import React, { useState, useEffect, useRef } from 'react';
import { useApp } from '../context/AppContext';
import { AppLayout } from '../components/layout/AppLayout';
import QRCode from 'qrcode';
import html2canvas from 'html2canvas';
import { Download, AlertCircle, RefreshCw } from 'lucide-react';

export const MemberCardPage: React.FC = () => {
  const { currentMember, navigate } = useApp();
  const [qrCodeUrl, setQrCodeUrl] = useState<string>('');
  const [isExporting, setIsExporting] = useState<boolean>(false);
  const cardRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    if (currentMember) {
      const verifyUrl = `${window.location.origin}/member/verify/${encodeURIComponent(currentMember.member_number)}`;
      QRCode.toDataURL(verifyUrl, {
        width: 300,
        margin: 2,
        errorCorrectionLevel: 'H',
        color: {
          dark: '#003822',
          light: '#ffffff',
        },
      })
        .then(url => setQrCodeUrl(url))
        .catch(err => console.error('Error generating QR code:', err));
    }
  }, [currentMember]);

  const handleDownload = async (format: 'png' | 'jpg') => {
    if (!cardRef.current || !currentMember) return;
    setIsExporting(true);

    try {
      // Ensure all images are loaded
      const images = Array.from(cardRef.current.querySelectorAll('img'));
      await Promise.all(
        images.map(
          img =>
            new Promise<void>(resolve => {
              if (img.complete) resolve();
              else {
                img.onload = () => resolve();
                img.onerror = () => resolve();
              }
            })
        )
      );

      const canvas = await html2canvas(cardRef.current, {
        scale: 2,
        useCORS: true,
        backgroundColor: '#ffffff',
        logging: false,
      });

      const mimeType = format === 'jpg' ? 'image/jpeg' : 'image/png';
      const extension = format === 'jpg' ? 'jpg' : 'png';

      canvas.toBlob(
        blob => {
          if (!blob) {
            console.error('Failed to create image blob.');
            setIsExporting(false);
            return;
          }

          const url = URL.createObjectURL(blob);
          const link = document.createElement('a');
          link.href = url;
          link.download = `member-card-${currentMember.member_number}.${extension}`;
          document.body.appendChild(link);
          link.click();
          link.remove();
          URL.revokeObjectURL(url);
          setIsExporting(false);
        },
        mimeType,
        0.95
      );
    } catch (err) {
      console.error('Failed to export member card:', err);
      setIsExporting(false);
    }
  };

  if (!currentMember) {
    return (
      <AppLayout title="Member Card" subtitle="View and download your digital member card.">
        <div className="mx-auto max-w-2xl bg-amber-50 border border-amber-200 rounded-xl p-6 text-center dark:bg-amber-950/20 dark:border-amber-900">
          <AlertCircle className="mx-auto h-10 w-10 text-amber-600 mb-2" />
          <h2 className="text-lg font-semibold text-amber-900 dark:text-amber-200">
            Profil Anggota Belum Ditemukan
          </h2>
          <p className="mt-2 text-sm text-amber-700 dark:text-amber-300">
            Akun Anda belum memiliki rekaman data anggota lengkap. Silakan lengkapi profil terlebih dahulu.
          </p>
          <button
            type="button"
            onClick={() => navigate('/member/profile')}
            className="mt-4 px-4 py-2 bg-[#1C775A] text-white rounded-lg text-sm font-semibold hover:bg-[#155A44] transition"
          >
            Lengkapi Profil Sekarang
          </button>
        </div>
      </AppLayout>
    );
  }

  const formatDate = (dateStr?: string) => {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    return date.toLocaleDateString('id-ID', {
      day: 'numeric',
      month: 'short',
      year: 'numeric',
    });
  };

  return (
    <AppLayout title="Member Card" subtitle="View and download your digital member card.">
      <div className="mx-auto max-w-4xl">
        <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white p-4 shadow-lg shadow-gray-300/40 dark:border-gray-800 dark:bg-[#111827] dark:shadow-black/20 sm:p-6">
          <div className="mb-5 flex items-center justify-between gap-4">
            <div>
              <h2 className="text-base font-semibold text-gray-900 dark:text-white">
                Digital Member Card (KARTANU)
              </h2>
              <p className="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Kartu ini dapat diverifikasi keasliannya melalui kode QR terintegrasi.
              </p>
            </div>

            <span className="hidden sm:inline-flex rounded-full bg-green-50 px-3 py-1.5 text-xs font-semibold text-green-700 dark:bg-green-500/10 dark:text-green-400 border border-green-200 dark:border-green-800">
              {currentMember.status === 'active' ? 'Active' : 'Inactive'}
            </span>
          </div>

          {/* CARD EXPORT AREA */}
          <div
            ref={cardRef}
            id="member-card"
            data-member-number={currentMember.member_number}
            className="overflow-hidden rounded-2xl border border-gray-200 bg-white text-gray-900 shadow-xl max-w-2xl mx-auto"
          >
            {/* Card Accent */}
            <div className="h-2.5 bg-gradient-to-r from-green-700 via-emerald-500 to-cyan-500"></div>

            <div className="p-6 sm:p-8">
              {/* Header */}
              <div className="flex items-start justify-between gap-5">
                <div className="min-w-0">
                  <div className="flex items-center gap-2">
                    <div className="h-7 w-7 rounded bg-[#1C775A] text-white flex items-center justify-center font-bold text-xs">
                      NU
                    </div>
                    <p className="text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">
                      PRNU PEKUNCEN
                    </p>
                  </div>

                  <h1 className="mt-2 text-2xl font-bold tracking-tight text-gray-900">
                    NU MEMBER CARD
                  </h1>

                  <p className="mt-1 text-sm text-gray-500">
                    Digital Membership Identification
                  </p>
                </div>

                {currentMember.photo ? (
                  <img
                    src={currentMember.photo}
                    alt={currentMember.user?.name || 'Member Photo'}
                    crossOrigin="anonymous"
                    className="h-24 w-24 shrink-0 rounded-xl border border-gray-200 object-cover shadow-sm"
                  />
                ) : (
                  <div className="h-24 w-24 shrink-0 rounded-xl border border-gray-200 bg-green-50 text-green-700 flex items-center justify-center font-bold text-3xl shadow-sm">
                    {((currentMember.user?.name || 'A')[0]).toUpperCase()}
                  </div>
                )}
              </div>

              {/* Information */}
              <div className="mt-8 grid gap-x-6 gap-y-5 sm:grid-cols-2">
                <div>
                  <p className="text-xs font-medium uppercase tracking-wider text-gray-400">
                    Member Number
                  </p>
                  <p className="mt-1 font-semibold text-gray-900 font-mono">
                    {currentMember.member_number}
                  </p>
                </div>

                <div>
                  <p className="text-xs font-medium uppercase tracking-wider text-gray-400">
                    Name
                  </p>
                  <p className="mt-1 font-semibold text-gray-900">
                    {currentMember.user?.name}
                  </p>
                </div>

                <div>
                  <p className="text-xs font-medium uppercase tracking-wider text-gray-400">
                    Birth
                  </p>
                  <p className="mt-1 font-semibold text-gray-900">
                    {currentMember.birth_place}, {formatDate(currentMember.birth_date)}
                  </p>
                </div>

                <div>
                  <p className="text-xs font-medium uppercase tracking-wider text-gray-400">
                    Gender
                  </p>
                  <p className="mt-1 font-semibold text-gray-900">
                    {currentMember.gender === 'L' ? 'Laki-laki' : 'Perempuan'}
                  </p>
                </div>

                <div className="sm:col-span-2">
                  <p className="text-xs font-medium uppercase tracking-wider text-gray-400">
                    Address
                  </p>
                  <p className="mt-1 font-semibold leading-6 text-gray-900">
                    {currentMember.address}
                  </p>
                </div>

                <div>
                  <p className="text-xs font-medium uppercase tracking-wider text-gray-400">
                    Status
                  </p>
                  <p className="mt-1 font-semibold text-emerald-700">
                    {currentMember.status === 'active' ? 'Active' : 'Inactive'}
                  </p>
                </div>

                <div>
                  <p className="text-xs font-medium uppercase tracking-wider text-gray-400">
                    NIK
                  </p>
                  <p className="mt-1 font-semibold text-gray-900 font-mono">
                    {currentMember.nik}
                  </p>
                </div>
              </div>

              {/* QR Code Section */}
              <div className="mt-8 flex justify-center">
                <div className="text-center">
                  <div className="inline-flex rounded-xl border border-gray-200 bg-white p-3 shadow-sm">
                    {qrCodeUrl ? (
                      <img
                        src={qrCodeUrl}
                        alt="Member verification QR Code"
                        className="h-32 w-32"
                      />
                    ) : (
                      <div className="h-32 w-32 flex items-center justify-center">
                        <RefreshCw className="h-6 w-6 animate-spin text-gray-400" />
                      </div>
                    )}
                  </div>

                  <p className="mt-3 text-xs text-gray-500">
                    Scan to verify membership authenticity
                  </p>
                </div>
              </div>
            </div>

            {/* Footer Accent */}
            <div className="border-t border-gray-200 bg-gray-50 px-6 py-3 text-center">
              <p className="text-[10px] font-medium uppercase tracking-[0.2em] text-gray-400">
                Official Digital Membership Card • PRNU Pekuncen
              </p>
            </div>
          </div>

          {/* Download Buttons */}
          <div className="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-end">
            <button
              type="button"
              disabled={isExporting}
              onClick={() => handleDownload('png')}
              className="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-200/40 transition hover:bg-blue-700 disabled:opacity-50 dark:bg-blue-500 dark:shadow-blue-950/20 dark:hover:bg-blue-600"
            >
              <Download className="h-4 w-4" />
              {isExporting ? 'Generating...' : 'Download PNG'}
            </button>

            <button
              type="button"
              disabled={isExporting}
              onClick={() => handleDownload('jpg')}
              className="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
            >
              <Download className="h-4 w-4" />
              Download JPG
            </button>
          </div>
        </div>
      </div>
    </AppLayout>
  );
};
