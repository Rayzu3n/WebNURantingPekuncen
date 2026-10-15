import React, { useState } from 'react';
import { useApp } from '../context/AppContext';
import { AppLayout } from '../components/layout/AppLayout';
import { Member } from '../types';
import { Plus, Edit, Trash2, ExternalLink, X, CheckCircle2, AlertCircle, QrCode } from 'lucide-react';

export const AdminMembersPage: React.FC = () => {
  const { members, createMember, updateMember, deleteMember, navigate } = useApp();

  const [isModalOpen, setIsModalOpen] = useState(false);
  const [editingMember, setEditingMember] = useState<Member | null>(null);

  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [memberNumber, setMemberNumber] = useState('');
  const [nik, setNik] = useState('');
  const [birthPlace, setBirthPlace] = useState('');
  const [birthDate, setBirthDate] = useState('');
  const [gender, setGender] = useState<'L' | 'P'>('L');
  const [phone, setPhone] = useState('');
  const [address, setAddress] = useState('');
  const [status, setStatus] = useState<'active' | 'inactive'>('active');
  const [photo, setPhoto] = useState('');
  const [notification, setNotification] = useState<{ type: 'success' | 'error'; message: string } | null>(null);

  const openCreateModal = () => {
    setEditingMember(null);
    setName('');
    setEmail('');
    setMemberNumber(`NU-PKC-2026-${String(members.length + 1).padStart(3, '0')}`);
    setNik(`330214${Math.floor(1000000000 + Math.random() * 9000000000)}`);
    setBirthPlace('Banyumas');
    setBirthDate('1990-01-01');
    setGender('L');
    setPhone('');
    setAddress('Desa Pekuncen, Kec. Pekuncen, Kab. Banyumas');
    setStatus('active');
    setPhoto('');
    setIsModalOpen(true);
  };

  const openEditModal = (m: Member) => {
    setEditingMember(m);
    setName(m.user?.name || '');
    setEmail(m.user?.email || '');
    setMemberNumber(m.member_number);
    setNik(m.nik);
    setBirthPlace(m.birth_place);
    setBirthDate(m.birth_date);
    setGender(m.gender);
    setPhone(m.phone || '');
    setAddress(m.address);
    setStatus(m.status);
    setPhoto(m.photo || '');
    setIsModalOpen(true);
  };

  const handlePhotoUpload = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      const reader = new FileReader();
      reader.onloadend = () => {
        setPhoto(reader.result as string);
      };
      reader.readAsDataURL(file);
    }
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (!name.trim() || !email.trim() || !memberNumber.trim() || !nik.trim() || !birthPlace.trim() || !birthDate || !address.trim()) {
      setNotification({ type: 'error', message: 'Semua field wajib diisi lengkap.' });
      return;
    }

    if (editingMember) {
      const res = updateMember(editingMember.id, {
        name,
        email,
        member_number: memberNumber,
        nik,
        birth_place: birthPlace,
        birth_date: birthDate,
        gender,
        phone,
        address,
        status,
        photo,
      });
      if (res.success) {
        setNotification({ type: 'success', message: 'Data anggota berhasil diperbarui.' });
        setIsModalOpen(false);
      } else {
        setNotification({ type: 'error', message: res.message || 'Gagal memperbarui anggota.' });
      }
    } else {
      const res = createMember({
        name,
        email,
        member_number: memberNumber,
        nik,
        birth_place: birthPlace,
        birth_date: birthDate,
        gender,
        phone,
        address,
        status,
        photo,
      });
      if (res.success) {
        setNotification({ type: 'success', message: 'Anggota baru berhasil didaftarkan.' });
        setIsModalOpen(false);
      } else {
        setNotification({ type: 'error', message: res.message || 'Gagal mendaftarkan anggota.' });
      }
    }
  };

  const handleDelete = (id: number, memberName: string) => {
    if (window.confirm(`Hapus anggota "${memberName}" beserta akun aksesnya?`)) {
      const res = deleteMember(id);
      if (res.success) {
        setNotification({ type: 'success', message: 'Anggota berhasil dihapus.' });
      }
    }
  };

  return (
    <AppLayout title="Kelola Anggota" subtitle="Pendaftaran dan manajemen keanggotaan warga NU Ranting Pekuncen.">
      <div className="space-y-6">
        {notification && (
          <div
            className={`flex items-start gap-3 rounded-xl border p-4 text-sm shadow-sm ${
              notification.type === 'success'
                ? 'border-green-200 bg-green-50 text-green-800 dark:border-green-500/20 dark:bg-green-500/10 dark:text-green-300'
                : 'border-red-200 bg-red-50 text-red-800 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-300'
            }`}
          >
            {notification.type === 'success' ? (
              <CheckCircle2 className="mt-0.5 h-5 w-5 shrink-0" />
            ) : (
              <AlertCircle className="mt-0.5 h-5 w-5 shrink-0" />
            )}
            <span>{notification.message}</span>
          </div>
        )}

        <div className="flex justify-between items-center">
          <div>
            <h2 className="text-lg font-semibold text-gray-900 dark:text-white">
              Daftar Anggota Terdaftar ({members.length})
            </h2>
          </div>
          <button
            type="button"
            onClick={openCreateModal}
            className="inline-flex items-center gap-2 rounded-xl bg-[#1C775A] px-4 py-2.5 text-sm font-semibold text-white shadow hover:bg-[#155A44] transition"
          >
            <Plus className="h-4 w-4" />
            Tambah Anggota Baru
          </button>
        </div>

        {/* Member Table */}
        <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow dark:border-gray-800 dark:bg-[#111827]">
          <div className="overflow-x-auto">
            <table className="w-full text-left text-sm text-gray-600 dark:text-gray-300">
              <thead className="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-900/50 dark:text-gray-400">
                <tr>
                  <th scope="col" className="px-6 py-4">Foto</th>
                  <th scope="col" className="px-6 py-4">Nama & Email</th>
                  <th scope="col" className="px-6 py-4">No. Anggota / NIK</th>
                  <th scope="col" className="px-6 py-4">L/P</th>
                  <th scope="col" className="px-6 py-4">Kontak</th>
                  <th scope="col" className="px-6 py-4">Status</th>
                  <th scope="col" className="px-6 py-4 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-gray-200 dark:divide-gray-800">
                {members.map(item => (
                  <tr key={item.id} className="hover:bg-gray-50/50 dark:hover:bg-gray-800/40">
                    <td className="px-6 py-4">
                      {item.photo ? (
                        <img
                          src={item.photo}
                          alt=""
                          className="h-10 w-10 object-cover rounded-xl border border-gray-200 dark:border-gray-700"
                        />
                      ) : (
                        <div className="h-10 w-10 rounded-xl bg-green-50 text-green-700 flex items-center justify-center font-bold text-sm dark:bg-green-950 dark:text-green-300">
                          {((item.user?.name || 'A')[0]).toUpperCase()}
                        </div>
                      )}
                    </td>
                    <td className="px-6 py-4">
                      <div className="font-semibold text-gray-900 dark:text-white">
                        {item.user?.name}
                      </div>
                      <div className="text-xs text-gray-400">{item.user?.email}</div>
                    </td>
                    <td className="px-6 py-4 font-mono text-xs">
                      <div className="font-bold text-gray-800 dark:text-gray-200">
                        {item.member_number}
                      </div>
                      <div className="text-gray-400">{item.nik}</div>
                    </td>
                    <td className="px-6 py-4 text-xs font-semibold">
                      {item.gender === 'L' ? 'Laki-laki' : 'Perempuan'}
                    </td>
                    <td className="px-6 py-4 text-xs">
                      {item.phone || '-'}
                    </td>
                    <td className="px-6 py-4">
                      <span
                        className={`inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold ${
                          item.status === 'active'
                            ? 'bg-green-100 text-green-800 dark:bg-green-950/60 dark:text-green-300'
                            : 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300'
                        }`}
                      >
                        {item.status === 'active' ? 'Aktif' : 'Non-aktif'}
                      </span>
                    </td>
                    <td className="px-6 py-4 text-right space-x-2">
                      <button
                        type="button"
                        onClick={() => navigate(`/member/verify/${item.member_number}`)}
                        title="Verifikasi QR Publik"
                        className="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400"
                      >
                        <QrCode className="h-4 w-4 inline" />
                      </button>
                      <button
                        type="button"
                        onClick={() => openEditModal(item)}
                        title="Edit Anggota"
                        className="text-blue-600 hover:text-blue-800 dark:text-blue-400"
                      >
                        <Edit className="h-4 w-4 inline" />
                      </button>
                      <button
                        type="button"
                        onClick={() => handleDelete(item.id, item.user?.name || '')}
                        title="Hapus Anggota"
                        className="text-red-600 hover:text-red-800 dark:text-red-400"
                      >
                        <Trash2 className="h-4 w-4 inline" />
                      </button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>

        {/* Modal Form */}
        {isModalOpen && (
          <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto">
            <div className="relative w-full max-w-2xl bg-white rounded-2xl shadow-xl dark:bg-[#181c1a] border border-gray-200 dark:border-gray-800 my-8">
              <div className="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-800">
                <h3 className="text-lg font-semibold text-gray-900 dark:text-white">
                  {editingMember ? 'Edit Data Anggota' : 'Daftarkan Anggota Baru'}
                </h3>
                <button
                  type="button"
                  onClick={() => setIsModalOpen(false)}
                  className="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                >
                  <X className="h-5 w-5" />
                </button>
              </div>

              <form onSubmit={handleSubmit} className="p-6 space-y-4">
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                    <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                      Nama Lengkap
                    </label>
                    <input
                      type="text"
                      required
                      value={name}
                      onChange={e => setName(e.target.value)}
                      className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                      placeholder="Contoh: H. Ahmad Fauzi"
                    />
                  </div>

                  <div>
                    <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                      Email Akun
                    </label>
                    <input
                      type="email"
                      required
                      value={email}
                      onChange={e => setEmail(e.target.value)}
                      className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                      placeholder="nama@nu-pekuncen.org"
                    />
                  </div>
                </div>

                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                    <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                      Nomor Anggota (KARTANU)
                    </label>
                    <input
                      type="text"
                      required
                      value={memberNumber}
                      onChange={e => setMemberNumber(e.target.value)}
                      className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white font-mono text-xs"
                    />
                  </div>

                  <div>
                    <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                      NIK (16 Digit)
                    </label>
                    <input
                      type="text"
                      required
                      value={nik}
                      onChange={e => setNik(e.target.value)}
                      className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white font-mono text-xs"
                    />
                  </div>
                </div>

                <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
                  <div>
                    <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                      Tempat Lahir
                    </label>
                    <input
                      type="text"
                      required
                      value={birthPlace}
                      onChange={e => setBirthPlace(e.target.value)}
                      className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    />
                  </div>

                  <div>
                    <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                      Tanggal Lahir
                    </label>
                    <input
                      type="date"
                      required
                      value={birthDate}
                      onChange={e => setBirthDate(e.target.value)}
                      className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    />
                  </div>

                  <div>
                    <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                      Jenis Kelamin
                    </label>
                    <select
                      value={gender}
                      onChange={e => setGender(e.target.value as 'L' | 'P')}
                      className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    >
                      <option value="L">Laki-laki (L)</option>
                      <option value="P">Perempuan (P)</option>
                    </select>
                  </div>
                </div>

                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                    <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                      Nomor HP / WhatsApp
                    </label>
                    <input
                      type="text"
                      value={phone}
                      onChange={e => setPhone(e.target.value)}
                      className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                      placeholder="081234567890"
                    />
                  </div>

                  <div>
                    <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                      Status Keanggotaan
                    </label>
                    <select
                      value={status}
                      onChange={e => setStatus(e.target.value as 'active' | 'inactive')}
                      className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    >
                      <option value="active">Aktif (Active)</option>
                      <option value="inactive">Non-aktif (Inactive)</option>
                    </select>
                  </div>
                </div>

                <div>
                  <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                    Alamat Lengkap
                  </label>
                  <textarea
                    rows={2}
                    required
                    value={address}
                    onChange={e => setAddress(e.target.value)}
                    className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    placeholder="RT/RW, Dusun, Desa Pekuncen..."
                  />
                </div>

                <div>
                  <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                    Foto Profil Anggota
                  </label>
                  {photo && (
                    <img
                      src={photo}
                      alt="Preview"
                      className="h-16 w-16 rounded-xl object-cover border border-gray-200 mb-2"
                    />
                  )}
                  <input
                    type="file"
                    accept="image/*"
                    onChange={handlePhotoUpload}
                    className="text-xs text-gray-500 cursor-pointer"
                  />
                </div>

                <div className="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-800">
                  <button
                    type="button"
                    onClick={() => setIsModalOpen(false)}
                    className="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-gray-800 dark:text-gray-400"
                  >
                    Batal
                  </button>
                  <button
                    type="submit"
                    className="px-5 py-2 text-sm font-semibold text-white bg-[#1C775A] hover:bg-[#155A44] rounded-xl transition shadow"
                  >
                    {editingMember ? 'Simpan Perubahan' : 'Daftarkan Anggota'}
                  </button>
                </div>
              </form>
            </div>
          </div>
        )}
      </div>
    </AppLayout>
  );
};
