<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', env('ADMIN_EMAIL', 'admin@example.com'))->first();

        if (! $admin) {
            throw new RuntimeException('Admin user was not found. Run AdminUserSeeder first.');
        }

        $warta = NewsCategory::where('slug', 'warta')->firstOrFail();
        $kegiatan = NewsCategory::where('slug', 'kegiatan')->firstOrFail();
        $pengumuman = NewsCategory::where('slug', 'pengumuman')->firstOrFail();

        $articles = [
            [
                'category_id' => $warta->id,
                'title' => 'Selamat Datang di Portal Berita NU Ranting Pekuncen',
                'slug' => 'selamat-datang-portal-berita-nu-ranting-pekuncen',
                'excerpt' => 'Portal informasi dan berita untuk mendokumentasikan kabar, kegiatan, dan pengumuman warga.',
                'content' => "Selamat datang di Portal Berita NU Ranting Pekuncen.\n\nPortal ini disiapkan sebagai tempat publikasi informasi, dokumentasi kegiatan, dan pengumuman yang berkaitan dengan aktivitas organisasi.\n\nKonten ini merupakan artikel awal contoh. Silakan sunting melalui dashboard admin agar sesuai dengan informasi resmi yang akan dipublikasikan.",
            ],
            [
                'category_id' => $kegiatan->id,
                'title' => 'Dokumentasi Kegiatan Organisasi',
                'slug' => 'dokumentasi-kegiatan-organisasi',
                'excerpt' => 'Gunakan portal ini untuk membagikan dokumentasi kegiatan dan informasi pelaksanaannya.',
                'content' => "Halaman ini merupakan contoh berita untuk kategori Kegiatan.\n\nLengkapi artikel dengan nama kegiatan, tanggal, lokasi, penyelenggara, serta dokumentasi yang sudah diverifikasi sebelum dipublikasikan sebagai berita resmi.",
            ],
            [
                'category_id' => $pengumuman->id,
                'title' => 'Pusat Informasi dan Pengumuman',
                'slug' => 'pusat-informasi-dan-pengumuman',
                'excerpt' => 'Tempat untuk menyampaikan pengumuman yang telah dikonfirmasi oleh pengurus.',
                'content' => "Halaman ini merupakan contoh artikel untuk kategori Pengumuman.\n\nGanti isi contoh ini dengan pengumuman resmi, termasuk tanggal, detail kegiatan, dan kontak yang relevan. Pastikan informasi sudah dikonfirmasi sebelum dipublikasikan.",
            ],
        ];

        foreach ($articles as $article) {
            News::firstOrCreate(
                ['slug' => $article['slug']],
                [
                    ...$article,
                    'author_id' => $admin->id,
                    'status' => 'draft',
                    'published_at' => null,
                ]
            );
        }
    }
}
