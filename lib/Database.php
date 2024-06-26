<?php
/* 
    Project Ini Dibuat oleh:
    NAMA :ANDY RAHMAN RAMADHAN
    NIM  :220401070404
    KELAS:IT403
    MAPEL:PEMROGRAMAN WEB II
*/
include_once "config/config.php";

class Database
{
    public $host = HOST;
    public $user = USER;
    public $password = PASSWORD;
    public $database = DATABASE;

    public $link;
    public $error;

    public function __construct()
    {
        $this->dbConnect();
    }

    // * Koneksi database
    public function dbConnect()
    {
        $this->link = mysqli_connect(
            $this->host,
            $this->user,
            $this->password,
            $this->database
        );
        if (!$this->link) {
            $this->error = "Database connection failed";
            return false;
        }
    }

    // * Masukkan data
    public function masukkan($query)
    {
        $hasil = mysqli_query($this->link, $query) or die($this->link->error . __LINE__);
        if ($hasil) {
            return $hasil;
        } else {
            return false;
        }
    }

    // * Pilih data
    public function pilih($query)
    {
        $hasil = mysqli_query($this->link, $query) or die($this->link->error . __LINE__);
        if (mysqli_num_rows($hasil) > 0) {
            return $hasil;
        } else {
            return false;
        }
    }

    // * Update data
    public function update($query)
    {
        $hasil = mysqli_query($this->link, $query) or die($this->link->error . __LINE__);
        if ($hasil) {
            return $hasil;
        } else {
            return false;
        }
    }

    // * Hapus data
    public function hapus($query)
    {
        $hasil = mysqli_query($this->link, $query) or die($this->link->error . __LINE__);
        if ($hasil) {
            return $hasil;
        } else {
            return false;
        }
    }

    public function siapkanPilihan($query, $types, ...$params)
    {
        $stmt = $this->link->prepare($query);
        if ($stmt === false) {
            die("Ada kesalahan: " . $this->link->error);
        }
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $hasil = $stmt->get_result();
        $stmt->close();
        return $hasil;
    }

    public function siapkanDanJalankan($query, $types, ...$params)
    {
        $stmt = $this->link->prepare($query);
        if ($stmt === false) {
            die("Ada kesalahan: " . $this->link->error);
        }
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $hasil = $stmt->affected_rows;
        $stmt->close();
        return $hasil;
    }
}
