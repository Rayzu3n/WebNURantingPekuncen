import React from 'react';
import { useApp } from '../context/AppContext';
import { PublicLayout } from '../components/layout/PublicLayout';
import { CheckCircle2, XCircle } from 'lucide-react';

interface MemberVerifyPageProps {
  memberNumber: string;
}

export const MemberVerifyPage: React.FC<MemberVerifyPageProps> = ({ memberNumber }) => {
  const { members, navigate } = useApp();

  const member = members.find(
    m => m.member_number.toLowerCase() === memberNumber.toLowerCase()
  );

  return (
    <PublicLayout>
      <div className="py-12 sm:py-16">
        <div className="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
          <div className="mb-8 text-center">
            <div className="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-400">
              <CheckCircle2 className="h-7 w-7" />
            </div>

            <p className="mt-4 text-sm font-semibold uppercase tracking-[0.16em] text-green-700 dark:text-green-400">
              Membership Verification
            </p>

            <h1 className="mt-2 font-editorial text-3xl font-semibold tracking-tight text-[#15201B] dark:text-white">
              Verifikasi Anggota NU
            </h1>

            <p className="mt-2 text-sm text-[#68736E] dark:text-[#9DAAA2]">
              Informasi keabsahan data keanggotaan berdasarkan nomor anggota yang terdaftar.
            </p>
          </div>

          {member ? (
            <div className="overflow-hidden rounded-2xl border border-[#CFD0C3] bg-white shadow-lg shadow-gray-300/40 dark:border-[#2b312d] dark:bg-[#181c1a] dark:shadow-black/20">
              <div className="p-6 sm:p-8">
                <div className="text-center">
                  {member.photo ? (
                    <img
                      src={member.photo}
                      alt={member.user?.name || 'Foto Anggota'}
                      className="mx-auto h-24 w-24 rounded-2xl object-cover border-2 border-green-500 shadow-sm"
                    />
                  ) : (
                    <div className="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-green-50 text-2xl font-bold text-green-700 dark:bg-green-500/10 dark:text-green-400">
                      {((member.user?.name || 'A')[0]).toUpperCase()}
                    </div>
                  )}

                  <h2 className="mt-5 text-2xl font-semibold text-[#15201B] dark:text-white">
                    {member.user?.name}
                  </h2>

                  <p className="mt-1 text-sm font-medium text-gray-500 dark:text-gray-400">
                    {member.member_number}
                  </p>
                </div>

                <div className="mt-6 flex justify-center">
                  {member.status === 'active' ? (
                    <span className="inline-flex items-center gap-2 rounded-full bg-green-50 px-3.5 py-1.5 text-xs font-semibold text-green-700 dark:bg-green-500/10 dark:text-green-400 border border-green-200 dark:border-green-800">
                      <span className="h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
                      Anggota Aktif (Active Member)
                    </span>
                  ) : (
                    <span className="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3.5 py-1.5 text-xs font-semibold text-gray-700 dark:bg-gray-700/50 dark:text-gray-300">
                      <span className="h-2 w-2 rounded-full bg-gray-500"></span>
                      Anggota Tidak Aktif
                    </span>
                  )}
                </div>

                <div className="mt-8 border-t border-gray-200 pt-6 dark:border-gray-800 space-y-3">
                  <div className="flex justify-between text-sm py-1 border-b border-gray-100 dark:border-gray-800/60">
                    <span className="text-gray-500 dark:text-gray-400">Tempat, Tanggal Lahir</span>
                    <span className="font-medium text-gray-900 dark:text-gray-200">
                      {member.birth_place}, {member.birth_date}
                    </span>
                  </div>
                  <div className="flex justify-between text-sm py-1 border-b border-gray-100 dark:border-gray-800/60">
                    <span className="text-gray-500 dark:text-gray-400">Ranting / Wilayah</span>
                    <span className="font-medium text-gray-900 dark:text-gray-200">
                      PRNU Desa Pekuncen
                    </span>
                  </div>
                  <div className="flex justify-between text-sm py-1">
                    <span className="text-gray-500 dark:text-gray-400">Status Verifikasi</span>
                    <span className="font-medium text-green-600 dark:text-green-400 flex items-center gap-1">
                      <CheckCircle2 className="h-4 w-4" /> Terverifikasi Resmi
                    </span>
                  </div>
                </div>
              </div>

              <div className="border-t border-gray-200 bg-gray-50/70 px-6 py-4 text-center dark:border-gray-800 dark:bg-gray-900/40">
                <p className="text-xs text-gray-500 dark:text-gray-400">
                  Hanya informasi yang diperlukan untuk verifikasi keanggotaan publik yang ditampilkan.
                </p>
              </div>
            </div>
          ) : (
            <div className="overflow-hidden rounded-2xl border border-red-200 bg-white p-8 text-center shadow-lg dark:border-red-900 dark:bg-[#181c1a]">
              <div className="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-red-50 text-red-600 dark:bg-red-500/10 dark:text-red-400">
                <XCircle className="h-7 w-7" />
              </div>
              <h2 className="mt-4 text-xl font-semibold text-gray-900 dark:text-white">
                Nomor Anggota Tidak Ditemukan
              </h2>
              <p className="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Nomor anggota "{memberNumber}" belum terdaftar atau telah dinonaktifkan dalam sistem basis data PRNU Pekuncen.
              </p>
              <button
                type="button"
                onClick={() => navigate('/')}
                className="mt-6 inline-flex items-center px-4 py-2 rounded-lg bg-[#1C775A] text-white text-sm font-semibold hover:bg-[#155A44] transition"
              >
                Kembali ke Beranda
              </button>
            </div>
          )}
        </div>
      </div>
    </PublicLayout>
  );
};
