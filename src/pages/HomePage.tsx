import React from 'react';
import { useApp } from '../context/AppContext';
import { PublicLayout } from '../components/layout/PublicLayout';

export const HomePage: React.FC = () => {
  const { news, categories, navigate } = useApp();

  const publishedNews = news
    .filter(item => item.status === 'published')
    .sort((a, b) => {
      const dateA = a.published_at ? new Date(a.published_at).getTime() : 0;
      const dateB = b.published_at ? new Date(b.published_at).getTime() : 0;
      return dateB - dateA;
    });

  const featuredNews = publishedNews.length > 0 ? publishedNews[0] : null;
  const latestNews = featuredNews
    ? publishedNews.filter(n => n.id !== featuredNews.id).slice(0, 6)
    : publishedNews.slice(0, 6);

  const formatDate = (dateStr?: string | null) => {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    return date.toLocaleDateString('id-ID', {
      day: 'numeric',
      month: 'short',
      year: 'numeric',
    });
  };

  const formatDateTime = (dateStr?: string | null) => {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    return (
      date.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
      }) +
      ' ' +
      date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
    );
  };

  return (
    <PublicLayout>
      {/* Breaking News Ticker */}
      {publishedNews.length > 0 && (
        <section className="border-b border-[#d9ddd9] dark:border-[#2b312d]">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="flex items-center gap-4 py-3">
              <span className="shrink-0 rounded-md bg-[#1C775A] px-3 py-1.5 font-interface text-[10px] font-bold uppercase tracking-[0.12em] text-white">
                TERKINI
              </span>

              <button
                type="button"
                onClick={() => navigate(`/berita/${publishedNews[0].slug}`)}
                className="min-w-0 truncate text-left font-interface text-sm text-[#4A5550] transition-colors hover:text-[#1C775A] dark:text-[#b8c1bb] dark:hover:text-[#53e0a0]"
              >
                {publishedNews[0].title}
              </button>
            </div>
          </div>
        </section>
      )}

      {/* Main Content */}
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Hero Section */}
        {featuredNews && (
          <section className="py-8 lg:py-12">
            <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
              {/* Hero Image */}
              <div className="lg:col-span-8">
                {featuredNews.thumbnail ? (
                  <div
                    onClick={() => navigate(`/berita/${featuredNews.slug}`)}
                    className="group block cursor-pointer"
                  >
                    <div className="relative overflow-hidden rounded-xl border border-[#d9ddd9] bg-[#eef2ef] dark:border-[#2b312d] dark:bg-[#181c1a]">
                      <div className="aspect-[16/9] overflow-hidden">
                        <img
                          src={featuredNews.thumbnail}
                          alt={featuredNews.title}
                          className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.025]"
                        />
                      </div>
                      <div className="absolute top-4 left-4">
                        <span className="rounded-md bg-[#15201B]/85 px-3 py-1.5 font-interface text-[10px] font-bold uppercase tracking-[0.1em] text-white">
                          Berita Utama
                        </span>
                      </div>
                    </div>
                  </div>
                ) : (
                  <div className="aspect-[16/9] rounded-xl border border-[#d9ddd9] bg-[#eef2ef] flex items-center justify-center dark:border-[#2b312d] dark:bg-[#181c1a]">
                    <span className="font-interface text-sm text-gray-500 dark:text-gray-400">
                      Tidak ada gambar
                    </span>
                  </div>
                )}
              </div>

              {/* Hero Information */}
              <div className="lg:col-span-4 flex flex-col justify-center">
                <div className="flex items-center gap-2">
                  <span className="font-interface text-[10px] font-bold uppercase tracking-[0.12em] text-[#1C775A] dark:text-[#53e0a0]">
                    {featuredNews.category?.name || 'Kegiatan'}
                  </span>
                  <span className="text-gray-400 dark:text-gray-600">•</span>
                  <span className="font-interface text-xs text-[#6b7771] dark:text-[#889990]">
                    {formatDate(featuredNews.published_at)}
                  </span>
                </div>

                <h1 className="mt-4 font-editorial text-4xl leading-[1.08] font-semibold tracking-[-0.02em] text-[#15201B] dark:text-[#e0e3df] lg:text-[44px]">
                  <button
                    type="button"
                    onClick={() => navigate(`/berita/${featuredNews.slug}`)}
                    className="text-left transition-colors hover:text-[#1C775A] dark:hover:text-[#53e0a0]"
                  >
                    {featuredNews.title}
                  </button>
                </h1>

                {featuredNews.excerpt && (
                  <p className="mt-5 font-editorial text-lg leading-8 text-[#5b6761] dark:text-[#abb6ae]">
                    {featuredNews.excerpt}
                  </p>
                )}

                <div className="mt-7 pt-5 border-t border-[#d9ddd9] dark:border-[#2b312d]">
                  <div className="flex items-center gap-3">
                    <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#2ec486] font-interface text-xs font-bold text-[#003822]">
                      {(featuredNews.author?.name || 'NU').substring(0, 2).toUpperCase()}
                    </div>
                    <div>
                      <p className="font-interface text-sm font-semibold text-[#15201B] dark:text-[#e0e3df]">
                        {featuredNews.author?.name || 'Admin Redaksi'}
                      </p>
                      <p className="mt-0.5 font-interface text-xs text-[#6b7771] dark:text-[#889990]">
                        {formatDateTime(featuredNews.published_at)}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        )}

        {/* Latest News Section */}
        <section className="pb-12 lg:pb-16">
          <div className="flex items-end justify-between gap-4 border-b-2 border-[#2ec486] pb-3">
            <div>
              <p className="font-interface text-[10px] font-bold uppercase tracking-[0.12em] text-[#1C775A] dark:text-[#53e0a0]">
                Portal Berita
              </p>
              <h2 className="mt-1 font-editorial text-3xl font-semibold tracking-[-0.015em] text-[#15201B] dark:text-[#e0e3df]">
                Berita Terkini
              </h2>
            </div>

            <button
              type="button"
              onClick={() => navigate('/berita')}
              className="hidden sm:inline-flex font-interface text-sm font-semibold text-[#1C775A] transition-colors hover:text-[#155A44] dark:text-[#53e0a0] dark:hover:text-[#71fcb8]"
            >
              Lihat semua →
            </button>
          </div>

          {latestNews.length > 0 ? (
            <div className="mt-7 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              {latestNews.map(item => (
                <article
                  key={item.id}
                  className="group overflow-hidden rounded-xl border border-[#d9ddd9] bg-white transition-all duration-300 hover:-translate-y-0.5 hover:border-[#2ec486]/60 hover:shadow-lg dark:border-[#2b312d] dark:bg-[#181c1a]"
                >
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

                  <div className="p-5">
                    <div className="flex items-center gap-2">
                      <span className="font-interface text-[10px] font-bold uppercase tracking-[0.1em] text-[#1C775A] dark:text-[#53e0a0]">
                        {item.category?.name || 'Berita'}
                      </span>
                      <span className="text-gray-400 dark:text-gray-600">•</span>
                      <span className="font-interface text-xs text-[#6b7771] dark:text-[#889990]">
                        {formatDate(item.published_at)}
                      </span>
                    </div>

                    <h3 className="mt-3 font-editorial text-2xl leading-tight font-semibold text-[#15201B] dark:text-[#e0e3df]">
                      <button
                        type="button"
                        onClick={() => navigate(`/berita/${item.slug}`)}
                        className="text-left transition-colors group-hover:text-[#1C775A] dark:group-hover:text-[#53e0a0]"
                      >
                        {item.title}
                      </button>
                    </h3>

                    {item.excerpt && (
                      <p className="mt-3 font-interface text-sm leading-6 text-[#5f6b65] dark:text-[#889990]">
                        {item.excerpt.length > 120
                          ? item.excerpt.substring(0, 120) + '...'
                          : item.excerpt}
                      </p>
                    )}

                    <div className="mt-5 flex items-center justify-between gap-3 border-t border-[#d9ddd9] pt-4 dark:border-[#2b312d]">
                      <span className="font-interface text-xs font-medium text-[#5f6b65] dark:text-[#889990]">
                        {item.author?.name || 'Admin Redaksi'}
                      </span>

                      <button
                        type="button"
                        onClick={() => navigate(`/berita/${item.slug}`)}
                        className="font-interface text-xs font-semibold text-[#1C775A] dark:text-[#53e0a0]"
                      >
                        Baca →
                      </button>
                    </div>
                  </div>
                </article>
              ))}
            </div>
          ) : (
            <div className="mt-7 rounded-xl border border-[#d9ddd9] p-10 text-center dark:border-[#2b312d]">
              <p className="font-interface text-sm text-gray-500 dark:text-gray-400">
                Belum ada berita yang dipublikasikan.
              </p>
            </div>
          )}

          <div className="mt-7 sm:hidden">
            <button
              type="button"
              onClick={() => navigate('/berita')}
              className="font-interface text-sm font-semibold text-[#1C775A] dark:text-[#53e0a0]"
            >
              Lihat semua berita →
            </button>
          </div>
        </section>

        {/* Categories Section */}
        <section className="pb-16">
          <div className="border-t border-[#d9ddd9] pt-8 dark:border-[#2b312d]">
            <div className="mb-6">
              <p className="font-interface text-[10px] font-bold uppercase tracking-[0.12em] text-[#1C775A] dark:text-[#53e0a0]">
                Jelajahi
              </p>
              <h2 className="mt-1 font-editorial text-2xl font-semibold text-[#15201B] dark:text-[#e0e3df]">
                Kategori Berita
              </h2>
            </div>

            <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
              {categories.map(category => (
                <button
                  key={category.id}
                  type="button"
                  onClick={() => navigate(`/berita?kategori=${category.slug}`)}
                  className="group flex items-center justify-between rounded-lg border border-[#d9ddd9] bg-[#f8faf8] px-4 py-4 text-left transition-colors hover:border-[#2ec486] hover:bg-[#f0f7f3] dark:border-[#2b312d] dark:bg-[#181c1a] dark:hover:bg-[#1c201e]"
                >
                  <span className="font-interface text-sm font-semibold text-[#3f4b45] group-hover:text-[#1C775A] dark:text-[#c0c9c3] dark:group-hover:text-[#53e0a0]">
                    {category.name}
                  </span>
                  <span className="text-[#1C775A] transition-transform group-hover:translate-x-1 dark:text-[#53e0a0]">
                    →
                  </span>
                </button>
              ))}
            </div>
          </div>
        </section>
      </div>
    </PublicLayout>
  );
};
