# ProjectTugasAkhir

Ini Adalah Web Aplikasi yang dirancang rentan untuk belajar Kerentanan XSS dan memahami Bagaimana Impactnya. Proyek ini dibuat sebagai alat pembelajaran untuk memahami kerentanan Cross-Site Scripting (XSS) dalam aplikasi web, termasuk cara eksploitasi dan dampaknya.

## Deskripsi
Proyek ini merupakan aplikasi web yang sengaja dibuat dengan kerentanan XSS untuk tujuan edukasi. Pengguna dapat belajar tentang jenis-jenis XSS (seperti reflected, stored, dan DOM-based), cara mendeteksi, dan mitigasi. Tujuan utama adalah membantu mahasiswa atau pemula dalam keamanan siber untuk memahami risiko XSS melalui praktik langsung.

## Instalasi
Untuk menjalankan proyek ini, ikuti langkah-langkah berikut:

1. Clone repository ini:
   ```
   git clone https://github.com/xxxTectationxxx/ProjectTugasAkhir.git
   cd ProjectTugasAkhir
   ```

2. Instal dependensi (asumsi menggunakan PHP dan web server seperti Apache atau Nginx. Jika menggunakan framework seperti Laravel atau CodeIgniter, sesuaikan):
   - Instal PHP dan web server (misalnya, XAMPP untuk lokal testing).
   - Install Database (misalnya MariaDB dan Mysql)

3. Jalankan server lokal:
   - Jika PHP sederhana: `php -S localhost:8000`.
   - Atau letakkan di folder web server (misalnya, htdocs XAMPP) dan akses via browser `localhost/NamaFolderFile`.

Catatan: Karena repo saat ini tidak memiliki file spesifik, tambahkan file aplikasi web (misalnya, index.php, vuln_form.php) sebelum instalasi.
## Penggunaan
1. Akses aplikasi melalui browser (misalnya, `http://localhost:8000`).
2. Coba fitur-fitur yang vulnerable:
   - Input form yang rentan XSS (misalnya, Edit Profil atau comment form).
   - Masukkan payload XSS seperti `<script>alert('XSS')</script>`.
3. Analisis dampak: Perhatikan bagaimana script diinjeksikan dan dijalankan di browser.

Contoh perintah untuk testing:
- Jalankan payload XSS untuk reflected: Akses URL dengan query `?comment=<script>alert(1)</script>`.
- Untuk stored XSS: Masukkan payload ke form dan lihat di halaman lain.

## Screenshot
Berikut adalah saran screenshot yang diperlukan untuk membuat README lebih ilustratif. Karena repo saat ini tidak memiliki screenshot, Anda perlu membuatnya dari aplikasi lokal atau server. Gunakan alat seperti Snipping Tool, Greenshot, atau Chrome DevTools untuk capture.

1. **Dashboard User**:
   <img width="1869" height="754" alt="image" src="https://github.com/user-attachments/assets/daad663d-dda2-43cb-bb7e-f39483197660" />

3. **Form Input Vulnerable**:
   <img width="1264" height="456" alt="image" src="https://github.com/user-attachments/assets/6e62d308-c282-4c5c-bfa1-620f909b5da1" />

4. **Contoh Output Rentan XSS**:
   <img width="1863" height="456" alt="image" src="https://github.com/user-attachments/assets/02788a7f-0b1f-458c-a5f3-ee4fdb104aa4" />

5. **Dashboard Admin**:
   <img width="1867" height="715" alt="image" src="https://github.com/user-attachments/assets/ca4eb9fd-a662-48f9-b07b-219749516452" />

6. **Diagram Workflow XSS**:
   <img width="805" height="768" alt="image" src="https://github.com/user-attachments/assets/82846238-4e4c-4adc-9ffd-dfc6ec1185c2" />

## Teknologi yang Digunakan
- PHP (untuk backend).
- HTML/CSS/JavaScript (untuk frontend).
- MySQL (jika ada database untuk stored XSS).
- Web Server (Apache/Nginx).
- XSS Report (Merekam Cookie).
- Cookie Editor (Modifikasi Cookie).

(Catatan: Sesuaikan dengan teknologi sebenarnya di repo Anda, karena saat ini tidak disebutkan. Jika menggunakan framework, tambahkan seperti Laravel atau Express.js.)

## Lisensi
Proyek ini dilisensikan di bawah MIT License. Lihat file [LICENSE](LICENSE) untuk detail lebih lanjut. 

Proyek ini dibuat untuk tujuan edukasi saja. Jangan gunakan di produksi atau untuk tujuan ilegal.

Terima Kasih!
