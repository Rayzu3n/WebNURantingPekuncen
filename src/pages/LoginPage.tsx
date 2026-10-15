import React, { useState } from 'react';
import { useApp } from '../context/AppContext';
import { ShieldCheck, UserCheck, ArrowLeft, AlertCircle } from 'lucide-react';

export const LoginPage: React.FC = () => {
  const { login, navigate } = useApp();
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState<string | null>(null);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    const res = login(email, password);
    if (!res.success) {
      setError(res.message || 'Login gagal. Silakan periksa kembali email dan password Anda.');
    }
  };

  const handleQuickLogin = (demoEmail: string) => {
    const res = login(demoEmail, 'password');
    if (!res.success) {
      setError(res.message || 'Login gagal.');
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
            Masuk ke Portal NU Pekuncen
          </h2>
          <p className="mt-2 text-center text-xs text-gray-500 dark:text-gray-400">
            Sistem Informasi Pengurus Ranting & KARTANU Digital
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
                Alamat Email
              </label>
              <input
                type="email"
                required
                value={email}
                onChange={e => setEmail(e.target.value)}
                placeholder="nama@nu-pekuncen.org"
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
                value={password}
                onChange={e => setPassword(e.target.value)}
                placeholder="••••••••"
                className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-[#1C775A]"
              />
            </div>

            <div className="flex items-center justify-between text-xs">
              <label className="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                <input
                  type="checkbox"
                  defaultChecked
                  className="rounded border-gray-300 text-[#1C775A] focus:ring-[#1C775A]"
                />
                Ingat saya
              </label>
              <button
                type="button"
                onClick={() => alert('Fitur reset password demo: silakan gunakan akun yang sudah ada.')}
                className="text-[#1C775A] dark:text-[#2ec486] hover:underline"
              >
                Lupa sandi?
              </button>
            </div>

            <button
              type="submit"
              className="w-full rounded-xl bg-[#1C775A] py-2.5 text-sm font-semibold text-white shadow-md hover:bg-[#155A44] transition"
            >
              Masuk (Log In)
            </button>
          </form>

          {/* Quick Demo Logins for AI Studio Evaluation */}
          <div className="mt-6 pt-6 border-t border-gray-200 dark:border-gray-800">
            <p className="text-center text-xs font-semibold uppercase tracking-wider text-gray-400 mb-3">
              Akses Cepat Mode Demo
            </p>
            <div className="space-y-2">
              <button
                type="button"
                onClick={() => handleQuickLogin('admin@nu-pekuncen.org')}
                className="w-full flex items-center justify-between p-2.5 text-xs font-medium rounded-xl border border-green-200 bg-green-50 text-green-900 hover:bg-green-100 dark:bg-green-950/40 dark:border-green-800 dark:text-green-300 transition"
              >
                <span className="flex items-center gap-1.5 font-semibold">
                  <ShieldCheck className="h-4 w-4 text-[#1C775A]" /> Masuk sebagai Admin
                </span>
                <span className="text-[10px] text-green-700 dark:text-green-400">admin@nu-pekuncen.org</span>
              </button>

              <button
                type="button"
                onClick={() => handleQuickLogin('member@nu-pekuncen.org')}
                className="w-full flex items-center justify-between p-2.5 text-xs font-medium rounded-xl border border-blue-200 bg-blue-50 text-blue-900 hover:bg-blue-100 dark:bg-blue-950/40 dark:border-blue-800 dark:text-blue-300 transition"
              >
                <span className="flex items-center gap-1.5 font-semibold">
                  <UserCheck className="h-4 w-4 text-blue-600" /> Masuk sebagai Anggota
                </span>
                <span className="text-[10px] text-blue-700 dark:text-blue-400">member@nu-pekuncen.org</span>
              </button>
            </div>
          </div>

          <div className="mt-6 text-center text-xs text-gray-500">
            Belum punya akun?{' '}
            <button
              type="button"
              onClick={() => navigate('/register')}
              className="font-semibold text-[#1C775A] dark:text-[#2ec486] hover:underline"
            >
              Daftar Sekarang
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};
