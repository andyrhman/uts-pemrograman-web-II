<!-- Bootstrap Toast -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="liveToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
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