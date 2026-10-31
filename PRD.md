# PRD — Website Event Organizer

**Versi:** 1.0 (Draft)
**Tanggal:** 31 Oktober 2026

---

## 1. Ringkasan

Website company profile untuk sebuah Event Organizer (EO) yang berfungsi sebagai etalase portofolio sekaligus kanal masuk calon klien. Pengunjung dapat mengenal profil EO, melihat layanan (pelatihan, workshop, seminar, penyewaan), melihat rekam jejak kerja sama dan testimoni, lalu berkonsultasi langsung melalui WhatsApp. Seluruh konten dikelola lewat halaman admin.

## 2. Tujuan

| # | Tujuan | Indikator Keberhasilan |
|---|--------|------------------------|
| 1 | Membangun kredibilitas EO secara online | Halaman Tentang, Kerja Sama, dan Testimoni terisi lengkap |
| 2 | Memperkenalkan layanan secara jelas | Setiap layanan punya halaman/deskripsi sendiri |
| 3 | Mengonversi pengunjung menjadi prospek | Klik tombol WhatsApp per bulan |
| 4 | Memudahkan pengelolaan konten tanpa programmer | Admin dapat CRUD seluruh konten mandiri |

## 3. Target Pengguna

- **Pengunjung / calon klien:** instansi, sekolah, perusahaan, komunitas yang mencari penyelenggara acara atau penyewaan.
- **Admin:** pemilik / staf EO yang mengelola konten website.

## 4. Ruang Lingkup

### 4.1 Termasuk (In Scope)
1. Halaman publik: Beranda, Tentang Kami, Layanan, Kerja Sama, Testimoni, Kontak.
2. Tombol konsultasi ke WhatsApp.
3. Halaman admin dengan login.
4. Manajemen konten: layanan, kerja sama, testimoni, profil, kontak & media sosial.

### 4.2 Tidak Termasuk (Out of Scope — versi 1)
- Pembayaran online / ticketing.
- Booking otomatis dengan kalender ketersediaan.
- Multi-bahasa.
- Chat / live chat internal (konsultasi cukup via WhatsApp).

## 5. Kebutuhan Fungsional

### 5.1 Halaman Publik

**FR-01 Beranda**
- Hero (headline, subjudul, CTA "Konsultasi via WhatsApp").
- Ringkasan layanan, cuplikan kerja sama, cuplikan testimoni.

**FR-02 Tentang Kami ("Siapa Kami")**
- Profil EO: deskripsi, visi & misi, nilai/keunggulan.
- Tim (opsional): foto, nama, jabatan.
- Gaya halaman seperti portofolio.

**FR-03 Layanan**
- Daftar layanan dalam kategori: **Pelatihan, Workshop, Seminar, Penyewaan**.
- Setiap layanan: nama, deskripsi, foto, poin-poin yang didapat/fasilitas.
- Untuk **Penyewaan**: daftar item/fasilitas yang disewakan (mis. sound system, tenda, venue) beserta deskripsi dan foto.
- Tombol "Tanya layanan ini" → WhatsApp dengan pesan otomatis berisi nama layanan.

**FR-04 Konsultasi**
- Tombol WhatsApp tetap (floating button) di semua halaman.
- Format tautan: `https://wa.me/<nomor>?text=<pesan_terisi>`.
- Nomor dan template pesan dapat diubah dari admin.

**FR-05 Log Kerja Sama**
- Daftar mitra/klien yang pernah bekerja sama.
- Setiap entri: nama mitra, logo (opsional), nama kegiatan, tanggal, deskripsi singkat, **foto kegiatan** (satu atau lebih/galeri).
- Diurutkan dari terbaru; mendukung filter berdasarkan tahun/jenis layanan.
- Halaman detail kegiatan dengan galeri foto.

**FR-06 Testimoni**
- Daftar testimoni: foto pemberi testimoni, nama, instansi/jabatan, komentar, (opsional) rating.
- Ditampilkan sebagai kartu/slider di Beranda dan halaman khusus.

**FR-07 Kontak & Lokasi**
- Alamat lengkap, jam operasional, nomor/WhatsApp, email.
- Peta lokasi tertanam (Google Maps embed).
- Daftar media sosial (ikon + tautan): mis. Instagram, Facebook, TikTok, YouTube, dan lainnya yang ditambah admin.
- Footer di semua halaman menampilkan alamat singkat dan ikon media sosial.

### 5.2 Halaman Admin

**FR-08 Autentikasi**
- Login dengan email & kata sandi di `/admin`.
- Kata sandi disimpan ter-hash; sesi dengan masa berlaku; logout.
- Akses halaman admin hanya untuk yang sudah login.

**FR-09 Dashboard**
- Ringkasan jumlah layanan, kerja sama, testimoni.

**FR-10 Kelola Layanan** — tambah, ubah, hapus, urutkan; kategori; unggah foto; status tampil/sembunyi.

**FR-11 Kelola Log Kerja Sama** — CRUD entri; unggah banyak foto per kegiatan; atur urutan/tanggal.

**FR-12 Kelola Testimoni** — CRUD; unggah foto; status tampil/sembunyi.

**FR-13 Kelola Profil & Konten Umum** — teks Tentang Kami, hero Beranda, tim.

**FR-14 Kelola Kontak & Media Sosial** — alamat, email, nomor WhatsApp, template pesan, koordinat/tautan peta, daftar media sosial (nama, tautan, ikon).

## 6. Kebutuhan Non-Fungsional

| Aspek | Kebutuhan |
|-------|-----------|
| Responsif | Tampilan optimal di ponsel, tablet, desktop (mobile-first) |
| Performa | Halaman utama dimuat < 3 detik pada koneksi 4G; gambar dikompres & lazy-load |
| Keamanan | HTTPS, hash kata sandi, validasi & sanitasi input, validasi tipe/ukuran file unggahan, proteksi CSRF/XSS |
| SEO | Meta title/description, URL bersih, sitemap, Open Graph untuk berbagi di media sosial |
| Aksesibilitas | Kontras warna cukup, teks alternatif pada gambar |
| Ketersediaan | Backup basis data dan file unggahan berkala |

## 7. Struktur Halaman (Sitemap)

```
/                    Beranda
/tentang             Tentang Kami
/layanan             Daftar Layanan
/layanan/:slug       Detail Layanan
/kerja-sama          Log Kerja Sama
/kerja-sama/:slug    Detail Kegiatan (galeri)
/testimoni           Testimoni
/kontak              Kontak, Alamat, Peta, Media Sosial

/admin/login
/admin               Dashboard
/admin/layanan
/admin/kerja-sama
/admin/testimoni
/admin/profil
/admin/kontak
```

## 8. Model Data (Garis Besar)

- **users**: id, nama, email, password_hash, created_at
- **services**: id, kategori (pelatihan | workshop | seminar | penyewaan), nama, slug, deskripsi, foto, urutan, is_active
- **rental_items** *(opsional, untuk Penyewaan)*: id, service_id, nama, deskripsi, foto
- **collaborations**: id, nama_mitra, logo, nama_kegiatan, slug, tanggal, deskripsi, is_active
- **collaboration_photos**: id, collaboration_id, path_foto, caption, urutan
- **testimonials**: id, nama, instansi, foto, komentar, rating, is_active
- **site_settings**: key/value (profil, visi misi, alamat, email, nomor WhatsApp, template pesan, peta, jam operasional)
- **social_links**: id, platform, url, urutan, is_active
- **team_members** *(opsional)*: id, nama, jabatan, foto, urutan

## 9. Alur Pengguna Utama

1. **Calon klien:** Beranda → lihat layanan → lihat kerja sama & testimoni → klik WhatsApp → konsultasi.
2. **Admin:** Login → pilih menu → tambah/ubah data → simpan → perubahan langsung tampil di situs publik.

## 10. Saran Teknologi (Dapat Disesuaikan)

- **Frontend:** HTML/CSS + Tailwind, atau framework (Next.js / Laravel Blade).
- **Backend:** Laravel / Node.js (Express) / Next.js API routes.
- **Database:** MySQL / PostgreSQL.
- **Penyimpanan file:** disk server atau object storage.
- **Hosting:** VPS / shared hosting dengan SSL.

## 11. Rencana Rilis

| Fase | Cakupan |
|------|---------|
| 1 — Desain & Struktur | Wireframe, desain UI, skema database |
| 2 — Halaman Publik | Beranda, Tentang, Layanan, Kontak, tombol WhatsApp |
| 3 — Admin & Konten | Login, CRUD layanan, kerja sama, testimoni, pengaturan |
| 4 — Pengujian & Rilis | Uji responsif, keamanan, performa, SEO, deploy |

## 12. Kriteria Penerimaan

- Seluruh halaman publik tampil benar di ponsel dan desktop.
- Tombol WhatsApp membuka chat dengan nomor dan pesan yang benar.
- Admin dapat menambah, mengubah, dan menghapus layanan, kerja sama (beserta foto), testimoni, kontak, dan media sosial tanpa menyentuh kode.
- Halaman admin tidak dapat diakses tanpa login.
- Perubahan dari admin langsung tampil di situs publik.

## 13. Pertanyaan Terbuka

1. Nama EO, logo, dan palet warna/brand yang dipakai?
2. Apakah satu admin saja, atau perlu beberapa peran (mis. admin & editor)?
3. Apakah daftar item penyewaan perlu harga yang ditampilkan, atau cukup "hubungi kami"?
4. Apakah perlu formulir kontak selain WhatsApp?
5. Rencana domain dan hosting?
6. Platform media sosial apa saja yang aktif saat ini?
