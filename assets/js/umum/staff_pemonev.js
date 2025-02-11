function modal_proposal($id) {
    var idnya = $id;

    $.ajax({
      url: `${BASE_URL}C_reviewer/get_modal`,
      method: "POST",
      data: { idnya: idnya },
      dataType: "json",
      success: function (res) {
        if (res.code === 0) {
        } else {
          $("#judul").val(res.judul);
          $("#ketua").val(res.NIDSN_ketua);
          $("#id_proposal").val(res.id_pengajuan_proposal);
          $("#myModal").modal("show");
        }
      },
    });
  };

  const obj = {
    //processing: true,
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
  };

  let datatable;

  const list_proposal_by_jenis = (id) => {
    if ($.fn.DataTable.isDataTable(datatable)) {
      datatable.clear().destroy();
    }

    const tahun = $("#filterTahun").val();
    const fokus = $("#fokus_select").val();
    const skema = $("#skema_select").val();

    $.ajax({
      url: `${BASE_URL}C_pemonev/get_tahun_proposal`,
      method: "POST",
      data: { id_list_event: id, tahun: tahun, skema:skema,fokus:fokus },
      dataType: "json",
      success: function (res) {
        if (res.code > 0) {
          $(".bodynya").html(res.datany);
          $(".table-nya").show();
          $(".header-ny").addClass("d-none");
        }

        datatable = $("#tabelevent").DataTable(obj);
      }
    })
  };

  const fokus_skema_list = function(id = null){
    let id_jenis = $(".jenis-event.active").data('list');
    $("#skema_select").val("");
    $("#fokus_select").val("");
    if(id != null){
      id_jenis = id;
    }
    $.ajax({
      url: `${BASE_URL}C_reviewer/fokus_skema_list`,
      method: "POST",
      data: { id_event: id_jenis },
      dataType: "json",
      success: function (res) {
        $("#skema_select").html("");
        if(res.skema.length > 0){
          let html = "<option value=''>-- Semua Skema --</option>";
          res.skema.forEach(function(item){
            html += `<option class="text-capitalize" value="${item.id_kelompok_pengajuan}">${item.nama_kelompok}</option>`;
          });
          $("#skema_select").html(html);
          $("#skema_select").select2("destroy").select2();
        }

        $("#fokus_select").html("");
        if(res.fokus.length > 0){
          let html = "<option value=''>-- Semua Fokus --</option>";
          res.fokus.forEach(function(item){
            html += `<option class="text-capitalize" value="${item.id_fokus}">${item.bidang_fokus}</option>`;
          });
          $("#fokus_select").html(html);
          $("#fokus_select").select2("destroy").select2();
        } else{
          $("#fokus_select").html("<option value=''>-- Semua Fokus --</option>");
        }
      }
    });
  };


  $(document).ready(function () {

    $("#filterTahun").datepicker({
      format: "yyyy",
      viewMode: "years",
      minViewMode: "years",
    });

    list_proposal_by_jenis(1);
    fokus_skema_list(1);
    $(`.jenis-event[data-list="1"]`).addClass("active");

    $(".jenis-event").click(function (e) {
      e.preventDefault();
      $(this).parent('li').addClass("active");

      const id_list = $(this).data("list");
      $(`.jenis-event`).parent('li').removeClass("active");
      $(`.jenis-event[data-list="${id_list}"]`).parent('li').addClass("active");
      fokus_skema_list(id_list);
      list_proposal_by_jenis(id_list);
    });

    $(".jenis_proses").on("click", function(e){
      e.preventDefault();
      const id_list = $(this).data("list");
      // console.log(id_list);
      $(".jenis_proses.active").removeClass("active");
      $(`.jenis_proses[data-list="${id_list}"]`).addClass("active");
    });

    $("#toggle_show").click(function () {
      $("#filter").toggle();
    });

    $("#fokus_select,#skema_select,#filterTahun").on("change", function () {
      let id_jenis = $(".jenis-event.active").data('list');
      list_proposal_by_jenis(id_jenis);
    });

    $("#clicker").click(function () {
      var id_proposal = $("#id_proposal").val();

      var reviewer = [];

      $('[name="reviewer"]').each(function () {
        reviewer.push($(this).val());
      });

      $("#loading").addClass("overlay");
      $("#loading").html('<i class="fa fa-spinner fa-spin fa-4x"></i>');
      setTimeout(RemoveClass, 4000);

      function RemoveClass() {
        $("#loading").removeClass("overlay");
        $("#loading").fadeOut();
        $("#myModal").modal("toggle");
      }

      // console.log(reviewer);
      //     		console.log(id_proposal);

      $.ajax({
        type: "POST",
        dataType: "json",
        url: `${BASE_URL}C_pemonev/insert_pemonev`,
        data: {
          id_proposal: id_proposal,
          reviewer: reviewer,
        },
        success: function (data) {
          alert("Berhasil mengirim permintaan!");
        },
      });
    });


    $("#dl_excel").on("click",function(e){
      e.preventDefault();
      const tahun = $("#filterTahun").val();
      const skema = $("#skema_select").val();
      const fokus = $("#fokus_select").val();
      const id_jenis = $(".jenis-event.active").data('list');
      const event = ['','PENELITIAN_DOSEN','PENGABDIAN_DOSEN','','','PENElITIAN_PLP'];

      let link = BASE_URL + "export_excel/export_pnbp_pemonev?id_event="+event[id_jenis]+"&tahun="+tahun+"&skema="+skema+"&fokus="+fokus;
      window.open(link, '_blank');
    });
  });
