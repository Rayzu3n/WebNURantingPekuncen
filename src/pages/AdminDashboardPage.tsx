import React from 'react';
import { useApp } from '../context/AppContext';
import { AppLayout } from '../components/layout/AppLayout';
import { FileText, Users, FolderKanban } from 'lucide-react';

export const AdminDashboardPage: React.FC = () => {
  const { currentUser, news, members, categories, navigate } = useApp();

  return (
    <AppLayout title="Admin Dashboard" subtitle="Manage portal content and members.">
      <div className="space-y-8">
        {/* Welcome Section */}
        <section>
          <div className="overflow-hidden rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-600 via-blue-700 to-cyan-700 px-6 py-7 text-white shadow-lg shadow-blue-200/50 dark:border-blue-400/10 dark:from-[#172554] dark:via-[#172554] dark:to-[#164E63] dark:shadow-black/30 sm:px-8">
            <p className="text-sm font-medium text-blue-100">Welcome back</p>
            <h1 className="mt-2 text-2xl font-semibold tracking-tight">
              {currentUser?.name}
            </h1>
            <p className="mt-2 max-w-2xl text-sm leading-6 text-blue-100">
              Kelola berita portal, kategori publikasi, dan keanggotaan warga NU Ranting Pekuncen dari panel kendali ini.
            </p>
          </div>
        </section>

        {/* Statistics Cards */}
        <section>
          <div className="grid gap-5 md:grid-cols-3">
            {/* Total News */}
            <div className="rounded-2xl border border-gray-200 bg-white p-6 shadow-lg shadow-gray-300/40 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xl dark:border-gray-800 dark:bg-[#111827] dark:shadow-black/20">
              <div className="flex items-start justify-between">
                <div>
                  <p className="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Total Berita
                  </p>
                  <p className="mt-3 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                    {news.length}
                  </p>
                </div>
                <div className="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                  <FileText className="h-5 w-5" />
                </div>
              </div>
              <button
                type="button"
                onClick={() => navigate('/admin/news')}
                className="mt-5 inline-flex items-center text-sm font-semibold text-blue-600 transition-colors hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
              >
                Kelola Berita <span className="ml-1">→</span>
              </button>
            </div>

            {/* Total Members */}
            <div className="rounded-2xl border border-gray-200 bg-white p-6 shadow-lg shadow-gray-300/40 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xl dark:border-gray-800 dark:bg-[#111827] dark:shadow-black/20">
              <div className="flex items-start justify-between">
                <div>
                  <p className="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Total Anggota
                  </p>
                  <p className="mt-3 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                    {members.length}
                  </p>
                </div>
                <div className="flex h-11 w-11 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 dark:bg-cyan-500/10 dark:text-cyan-400">
                  <Users className="h-5 w-5" />
                </div>
              </div>
              <button
                type="button"
                onClick={() => navigate('/admin/members')}
                className="mt-5 inline-flex items-center text-sm font-semibold text-cyan-600 transition-colors hover:text-cyan-700 dark:text-cyan-400 dark:hover:text-cyan-300"
              >
                Kelola Anggota <span className="ml-1">→</span>
              </button>
            </div>

            {/* Total Categories */}
            <div className="rounded-2xl border border-gray-200 bg-white p-6 shadow-lg shadow-gray-300/40 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xl dark:border-gray-800 dark:bg-[#111827] dark:shadow-black/20">
              <div className="flex items-start justify-between">
                <div>
                  <p className="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Kategori Berita
                  </p>
                  <p className="mt-3 text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                    {categories.length}
                  </p>
                </div>
                <div className="flex h-11 w-11 items-center justify-center rounded-xl bg-sky-50 text-sky-600 dark:bg-sky-500/10 dark:text-sky-400">
                  <FolderKanban className="h-5 w-5" />
                </div>
              </div>
              <button
                type="button"
                onClick={() => navigate('/admin/categories')}
                className="mt-5 inline-flex items-center text-sm font-semibold text-sky-600 transition-colors hover:text-sky-700 dark:text-sky-400 dark:hover:text-sky-300"
              >
                Kelola Kategori <span className="ml-1">→</span>
              </button>
            </div>
          </div>
        </section>

        {/* Management Section */}
        <section>
          <div className="mb-4">
            <h2 className="text-lg font-semibold text-gray-900 dark:text-white">
              Menu Utama Manajemen
            </h2>
            <p className="mt-1 text-sm text-gray-500 dark:text-gray-400">
              Akses cepat menu pengelolaan utama.
            </p>
          </div>

          <div className="grid gap-5 md:grid-cols-3">
            <div
              onClick={() => navigate('/admin/news')}
              className="group cursor-pointer rounded-2xl border border-gray-200 bg-white p-6 shadow-lg shadow-gray-300/40 transition-all duration-200 hover:-translate-y-1 hover:border-blue-200 hover:shadow-xl dark:border-gray-800 dark:bg-[#111827] dark:shadow-black/20 dark:hover:border-blue-500/30"
            >
              <div className="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 transition-colors group-hover:bg-blue-600 group-hover:text-white dark:bg-blue-500/10 dark:text-blue-400 dark:group-hover:bg-blue-500 dark:group-hover:text-white">
                <FileText className="h-5 w-5" />
              </div>
              <h3 className="mt-5 font-semibold text-gray-900 dark:text-white">
                Berita (News)
              </h3>
              <p className="mt-2 text-sm leading-6 text-gray-500 dark:text-gray-400">
                Tulis artikel baru, edit berita, unggah thumbnail, dan atur status publikasi.
              </p>
              <span className="mt-4 inline-block text-sm font-semibold text-blue-600 dark:text-blue-400">
                Buka Berita →
              </span>
            </div>

            <div
              onClick={() => navigate('/admin/categories')}
              className="group cursor-pointer rounded-2xl border border-gray-200 bg-white p-6 shadow-lg shadow-gray-300/40 transition-all duration-200 hover:-translate-y-1 hover:border-sky-200 hover:shadow-xl dark:border-gray-800 dark:bg-[#111827] dark:shadow-black/20 dark:hover:border-sky-500/30"
            >
              <div className="flex h-11 w-11 items-center justify-center rounded-xl bg-sky-50 text-sky-600 transition-colors group-hover:bg-sky-600 group-hover:text-white dark:bg-sky-500/10 dark:text-sky-400 dark:group-hover:bg-sky-500 dark:group-hover:text-white">
                <FolderKanban className="h-5 w-5" />
              </div>
              <h3 className="mt-5 font-semibold text-gray-900 dark:text-white">
                Kategori (Categories)
              </h3>
              <p className="mt-2 text-sm leading-6 text-gray-500 dark:text-gray-400">
                Kelola taksonomi dan pengelompokan rubrik berita di portal NU.
              </p>
              <span className="mt-4 inline-block text-sm font-semibold text-sky-600 dark:text-sky-400">
                Buka Kategori →
              </span>
            </div>

            <div
              onClick={() => navigate('/admin/members')}
              className="group cursor-pointer rounded-2xl border border-gray-200 bg-white p-6 shadow-lg shadow-gray-300/40 transition-all duration-200 hover:-translate-y-1 hover:border-cyan-200 hover:shadow-xl dark:border-gray-800 dark:bg-[#111827] dark:shadow-black/20 dark:hover:border-cyan-500/30"
            >
              <div className="flex h-11 w-11 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 transition-colors group-hover:bg-cyan-600 group-hover:text-white dark:bg-cyan-500/10 dark:text-cyan-400 dark:group-hover:bg-cyan-500 dark:group-hover:text-white">
                <Users className="h-5 w-5" />
              </div>
              <h3 className="mt-5 font-semibold text-gray-900 dark:text-white">
                Anggota (Members)
              </h3>
              <p className="mt-2 text-sm leading-6 text-gray-500 dark:text-gray-400">
                Daftar anggota ranting, verifikasi status KARTANU, edit biodata dan foto.
              </p>
              <span className="mt-4 inline-block text-sm font-semibold text-cyan-600 dark:text-cyan-400">
                Buka Anggota →
              </span>
            </div>
          </div>
        </section>
      </div>
    </AppLayout>
  );
};
