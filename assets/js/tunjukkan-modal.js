document.addEventListener('DOMContentLoaded', function () {
    // Get the modal element
    var modal = document.getElementById('exampleModal');

    // Listen for the modal show event
    modal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        var button = event.relatedTarget;

        // Extract info from data attributes
        var kodeBarang = button.getAttribute('data-kode-barang');

        // Update the hidden input elements inside the modal
        var inputs = modal.querySelectorAll('input[name="kode_barang"]');
        inputs.forEach(function (input) {
            input.value = kodeBarang;
        });
    });
});
