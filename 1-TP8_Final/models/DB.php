<?php
class DB
{
    var $db_host = "";  // Host database (misal localhost)
    var $db_user = "";  // Username database
    var $db_pass = "";  // Password database
    var $db_name = "";  // Nama database
    var $db_link = "";  // Menyimpan koneksi mysqli
    var $result = 0;    // Menyimpan hasil query

    // Konstruktor untuk inisialisasi properti DB
    function __construct($db_host, $db_user, $db_pass, $db_name)
    {
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;

        // Matikan laporan error default mysqli, handle manual
        mysqli_report(MYSQLI_REPORT_OFF);
    }

    // Membuka koneksi ke database
    function open()
    {
        $this->db_link = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        if (!$this->db_link) {
            die("Connection failed: " . mysqli_connect_error()); // Jika gagal koneksi, hentikan program
        }
    }

    // Eksekusi query SQL
    function execute($query)
    {
        // Eksekusi query tanpa exception
        $this->result = mysqli_query($this->db_link, $query);
        
        if (!$this->result) { // Jika query gagal
            $error = mysqli_error($this->db_link);
            
            // LOG error untuk debugging
            error_log("DB ERROR: " . $error);
            error_log("QUERY: " . $query);
            
            // Check jika error karena foreign key constraint
            if (strpos($error, 'foreign key constraint') !== false || 
                strpos($error, 'Cannot delete or update a parent row') !== false ||
                strpos($error, 'a foreign key constraint fails') !== false) {
                error_log("FOREIGN KEY CONSTRAINT DETECTED");
                return false; // Return false jika error FK
            } else {
                // Untuk error lainnya, return false
                return false;
            }
        }
        
        return $this->result; // Jika sukses, kembalikan hasil query
    }

    // Ambil satu baris hasil query sebagai array
    function getResult()
    {
        return mysqli_fetch_array($this->result);
    }

    // Menutup koneksi database
    function close()
    {
        mysqli_close($this->db_link);
    }
}
