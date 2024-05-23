                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
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
                                        <button type="submit" name="tambah_jumlah_barang" class="btn btn-info btn-sm">Tambah</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>