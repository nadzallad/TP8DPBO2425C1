<?php
class Template
{
    var $filename = '';  // Menyimpan path file template
    var $content = '';   // Menyimpan isi template sebagai string

    // Konstruktor: load file template ke dalam content
    function __construct($filename = '')
    {
        $this->filename = $filename;

        // Cek apakah file ada
        if (!file_exists($filename)) {
            die("error: template file not found: " . $filename);
        }

        // Cek apakah file bisa dibaca
        if (!is_readable($filename)) {
            die("error: template file not readable: " . $filename);
        }

        // Baca file menjadi array setiap baris
        $file_content = file($filename);
        if ($file_content === false) {
            die("error: failed to read template file: " . $filename);
        }

        // Gabungkan array baris menjadi satu string
        $this->content = implode('', $file_content);
    }

    // Hapus placeholder seperti DATA_SOMETHING dari content
    function clear()
    {
        $this->content = preg_replace("/DATA_[A-Z|_|0-9]+/", "", $this->content);
    }

    // Cetak isi template setelah membersihkan placeholder
    function write()
    {
        $this->clear();
        print $this->content;
    }

    // Mendapatkan isi template sebagai string setelah membersihkan placeholder
    function getContent()
    {
        $this->clear();
        return $this->content;
    }

    // Ganti placeholder tertentu dengan nilai baru
    function replace($old = '', $new = '')
    {
        // Tentukan tipe nilai yang diberikan
        if (is_int($new)) {
            $value = sprintf("%d", $new);        // jika integer
        } elseif (is_float($new)) {
            $value = sprintf("%f", $new);        // jika float
        } elseif (is_array($new)) {
            $value = '';
            // jika array, gabungkan item menjadi string dipisah spasi
            foreach ($new as $item) {
                $value .= $item . ' ';
            }
        } else {
            $value = $new;                       // string atau tipe lain
        }

        // Ganti semua kemunculan placeholder $old dengan $value
        $this->content = preg_replace("/$old/", $value, $this->content);
    }
}
