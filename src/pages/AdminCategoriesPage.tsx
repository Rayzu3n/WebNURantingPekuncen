import React, { useState } from 'react';
import { useApp } from '../context/AppContext';
import { AppLayout } from '../components/layout/AppLayout';
import { NewsCategory } from '../types';
import { Plus, Edit, Trash2, X, CheckCircle2, AlertCircle } from 'lucide-react';

export const AdminCategoriesPage: React.FC = () => {
  const { categories, news, createCategory, updateCategory, deleteCategory } = useApp();

  const [isModalOpen, setIsModalOpen] = useState(false);
  const [editingCategory, setEditingCategory] = useState<NewsCategory | null>(null);
  const [name, setName] = useState('');
  const [slug, setSlug] = useState('');
  const [notification, setNotification] = useState<{ type: 'success' | 'error'; message: string } | null>(null);

  const generateSlug = (text: string) => {
    return text
      .toLowerCase()
      .trim()
      .replace(/[^\w\s-]/g, '')
      .replace(/[\s_-]+/g, '-')
      .replace(/^-+|-+$/g, '');
  };

  const handleNameChange = (val: string) => {
    setName(val);
    if (!editingCategory) {
      setSlug(generateSlug(val));
    }
  };

  const openCreateModal = () => {
    setEditingCategory(null);
    setName('');
    setSlug('');
    setIsModalOpen(true);
  };

  const openEditModal = (cat: NewsCategory) => {
    setEditingCategory(cat);
    setName(cat.name);
    setSlug(cat.slug);
    setIsModalOpen(true);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (!name.trim() || !slug.trim()) {
      setNotification({ type: 'error', message: 'Nama kategori dan slug wajib diisi.' });
      return;
    }

    if (editingCategory) {
      const res = updateCategory(editingCategory.id, { name, slug });
      if (res.success) {
        setNotification({ type: 'success', message: 'Kategori berhasil diperbarui.' });
        setIsModalOpen(false);
      } else {
        setNotification({ type: 'error', message: res.message || 'Gagal memperbarui kategori.' });
      }
    } else {
      const res = createCategory({ name, slug });
      if (res.success) {
        setNotification({ type: 'success', message: 'Kategori berhasil ditambahkan.' });
        setIsModalOpen(false);
      } else {
        setNotification({ type: 'error', message: res.message || 'Gagal membuat kategori.' });
      }
    }
  };

  const handleDelete = (id: number, catName: string) => {
    if (window.confirm(`Hapus kategori "${catName}"?`)) {
      const res = deleteCategory(id);
      if (res.success) {
        setNotification({ type: 'success', message: 'Kategori berhasil dihapus.' });
      } else {
        setNotification({ type: 'error', message: res.message || 'Gagal menghapus kategori.' });
      }
    }
  };

  return (
    <AppLayout title="Kategori Berita" subtitle="Kelola taksonomi dan pengelompokan rubrik berita.">
      <div className="space-y-6">
        {notification && (
          <div
            className={`flex items-start gap-3 rounded-xl border p-4 text-sm shadow-sm ${
              notification.type === 'success'
                ? 'border-green-200 bg-green-50 text-green-800 dark:border-green-500/20 dark:bg-green-500/10 dark:text-green-300'
                : 'border-red-200 bg-red-50 text-red-800 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-300'
            }`}
          >
            {notification.type === 'success' ? (
              <CheckCircle2 className="mt-0.5 h-5 w-5 shrink-0" />
            ) : (
              <AlertCircle className="mt-0.5 h-5 w-5 shrink-0" />
            )}
            <span>{notification.message}</span>
          </div>
        )}

        <div className="flex justify-between items-center">
          <div>
            <h2 className="text-lg font-semibold text-gray-900 dark:text-white">
              Daftar Kategori ({categories.length})
            </h2>
          </div>
          <button
            type="button"
            onClick={openCreateModal}
            className="inline-flex items-center gap-2 rounded-xl bg-[#1C775A] px-4 py-2.5 text-sm font-semibold text-white shadow hover:bg-[#155A44] transition"
          >
            <Plus className="h-4 w-4" />
            Tambah Kategori
          </button>
        </div>

        {/* Categories Table */}
        <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow dark:border-gray-800 dark:bg-[#111827]">
          <div className="overflow-x-auto">
            <table className="w-full text-left text-sm text-gray-600 dark:text-gray-300">
              <thead className="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-900/50 dark:text-gray-400">
                <tr>
                  <th scope="col" className="px-6 py-4">Nama Kategori</th>
                  <th scope="col" className="px-6 py-4">Slug</th>
                  <th scope="col" className="px-6 py-4">Jumlah Berita</th>
                  <th scope="col" className="px-6 py-4 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-gray-200 dark:divide-gray-800">
                {categories.map(cat => {
                  const count = news.filter(n => n.category_id === cat.id).length;
                  return (
                    <tr key={cat.id} className="hover:bg-gray-50/50 dark:hover:bg-gray-800/40">
                      <td className="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                        {cat.name}
                      </td>
                      <td className="px-6 py-4 font-mono text-xs text-gray-500">
                        {cat.slug}
                      </td>
                      <td className="px-6 py-4">
                        <span className="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 dark:bg-blue-950 dark:text-blue-300">
                          {count} Berita
                        </span>
                      </td>
                      <td className="px-6 py-4 text-right space-x-2">
                        <button
                          type="button"
                          onClick={() => openEditModal(cat)}
                          title="Edit Kategori"
                          className="text-blue-600 hover:text-blue-800 dark:text-blue-400"
                        >
                          <Edit className="h-4 w-4 inline" />
                        </button>
                        <button
                          type="button"
                          onClick={() => handleDelete(cat.id, cat.name)}
                          title="Hapus Kategori"
                          className="text-red-600 hover:text-red-800 dark:text-red-400"
                        >
                          <Trash2 className="h-4 w-4 inline" />
                        </button>
                      </td>
                    </tr>
                  );
                })}
              </tbody>
            </table>
          </div>
        </div>

        {/* Modal Form */}
        {isModalOpen && (
          <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
            <div className="relative w-full max-w-md bg-white rounded-2xl shadow-xl dark:bg-[#181c1a] border border-gray-200 dark:border-gray-800">
              <div className="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-800">
                <h3 className="text-lg font-semibold text-gray-900 dark:text-white">
                  {editingCategory ? 'Edit Kategori' : 'Tambah Kategori'}
                </h3>
                <button
                  type="button"
                  onClick={() => setIsModalOpen(false)}
                  className="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                >
                  <X className="h-5 w-5" />
                </button>
              </div>

              <form onSubmit={handleSubmit} className="p-6 space-y-4">
                <div>
                  <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                    Nama Kategori
                  </label>
                  <input
                    type="text"
                    required
                    value={name}
                    onChange={e => handleNameChange(e.target.value)}
                    className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    placeholder="Contoh: Kajian & Pengajian"
                  />
                </div>

                <div>
                  <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                    Slug
                  </label>
                  <input
                    type="text"
                    required
                    value={slug}
                    onChange={e => setSlug(e.target.value)}
                    className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white font-mono text-xs"
                    placeholder="kajian-pengajian"
                  />
                </div>

                <div className="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-800">
                  <button
                    type="button"
                    onClick={() => setIsModalOpen(false)}
                    className="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-gray-800 dark:text-gray-400"
                  >
                    Batal
                  </button>
                  <button
                    type="submit"
                    className="px-5 py-2 text-sm font-semibold text-white bg-[#1C775A] hover:bg-[#155A44] rounded-xl transition shadow"
                  >
                    {editingCategory ? 'Simpan Perubahan' : 'Tambahkan'}
                  </button>
                </div>
              </form>
            </div>
          </div>
        )}
      </div>
    </AppLayout>
  );
};
