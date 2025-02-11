 // swal
 function swal_alert(data) {

  Swal.fire({
    title: 'Data',
    text: data,
    type: 'success'
  });
}
function swal_error(data) {

  Swal.fire({
    title: 'Data',
    text: data,
    type: 'error'
  });
}
//==========================start js form wizard=======================================

var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab
const nidsn = [];
let make_anggota2 = false;

function showTab(n) {
// This function will display the specified tab of the form...
var x = document.getElementsByClassName("tab");

const tab = currentTab + n ;

x[n].style.display = "block";
//... and fix the Previous/Next buttons:
if (n == 0) {
  document.getElementById("prevBtn").style.display = "none";
} else {
  document.getElementById("prevBtn").style.display = "inline";
}
if (n == (x.length - 1)) {
  document.getElementById("nextBtn").innerHTML = "Submit";
  $('#nextBtn').hide();


} else {
  document.getElementById("nextBtn").innerHTML = "Next";
  $('#nextBtn').show();

}
//... and run a function that will display the correct step indicator:
fixStepIndicator(n)
}

const data_ketua = () => {
return new Promise((resolve,reject) => {
  $.ajax({
    url:`${BASE_URL}C_penelitian_dsn_pnbp/data_ketua`,
    type: 'get',
    dataType: 'json',
    success: res => resolve(res)
      // console.log(data.nama_prodi);
      // $('#ketua').select2().val(data.id).trigger('change');
      // $('#nidn').val(data.id); 
      // $('#pangkat').val(data.pangkat);
      // $('#jabatan').val(data.jabatan);
      // $('#jurusan').val(data.nama_jurusan);
    
  });    
});
};




const select_dosen = function(){
//cari dosen anggota1
$('#anggota1').change(function(){ 
    var NIDSN = $(this).val();
    nidsn[0] = NIDSN;
        $.ajax({
          url:`${BASE_URL}C_penelitian_dsn_pnbp/cari_anggota_dosen`,
          method:"POST",
          data:{NIDSN:NIDSN},
          success:function(val){
            data = JSON.parse(val);
            // console.log(data.nama_prodi);
            $('#nidn1').val(data.id); 
            $('#pangkat1').val(data.pangkat);
            $('#jabatan1').val(data.jabatan);
            $('#jurusan1').val(data.nama_jurusan);

          }
        })

});
//cari dosen anggota2
$('#anggota2').change(function(){ 
    var NIDSN = $(this).val();
    nidsn[1] = NIDSN;  
          $.ajax({
          url:`${BASE_URL}C_penelitian_dsn_pnbp/cari_anggota_dosen`,
          method:"POST",
          data:{NIDSN:NIDSN},
          success:function(val){
            data = JSON.parse(val);
            // console.log(data.nama_prodi);
            $('#nidn2').val(data.id); 
            $('#pangkat2').val(data.pangkat);
            $('#jabatan2').val(data.jabatan);
            $('#jurusan2').val(data.nama_jurusan);

          }
        })

});
};

function cek_anggota2() {
$('input[name="pakegak"]').on('change', () => {

  if($('input[name="pakegak"]').is(':checked')){
    make_anggota2 = true;
  } else{ 
    make_anggota2 = false;
  }

  $('.form-anggota2').toggle();
});  
}

cek_anggota2();
function nextPrev(n) {
// This function will figure out which tab to display
var x = document.getElementsByClassName("tab");
const tab = currentTab + n ;
let angg2;

if(n == 1){
  angg2 = currentTab;
} else{
  angg2 = tab;
}
// if(n === 1){

// }else{

// }

// if(currentTab === 2 || currentTab === 3){
//   if(nidsn.length !== 0){
//     nidsn.forEach(item => {
//       // console.log(item);
//       // const select = 
//       // console.log($(`select.nm_dosen option[value="${item}"]`)[tab-1]);
//       // $(`select.nm_dosen option[value="${item}"]`)[tab-1].disabled = true;
//       // console.log(`${$(`option[value="${item}"]`)}`);
//       // $(`option[value="${item}"]`).attr('disabled','disabled');
//     });
//   }
// }




// Exit the function if any field in the current tab is invalid: 

if(angg2 === 3){
  if(make_anggota2){
    if (!validateForm()) return false;
  }
  document.getElementsByClassName("step")[currentTab].className += " finish";
} else{
  if (n == 1 && !validateForm()) return false;
}
// if (n == 1 && !validateForm()) return false;

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
var x, y, i, valid = true;
x = document.getElementsByClassName("tab");
y = x[currentTab].getElementsByTagName("input");
// A loop that checks every input field in the current tab:
for (i = 0; i < y.length; i++) {
  // If a field is empty...
  if (y[i].value == "") {
    // add an "invalid" class to the field:
    y[i].className += " invalid";
    // and set the current valid status to false
    valid = false;
  }
}
// If the valid status is true, mark the step as finished and valid:
if (valid) {
  document.getElementsByClassName("step")[currentTab].className += " finish";
}
return valid; // return the valid status
}

function fixStepIndicator(n) {
// This function removes the "active" class of all steps...
var i, x = document.getElementsByClassName("step");
for (i = 0; i < x.length; i++) {
  x[i].className = x[i].className.replace(" active", "");
}
//... and adds the "active" class on the current step:
x[n].className += " active";
}
//==========================end js form wizard=======================================

// =========================start ajax form input proposal===========================
const list_dosen = () => {
const url = `${BASE_URL}C_penelitian_dsn_pnbp/get_all_dosen`;

return new Promise((resolve,reject) => {
  $.ajax({
    url: url,
    type: 'get',
    dataType: 'json',
    success: res => resolve(res)
  });
});
};  


const set_ketua = ketua => {
$('#ketua').html(`<option value="${ketua.id}">${ketua.label}</option>`);
$('#ketua').select2().val(ketua.id).trigger('change');
$('#nidn').val(ketua.id); 
$('#pangkat').val(ketua.pangkat);
$('#jabatan').val(ketua.jabatan);
$('#jurusan').val(ketua.nama_jurusan);  
};

const generate_select = async () => {
const select = $('.nm_dosen');
const dosen = await list_dosen();
const ketua = await data_ketua();

set_ketua(ketua);

let html = `<option  value="">-- Cari Dosen --</option>`;
dosen.forEach(item => {
  if(!nidsn.includes(item.NIDSN) && item.NIDSN !== ketua.id){
    html += `<option  value="${item.NIDSN}">${item.nama_dosen}</option>`;
  }
});

select.html(html);
};  

generate_select();
//cari dosen ketua

select_dosen();

  $('#b_test').click(function() {
    const form_data = new FormData();
//field data proposal
    const judul = $('#inputJudul').val();
    const NIDSN_ketua = $('#ketua').val();
    const tahun_usulan = $('#tahunPenelitianDosenPNBP').val();
    const mulai = $('#tglmulai').val();
    const akhir = $('#tglakhir').val();
    const biaya = $('#biayadiusulkan').val();
    const capaian = $('#target').val();
    const status_tkt = $('#statusTKT').val();
    const jenis_proposal = $('input[name="jnsproposal"]').val();

    form_data.append('file_proposal', $('#Proposal')[0].files[0]);
    form_data.append('file_rab', $('#Rab')[0].files[0]);
    form_data.append('judul', judul);
    form_data.append("jnsproposal", jenis_proposal);
    form_data.append('NIDSN_ketua', NIDSN_ketua);
    form_data.append('tahun_usulan', tahun_usulan);
    form_data.append('mulai', mulai);
    form_data.append('akhir', akhir);
    form_data.append('biaya',biaya);
    form_data.append('capaian',capaian);
    form_data.append('status_tkt',status_tkt);
    
    // console.log({judul,NIDSN_ketua,tahun_usulan,mulai,akhir,biaya,capaian,status_tkt,file_proposal,file_rab});

//field dosen
    var filecv = [];
    var fokus = [];
    var sinta = [];
    var nidn = [];

    $('[name="nidn"]').each(function(){
     nidn.push($(this).val());
    });
    $('[name="fks_penelitian"]').each(function(){
     fokus.push($(this).val());
    });
    $('[name="id_sinta"]').each(function(){
     sinta.push($(this).val());
    });

    const file_cv = $('[name="filecv"]');

    if(!make_anggota2){
      file_cv.splice(-1,1);
      fokus.pop();
      sinta.pop();
      nidn.pop();
    }

    $(file_cv).each(function(){
     form_data.append('filecv[]',$(this)[0].files[0]); 
     filecv.push($(this).val());
    });


    form_data.append('fokus', fokus);
    form_data.append('sinta', sinta);
    form_data.append('nidn', nidn);

//field mahasiswa
    var nama = [];
    var nim = [];
    var prodi = [];
    var jurusan = [];
    var tahun = [];

    $('[name="mahasiswa"]').each(function(){
     nama.push($(this).val());
    });
    $('[name="nimmahasiswa"]').each(function(){
     nim.push($(this).val());
    });

    $('[name="prodi"]').each(function(){
     prodi.push($(this).val());
    });
    $('[name="jurusan"]').each(function(){
     jurusan.push($(this).val());
    });
    $('[name="aktmhs"]').each(function(){
     tahun.push($(this).val());
    });

    
    form_data.append('nama',nama);
    form_data.append('nim',nim);
    form_data.append('prodi',prodi);
    form_data.append('jurusan',jurusan);
    form_data.append('tahun',tahun);
    form_data.append('jenis','Penelitian Dosen PNBP');

    // var file_data = $('#formnya').prop('files')[0];   
    
    // var form_data = new FormData($('#formnya')[0]);

    $.ajax({
      type: "POST",
      dataType:'json',
      url: `${BASE_URL}C_penelitian_dsn_pnbp/insert_pengajuan`,
      data: form_data
      ,
      contentType: false,
      cache : false,
      processData: false,
      success: function(data){
        if (data.code === 1) {
          swal_alert(data.pesan);
          setTimeout(function(){
             window.location.replace(`${BASE_URL}C_penelitian_dsn_pnbp`);
          },2000);
        }else{
          swal_error(data.message);
        }
      }
    });

//insert ajax db
      // console.log(filecv);
      // $.ajax({
      //   type: "POST",
      //   dataType:'json',
      //   url: `${BASE_URL}C_penelitian_dsn_pnbp/test`,
      //   data: {
          // nidn: nidn,
          // fks_penelitian: fokus,
          // id_sinta: sinta,
          // filecv: filecv,
          // nama: nama,
          // nim: nim,
          // prodi: prodi,
          // jurusan: jurusan,
          // tahun: tahun,
          // judul: judul,
          // NIDSN_ketua: NIDSN_ketua,
          // tahun_usulan: tahun_usulan,
          // mulai: mulai,
          // akhir: akhir,
          // biaya: biaya,
          // capaian: capaian,
          // status_tkt: status_tkt,
      //     file_proposal: file_proposal,
      //     file_rab: file_rab,
      //   },
      //   success: function(data) {

      //     if (data.code === 1) {

      //       swal_alert(data.pesan);

      //       setTimeout(function(){
      //           location.reload();
      //       }, 2500);

      //     } else {
      //       swal_error(data.pesan);
      //     }
      //   }
      // });
    

  })
// =========================end ajax form input proposal===========================
const get_data_proposal = () => {
  return new Promise((resolve,reject) => {
    $.ajax({
      url: `${BASE_URL}C_penelitian_dsn_pnbp/get_data_pengajuan`,
      type: 'get',
      dataType: 'JSON',
      success: res => resolve(res)
    });
  });
};


(async () => {
  const data_poposal = await get_data_proposal();
   $('#inputJudul').val(data_poposal.proposal.judul);
   $('#tahunPenelitianDosenPNBP').val(data_poposal.proposal.tahun_usulan);
   $('#tglmulai').val(data_poposal.proposal.tanggal_mulai_kgt);
   $('#tglakhir').val(data_poposal.proposal.tanggal_akhir_kgt);
   $('#biayadiusulkan').val(data_poposal.proposal.biaya);
   $('#target').val(data_poposal.proposal.target_capaian);
   $('#statusTKT').val(data_poposal.proposal.status_tkt);
  
  x = document.getElementsByClassName("tab")[1];
  y = x.getElementsByTagName("input");
  y[4].value = data_poposal.dsn[0].sinta;
  y[5].value = data_poposal.dsn[0].fokus;
  x.getElementsByTagName("a").href = 
  console.log(data_poposal);
})();