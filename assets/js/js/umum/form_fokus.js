  function swal_alert(title, data, type) {
    Swal.fire({
      title: title,
      text: data,
      type: type,
    });
  }
  function swal_alert1(title, data, type) {
    Swal.fire({
      title: title,
      text: data,
      type: type,
    });
  }
const data = (function () {
  const url = `${BASE_URL}C_master_data/`;

  const insert = (kirim) => {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${url}store_fokus`,
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

const data1 = (function () {
  const url = `${BASE_URL}C_master_data/`;

  const insert = (kirim) => {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${url}store_fokusdtl`,
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
      fokus: "#fokus",
      event: "#event",

    },
  };

  return {
    getDomstring: function () {
      return domstring;
    },
  };
})();

const ui1 = (function () {
  const domstring = {
    form: {
      event: "#event",
      fokusdtl: "#fokusdtl",
    },
  };

  return {
    getDomstring: function () {
      return domstring;
    },
  };
})();

const element = {
  fokus: "#fokus",
  event: "#event",
  fokusdtl: "#fokusdtl",
};

const kosongkan = function () {
  $(element.fokus).val("");
  $(element.event).val("").trigger("change");
  $(element.fokusdtl).val("");
};

const error = {
  fokus: $(".error-fokus"),
  event: $(".error-event"),
  fokusdtl: $(".error-fokusdtl"),
};

const validasi = () => {
  state = {
    fokus: false,
    event: false,

  };

  if ($(element.fokus).val() === "") {
    error.fokus.show();
    state.fokus = false;
  } else {
    error.fokus.hide();
    state.fokus = true;
  }

  if ($(element.event).val() === "") {
    error.event.show();
    state.event = false;
  } else {
    error.event.hide();
    state.event = true;
  }
  if (state.fokus === true && state.event === true) {
    return true;
  }

  return false;
};

const url = `${BASE_URL}C_master_data/`;

const getDataById = (id) =>
  new Promise((resolve, reject) => {
    $.ajax({
      url: `${url}dataEditfokus`,
      type: "post",
      data: id,
      dataType: "json",
      success: (res) => resolve(res),
    });
  });

$(document).ready(function () {
  $(document).on("click", ".editfokus", function (e) {
    e.preventDefault();
    console.log(this.id);
    getDataById({ id: this.id }).then((res) => {
      console.log();
      showData(res);
    });
    $("#simpan-fokus").hide();

    $("#modal-editfokus").modal("show");
  });

  $(".tambah-fokus").on("click", function (e) {
    kosongkan();
    $("#simpan-fokus").show();
    e.preventDefault();
    hideData();
    $("#modal-fokus").modal("show");
  });
});

const hideData = function () {
  $("#simpan-fokus").show();
  $("#update-fokus").hide();
  $("#status-fokus").hide();
  $(`input[name=status][value=""]`).prop("checked", true);
  $('textarea[name="fokus"]').val("");
};

const showData = function (data) {
  $("#update-fokus").show();
  $("#status-fokus").show();
  $(`input[name=status][value="${data[0].status}"]`).trigger("click");
  $('input[name="fokus"]').val(data[0].bidang_fokus);
  $('input[name="fokusId"]').val(data[0].id_fokus);

};

const controller = (function (data, ui) {
  const domstring = ui.getDomstring();
  const domstring1 = ui1.getDomstring();

  const eventHandler = function () {
    $("#simpan-fokus").on("click", simpanHandler);
  };
  const eventHandler1 = function () {
    $("#simpan-fokusdtl").on("click", simpanHandler1);
  };



  const simpanHandler = function (e) {
    e.preventDefault();
    const fokus = $(domstring.form.fokus).val();
    const event = $(domstring1.form.event).val();
    if (validasi() === false) {
      return false;
    }
    data.store({ event, fokus }).then((res) => {
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
        window.location.replace(`${BASE_URL}C_master_data/fokus`);
      }, 1000);
      // $("#form-hidden").show();
      // $("#simpan-fokusdtl").show();
      // $("#hide").hide();
      // $("#simpan-fokus").hide();
      // setTimeout(function () {
      //   window.location.replace(`${BASE_URL}C_master_data/fokus`);
      // }, 1000);
    });
  };
  const simpanHandler1 = function (e) {
    e.preventDefault();
    const event = $(domstring1.form.event).val();
    const fokusdtl = $(domstring1.form.fokusdtl).val();
    data1.store({ event, fokusdtl }).then((res) => {
      let title = "Berhasil Menambahkan Data!";
      let status = "success";
      console.log(res);
      // if (res.code != 1) {
      //   title = "Gagal manambahkan data!";
      //   status = "error";
      // }
      kosongkan();
      swal_alert1(title, res.pesan, status);
      $("#overlay").fadeOut(400);

    });
  };

  return {
    init: function () {
      eventHandler();
      eventHandler1();
    },
  };
})(data, ui);

controller.init();

$("#update-fokus").on("click", function (e) {
  e.preventDefault();
  const fokusnya = $("input[name=fokus]").val();
  console.log(fokusnya);

  $("#overlay").fadeIn(100);
  $.ajax({
    url: `${BASE_URL}C_master_data/update_fokus`,
    type: "post",
    data: {
      fokus: $("input[name='fokus']").val(),
      status: $("input[name='status']:checked").val(),
      id: $("input[name='fokusId']").val(),
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
      setTimeout(function () {
        window.location.replace(`${BASE_URL}C_master_data/fokus`);
      }, 400);
      swal_alert(title, res.pesan, status);
    },
  });
});
$(window).on("load", function () {
  $("#overlay").fadeOut(400);
});

