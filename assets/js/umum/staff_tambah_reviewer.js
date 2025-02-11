$(document).ready(function () {
  function swal_alert(data, type) {

    Swal.fire({
      title: 'Data',
      text:  data,
      type: type
    });
  }
  $(`.btn-dosen`).click(function (e) {
    const segment = $(location).attr(`href`).split(`/`);
    const id_proposal = segment[segment.length - 1];
    // console.log(segment);

    $.ajax({
      url: `${BASE_URL}C_reviewer/get_anggota_dosen`,
      method: `POST`,
      data: { id_proposal: id_proposal },
      dataType: `json`,
      success: function (res) {
        if (res.code == 1) {
          $(`.isi-dosen`).html(res.datany);
        } else {
          $(`.isi-dosen`).html(`ada yang error`);
        }
      },
    });
    $(`.anggota-dosen`).toggle();
  });

  $(`.btn-mhs`).click(function (e) {
    const segment = $(location).attr(`href`).split(`/`);
    const id_proposal = segment[segment.length - 1];
    // console.log(segment);

    $.ajax({
      url: `${BASE_URL}C_reviewer/get_anggota_mhs`,
      method: `POST`,
      data: { id_proposal: id_proposal },
      dataType: `json`,
      success: function (res) {
        if (res.code == 1) {
          $(`.isi-mhs`).html(res.datany);
        } else {
          $(`.isi-mhs`).html(`ada yang error`);
        }
      },
    });
    $(`.anggota-mhs`).toggle();
  });

  $(`.tombol-tolak`).click(function (e) {
    const segment = $(location).attr(`href`).split(`/`);
    const id_proposal = segment[segment.length - 1];
    const status = $('.tombol-tolak').data('tmbl');


    $.ajax({
      url: `${BASE_URL}C_reviewer/prosesKeputusan`,
      method: `POST`,
      data: { id_proposal: id_proposal, status:status },
      dataType: `json`,
      success: function (res) {
        if(status == "lanjut_review" || status == "tolak_administrasi" ){
          if (res.code == 1) {
            swal_alert(`${res.pesan} ${status}`, "success");
            setTimeout(function () {
              window.location.replace(`${BASE_URL}C_reviewer/tambahReviewer/${id_proposal}`);
            }, 1000);
          } else {
            swal_alert(`${res.pesan} ${status}`, "error");
            setTimeout(function () {
              window.location.replace(`${BASE_URL}C_reviewer/tambahReviewer/${id_proposal}`);
            }, 1000);
          }
        }else{
          if (res.code == 1) {
            swal_alert(`${res.pesan} ${status}`, "success");
            setTimeout(function () {
              window.location.replace(`${BASE_URL}C_reviewer`);
            }, 1000);
          } else {
            swal_alert(`${res.pesan} ${status}`, "error");
            setTimeout(function () {
              window.location.replace(`${BASE_URL}C_reviewer`);
            }, 1000);
          }
        }

      },
    });
  });
  $(`.tombol-terima`).click(function (e) {
    const segment = $(location).attr(`href`).split(`/`);
    const id_proposal = segment[segment.length - 1];
    const status = $('.tombol-terima').data('tmbl');


    $.ajax({
      url: `${BASE_URL}C_reviewer/prosesKeputusan`,
      method: `POST`,
      data: { id_proposal: id_proposal, status:status },
      dataType: `json`,
      success: function (res) {
        if(status == "lanjut_review" || status == "tolak_administrasi" ){
          if (res.code == 1) {
            swal_alert(`${res.pesan} ${status}`, "success");
            setTimeout(function () {
              window.location.replace(`${BASE_URL}C_reviewer/tambahReviewer/${id_proposal}`);
            }, 1000);
          } else {
            swal_alert(`${res.pesan} ${status}`, "error");
            setTimeout(function () {
              window.location.replace(`${BASE_URL}C_reviewer/tambahReviewer/${id_proposal}`);
            }, 1000);
          }
        }else{
          if (res.code == 1) {
            swal_alert(`${res.pesan} ${status}`, "success");
            setTimeout(function () {
              window.location.replace(`${BASE_URL}C_reviewer`);
            }, 1000);
          } else {
            swal_alert(`${res.pesan} ${status}`, "error");
            setTimeout(function () {
              window.location.replace(`${BASE_URL}C_reviewer`);
            }, 1000);
          }
        }
      },
    });
  });
});
