<?php
// Memuat konfigurasi database dan class yang dibutuhkan
include_once("config.php"); // Mengambil konfigurasi koneksi database (host, user, password, db_name)
include_once("models/Department.php"); // Mengambil model Department (CRUD untuk tabel department)
include_once("views/DepartmentView.php"); // Mengambil view untuk menampilkan data department

class DepartmentController
{
    private $department; // Properti untuk menyimpan instance model Department

    function __construct()
    {
        // Inisialisasi model Department dengan konfigurasi database
        $this->department = new Department(
            Config::$db_host, 
            Config::$db_user, 
            Config::$db_pass, 
            Config::$db_name
        );
    }

    // Method untuk menampilkan semua data department
    public function index()
    {
        $this->department->open(); // Membuka koneksi database
        $this->department->getDepartments(); // Ambil seluruh data department

        $data = array();
        // Loop hasil query
        while ($row = $this->department->getResult()) {
            // Konversi hasil query ke array asosiatif (untuk fleksibilitas)
            $departmentData = array(
                'department_id' => $row['department_id'] ?? $row[0],
                'department_name' => $row['department_name'] ?? $row[1],
                'department_code' => $row['department_code'] ?? $row[2],
                'created_at' => $row['created_at'] ?? $row[3]
            );
            array_push($data, $departmentData); // Tambahkan data ke array
        }

        $this->department->close(); // Tutup koneksi database

        // Render tampilan menggunakan View
        $view = new DepartmentView();
        $view->render($data); // Tampilkan semua department
    }
    
    // Method untuk menambah data department baru
    function add()
    {
        if (isset($_POST['submit'])) { // Jika form add disubmit
            $data = [
                'department_name' => $_POST['department_name'], // Ambil input nama
                'department_code' => $_POST['department_code'], // Ambil input kode
                'created_at' => $_POST['created_at'] // Ambil tanggal pembuatan
            ];
            
            $this->department->open(); // Buka koneksi
            $result = $this->department->add($data); // Eksekusi insert
            $this->department->close(); // Tutup koneksi
            
            if ($result) { // Jika berhasil
                header("location: index.php?controller=department"); // Redirect ke halaman index
                exit;
            } else { // Jika gagal insert
                echo "Error: Gagal menambah data departemen";
            }
        } else { // Jika belum submit, tampilkan form tambah
            $view = new DepartmentView();
            $view->renderFormAdd();
        }
    }

    // Method untuk mengedit data department
    function edit()
    {
        // Jika form sudah disubmit
        if (isset($_POST['submit'])) {

            $id = $_POST['department_id']; // ambil id dari hidden input

            // Ambil data update dari form
            $data = [
                'department_name' => $_POST['department_name'],
                'department_code' => $_POST['department_code'],
                'created_at' => $_POST['created_at']
            ];

            $this->department->open(); // Buka koneksi
            $result = $this->department->update($id, $data); // Update data
            $this->department->close(); // Tutup koneksi
            
            if ($result) { // Jika update berhasil
                header("location: index.php?controller=department"); // Redirect ke index
                exit;
            } else { // Jika gagal update
                echo "Error: Gagal mengupdate data";
            }

        // Jika ada parameter GET id → tampilkan form edit sesuai data lama
        } else if (isset($_GET['id'])) {
            
            $id = $_GET['id'];

            $this->department->open(); // Buka koneksi
            $this->department->getDepartmentById($id); // Ambil data berdasarkan id
            $row = $this->department->getResult(); // Ambil hasil query
            
            if ($row) { // Jika data ditemukan
                // Format ulang hasil query menjadi array asosiatif
                $data = array(
                    'department_id' => $row['department_id'] ?? $row[0],
                    'department_name' => $row['department_name'] ?? $row[1],
                    'department_code' => $row['department_code'] ?? $row[2],
                    'created_at' => $row['created_at'] ?? $row[3]
                );
                
                // Tampilkan form edit
                $view = new DepartmentView();
                $view->renderFormEdit($data);
            } else { // Jika data tidak ditemukan
                echo "Error: Data tidak ditemukan";
            }
            
            $this->department->close(); // Tutup koneksi

        } else { // Jika tidak ada id dan tidak submit → kembalikan ke halaman index
            header("location: index.php?controller=department");
            exit;
        }
    }

    // Method untuk menghapus data department
    function delete()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            $this->department->open(); // Buka koneksi
            $result = $this->department->delete($id); // Hapus data
            $this->department->close(); // Tutup koneksi
            
            if ($result) { // Jika berhasil hapus
                header("location: index.php?controller=department");
                exit;
            } else { 
                // ERROR: Foreign key constraint (masih ada dosen di departemen ini)
                echo "
                <script>
                    alert('Tidak dapat menghapus departemen! Masih ada dosen yang terdaftar di departemen ini.\\n\\nSilakan pindahkan atau hapus dosen terlebih dahulu.');
                    window.location.href = 'index.php?controller=department';
                </script>";
                exit;
            }
        } else { // Jika tidak ada parameter id → kembali ke index
            header("location: index.php?controller=department");
            exit;
        }
    }
}
