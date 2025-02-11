const data = (function () {
  const url = `${BASE_URL}/C_penilai/`;

  const insert = (kirim) => {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${url}store_soal`,
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
      jnsSoal: "#jnsSoal",
      soal: "#soal",
      pilihan: 'input[name="pilihanpne[]"]',
      bobot: 'input[name="bobotpne[]"]',
    },
  };

  return {
    getDomstring: function () {
      return domstring;
    },
  };
})();

const controller = (function (data, ui) {
  const domstring = ui.getDomstring();

  const element = {
    jnsSoal: "#jnsSoal",
    soal: "#soal",
    pilihan: 'input[name="pilihanpne[]"]',
    bobot: 'input[name="bobotpne[]"]',
  };

  const kosongkan = function () {
    $(element.jnsSoal).val("").trigger("change");
    $(element.soal).val("");
    $(element.pilihan).val("");
    $(element.bobot).val("");
  };

  const error = {
    jnskrt: $(".error-jnskrt"),
    kriteria: $(".error-kriteria"),
  };

  const validasi = () => {
    state = {
      jnskrt: false,
      kriteria: false,
      pilihan: true,
      bobot: true,
      persen: true,
    };

    if ($(element.jnsSoal).val() === "") {
      error.jnskrt.show();
      state.jnskrt = false;
    } else {
      error.jnskrt.hide();
      state.jnskrt = true;
    }
    if ($(element.soal).val() === "") {
      error.kriteria.show();
      state.kriteria = false;
    } else {
      error.kriteria.hide();
      state.kriteria = true;
    }

    $('input[name="pilihanpne[]"]').each((item, wowo) => {
      if ($(wowo).val().trim() === "") {
        $(wowo).parent(".form-group").next().show();
        state.pilihan = false;
      } else {
        $(wowo).parent(".form-group").next().hide();
        state.pilihan = true;
      }
    });

    $('input[name="bobotpne[]"]').each((item, wowo) => {
      if ($(wowo).val().trim() === "") {
        $(wowo).parent(".form-group").next(".err-pilihan").show();
        state.bobot = false;
      } else {
        $(wowo).parent(".form-group").next(".err-pilihan").hide();
        state.bobot = true;
      }
    });

    if (
      state.jnskrt === true &&
      state.kriteria === true &&
      state.pilihan === true &&
      state.bobot === true
    ) {
      return true;
    }

    return false;
  };

  const eventHandler = function () {
    $("#simpan-soal").on("click", simpanHandler);
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

    if (validasi() === false) {
      console.log(`inputan masih ada yang kosong`);
      return;
    }
    const jenis = $(domstring.form.jnsSoal).val();
    const soal = $(domstring.form.soal).val();
    const pilihan = $(domstring.form.pilihan)
      .map((item, i) => $(i)[0].value)
      .get();

    const bobot = $(domstring.form.bobot)
      .map((item, i) => $(i)[0].value)
      .get();

    data.store({ soal, jenis, pilihan, bobot }).then((res) => {
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
        window.location.replace(`${BASE_URL}C_penilai`);
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

var counter = 2;

$("#addpilihan1").click(function () {
  //   if (counter > 1) {
  //     alert("Cuma Boleh 3 Pilihan");
  //     return false;
  //   }

  var newSelectDiv = $(document.createElement("div")).attr(
    "id",
    "append" + counter
  );

  newSelectDiv.after().html(`<div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="pilihan${
                                          counter + 1
                                        }">Pilihan Ganda ${counter + 1}</label>
                                        <input type="text" class="form-control" id="pilihan${
                                          counter + 1
                                        }" placeholder="Pilihan Ganda" name="pilihanpne[]" value="">
                                    </div>
                                    <div class="err-pilihan" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="bobot2">Bobot ${
                                          counter + 1
                                        }</label>
                                        <input type="number" class="form-control" id="bobot${
                                          counter + 1
                                        }" placeholder="Bobot" name="bobotpne[]" value="">
                                    </div>
                                    <div class="err-pilihan" style="display:none;">
                                          <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                    </div>
                                </div>
                              </div>`);

  newSelectDiv.appendTo(".append-group1");
  counter++;
});

$("#removepilihan1").click(function () {
  if (counter == 2) {
    alert("Minimal 2 Pilihan Ganda");
    return false;
  }

  counter--;

  $("#append" + counter).remove();
});

// insert jenis kriteria penelitian=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+==+=+=

const data2 = (function () {
  const url = `${BASE_URL}C_penilai/`;

  const insert2 = (kirim) => {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${url}store_jnsoalpne`,
        type: "post",
        data: kirim,
        dataType: "json",
        success: (res) => resolve(res),
      });
    });
  };

  return {
    store2: function (kirim) {
      return insert2(kirim);
    },
  };
})();

const ui2 = (function () {
  const domstring2 = {
    form: {
      jns: "#jns",
      bobotjns: "#bobotjns",
    },
  };

  return {
    getDomstring: function () {
      return domstring2;
    },
  };
})();

const controller2 = (function (data, ui) {
  const domstring2 = ui.getDomstring();

  const element = {
    jns: "#jns",
    bobotjns: "#bobotjns",
  };

  const kosongkan1 = function () {
    $(element.jns).val("").trigger("change");
    $(element.bobotjns).val("");
  };

  const error = {
    jnskrtS: $(".error-jnskrtS"),
    bobotjns: $(".error-bobotjns"),
  };

  const validasi = () => {
    state = {
      jnskrt: false,
      kriteria: false,
      pilihan: true,
      bobot: true,
    };

    if ($(element.jns).val() === "") {
      error.jnskrtS.show();
      state.jnskrtS = false;
    } else {
      error.jnskrtS.hide();
      state.jnskrtS = true;
    }
    if ($(element.bobotjns).val() === "") {
      error.bobotjns.show();
      state.bobotjns = false;
    } else {
      error.bobotjns.hide();
      state.bobotjns = true;
    }

    if (state.jnskrtS === true && state.bobotjns === true) {
      return true;
    }

    return false;
  };

  const eventHandler = function () {
    $("#simpan-jns-kriteria").on("click", simpanHandler2);
  };

  function swal_alert(title, data, type) {
    Swal.fire({
      title: title,
      text: data,
      type: type,
    });
  }

  const simpanHandler2 = function (e) {
    e.preventDefault();

    if (validasi() === false) {
      console.log(`inputan masih ada yang kosong`);
      return;
    }

    const jns = $(domstring2.form.jns).val();
    const bobotjns = $(domstring2.form.bobotjns).val();

    data.store2({ jns, bobotjns }).then((res) => {
      let title = "Berhasil Menambahkan Data!";
      let status = "success";
      console.log(res);
      // if (res.code != 1) {
      //   title = "Gagal manambahkan data!";
      //   status = "error";
      // }
      kosongkan1();
      swal_alert(title, res.pesan, status);
      $("#overlay").fadeOut(400);
      setTimeout(function () {
        window.location.replace(`${BASE_URL}C_penilai`);
      }, 1000);
    });
  };

  return {
    init: function () {
      eventHandler();
    },
  };
})(data2, ui2);

controller2.init();

$(window).on("load", function () {
  $("#overlay").fadeOut(400);
});

//insert data soal pengabdian

const data3 = (function () {
  const url = `${BASE_URL}/C_penilai/`;

  const insert3 = (kirim) => {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${url}store_soalpge`,
        type: "post",
        data: kirim,
        dataType: "json",
        success: (res) => resolve(res),
      });
    });
  };

  return {
    store: function (kirim) {
      return insert3(kirim);
    },
  };
})();

const ui3 = (function () {
  const domstring3 = {
    form: {
      jnsSoalpge: "#jnsSoalpge",
      soalpge: "#soalpge",
      pilihanpge: 'input[name="pilihanpge[]"]',
      bobotpge: 'input[name="bobotpge[]"]',
      persen: 'input[name="prosentase[]"]',
    },
  };

  return {
    getDomstring: function () {
      return domstring3;
    },
  };
})();

const controller3 = (function (data, ui) {
  const domstring3 = ui.getDomstring();

  const element = {
    jnsSoalpge: "#jnsSoalpge",
    soalpge: "#soalpge",
    pilihanpge: 'input[name="pilihanpge[]"]',
    bobotpge: 'input[name="bobotpge[]"]',
    persen: 'input[name="prosentase[]"]',
  };

  const kosongkan3 = function () {
    $(element.jnsSoalpge).val("").trigger("change");
    $(element.soalpge).val("");
    $(element.pilihanpge).val("");
    $(element.bobotpge).val("");
    $(element.persen).val("");
  };

  const error = {
    jnskrt: $(".error-jnskrt"),
    kriteria: $(".error-kriteria"),
  };

  const validasi = () => {
    state = {
      jnskrt: false,
      kriteria: false,
      pilihan: true,
      bobot: true,
      persen: true,
    };

    if ($(element.jnskrt).val() === "") {
      error.jnskrt.show();
      state.jnskrt = false;
    } else {
      error.jnskrt.hide();
      state.jnskrt = true;
    }
    if ($(element.kriteria).val() === "") {
      error.kriteria.show();
      state.kriteria = false;
    } else {
      error.kriteria.hide();
      state.kriteria = true;
    }

    $('input[name="pilihanpge[]"').each((item, wowo) => {
      if ($(wowo).val().trim() === "") {
        $(wowo).parent(".form-group").next().show();
        state.pilihan = false;
      } else {
        $(wowo).parent(".form-group").next().hide();
        state.pilihan = true;
      }
    });

    $('input[name="bobotpge[]"]').each((item, wowo) => {
      if ($(wowo).val().trim() === "") {
        $(wowo).parent(".form-group").next(".err-pilihanpge").show();
        state.bobot = false;
      } else {
        $(wowo).parent(".form-group").next(".err-pilihanpge").hide();
        state.bobot = true;
      }
    });

    if (
      state.jnskrt === true &&
      state.kriteria === true &&
      state.pilihan === true &&
      state.bobot === true
    ) {
      return true;
    }

    return false;
  };

  const eventHandler3 = function () {
    $("#simpan-soalpge").on("click", simpanHandler3);
  };

  function swal_alert(title, data, type) {
    Swal.fire({
      title: title,
      text: data,
      type: type,
    });
  }

  const simpanHandler3 = function (e) {
    e.preventDefault();

    if (validasi() === false) {
      console.log(`inputan masih ada yang kosong`);
      return;
    }

    const jnsSoalpge = $(domstring3.form.jnsSoalpge).val();
    const soalpge = $(domstring3.form.soalpge).val();
    const pilihanpge = $(domstring3.form.pilihanpge)
      .map((item, i) => $(i)[0].value)
      .get();
    const bobotpge = $(domstring3.form.bobotpge)
      .map((item, i) => $(i)[0].value)
      .get();
    const persen = $(domstring3.form.persen)
      .map((item, i) => $(i)[0].value)
      .get();

    data.store({ soalpge, jnsSoalpge, pilihanpge, bobotpge, persen}).then((res) => {
      let title = "Berhasil Menambahkan Data!";
      let status = "success";
      console.log(res);
      // if (res.code != 1) {
      //   title = "Gagal manambahkan data!";
      //   status = "error";
      // }
      kosongkan3();
      swal_alert(title, res.pesan, status);
      $("#overlay").fadeOut(400);
      setTimeout(function () {
        window.location.replace(`${BASE_URL}C_penilai`);
      }, 1000);
    });
  };

  return {
    init: function () {
      eventHandler3();
    },
  };
})(data3, ui3);

controller3.init();

$(window).on("load", function () {
  $("#overlay").fadeOut(400);
});

var counter = 2;

$("#addpilihan").click(function () {
  //   if (counter > 1) {
  //     alert("Cuma Boleh 3 Pilihan");
  //     return false;
  //   }

  var newSelectDiv = $(document.createElement("div")).attr(
    "id",
    "append" + counter
  );

  newSelectDiv.after().html(`<div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="pilihan${
                                          counter + 1
                                        }">Pilihan Ganda ${counter + 1}</label>
                                        <input type="text" class="form-control" id="pilihan${
                                          counter + 1
                                        }" placeholder="Pilihan Ganda" name="pilihanpge[]" value="">
                                    </div>
                                    <div class="err-pilgan${
                                      counter + 1
                                    }" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="bobot2">Bobot ${
                                          counter + 1
                                        }</label>
                                        <input type="number" class="form-control" id="bobot${
                                          counter + 1
                                        }" placeholder="Bobot" name="bobotpge[]" value="">
                                    </div>
                                    <div class="err-bobot${
                                      counter + 1
                                    }" style="display:none;">
                                        <h5 style="font-size: 16px; color: red;" class="text-left">Tidak Boleh Kosong</h5>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                  <div class="form-group">
                                      <label for="prosentase">Prosentase ${
                                        counter + 1
                                      }</label>
                                      <input type="number" class="form-control" id="prosentase${
                                        counter + 1
                                      }" placeholder="Prosentase(%)" name="prosentase[]" value="">
                                  </div>
                                </div>
                            </div>`);

  newSelectDiv.appendTo(".append-group2");
  counter++;
});

$("#removepilihan").click(function () {
  if (counter == 2) {
    alert("Minimal 2 Pilihan Ganda");
    return false;
  }

  counter--;

  $("#append" + counter).remove();
});

// insert jenis kriteria pengabdian =+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+==+=+=

const data4 = (function () {
  const url = `${BASE_URL}/C_penilai/`;

  const insert4 = (kirim) => {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${url}store_jnsoalpge`,
        type: "post",
        data: kirim,
        dataType: "json",
        success: (res) => resolve(res),
      });
    });
  };

  return {
    store4: function (kirim) {
      return insert4(kirim);
    },
  };
})();

const ui4 = (function () {
  const domstring4 = {
    form: {
      jnspge: "#jnspge",
      bobotjnspge: "#bobotjnspge",
    },
  };

  return {
    getDomstring: function () {
      return domstring4;
    },
  };
})();

const controller4 = (function (data, ui) {
  const domstring4 = ui.getDomstring();

  const eventHandler = function () {
    $("#simpan-jenis-kriteriapge").on("click", simpanHandler4);
  };

  const element = {
    jnspge: "#jnspge",
    bobotjnspge: "#bobotjnspge",
  };

  const kosongkan2 = function () {
    $(element.jns).val("").trigger("change");
    $(element.bobotjns).val("");
  };

  const error = {
    jnskrtS: $(".error-jnskriteriaS"),
    bobotjns: $(".error-bobotjnspge"),
  };

  const validasi = () => {
    state = {
      jnskrt: false,
      kriteria: false,
      pilihan: true,
      bobot: true,
    };

    if ($(element.jnspge).val() === "") {
      error.jnskrtS.show();
      state.jnskrtS = false;
    } else {
      error.jnskrtS.hide();
      state.jnskrtS = true;
    }
    if ($(element.bobotjnspge).val() === "") {
      error.bobotjns.show();
      state.bobotjns = false;
    } else {
      error.bobotjns.hide();
      state.bobotjns = true;
    }

    if (state.jnskrtS === true && state.bobotjns === true) {
      return true;
    }

    return false;
  };

  function swal_alert(title, data, type) {
    Swal.fire({
      title: title,
      text: data,
      type: type,
    });
  }

  const simpanHandler4 = function (e) {
    e.preventDefault();

    if (validasi() === false) {
      console.log(`inputan masih ada yang kosong`);
      return;
    }

    const jnspge = $(domstring4.form.jnspge).val();
    const bobotjnspge = $(domstring4.form.bobotjnspge).val();

    data.store4({ jnspge, bobotjnspge }).then((res) => {
      let title = "Berhasil Menambahkan Data!";
      let status = "success";
      console.log(res);
      // if (res.code != 1) {
      //   title = "Gagal manambahkan data!";
      //   status = "error";
      // }
      kosongkan2();
      swal_alert(title, res.pesan, status);
      $("#overlay").fadeOut(400);
      setTimeout(function () {
        window.location.replace(`${BASE_URL}C_penilai`);
      }, 1000);
    });
  };

  return {
    init: function () {
      eventHandler();
    },
  };
})(data4, ui4);

controller4.init();

$(window).on("load", function () {
  $("#overlay").fadeOut(400);
});
