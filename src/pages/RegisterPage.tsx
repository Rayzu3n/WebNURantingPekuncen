import React, { useState } from 'react';
import { useApp } from '../context/AppContext';
import { ArrowLeft, AlertCircle } from 'lucide-react';

export const RegisterPage: React.FC = () => {
  const { register, navigate } = useApp();
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [error, setError] = useState<string | null>(null);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (password !== confirmPassword) {
      setError('Konfirmasi kata sandi tidak cocok.');
      return;
    }
    const res = register(name, email, password);
    if (!res.success) {
      setError(res.message || 'Registrasi gagal.');
    }
  };

  return (
    <div className="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-gray-50 dark:bg-[#101412] text-gray-900 dark:text-[#e0e3df]">
      <div className="sm:mx-auto sm:w-full sm:max-w-md">
        <button
          type="button"
          onClick={() => navigate('/')}
          className="mx-auto flex items-center gap-1.5 text-xs font-semibold text-[#1C775A] dark:text-[#2ec486] hover:underline mb-4"
        >
          <ArrowLeft className="h-3.5 w-3.5" /> Kembali ke Portal Berita
        </button>

        <div className="text-center">
          <div className="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-[#1C775A] text-white font-bold text-xl shadow-md">
            NU
          </div>
          <h2 className="mt-4 text-center text-2xl font-bold tracking-tight font-editorial sm:text-3xl">
            Pendaftaran Anggota NU
          </h2>
          <p className="mt-2 text-center text-xs text-gray-500 dark:text-gray-400">
            Daftarkan diri Anda untuk mendapatkan nomor anggota KARTANU Pekuncen
          </p>
        </div>
      </div>

      <div className="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4">
        <div className="bg-white dark:bg-[#181c1a] py-8 px-6 shadow-xl rounded-2xl sm:px-10 border border-gray-200 dark:border-gray-800">
          {error && (
            <div className="mb-4 flex items-center gap-2 p-3 text-xs rounded-xl bg-red-50 text-red-700 border border-red-200 dark:bg-red-950/30 dark:border-red-900 dark:text-red-300">
              <AlertCircle className="h-4 w-4 shrink-0" />
              <span>{error}</span>
            </div>
          )}

          <form className="space-y-4" onSubmit={handleSubmit}>
            <div>
              <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                Nama Lengkap
              </label>
              <input
                type="text"
                required
                value={name}
                onChange={e => setName(e.target.value)}
                placeholder="Contoh: Muhammad Ali"
                className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-[#1C775A]"
              />
            </div>

            <div>
              <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                Alamat Email
              </label>
              <input
                type="email"
                required
                value={email}
                onChange={e => setEmail(e.target.value)}
                placeholder="nama@email.com"
                className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-[#1C775A]"
              />
            </div>

            <div>
              <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                Kata Sandi
              </label>
              <input
                type="password"
                required
                minLength={8}
                value={password}
                onChange={e => setPassword(e.target.value)}
                placeholder="Minimal 8 karakter"
                className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-[#1C775A]"
              />
            </div>

            <div>
              <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                Konfirmasi Kata Sandi
              </label>
              <input
                type="password"
                required
                minLength={8}
                value={confirmPassword}
                onChange={e => setConfirmPassword(e.target.value)}
                placeholder="Ulangi kata sandi"
                className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-[#1C775A]"
              />
            </div>

            <button
              type="submit"
              className="w-full rounded-xl bg-[#1C775A] py-2.5 text-sm font-semibold text-white shadow-md hover:bg-[#155A44] transition mt-2"
            >
              Daftar Sebagai Anggota
            </button>
          </form>

          <div className="mt-6 text-center text-xs text-gray-500">
            Sudah memiliki akun?{' '}
            <button
              type="button"
              onClick={() => navigate('/login')}
              className="font-semibold text-[#1C775A] dark:text-[#2ec486] hover:underline"
            >
              Masuk di sini
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};
