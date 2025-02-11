const data = (function () {
  const url = `${BASE_URL}/C_master_data/`;

  const insert = (kirim) => {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${url}store_jenis_proposal_pengabdian`,
        type: "post",
        data: kirim,
        dataType: "json",
        success: (res) => resolve(res),
      });
    });
  };

  return {
    store: function (kirim) {
      return insert(kirim);
    },
  };
})();

const ui = (function () {
  const domstring = {
    form: {
      jnsproposal: "#jnsproposal",
      biaya: "#biayaproposal",
    },
  };

  return {
    getDomstring: function () {
      return domstring;
    },
  };
})();

const element = {
  jnsproposal: "#jnsproposal",
};

const kosongkan = function () {
  $(element.jnsproposal).val("");
};

const error = {
  jnsproposal: $(".error-jnsproposal"),
  biaya: $(".error-biayaproposal"),
};

const validasi = () => {
  state = {
    jnsproposal: false,
  };

  if ($(element.jnsproposal).val() === "") {
    error.jnsproposal.show();
    state.jnsproposal = false;
  } else {
    error.jnsproposal.hide();
    state.jnsproposal = true;
  }
  if ($(element.biayaproposal).val() === "") {
    error.biaya.show();
    state.biaya = false;
  } else {
    error.biaya.hide();
    state.biaya = true;
  }
  if (state.jnsproposal === true && state.biaya === true) {
    return true;
  }

  return false;
};

const url = `${BASE_URL}/C_master_data/`;

const getDataById = (id) =>
  new Promise((resolve, reject) => {
    $.ajax({
      url: `${url}dataEditjnsproposal`,
      type: "post",
      data: id,
      dataType: "json",
      success: (res) => resolve(res),
    });
  });
var table1;
table1 = $("#jenisproposal").DataTable();
var table2;
table2 = $("#luarantabel").DataTable({
  processing: true,
  serverSide: false,
  deferRender: true,
});
$(document).ready(function () {
  $(document).on("click", ".editKelompok", function (e) {
    e.preventDefault();
    // console.log(this.id);
    getDataById({ id: this.id }).then((res) => {
      showData(res);
    });
    $("#jnsproposalid").val(this.id);
  });

  $(".tambah-jnsproposal").on("click", function (e) {
    e.preventDefault();
    hideData();
    $("#modal-jnsproposal").modal("show");
  });
});

const hideData = function () {
  $("#simpan-jnsproposal").show();
  $("#update-jnsproposal").hide();
  $("#luaranPilih").hide();
  $("#status-jnsproposal").hide();
  $(`input[name=status][value=""]`).prop("checked", true);
  $('input[name="jnsproposal"]').val("");
  $('input[name="biayaproposal"]').val("");
};

const showData = function (data) {
  table2.rows().every(function (rowIdx, tableLoop, rowLoop) {
    var data = this.node();
    $(data).find("input[type='checkbox']:checked").attr("checked", false);
  });

  if (data.kelompok_luaran) {
    var string_kelompok_luaran = data.kelompok_luaran;
    var array_kelompok_luaran = string_kelompok_luaran.split(",");

    table2.rows().every(function (rowIdx, tableLoop, rowLoop) {
      var data = this.node();
      const check = $(data).find("input[type='checkbox']");
      
      if(array_kelompok_luaran.includes(check.val())){
        check.attr("checked", true);
      }    
      
    });

  }
  $("#simpan-jnsproposal").hide();
  $("#luaranPilih").show();
  $("#update-jnsproposal").show();
  $("#status-jnsproposal").show();
  $(`input[name=status][value="${data.status}"]`).trigger("click");
  $('input[name="jnsproposal"]').val(data.nama_kelompok);
  $('input[name="biayaproposal"]').val(data.biaya_proposal);
  $("#modal-jnsproposal").modal("show");
};

const controller = (function (data, ui) {
  const domstring = ui.getDomstring();

  const eventHandler = function () {
    $("#simpan-jnsproposal").on("click", simpanHandler);
  };

  function swal_alert(title, data, type) {
    Swal.fire({
      title: title,
      text: data,
      type: type,
    });
  }

  const simpanHandler = function (e) {
    e.preventDefault();
    var luaran_pilih = new Array();
    table2
      .rows()
      .nodes()
      .to$()
      .find("input[name='luaran_pilih[]']:checked")
      .each(function () {
        luaran_pilih.push($(this).val());
      });
    const nmkelompok = $(domstring.form.jnsproposal).val();
    const biaya = $(domstring.form.biaya).val();
    data.store({ nmkelompok, biaya, luaran_pilih }).then((res) => {
      let title = "Berhasil Menambahkan Data!";
      let status = "success";
      // if (res.code != 1) {
      //   title = "Gagal manambahkan data!";
      //   status = "error";
      // }
      kosongkan();
      swal_alert(title, res.pesan, status);
      $("#overlay").fadeOut(400);
      setTimeout(function () {
        window.location.replace(`${BASE_URL}C_master_data/jenis_proposal_pengabdian`);
      }, 1000);
    });
  };

  return {
    init: function () {
      eventHandler();
    },
  };
})(data, ui);

controller.init();

$(window).on("load", function () {
  $("#overlay").fadeOut(400);
});

function swal_alert(title, data, type) {
  Swal.fire({
    title: title,
    text: data,
    type: type,
  });
}
$("#update-jnsproposal").on("click", function (e) {
  e.preventDefault();

  var luaran_pilih = new Array();
  table2
    .rows()
    .nodes()
    .to$()
    .find("input[name='luaran_pilih[]']:checked")
    .each(function () {
      luaran_pilih.push($(this).val());
    });
  // console.log(luaran_pilih);
  // return;
  if (validasi() === false) {
    return;
  }
  // console.log($("input[name='status']:checked").val());

  $.ajax({
    url: `${BASE_URL}C_master_data/update_jnsproposal`,
    type: "post",
    data: {
      nmkelompok: $("input[name=jnsproposal]").val(),
      biaya: $("input[name=biayaproposal]").val(),
      status: $("input[name='status']:checked").val(),
      id: $("input[name=jnsproposalid]").val(),
      luaran_pilih: luaran_pilih,
    },
    dataType: "json",
    success: function (res) {
      let title = "Berhasil!";
      let status = "success";
      if (res.code != 1) {
        title = res.pesan;
        status = "error";
      }
      kosongkan();
      setTimeout(function () {
        window.location.replace(`${BASE_URL}C_master_data/jenis_proposal_pengabdian`);
      }, 400);
      $("#overlay").fadeIn(100);
      swal_alert(title, res.pesan, status);
    },
  });
});
