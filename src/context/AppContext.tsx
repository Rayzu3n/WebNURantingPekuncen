import React, { createContext, useContext, useState, useEffect } from 'react';
import { User, Member, News, NewsCategory } from '../types';

interface AppContextType {
  currentUser: User | null;
  currentMember: Member | null;
  users: User[];
  members: Member[];
  news: News[];
  categories: NewsCategory[];
  darkMode: boolean;
  toggleDarkMode: () => void;
  login: (email: string, password?: string) => { success: boolean; message?: string };
  logout: () => void;
  register: (name: string, email: string, password?: string) => { success: boolean; message?: string };
  updateMemberProfile: (data: Partial<Member>) => { success: boolean; message?: string };
  createNews: (newsItem: Omit<News, 'id' | 'author_id'>) => { success: boolean; message?: string };
  updateNews: (id: number, newsItem: Partial<News>) => { success: boolean; message?: string };
  deleteNews: (id: number) => { success: boolean; message?: string };
  createCategory: (category: Omit<NewsCategory, 'id'>) => { success: boolean; message?: string };
  updateCategory: (id: number, category: Partial<NewsCategory>) => { success: boolean; message?: string };
  deleteCategory: (id: number) => { success: boolean; message?: string };
  createMember: (memberData: {
    name: string;
    email: string;
    member_number: string;
    nik: string;
    birth_place: string;
    birth_date: string;
    gender: 'L' | 'P';
    phone?: string;
    address: string;
    photo?: string;
    status: 'active' | 'inactive';
  }) => { success: boolean; message?: string };
  updateMember: (id: number, memberData: Partial<Member> & { name?: string; email?: string }) => { success: boolean; message?: string };
  deleteMember: (id: number) => { success: boolean; message?: string };
  currentRoute: string;
  navigate: (route: string) => void;
}

const INITIAL_USERS: User[] = [
  {
    id: 1,
    name: 'Admin Redaksi NU',
    email: 'admin@nu-pekuncen.org',
    role: 'admin',
    email_verified_at: '2026-01-01T00:00:00Z',
  },
  {
    id: 2,
    name: 'Ahmad Dahlan',
    email: 'member@nu-pekuncen.org',
    role: 'member',
    email_verified_at: '2026-01-01T00:00:00Z',
  },
  {
    id: 3,
    name: 'Siti Fatimah',
    email: 'siti.fatimah@nu-pekuncen.org',
    role: 'member',
    email_verified_at: '2026-02-15T00:00:00Z',
  },
  {
    id: 4,
    name: 'K.H. Mustofa Bisri',
    email: 'mustofa@nu-pekuncen.org',
    role: 'member',
    email_verified_at: '2026-03-01T00:00:00Z',
  },
];

const INITIAL_MEMBERS: Member[] = [
  {
    id: 1,
    user_id: 2,
    member_number: 'NU-PKC-2026-001',
    nik: '3302141508890001',
    birth_place: 'Banyumas',
    birth_date: '1989-08-15',
    gender: 'L',
    phone: '081234567890',
    address: 'RT 03 RW 02, Desa Pekuncen, Kec. Pekuncen, Kab. Banyumas, Jawa Tengah',
    photo: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80',
    status: 'active',
  },
  {
    id: 2,
    user_id: 3,
    member_number: 'NU-PKC-2026-002',
    nik: '3302145204920002',
    birth_place: 'Banyumas',
    birth_date: '1992-04-12',
    gender: 'P',
    phone: '081987654321',
    address: 'RT 01 RW 04, Desa Pekuncen, Kec. Pekuncen, Kab. Banyumas, Jawa Tengah',
    photo: 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=400&q=80',
    status: 'active',
  },
  {
    id: 3,
    user_id: 4,
    member_number: 'NU-PKC-2026-003',
    nik: '3302141010750003',
    birth_place: 'Pekuncen',
    birth_date: '1975-10-10',
    gender: 'L',
    phone: '085211223344',
    address: 'Kompleks Pondok Pesantren Pekuncen, RT 02 RW 01',
    photo: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=400&q=80',
    status: 'active',
  },
];

const INITIAL_CATEGORIES: NewsCategory[] = [
  { id: 1, name: 'Kegiatan', slug: 'kegiatan' },
  { id: 2, name: 'Pengumuman', slug: 'pengumuman' },
  { id: 3, name: 'Kajian & Keagamaan', slug: 'kajian-keagamaan' },
  { id: 4, name: 'Sosial & Kemasyarakatan', slug: 'sosial-kemasyarakatan' },
  { id: 5, name: 'Pendidikan & Kaderisasi', slug: 'pendidikan-kaderisasi' },
];

const INITIAL_NEWS: News[] = [
  {
    id: 1,
    category_id: 1,
    author_id: 1,
    title: 'Pelantikan Pengurus Ranting Nahdlatul Ulama Pekuncen Masa Khidmat 2026-2031 Berjalan Khidmat',
    slug: 'pelantikan-pengurus-ranting-nu-pekuncen-2026-2031',
    excerpt: 'Pengurus Ranting Nahdlatul Ulama (PRNU) Pekuncen resmi dilantik dalam suasana khusyuk dan penuh optimisme dihadiri jajaran MWC NU serta tokoh masyarakat setempat.',
    content: `PEKUNCEN — Pengurus Ranting Nahdlatul Ulama (PRNU) Pekuncen secara resmi dilantik untuk masa khidmat 2026–2031 bertempat di Masjid Jami' Pekuncen pada hari Ahad.

Acara pelantikan ini dihadiri oleh jajaran Pengurus Majelis Wakil Cabang (MWC) NU, tokoh masyarakat, alim ulama, serta ratusan warga Nahdliyin dari seluruh dusun di Pekuncen.

Dalam sambutannya, Rais Syuriyah PRNU Pekuncen menegaskan pentingnya memperkuat ukhuwah islamiyah dan komitmen melayani umat di bidang keagamaan, pendidikan, dan pemberdayaan ekonomi masyarakat.

"Kehadiran NU di tingkat ranting adalah ujung tombak pelayanan umat. Kita harus senantiasa menjaga tradisi Aswaja an-Nahdliyah dan merangkul generasi muda untuk aktif berkontribusi," ujarnya.

Kegiatan ini diakhiri dengan doa bersama untuk keselamatan bangsa dan kemajuan warga Nahdlatul Ulama khususnya di wilayah Pekuncen.`,
    thumbnail: 'https://images.unsplash.com/photo-1542816417-0983c9c9ad53?auto=format&fit=crop&w=1200&q=80',
    status: 'published',
    published_at: '2026-10-12T10:00:00Z',
  },
  {
    id: 2,
    category_id: 3,
    author_id: 1,
    title: "Lailatul Ijtima' dan Pengajian Kitab Nashoihul Ibad di Musala Nurul Huda",
    slug: 'lailatul-ijtima-pengajian-nashoihul-ibad-musala-nurul-huda',
    excerpt: "Warga Nahdliyin Pekuncen rutin menggelar tradisi Lailatul Ijtima' setiap malam Jumat Kliwon guna mempererat silaturahmi spiritual dan keilmuan.",
    content: `PEKUNCEN — Ratusan jamaah memadati Musala Nurul Huda Pekuncen dalam gelaran Lailatul Ijtima' bulanan PRNU Pekuncen. Kegiatan diawali dengan salat hajat dan tasbih berjamaah, dilanjutkan pembacaan istighosah, tahlil akbar, dan pengajian kitab Nashoihul Ibad karya Syaikh Nawawi al-Bantani.

Ketua Tanfidziyah menyampaikan apresiasi atas konsistensi warga dalam merawat amaliah Ahlussunnah wal Jama'ah an-Nahdliyah. Beliau juga mengajak seluruh jamaah untuk senantiasa mengamalkan nilai-nilai tasamuh (toleransi) dan tawazun (seimbang) dalam kehidupan bertetangga.`,
    thumbnail: 'https://images.unsplash.com/photo-1564769625905-50e93615e769?auto=format&fit=crop&w=800&q=80',
    status: 'published',
    published_at: '2026-10-10T20:30:00Z',
  },
  {
    id: 3,
    category_id: 4,
    author_id: 1,
    title: 'Lazisnu Ranting Pekuncen Salurkan Santunan Paket Sembako untuk Kaum Dhuafa',
    slug: 'lazisnu-ranting-pekuncen-salurkan-santunan-sembako',
    excerpt: 'Program Koin NU Pekuncen kembali membuktikan manfaat nyata dengan menyalurkan ratusan paket kebutuhan pokok bagi warga yang membutuhkan.',
    content: `PEKUNCEN — Unit Pengelola Zakat, Infaq, dan Shadaqah Nahdlatul Ulama (UPZIS) Lazisnu Ranting Pekuncen menyalurkan 150 paket sembako kepada mustahiq di 5 pedukuhan se-Desa Pekuncen.

Program ini bersumber dari infaq kaleng Koin NU yang dikumpulkan secara mandiri dan transparan oleh kader-kader Muslimat dan Fatayat setiap bulannya. Penyaluran disaksikan oleh tokoh warga dan aparatur desa.

Melalui program ini, Lazisnu terus membuktikan bahwa kemandirian ekonomi umat dapat terwujud lewat gerakan gotong royong warga Nahdliyin.`,
    thumbnail: 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=800&q=80',
    status: 'published',
    published_at: '2026-10-08T14:15:00Z',
  },
  {
    id: 4,
    category_id: 5,
    author_id: 1,
    title: 'Kaderisasi IPNU & IPPNU Pekuncen: Cetak Generasi Muda Berkarakter dan Mandiri',
    slug: 'kaderisasi-ipnu-ippnu-pekuncen-generasi-muda',
    excerpt: 'Pimpinan Ranting IPNU-IPPNU Pekuncen menyelenggarakan Makesta (Masa Kesetiaan Anggota) bagi puluhan pelajar dan santri.',
    content: `PEKUNCEN — Sebanyak 45 peserta antusias mengikuti Masa Kesetiaan Anggota (MAKESTA) yang digelar oleh PR IPNU dan IPPNU Desa Pekuncen. Kegiatan berlangsung selama dua hari di Aula Madrasah Diniyah Pekuncen.

Para peserta menerima berbagai materi pembekalan, antara lain ke-NU-an, ke-Aswaja-an, keorganisasian, wawasan kebangsaan, dan kepemimpinan digital di era modern.

Ketua PR IPNU berharap pelatihan ini menjadi gerbang lahirnya generasi muda yang berilmu, berakhlaqul karimah, dan cinta tanah air.`,
    thumbnail: 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=800&q=80',
    status: 'published',
    published_at: '2026-10-05T09:00:00Z',
  },
  {
    id: 5,
    category_id: 2,
    author_id: 1,
    title: 'Sosialisasi Pembuatan Kartu Tanda Anggota NU (KARTANU) Digital Ranting Pekuncen',
    slug: 'sosialisasi-kartanu-digital-ranting-pekuncen',
    excerpt: 'Seluruh warga NU Ranting Pekuncen kini dapat mengakses kartu anggota digital terverifikasi QR Code melalui portal resmi ranting.',
    content: `PEKUNCEN — Dalam rangka modernisasi administrasi organisasi, PRNU Pekuncen meluncurkan fasilitas KARTANU Digital yang dilengkapi kode QR verifikasi instan.

Warga yang telah terdaftar sebagai anggota dapat melihat profil, mengecek status keanggotaan aktif, serta mengunduh kartu digital dalam format PNG maupun JPG beresolusi tinggi langsung dari genggaman ponsel.

Bagi warga yang belum memiliki kartu, pendaftaran dapat dilakukan melalui pengurus ranting setempat atau sekretariat PRNU Pekuncen.`,
    thumbnail: 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=800&q=80',
    status: 'published',
    published_at: '2026-10-01T08:00:00Z',
  },
];

const AppContext = createContext<AppContextType | undefined>(undefined);

export const AppProvider: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [users, setUsers] = useState<User[]>(() => {
    const saved = localStorage.getItem('nu_users');
    return saved ? JSON.parse(saved) : INITIAL_USERS;
  });

  const [members, setMembers] = useState<Member[]>(() => {
    const saved = localStorage.getItem('nu_members');
    return saved ? JSON.parse(saved) : INITIAL_MEMBERS;
  });

  const [categories, setCategories] = useState<NewsCategory[]>(() => {
    const saved = localStorage.getItem('nu_categories');
    return saved ? JSON.parse(saved) : INITIAL_CATEGORIES;
  });

  const [news, setNews] = useState<News[]>(() => {
    const saved = localStorage.getItem('nu_news');
    return saved ? JSON.parse(saved) : INITIAL_NEWS;
  });

  const [currentUser, setCurrentUser] = useState<User | null>(() => {
    const saved = localStorage.getItem('nu_current_user');
    return saved ? JSON.parse(saved) : null;
  });

  const [darkMode, setDarkMode] = useState<boolean>(() => {
    const saved = localStorage.getItem('theme');
    if (saved) return saved === 'dark';
    return window.matchMedia('(prefers-color-scheme: dark)').matches;
  });

  const [currentRoute, setCurrentRoute] = useState<string>(() => {
    return window.location.pathname || '/';
  });

  // Keep browser URL and route state synced
  const navigate = (route: string) => {
    window.history.pushState({}, '', route);
    setCurrentRoute(route);
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  useEffect(() => {
    const handlePopState = () => {
      setCurrentRoute(window.location.pathname || '/');
    };
    window.addEventListener('popstate', handlePopState);
    return () => window.removeEventListener('popstate', handlePopState);
  }, []);

  // Save changes to localStorage
  useEffect(() => {
    localStorage.setItem('nu_users', JSON.stringify(users));
  }, [users]);

  useEffect(() => {
    localStorage.setItem('nu_members', JSON.stringify(members));
  }, [members]);

  useEffect(() => {
    localStorage.setItem('nu_categories', JSON.stringify(categories));
  }, [categories]);

  useEffect(() => {
    localStorage.setItem('nu_news', JSON.stringify(news));
  }, [news]);

  useEffect(() => {
    if (currentUser) {
      localStorage.setItem('nu_current_user', JSON.stringify(currentUser));
    } else {
      localStorage.removeItem('nu_current_user');
    }
  }, [currentUser]);

  useEffect(() => {
    document.documentElement.classList.toggle('dark', darkMode);
    localStorage.setItem('theme', darkMode ? 'dark' : 'light');
  }, [darkMode]);

  const toggleDarkMode = () => {
    setDarkMode(prev => !prev);
  };

  const login = (email: string, _password?: string) => {
    const trimmed = email.trim().toLowerCase();
    const user = users.find(u => u.email.toLowerCase() === trimmed);
    if (user) {
      setCurrentUser(user);
      if (user.role === 'admin') {
        navigate('/admin/dashboard');
      } else {
        navigate('/member/dashboard');
      }
      return { success: true };
    }
    return { success: false, message: 'Kombinasi email atau password salah. Coba akun demo yang tersedia.' };
  };

  const logout = () => {
    setCurrentUser(null);
    navigate('/');
  };

  const register = (name: string, email: string) => {
    const trimmed = email.trim().toLowerCase();
    if (users.some(u => u.email.toLowerCase() === trimmed)) {
      return { success: false, message: 'Email sudah terdaftar.' };
    }
    const newUser: User = {
      id: Date.now(),
      name,
      email: trimmed,
      role: 'member',
      email_verified_at: new Date().toISOString(),
    };
    const newMemberNumber = `NU-PKC-2026-${String(members.length + 1).padStart(3, '0')}`;
    const newMember: Member = {
      id: Date.now() + 1,
      user_id: newUser.id,
      member_number: newMemberNumber,
      nik: `330214${Math.floor(1000000000 + Math.random() * 9000000000)}`,
      birth_place: 'Banyumas',
      birth_date: '2000-01-01',
      gender: 'L',
      phone: '',
      address: 'Desa Pekuncen, Kec. Pekuncen, Kab. Banyumas',
      status: 'active',
    };

    setUsers(prev => [...prev, newUser]);
    setMembers(prev => [...prev, newMember]);
    setCurrentUser(newUser);
    navigate('/member/dashboard');
    return { success: true };
  };

  const currentMember = currentUser
    ? members.find(m => m.user_id === currentUser.id) || null
    : null;

  const updateMemberProfile = (data: Partial<Member>) => {
    if (!currentMember) return { success: false, message: 'Anggota tidak ditemukan.' };
    setMembers(prev =>
      prev.map(m => (m.id === currentMember.id ? { ...m, ...data } : m))
    );
    return { success: true, message: 'Profil anggota berhasil diperbarui.' };
  };

  const createNews = (newsItem: Omit<News, 'id' | 'author_id'>) => {
    const id = Date.now();
    const newNews: News = {
      ...newsItem,
      id,
      author_id: currentUser ? currentUser.id : 1,
      published_at: newsItem.status === 'published' ? new Date().toISOString() : null,
    };
    setNews(prev => [newNews, ...prev]);
    return { success: true, message: 'Berita berhasil diterbitkan.' };
  };

  const updateNews = (id: number, newsItem: Partial<News>) => {
    setNews(prev =>
      prev.map(n => {
        if (n.id === id) {
          const wasPublished = n.status === 'published';
          const isNowPublished = newsItem.status === 'published';
          return {
            ...n,
            ...newsItem,
            published_at:
              newsItem.status !== undefined
                ? isNowPublished
                  ? n.published_at || new Date().toISOString()
                  : null
                : n.published_at,
          };
        }
        return n;
      })
    );
    return { success: true, message: 'Berita berhasil diperbarui.' };
  };

  const deleteNews = (id: number) => {
    setNews(prev => prev.filter(n => n.id !== id));
    return { success: true, message: 'Berita berhasil dihapus.' };
  };

  const createCategory = (cat: Omit<NewsCategory, 'id'>) => {
    const id = Date.now();
    setCategories(prev => [...prev, { ...cat, id }]);
    return { success: true, message: 'Kategori berhasil ditambahkan.' };
  };

  const updateCategory = (id: number, cat: Partial<NewsCategory>) => {
    setCategories(prev => prev.map(c => (c.id === id ? { ...c, ...cat } : c)));
    return { success: true, message: 'Kategori berhasil diperbarui.' };
  };

  const deleteCategory = (id: number) => {
    const hasNews = news.some(n => n.category_id === id);
    if (hasNews) {
      return { success: false, message: 'Kategori ini masih digunakan oleh berita yang ada.' };
    }
    setCategories(prev => prev.filter(c => c.id !== id));
    return { success: true, message: 'Kategori berhasil dihapus.' };
  };

  const createMember = (memberData: {
    name: string;
    email: string;
    member_number: string;
    nik: string;
    birth_place: string;
    birth_date: string;
    gender: 'L' | 'P';
    phone?: string;
    address: string;
    photo?: string;
    status: 'active' | 'inactive';
  }) => {
    const userId = Date.now();
    const newUser: User = {
      id: userId,
      name: memberData.name,
      email: memberData.email,
      role: 'member',
      email_verified_at: new Date().toISOString(),
    };
    const newMember: Member = {
      id: Date.now() + 1,
      user_id: userId,
      member_number: memberData.member_number,
      nik: memberData.nik,
      birth_place: memberData.birth_place,
      birth_date: memberData.birth_date,
      gender: memberData.gender,
      phone: memberData.phone,
      address: memberData.address,
      photo: memberData.photo,
      status: memberData.status,
    };
    setUsers(prev => [...prev, newUser]);
    setMembers(prev => [...prev, newMember]);
    return { success: true, message: 'Anggota berhasil didaftarkan.' };
  };

  const updateMember = (id: number, memberData: Partial<Member> & { name?: string; email?: string }) => {
    const member = members.find(m => m.id === id);
    if (!member) return { success: false, message: 'Anggota tidak ditemukan.' };

    if (memberData.name || memberData.email) {
      setUsers(prev =>
        prev.map(u =>
          u.id === member.user_id
            ? {
                ...u,
                name: memberData.name || u.name,
                email: memberData.email || u.email,
              }
            : u
        )
      );
    }

    setMembers(prev =>
      prev.map(m => (m.id === id ? { ...m, ...memberData } : m))
    );
    return { success: true, message: 'Data anggota berhasil diperbarui.' };
  };

  const deleteMember = (id: number) => {
    const member = members.find(m => m.id === id);
    if (member) {
      setMembers(prev => prev.filter(m => m.id !== id));
      setUsers(prev => prev.filter(u => u.id !== member.user_id));
    }
    return { success: true, message: 'Anggota berhasil dihapus.' };
  };

  // Attach relational references dynamically
  const populatedNews = news.map(item => ({
    ...item,
    category: categories.find(c => c.id === item.category_id),
    author: users.find(u => u.id === item.author_id),
  }));

  const populatedMembers = members.map(m => ({
    ...m,
    user: users.find(u => u.id === m.user_id),
  }));

  const populatedCurrentMember = currentMember
    ? { ...currentMember, user: users.find(u => u.id === currentMember.user_id) }
    : null;

  return (
    <AppContext.Provider
      value={{
        currentUser,
        currentMember: populatedCurrentMember,
        users,
        members: populatedMembers,
        news: populatedNews,
        categories,
        darkMode,
        toggleDarkMode,
        login,
        logout,
        register,
        updateMemberProfile,
        createNews,
        updateNews,
        deleteNews,
        createCategory,
        updateCategory,
        deleteCategory,
        createMember,
        updateMember,
        deleteMember,
        currentRoute,
        navigate,
      }}
    >
      {children}
    </AppContext.Provider>
  );
};

export const useApp = () => {
  const context = useContext(AppContext);
  if (!context) throw new Error('useApp must be used within an AppProvider');
  return context;
};
