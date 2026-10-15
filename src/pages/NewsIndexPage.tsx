import React, { useState } from 'react';
import { useApp } from '../context/AppContext';
import { PublicLayout } from '../components/layout/PublicLayout';
import { Search, Filter } from 'lucide-react';

export const NewsIndexPage: React.FC = () => {
  const { news, categories, navigate } = useApp();
  const [searchQuery, setSearchQuery] = useState('');
  const [selectedCategory, setSelectedCategory] = useState<string>('all');
  const [currentPage, setCurrentPage] = useState(1);
  const itemsPerPage = 6;

  // Filter published news
  const publishedNews = news
    .filter(item => item.status === 'published')
    .sort((a, b) => {
      const dateA = a.published_at ? new Date(a.published_at).getTime() : 0;
      const dateB = b.published_at ? new Date(b.published_at).getTime() : 0;
      return dateB - dateA;
    });

  const filteredNews = publishedNews.filter(item => {
    const matchesSearch =
      item.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
      item.excerpt.toLowerCase().includes(searchQuery.toLowerCase()) ||
      item.content.toLowerCase().includes(searchQuery.toLowerCase());

    const matchesCategory =
      selectedCategory === 'all' || item.category?.slug === selectedCategory;

    return matchesSearch && matchesCategory;
  });

  const totalPages = Math.ceil(filteredNews.length / itemsPerPage);
  const paginatedNews = filteredNews.slice(
    (currentPage - 1) * itemsPerPage,
    currentPage * itemsPerPage
  );

  const formatDate = (dateStr?: string | null) => {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    return date.toLocaleDateString('id-ID', {
      day: 'numeric',
      month: 'short',
      year: 'numeric',
    });
  };

  return (
    <PublicLayout>
      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">
        {/* Page Header */}
        <section className="border-b-2 border-[#2ec486] pb-5">
          <p className="font-interface text-[10px] font-bold uppercase tracking-[0.12em] text-[#1C775A] dark:text-[#53e0a0]">
            Portal Berita
          </p>

          <h1 className="mt-2 font-editorial text-4xl lg:text-5xl font-semibold tracking-[-0.02em] text-[#15201B] dark:text-[#e0e3df]">
            Berita
          </h1>

          <p className="mt-3 max-w-2xl font-interface text-sm leading-6 text-[#68746e] dark:text-[#929e97]">
            Informasi dan berita terbaru dari lingkungan Pengurus Ranting Nahdlatul Ulama Pekuncen.
          </p>
        </section>

        {/* Filter & Search Bar */}
        <section className="mt-8 flex flex-col md:flex-row gap-4 items-stretch md:items-center justify-between">
          {/* Category Tabs */}
          <div className="flex flex-wrap gap-2 items-center">
            <span className="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mr-1">
              <Filter className="h-3.5 w-3.5" /> Kategori:
            </span>
            <button
              type="button"
              onClick={() => {
                setSelectedCategory('all');
                setCurrentPage(1);
              }}
              className={`px-3 py-1.5 rounded-lg text-xs font-semibold transition ${
                selectedCategory === 'all'
                  ? 'bg-[#1C775A] text-white shadow-sm'
                  : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700'
              }`}
            >
              Semua
            </button>
            {categories.map(c => (
              <button
                key={c.id}
                type="button"
                onClick={() => {
                  setSelectedCategory(c.slug);
                  setCurrentPage(1);
                }}
                className={`px-3 py-1.5 rounded-lg text-xs font-semibold transition ${
                  selectedCategory === c.slug
                    ? 'bg-[#1C775A] text-white shadow-sm'
                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700'
                }`}
              >
                {c.name}
              </button>
            ))}
          </div>

          {/* Search Input */}
          <div className="relative min-w-[240px]">
            <Search className="absolute left-3 top-2.5 h-4 w-4 text-gray-400" />
            <input
              type="text"
              value={searchQuery}
              onChange={e => {
                setSearchQuery(e.target.value);
                setCurrentPage(1);
              }}
              placeholder="Cari berita..."
              className="w-full pl-9 pr-4 py-1.5 text-sm rounded-lg border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-[#1C775A] dark:border-gray-700 dark:bg-[#181c1a] dark:text-gray-200"
            />
          </div>
        </section>

        {/* News List */}
        {paginatedNews.length > 0 ? (
          <section className="mt-8">
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              {paginatedNews.map(item => (
                <article
                  key={item.id}
                  className="group flex flex-col overflow-hidden rounded-xl border border-[#d9ddd9] bg-white transition-all duration-300 hover:-translate-y-0.5 hover:border-[#2ec486]/70 hover:shadow-lg dark:border-[#2b312d] dark:bg-[#181c1a]"
                >
                  {/* Thumbnail */}
                  {item.thumbnail && (
                    <div
                      onClick={() => navigate(`/berita/${item.slug}`)}
                      className="block overflow-hidden cursor-pointer"
                    >
                      <div className="aspect-[16/10] overflow-hidden">
                        <img
                          src={item.thumbnail}
                          alt={item.title}
                          className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.025]"
                        />
                      </div>
                    </div>
                  )}

                  {/* Content */}
                  <div className="flex flex-col flex-1 p-5">
                    <div className="flex items-center gap-2">
                      <span className="font-interface text-[10px] font-bold uppercase tracking-[0.1em] text-[#1C775A] dark:text-[#53e0a0]">
                        {item.category?.name || 'Berita'}
                      </span>
                      <span className="text-gray-400 dark:text-gray-600">•</span>
                      <span className="font-interface text-xs text-[#6b7771] dark:text-[#889990]">
                        {formatDate(item.published_at)}
                      </span>
                    </div>

                    <h2 className="mt-3 font-editorial text-2xl leading-tight font-semibold text-[#15201B] dark:text-[#e0e3df]">
                      <button
                        type="button"
                        onClick={() => navigate(`/berita/${item.slug}`)}
                        className="text-left transition-colors group-hover:text-[#1C775A] dark:group-hover:text-[#53e0a0]"
                      >
                        {item.title}
                      </button>
                    </h2>

                    {item.excerpt && (
                      <p className="mt-3 font-interface text-sm leading-6 text-[#5f6b65] dark:text-[#889990]">
                        {item.excerpt.length > 140
                          ? item.excerpt.substring(0, 140) + '...'
                          : item.excerpt}
                      </p>
                    )}

                    <div className="mt-auto pt-5 border-t border-[#d9ddd9] dark:border-[#2b312d]">
                      <div className="flex items-center justify-between gap-3">
                        <span className="font-interface text-xs font-medium text-[#5f6b65] dark:text-[#889990]">
                          {item.author?.name || 'Admin Redaksi'}
                        </span>

                        <button
                          type="button"
                          onClick={() => navigate(`/berita/${item.slug}`)}
                          className="font-interface text-xs font-semibold text-[#1C775A] dark:text-[#53e0a0]"
                        >
                          Baca berita →
                        </button>
                      </div>
                    </div>
                  </div>
                </article>
              ))}
            </div>

            {/* Pagination */}
            {totalPages > 1 && (
              <div className="mt-10 flex justify-center gap-2">
                <button
                  type="button"
                  disabled={currentPage === 1}
                  onClick={() => setCurrentPage(prev => Math.max(prev - 1, 1))}
                  className="px-3 py-1 rounded-md border border-gray-300 text-sm font-medium disabled:opacity-50 dark:border-gray-700"
                >
                  Sebelumnya
                </button>
                {Array.from({ length: totalPages }).map((_, i) => (
                  <button
                    key={i}
                    type="button"
                    onClick={() => setCurrentPage(i + 1)}
                    className={`px-3 py-1 rounded-md text-sm font-medium ${
                      currentPage === i + 1
                        ? 'bg-[#1C775A] text-white'
                        : 'border border-gray-300 dark:border-gray-700'
                    }`}
                  >
                    {i + 1}
                  </button>
                ))}
                <button
                  type="button"
                  disabled={currentPage === totalPages}
                  onClick={() => setCurrentPage(prev => Math.min(prev + 1, totalPages))}
                  className="px-3 py-1 rounded-md border border-gray-300 text-sm font-medium disabled:opacity-50 dark:border-gray-700"
                >
                  Selanjutnya
                </button>
              </div>
            )}
          </section>
        ) : (
          <section className="mt-8">
            <div className="rounded-xl border border-[#d9ddd9] p-10 text-center dark:border-[#2b312d]">
              <p className="font-interface text-sm text-[#68746e] dark:text-[#929e97]">
                Tidak ada berita yang sesuai dengan pencarian atau kategori ini.
              </p>
            </div>
          </section>
        )}
      </main>
    </PublicLayout>
  );
};
