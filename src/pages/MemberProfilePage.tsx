import React, { useState } from 'react';
import { useApp } from '../context/AppContext';
import { AppLayout } from '../components/layout/AppLayout';
import { CheckCircle2, AlertCircle } from 'lucide-react';

export const MemberProfilePage: React.FC = () => {
  const { currentMember, updateMemberProfile } = useApp();

  const [nik, setNik] = useState(currentMember?.nik || '');
  const [phone, setPhone] = useState(currentMember?.phone || '');
  const [birthPlace, setBirthPlace] = useState(currentMember?.birth_place || '');
  const [birthDate, setBirthDate] = useState(currentMember?.birth_date || '');
  const [gender, setGender] = useState<'L' | 'P'>(currentMember?.gender || 'L');
  const [address, setAddress] = useState(currentMember?.address || '');
  const [photo, setPhoto] = useState(currentMember?.photo || '');

  const [notification, setNotification] = useState<{ type: 'success' | 'error'; message: string } | null>(null);

  const handlePhotoUpload = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      if (file.size > 2 * 1024 * 1024) {
        setNotification({ type: 'error', message: 'Ukuran foto maksimal 2 MB.' });
        return;
      }
      const reader = new FileReader();
      reader.onloadend = () => {
        setPhoto(reader.result as string);
      };
      reader.readAsDataURL(file);
    }
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (!currentMember) return;

    const res = updateMemberProfile({
      nik,
      phone,
      birth_place: birthPlace,
      birth_date: birthDate,
      gender,
      address,
      photo,
    });

    if (res.success) {
      setNotification({ type: 'success', message: 'Profil anggota berhasil diperbarui.' });
    } else {
      setNotification({ type: 'error', message: res.message || 'Gagal memperbarui profil.' });
    }
  };

  return (
    <AppLayout title="Member Profile" subtitle="View and update your membership information.">
      <div className="mx-auto max-w-4xl">
        {notification && (
          <div
            className={`mb-6 flex items-start gap-3 rounded-xl border p-4 text-sm shadow-sm ${
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

        <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-lg shadow-gray-300/40 dark:border-gray-800 dark:bg-[#111827] dark:shadow-black/20">
          {/* Profile Header */}
          <div className="border-b border-gray-200 bg-gray-50/70 px-6 py-6 dark:border-gray-800 dark:bg-gray-900/40 sm:px-8">
            <div className="flex items-center gap-4">
              {photo ? (
                <img
                  src={photo}
                  alt={currentMember?.user?.name || 'Photo'}
                  className="h-16 w-16 rounded-2xl object-cover border border-gray-200 shadow-sm dark:border-gray-700"
                />
              ) : (
                <div className="flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-xl font-bold text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                  {((currentMember?.user?.name || 'A')[0]).toUpperCase()}
                </div>
              )}

              <div className="min-w-0">
                <h1 className="truncate text-lg font-semibold text-gray-900 dark:text-white">
                  {currentMember?.user?.name}
                </h1>
                <p className="mt-1 text-sm text-gray-500 dark:text-gray-400">
                  Member Number:{' '}
                  <span className="font-semibold text-gray-700 dark:text-gray-300 font-mono">
                    {currentMember?.member_number}
                  </span>
                </p>
              </div>
            </div>
          </div>

          <form onSubmit={handleSubmit}>
            <div className="space-y-8 px-6 py-6 sm:px-8 sm:py-8">
              {/* Photo Section */}
              <section>
                <div className="mb-5">
                  <h2 className="text-sm font-semibold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                    Profile Photo
                  </h2>
                </div>

                {photo && (
                  <div className="mb-4 rounded-xl border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/50 inline-block">
                    <img
                      src={photo}
                      alt="Preview"
                      className="h-36 w-36 rounded-xl object-cover border border-gray-200 shadow-sm dark:border-gray-700"
                    />
                  </div>
                )}

                <div className="rounded-xl border border-dashed border-gray-300 bg-gray-50 p-5 dark:border-gray-700 dark:bg-gray-900/50">
                  <input
                    id="photo"
                    type="file"
                    accept=".jpg,.jpeg,.png,.webp"
                    onChange={handlePhotoUpload}
                    className="block w-full text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100 dark:text-gray-400 dark:file:bg-blue-500/10 dark:file:text-blue-400 dark:hover:file:bg-blue-500/20 cursor-pointer"
                  />
                  <p className="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    JPG, JPEG, PNG, or WebP. Maksimal 2 MB.
                  </p>
                </div>
              </section>

              {/* Identity Section */}
              <section>
                <div className="mb-5">
                  <h2 className="text-sm font-semibold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                    Identity
                  </h2>
                </div>

                <div className="grid gap-6 md:grid-cols-2">
                  <div>
                    <label htmlFor="nik" className="block text-sm font-medium text-gray-700 dark:text-gray-300">
                      NIK
                    </label>
                    <input
                      id="nik"
                      type="text"
                      required
                      value={nik}
                      onChange={e => setNik(e.target.value)}
                      className="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                    />
                  </div>

                  <div>
                    <label htmlFor="phone" className="block text-sm font-medium text-gray-700 dark:text-gray-300">
                      Nomor HP / WhatsApp
                    </label>
                    <input
                      id="phone"
                      type="text"
                      value={phone}
                      onChange={e => setPhone(e.target.value)}
                      className="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                    />
                  </div>

                  <div>
                    <label htmlFor="birth_place" className="block text-sm font-medium text-gray-700 dark:text-gray-300">
                      Tempat Lahir
                    </label>
                    <input
                      id="birth_place"
                      type="text"
                      required
                      value={birthPlace}
                      onChange={e => setBirthPlace(e.target.value)}
                      className="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                    />
                  </div>

                  <div>
                    <label htmlFor="birth_date" className="block text-sm font-medium text-gray-700 dark:text-gray-300">
                      Tanggal Lahir
                    </label>
                    <input
                      id="birth_date"
                      type="date"
                      required
                      value={birthDate}
                      onChange={e => setBirthDate(e.target.value)}
                      className="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                    />
                  </div>

                  <div>
                    <label htmlFor="gender" className="block text-sm font-medium text-gray-700 dark:text-gray-300">
                      Jenis Kelamin
                    </label>
                    <select
                      id="gender"
                      value={gender}
                      onChange={e => setGender(e.target.value as 'L' | 'P')}
                      className="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                    >
                      <option value="L">Laki-laki</option>
                      <option value="P">Perempuan</option>
                    </select>
                  </div>
                </div>
              </section>

              {/* Address Section */}
              <section>
                <div className="mb-5">
                  <h2 className="text-sm font-semibold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                    Address
                  </h2>
                </div>

                <textarea
                  id="address"
                  rows={4}
                  required
                  value={address}
                  onChange={e => setAddress(e.target.value)}
                  className="block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm leading-6 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                />
              </section>
            </div>

            {/* Footer Submit */}
            <div className="flex justify-end border-t border-gray-200 bg-gray-50/70 px-6 py-5 dark:border-gray-800 dark:bg-gray-900/40 sm:px-8">
              <button
                type="submit"
                className="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-200/40 hover:bg-blue-700 dark:bg-blue-500 dark:shadow-blue-950/20 dark:hover:bg-blue-600 transition"
              >
                Simpan Perubahan
              </button>
            </div>
          </form>
        </div>
      </div>
    </AppLayout>
  );
};
