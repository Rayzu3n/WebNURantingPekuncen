import React, { useState } from 'react';
import { useApp } from '../../context/AppContext';
import { ThemeToggle } from '../ThemeToggle';
import { Menu, X, ShieldCheck } from 'lucide-react';

interface PublicLayoutProps {
  children: React.ReactNode;
}

export const PublicLayout: React.FC<PublicLayoutProps> = ({ children }) => {
  const { currentUser, currentRoute, navigate } = useApp();
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  return (
    <div className="min-h-screen flex flex-col bg-white text-[#15201B] antialiased dark:bg-[#101412] dark:text-[#e0e3df]">
      {/* Navigation */}
      <header className="sticky top-0 z-50 border-b border-[#CFD0C3] bg-white/95 backdrop-blur-md dark:border-[#2b312d] dark:bg-[#181c1a]/95">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="h-16 flex items-center justify-between">
            {/* Brand */}
            <div className="flex items-center gap-8">
              <button
                type="button"
                onClick={() => navigate('/')}
                className="flex items-center gap-3 text-left group"
              >
                <div className="flex h-9 w-9 items-center justify-center rounded-md bg-[#1C775A] text-white font-bold text-base shadow-sm group-hover:bg-[#155A44] transition-colors">
                  NU
                </div>
                <div>
                  <div className="font-editorial text-2xl font-semibold tracking-tight text-[#1C775A] dark:text-[#2ec486]">
                    Portal Berita NU
                  </div>
                  <div className="text-[10px] tracking-wider uppercase font-semibold text-gray-500 dark:text-gray-400">
                    Ranting Pekuncen
                  </div>
                </div>
              </button>

              {/* Desktop Navigation */}
              <nav className="hidden md:flex items-center gap-6">
                <button
                  type="button"
                  onClick={() => navigate('/')}
                  className={`font-interface text-sm font-semibold transition-colors ${
                    currentRoute === '/'
                      ? 'text-[#1C775A] dark:text-[#2ec486]'
                      : 'text-[#4A5550] hover:text-[#1C775A] dark:text-[#bbcabf] dark:hover:text-[#53e0a0]'
                  }`}
                >
                  Beranda
                </button>
                <button
                  type="button"
                  onClick={() => navigate('/berita')}
                  className={`font-interface text-sm font-semibold transition-colors ${
                    currentRoute.startsWith('/berita')
                      ? 'text-[#1C775A] dark:text-[#2ec486]'
                      : 'text-[#4A5550] hover:text-[#1C775A] dark:text-[#bbcabf] dark:hover:text-[#53e0a0]'
                  }`}
                >
                  Berita
                </button>
              </nav>
            </div>

            {/* Desktop Actions */}
            <div className="hidden sm:flex items-center gap-3">
              <ThemeToggle />

              {currentUser ? (
                <button
                  type="button"
                  onClick={() =>
                    navigate(currentUser.role === 'admin' ? '/admin/dashboard' : '/member/dashboard')
                  }
                  className="inline-flex items-center gap-2 rounded-md bg-[#1C775A] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#155A44]"
                >
                  <ShieldCheck className="h-4 w-4" />
                  Dashboard ({currentUser.role === 'admin' ? 'Admin' : 'Member'})
                </button>
              ) : (
                <button
                  type="button"
                  onClick={() => navigate('/login')}
                  className="inline-flex items-center rounded-md bg-[#1C775A] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#155A44]"
                >
                  Login
                </button>
              )}
            </div>

            {/* Mobile Button */}
            <div className="flex sm:hidden items-center gap-2">
              <ThemeToggle />
              <button
                type="button"
                onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                className="inline-flex items-center justify-center rounded-md p-2 text-[#4A5550] hover:bg-gray-100 dark:text-[#bbcabf] dark:hover:bg-[#1c201e]"
                aria-label="Toggle navigation"
              >
                {mobileMenuOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
              </button>
            </div>
          </div>
        </div>

        {/* Mobile Navigation Drawer */}
        {mobileMenuOpen && (
          <div className="border-t border-[#CFD0C3] bg-white sm:hidden dark:border-[#2b312d] dark:bg-[#181c1a]">
            <div className="space-y-1 px-4 py-3">
              <button
                type="button"
                onClick={() => {
                  setMobileMenuOpen(false);
                  navigate('/');
                }}
                className="block w-full text-left rounded-md px-3 py-2 text-sm font-semibold text-[#15201B] hover:bg-[#F5FAF8] hover:text-[#1C775A] dark:text-[#e0e3df] dark:hover:bg-[#1c201e]"
              >
                Beranda
              </button>
              <button
                type="button"
                onClick={() => {
                  setMobileMenuOpen(false);
                  navigate('/berita');
                }}
                className="block w-full text-left rounded-md px-3 py-2 text-sm font-semibold text-[#15201B] hover:bg-[#F5FAF8] hover:text-[#1C775A] dark:text-[#e0e3df] dark:hover:bg-[#1c201e]"
              >
                Berita
              </button>
              {currentUser ? (
                <button
                  type="button"
                  onClick={() => {
                    setMobileMenuOpen(false);
                    navigate(currentUser.role === 'admin' ? '/admin/dashboard' : '/member/dashboard');
                  }}
                  className="block w-full text-center rounded-md bg-[#1C775A] px-3 py-2 text-sm font-semibold text-white mt-2"
                >
                  Buka Dashboard ({currentUser.role === 'admin' ? 'Admin' : 'Member'})
                </button>
              ) : (
                <button
                  type="button"
                  onClick={() => {
                    setMobileMenuOpen(false);
                    navigate('/login');
                  }}
                  className="block w-full text-center rounded-md bg-[#1C775A] px-3 py-2 text-sm font-semibold text-white mt-2"
                >
                  Login
                </button>
              )}
            </div>
          </div>
        )}
      </header>

      {/* Main Content */}
      <main className="flex-1 w-full">{children}</main>

      {/* Footer */}
      <footer className="mt-auto border-t border-[#CFD0C3] bg-[#15201B] px-4 py-12 text-[#CFD0C3] sm:px-6 lg:px-8">
        <div className="mx-auto max-w-7xl">
          <div className="grid gap-10 md:grid-cols-3">
            {/* Brand */}
            <div>
              <div className="font-editorial text-2xl font-semibold text-white">
                Portal Berita NU
              </div>
              <p className="mt-3 max-w-md text-sm leading-6 text-[#CFD0C3]">
                Portal informasi dan berita untuk menyajikan kegiatan serta informasi seputar Nahdlatul Ulama Ranting Pekuncen.
              </p>
            </div>

            {/* Navigation */}
            <div>
              <h3 className="text-sm font-semibold uppercase tracking-wider text-white">
                Navigasi
              </h3>
              <div className="mt-4 space-y-2">
                <button
                  type="button"
                  onClick={() => navigate('/')}
                  className="block text-sm text-[#CFD0C3] transition-colors hover:text-[#94DFE0]"
                >
                  Beranda
                </button>
                <button
                  type="button"
                  onClick={() => navigate('/berita')}
                  className="block text-sm text-[#CFD0C3] transition-colors hover:text-[#94DFE0]"
                >
                  Berita
                </button>
                {currentUser ? (
                  <button
                    type="button"
                    onClick={() =>
                      navigate(currentUser.role === 'admin' ? '/admin/dashboard' : '/member/dashboard')
                    }
                    className="block text-sm text-[#CFD0C3] transition-colors hover:text-[#94DFE0]"
                  >
                    Dashboard
                  </button>
                ) : (
                  <button
                    type="button"
                    onClick={() => navigate('/login')}
                    className="block text-sm text-[#CFD0C3] transition-colors hover:text-[#94DFE0]"
                  >
                    Login
                  </button>
                )}
              </div>
            </div>

            {/* Organisation */}
            <div>
              <h3 className="text-sm font-semibold uppercase tracking-wider text-white">
                Portal Resmi
              </h3>
              <p className="mt-4 text-sm leading-6 text-[#CFD0C3]">
                Media informasi dan administrasi resmi untuk lingkungan Pengurus Ranting Nahdlatul Ulama (PRNU) Desa Pekuncen, Kecamatan Pekuncen, Kabupaten Banyumas.
              </p>
            </div>
          </div>

          <div className="mt-10 border-t border-[#2b312d] pt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p className="text-sm text-[#86948a]">
              &copy; {new Date().getFullYear()} Portal Berita NU Ranting Pekuncen. All rights reserved.
            </p>
            <div className="text-xs text-[#86948a] flex items-center gap-3">
              <span>Banyumas, Jawa Tengah</span>
              <span>•</span>
              <span>Aswaja an-Nahdliyah</span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  );
};
