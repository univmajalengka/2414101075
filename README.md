# 🍽️ Website Pemesanan Makanan

## 👨‍💻 Tentang Proyek
Website ini merupakan aplikasi **pemesanan makanan berbasis web** yang terhubung dengan database **MySQL**.  
Proyek ini dibuat untuk memenuhi tugas mata kuliah **Pemrograman Web**.  
Aplikasi ini memungkinkan pengguna untuk melihat daftar makanan, memilih kategori, menambahkan ke keranjang, dan melakukan pemesanan sederhana.

---

## 🧑‍🎓 Identitas Pembuat
- **Nama:** Rizki Muhamad Aminudin  
- **NPM:** 2414101075  
- **Mata Kuliah:** Pemrograman Web  
- **Program Studi:** Teknik Informatika  
- **Dosen Pengampu:** _(Isi sesuai nama dosen Anda)_

---

## ⚙️ Teknologi yang Digunakan
| Komponen | Teknologi |
|-----------|------------|
| **Frontend** | HTML, CSS, JavaScript, Bootstrap |
| **Backend** | PHP (Native, tanpa framework) |
| **Database** | MySQL |
| **Server Lokal** | XAMPP / Laragon |

---

## 🗄️ Struktur Database

### Database: `food`

#### Tabel `admin`
```sql
CREATE TABLE `admin` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
