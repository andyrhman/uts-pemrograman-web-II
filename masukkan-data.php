<?php
session_start();
include_once "classes/Barang.php";

$re = new Barang();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $masukkan = $re->tambahBarang($_POST);
}
$titleHalaman = "Masukkan Data";
include("includes/header.php");
include("includes/navbar.php");
?>

<div class="container container-small">
    <div class="py-2 text-center">
        <div class="d-block mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#0000F5">
                <path d="M620-159 460-319l43-43 117 117 239-239 43 43-282 282Zm220-414h-60v-207h-60v90H240v-90h-60v600h251v60H180q-26 0-43-17t-17-43v-600q0-26 17-43t43-17h202q7-35 34.5-57.5T480-920q36 0 63.5 22.5T578-840h202q26 0 43 17t17 43v207ZM480-780q17 0 28.5-11.5T520-820q0-17-11.5-28.5T480-860q-17 0-28.5 11.5T440-820q0 17 11.5 28.5T480-780Z" />
            </svg>
        </div>
        <h4>Masukkan Data Barang</h4>
    </div>
    <form method="post">

        <?php include("pesan.php")?>

        <div class="mb-3">
            <label for="kode_barang" class="form-label">Kode Barang</label>
            <input type="text" name="kode_barang" class="form-control" id="kode_barang" required>
        </div>
        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" id="nama_barang" required>
        </div>
        <div class="mb-3">
            <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
            <input type="number" name="jumlah_barang" class="form-control" id="jumlah_barang" required>
        </div>
        <div class="mb-3">
            <label for="satuan_barang" class="form-label">Satuan Barang</label>
            <select class="form-select" name="satuan_barang" id="satuan_barang" required>
                <option value="">Pilih Satuan Barang</option>
                <option value="kg">Kg</option>
                <option value="pcs">Pcs</option>
                <option value="liter">Liter</option>
                <option value="meter">Meter</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="harga_beli" class="form-label">Harga Beli</label>
            <input type="number" name="harga_beli" class="form-control" id="harga_beli" required>
        </div>
        <div class="mb-3">
            <label for="status_barang" class="form-label">Status Barang</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status_barang" value="true" checked>
                <label class="form-check-label">
                    Available
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status_barang" value="false">
                <label class="form-check-label">
                    Not Available
                </label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php include("includes/footer.php") ?>