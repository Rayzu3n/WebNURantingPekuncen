import React from 'react';
import { useApp } from '../context/AppContext';
import { AppLayout } from '../components/layout/AppLayout';
import { User as UserIcon, CreditCard, ShieldCheck } from 'lucide-react';

export const MemberDashboardPage: React.FC = () => {
  const { currentUser, currentMember, navigate } = useApp();

  return (
    <AppLayout title="Member Dashboard" subtitle="Access your member profile and digital member card.">
      <div className="space-y-6">
        {/* Welcome Banner */}
        <section className="overflow-hidden rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-600 via-blue-700 to-cyan-700 px-6 py-7 text-white shadow-lg shadow-blue-200/50 dark:border-blue-400/10 dark:from-[#172554] dark:via-[#172554] dark:to-[#164E63] dark:shadow-black/30 sm:px-8">
          <p className="text-sm font-medium text-blue-100">Selamat datang kembali,</p>
          <h1 className="mt-2 text-2xl font-semibold tracking-tight">
            {currentUser?.name}
          </h1>
          <p className="mt-2 max-w-2xl text-sm leading-6 text-blue-100">
            Kelola data diri keanggotaan NU Ranting Pekuncen Anda dan dapatkan Kartu Tanda Anggota digital resmi dengan QR code terverifikasi.
          </p>
          {currentMember && (
            <div className="mt-4 inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-lg text-xs font-semibold">
              <ShieldCheck className="h-4 w-4" />
              Nomor Anggota: {currentMember.member_number} ({currentMember.status === 'active' ? 'Aktif' : 'Tidak Aktif'})
            </div>
          )}
        </section>

        {/* Member Actions */}
        <section>
          <div className="mb-4">
            <h2 className="text-lg font-semibold text-gray-900 dark:text-white">
              Area Anggota
            </h2>
            <p className="mt-1 text-sm text-gray-500 dark:text-gray-400">
              Menu pengelolaan keanggotaan Anda.
            </p>
          </div>

          <div className="grid gap-5 md:grid-cols-2">
            {/* Profile Action Card */}
            <div
              onClick={() => navigate('/member/profile')}
              className="group cursor-pointer rounded-2xl border border-gray-200 bg-white p-6 shadow-lg shadow-gray-300/40 transition-all duration-200 hover:-translate-y-1 hover:border-blue-200 hover:shadow-xl dark:border-gray-800 dark:bg-[#111827] dark:shadow-black/20 dark:hover:border-blue-500/30"
            >
              <div className="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 transition-colors group-hover:bg-blue-600 group-hover:text-white dark:bg-blue-500/10 dark:text-blue-400 dark:group-hover:bg-blue-500 dark:group-hover:text-white">
                <UserIcon className="h-5 w-5" />
              </div>

              <h3 className="mt-5 font-semibold text-gray-900 dark:text-white">
                Member Profile
              </h3>

              <p className="mt-2 text-sm leading-6 text-gray-500 dark:text-gray-400">
                Lihat dan perbarui data profil diri, foto identitas, nomor telepon, dan domisili.
              </p>

              <span className="mt-4 inline-block text-sm font-semibold text-blue-600 dark:text-blue-400">
                Buka profil →
              </span>
            </div>

            {/* Member Card Action Card */}
            <div
              onClick={() => navigate('/member/card')}
              className="group cursor-pointer rounded-2xl border border-gray-200 bg-white p-6 shadow-lg shadow-gray-300/40 transition-all duration-200 hover:-translate-y-1 hover:border-cyan-200 hover:shadow-xl dark:border-gray-800 dark:bg-[#111827] dark:shadow-black/20 dark:hover:border-cyan-500/30"
            >
              <div className="flex h-11 w-11 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 transition-colors group-hover:bg-cyan-600 group-hover:text-white dark:bg-cyan-500/10 dark:text-cyan-400 dark:group-hover:bg-cyan-500 dark:group-hover:text-white">
                <CreditCard className="h-5 w-5" />
              </div>

              <h3 className="mt-5 font-semibold text-gray-900 dark:text-white">
                Digital Member Card
              </h3>

              <p className="mt-2 text-sm leading-6 text-gray-500 dark:text-gray-400">
                Lihat kartu anggota digital resmi Anda dan unduh dalam format resolusi tinggi (PNG/JPG).
              </p>

              <span className="mt-4 inline-block text-sm font-semibold text-cyan-600 dark:text-cyan-400">
                Buka kartu anggota →
              </span>
            </div>
          </div>
        </section>
      </div>
    </AppLayout>
  );
};
