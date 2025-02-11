// swal

function swal_alert(title, data, status) {
  Swal.fire({
    title: title,
    text: data,
    type: status,
  });
}
function checkextensionProposal() {
  const file = document.querySelector("#proposal");
  if (/\.(pdf|doc|docx)$/i.test(file.files[0].name) === false) {
    file.value = null;
    swal_alert("Gagal !", "File Harus PDF / DOC / DOCX !", "error");
  }
}
function checkextensionRab() {
  const file = document.querySelector("#rab");
  if (/\.(xlsx)$/i.test(file.files[0].name) === false) {
    file.value = null;
    swal_alert("Gagal !", "File Harus EXCEL !", "error");
  }
}
function checkextensionCVket() {
  const file = document.querySelector("#cvKetua");
  if (/\.(pdf)$/i.test(file.files[0].name) === false) {
    file.value = null;
    swal_alert("Gagal !", "File Harus PDF !", "error");
  }
}
function checkextensionCV1() {
  const file = document.querySelector("#cvAnggota1");
  if (/\.(pdf)$/i.test(file.files[0].name) === false) {
    file.value = null;
    swal_alert("Gagal !", "File Harus PDF !", "error");
  }
}
function checkextensionCV2() {
  const file = document.querySelector("#cvAnggota2");
  if (/\.(pdf)$/i.test(file.files[0].name) === false) {
    file.value = null;
    swal_alert("Gagal !", "File Harus PDF !", "error");
  }
}
function check_status_anggota() {
  const segment = $(location).attr(`href`).split(`/`);
  const id_pengajuan = segment[segment.length - 1];
  $.get(
    `${BASE_URL}C_penelitian_dsn_pnbp/check_permintaan_anggota/${
      id_pengajuan == undefined ? 0 : id_pengajuan
    }`,
    function (data) {
      const res = JSON.parse(data);
      console.log(res.code);
      if (res.code <= 3) {
        if (res.code == 1) {
          console.log("sudah mengajukan . masih ada permintaan belum di acc");

          res.pesan.every((resnya) => {
            console.log(resnya.status_permintaan);
            // check status permintaan 0 = masih belum di terima, 1 = sudah di terima
            if (resnya.status_permintaan > 0) {
              $("#nextBtn").prop("disabled", false);
              $("#b_test2").hide();
              console.log("status sudah di acc.");
              return true;
            } else {
              $("#nextBtn").attr("disabled", true);
              $("#b_test2").hide();
              $("#alert_permintaan").show();

              console.log("status belum di acc.");
              return false;
            }
            // console.log(res[0].status_permintaan);
          });
        } else if (res.code == 3) {
          $("#nextBtn").attr("disabled", true);
          $("#b_test2").text("update");
          $("#b_test2").val("update");
          $("#b_test2").show();
        } else {
          console.log("sudah mengajukan .  permintaan sudah di acc semua");
          $("#nextBtn").prop("disabled", false);
          $("#b_test2").hide();
        }
      } else {
        console.log("mamtab");
        $("#b_test2").text("simpan");
        $("#b_test2").val("simpan");
        $("#b_test2").show();
        // console.log('belum submit')
      }
    }
  );
}

let make_tambahan_luaran = false;

const element = {
  jenis_penelitian: "input[name='jenis_penelitian']",
  jnsproposal: "input[name='jnsproposal']",
  fokus_penelitian: "input[name='fokus_penelitian']",
  tema_penelitian: "input[name='tema_penelitian']",
  sasaran_penelitian: "input[name='sasaran_penelitian']",
  judul_penelitian: "input[name='judul_penelitian']",
  tahun_penelitian: "input[name='tahun_penelitian']",
  tgl_mulai: "input[name='tgl_mulai']",
  tgl_akhir: "input[name='tgl_akhir']",
  biaya_diusulkan: "input[name='biaya_diusulkan']",
  luaran: "input[name='luaran[]']",
  luaran_tambahan: "input[name='luaran_tambahan']",
  tambahan_luaran: "input[name='tambahan_luaran']",
  ringkasan: "textarea[name='ringkasan']",
  tinjauan: "textarea[name='tinjauan']",
  metode: "textarea[name='metode']",
  id_sinta_ketua: "#id_sinta1",
  id_sinta_anggota1: "#id_sinta2",
  id_sinta_anggota2: "#id_sinta3",
  nidn_anggota1: "#anggota1",
  nidn_anggota2: "#anggota2",
  cv_ketua: "#cvKetua",
  cv_anggota1: "#cvAnggota1",
  cv_anggota2: "#cvAnggota2",
};

function swal_error(data) {
  Swal.fire({
    title: "Data",
    text: data,
    type: "error",
  });
}

$(element.jenis_penelitian).on("change", function () {
  if ($(this).val() === "1") {
    $(element.biaya_diusulkan).attr("placeholder", "Rp.25.000.000");
  } else {
    $(element.biaya_diusulkan).attr("placeholder", "Rp.15.000.000");
  }
});

$(element.jnsproposal).on("change", function () {
  var id = $(this).val();
  $.ajax({
    url: `${BASE_URL}C_pengabdian_dsn_pnbp/cari_biaya`,
    method: "POST",
    data: { id: id },
    success: function (val) {
      data = JSON.parse(val);
      // console.log(data);
      $("#biayadiusulkan").val(data.biaya_proposal);
    },
  });
});

$(element.luaran_tambahan).on("change", function () {
  if ($(this).is(":checked")) {
    make_tambahan_luaran = true;
    $(".tambahan_luaran").html(
      `<input type="text" value="" class="form-control" id="luaran12" placeholder="Lainnya" name="tambahan_luaran">`
    );
  } else {
    make_tambahan_luaran = false;
    $(".tambahan_luaran").html("");
  }
});

function validasi_identitas_dosen() {
  const state = {
    sinta_ketua: false,
    sinta_anggota1: false,
    sinta_anggota2: false,
    nidn_anggota1: false,
    nidn_anggota2: false,
    cv_anggota2: false,
    cv_ketua: false,
    cv_anggota1: false,
  };

  const error = {
    sinta1: ".err-sinta1",
    sinta2: ".err-sinta2",
    sinta3: ".err-sinta3",
    nidn_anggota1: ".err-anggota1",
    nidn_anggota2: ".err-anggota2",
    cv_anggota1: ".err-cv-anggota1",
    cv_anggota2: ".err-cv-anggota2",
    cv_ketua: ".err-cv-ketua",
  };

  if (make_anggota2) {
    if ($(element.nidn_anggota2).val() === "") {
      state.nidn_anggota2 = false;
      $(error.nidn_anggota2).show();
    } else {
      state.nidn_anggota2 = true;
      $(error.nidn_anggota2).hide();
    }

    if ($(element.id_sinta_anggota2).val() === "") {
      state.sinta_anggota2 = false;
      $(error.sinta3).children("h5").text("Tidak boleh kosong");
      $(error.sinta3).show();
    } else {
      if ($(element.id_sinta_anggota2).val().length > 7) {
        state.sinta_anggota2 = false;
        $(error.sinta3).children("h5").text("maximal 7 karakter");
        $(error.sinta3).show();
      } else {
        state.sinta_anggota2 = true;
        $(error.sinta3).hide();
      }
    }

    if ($(element.cv_anggota2).val() === "") {
      state.cv_anggota2 = false;
      if (status_pengajuan !== "lanjut") {
        $(error.cv_anggota2).show();
      }
    } else {
      state.cv_anggota2 = true;
      $(error.cv_anggota2).hide();
    }
  } else {
    $(error.nidn_anggota2).hide();
    $(error.sinta3).hide();
    $(error.cv_anggota2).hide();
  }

  if ($(element.id_sinta_ketua).val() === "") {
    state.sinta_ketua = false;
    $(error.sinta1).children("h5").text("Tidak boleh kosong");
    $(error.sinta1).show();
  } else {
    if ($(element.id_sinta_ketua).val().length > 7) {
      state.sinta_ketua = false;
      $(error.sinta1).children("h5").text("maximal 7 karakter");
      $(error.sinta1).show();
    } else {
      state.sinta_ketua = true;
      $(error.sinta1).hide();
    }
  }

  if ($(element.id_sinta_anggota1).val() === "") {
    state.sinta_anggota1 = false;
    $(error.sinta2).children("h5").text("Tidak boleh kosong");
    $(error.sinta2).show();
  } else {
    if ($(element.id_sinta_anggota1).val().length > 7) {
      state.sinta_anggota1 = false;
      $(error.sinta2).children("h5").text("maximal 7 karakter");
      $(error.sinta2).show();
    } else {
      state.sinta_anggota1 = true;
      $(error.sinta2).hide();
    }
  }

  if ($(element.cv_ketua).val() === "") {
    state.cv_ketua = false;
    if (status_pengajuan !== "lanjut") {
      $(error.cv_ketua).show();
    }
  } else {
    state.cv_ketua = true;
    $(error.cv_ketua).hide();
  }

  if ($(element.cv_anggota1).val() === "") {
    state.cv_anggota1 = false;
    if (status_pengajuan !== "lanjut") {
      $(error.cv_anggota1).show();
    }
  } else {
    state.cv_anggota1 = true;
    $(error.cv_anggota1).hide();
  }

  if ($(element.nidn_anggota1).val() === "") {
    state.nidn_anggota1 = false;
    $(error.nidn_anggota1).show();
  } else {
    state.nidn_anggota1 = true;
    $(error.nidn_anggota1).hide();
  }

  if (status_pengajuan === "lanjut") {
    console.log(anggota.length);
    console.log("bhh");
    state.cv_ketua = true;

    // if(anggota.length === 1){
    //   state.anggota1 = true;
    // }
    // if(anggota.length === 2){
    state.cv_anggota1 = true;
    state.cv_anggota2 = true;
    // }
  }

  if (
    state.sinta_ketua === true &&
    state.sinta_anggota1 === true &&
    state.nidn_anggota1 === true &&
    state.cv_ketua === true &&
    state.cv_anggota1 === true
  ) {
    if (make_anggota2) {
      if (
        state.nidn_anggota2 === true &&
        state.sinta_anggota2 === true &&
        state.cv_anggota2 === true
      ) {
        if ($(element.nidn_anggota1).val() === $(element.nidn_anggota2).val()) {
          swal_alert(
            "Data Dosen Sama",
            "Tidak Boleh Memasukkan Anggota yang Sama, Silahkan Cek NIDN Anggota1 dan Anggota2",
            "error"
          );
          return false;
        } else {
          return true;
        }
      } else {
        return false;
      }
    } else {
      return true;
    }
  }

  return false;
}

function validasi_identitas_usulan() {
  const state = {
    luaran: false,
    jenis: false,
    fokus: false,
    tema: false,
    judul: false,
    tahun: false,
    mulai: false,
    akhir: false,
    biaya: false,
    ringkasan: false,
    tinjauan: false,
    metode: false,
  };

  const error = {
    jenis_penelitian: ".err-jns-penelitian",
    fokus: ".err-fokus",
    tema: ".err-tema",
    judul: ".err-judul",
    thn_usulan: ".err-thn-usulan",
    mulai: ".err-mulai",
    akhir: ".err-akhir",
    biaya: ".err-biaya",
    luaran: ".err-luaran",
    ringkasan: ".err-ringkasan",
    tinjauan: ".err-tinjauan",
    metode: ".err-metode",
  };

  const luaran = $('input[name="luaran[]"]:checked')
    .map(function (_, el) {
      return $(el).val();
    })
    .get();

  const jenis = $(`${element.jenis_penelitian}:checked`).val();
  const fokus = $(`${element.fokus_penelitian}:checked`).val();
  const tema = $(element.tema_penelitian).val();
  const sasaran = $(element.sasaran_penelitian).val();
  const judul = $(element.judul_penelitian).val();
  const thn_usulan = $(element.tahun_penelitian).val();
  const mulai = $(element.tgl_mulai).val();
  const akhir = $(element.tgl_akhir).val();
  const biaya = $(element.biaya_diusulkan).val();
  const ringkasan = $(element.ringkasan).val();
  const tinjauan = $(element.tinjauan).val();
  const metode = $(element.metode).val();
  let luaran_tambahan = null;
  if (make_tambahan_luaran) {
    luaran_tambahan = $(element.tambahan_luaran).val();
    if ($(element.tambahan_luaran).val() === "") {
      luaran_tambahan = null;
    }
  } else {
    luaran_tambahan = null;
  }

  if (luaran.length === 0 && luaran_tambahan === null) {
    state.luaran = false;
    $(error.luaran).show();
  } else {
    state.luaran = true;
    $(error.luaran).hide();
  }

  if (jenis === undefined) {
    state.jenis = false;
    $(error.jenis_penelitian).show();
  } else {
    state.jenis = true;
    $(error.jenis_penelitian).hide();
  }

  if (fokus === undefined) {
    state.fokus = false;
    $(error.fokus).show();
  } else {
    state.fokus = true;
    $(error.fokus).hide();
  }

  if (tema === "") {
    state.tema = false;
    $(error.tema).show();
  } else {
    state.tema = true;
    $(error.tema).hide();
  }

  if (judul === "") {
    state.judul = false;
    $(error.judul).show();
  } else {
    state.judul = true;
    $(error.judul).hide();
  }

  if (mulai === "") {
    state.mulai = false;
    $(error.mulai).show();
  } else {
    state.mulai = true;
    $(error.mulai).hide();
  }

  if (akhir === "") {
    state.akhir = false;
    $(error.akhir).show();
  } else {
    state.akhir = true;
    $(error.akhir).hide();
  }

  if (biaya === "") {
    state.biaya = false;
    $(error.biaya).show();
  } else {
    state.biaya = true;
    $(error.biaya).hide();
  }

  if (tema === "") {
    state.tema = false;
    $(error.tema).show();
  } else {
    state.tema = true;
    $(error.tema).hide();
  }

  if (ringkasan === "") {
    state.ringkasan = false;
    $(error.ringkasan).show();
  } else {
    if (ringkasan.split(" ").length > 500) {
      swal_alert(
        "Banyak Kata Tidak Sesuai",
        "Maksimal kata ringkasan adalah 500",
        "error"
      );
      state.ringkasan = true;
    } else {
      state.ringkasan = true;
      $(error.ringkasan).hide();
    }
  }

  if (tinjauan === "") {
    state.tinjauan = false;
    $(error.tinjauan).show();
  } else {
    if (tinjauan.split(" ").length > 1000) {
      swal_alert(
        "Banyak Kata Tidak Sesuai",
        "Maksimal kata tinjauan pustaka adalah 1000 kata",
        "error"
      );
      state.tinjauan = false;
    } else {
      state.tinjauan = true;
      $(error.tinjauan).hide();
    }
  }

  if (metode === "") {
    state.metode = false;
    $(error.metode).show();
  } else {
    if (metode.split(" ").length > 600) {
      swal_alert(
        "Banyak Kata Tidak Sesuai",
        "Maksimal kata tinjauan metode adalah 600 kata",
        "error"
      );
      state.metode = false;
    } else {
      state.metode = true;
      $(error.metode).hide();
    }
  }

  if (thn_usulan === "") {
    state.tahun = false;
    $(error.thn_usulan).show();
  } else {
    state.tahun = true;
    $(error.thn_usulan).hide();
  }

  if (
    state.luaran === true &&
    state.jenis === true &&
    state.fokus === true &&
    state.tema === true &&
    state.judul === true &&
    state.tahun === true &&
    state.mulai === true &&
    state.akhir === true &&
    state.biaya === true &&
    state.ringkasan === true &&
    state.tinjauan === true &&
    state.metode === true
  ) {
    return true;
  }

  return false;
}

var currentTab = 0;
showTab(currentTab);
let make_anggota2 = false;

function showTab(n) {
  const x = $(".tab");

  const tab = currentTab + n;
  x[n].style.display = "block";

  if (n == 0) {
    $("#prevBtn").css("display", "none");
  } else {
    $("#prevBtn").css("display", "inline");
  }
  if (n != 3) {
    $("#b_test").hide();
  }
  if (n != 1) {
    $("#b_test2").hide();
  }
  if (n != 1) {
    $("#b_test2").hide();
  }

  if (n == x.length - 1) {
    $("#b_test").show();

    $("#nextBtn").html("Kirim");
    $("#nextBtn").hide();
  } else if (n == 1) {
    check_status_anggota();
    // $("#b_test2").show();
    $("#nextBtn").show();
    $("#nextBtn").attr("disabled", true);
  } else {
    $("#nextBtn").html("Selanjutnya");
    $("#nextBtn").show();
    $("#nextBtn").prop("disabled", false);
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n);
}

const find_dosen = (nidn) => {
  const data = semua_dosen.find((el) => el.nidn === nidn);
  return data;
};

const find_masiswa = (nim) => {
  const data = mahasiswa.find((el) => el.nim === nim);
  return data;
};

const select_dosen = function () {
  //cari dosen anggota1
  $("#anggota1").change(function () {
    var nidn = $(this).val();
    if (nidn !== "") {
      const data = find_dosen(nidn);
      $("#dsn_nama1").val(data.nama);
      $("#dsn_jurusan1").val(data.unit);
      $("#dsn_pangkat1").val(data.jenis_job);
    } else {
      $("#dsn_nama1").val("");
      $("#dsn_jurusan1").val("");
      $("#dsn_pangkat1").val("");
    }
  });
  //cari dosen anggota2
  $("#anggota2").change(function () {
    const nidn = $(this).val();
    if (nidn !== "") {
      const data = find_dosen(nidn);
      $("#dsn_nama2").val(data.nama);
      $("#dsn_jurusan2").val(data.unit);
      $("#dsn_pangkat2").val(data.jenis_job);
    } else {
      $("#dsn_nama2").val("");
      $("#dsn_jurusan2").val("");
      $("#dsn_pangkat2").val("");
    }
  });
};

// $("#nim1").on("change", function () {
//   const nim = $(this).val();
//   if (nim !== "") {
//     const data = find_masiswa(nim);
//     $("#nm_mhs1").val(data.nama);
//     $("#prodi1").val(`${data.prodi} - ${data.jurusan}, ${data.angkatan}`);
//   } else {
//     $("#nm_mhs1").val("");
//     $("#prodi1").val("");
//   }
// });

function cek_anggota2() {
  $('input[name="pakegak"]').on("change", () => {
    if ($('input[name="pakegak"]').is(":checked")) {
      make_anggota2 = true;
      if ($('input[name="cv_lama_anggota2"]').length !== 1) {
        $("#nextBtn").prop("disabled", true);
        $("#b_test2").show();
      }
    } else {
      make_anggota2 = false;
      if ($('input[name="cv_lama_anggota2"]').length !== 1) {
        $("#b_test2").hide();
        $("#nextBtn").prop("disabled", false);
      }
    }

    $(".form-anggota2").toggle();
  });
}

const findDuplicates = (arr) => {
  let sorted_arr = arr.slice().sort();
  let results = [];
  for (let i = 0; i < sorted_arr.length - 1; i++) {
    if (sorted_arr[i + 1] == sorted_arr[i]) {
      results.push(sorted_arr[i]);
    }
  }
  return results;
};

cek_anggota2();

function nextPrev(n) {
  const x = $(".tab");
  const tab = currentTab + n;

  if (n == 1 && !validateForm()) return false;
  document.getElementsByClassName("step")[currentTab].className += " finish";

  $('input[type="number"]').on("keydown", function (e) {
    var key = e.charCode || e.keyCode || 0;
    // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
    // home, end, period, and numpad decimal
    return (
      key == 8 ||
      key == 9 ||
      key == 13 ||
      key == 46 ||
      key == 110 ||
      key == 190 ||
      (key >= 35 && key <= 40) ||
      (key >= 48 && key <= 57) ||
      (key >= 96 && key <= 105)
    );
  });

  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = tab;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x,
    y,
    i,
    valid = false;
  x = $(".tab");

  if (currentTab === 0) {
    return validasi_identitas_usulan();
  }

  if (currentTab === 1) {
    return validasi_identitas_dosen();
  }

  if (currentTab === 2) {
    const nimnya = document.getElementsByName("nimmahasiswa");
    const jurusannya = document.getElementsByName("jurusan_mhs");
    const namanya = document.getElementsByName("nm_mhs");
    const angkatanya = document.getElementsByName("angkatan");
    const gada = [];
    for (let i = 0; i <= nimnya.length - 1; i++) {
      if (
        nimnya[i].value === "" ||
        jurusannya[i].value === "" ||
        namanya[i].value === "" ||
        angkatanya[i].value === ""
      ) {
        $(".err-nim")[i].style.display = "block";
        gada.push(false);
      } else {
        $(".err-nim")[i].style.display = "none";
      }
    }

    if ($("#nim1").val() === $("#nim2").val()) {
      swal_alert(
        "Data Mahasiswa Sama",
        "Tidak Boleh Memasukkan Anggota yang Sama, Silahkan Cek NIM Mahasiswa 1 dan Mahasiswa 2",
        "error"
      );
      return false;
    }

    if (gada.length > 0) {
      return false;
    }

    return true;
  }

  // if (valid) {
  //   document.getElementsByClassName("step")[currentTab].className += " finish";
  // }
  // return valid;
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i,
    x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}

function setValueForm() {}

//cari dosen ketua
select_dosen();

$("#b_test2").click(function () {
  if (currentTab === 1) {
    validasi_identitas_dosen();
    if (validasi_identitas_dosen() == false) {
      return console.log("Tidak Boleh Kosong");
    }
  }
  $("#overlay").fadeIn(300);
  const form_data = new FormData();
  //field data proposal
  const judul = $('input[name="judul_penelitian"]').val();
  const nidn_ketua = $("#nidn_ketua").val();
  const tahun_usulan = $('input[name="tahun_penelitian"]').val();
  const jenis_proposal = $('input[name="jnsproposal"]:checked').val();
  const mulai = $('input[name="tgl_mulai"]').val();
  const akhir = $('input[name="tgl_akhir"]').val();
  const biaya = $('input[name="biaya_diusulkan"]').val();
  const tema = $('input[name="tema_penelitian"]').val();
  const sasaran = $('input[name="sasaran_penelitian"]').val();
  const target_luaran = $('input[name="luaran[]"]:checked')
    .map(function (_, el) {
      return $(el).val();
    })
    .get();
  const ringkasan = $('textarea[name="ringkasan"]').val();
  const tinjauan = $('textarea[name="tinjauan"]').val();
  const metode = $('textarea[name="metode"]').val();
  const fokus = $('input[name="fokus_penelitian"]:checked').val();

  form_data.append("file_proposal", $("#proposal")[0].files[0]);
  form_data.append("file_rab", $("#rab")[0].files[0]);
  form_data.append("judul", judul);
  form_data.append("jnsproposal", jenis_proposal);
  form_data.append("ringkasan", ringkasan);
  form_data.append("tinjauan", tinjauan);
  form_data.append("metode", metode);
  form_data.append("nidn_ketua", nidn_ketua);
  form_data.append("tahun_usulan", tahun_usulan);
  form_data.append("tema", tema);
  form_data.append("sasaran", sasaran === "" ? null : sasaran);
  form_data.append("mulai", mulai);
  form_data.append("akhir", akhir);
  form_data.append("biaya", biaya);
  form_data.append("luaran", target_luaran);
  form_data.append("fokus", fokus);
  if (make_tambahan_luaran) {
    form_data.append(
      "luaran_tambahan",
      $('input[name="tambahan_luaran"]').val()
    );
  } else {
    form_data.append("luaran_tambahan", null);
  }

  // console.log({judul,NIDSN_ketua,tahun_usulan,mulai,akhir,biaya,capaian,status_tkt,file_proposal,file_rab});

  //field dosen
  var filecv = [];
  var sinta = [];
  var nidn = [];

  $('[name="nidn"]').each(function () {
    nidn.push($(this).val());
  });

  $('[name="id_sinta"]').each(function () {
    sinta.push($(this).val());
  });

  const file_cv = $('[name="filecv"]');

  if (!make_anggota2) {
    file_cv.splice(-1, 1);
    sinta.pop();
    nidn.pop();
  }

  if ($(this).val() === "simpan") {
    $(file_cv).each(function () {
      form_data.append("filecv[]", $(this)[0].files[0]);
      filecv.push($(this).val());
    });
  } else {
    let no = 0;
    $(file_cv).each(function () {
      if ($(this)[0].files[0] === undefined) {
        filecv.push("tidak");
      } else {
        filecv.push("ada");
        form_data.append("filecv[]", $(this)[0].files[0]);
      }
    });

    const file_lama = [];

    if ($('input[name="id_pengajuan_detail"]').length === 1) {
      form_data.append(
        "id_pengajuan_detail",
        $('input[name="id_pengajuan_detail"]').val()
      );

      if ($('input[name="cv_lama_ketua"]').length === 1) {
        file_lama.push($('input[name="cv_lama_ketua"]').val());
      }

      if ($('input[name="cv_lama_anggota1"]').length === 1) {
        file_lama.push($('input[name="cv_lama_anggota1"]').val());
      }

      if ($('input[name="cv_lama_anggota2"]').length === 1) {
        file_lama.push($('input[name="cv_lama_anggota2"]').val());
      }
      form_data.append("file_lama", file_lama);
    }
  }

  form_data.append("status_cv", filecv);
  form_data.append("sinta", sinta);
  form_data.append("nidn", nidn);

  //field mahasiswa
  let nim = [];
  let nama_mhs = [];
  let jurusan_mhs = [];
  let angkatan_mhs = [];

  $('[name="nimmahasiswa"]').each(function () {
    nim.push($(this).val());
  });
  $('[name="nm_mhs"]').each(function () {
    nama_mhs.push($(this).val());
  });
  $('[name="jurusan_mhs"]').each(function () {
    jurusan_mhs.push($(this).val());
  });
  $('[name="angkatan"]').each(function () {
    angkatan_mhs.push($(this).val());
  });
  form_data.append("nim", nim);
  form_data.append("nama_mhs", nama_mhs);
  form_data.append("jurusan_mhs", jurusan_mhs);
  form_data.append("angkatan_mhs", angkatan_mhs);
  form_data.append("mode", $(this).val());
  // var file_data = $('#formnya').prop('files')[0];

  // var form_data = new FormData($('#formnya')[0]);

  $.ajax({
    type: "POST",
    dataType: "json",
    url: `${
      $(this).val() === "simpan"
        ? `${BASE_URL}C_penelitian_dsn_pnbp/store_pengajuan_edit_satu`
        : `${BASE_URL}C_penelitian_dsn_pnbp/store_pengajuan_edit_satu`
    }`,
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    success: function (data) {
      if (data.code === 1) {
        $("#overlay").fadeOut(400);
        swal_alert(data.pesan, "success");
        setTimeout(function () {
          window.location.replace(`${BASE_URL}C_penelitian_dsn_pnbp`);
        }, 2000);
      } else {
        $("#overlay").fadeOut(400);
        swal_error(data.message);
      }
    },
  });
});

$("#b_test").click(function () {
  $("#overlay").fadeIn(300);
  const form_data = new FormData();
  //field data proposal
  //field data proposal
  const judul = $('input[name="judul_penelitian"]').val();
  const nidn_ketua = $("#nidn_ketua").val();
  const tahun_usulan = $('input[name="tahun_penelitian"]').val();
  const mulai = $('input[name="tgl_mulai"]').val();
  const akhir = $('input[name="tgl_akhir"]').val();
  const biaya = $('input[name="biaya_diusulkan"]').val();
  const tema = $('input[name="tema_penelitian"]').val();
  const sasaran = $('input[name="sasaran_penelitian"]').val();
  const jenis_proposal = $('input[name="jnsproposal"]:checked').val();
  const target_luaran = $('input[name="luaran[]"]:checked')
    .map(function (_, el) {
      return $(el).val();
    })
    .get();
  const ringkasan = $('textarea[name="ringkasan"]').val();
  const tinjauan = $('textarea[name="tinjauan"]').val();
  const metode = $('textarea[name="metode"]').val();
  const fokus = $('input[name="fokus_penelitian"]:checked').val();

  form_data.append("file_proposal", $("#proposal")[0].files[0]);
  form_data.append("file_rab", $("#rab")[0].files[0]);
  form_data.append("judul", judul);
  form_data.append("jnsproposal", jenis_proposal);
  form_data.append("ringkasan", ringkasan);
  form_data.append("tinjauan", tinjauan);
  form_data.append("metode", metode);
  form_data.append("nidn_ketua", nidn_ketua);
  form_data.append("tahun_usulan", tahun_usulan);
  form_data.append("tema", tema);
  form_data.append("sasaran", sasaran === "" ? null : sasaran);
  form_data.append("mulai", mulai);
  form_data.append("akhir", akhir);
  form_data.append("biaya", biaya);
  form_data.append("luaran", target_luaran);
  form_data.append("fokus", fokus);
  if (make_tambahan_luaran) {
    form_data.append(
      "luaran_tambahan",
      $('input[name="tambahan_luaran"]').val()
    );
  } else {
    form_data.append("luaran_tambahan", null);
  }

  var filecv = [];
  var sinta = [];
  var nidn = [];

  //field dosen
  var filecv = [];
  var sinta = [];
  var nidn = [];

  $('[name="nidn"]').each(function () {
    nidn.push($(this).val());
  });

  $('[name="id_sinta"]').each(function () {
    sinta.push($(this).val());
  });

  const file_cv = $('[name="filecv"]');

  if (!make_anggota2) {
    file_cv.splice(-1, 1);
    sinta.pop();
    nidn.pop();
  }

  $(file_cv).each(function () {
    if ($(this)[0].files[0] === undefined) {
      filecv.push("tidak");
    } else {
      filecv.push("ada");
      form_data.append("filecv[]", $(this)[0].files[0]);
    }
  });

  const file_lama = [];

  if ($('input[name="id_pengajuan_detail"]').length === 1) {
    form_data.append(
      "id_pengajuan_detail",
      $('input[name="id_pengajuan_detail"]').val()
    );

    if ($('input[name="cv_lama_ketua"]').length === 1) {
      file_lama.push($('input[name="cv_lama_ketua"]').val());
    }

    if ($('input[name="cv_lama_anggota1"]').length === 1) {
      file_lama.push($('input[name="cv_lama_anggota1"]').val());
    }

    if ($('input[name="cv_lama_anggota2"]').length === 1) {
      file_lama.push($('input[name="cv_lama_anggota2"]').val());
    }

    if ($('input[name="proposal_lama"]').length === 1) {
      form_data.append("proposal_lama", $('input[name="proposal_lama"]').val());
    }

    if ($('input[name="rab_lama"]').length === 1) {
      form_data.append("rab_lama", $('input[name="rab_lama"]').val());
    }

    form_data.append("file_lama", file_lama);
  }

  //field mahasiswa
  let nim = [];
  let nama_mhs = [];
  let jurusan_mhs = [];
  let angkatan_mhs = [];

  $('[name="nimmahasiswa"]').each(function () {
    nim.push($(this).val());
  });
  $('[name="nm_mhs"]').each(function () {
    nama_mhs.push($(this).val());
  });
  $('[name="jurusan_mhs"]').each(function () {
    jurusan_mhs.push($(this).val());
  });
  $('[name="angkatan"]').each(function () {
    angkatan_mhs.push($(this).val());
  });

  if ($('input[name="id_pengajuan_detail"]').length === 1) {
    form_data.append(
      "id_pengajuan_detail",
      $('input[name="id_pengajuan_detail"]').val()
    );
  }

  form_data.append("nim", nim);
  form_data.append("nama_mhs", nama_mhs);
  form_data.append("jurusan_mhs", jurusan_mhs);
  form_data.append("angkatan_mhs", angkatan_mhs);
  form_data.append("status_cv", filecv);
  form_data.append("sinta", sinta);
  form_data.append("nidn", nidn);

  $.ajax({
    type: "POST",
    dataType: "json",
    url: `${BASE_URL}C_penelitian_dsn_pnbp/store_pengajuan_edit_dua`,
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    success: function (data) {
      console.log(data);
      if (data.code === 1) {
        $("#overlay").fadeOut(400);
        swal_alert(data.pesan, "success");
        setTimeout(function () {
          window.location.replace(`${BASE_URL}C_penelitian_dsn_pnbp`);
        }, 2000);
      } else {
        $("#overlay").fadeOut(400);
        swal_error(data.message);
      }
    },
  });
});
