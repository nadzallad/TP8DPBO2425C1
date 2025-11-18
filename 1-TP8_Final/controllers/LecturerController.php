<?php
// Memuat file konfigurasi dan class yang diperlukan
include_once("config.php"); // Konfigurasi database (host, user, pass, db_name)
include_once("models/Department.php"); // Model untuk tabel department (CRUD)
include_once("models/Lecturer.php"); // Model untuk tabel lecturer (CRUD)
include_once("views/LecturerView.php"); // View untuk menampilkan data dosen

class LecturerController
{
    private $lecturer;   // Properti untuk menyimpan instance model Lecturer
    private $department; // Properti untuk menyimpan instance model Department

    function __construct()
    {
        // Inisialisasi model Lecturer & Department dengan konfigurasi DB
        $this->lecturer = new Lecturer(
            Config::$db_host,
            Config::$db_user,
            Config::$db_pass,
            Config::$db_name
        );

        $this->department = new Department(
            Config::$db_host,
            Config::$db_user,
            Config::$db_pass,
            Config::$db_name
        );
    }

    // Membuat opsi dropdown <option> untuk Department
    private function getDepartmentOptions()
    {
        $this->department->open(); // Buka koneksi
        $this->department->getDepartments(); // Ambil semua department

        $dataDepartments = "";

        // Loop semua department
        while ($row = $this->department->getResult()) {

            // Antisipasi format data array vs associative
            $deptId = $row['department_id'] ?? $row[0];
            $deptName = $row['department_name'] ?? $row[1];

            // Tambahkan opsi ke HTML dropdown
            $dataDepartments .= "<option value='" . $deptId . "'>" . $deptName . "</option>";
        }

        $this->department->close(); // Tutup koneksi
        return $dataDepartments; // Kembalikan string HTML <option>
    }

    // Method utama untuk menampilkan data dosen
    public function index()
    {
        // Buka koneksi untuk kedua tabel
        $this->lecturer->open();
        $this->department->open();

        // Ambil semua data dosen
        $this->lecturer->getLecturers();
        $dataLecturers = array();

        echo "<!-- DEBUG: Starting to fetch lecturers -->";

        // Loop hasil query lecturer
        while ($row = $this->lecturer->getResult()) {

            // Debug data mentah
            echo "<!-- DEBUG raw row: " . print_r($row, true) . " -->";

            // Normalisasi data menjadi array asosiatif
            $lecturerData = array(
                'id'            => $row['id'] ?? $row[0],
                'name'          => $row['name'] ?? $row[1],
                'nidn'          => $row['nidn'] ?? $row[2],
                'phone'         => $row['phone'] ?? $row[3],
                'join_date'     => $row['join_date'] ?? $row[4],
                'department_id' => $row['department_id'] ?? $row[5]
            );

            array_push($dataLecturers, $lecturerData); // Tambahkan ke array data dosen
        }

        echo "<!-- DEBUG: Fetched " . count($dataLecturers) . " lecturers -->";

        // Ambil data department untuk dropdown di view
        $this->department->getDepartments();
        $dataDepartments = array();

        while ($row = $this->department->getResult()) {
            $deptData = array(
                'department_id'   => $row['department_id'] ?? $row[0],
                'department_name' => $row['department_name'] ?? $row[1]
            );
            array_push($dataDepartments, $deptData); // Tambahkan ke array data department
        }

        echo "<!-- DEBUG: Fetched " . count($dataDepartments) . " departments -->";

        // Tutup koneksi
        $this->lecturer->close();
        $this->department->close();

        // Gabungkan data untuk dikirim ke view
        $data = [
            'lecturers'   => $dataLecturers,
            'departments' => $dataDepartments
        ];

        // Render tampilan utama dosen
        $view = new LecturerView();
        $view->render($data);
    }
    

    // Method untuk menambah data dosen
    function add()
    {
        // Ketika form disubmit
        if (isset($_POST['submit'])) {

            // Ambil data dari form
            $data = [
                'name'          => $_POST['name'],
                'nidn'          => $_POST['nidn'],
                'phone'         => $_POST['phone'],
                'join_date'     => $_POST['join_date'],
                'department_id' => $_POST['department_id']
            ];

            $this->lecturer->open(); // Buka koneksi
            $result = $this->lecturer->add($data); // Tambah data ke DB
            $this->lecturer->close(); // Tutup koneksi

            // Jika berhasil → redirect
            if ($result) {
                header("location: index.php?controller=lecturer");
                exit;
            } else {
                echo "Error: Gagal menambah data dosen";
            }

        } else {

            // Jika belum submit, tampilkan form add dengan dropdown department
            $dataDepartments = $this->getDepartmentOptions();
            $view = new LecturerView();
            $view->renderFormAdd($dataDepartments);
        }
    }

    // Method untuk mengedit data dosen
    function edit()
    {
        // Jika form disubmit
        if (isset($_POST['submit'])) {

            $id = $_POST['id'];

            $data = [
                'name'          => $_POST['name'],
                'nidn'          => $_POST['nidn'],
                'phone'         => $_POST['phone'],
                'join_date'     => $_POST['join_date'],
                'department_id' => $_POST['department_id']
            ];

            $this->lecturer->open(); // Buka koneksi
            $result = $this->lecturer->update($id, $data); // Update data dosen
            $this->lecturer->close(); // Tutup koneksi

            if ($result) { // Jika update berhasil
                header("location: index.php?controller=lecturer");
                exit;
            } else { // Jika gagal update
                echo "Error: Gagal mengupdate data dosen";
            }

        // Jika masuk dari tombol edit (GET id)
        } else if (isset($_GET['id'])) {

            $id = $_GET['id'];

            $this->lecturer->open(); // Buka koneksi
            $this->lecturer->getLecturerById($id); // Ambil data berdasarkan id
            $row = $this->lecturer->getResult(); // Ambil hasil query

            // Jika data ditemukan
            if ($row) {

                // Normalisasi data menjadi array asosiatif
                $lecturerData = array(
                    'id'            => $row['id'] ?? $row[0],
                    'name'          => $row['name'] ?? $row[1],
                    'nidn'          => $row['nidn'] ?? $row[2],
                    'phone'         => $row['phone'] ?? $row[3],
                    'join_date'     => $row['join_date'] ?? $row[4],
                    'department_id' => $row['department_id'] ?? $row[5]
                );

                // Ambil semua department untuk dropdown edit
                $dataDepartments = $this->getDepartmentOptions();

                $view = new LecturerView();
                $view->renderFormEdit($lecturerData, $dataDepartments);

            } else { // Jika data tidak ditemukan
                echo "Error: Data dosen tidak ditemukan";
            }

            $this->lecturer->close(); // Tutup koneksi

        } else { // Jika akses edit tanpa parameter id
            header("location: index.php?controller=lecturer");
            exit;
        }
    }

    // Method untuk menghapus data dosen
    function delete()
    {
        if (isset($_GET['id'])) {

            $id = $_GET['id'];

            $this->lecturer->open(); // Buka koneksi
            $result = $this->lecturer->delete($id); // Hapus data dosen
            $this->lecturer->close(); // Tutup koneksi

            if ($result) { // Jika berhasil hapus
                header("location: index.php?controller=lecturer");
                exit;
            } else { // Jika gagal hapus
                echo "Error: Gagal menghapus data dosen";
            }

        } else { // Jika tidak ada parameter id → kembali ke index
            header("location: index.php?controller=lecturer");
            exit;
        }
    }
}
