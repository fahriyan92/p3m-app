$("#total_nilai_luaran_wajib").click(function(){
  var ket1_nilai = parseInt($("#ket1_nilai").val());
  $("#total_nilai_luaran_wajib").val(ket1_nilai);
});

$("#total_nilai_luaran_wajib").hover(function(){
  var ket1_nilai = parseInt($("#ket1_nilai").val());
  $("#total_nilai_luaran_wajib").val(ket1_nilai);
});

$("#ket1_skor").keyup(function(){
  var ket1_bobot = parseInt($("#ket1_bobot").val());
  var ket1_skor = parseInt($("#ket1_skor").val());
  var nilai = ket1_bobot * ket1_skor;
  $("#total_nilai_luaran_wajib").val(nilai);
});

$("#ket1_skor").click(function(){
  var ket1_bobot = parseInt($("#ket1_bobot").val());
  var ket1_skor = parseInt($("#ket1_skor").val());
  var nilai = ket1_bobot * ket1_skor;
  $("#total_nilai_luaran_wajib").val(nilai);
});

$("#btnHitungJumlahNilai").click(function(){
  var ket1_nilai = parseInt($("#ket1_nilai").val());
  $("#total_nilai_luaran_wajib").val(ket1_nilai);
});
