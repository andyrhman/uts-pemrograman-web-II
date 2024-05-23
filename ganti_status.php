<?php
session_start();
include_once "classes/Barang.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_barang = $_POST['kode_barang'];
    $status_baru = $_POST['status_barang'];

    $re = new Barang();
    $updateResult = $re->updateStatusBarang($kode_barang, $status_baru);

    echo json_encode(['success' => $updateResult]);
}
exit();

