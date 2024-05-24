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

// * Update Jumlah dan Pemakaian Barang
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
    header("Location: index.php");
    exit();
}

// * Hapus Barang
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    $re->hapusBarang($id);
}

include("includes/header.php");
include("includes/navbar.php");
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
                        <td>

                            <button type="button" class="btn badge rounded-pill <?= $badgeClass ?>" onclick="toggleStatus('<?= $row['kode_barang'] ?>', <?= $row['status_barang'] ?>)" style="outline: none;">
                                <?= $status ?>
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning rounded" data-bs-toggle="modal" data-bs-target="#exampleModal" data-kode-barang="<?= $row['kode_barang'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                    <path d="M216-720h528l-34-40H250l-34 40Zm184 270 80-40 80 40v-190H400v190ZM200-120q-33 0-56.5-23.5T120-200v-499q0-14 4.5-27t13.5-24l50-61q11-14 27.5-21.5T250-840h460q18 0 34.5 7.5T772-811l50 61q9 11 13.5 24t4.5 27v139q-21 0-41.5 3T760-545v-95H640v205l-77 77-83-42-160 80v-320H200v440h280v80H200Zm440-520h120-120Zm-440 0h363-363Zm360 520v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T903-340L683-120H560Zm300-263-37-37 37 37ZM620-180h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z" />
                                </svg>
                            </button>
                            <a href="edit.php?id=<?= $row["id_barang"] ?>" class="btn btn-sm btn-info rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                    <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h357l-80 80H200v560h560v-278l80-80v358q0 33-23.5 56.5T760-120H200Zm280-360ZM360-360v-170l367-367q12-12 27-18t30-6q16 0 30.5 6t26.5 18l56 57q11 12 17 26.5t6 29.5q0 15-5.5 29.5T897-728L530-360H360Zm481-424-56-56 56 56ZM440-440h56l232-232-28-28-29-28-231 231v57Zm260-260-29-28 29 28 28 28-28-28Z" />
                                </svg>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger rounded" data-bs-toggle="modal" data-bs-target="#hapusModal" data-id="<?= $row["id_barang"] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                    <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <?php include('includes/barang_modal.php') ?>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>
<?php include('includes/hapus_modal.php') ?>
<?php include('includes/toast.php') ?>
<script>
    let deleteId;

    $('#hapusModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        deleteId = button.data('id');
    });

    document.getElementById('hapusData').addEventListener('click', function() {
        window.location.href = "?del=" + deleteId;
    });
</script>

<script>
    function toggleStatus(kode_barang, currentStatus) {
        var status_baru = currentStatus === 1 ? 0 : 1;
        $.ajax({
            url: 'ganti_status.php',
            method: 'POST',
            data: {
                kode_barang: kode_barang,
                status_barang: status_baru
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error("An error occurred: ", error);
            }
        });
    }
</script>
<script src="assets/js/datatable-config.js"></script>

<script src="assets/js/tunjukkan-modal.js"></script>

<?php include("includes/footer.php") ?>