# TP8DPBO2425C1

## Janji

Saya Daffa Dhiyaa Candra dengan NIM 2404286 mengerjakan  
TP 7 dalam mata kuliah Desain dan Pemrograman  
Berorientasi Objek untuk keberkahanNya maka saya tidak  
melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.  

## Desain Program

Aplikasi ini mengikuti pola desain **Model-View-Controller (MVC)** untuk memisahkan model, presentasi data, dan interaksi pengguna.

### Struktur Direktori Inti

| Direktori | Deskripsi |
| :--- | :--- |
| `config/` | Berisi file konfigurasi `database.php`. |
| `Controllers/` | Berisi logika pemrosesan input pengguna dan koordinasi data (`LecturerController.php`, `DepartmentController.php`, dll.). |
| `Models/` | Berisi kelas yang berhubungan langsung dengan database (Logika bisnis data: `Departemen.php`, `Lecturer.php`, dll.). |
| `View/` | Berisi semua file presentasi HTML/PHP yang dilihat pengguna. |
| `index.php` | **Front Controller** utama yang memproses semua permintaan masuk (routing). |

### Komponen Kunci

1.  **Model (`Models/`)**: Kelas ini (misalnya, `DB.php` sebagai Base Model) bertanggung jawab untuk berinteraksi dengan database. Semua operasi **CRUD** (Create, Read, Update, Delete) diimplementasikan di sini.
2.  **View (`View/`)**: File-file ini murni untuk presentasi data (HTML, Bootstrap, PHP). View menerima data dari Controller dan menampilkannya kepada pengguna.
3.  **Controller (`Controllers/`)**: Kelas ini menerima permintaan dari pengguna, memanggil Model yang relevan untuk mendapatkan/memproses data, dan kemudian memanggil View untuk menampilkan hasilnya.

---

## 🚀 Penjelasan Alur (Flow & Routing)

Semua permintaan pengguna diarahkan melalui satu titik masuk: **`index.php`** (Front Controller).

### 1. Proses Routing (`index.php`)

Routing ditentukan oleh parameter GET di URL: `index.php?controller=X&action=Y`

| Parameter | Contoh Nilai | Fungsi |
| :--- | :--- | :--- |
| `controller` | `lecturer` | Memuat kelas `LecturerController`. |
| `action` | `index` | Memanggil metode `index()` di Controller yang dimuat (menampilkan daftar). |

### 2. Alur CRUD (Contoh: Menambah Dosen) 

1.  **Pengguna** mengisi formulir Tambah Dosen di halaman **View/lecturer/index.php**.
2.  **Controller** (`LecturerController.php`) menerima permintaan **POST** dengan `action=create`.
3.  Controller memvalidasi data dan memanggil **Model** (`Lecturer.php`).
4.  Model menjalankan *prepared statement* **INSERT INTO** ke tabel `lecturers`.
5.  Model mengembalikan status keberhasilan ke Controller.
6.  Controller memanggil **`$this->redirect()`** untuk mengalihkan pengguna kembali ke `index.php?controller=lecturer&action=index` (pola **PRG** - Post/Redirect/Get).

---

## Dokumentasi  



https://github.com/user-attachments/assets/cb0c6aeb-9b40-4563-a8a8-fd7b8b1f500a

