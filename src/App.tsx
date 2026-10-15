import React from 'react';
import { useApp } from './context/AppContext';
import { HomePage } from './pages/HomePage';
import { NewsIndexPage } from './pages/NewsIndexPage';
import { NewsDetailPage } from './pages/NewsDetailPage';
import { MemberVerifyPage } from './pages/MemberVerifyPage';
import { MemberCardPage } from './pages/MemberCardPage';
import { MemberProfilePage } from './pages/MemberProfilePage';
import { MemberDashboardPage } from './pages/MemberDashboardPage';
import { AdminDashboardPage } from './pages/AdminDashboardPage';
import { AdminNewsPage } from './pages/AdminNewsPage';
import { AdminCategoriesPage } from './pages/AdminCategoriesPage';
import { AdminMembersPage } from './pages/AdminMembersPage';
import { LoginPage } from './pages/LoginPage';
import { RegisterPage } from './pages/RegisterPage';

export const App: React.FC = () => {
  const { currentRoute, currentUser, navigate } = useApp();

  // Normalize path without query parameters or hash
  const path = currentRoute.split('?')[0].split('#')[0];

  // Public Routes
  if (path === '/' || path === '/home') {
    return <HomePage />;
  }

  if (path === '/berita') {
    return <NewsIndexPage />;
  }

  if (path.startsWith('/berita/')) {
    const slug = path.replace('/berita/', '');
    return <NewsDetailPage slug={slug} />;
  }

  if (path.startsWith('/member/verify/')) {
    const memberNumber = decodeURIComponent(path.replace('/member/verify/', ''));
    return <MemberVerifyPage memberNumber={memberNumber} />;
  }

  if (path === '/login') {
    if (currentUser) {
      if (currentUser.role === 'admin') {
        navigate('/admin/dashboard');
        return <AdminDashboardPage />;
      }
      navigate('/member/dashboard');
      return <MemberDashboardPage />;
    }
    return <LoginPage />;
  }

  if (path === '/register') {
    if (currentUser) {
      navigate('/member/dashboard');
      return <MemberDashboardPage />;
    }
    return <RegisterPage />;
  }

  if (path === '/dashboard') {
    if (!currentUser) {
      return <LoginPage />;
    }
    if (currentUser.role === 'admin') {
      return <AdminDashboardPage />;
    }
    return <MemberDashboardPage />;
  }

  // Admin Routes (protected)
  if (path.startsWith('/admin')) {
    if (!currentUser) {
      return <LoginPage />;
    }
    if (currentUser.role !== 'admin') {
      return <MemberDashboardPage />;
    }

    if (path === '/admin/dashboard' || path === '/admin') {
      return <AdminDashboardPage />;
    }
    if (path === '/admin/news') {
      return <AdminNewsPage />;
    }
    if (path === '/admin/categories') {
      return <AdminCategoriesPage />;
    }
    if (path === '/admin/members') {
      return <AdminMembersPage />;
    }
  }

  // Member Routes (protected)
  if (path.startsWith('/member')) {
    if (!currentUser) {
      return <LoginPage />;
    }

    if (path === '/member/dashboard') {
      return <MemberDashboardPage />;
    }
    if (path === '/member/profile') {
      return <MemberProfilePage />;
    }
    if (path === '/member/card') {
      return <MemberCardPage />;
    }
  }

  // Fallback
  return <HomePage />;
};
