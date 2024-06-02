<!-- 
    Project Ini Dibuat oleh:
    NAMA :ANDY RAHMAN RAMADHAN
    NIM  :220401070404
    KELAS:IT403
    MAPEL:PEMROGRAMAN WEB II
 -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Pakai atau Tambah Barang</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" class="mb-3">
                    <label for="pakaiJumlah" class="form-label">Barang Dipakai</label>
                    <input type="hidden" name="kode_barang" value="<?= $row['kode_barang'] ?>">
                    <div class="input-group mb-2">
                        <input type="number" class="form-control" name="jumlah" min="1" placeholder="Jumlah">
                        <button type="submit" name="pakai_barang" class="btn btn-warning">Pakai</button>
                    </div>
                </form>
                <form method="POST">
                    <label for="pakaiJumlah" class="form-label">Barang Ditambah</label>
                    <input type="hidden" name="kode_barang" value="<?= $row['kode_barang'] ?>">
                    <div class="input-group">
                        <input type="number" class="form-control" name="jumlah" min="1" placeholder="Jumlah">
                        <button type="submit" name="tambah_jumlah_barang" class="btn btn-info">Tambah</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                        <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
                    </svg>
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>