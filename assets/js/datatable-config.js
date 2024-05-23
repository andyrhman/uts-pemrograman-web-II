$('#data_barang').DataTable({
    paging: true,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
    pageLength: 10,
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]], // Customize the entries dropdown
    language: {
        processing: "Sedang diproses...",
        search: "Cari&nbsp;:",
        lengthMenu: "Tampilkan _MENU_ entri",
        info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
        infoEmpty: "Menampilkan 0 hingga 0 dari 0 entri",
        infoFiltered: "(disaring dari _MAX_ entri total)",
        infoPostFix: "",
        loadingRecords: "Memuat...",
        zeroRecords: "Tidak ada entri yang tersedia untuk ditampilkan",
        emptyTable: "Tidak ada data yang tersedia dalam tabel",
        aria: {
            sortAscending: ": aktifkan untuk mengurutkan kolom secara ascending",
            sortDescending: ": aktifkan untuk mengurutkan kolom secara descending"
        }
    }

});