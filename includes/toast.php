<!-- 
    Project Ini Dibuat oleh:
    NAMA :ANDY RAHMAN RAMADHAN
    NIM  :220401070404
    KELAS:IT403
    MAPEL:PEMROGRAMAN WEB II
 -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="liveToast" class="toast align-items-center <?php echo (isset($_SESSION['tipe_toast']) && $_SESSION['tipe_toast'] == 'error') ? 'text-bg-danger' : 'text-bg-success'; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <?php
                if (isset($_SESSION['pesan_toast'])) {
                    echo $_SESSION['pesan_toast'];
                    unset($_SESSION['pesan_toast']);
                }
                ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        <?php if (isset($_SESSION['tipe_toast'])) { ?>
            var toastLiveExample = document.getElementById('liveToast');
            var toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
            toastBootstrap.show();
            <?php unset($_SESSION['tipe_toast']); ?>
        <?php } ?>
    });
</script>