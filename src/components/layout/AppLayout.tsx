import React, { useState } from 'react';
import { useApp } from '../../context/AppContext';
import { ThemeToggle } from '../ThemeToggle';
import {
  Menu,
  X,
  LogOut,
  User as UserIcon,
  CreditCard,
  FileText,
  FolderKanban,
  Users,
  LayoutDashboard,
  ExternalLink,
} from 'lucide-react';

interface AppLayoutProps {
  title: string;
  subtitle?: string;
  children: React.ReactNode;
}

export const AppLayout: React.FC<AppLayoutProps> = ({ title, subtitle, children }) => {
  const { currentUser, currentRoute, navigate, logout } = useApp();
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [userDropdownOpen, setUserDropdownOpen] = useState(false);

  const isAdmin = currentUser?.role === 'admin';

  return (
    <div className="min-h-screen bg-gray-50 dark:bg-[#101412] text-gray-900 dark:text-[#e0e3df] antialiased">
      {/* Top Navbar */}
      <nav className="bg-white dark:bg-[#181c1a] border-b border-gray-200 dark:border-[#2b312d] sticky top-0 z-40">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between h-16">
            <div className="flex items-center">
              {/* Logo */}
              <button
                type="button"
                onClick={() => navigate(isAdmin ? '/admin/dashboard' : '/member/dashboard')}
                className="shrink-0 flex items-center gap-3 text-left"
              >
                <div className="flex h-9 w-9 items-center justify-center rounded-md bg-[#1C775A] text-white font-bold">
                  NU
                </div>
                <div className="hidden sm:block">
                  <span className="font-editorial text-xl font-bold tracking-tight text-[#1C775A] dark:text-[#2ec486]">
                    NU Pekuncen
                  </span>
                  <span className="ml-2 text-xs uppercase px-2 py-0.5 rounded font-semibold bg-green-100 text-green-800 dark:bg-green-950 dark:text-green-300">
                    {isAdmin ? 'Admin' : 'Member'}
                  </span>
                </div>
              </button>

              {/* Navigation Links (Desktop) */}
              <div className="hidden sm:-my-px sm:ms-10 sm:flex sm:space-x-4">
                <button
                  type="button"
                  onClick={() => navigate(isAdmin ? '/admin/dashboard' : '/member/dashboard')}
                  className={`inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium border-b-2 transition ${
                    currentRoute.endsWith('/dashboard')
                      ? 'border-[#1C775A] text-[#1C775A] dark:border-[#2ec486] dark:text-[#2ec486]'
                      : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200'
                  }`}
                >
                  <LayoutDashboard className="h-4 w-4" />
                  Dashboard
                </button>

                {isAdmin && (
                  <>
                    <button
                      type="button"
                      onClick={() => navigate('/admin/news')}
                      className={`inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium border-b-2 transition ${
                        currentRoute.startsWith('/admin/news')
                          ? 'border-[#1C775A] text-[#1C775A] dark:border-[#2ec486] dark:text-[#2ec486]'
                          : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200'
                      }`}
                    >
                      <FileText className="h-4 w-4" />
                      Berita
                    </button>
                    <button
                      type="button"
                      onClick={() => navigate('/admin/categories')}
                      className={`inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium border-b-2 transition ${
                        currentRoute.startsWith('/admin/categories')
                          ? 'border-[#1C775A] text-[#1C775A] dark:border-[#2ec486] dark:text-[#2ec486]'
                          : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200'
                      }`}
                    >
                      <FolderKanban className="h-4 w-4" />
                      Kategori
                    </button>
                    <button
                      type="button"
                      onClick={() => navigate('/admin/members')}
                      className={`inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium border-b-2 transition ${
                        currentRoute.startsWith('/admin/members')
                          ? 'border-[#1C775A] text-[#1C775A] dark:border-[#2ec486] dark:text-[#2ec486]'
                          : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200'
                      }`}
                    >
                      <Users className="h-4 w-4" />
                      Anggota
                    </button>
                  </>
                )}

                {!isAdmin && (
                  <>
                    <button
                      type="button"
                      onClick={() => navigate('/member/profile')}
                      className={`inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium border-b-2 transition ${
                        currentRoute.startsWith('/member/profile')
                          ? 'border-[#1C775A] text-[#1C775A] dark:border-[#2ec486] dark:text-[#2ec486]'
                          : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200'
                      }`}
                    >
                      <UserIcon className="h-4 w-4" />
                      Profil
                    </button>
                    <button
                      type="button"
                      onClick={() => navigate('/member/card')}
                      className={`inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium border-b-2 transition ${
                        currentRoute.startsWith('/member/card')
                          ? 'border-[#1C775A] text-[#1C775A] dark:border-[#2ec486] dark:text-[#2ec486]'
                          : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200'
                      }`}
                    >
                      <CreditCard className="h-4 w-4" />
                      Kartu Anggota
                    </button>
                  </>
                )}
              </div>
            </div>

            {/* Right side controls */}
            <div className="hidden sm:flex sm:items-center sm:gap-3">
              <button
                type="button"
                onClick={() => navigate('/')}
                title="Lihat Website Publik"
                className="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition"
              >
                <ExternalLink className="h-3.5 w-3.5" />
                Web Publik
              </button>

              <ThemeToggle />

              {/* User dropdown */}
              <div className="relative">
                <button
                  type="button"
                  onClick={() => setUserDropdownOpen(!userDropdownOpen)}
                  className="inline-flex items-center gap-2 px-3 py-2 border border-gray-200 dark:border-gray-700 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-200 bg-white dark:bg-[#181c1a] hover:bg-gray-50 dark:hover:bg-gray-800 transition shadow-sm"
                >
                  <div className="h-7 w-7 rounded-full bg-[#1C775A] text-white flex items-center justify-center font-bold text-xs">
                    {currentUser?.name.substring(0, 2).toUpperCase()}
                  </div>
                  <span>{currentUser?.name}</span>
                </button>

                {userDropdownOpen && (
                  <div className="origin-top-right absolute right-0 mt-2 w-48 rounded-xl shadow-lg bg-white dark:bg-[#181c1a] ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 dark:divide-gray-800 z-50">
                    <div className="px-4 py-3">
                      <p className="text-xs text-gray-500 dark:text-gray-400">Masuk sebagai</p>
                      <p className="text-sm font-semibold text-gray-900 dark:text-white truncate">
                        {currentUser?.email}
                      </p>
                    </div>
                    <div className="py-1">
                      <button
                        type="button"
                        onClick={() => {
                          setUserDropdownOpen(false);
                          logout();
                        }}
                        className="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/30"
                      >
                        <LogOut className="h-4 w-4" />
                        Keluar (Log Out)
                      </button>
                    </div>
                  </div>
                )}
              </div>
            </div>

            {/* Mobile menu button */}
            <div className="-me-2 flex items-center sm:hidden gap-2">
              <ThemeToggle />
              <button
                type="button"
                onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                className="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800"
              >
                {mobileMenuOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
              </button>
            </div>
          </div>
        </div>

        {/* Mobile menu */}
        {mobileMenuOpen && (
          <div className="sm:hidden border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-[#181c1a] px-4 pt-2 pb-4 space-y-2">
            <button
              type="button"
              onClick={() => {
                setMobileMenuOpen(false);
                navigate(isAdmin ? '/admin/dashboard' : '/member/dashboard');
              }}
              className="block w-full text-left px-3 py-2 rounded-md font-medium text-gray-800 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800"
            >
              Dashboard
            </button>
            {isAdmin ? (
              <>
                <button
                  type="button"
                  onClick={() => {
                    setMobileMenuOpen(false);
                    navigate('/admin/news');
                  }}
                  className="block w-full text-left px-3 py-2 rounded-md font-medium text-gray-800 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800"
                >
                  Berita
                </button>
                <button
                  type="button"
                  onClick={() => {
                    setMobileMenuOpen(false);
                    navigate('/admin/categories');
                  }}
                  className="block w-full text-left px-3 py-2 rounded-md font-medium text-gray-800 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800"
                >
                  Kategori
                </button>
                <button
                  type="button"
                  onClick={() => {
                    setMobileMenuOpen(false);
                    navigate('/admin/members');
                  }}
                  className="block w-full text-left px-3 py-2 rounded-md font-medium text-gray-800 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800"
                >
                  Anggota
                </button>
              </>
            ) : (
              <>
                <button
                  type="button"
                  onClick={() => {
                    setMobileMenuOpen(false);
                    navigate('/member/profile');
                  }}
                  className="block w-full text-left px-3 py-2 rounded-md font-medium text-gray-800 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800"
                >
                  Profil
                </button>
                <button
                  type="button"
                  onClick={() => {
                    setMobileMenuOpen(false);
                    navigate('/member/card');
                  }}
                  className="block w-full text-left px-3 py-2 rounded-md font-medium text-gray-800 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800"
                >
                  Kartu Anggota
                </button>
              </>
            )}
            <button
              type="button"
              onClick={() => {
                setMobileMenuOpen(false);
                navigate('/');
              }}
              className="block w-full text-left px-3 py-2 rounded-md font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800"
            >
              Lihat Portal Publik
            </button>
            <div className="pt-2 border-t border-gray-200 dark:border-gray-700">
              <button
                type="button"
                onClick={() => {
                  setMobileMenuOpen(false);
                  logout();
                }}
                className="block w-full text-left px-3 py-2 rounded-md font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/20"
              >
                Log Out ({currentUser?.name})
              </button>
            </div>
          </div>
        )}
      </nav>

      {/* Header section */}
      <header className="bg-white dark:bg-[#181c1a] border-b border-gray-200 dark:border-[#2b312d] py-6">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h1 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white font-editorial sm:text-3xl">
            {title}
          </h1>
          {subtitle && (
            <p className="mt-1 text-sm text-gray-500 dark:text-gray-400 font-interface">
              {subtitle}
            </p>
          )}
        </div>
      </header>

      {/* Main Content Area */}
      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">{children}</main>
    </div>
  );
};
