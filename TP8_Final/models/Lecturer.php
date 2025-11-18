<?php
// Import class DB agar Lecturer dapat menggunakan koneksi database dan method execute()
include_once("DB.php");

// Class Lecturer mewarisi (extends) class DB
// sehingga bisa memakai koneksi ($this->db_link) dan method execute()
class Lecturer extends DB
{
    // Mengambil semua data dosen
    function getLecturers() 
    {
        // Query ambil seluruh data dari tabel lecturers
        $query = "SELECT * FROM lecturers";

        // Jalankan query dan kembalikan hasilnya
        return $this->execute($query);
    }

    // Mengambil data satu dosen berdasarkan ID
    function getLecturerById($id) 
    {
        // Query ambil data dosen berdasarkan id
        $query = "SELECT * FROM lecturers WHERE id = $id";

        // Jalankan query
        return $this->execute($query);
    }

    // Menambah data dosen baru
    function add($data)
    {
        // Ambil data dari form (array associative)
        $name = $data['name'];
        $nidn = $data['nidn'];
        $phone = $data['phone'];
        $join_date = $data['join_date'];
        $department_id = $data['department_id'];

        // Query insert data ke tabel lecturers
        $query = "INSERT INTO lecturers (name, nidn, phone, join_date, department_id) 
                  VALUES ('$name', '$nidn', '$phone', '$join_date', '$department_id')";

        // Jalankan query
        return $this->execute($query);
    }
    
    // Mengupdate data dosen berdasarkan ID
    function update($id, $data)
    {
        // Ambil data dari form
        $name = $data['name'];
        $nidn = $data['nidn'];
        $phone = $data['phone'];
        $join_date = $data['join_date'];
        $department_id = $data['department_id'];

        // Query update data
        $query = "UPDATE lecturers SET 
                  name = '$name', 
                  nidn = '$nidn', 
                  phone = '$phone', 
                  join_date = '$join_date', 
                  department_id = '$department_id' 
                  WHERE id = $id";

        // Jalankan query update
        return $this->execute($query);
    }

    // Menghapus data dosen berdasarkan ID
    function delete($id)
    {
        // Query delete berdasarkan id dosen
        $query = "DELETE FROM lecturers WHERE id = $id";

        // Jalankan query delete
        return $this->execute($query);
    }
}
