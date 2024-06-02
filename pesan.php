<?php
/* 
    Project Ini Dibuat oleh:
    NAMA :ANDY RAHMAN RAMADHAN
    NIM  :220401070404
    KELAS:IT403
    MAPEL:PEMROGRAMAN WEB II
*/

if (isset($_SESSION['pesan_alert'])) {
    $classAlert = $_SESSION['tipe_alert'] === "success" ? "alert-success" : "alert-danger";
?>
    <div class="alert <?= $classAlert ?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['pesan_alert'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
    unset($_SESSION['pesan_alert']);
    unset($_SESSION['tipe_alert']);
}
?>