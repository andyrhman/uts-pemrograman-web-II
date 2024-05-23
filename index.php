<?php
session_start();
include_once "classes/Barang.php";

$re = new Barang();

$titleHalaman = "Daftar Data";
$titleNavCenter = '<h4>Daftar Data Barang</h4>';
$titleNavButton = '
<a href="masukkan-data.php" class="btn btn-outline-primary me-2">
<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
    fill="#3B71CA">
    <path
        d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z" />
</svg>
Tambah Data
</a>
';

$semuaBarang = $re->semuaBarang();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['pakai_barang'])) {
        $kode_barang = $_POST['kode_barang'];
        $jumlah = $_POST['jumlah'];
        $re->pakaiBarang($kode_barang, $jumlah);
    } elseif (isset($_POST['tambah_jumlah_barang'])) {
        $kode_barang = $_POST['kode_barang'];
        $jumlah = $_POST['jumlah'];
        $re->tambahJumlahBarang($kode_barang, $jumlah);
    }
    header("Location: " . $_SERVER['PHP_SELF'] . "?halaman=" . $halaman);
    exit();
}

include ("includes/header.php");
include ("includes/navbar.php");
?>

<div class="container">
    <table id="data_barang" class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Jumlah Barang</th>
                <th>Satuan Barang</th>
                <th>Harga Beli</th>
                <th>Status Barang</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rowNumber = +1;
            if ($semuaBarang) {
                while ($row = mysqli_fetch_assoc($semuaBarang)) {
                    $status = $row['status_barang'] == 1 ? 'Available' : 'Not Available';
                    $badgeClass = $row['status_barang'] == 1 ? 'text-bg-info' : 'text-bg-warning';

                    // Format harga_beli menjadi Rupiah
                    $formatHargaBeli = "Rp" . number_format($row['harga_beli'], 0, ',', '.');
                    ?>
                    <tr>
                        <th scope="row"><?= $rowNumber++ ?></th>
                        <td><?= $row['kode_barang'] ?></td>
                        <td><?= $row['nama_barang'] ?></td>
                        <td><?= $row['jumlah_barang'] ?></td>
                        <td><?= $row['satuan_barang'] ?></td>
                        <td><?= $formatHargaBeli ?></td>
                        <td><span class="badge rounded-pill <?= $badgeClass ?>"><?= $status ?></span></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary rounded" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" data-kode-barang="<?= $row['kode_barang'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                    fill="#e8eaed">
                                    <path
                                        d="M216-720h528l-34-40H250l-34 40Zm184 270 80-40 80 40v-190H400v190ZM200-120q-33 0-56.5-23.5T120-200v-499q0-14 4.5-27t13.5-24l50-61q11-14 27.5-21.5T250-840h460q18 0 34.5 7.5T772-811l50 61q9 11 13.5 24t4.5 27v139q-21 0-41.5 3T760-545v-95H640v205l-77 77-83-42-160 80v-320H200v440h280v80H200Zm440-520h120-120Zm-440 0h363-363Zm360 520v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T903-340L683-120H560Zm300-263-37-37 37 37ZM620-180h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Pakai atau Tambah barang</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="kode_barang" value="<?= $row['kode_barang'] ?>">
                                        <input type="number" name="jumlah" min="1" placeholder="Jumlah">
                                        <button type="submit" name="pakai_barang" class="btn btn-warning btn-sm">Pakai</button>
                                    </form>
                                    <!-- Form to add items -->
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="kode_barang" value="<?= $row['kode_barang'] ?>">
                                        <input type="number" name="jumlah" min="1" placeholder="Jumlah">
                                        <button type="submit" name="tambah_jumlah_barang"
                                            class="btn btn-info btn-sm">Tambah</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>


<!-- Bootstrap Toast -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="liveToast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <?php
                if (isset($_SESSION['toast_message'])) {
                    echo $_SESSION['toast_message'];
                    unset($_SESSION['toast_message']);
                }
                ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>

<script src="assets/js/datatable-config.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        <?php if (isset($_SESSION['toast_type'])) { ?>
            var toastLiveExample = document.getElementById('liveToast');
            var toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
            toastBootstrap.show();
            <?php unset($_SESSION['toast_type']); ?>
        <?php } ?>
    });
</script>
<script src="assets/js/tunjukkan-modal.js"></script>

<?php include ("includes/footer.php") ?>