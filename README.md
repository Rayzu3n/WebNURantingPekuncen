# Web NU Ranting Pekuncen

Portal Berita dan Sistem Informasi Keanggotaan Nahdlatul Ulama (NU) Ranting Pekuncen, Kecamatan Pekuncen, Kabupaten Banyumas, Jawa Tengah.

## Fitur Utama

- **Portal Berita Publik**:
  - Running text / Ticker Berita Terkini
  - Hero Berita Utama dengan gambar resolusi tinggi
  - Grid Berita Terkini dengan kategori, tanggal publikasi, dan cuplikan artikel
  - Filter kategori berita dan pencarian artikel interaktif
  - Halaman baca artikel lengkap dengan tipografi editorial
- **Kartu Tanda Anggota (KARTANU) Digital**:
  - Tampilan kartu resmi keanggotaan PRNU Pekuncen dengan gradient accent bar
  - QR Code verifikasi keabsahan kartu anggota
  - Unduh kartu dalam format gambar PNG dan JPG (menggunakan `html2canvas`)
- **Verifikasi QR Keanggotaan Publik**:
  - Halaman verifikasi publik `/member/verify/:member_number`
  - Validasi status keanggotaan aktif/non-aktif
- **Panel Anggota (Member Dashboard)**:
  - Ringkasan status keanggotaan
  - Formulir pembaruan profil, biodata diri (NIK, tempat/tgl lahir, gender, kontak, domisili), dan foto profil
- **Panel Admin (Admin Dashboard)**:
  - Ringkasan statistik (Total Berita, Total Anggota, Total Kategori)
  - CRUD Berita (tulis artikel baru, edit, upload foto, status draft/published, hapus)
  - CRUD Kategori Berita
  - CRUD Data Anggota (pendaftaran anggota baru, pembaruan status, hapus akun)
- **Tema Gelap & Terang**:
  - Dukungan Dark Mode dan Light Mode terintegrasi

## Akun Demo untuk Pengujian

- **Admin**: `admin@nu-pekuncen.org` (Kata Sandi: `password`)
- **Anggota (Ahmad Dahlan)**: `member@nu-pekuncen.org` (Kata Sandi: `password`)
- **Anggota (Siti Fatimah)**: `siti.fatimah@nu-pekuncen.org` (Kata Sandi: `password`)

Tersedia tombol akses cepat sekali klik (1-click quick login) di halaman `/login` untuk kemudahan pengujian.

## Teknologi

- React 19 + TypeScript
- Vite 8
- Tailwind CSS
- Lucide React
- QRCode & html2canvas
