const data = (function () {
  const url = `${BASE_URL}/C_master_data/`;

  const insert = (kirim) => {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${url}store_luaran`,
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
      luaran: "#luaran",
      jnsluaran: "#jnsluaran",
    },
  };

  return {
    getDomstring: function () {
      return domstring;
    },
  };
})();

const element = {
  luaran: "#luaran",
};

const kosongkan = function () {
  $(element.luaran).val("").trigger("change");
};

const error = {
  luaran: $(".error-luaran"),
};

const validasi = () => {
  state = {
    luaran: false,
  };

  if ($(element.luaran).val() === "") {
    error.luaran.show();
    state.luaran = false;
  } else {
    error.luaran.hide();
    state.luaran = true;
  }
  if (state.luaran === true) {
    return true;
  }

  return false;
};

const url = `${BASE_URL}/C_master_data/`;

const getDataById = (id) =>
  new Promise((resolve, reject) => {
    $.ajax({
      url: `${url}dataEditLuaran`,
      type: "post",
      data: id,
      dataType: "json",
      success: (res) => resolve(res),
    });
  });

$(document).ready(function () {
  $(document).on("click", ".editLuaran", function (e) {
    e.preventDefault();
    // console.log(this.id);
    getDataById({ id: this.id }).then((res) => {
      showData(res);
    });
    $("#luaranid").val(this.id);
    $("#modal-luaran").modal("show");
  });

  $(".tambah-luaran").on("click", function (e) {
    e.preventDefault();
    hideData();
    $("#modal-luaran").modal("show");
  });
});

const hideData = function () {
  $("#simpan-luaran").show();
  $("#update-luaran").hide();
  $("#status-luaran").hide();
  $(`input[name=status][value=""]`).prop("checked", true);
  $('textarea[name="luaran"]').val("");
  $('#jnsluaran select[name="jnsluaran"]').attr("selected", "false");
};

const showData = function (data) {
  $("#simpan-luaran").hide();
  $("#update-luaran").show();
  $("#status-luaran").show();
  $(`input[name=status][value="${data.status}"]`).trigger("click");
  $('textarea[name="luaran"]').val(data.judul_luaran);
  $('#jnsluaran option[value="' + data.jenis_luaran + '"]').attr(
    "selected",
    "selected"
  );
};

const controller = (function (data, ui) {
  const domstring = ui.getDomstring();

  const eventHandler = function () {
    $("#simpan-luaran").on("click", simpanHandler);
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
    const luaran = $(domstring.form.luaran).val();
    const jnsluaran = $(domstring.form.jnsluaran).val();
    data.store({ luaran, jnsluaran }).then((res) => {
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
        window.location.replace(`${BASE_URL}C_master_data/luaran`);
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
$("#update-luaran").on("click", function (e) {
  e.preventDefault();

  if (validasi() === false) {
    return;
  }
  // console.log($("input[name='status']:checked").val());

  $("#overlay").fadeIn(100);
  $.ajax({
    url: `${BASE_URL}C_master_data/update_luaran`,
    type: "post",
    data: {
      luaran: $("textarea[name=luaran]").val(),
      jnsluaran: $("select[name=jnsluaran]").val(),
      status: $("input[name='status']:checked").val(),
      id: $("input[name=luaranid]").val(),
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
        window.location.replace(`${BASE_URL}C_master_data/luaran`);
      }, 400);
      swal_alert(title, res.pesan, status);
    },
  });
});
