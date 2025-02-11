(function () {
    $(window).on("load", function () {
      $("#overlay").fadeOut(400);
    });

    $("#tahun").datepicker({
        orientation: "bottom",
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years"
    }).datepicker('setDate',TAHUN_NOW);

    //$("#tahun").datepicker({
      //orientation: "bottom",
      //format: "yyyy",
      //viewMode: "years",
      //minViewMode: "years",
    //}).datepicker('setDate',TAHUN_NOW);;

    const score_modal = (id, rata, modal) => {
      $.ajax({
        url: `${BASE_URL}C_rekap/list_reviewer_score`,
        method: "POST",
        data: { id: id },
        dataType: "json",
        success: (res) => {
          let no = 1;
          let html = "";
          res.forEach((item) => {
            html += `<tr><td>${no}</td><td class="text-capitalize" >${
              item.nama
            }</td><td>${parseInt(item.nilai_fix).toFixed(1)}</td></tr>`;
            no++;
          });
          $(".bodyscore").html(html);
          $('input[name="id-update"]').val(id);
          $(".rata").text(rata);
          modal();
          $('input.update').on('click', function (e) {
            e.preventDefault();
            const status = $(this).data('status');
            const id = $('input[name="id-update"]').val();
            const judul = $('#judul').text();
            // console.log( `${id}, ${status}, ${judul}`);
            // return;
            $.ajax({
              url: `${BASE_URL}C_rekap/edit_status`,
              method: 'POST',
              data: { id: id, status: status, judul: judul },
              dataType: 'json',
              success: res => {
                $("#tahun").trigger("change");
                $('#modal-score').modal('hide');
              }
            });
          });
        },
      });
    };

    const list_proposal = (tahun, id, status = 0) => {
      $.ajax({
        url: `${BASE_URL}C_rekap/list_proposal_pnbp`,
        method: "POST",
        data: { tahun: tahun, jenis: id, status: status },
        dataType: "json",
        success: (res) => {
          $("#tabelnya").DataTable().clear().destroy();
          let no = 1;
          let html = "";
          if (res.status === "ok") {
            res.data.forEach((item) => {
              html += `<tr><td>${no}</td><td id="judul">${item.judul}</td><td>${
                item.nama_ketua
              }</td><td><a class="modal-score" data-id="${
                item.id
              }" href="#" style="cursor:pointer;color:#007bff">${parseInt(
                item.nilai_rata
              ).toFixed(1)}</a></td><td><a href="${BASE_URL}C_rekap/viewDetail/${
                item.id
              }">Lihat</a></td></tr>`;
              no++;
            });
            $(".bodynya").html(html);
          }
          $("#tabelnya").DataTable({
            language: {
              emptyTable: "Tidak Ada Data",
            },
          });

          $(".modal-score").on("click", function (e) {
            e.preventDefault();
            const score = $(this).text();
            const id = $(this).data("id");
            score_modal(id, score, function () {
              const status = $('.jenis-event.active').data('list');
              if(status == 6){
                $('.button-action').html('');
                $('.button-action').html('<input type="button" class="btn btn-danger update" data-status="8" value="Tolak"><input type="button" class="btn btn-success update" data-status="7" style="margin-left:8px;" value="Terima">');
              } else {
                $('.button-action').html('');
                $('.button-action').html('<input type="button" class="btn btn-warning update" data-status="6" value="Kembalikan">');
              }
              $("#modal-score").modal("show");
            });
          });
        },
      });
    };

    $(".jenis-event").on("click", function (e) {
      e.preventDefault();
      const status = $(this).data("list");
      $(".jenis-event").removeClass("active");
      $(`.jenis-event[data-list="${status}"]`).addClass("active");
      $("#tahun").trigger("change");
    });

    $("#tahun").on("change", function () {
      const judul = [
        "Proposal Pengabdian Belum Diproses",
        "Proposal Pengabdian Lolos Monev",
        "Proposal Pengabdian Tidak Lolos Monev",
        "Proposal Pengabdian tidak lolos administrasi",
      ];
      const tahun = $(this).val();
      const jenis = 2;
      const status = $(".jenis-event.active").data("list");
      $(".judulnya").text(`${judul[status]} Tahun ${tahun}`);
      list_proposal(tahun, jenis, status);
    });
    $("#tahun").trigger("change");

    $("#download-excel").on("click", function(e){
      e.preventDefault();
      const tahun = $("#tahun").val();

      let link = BASE_URL + "export_excel/export_laporan_akhir_monitoring?id_event=PENGABDIAN_DOSEN&tahun="+tahun;
      window.open(link, '_blank');
    });
  })();
