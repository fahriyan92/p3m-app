(function(){
  const change_title = function(){
    const tahun = $("#select_tahun").val();
    const jenis = $('.jenisnya.active').data('list');
    const jenis_desc = ['Penelitian','Pengabdian'];

    const text = `${jenis_desc[(jenis*1) - 1]} tahun ${tahun}`;
    $(".titelnya").text(text);
  };

  const list_proposal_by_jenis = (id,status = 0) => {
    const tahun = $("#select_tahun").val();
    change_title();
    $.ajax({
      url: `${BASE_URL}C_review_proposal_mandiri/list_proposal_mandiri`,
      method: "POST",
      data: { id_jenis: id, status: status,tahun:tahun},
      dataType: "json",
      success: function (res) {
        $('.table-bordered').DataTable().clear().destroy();
        if(res.length !== 0){
          let no = 1;
          let html = '';

          res.forEach(item => {
            html += `
              <tr>
              <td>${no}</td>
              <td class="text-capitalize">${item.judul}</td>
              <td>${item.tahun}</td>
              <td class="text-capitlize">${item.nama} (${item.nip})</td>
              <td> <a href="${BASE_URL}C_nilai_mandiri/index/${item.id_detail}" class="btn btn-sm btn-danger"> <i class="fa fa-paste"></i></a></td>
              </tr>
            `;
            no++;
          });

          $('.bodynya').html(html);
        }

        $('.table-bordered').DataTable({ "language": {
          "emptyTable": "Tidak Ada Data"
        }
    });
      },
    });
  };

  $('.sudah,.belum').on('click', function(e){
    e.preventDefault();
    $('.status').text($(this).text());
    const status = $(this).data('status');
    const jenis = $('.jenisnya.active').data('list');
    $('.status').data('status',$(this).data('status'));
    list_proposal_by_jenis(jenis,status);

  });
  
  list_proposal_by_jenis(1,0);
  
  $(`.jenisnya[data-list="1"]`).addClass('active');
  $(".jenisnya").click(function(e){
    e.preventDefault();
    $(this).addClass("active");
    const status = $('.status').data('status');

    const id_list = $(this).data('list');
    $(`.jenisnya`).removeClass("active");
    $(`.jenisnya[data-list="${id_list}"]`).addClass('active');
    list_proposal_by_jenis(id_list,status);
  });

  $("#select_tahun").on("change",function(){
    const jenis = $('.jenisnya.active').data('list');
    const status = $('.status').data('status');

    list_proposal_by_jenis(jenis,status);
  });
  

})();