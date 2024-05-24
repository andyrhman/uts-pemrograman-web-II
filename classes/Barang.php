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
        $kode_barang = $data['kode_barang'];
        $nama_barang = $data['nama_barang'];
        $jumlah_barang = $data['jumlah_barang'];
        $satuan_barang = $data['satuan_barang'];
        $harga_beli = $data['harga_beli'];
        $status_barang = ($data['status_barang'] === 'true') ? 1 : 0;

        // Simpan sesi lama data
        $_SESSION['old'] = $data;

        // Check kode barang
        $checkBarangQuery = "SELECT * FROM `barang` WHERE `kode_barang` = ?";
        $hasilCheck = $this->db->siapkanPilihan($checkBarangQuery, 's', $kode_barang);

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
                      VALUES (?, ?, ?, ?, ?, ?)";
            $hasil = $this->db->siapkanDanJalankan($query, 'ssisii', $kode_barang, $nama_barang, $jumlah_barang, $satuan_barang, $harga_beli, $status_barang);

            if ($hasil > 0) {
                unset($_SESSION['old']);
                $_SESSION['pesan_toast'] = "Berhasil Dimasukkan";
                $_SESSION['tipe_toast'] = "success";
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['pesan_toast'] = "Gagal Dimasukkan";
                $_SESSION['tipe_toast'] = "error";
                header("Location: index.php");
                exit();
            }
        }
    }

    public function semuaBarang()
    {
        $query = "SELECT * FROM `barang` ORDER BY id_barang DESC";
        $hasil = $this->db->pilih($query);
        return $hasil;
    }

    public function pakaiBarang($kode_barang, $jumlah)
    {
        $kode_barang = mysqli_real_escape_string($this->db->link, $kode_barang);
        $jumlah = (int) $jumlah;

        // Periksa jumlah_barang saat ini
        $queryPeriksa = "SELECT `jumlah_barang` FROM `barang` WHERE `kode_barang` = '$kode_barang'";
        $hasilPeriksa = $this->db->pilih($queryPeriksa);
        if ($hasilPeriksa && $hasilPeriksa->num_rows > 0) {
            $baris = $hasilPeriksa->fetch_assoc();
            $jumlahSaatIni = (int) $baris['jumlah_barang'];

            if ($jumlah > $jumlahSaatIni) {
                $_SESSION['pesan_toast'] = "Jumlah barang tidak mencukupi.";
                $_SESSION['tipe_toast'] = "error";
                return false;
            }
        } else {
            $_SESSION['pesan_toast'] = "Barang tidak ditemukan.";
            $_SESSION['tipe_toast'] = "error";
            return false;
        }

        // Lanjutkan untuk memperbarui jumlah_barang jika pemeriksaan lolos
        $queryPerbarui = "UPDATE `barang` SET `jumlah_barang` = `jumlah_barang` - $jumlah WHERE `kode_barang` = '$kode_barang' AND `jumlah_barang` >= $jumlah";
        $hasil = $this->db->update($queryPerbarui);

        if ($hasil) {
            $_SESSION['pesan_toast'] = "Barang berhasil dipakai.";
            $_SESSION['tipe_toast'] = "success";
            return true;
        } else {
            $_SESSION['pesan_toast'] = "Gagal memakai barang.";
            $_SESSION['tipe_toast'] = "error";
            return false;
        }
    }

    public function tambahJumlahBarang($kode_barang, $jumlah)
    {
        $kode_barang = mysqli_real_escape_string($this->db->link, $kode_barang);
        $jumlah = (int) $jumlah;

        $query = "UPDATE `barang` SET `jumlah_barang` = `jumlah_barang` + $jumlah WHERE `kode_barang` = '$kode_barang'";

        $hasil = $this->db->update($query);

        if ($hasil) {
            $_SESSION['pesan_toast'] = "Jumlah barang berhasil ditambah.";
            $_SESSION['tipe_toast'] = "success";
            return true;
        } else {
            $_SESSION['pesan_toast'] = "Gagal menambah jumlah barang.";
            $_SESSION['tipe_toast'] = "error";
            return false;
        }
    }

    public function updateStatusBarang($kode_barang, $status_barang)
    {
        $kode_barang = mysqli_real_escape_string($this->db->link, $kode_barang);
        $status_barang = (int) $status_barang;

        $query = "UPDATE `barang` SET `status_barang` = $status_barang WHERE `kode_barang` = '$kode_barang'";

        $hasil = $this->db->update($query);

        if ($hasil) {
            $_SESSION['pesan_toast'] = "Status barang berhasil diganti.";
            $_SESSION['tipe_toast'] = "success";
            return true;
        } else {
            $_SESSION['pesan_toast'] = "Gagal mengganti status barang.";
            $_SESSION['tipe_toast'] = "error";
            return false;
        }
    }

    public function pilihBarang($id)
    {
        $query = "SELECT * FROM `barang` WHERE id_barang = ?";
        return $this->db->siapkanPilihan($query, "i", $id);
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
            // Ambil data kode barang di database
            $cari_kodebarang = "SELECT kode_barang FROM `barang` WHERE id_barang = $id";
            $hasil_pencarian = $this->db->pilih($cari_kodebarang);
            $row_pencarian = mysqli_fetch_assoc($hasil_pencarian);
            $kodebarang_tercari = $row_pencarian['kode_barang'];

            // Cek jika kode barang berubah
            if ($kode_barang !== $kodebarang_tercari) {
                // Cek jika kode barang terbaru ada
                $cek_query = "SELECT * FROM `barang` WHERE kode_barang = '$kode_barang'";
                $cek_hasil = $this->db->pilih($cek_query);

                if ($cek_hasil) {
                    $_SESSION['pesan_alert'] = "Kode Barang sudah ada";
                    $_SESSION['tipe_alert'] = "error";
                    header("Location: edit.php?id=$id");
                    exit();
                }
            }

            // Update data barang
            $update_query = "UPDATE `barang` SET `kode_barang`='$kode_barang',`nama_barang`='$nama_barang',`jumlah_barang`='$jumlah_barang',`satuan_barang`='$satuan_barang', `harga_beli`='$harga_beli', `status_barang`='$status_barang' WHERE id_barang=$id";

            $hasil = $this->db->update($update_query);

            if ($hasil) {
                $_SESSION['pesan_toast'] = "Berhasil Diupdate";
                $_SESSION['tipe_toast'] = "success";
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['pesan_toast'] = "Gagal Diupdate";
                $_SESSION['tipe_toast'] = "error";
                header("Location: index.php");
                exit();
            }
        }
    }

    public function hapusBarang($id)
    {
        $query = "DELETE FROM `barang` WHERE id_barang='$id'";
        $hasil = $this->db->hapus($query);
        if ($hasil) {
            $_SESSION['pesan_toast'] = "Berhasil Dihapus";
            $_SESSION['tipe_toast'] = "success";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['pesan_toast'] = "Gagal Dihapus";
            $_SESSION['tipe_toast'] = "error";
            header("Location: index.php");
            exit();
        }
    }
}
