import React from 'react';
import { useApp } from '../context/AppContext';
import { PublicLayout } from '../components/layout/PublicLayout';

interface NewsDetailPageProps {
  slug: string;
}

export const NewsDetailPage: React.FC<NewsDetailPageProps> = ({ slug }) => {
  const { news, navigate } = useApp();

  const article = news.find(n => n.slug === slug);

  if (!article) {
    return (
      <PublicLayout>
        <div className="max-w-3xl mx-auto px-4 py-20 text-center">
          <h1 className="text-3xl font-bold font-editorial text-gray-900 dark:text-white">
            Berita Tidak Ditemukan
          </h1>
          <p className="mt-4 text-gray-600 dark:text-gray-400">
            Maaf, berita yang Anda cari mungkin sudah dipindahkan atau dihapus.
          </p>
          <button
            type="button"
            onClick={() => navigate('/berita')}
            className="mt-6 inline-flex items-center px-4 py-2 rounded-lg bg-[#1C775A] text-white font-medium hover:bg-[#155A44] transition"
          >
            ← Kembali ke Daftar Berita
          </button>
        </div>
      </PublicLayout>
    );
  }

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
      <main className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">
        <article>
          <div className="max-w-4xl">
            {/* Meta */}
            <div className="flex flex-wrap items-center gap-2">
              <span className="font-interface text-[10px] font-bold uppercase tracking-[0.1em] text-[#1C775A] dark:text-[#53e0a0]">
                {article.category?.name || 'Berita'}
              </span>

              <span className="text-gray-400 dark:text-gray-600">•</span>

              <span className="font-interface text-xs text-[#6b7771] dark:text-[#889990]">
                {formatDateTime(article.published_at)}
              </span>
            </div>

            {/* Title */}
            <h1 className="mt-5 font-editorial text-4xl sm:text-5xl lg:text-6xl leading-[1.05] font-semibold tracking-[-0.025em] text-[#15201B] dark:text-[#e0e3df]">
              {article.title}
            </h1>

            {/* Excerpt */}
            {article.excerpt && (
              <p className="mt-6 max-w-3xl font-editorial text-xl leading-8 text-[#5b6761] dark:text-[#abb6ae]">
                {article.excerpt}
              </p>
            )}

            {/* Author */}
            <div className="mt-7 pt-5 border-t border-[#d9ddd9] dark:border-[#2b312d]">
              <div className="flex items-center gap-3">
                <div className="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#2ec486] font-interface text-xs font-bold text-[#003822]">
                  {(article.author?.name || 'NU').substring(0, 2).toUpperCase()}
                </div>

                <div>
                  <p className="font-interface text-sm font-semibold text-[#15201B] dark:text-[#e0e3df]">
                    {article.author?.name || 'Admin Redaksi'}
                  </p>
                  <p className="mt-0.5 font-interface text-xs text-[#6b7771] dark:text-[#889990]">
                    Dipublikasikan pada {formatDateTime(article.published_at)}
                  </p>
                </div>
              </div>
            </div>
          </div>

          {/* Featured Image */}
          {article.thumbnail && (
            <div className="mt-8 overflow-hidden rounded-xl border border-[#d9ddd9] dark:border-[#2b312d]">
              <img
                src={article.thumbnail}
                alt={article.title}
                className="w-full max-h-[650px] object-cover"
              />
            </div>
          )}

          {/* Article Content */}
          <div className="mt-10 max-w-4xl">
            <div className="font-editorial text-lg sm:text-xl leading-8 sm:leading-9 text-[#27332d] dark:text-[#d0d8d2] space-y-6 whitespace-pre-line">
              {article.content}
            </div>
          </div>

          {/* Back */}
          <div className="mt-10 pt-6 border-t border-[#d9ddd9] dark:border-[#2b312d]">
            <button
              type="button"
              onClick={() => navigate('/berita')}
              className="inline-flex items-center gap-2 font-interface text-sm font-semibold text-[#1C775A] hover:text-[#155A44] dark:text-[#53e0a0] dark:hover:text-[#71fcb8]"
            >
              ← Kembali ke berita
            </button>
          </div>
        </article>
      </main>
    </PublicLayout>
  );
};
