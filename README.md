//Janji

Saya Nadzalla Diva Asmara Sutedja dengan Nim 2408095 mengerjakan Tugas Praktikum 8 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahan-Nya maka saya tidak akan melakukan kecurangan seperti yang telah di spesifikasikan

//Penjelasan Desain Program
Sistem manajemen dosen ini dibangun untuk mengelola data dosen secara terstruktur menggunakan arsitektur MVC (Model–View–Controller). Sistem menyediakan fungsi dasar seperti menampilkan daftar dosen, menambah dosen baru, mengubah data, dan menghapus data dosen, dengan atribut penting seperti nama, NIDN, nomor telepon, dan departemen.

Pada konsep MVC, Model bertugas mengelola logika dan data, termasuk membuka koneksi ke database dan menjalankan operasi CRUD (Create, Read, Update, Delete). Contoh file model adalah Lecturer.php untuk data dosen dan Department.php untuk data departemen. Model berinteraksi dengan database melalui file DB.php, yang berfungsi sebagai modul untuk melakukan koneksi dan mengeksekusi query secara terstruktur dan aman.

View bertugas menampilkan halaman kepada pengguna. View memanfaatkan file HTML sebagai template tampilan, seperti templates/lecturers.html untuk daftar dosen dan form tambah/edit, serta templates/departments.html untuk daftar departemen. File HTML template ini berisi struktur halaman web, termasuk tabel, form input, tombol, dan layout. View akan menempelkan data nyata dari Model ke dalam placeholder di template sebelum dikirim ke browser, sehingga tampilan dan logika aplikasi tetap terpisah.

Controller berfungsi sebagai pengatur alur sistem. Controller menerima request dari pengguna, memprosesnya melalui Model, dan memilih View yang sesuai untuk ditampilkan. Contoh file controller adalah LecturerController.php untuk mengatur aksi tambah, edit, atau hapus dosen, dan DepartmentController.php untuk pengelolaan departemen. Controller juga memastikan alur kerja aplikasi berjalan logis dan konsisten.

Selain itu, terdapat file config.php, yang berfungsi menyimpan pengaturan koneksi database seperti host, username, password, dan nama database. Dengan file ini, pengaturan database bisa digunakan secara terpusat dan mudah diubah tanpa memengaruhi kode lain.

Dengan pemisahan logika, penggunaan template HTML, serta file config.php dan DB.php, sistem menjadi modular, mudah dikembangkan, mudah diperbaiki, dan fleksibel dalam mengubah tampilan maupun pengaturan koneksi database tanpa memengaruhi logika utama aplikasi.

//Alur Program

Pengguna membuka aplikasi melalui index.php di browser. Halaman awal biasanya menampilkan daftar dosen atau menu navigasi untuk menambah, mengedit, atau menghapus data.
Request diterima oleh Controller. Misalnya, jika pengguna ingin menambah dosen, request tersebut akan diteruskan ke LecturerController.php. Controller bertugas menentukan aksi apa yang harus dijalankan berdasarkan request dari pengguna.
Controller memanggil Model untuk memproses data. Model seperti Lecturer.php akan berinteraksi dengan database melalui DB.php untuk menjalankan operasi CRUD sesuai kebutuhan, misalnya menambahkan data dosen baru atau mengambil daftar dosen yang sudah ada.
Model mengeksekusi query ke database menggunakan modul DB.php. Hasil query, berupa data dosen atau status operasi (sukses/gagal), dikembalikan ke Controller.
Controller menyiapkan data untuk View. Controller memilih View yang sesuai, misalnya LecturerView.php, dan mengirimkan data dari Model agar dapat ditampilkan.
View menempelkan data ke template HTML. File template seperti templates/lecturers.html atau templates/departments.html berisi struktur halaman web. View akan menggantikan placeholder dengan data nyata dari Model, sehingga halaman siap ditampilkan di browser.
Browser menampilkan hasil kepada pengguna. Pengguna melihat daftar dosen, form tambah/edit, atau notifikasi hasil operasi (misalnya “Data berhasil ditambahkan”). Jika pengguna melakukan aksi lain, alur ini akan diulang sesuai request baru.
Konfigurasi database terpusat. Semua koneksi database menggunakan pengaturan di config.php, sehingga perubahan host, username, password, atau nama database cukup dilakukan di satu file tanpa harus mengubah Model atau Controller.


//Dokumentasi 
1. Dokumentasi berhasil tabel department
https://github.com/user-attachments/assets/10e959ff-b170-4ab3-a329-bea3044a21d9

3. Dokumentasi berhasil tabel Lecturer
https://github.com/user-attachments/assets/3a647fa8-fec5-44bb-b1d4-2f530a483955








