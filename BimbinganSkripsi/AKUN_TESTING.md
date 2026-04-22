# Kredensial Akses Aplikasi Bimbingan Skripsi
*Diberikan untuk keperluan Testing & Evaluasi Anggota Tim.*

Aplikasi ini menggunakan Role-Based Access Control (RBAC). Berikut adalah akun standar yang di-generate otomatis oleh sistem saat database direset (`php artisan migrate:fresh --seed`):

## 1. Akun Superadmin (Hak Akses Penuh / Root)
Manifes Tugas: Menambahkan Program Studi (Prodi) baru, dan Menugaskan Dosen/Staf untuk menjadi "Admin Prodi".
- **Email Login:** `superadmin@contoh.com`
- **Password:** `password`

## 2. Akun Admin Prodi (Sistem Informasi)
Manifes Tugas: Memasukkan/Validasi Dosen, Edit Profil Mahasiswa (Menetapkan Pembimbing 1), Menyiapkan Ruangan Ujian Sidang Skripsi, dan Melakukan Penjadwalan Sidang & Menunjuk Dosen Penguji 1 & 2.
- **Email Login:** `admin@si.contoh.com`
- **Password:** `password`

---

## Bagaimana Cara Mendapatkan Akun Dosen dan Mahasiswa?
Untuk skenario pengujian alur Skripsi secara utuh:
1. Teman Anda harus membuka browser dan menuju URL: `http://localhost:8000/register`
2. **DAFTAR SEBAGAI MAHASISWA**: 
   - Pilih peran: *Mahasiswa*
   - Isi NIM, pilih Prodi Sistem Informasi.
   - Buat email tes, contoh: *mahasiswa1@test.com* (Password bebas)
3. **DAFTAR SEBAGAI DOSEN**: 
   - Lakukan registrasi ulang. Pilih peran: *Dosen*
   - Isi NIDN, pilih Prodi Sistem Informasi.
   - Buat email tes, contoh: *dosen1@test.com* (Password bebas). Buat setidaknya 2 atau 3 dosen.

**Setelah membuat akun Mahasiswa & Dosen, silakan gunakan Akun Admin Prodi (`admin@si.contoh.com`) di atas untuk memberikan jabatan "Pembimbing 1" kepada mahasiswa tersebut dari menu 'Mahasiswa' agar siklus Bimbingan bisa dimulai!**
