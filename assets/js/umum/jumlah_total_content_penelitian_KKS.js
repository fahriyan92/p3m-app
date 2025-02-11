$("#total_nilai_luaran_wajib").click(function(){
  var ket1_nilai = parseInt($("#ket1_nilai").val());
  var ket2_nilai = parseInt($("#ket2_nilai").val());
  var ket3_nilai = parseInt($("#ket3_nilai").val());
  var total = ket1_nilai + ket2_nilai + ket3_nilai;
  $("#total_nilai_luaran_wajib").val(total);
});

$("#total_nilai_luaran_wajib").hover(function(){
  var ket1_nilai = parseInt($("#ket1_nilai").val());
  var ket2_nilai = parseInt($("#ket2_nilai").val());
  var ket3_nilai = parseInt($("#ket3_nilai").val());
  var total = ket1_nilai + ket2_nilai + ket3_nilai;
  $("#total_nilai_luaran_wajib").val(total);
});

$("#btnHitungJumlahNilai").click(function(){
  var ket1_nilai = parseInt($("#ket1_nilai").val());
  var ket2_nilai = parseInt($("#ket2_nilai").val());
  var ket3_nilai = parseInt($("#ket3_nilai").val());
  var total = ket1_nilai + ket2_nilai + ket3_nilai;
  $("#total_nilai_luaran_wajib").val(total);
});
