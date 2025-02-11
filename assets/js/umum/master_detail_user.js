
let datatable; 

const list_proposal = (status) => {
  console.log("test");
  if ($.fn.DataTable.isDataTable(datatable)) {
    datatable.clear().destroy();
  }

  $.ajax({
    url: `${BASE_URL}C_master_data/get_list_proposal`,
    method: "POST",
    data: { id: status, nip: $('input[name="nip"]').val() },
    dataType: "json",
    success: (res) => {
      // $(".table-bordered").DataTable().clear().destroy();

      $(".isi_histori").html(res.data);

      datatable = $("#historitb").DataTable({
        // scrollX: true,
        // scrollY: 200,
        language: {
          search : 'Cari',
          lengthMenu: 'Menampilkan _MENU_ data',
          info: 'Menampilkan _PAGE_ sampai _PAGES_ dari _MAX_ data',
          infoFiltered: '(difilter dari _MAX_ data)',
          paginate: {
            previous: 'Sebelumnya',
            next: 'Selanjutnya'
          },
          emptyTable: "Tidak Ada Data"
        },
        lengthMenu: [[10,15,20],[10,15,20]]  
      });
      $(".dataTables_length").addClass("bs-select");
    },
  });
};

$(document).ready(function () {
  list_proposal(0);

  $(".tablur").click(function (e) {
    e.preventDefault();
    $(this).addClass("active");

    const id_list = $(this).data("status");
    $(`.tablur`).removeClass("active");
    $(`.tablur[data-status="${id_list}"]`).addClass("active");
    console.log($(this).data("status"));
    list_proposal(id_list);
  });
  // datatable = $("#historitb").DataTable({
  //   scrollX: true,
  //   scrollY: 200,
  // });

  
});
