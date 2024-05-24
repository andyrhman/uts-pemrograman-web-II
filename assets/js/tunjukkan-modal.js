document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('exampleModal');

    modal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        var kodeBarang = button.getAttribute('data-kode-barang');

        var inputs = modal.querySelectorAll('input[name="kode_barang"]');
        inputs.forEach(function (input) {
            input.value = kodeBarang;
        });
    });
});
