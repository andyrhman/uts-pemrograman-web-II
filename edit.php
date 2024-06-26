<?php
/* 
    Project Ini Dibuat oleh:
    NAMA :ANDY RAHMAN RAMADHAN
    NIM  :220401070404
    KELAS:IT403
    MAPEL:PEMROGRAMAN WEB II
*/

session_start();
include_once "classes/Barang.php";

$re = new Barang();
$id = isset($_GET["id"]) ? $_GET["id"] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && $id !== null) {
    $re->updateBarang($_POST, $id);
}

$titleHalaman = "Edit Data";
$titleNavCenter = '<h4 class="salsa-regular">Edit Data Barang</h4>';
$titleNavButton = '
<a href="index.php" class="btn btn-outline-primary me-2">
<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
    fill="#3B71CA">
    <path
        d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z" />
</svg>
Lihat Data
</a>
';

include("includes/header.php");
include("includes/navbar.php");
?>

<div class="container container-small">
    <div class="pt-2 pb-5">
        <?php
        if ($id !== null) {
            $pilihBarang = $re->pilihBarang($id);
            if ($pilihBarang) {
                while ($row = $pilihBarang->fetch_assoc()) {
        ?>
                    <form method="post">

                        <?php include("pesan.php") ?>

                        <div class="mb-3">
                            <label for="kode_barang" class="form-label">Kode Barang</label>
                            <input type="text" value="<?= htmlspecialchars($row['kode_barang'], ENT_QUOTES, 'UTF-8') ?>" name="kode_barang" class="form-control" id="kode_barang" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" value="<?= htmlspecialchars($row['nama_barang'], ENT_QUOTES, 'UTF-8') ?>" name="nama_barang" class="form-control" id="nama_barang" required>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                            <input type="number" value="<?= htmlspecialchars($row['jumlah_barang'], ENT_QUOTES, 'UTF-8') ?>" name="jumlah_barang" class="form-control" id="jumlah_barang" required>
                        </div>
                        <div class="mb-3">
                            <label for="satuan_barang" class="form-label">Satuan Barang</label>
                            <select class="form-select" name="satuan_barang" id="satuan_barang" required>
                                <option value="<?= htmlspecialchars($row['satuan_barang'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($row['satuan_barang'], ENT_QUOTES, 'UTF-8') ?></option>
                                <option value="kg">Kg</option>
                                <option value="pcs">Pcs</option>
                                <option value="liter">Liter</option>
                                <option value="meter">Meter</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="harga_beli" class="form-label">Harga Beli</label>
                            <input type="number" value="<?= htmlspecialchars($row['harga_beli'], ENT_QUOTES, 'UTF-8') ?>" name="harga_beli" class="form-control" id="harga_beli" required>
                        </div>
                        <div class="mb-3">
                            <label for="status_barang" class="form-label">Status Barang</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_barang" value="true" <?php if ($row['status_barang'] == 1) echo 'checked'; ?>>
                                <label class="form-check-label">Available</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_barang" value="false" <?php if ($row['status_barang'] == 0) echo 'checked'; ?>>
                                <label class="form-check-label">Not Available</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
        <?php
                }
            }
        }
        ?>
    </div>
</div>

<?php include("includes/footer.php") ?>