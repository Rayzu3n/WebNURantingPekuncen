export type UserRole = 'admin' | 'member';

export interface User {
  id: number;
  name: string;
  email: string;
  role: UserRole;
  password?: string;
  email_verified_at?: string | null;
}

export interface Member {
  id: number;
  user_id: number;
  member_number: string;
  nik: string;
  birth_place: string;
  birth_date: string;
  gender: 'L' | 'P';
  phone?: string;
  address: string;
  photo?: string;
  status: 'active' | 'inactive';
  user?: User;
}

export interface NewsCategory {
  id: number;
  name: string;
  slug: string;
}

export interface News {
  id: number;
  category_id: number;
  author_id: number;
  title: string;
  slug: string;
  excerpt: string;
  content: string;
  thumbnail: string;
  status: 'published' | 'draft' | 'archived';
  published_at: string | null;
  category?: NewsCategory;
  author?: User;
}
