const get_data_all = () =>
  new Promise((resolve, reject) => {
    $.ajax({
      url: `${BASE_URL}C_master_data/get_list_master_pemonev`,
      type: "get",
      dataType: "json",
      success: (res) => resolve(res),
    });
  });

const get_by_id = (id) =>
  new Promise((resolve, reject) => {
    $.ajax({
      url: `${BASE_URL}C_master_data/get_list_pemonev_by_id`,
      type: "POST",
      data: id,
      dataType: "json",
      success: (res) => resolve(res),
    });
  });

$(document).ready(function () {
  //init swal success
  function swal_alert(data) {
    Swal.fire({
      title: "Success",
      text: data,
      type: "success",
    });
  }

  //init swal error
  function swal_error(data) {
    Swal.fire({
      title: "Failed",
      text: data,
      type: "error",
    });
  }

  $("#reviewer").select2();
  $("#reviewer2").select2();
  $("#hide").hide();
  const obj = {
    //processing: true,
    language: {
      search: "Cari",
      lengthMenu: "Menampilkan _MENU_ data",
      info: "Menampilkan _PAGE_ sampai _PAGES_ dari _MAX_ data",
      infoFiltered: "(difilter dari _MAX_ data)",
      paginate: {
        previous: "Sebelumnya",
        next: "Selanjutnya",
      },
      emptyTable: "Tidak Ada Data",
    },
    lengthMenu: [
      [10, 15, 20],
      [10, 15, 20],
    ],
  };

  let datatable;

  const get_data = async () => {
    if ($.fn.DataTable.isDataTable(datatable)) {
      datatable.clear().destroy();
    }

    const data = await get_data_all();
    $(".body").html(data);
    datatable = $("#tabelmasterrvw").DataTable(obj);
  };

  $("#tabelmasterrvw").on("click", ".btn-edit", function (e) {
    e.preventDefault();
    get_by_id({ id: this.id }).then((res) => {
      siapkanEdit(res);
    });
  });

  $("#tabelmasterrvw").on("click", ".btn-delete", function (e) {
    e.preventDefault();
    $.ajax({
      url: `${BASE_URL}C_event/delete`,
      type: "POST",
      data: { id: this.id },
      dataType: "json",
      success: function (res) {
        let title = "Berhasil!";
        let status = "success";
        if (res.code != 1) {
          title = "Gagal!";
          status = "error";
        } else {
          get_data();
        }
        swal_alert(title, res.pesan, status);
        $("#overlay").fadeOut(400);
      },
    });
  });

  const empty_form = function () {
    $('select[name="reviewer"]').val("").trigger("change");
    $('select[name="event"]').val("").trigger("change");
  };

  const siapkanEdit = function (data) {
    $("#add").hide();
    $("#edit").show();
    $(`input[type="radio"][value="${data.status}"]`).trigger("click");
    $('select[name="reviewer2"]').val(data.nidn).trigger("change");
    $("#id_reviewer").val(data.id_reviewer);
    $("#hide").show();
    $(".tempat-edit").show();
    $("#simpan-btn").hide();

    var string_eventids = data.id_event;
    var array_eventids = string_eventids.split(",");
    console.log(array_eventids);

    $(".form-check")
      .find(':checkbox[name="eventids[]"]')
      .each(function () {
        if (array_eventids.some((v) => v == $(this).val())) {
          $(this).prop("checked", true);
        }
      });
  };

  $("#batal-btn").on("click", function (e) {
    e.preventDefault();
    $("#hide").hide();
    $(".tempat-edit").hide();
    $("#simpan-btn").show();

    empty_form();
  });

  $(document).on("click", ".btn_delete", function (e) {
    e.preventDefault();
    var id = this.id;
    const config = {
      title: "Apa anda yakin?",
      text: "Anda tidak dapat mengembalikan data ini!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Ya, hapus",
      cancelButtonText: "Tidak, tolong batalkan!",
    };
    sweetAlert.fire(config).then(deleting);
    function deleting(isConfirm) {
      if (isConfirm.value) {
        $.ajax({
          url: `${BASE_URL}C_master_data/deletePemonev`,
          type: "post",
          data: { id: id },
          dataType: "json",
          success: function (res) {
            if (res.code === undefined) {
              $("#overlay").fadeOut(400);
              swal_alert("Berhasil menghapus data");
            } else {
              $("#overlay").fadeOut(400);
              swal_error(res.pesan);
            }
            get_data();
          },
        });
      } else {
        swal.fire("Dibatalkan", "Data anda aman :)", "success");
      }
    }
  });

  $("#edit-btn").on("click", function (e) {
    e.preventDefault();

    var eventIds = new Array();
    $("input[name='eventids[]']:checked").each(function () {
      eventIds.push($(this).val());
    });

    if ($("select[name='reviewer2']").val() === "") {
      title = "Gagal!";
      status = "error";
      swal_alert(title, "Form Harus Diisi Lengkap!", status);
      $("#overlay").fadeOut(400);
    } else if (eventIds.length < 1 || eventIds == undefined) {
      title = "Gagal!";
      status = "error";
      swal_alert(title, "Form Harus Diisi Lengkap!", status);
      $("#overlay").fadeOut(400);
    } else {
      $("#overlay").fadeIn(100);
      $.ajax({
        url: `${BASE_URL}C_master_data/updatePemonev`,
        type: "post",
        data: {
          id_pemonev: $("#id_reviewer").val(),
          pemonev: $("select[name='reviewer2']").val(),
          event: eventIds,
        },
        dataType: "json",
        success: function (res) {
          let title = "Berhasil!";
          let status = "success";
          console.log(res);
          if (res.code == 0) {
            title = "Gagal!";
            status = "error";
          }
          $("#add").show();
          $("#edit").hide();
          empty_form();
          $("#hide").hide();
          $(".tempat-edit").hide();
          $("#simpan-btn").show();
          get_data();
          $("input[type=checkbox]").prop("checked", false);
          swal_alert(title, res.pesan, status);
          window.location.replace(`${BASE_URL}C_master_data/pemonev`);
          $("#overlay").fadeOut(400);
        },
      });
    }
  });

  get_data();

  const kosongkan = function () {
    $("select[name='reviewer']").val("").trigger("change");
    $("input[type=checkbox]").prop("checked", false);
  };

  function swal_alert(title, data, type) {
    Swal.fire({
      title: title,
      text: data,
      type: type,
    });
  }

  const error = {
    jenis: $(".error-jns"),
    mulai: $(".error-mulai"),
    akhir: $(".error-akhir"),
    thp: $(".error-tahapan"),
  };

  $("#simpan-btn").on("click", function (e) {
    $("#overlay").fadeIn(100);

    var eventIds = new Array();
    $("input[name='eventids[]']:checked").each(function () {
      eventIds.push($(this).val());
    });

    if ($("select[name='reviewer']").val() === "") {
      title = "Gagal!";
      status = "error";
      swal_alert(title, "Form Harus Diisi Lengkap!", status);
      $("#overlay").fadeOut(400);
    } else if (eventIds.length < 1 || eventIds == undefined) {
      title = "Gagal!";
      status = "error";
      swal_alert(title, "Form Harus Diisi Lengkap!", status);
      $("#overlay").fadeOut(400);
    } else {
      $.ajax({
        url: `${BASE_URL}C_master_data/store_MasterPemonev`,
        type: "post",
        data: {
          nidn: $("select[name='reviewer']").val(),
          eventIds: eventIds,
        },
        dataType: "json",
        success: function (res) {
          let title = "Berhasil!";
          let status = "success";
          console.log(res);
          if (res.code == 0) {
            title = "Gagal!";
            status = "error";
          }
          kosongkan();
          swal_alert(title, res.pesan, status);
          window.location.replace(`${BASE_URL}C_master_data/pemonev`);
          get_data();
          $("#overlay").fadeOut(400);
        },
      });
    }
  });
});

$(window).on("load", function () {
  $("#overlay").fadeOut(400);
});
