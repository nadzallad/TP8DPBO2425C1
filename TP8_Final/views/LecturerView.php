<?php
// Memuat class Template yang akan digunakan untuk render file HTML
include_once(__DIR__ . "/Template.php");

// Kelas untuk menampilkan tampilan halaman dosen (lecturer)
class LecturerView
{
    // Metode untuk menampilkan halaman utama daftar dosen
    public function render($data)
    {
        $no = 1;                       // Nomor urut untuk tabel
        $dataLecturers = '';            // Variabel untuk menampung baris HTML tabel

        // Loop setiap dosen yang dikirim dari controller
        foreach ($data['lecturers'] as $val) {
            $id            = $val['id'];
            $name          = $val['name'];
            $nidn          = $val['nidn'];
            $phone         = $val['phone'];
            $join_date     = $val['join_date'];
            $department_id = $val['department_id'];

            // Mencari nama departemen sesuai department_id
            $department_name = "unknown"; // Default jika tidak ditemukan
            foreach ($data['departments'] as $dept) {
                if ($dept['department_id'] == $department_id) {
                    $department_name = $dept['department_name'];
                    break; // Stop loop jika sudah ditemukan
                }
            }

            // Membuat baris HTML untuk masing-masing dosen
            $dataLecturers .= "<tr class='text-center align-middle'>
                                <td>" . $no++ . "</td>
                                <td>" . $name . "</td>
                                <td>" . $nidn . "</td>
                                <td>" . $phone . "</td>
                                <td>" . $join_date . "</td>
                                <td>" . $department_name . "</td>
                                <td>
                                    <a href='index.php?controller=lecturer&action=edit&id=" . $id . "' 
                                       class='btn btn-warning mb-2'>edit</a>
                                    <a href='index.php?controller=lecturer&action=delete&id=" . $id . "' 
                                       class='btn btn-danger' 
                                       onclick='return confirm(\"are you sure you want to delete?\")'>delete</a>
                                </td>
                               </tr>";
        }

        // Memuat template HTML utama untuk halaman dosen
        $tpl = new Template("templates/lecturer.html");

        // Mengganti placeholder dengan konten dinamis
        $tpl->replace("JUDUL", "lecturer data");   // Judul halaman
        $tpl->replace("DATA_TABEL", $dataLecturers); // Baris tabel dosen

        // Menampilkan halaman HTML ke browser
        $tpl->write();
    }

    // Metode untuk menampilkan form tambah dosen
    public function renderFormAdd($dataDepartments)
    {
        $tpl = new Template("templates/form_add_lecturer.html");

        // Mengisi placeholder form dengan nilai default (kosong)
        $tpl->replace("JUDUL_FORM", "add new lecturer"); // Judul form
        $tpl->replace("VAL_NAME", "");
        $tpl->replace("VAL_NIDN", "");
        $tpl->replace("VAL_PHONE", "");
        $tpl->replace("VAL_DATE", date('Y-m-d')); // Tanggal default hari ini
        $tpl->replace("ACTION_URL", "index.php?controller=lecturer&action=add"); // URL form submit

        // Mengisi dropdown departemen
        $tpl->replace("DEPARTEMENT_OPTIONS", $dataDepartments);

        // Menampilkan form ke browser
        $tpl->write();
    }

    // Metode untuk menampilkan form edit dosen
    public function renderFormEdit($data, $dataDepartments)
    {
        $id            = $data['id'];
        $name          = $data['name'];
        $nidn          = $data['nidn'];
        $phone         = $data['phone'];
        $join_date     = $data['join_date'];
        $department_id = $data['department_id'];

        $tpl = new Template("templates/form_edit_lecturer.html");

        // Mengisi form dengan data dosen yang sudah ada
        $tpl->replace("JUDUL_FORM", "edit lecturer data");
        $tpl->replace("VAL_ID", $id);
        $tpl->replace("VAL_NAME", $name);
        $tpl->replace("VAL_NIDN", $nidn);
        $tpl->replace("VAL_PHONE", $phone);
        $tpl->replace("VAL_DATE", $join_date);
        $tpl->replace("ACTION_URL", "index.php?controller=lecturer&action=edit");

        // Menandai departemen yang sedang dipilih sebagai "selected"
        $updatedOptions = str_replace(
            "value='" . $department_id . "'",
            "value='" . $department_id . "' selected",
            $dataDepartments
        );

        $tpl->replace("DEPARTEMENT_OPTIONS", $updatedOptions);

        // Menampilkan form edit ke browser
        $tpl->write();
    }
}
