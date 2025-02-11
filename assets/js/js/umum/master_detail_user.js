(function () {
  const list_proposal = (status) => {
    $.ajax({
      url: `${BASE_URL}C_master_data/get_list_proposal`,
      method: "POST",
      data: { id: status, nip: $('input[name="nip"]').val() },
      dataType: "json",
      success: (res) => {
        $(".table-bordered").DataTable().clear().destroy();

        $(".isi_histori").html(res.data);

        $(".table-bordered").DataTable({
          language: {
            emptyTable: "Tidak Ada Data",
          },
        });
      },
    });
  };
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
})();

$(document).ready(function () {
  $("#historitb").DataTable({
    scrollX: true,
    scrollY: 200,
  });
  $(".dataTables_length").addClass("bs-select");
});
