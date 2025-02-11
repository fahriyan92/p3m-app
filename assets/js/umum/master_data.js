const get_data_all = () =>
  new Promise((resolve, reject) => {
    $.ajax({
      url: `${BASE_URL}C_master_data/get_all_dosen`,
      type: "get",
      success: (res) => resolve(res),
    });
  });

$(document).ready(function () {
  // cari dosen
  const find_dosen = (nidn) => {
    const data = dosen.find((el) => el.nidn === nidn);
    console.log(data);

    return data;
  };
  const select_dosen = () => {
    $("#cari_dosen").change(function () {
      const nidn = $(this).val();
      // console.log(nidn);
      if (nidn !== "") {
        const data = find_dosen(nidn);
        $("#nama_dsn").val(data.nama);
      } else {
        $("#nama_dsn").val("");
      }
    });
  };
  select_dosen();

  const get_data = async () => {
    $("#tabelevent").DataTable().clear().destroy();
    const data = await get_data_all();
    $(".bodynya").html(data);
    $("#tabelevent").DataTable({
      processing: true,
      language: {
        search: "Cari",
        lengthMenu: "Menampilkan _MENU_ data",
        info: "Menampilkan _PAGE_ sampai _PAGES_ dari _MAX_ data",
        infoFiltered: "(difilter dari _MAX_ data)",
        paginate: {
          previous: "Sebelumnya",
          next: "Selanjutnya",
        },
      },
      lengthMenu: [
        [15, 20, 50],
        [15, 20, 50],
      ],
      initComplete: function(){
        $("#tabelevent_filter").append('<a href="'+BASE_URL+'C_master_data/insertuser" class="btn btn-sm btn-success ml-2">Tambahkan User</a>');
        // 
      }
    });
  };
  get_data();

  const element = {
    nidn: 'select[name="nidn"]',
    nama: 'input[name="dsn_nama2"]',
    sinta: 'input[name="sinta"]',
    hindex: 'input[name="index"]',
    jml_pengajuan: 'input[name="jml_pengajuan"]',
  };

  const kosongkan = function () {
    $(element.nidn).val("").trigger("change");
    $(element.nama).val("");
    $(element.sinta).val("");
    $(element.hindex).val("");
    $(element.jml_pengajuan).val("");
  };

  function swal_alert(title, data, type) {
    Swal.fire({
      title: title,
      text: data,
      type: type,
    });
  }

  const error = {
    nidn: $(".error-nidn"),
    nama: $(".error-nama"),
    sinta: $(".error-sinta"),
    hindex: $(".error-index"),
    jml_pengajuan: $(".error-jml_pengajuan"),
  };

  const validasi = () => {
    state = {
      nidn: false,
      nama: false,
      sinta: false,
      hindex: false,
      jml_pengajuan: false,
      jml_pengabdian: false,
    };

    if ($(element.nidn).val() === "") {
      error.nidn.show();
      state.nidn = false;
    } else {
      error.nidn.hide();
      state.nidn = true;
    }
    if ($(element.nama).val() === "") {
      error.nama.show();
      state.nama = false;
    } else {
      error.nama.hide();
      state.nama = true;
    }
    if ($(element.sinta).val() === "") {
      error.sinta.show();
      state.sinta = false;
    } else {
      error.sinta.hide();
      state.sinta = true;
    }
    if ($(element.hindex).val() === "") {
      error.hindex.show();
      state.hindex = false;
    } else {
      error.hindex.hide();
      state.hindex = true;
    }
    if ($(element.jml_pengajuan).val() === "") {
      error.jml_pengajuan.show();
      state.jml_pengajuan = false;
    } else {
      error.jml_pengajuan.hide();
      state.jml_pengajuan = true;
    }

    if (
      state.nidn === true &&
      state.nama === true &&
      state.sinta === true &&
      state.hindex === true &&
      state.jml_pengajuan === true
    ) {
      return true;
    }

    return false;
  };

  $("#simpan-btn").on("click", function (e) {
    const segment = $(location).attr(`href`).split(`/`);
    const id_hindex = segment[segment.length -1];

    let url_aksi = `C_hindex/action_store`;
    if (id_hindex != undefined) {
      url_aksi = `C_hindex/action_edit/${id_hindex}`;
      element.nidn = 'input[name="nidn"]';
    }
    // console.log(segment);

    if (validasi() === false) {
      console.log(`inputan masih ada yang kosong`);
      return;
    }

    $("#overlay").fadeIn(100);
    $.ajax({
      url: `${BASE_URL}${url_aksi}`,
      type: "post",
      data: {
        nidn: $(element.nidn).val(),
        nama: $(element.nama).val(),
        sinta: $(element.sinta).val(),
        hindex: $(element.hindex).val(),
        jml_pengajuan: $(element.jml_pengajuan).val(),
        id_hindex: id_hindex,
      },
      dataType: "json",
      success: function (res) {
        let title = "Berhasil!";
        let status = "success";
        console.log(res);
        if (res.code != 1) {
          title = "Gagal!";
          status = "error";
        }
        kosongkan();
        $("#overlay").fadeOut(400);
        swal_alert(title, res.pesan, status);
        setTimeout(function () {
          window.location.replace(`${BASE_URL}C_hindex`);
        }, 1000);
      },
    });
  });
});

$(window).on("load", function () {
  $("#overlay").fadeOut(400);
});
