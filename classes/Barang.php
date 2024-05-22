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

        if (empty($kode_barang)) {
            $msg = "Kode Barang tidak boleh kosong";
            return $msg;
        } elseif (empty($nama_barang)) {
            $msg = "Nama Barang tidak boleh kosong";
            return $msg;
        } elseif (empty($jumlah_barang)) {
            $msg = "Jumlah Barang tidak boleh kosong";
            return $msg;
        } elseif (empty($satuan_barang)) {
            $msg = "Satuan Barang tidak boleh kosong";
            return $msg;
        } elseif (empty($harga_beli)) {
            $msg = "Harga Beli tidak boleh kosong";
            return $msg;
        } else {
            $query = "INSERT INTO `barang`(`kode_barang`, `nama_barang`, `jumlah_barang`, `satuan_barang`, `harga_beli`, `status_barang`) 
            VALUES ('$kode_barang', '$nama_barang', '$jumlah_barang', '$satuan_barang', '$harga_beli', '$status_barang')";

            $result = $this->db->masukkan($query);

            if ($result) {
                $_SESSION['pesan_alert'] = "Berhasil Dimasukkan";
                $_SESSION['tipe_alert'] = "success";
                header("Location: masukkan-data.php");
                exit();
            } else {
                $_SESSION['pesan_alert'] = "Gagal Dimasukkan";
                $_SESSION['tipe_alert'] = "error";
                header("Location: masukkan-data.php");
                exit();
            }
        }
    }

    public function semuaBarang($limit, $offset)
    {
        $query = "SELECT * FROM `barang` ORDER BY id_barang DESC LIMIT $limit OFFSET $offset";
        $result = $this->db->pilih($query);
        return $result;
    }

    public function hitungBarang()
    {
        $query = "SELECT COUNT(*) as count FROM `barang`";
        $result = $this->db->pilih($query);
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
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

    // public function getStudentById($id)
    // {
    //     $query = "SELECT * FROM `tbl_register` WHERE id='$id'";
    //     $result = $this->db->select($query);
    //     return $result;
    // }

    // public function updateStudent($data, $file, $id)
    // {
    //     $name = mysqli_real_escape_string($this->db->link, $data['name']);
    //     $email = mysqli_real_escape_string($this->db->link, $data['email']);
    //     $phone = mysqli_real_escape_string($this->db->link, $data['phone']);
    //     $address = mysqli_real_escape_string($this->db->link, $data['address']);

    //     $permitted = array("jpg", "jpeg", "png", "gif");
    //     $file_name = $file['photo']['name'];
    //     $file_size = $file['photo']['size'];
    //     $file_temp = $file['photo']['tmp_name'];

    //     $div = explode(".", $file_name);
    //     $file_ext = strtolower(end($div));
    //     $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
    //     $upload_image = "upload/" . $unique_image;

    //     if (empty($name) || empty($email) || empty($phone) || empty($address)) {
    //         $msg = "Field must not be empty";
    //         return $msg;
    //     }
    //     if (!empty($file_name)) {
    //         if ($file_size > 1048567) {
    //             $msg = "File size must be less than 1 MB";
    //             return $msg;
    //         } elseif (!in_array($file_ext, $permitted)) {
    //             $msg = "You can only upload " . implode(",", $permitted);
    //             return $msg;
    //         } else {

    //             $img_query = "SELECT * FROM tbl_register WHERE id = '$id'";
    //             $img_res = $this->db->select($img_query);
    //             if ($img_res) {
    //                 while ($row = mysqli_fetch_assoc($img_res)) {
    //                     $photo = $row["photo"];
    //                     unlink($photo);
    //                 }
    //             }

    //             move_uploaded_file($file_temp, $upload_image);
    //             $query = "UPDATE `tbl_register` SET `name`='$name',`email`='$email',
    //                 `phone`='$phone',`photo`='$upload_image',`address`='$address' WHERE id=$id";

    //             $result = $this->db->insert($query);

    //             if ($result) {
    //                 $msg = "Student Updated Successfull";
    //                 return $msg;
    //             } else {
    //                 $msg = "Update Failed";
    //                 return $msg;
    //             }

    //         }
    //     } else {
    //         $query = "UPDATE `tbl_register` SET `name`='$name',`email`='$email',
    //         `phone`='$phone',`address`='$address' WHERE id=$id";

    //         $result = $this->db->insert($query);

    //         if ($result) {
    //             $msg = "Student Updated Successfull";
    //             return $msg;
    //         } else {
    //             $msg = "Update Failed";
    //             return $msg;
    //         }
    //     }

    // }

    // public function deleteStudent($id)
    // {
    //     $img_query = "SELECT * FROM tbl_register WHERE id = '$id'";
    //     $img_res = $this->db->select($img_query);
    //     if ($img_res) {
    //         while ($row = mysqli_fetch_assoc($img_res)) {
    //             $photo = $row["photo"];
    //             unlink($photo);
    //         }
    //     }

    //     $query = "DELETE FROM `tbl_register` WHERE id='$id'";
    //     $result = $this->db->delete($query);
    //     if ($result) {
    //         $msg = "Deleted Successfully";
    //         return $msg;
    //     } else {
    //         $msg = "Delete Failed";
    //         return $msg;
    //     }
    // }
}
