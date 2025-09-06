<p align="center">
  <img src="https://upload.wikimedia.org/wikipedia/commons/3/3f/Logo_SMK_Kesehatan.png" width="120" alt="SMK Logo" />
</p>
<h1 align="center">🧪 PEMINJAMAN ALAT LAB SMK N 1 SRAGI</h1>
<p align="center">
  <b>Digitalisasi manajemen alat laboratorium SMK: peminjaman, inventaris, hingga QR tracking, semua otomatis & transparan!</b>
  <br/><br/>
  <img src="https://img.shields.io/badge/PHP-%3E=7.4-blue?style=flat-square" />
  <img src="https://img.shields.io/badge/License-MIT-green?style=flat-square" />
  <img src="https://img.shields.io/badge/Powered%20by-CodeIgniter%204-orange?style=flat-square" />
</p>

---

## 🚩 **Deskripsi Singkat**

Aplikasi **Peminjaman Alat Laboratorium** untuk SMK N 1 SRAGI.  
Dirancang buat digitalisasi proses peminjaman, pengembalian, inventaris, sampai tracking alat dengan QR code.  
Cocok buat admin, guru, siswa, dan bagian inventarisir sekolah biar enggak lagi ribet nyari alat yang “katanya udah dibalikin” tapi hilang entah ke mana! 🤣

---

## 🚀 **Fitur Utama**

- **📦 Manajemen Inventaris Barang**
  - Tambah, edit, hapus, & tracking semua alat lab.
  - Integrasi **QR Code** untuk identifikasi & scanning alat (inventarisasi lebih gampang).
  - Data stok real-time (stok masuk, keluar, rusak, dll).

- **📝 Peminjaman & Pengembalian Online**
  - Peminjaman/pengembalian cukup input lewat web.
  - Approval by admin/lab.
  - Riwayat transaksi otomatis tercatat, semua transparan.

- **🔔 Notifikasi Otomatis**
  - Reminder sebelum jatuh tempo, via WhatsApp/Email (siap diintegrasi).

- **📊 Dashboard Realtime**
  - Lihat status alat, info siapa yang pinjam, stok tersisa, jadwal pengembalian.
  - Statistik peminjaman, alat paling sering dipakai, dsb.

- **📑 Laporan & Export Data**
  - Export laporan peminjaman, pengembalian, dan stok ke **Excel/PDF**.
  - Siap cetak untuk laporan BOS/akreditasi sekolah.

---

## ⚙️ **Teknologi**

- **Frontend:** Bootstrap SB ADMIN 2 (simple & responsive)
- **Backend:** CodeIgniter 4 (**Minimal PHP 7.4**)
- **Database:** MySQL
- **Fitur Tambahan:** QR Code Generator, Export Excel/PDF

---

## 🛠️ **Cara Install (Development)**

```bash
# 1. Clone project ini
git clone https://github.com/asstroboyz/PEMINJAMAN-ALAT-LAB-SMK-N-1-SRAGI.git
cd PEMINJAMAN-ALAT-LAB-SMK-N-1-SRAGI

# 2. Copy file env
cp .env.example .env
# Atur koneksi DB MySQL & setting lain di file .env

# 3. Install dependency PHP (wajib PHP >= 7.4)
composer install

# 4. Migrasi database (lihat migrasi di /app/Database)
#php spark migrate

# 5. Jalankan aplikasi (via PHP built-in server)
php spark serve
# Atau host di XAMPP/laragon/nginx sesuai kebutuhan

# 6. (Optional) Untuk QR scanner via kamera, pakai device dengan kamera aktif (mobile/laptop)
