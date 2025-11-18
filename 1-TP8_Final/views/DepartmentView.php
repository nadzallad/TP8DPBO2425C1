<?php

class DepartmentView
{
    // Menampilkan tabel daftar semua departemen
    public function render($data)
    {
        $no = 1;                      // Nomor urut tabel
        $dataDepartments = '';        // Penampung HTML baris tabel

        // Loop setiap record department
        foreach ($data as $val) {
            // Ambil nilai tiap kolom
            $department_id   = $val['department_id'];
            $department_name = $val['department_name'];
            $department_code = $val['department_code'];
            $created_at      = $val['created_at'];

            // Susun baris tabel HTML
            $dataDepartments .= "<tr>
                                <td>" . $no++ . "</td>
                                <td>" . $department_name . "</td>
                                <td>" . $department_code . "</td>
                                <td>" . $created_at . "</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <a href='index.php?controller=department&action=edit&id=" . $department_id . "' 
                                       class='btn btn-warning btn-sm mb-1'>Edit</a>

                                    <!-- Tombol Delete dengan konfirmasi -->
                                    <a href='index.php?controller=department&action=delete&id=" . $department_id . "' 
                                       class='btn btn-danger btn-sm' 
                                       onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                                </td>
                                </tr>";
        }

        // Nama file template untuk tabel
        $templateFile = "templates/department.html";

        // Pastikan file template ada sebelum diproses
        if (!file_exists($templateFile)) {
            die("Error: Template file not found: " . $templateFile);
        }

        // Muat template HTML
        $tpl = new Template($templateFile);

        // Ganti placeholder di dalam template
        $tpl->replace("JUDUL", "Data Departemen");
        $tpl->replace("DATA_TABEL", $dataDepartments);

        // Tampilkan halaman
        $tpl->write();
    }

    // Menampilkan form tambah departemen
    public function renderFormAdd()
    {
        // Nama file template form tambah
        $templateFile = "templates/form_add_department.html";

        // Cek dulu apakah template tersedia
        if (!file_exists($templateFile)) {
            die("Error: Template file not found: " . $templateFile);
        }

        $tpl = new Template($templateFile);

        // Isi placeholder template
        $tpl->replace("JUDUL_FORM", "Tambah Departemen Baru");
        $tpl->replace("VAL_NAME", "");                   // Default kosong
        $tpl->replace("VAL_CODE", "");                   // Default kosong
        $tpl->replace("VAL_DATE", date('Y-m-d'));        // Isi tanggal hari ini
        $tpl->replace("ACTION_URL", "index.php?controller=department&action=add");

        // Tampilkan form
        $tpl->write();
    }

    // Menampilkan form edit departemen
    public function renderFormEdit($data)
    {
        // Nama file template form edit
        $templateFile = "templates/form_edit_department.html";

        // Validasi keberadaan file template
        if (!file_exists($templateFile)) {
            die("Error: Template file not found: " . $templateFile);
        }

        $tpl = new Template($templateFile);

        // Isi placeholder dengan data yang sudah ada
        $tpl->replace("JUDUL_FORM", "Ubah Data Departemen");
        $tpl->replace("VAL_ID", $data['department_id']);
        $tpl->replace("VAL_NAME", $data['department_name']);
        $tpl->replace("VAL_CODE", $data['department_code']);
        $tpl->replace("VAL_DATE", $data['created_at']);
        $tpl->replace("ACTION_URL", "index.php?controller=department&action=edit");

        // Tampilkan form edit
        $tpl->write();
    }
}
