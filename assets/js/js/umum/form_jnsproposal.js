const data = (function () {
  const url = `${BASE_URL}/C_master_data/`;

  const insert = (kirim) => {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${url}store_jenis_proposal`,
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

$(document).ready(function () {
  $(document).on("click", ".editKelompok", function (e) {
    e.preventDefault();
    // console.log(this.id);
    getDataById({ id: this.id }).then((res) => {
      showData(res);
    });
    $("#jnsproposalid").val(this.id);
    $("#modal-jnsproposal").modal("show");
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
  $("#status-jnsproposal").hide();
  $(`input[name=status][value=""]`).prop("checked", true);
  $('input[name="jnsproposal"]').val("");
  $('input[name="biayaproposal"]').val("");
};

const showData = function (data) {
  $("#simpan-jnsproposal").hide();
  $("#update-jnsproposal").show();
  $("#status-jnsproposal").show();
  $(`input[name=status][value="${data.status}"]`).trigger("click");
  $('input[name="jnsproposal"]').val(data.nama_kelompok);
  $('input[name="biayaproposal"]').val(data.biaya_proposal);
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
    const nmkelompok = $(domstring.form.jnsproposal).val();
    const biaya = $(domstring.form.biaya).val();
    data.store({ nmkelompok, biaya }).then((res) => {
      let title = "Berhasil Menambahkan Data!";
      let status = "success";
      console.log(res);
      // if (res.code != 1) {
      //   title = "Gagal manambahkan data!";
      //   status = "error";
      // }
      kosongkan();
      swal_alert(title, res.pesan, status);
      $("#overlay").fadeOut(400);
      setTimeout(function () {
        window.location.replace(`${BASE_URL}C_master_data/jenis_proposal`);
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

  if (validasi() === false) {
    return;
  }
  // console.log($("input[name='status']:checked").val());

  $("#overlay").fadeIn(100);
  $.ajax({
    url: `${BASE_URL}C_master_data/update_jnsproposal`,
    type: "post",
    data: {
      nmkelompok: $("input[name=jnsproposal]").val(),
      biaya: $("input[name=biayaproposal]").val(),
      status: $("input[name='status']:checked").val(),
      id: $("input[name=jnsproposalid]").val(),
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
      setTimeout(function () {
        window.location.replace(`${BASE_URL}C_master_data/jenis_proposal`);
      }, 400);
      swal_alert(title, res.pesan, status);
    },
  });
});
