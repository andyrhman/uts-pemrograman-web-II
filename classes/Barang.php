<?php
include_once "lib/Database.php";

class Barang
{
    public $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function tambahBarang($data)
    {
        $kode_barang = mysqli_real_escape_string($this->db->link, $data['kode_barang']);
        $nama_barang = mysqli_real_escape_string($this->db->link, $data['nama_barang']);
        $jumlah_barang = mysqli_real_escape_string($this->db->link, $data['jumlah_barang']);
        $satuan_barang = mysqli_real_escape_string($this->db->link, $data['satuan_barang']);
        $harga_beli = mysqli_real_escape_string($this->db->link, $data['harga_beli']);
        $status_barang = ($data['status_barang'] === 'true') ? 1 : 0;

        // Simpan sesi lama di input value
        $_SESSION['old'] = $data;

        // Cek kode barang
        $checkBarang = "SELECT * FROM `barang` WHERE `kode_barang` = '$kode_barang'";
        $hasilCheck = $this->db->pilih($checkBarang);

        if ($hasilCheck->num_rows > 0) {
            $_SESSION['pesan_alert'] = "Kode Barang sudah ada";
            $_SESSION['tipe_alert'] = "error";
            header("Location: masukkan-data.php");
            exit();
        } elseif (empty($kode_barang)) {
            $_SESSION['pesan_alert'] = "Kode Barang tidak boleh kosong";
            $_SESSION['tipe_alert'] = "error";
            header("Location: masukkan-data.php");
            exit();
        } elseif (empty($nama_barang)) {
            $_SESSION['pesan_alert'] = "Nama Barang tidak boleh kosong";
            $_SESSION['tipe_alert'] = "error";
            header("Location: masukkan-data.php");
            exit();
        } elseif (empty($jumlah_barang)) {
            $_SESSION['pesan_alert'] = "Jumlah Barang tidak boleh kosong";
            $_SESSION['tipe_alert'] = "error";
            header("Location: masukkan-data.php");
            exit();
        } elseif (empty($satuan_barang)) {
            $_SESSION['pesan_alert'] = "Satuan Barang tidak boleh kosong";
            $_SESSION['tipe_alert'] = "error";
            header("Location: masukkan-data.php");
            exit();
        } elseif (empty($harga_beli)) {
            $_SESSION['pesan_alert'] = "Harga Beli tidak boleh kosong";
            $_SESSION['tipe_alert'] = "error";
            header("Location: masukkan-data.php");
            exit();
        } else {
            $query = "INSERT INTO `barang`(`kode_barang`, `nama_barang`, `jumlah_barang`, `satuan_barang`, `harga_beli`, `status_barang`) 
            VALUES ('$kode_barang', '$nama_barang', '$jumlah_barang', '$satuan_barang', '$harga_beli', '$status_barang')";

            $result = $this->db->masukkan($query);

            if ($result) {
                unset($_SESSION['old']);
                $_SESSION['toast_message'] = "Berhasil Dimasukkan";
                $_SESSION['toast_type'] = "success";
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['toast_message'] = "Gagal Dimasukkan";
                $_SESSION['toast_type'] = "error";
                header("Location: index.php");
                exit();
            }
        }
    }

    public function semuaBarang()
    {
        $query = "SELECT * FROM `barang` ORDER BY id_barang DESC";
        $result = $this->db->pilih($query);
        return $result;
    }


    public function pakaiBarang($kode_barang, $jumlah)
    {
        $kode_barang = mysqli_real_escape_string($this->db->link, $kode_barang);
        $jumlah = (int) $jumlah;

        $query = "UPDATE `barang` SET `jumlah_barang` = `jumlah_barang` - $jumlah WHERE `kode_barang` = '$kode_barang' AND `jumlah_barang` >= $jumlah";

        $result = $this->db->update($query);

        if ($result) {
            $_SESSION['toast_message'] = "Barang berhasil dipakai.";
            $_SESSION['toast_type'] = "success";
            return true;
        } else {
            $_SESSION['toast_message'] = "Gagal memakai barang.";
            $_SESSION['toast_type'] = "error";
            return false;
        }
    }

    public function tambahJumlahBarang($kode_barang, $jumlah)
    {
        $kode_barang = mysqli_real_escape_string($this->db->link, $kode_barang);
        $jumlah = (int) $jumlah;

        $query = "UPDATE `barang` SET `jumlah_barang` = `jumlah_barang` + $jumlah WHERE `kode_barang` = '$kode_barang'";

        $result = $this->db->update($query);

        if ($result) {
            $_SESSION['toast_message'] = "Jumlah barang berhasil ditambah.";
            $_SESSION['toast_type'] = "success";
            return true;
        } else {
            $_SESSION['toast_message'] = "Gagal menambah jumlah barang.";
            $_SESSION['toast_type'] = "error";
            return false;
        }
    }

    public function updateStatusBarang($kode_barang, $status_barang)
    {
        $kode_barang = mysqli_real_escape_string($this->db->link, $kode_barang);
        $status_barang = (int) $status_barang;

        $query = "UPDATE `barang` SET `status_barang` = $status_barang WHERE `kode_barang` = '$kode_barang'";

        $result = $this->db->update($query);

        if ($result) {
            $_SESSION['toast_message'] = "Status barang berhasil diganti.";
            $_SESSION['toast_type'] = "success";
            return true;
        } else {
            $_SESSION['toast_message'] = "Gagal mengganti status barang.";
            $_SESSION['toast_type'] = "error";
            return false;
        }
    }

    public function pilihBarang($id)
    {
        $query = "SELECT * FROM `barang` WHERE id_barang='$id'";
        $result = $this->db->pilih($query);
        return $result;
    }

    public function updateBarang($data, $id)
    {
        $kode_barang = mysqli_real_escape_string($this->db->link, $data['kode_barang']);
        $nama_barang = mysqli_real_escape_string($this->db->link, $data['nama_barang']);
        $jumlah_barang = mysqli_real_escape_string($this->db->link, $data['jumlah_barang']);
        $satuan_barang = mysqli_real_escape_string($this->db->link, $data['satuan_barang']);
        $harga_beli = mysqli_real_escape_string($this->db->link, $data['harga_beli']);
        $status_barang = ($data['status_barang'] === 'true') ? 1 : 0;

        if (empty($kode_barang)) {
            $_SESSION['pesan_alert'] = "Kode Barang tidak boleh kosong";
            $_SESSION['tipe_alert'] = "error";
            header("Location: edit.php?id=$id");
            exit();
        } elseif (empty($nama_barang)) {
            $_SESSION['pesan_alert'] = "Nama Barang tidak boleh kosong";
            $_SESSION['tipe_alert'] = "error";
            header("Location: edit.php?id=$id");
            exit();
        } elseif (empty($jumlah_barang)) {
            $_SESSION['pesan_alert'] = "Jumlah Barang tidak boleh kosong";
            $_SESSION['tipe_alert'] = "error";
            header("Location: edit.php?id=$id");
            exit();
        } elseif (empty($satuan_barang)) {
            $_SESSION['pesan_alert'] = "Satuan Barang tidak boleh kosong";
            $_SESSION['tipe_alert'] = "error";
            header("Location: edit.php?id=$id");
            exit();
        } elseif (empty($harga_beli)) {
            $_SESSION['pesan_alert'] = "Harga Beli tidak boleh kosong";
            $_SESSION['tipe_alert'] = "error";
            header("Location: edit.php?id=$id");
            exit();
        } else {
            // Fetch the current kode_barang from the database
            $current_query = "SELECT kode_barang FROM `barang` WHERE id_barang = $id";
            $current_result = $this->db->pilih($current_query);
            $current_row = mysqli_fetch_assoc($current_result);
            $current_kode_barang = $current_row['kode_barang'];

            // Check if kode_barang has changed
            if ($kode_barang !== $current_kode_barang) {
                // Check if the new kode_barang already exists
                $check_query = "SELECT * FROM `barang` WHERE kode_barang = '$kode_barang'";
                $check_result = $this->db->pilih($check_query);

                if ($check_result) {
                    $_SESSION['pesan_alert'] = "Kode Barang sudah ada";
                    $_SESSION['tipe_alert'] = "error";
                    header("Location: edit.php?id=$id");
                    exit();
                }
            }

            // Update the record
            $update_query = "UPDATE `barang` SET `kode_barang`='$kode_barang',`nama_barang`='$nama_barang',`jumlah_barang`='$jumlah_barang',`satuan_barang`='$satuan_barang', `harga_beli`='$harga_beli', `status_barang`='$status_barang' WHERE id_barang=$id";

            $result = $this->db->update($update_query);

            if ($result) {
                $_SESSION['toast_message'] = "Berhasil Diupdate";
                $_SESSION['toast_type'] = "success";
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['toast_message'] = "Gagal Diupdate";
                $_SESSION['toast_type'] = "error";
                header("Location: index.php");
                exit();
            }
        }
    }

    public function hapusBarang($id)
    {
        $query = "DELETE FROM `barang` WHERE id_barang='$id'";
        $result = $this->db->hapus($query);
        if ($result) {
            $_SESSION['toast_message'] = "Berhasil Dihapus";
            $_SESSION['toast_type'] = "success";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['toast_message'] = "Gagal Dihapus";
            $_SESSION['toast_type'] = "error";
            header("Location: index.php");
            exit();
        }
    }
}
