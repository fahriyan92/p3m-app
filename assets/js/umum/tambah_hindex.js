const get_data_all = () =>
  new Promise((resolve, reject) => {
    $.ajax({
      url: `${BASE_URL}C_hindex/get_hindex_dosen`,
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
        [5, 10, 20],
        [5, 10, 20],
      ],
    });
  };
  get_data();

  const element = {
    nidn: 'select[name="nidn"]',
    nama: 'input[name="dsn_nama2"]',
    sinta: 'input[name="sinta"]',
    hindex_scopus: 'input[name="index_scopus"]',
    hindex_schoolar: 'input[name="index_schoolar"]',
    limit_pengabdian: 'input[name="max_pengabdian"]',
    limit_penelitian: 'input[name="max_penelitian"]',
  };

  const kosongkan = function () {
    $(element.nidn).val("").trigger("change");
    $(element.nama).val("");
    $(element.sinta).val("");
    $(element.hindex_scopus).val("");
    $(element.hindex_schoolar).val("");
    $(element.limit_pengabdian).val("");
    $(element.limit_penelitian).val("");

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
    hindex_scopus: $(".error-index_scopus"),
    hindex_schoolar: $(".error-index_schoolar"),
    limit_pengabdian: $(".error-max_ketua"),
    limit_penelitian: $(".error-max_anggota"),

  };

  const validasi = () => {
    state = {
      nidn: false,
      nama: false,
      sinta: false,
      hindex_scopus: false,
      hindex_schoolar: false,
      limit_pengabdian: false,
      limit_penelitian: false,
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
    // if ($(element.sinta).val() === "") {
    //   error.sinta.show();
    //   state.sinta = false;
    // } else {
    //   error.sinta.hide();
    //   state.sinta = true;
    // }
    if ($(element.hindex_scopus).val() === "") {
      error.hindex_scopus.show();
      state.hindex_scopus = false;
    } else {
      error.hindex_scopus.hide();
      state.hindex_scopus = true;
    }
    if ($(element.hindex_schoolar).val() === "") {
      error.hindex_schoolar.show();
      state.hindex_schoolar = false;
    } else {
      error.hindex_schoolar.hide();
      state.hindex_schoolar = true;
    }
    if ($(element.limit_pengabdian).val() === "") {
      error.limit_pengabdian.show();
      state.limit_pengabdian = false;
    } else {
      error.limit_pengabdian.hide();
      state.limit_pengabdian = true;
    }
    if ($(element.limit_penelitian).val() === "") {
      error.limit_penelitian.show();
      state.limit_penelitian = false;
    } else {
      error.limit_penelitian.hide();
      state.limit_penelitian = true;
    }
    if (
      state.nidn === true &&
      state.nama === true &&
      // state.sinta === true &&
      state.hindex_scopus === true &&
      state.hindex_schoolar === true &&
      state.limit_pengabdian === true &&
      state.limit_penelitian === true

    ) {
      return true;
    }

    return false;
  };

  $("#simpan-btn").on("click", function (e) {
    const segment = $(location).attr(`href`).split(`/`);
    const id_hindex = segment[segment.length - 1];
    console.log(Number.isInteger(id_hindex));
    let url_aksi = `C_hindex/action_store`;
    if (Number.isInteger(parseInt(id_hindex)) == true) {
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
        // sinta: $(element.sinta).val(),
        hindex_scopus: $(element.hindex_scopus).val(),
        hindex_schoolar: $(element.hindex_schoolar).val(),
        limit_pengabdian: $(element.limit_pengabdian).val(),
        limit_penelitian: $(element.limit_penelitian).val(),
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
