<?php
session_start();
include_once "classes/Barang.php";

$re = new Barang();

$titleHalaman = "Home";

// Parameter paginasi
$limit = 10; // Jumlah data tiap halaman
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$offset = ($halaman - 1) * $limit;

// Ambil semua barang dan total barang
$semuaBarang = $re->semuaBarang($limit, $offset);
$totalBarang = $re->hitungBarang();

// Hitung total halaman
$totalHalaman = ceil($totalBarang / $limit);

function linkHalaman($halaman, $totalHalaman)
{
    $paginasi = [];

    // Selalu perlihatkan halaman pertama
    if ($halaman > 3) {
        $paginasi[] = 1;
        if ($halaman > 4) {
            $paginasi[] = '...';
        }
    }

    // Halaman sekitar halaman saat ini
    for ($i = max(1, $halaman - 2); $i <= min($totalHalaman, $halaman + 2); $i++) {
        $paginasi[] = $i;
    }

    // Selalu perlihatkan halaman terakhir
    if ($halaman < $totalHalaman - 2) {
        if ($halaman < $totalHalaman - 3) {
            $paginasi[] = '...';
        }
        $paginasi[] = $totalHalaman;
    }

    return $paginasi;
}

$linkHalaman = linkHalaman($halaman, $totalHalaman);

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

include("includes/header.php");
include("includes/navbar.php");
?>

<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Kode Barang</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Jumlah Barang</th>
                <th scope="col">Satuan Barang</th>
                <th scope="col">Harga Beli</th>
                <th scope="col">Status Barang</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rowNumber = $offset + 1;
            if ($semuaBarang) {
                while ($row = mysqli_fetch_assoc($semuaBarang)) {
                    $status = $row['status_barang'] == 1 ? 'Available' : 'Not Available';
                    $badgeClass = $row['status_barang'] == 1 ? 'text-bg-info' : 'text-bg-warning';
            ?>
                    <tr>
                        <th scope="row"><?= $rowNumber++ ?></th>
                        <td><?= $row['kode_barang'] ?></td>
                        <td><?= $row['nama_barang'] ?></td>
                        <td><?= $row['jumlah_barang'] ?></td>
                        <td><?= $row['satuan_barang'] ?></td>
                        <td><?= $row['harga_beli'] ?></td>
                        <td><span class="badge rounded-pill <?= $badgeClass ?>"><?= $status ?></span></td>
                        <td>
                            <!-- Form to use items -->
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="kode_barang" value="<?= $row['kode_barang'] ?>">
                                <input type="number" name="jumlah" min="1" placeholder="Jumlah" required>
                                <button type="submit" name="pakai_barang" class="btn btn-warning btn-sm">Pakai</button>
                            </form>
                            <!-- Form to add items -->
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="kode_barang" value="<?= $row['kode_barang'] ?>">
                                <input type="number" name="jumlah" min="1" placeholder="Jumlah" required>
                                <button type="submit" name="tambah_jumlah_barang" class="btn btn-info btn-sm">Tambah</button>
                            </form>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
    <div class="d-flex flex-column align-items-center border-top bg-white px-3 flex-sm-row justify-content-sm-between">
        <span class="text-muted small small-sm"> Memperlihatkan <?= ($offset + 1) ?> sampai <?= min($offset + $limit, $totalBarang) ?> dari <?= $totalBarang ?> Data </span>
        <ul class="pagination justify-content-center mt-2 mt-sm-0">
            <li class="page-item <?= $halaman <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?halaman=<?= max(1, $halaman - 1) ?>">Previous</a>
            </li>
            <?php foreach ($linkHalaman as $link) { ?>
                <?php if ($link == '...') { ?>
                    <li class="page-item disabled"><a class="page-link">...</a></li>
                <?php } else { ?>
                    <li class="page-item <?= $link == $halaman ? 'active' : '' ?>">
                        <a class="page-link" href="?halaman=<?= $link ?>"><?= $link ?></a>
                    </li>
                <?php } ?>
            <?php } ?>
            <li class="page-item <?= $halaman >= $totalHalaman ? 'disabled' : '' ?>">
                <a class="page-link" href="?halaman=<?= min($totalHalaman, $halaman + 1) ?>">Next</a>
            </li>
        </ul>
    </div>
</div>

<!-- Bootstrap Toast -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="liveToast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <?php
                if (isset($_SESSION['toast_message'])) {
                    echo $_SESSION['toast_message'];
                    unset($_SESSION['toast_message']);
                }
                ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

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
<?php include("includes/footer.php") ?>