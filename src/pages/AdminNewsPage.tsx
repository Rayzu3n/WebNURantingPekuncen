import React, { useState } from 'react';
import { useApp } from '../context/AppContext';
import { AppLayout } from '../components/layout/AppLayout';
import { News } from '../types';
import { Plus, Edit, Trash2, ExternalLink, X, CheckCircle2, AlertCircle } from 'lucide-react';

export const AdminNewsPage: React.FC = () => {
  const { news, categories, createNews, updateNews, deleteNews, navigate } = useApp();

  const [isModalOpen, setIsModalOpen] = useState(false);
  const [editingNews, setEditingNews] = useState<News | null>(null);

  const [title, setTitle] = useState('');
  const [slug, setSlug] = useState('');
  const [categoryId, setCategoryId] = useState<number>(categories[0]?.id || 1);
  const [excerpt, setExcerpt] = useState('');
  const [content, setContent] = useState('');
  const [thumbnail, setThumbnail] = useState('');
  const [status, setStatus] = useState<'draft' | 'published' | 'archived'>('published');
  const [notification, setNotification] = useState<{ type: 'success' | 'error'; message: string } | null>(null);

  const generateSlug = (text: string) => {
    return text
      .toLowerCase()
      .trim()
      .replace(/[^\w\s-]/g, '')
      .replace(/[\s_-]+/g, '-')
      .replace(/^-+|-+$/g, '');
  };

  const handleTitleChange = (val: string) => {
    setTitle(val);
    if (!editingNews) {
      setSlug(generateSlug(val));
    }
  };

  const openCreateModal = () => {
    setEditingNews(null);
    setTitle('');
    setSlug('');
    setCategoryId(categories[0]?.id || 1);
    setExcerpt('');
    setContent('');
    setThumbnail('https://images.unsplash.com/photo-1542816417-0983c9c9ad53?auto=format&fit=crop&w=800&q=80');
    setStatus('published');
    setIsModalOpen(true);
  };

  const openEditModal = (item: News) => {
    setEditingNews(item);
    setTitle(item.title);
    setSlug(item.slug);
    setCategoryId(item.category_id);
    setExcerpt(item.excerpt);
    setContent(item.content);
    setThumbnail(item.thumbnail);
    setStatus(item.status);
    setIsModalOpen(true);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (!title.trim() || !slug.trim() || !content.trim()) {
      setNotification({ type: 'error', message: 'Judul, slug, dan konten berita wajib diisi.' });
      return;
    }

    if (editingNews) {
      const res = updateNews(editingNews.id, {
        title,
        slug,
        category_id: categoryId,
        excerpt,
        content,
        thumbnail,
        status,
      });
      if (res.success) {
        setNotification({ type: 'success', message: 'Berita berhasil diperbarui.' });
        setIsModalOpen(false);
      }
    } else {
      const res = createNews({
        title,
        slug,
        category_id: categoryId,
        excerpt,
        content,
        thumbnail,
        status,
        published_at: status === 'published' ? new Date().toISOString() : null,
      });
      if (res.success) {
        setNotification({ type: 'success', message: 'Berita baru berhasil ditambahkan.' });
        setIsModalOpen(false);
      }
    }
  };

  const handleDelete = (id: number, title: string) => {
    if (window.confirm(`Apakah Anda yakin ingin menghapus berita "${title}"?`)) {
      const res = deleteNews(id);
      if (res.success) {
        setNotification({ type: 'success', message: 'Berita berhasil dihapus.' });
      }
    }
  };

  const handlePhotoUpload = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      const reader = new FileReader();
      reader.onloadend = () => {
        setThumbnail(reader.result as string);
      };
      reader.readAsDataURL(file);
    }
  };

  return (
    <AppLayout title="Kelola Berita" subtitle="Manajemen artikel, berita ranting, dan publikasi portal.">
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
              Daftar Artikel Berita ({news.length})
            </h2>
          </div>
          <button
            type="button"
            onClick={openCreateModal}
            className="inline-flex items-center gap-2 rounded-xl bg-[#1C775A] px-4 py-2.5 text-sm font-semibold text-white shadow hover:bg-[#155A44] transition"
          >
            <Plus className="h-4 w-4" />
            Tambah Berita Baru
          </button>
        </div>

        {/* News Table */}
        <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow dark:border-gray-800 dark:bg-[#111827]">
          <div className="overflow-x-auto">
            <table className="w-full text-left text-sm text-gray-600 dark:text-gray-300">
              <thead className="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-900/50 dark:text-gray-400">
                <tr>
                  <th scope="col" className="px-6 py-4">Thumbnail</th>
                  <th scope="col" className="px-6 py-4">Judul</th>
                  <th scope="col" className="px-6 py-4">Kategori</th>
                  <th scope="col" className="px-6 py-4">Penulis</th>
                  <th scope="col" className="px-6 py-4">Status</th>
                  <th scope="col" className="px-6 py-4 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-gray-200 dark:divide-gray-800">
                {news.map(item => (
                  <tr key={item.id} className="hover:bg-gray-50/50 dark:hover:bg-gray-800/40">
                    <td className="px-6 py-4">
                      {item.thumbnail ? (
                        <img
                          src={item.thumbnail}
                          alt=""
                          className="h-12 w-16 object-cover rounded-lg border border-gray-200 dark:border-gray-700"
                        />
                      ) : (
                        <div className="h-12 w-16 bg-gray-100 rounded-lg flex items-center justify-center text-xs text-gray-400 dark:bg-gray-800">
                          No Pic
                        </div>
                      )}
                    </td>
                    <td className="px-6 py-4 max-w-xs">
                      <div className="font-semibold text-gray-900 dark:text-white truncate">
                        {item.title}
                      </div>
                      <div className="text-xs text-gray-400 truncate">/berita/{item.slug}</div>
                    </td>
                    <td className="px-6 py-4">
                      <span className="inline-flex rounded-md bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                        {item.category?.name || 'Umum'}
                      </span>
                    </td>
                    <td className="px-6 py-4 text-xs">
                      {item.author?.name || 'Admin'}
                    </td>
                    <td className="px-6 py-4">
                      <span
                        className={`inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold ${
                          item.status === 'published'
                            ? 'bg-green-100 text-green-800 dark:bg-green-950/60 dark:text-green-300'
                            : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-950/60 dark:text-yellow-300'
                        }`}
                      >
                        {item.status === 'published' ? 'Published' : 'Draft'}
                      </span>
                    </td>
                    <td className="px-6 py-4 text-right space-x-2">
                      <button
                        type="button"
                        onClick={() => navigate(`/berita/${item.slug}`)}
                        title="Lihat Berita"
                        className="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                      >
                        <ExternalLink className="h-4 w-4 inline" />
                      </button>
                      <button
                        type="button"
                        onClick={() => openEditModal(item)}
                        title="Edit Berita"
                        className="text-blue-600 hover:text-blue-800 dark:text-blue-400"
                      >
                        <Edit className="h-4 w-4 inline" />
                      </button>
                      <button
                        type="button"
                        onClick={() => handleDelete(item.id, item.title)}
                        title="Hapus Berita"
                        className="text-red-600 hover:text-red-800 dark:text-red-400"
                      >
                        <Trash2 className="h-4 w-4 inline" />
                      </button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>

        {/* Modal Form */}
        {isModalOpen && (
          <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm overflow-y-auto">
            <div className="relative w-full max-w-2xl bg-white rounded-2xl shadow-xl dark:bg-[#181c1a] border border-gray-200 dark:border-gray-800 my-8">
              <div className="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-800">
                <h3 className="text-lg font-semibold text-gray-900 dark:text-white">
                  {editingNews ? 'Edit Berita' : 'Tulis Berita Baru'}
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
                    Judul Berita
                  </label>
                  <input
                    type="text"
                    required
                    value={title}
                    onChange={e => handleTitleChange(e.target.value)}
                    className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    placeholder="Contoh: Pengajian Rutin Lailatul Ijtima'..."
                  />
                </div>

                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                    <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                      Slug URL
                    </label>
                    <input
                      type="text"
                      required
                      value={slug}
                      onChange={e => setSlug(e.target.value)}
                      className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white font-mono text-xs"
                      placeholder="pengajian-rutin-lailatul-ijtima"
                    />
                  </div>

                  <div>
                    <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                      Kategori
                    </label>
                    <select
                      value={categoryId}
                      onChange={e => setCategoryId(Number(e.target.value))}
                      className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    >
                      {categories.map(c => (
                        <option key={c.id} value={c.id}>
                          {c.name}
                        </option>
                      ))}
                    </select>
                  </div>
                </div>

                <div>
                  <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                    Ringkasan (Excerpt)
                  </label>
                  <textarea
                    rows={2}
                    value={excerpt}
                    onChange={e => setExcerpt(e.target.value)}
                    className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    placeholder="Ringkasan singkat berita untuk ditampilkan di kartu cuplikan..."
                  />
                </div>

                <div>
                  <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                    Isi Berita Lengkap
                  </label>
                  <textarea
                    rows={6}
                    required
                    value={content}
                    onChange={e => setContent(e.target.value)}
                    className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    placeholder="Tuliskan berita lengkap di sini..."
                  />
                </div>

                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                  <div>
                    <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                      Foto Thumbnail (URL atau Unggah)
                    </label>
                    <input
                      type="text"
                      value={thumbnail}
                      onChange={e => setThumbnail(e.target.value)}
                      placeholder="https://..."
                      className="w-full rounded-xl border border-gray-300 p-2 text-xs mb-2 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    />
                    <input
                      type="file"
                      accept="image/*"
                      onChange={handlePhotoUpload}
                      className="text-xs text-gray-500"
                    />
                  </div>

                  <div>
                    <label className="block text-xs font-semibold uppercase text-gray-600 dark:text-gray-400 mb-1">
                      Status Publikasi
                    </label>
                    <select
                      value={status}
                      onChange={e => setStatus(e.target.value as 'draft' | 'published' | 'archived')}
                      className="w-full rounded-xl border border-gray-300 p-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                    >
                      <option value="published">Diterbitkan (Published)</option>
                      <option value="draft">Draf (Draft)</option>
                    </select>
                  </div>
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
                    {editingNews ? 'Simpan Perubahan' : 'Terbitkan Berita'}
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
