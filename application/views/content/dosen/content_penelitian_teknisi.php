<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $judul; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><?= $brdcrmb; ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content pb-3">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div style="text-align:center;">
                    <ul class="nav nav-tabs nav-justified">
                        <li class="nav-item step"><a class="nav-link" href="#tab_1" data-toggle="tab">Identitas Usulan</a></li>
                        <li class="nav-item step"><a class="nav-link" href="#tab_2" data-toggle="tab">Ketua</a></li>
                        <li class="nav-item step"><a class="nav-link" href="#tab_3" data-toggle="tab">Anggota 1</a></li>
                        <li class="nav-item step"><a class="nav-link" href="#tab_4" data-toggle="tab">Anggota 2</a></li>
                        <li class="nav-item step"><a class="nav-link" href="#tab_5" data-toggle="tab">Mahasiswa</a></li>
                        <li class="nav-item step"><a class="nav-link" href="#tab_6" data-toggle="tab">File</a></li>

                    </ul>
                </div>
                <div class="card-body">
                    <form id="formnya" method="post" enctype="multipart/form-data">
                        <div class="tab">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputJudul">1. Bidang Fokus Penelitian</label><br>
                                        <input type="radio" id="fokus" name="fokus" value="1">
                                        <span for="fokus"> Ketahanan dan Keamanan Pangan</span><br>
                                        <input type="radio" id="fokus" name="fokus" value="2">
                                        <span for="fokus"> Teknologi Informasi dan Komunikasi</span><br>
                                        <input type="radio" id="fokus" name="fokus" value="3">
                                        <span for="fokus"> Diversifikasi dan Konservasi Energi</span><br>
                                        <input type="radio" id="fokus" name="fokus" value="4">
                                        <span for="fokus"> Sosial Humaniora</span><br>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputJudul">2. Tema Penelitian</label>
                                        <input type="text" value="" class="form-control" id="inputTema" placeholder="Tema Penelitian" name="temaPenelitianDosenPNBP">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="inputJudul">3. Sasaran Mitra (Jika Ada)</label>
                                        <input type="text" value="" class="form-control" id="inputSasaran" placeholder="Sasaran Penelitian" name="sasaranPenelitianDosenPNBP">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="inputJudul">4. Judul Penelitian</label>
                                        <input type="text" value="" class="form-control" id="inputJudul" placeholder="Judul Penelitian" name="judulPenelitianDosenPNBP">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="tahunPenelitianDosenPNBP">5. Tahun Usulan</label>
                                        <input type="number" value="" class="form-control" min="1900" max="2099" step="1" value="2020" id="tahunPenelitianDosenPNBP" name="tahunPenelitianDosenPNBP">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="tglmulai">6. Lama Penelitian (mulai)</label>
                                        <input type="date" value="" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" id="tglmulai" placeholder="mulai" name="tglmulai">
                                    </div>
                                </div>
                                <div class="col-sm-1" style="text-align: center; margin-top:36px">
                                    <span> - </span>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="tglakhir">(akhir)</label>
                                        <input type="date" value="" class="form-control" id="tglakhir" data-inputmask-inputformat="dd/mm/yyyy" placeholder="akhir" name="tglakhir">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="biayadiusulkan">7. Biaya yang diusulkan (rupiah)</label><br>
                                        <input type="radio" id="fokus" name="biayadiusulkan" value="Rp. 25.000.000">
                                        <span for="fokus"> Rp. 25.000.000 (Dosen)</span><br>
                                        <input type="radio" id="fokus" name="biayadiusulkan" value="Rp. 15.000.000">
                                        <span for="fokus"> Rp. 15.000.000 (PLP)</span><br>
                                        <div class="row" style="padding-left: 9px; padding-top: 3px;">
                                            <input type="radio" id="fokus" name="biayadiusulkan" value="">
                                            <span for="fokus"> Lainnya</span>
                                            <div class="col-sm-6">
                                                <input type="text" value="" class="form-control" id="biayadiusulkan" placeholder="Rp.000.000,-" name="biayadiusulkan">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="target">8. Target Luaran</label><br>
                                        <input type="checkbox" id="luaran1" name="luaran1" value="Artikel Ilmiah dimuat di Jurnal Cetak atau Elektronik (Internasional/Nasional Terakreditasi/Nasional) - disebutkan pada proposal">
                                        <span for="luaran1"> Artikel Ilmiah dimuat di Jurnal Cetak atau Elektronik (Internasional/Nasional Terakreditasi/Nasional) - disebutkan pada proposal</span><br>
                                        <input type="checkbox" id="luaran2" name="luaran2" value="Artikel Ilmiah dimuat di Prosiding Cetak atau Elektronik (Internasional/Nasional/Lokal) - disebutkan pada proposal">
                                        <span for="luaran2"> Artikel Ilmiah dimuat di Prosiding Cetak atau Elektronik (Internasional/Nasional/Lokal) - disebutkan pada proposal</span><br>
                                        <input type="checkbox" id="luaran3" name="luaran3" value="Artikel di Media Massa Cetak atau Elektronik">
                                        <span for="luaran3"> Artikel di Media Massa Cetak atau Elektronik</span><br>
                                        <input type="checkbox" id="luaran4" name="luaran4" value="Dokumentasi Pelaksanaan Kegiatan (Foto dan Video)">
                                        <span for="luaran4"> Dokumentasi Pelaksanaan Kegiatan (Foto dan Video)</span><br>
                                        <input type="checkbox" id="luaran5" name="luaran5" value="Keynote/invited Speaker dalam Temu Ilmiah (Internasional/Nasional/Lokal)">
                                        <span for="luaran5"> Keynote/invited Speaker dalam Temu Ilmiah (Internasional/Nasional/Lokal)</span><br>
                                        <input type="checkbox" id="luaran6" name="luaran6" value="Pembicara Tamu/visiting lecturer">
                                        <span for="luaran6"> Pembicara Tamu/visiting lecturer</span><br>
                                        <input type="checkbox" id="luaran7" name="luaran7" value="Kekayaan Intelektual (KI) - disebutkan di proposal">
                                        <span for="luaran7"> Kekayaan Intelektual (KI) - disebutkan di proposal</span><br>
                                        <input type="checkbox" id="luaran8" name="luaran8" value="Teknologi Tepat Guna">
                                        <span for="luaran8"> Teknologi Tepat Guna</span><br>
                                        <input type="checkbox" id="luaran9" name="luaran9" value="Model/Purwarupa/Desain/Karya Seni/Rekayasa Sosial">
                                        <span for="luaran9"> Model/Purwarupa/Desain/Karya Seni/Rekayasa Sosial</span><br>
                                        <input type="checkbox" id="luaran10" name="luaran10" value="Buku ber-ISBN">
                                        <span for="luaran10"> Buku ber-ISBN</span><br>
                                        <input type="checkbox" id="luaran11" name="luaran11" value="Bahan Ajar (modul praktikum, tutorial, dsb)">
                                        <span for="luaran11"> Bahan Ajar (modul praktikum, tutorial, dsb)</span><br>
                                        <div class="row" style="padding-left: 8px; padding-top: 8px;">
                                            <input type="checkbox" id="luaran12" name="luaran12" value="">
                                            <span for="luaran11">Lainnya</span><br>
                                            <div class="col-sm-6">
                                                <input type="text" value="" class="form-control" id="luaran12" placeholder="Lainnya" name="luaran12">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <label for="statusTKT">9. Ringkasan Usulan (max. 500 kata)</label>
                                        <textarea value="" class="form-control" id="ringkasan" name="ringkasan" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <label for="statusTKT">10. Tinjauan Pustaka (max. 1000 kata)</label>
                                        <textarea value="" class="form-control" id="tinjauan" name="tinjauan" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <label for="statusTKT">11. Metode (max. 600 kata)</label>
                                        <textarea value="" class="form-control" id="ringkasan" name="ringkasan" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="ketua">1. Nama Ketua</label>
                                        <select class="form-control select2" style="width: 100%;" id="ketua" name="dosen[]" disabled>
                                            <option value="">-- Cari Nama Dosen --</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nidn">2. NIDN / NIDK</label>
                                        <div class="custom-file">
                                            <input type="number" class="form-control" id="nidn" name="nidn" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="pangkat">3. Pangkat / Jabatan Fungsional</label>
                                        <div class="custom-file">
                                            <input type="text" class="form-control" id="pangkat" name="pangkat[]" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_sinta">4. ID-Sinta/Scopus</label>
                                        <div class="custom-file">
                                            <input type="number" class="form-control" id="id_sinta" name="id_sinta">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cvKetua">5. Unggah CV Ketua</label>
                                        <div class="">
                                            <a href="#" id="edit-cv-ketua">alsdkfasjldfasdf.pdf</a>
                                        </div>

                                        <!-- <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="cvKetua" name="filecv" hidden="hidden">
                                            <label class="custom-file-label" for="cvKetua" id="labelcvKetua">Pilih file</label>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="anggota1">1. Nama Anggota 1</label>
                                        <select class="form-control select2 nm_dosen" style="width: 100%;" id="anggota1" name="dosen[]">
                                            <option value="">-- Cari Nama Dosen --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nidn">2. NIDN / NIDK</label>
                                        <div class="custom-file">
                                            <input type="number" disabled class="form-control" id="nidn1" name="nidn">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="pangkat">3. Pangkat / Jabatan Fungsional</label>
                                        <div class="custom-file">
                                            <input type="text" disabled class="form-control" id="pangkat1" name="pangkat[]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_sinta">4. ID-Sinta/Scopus</label>
                                        <div class="custom-file">
                                            <input type="number" class="form-control" id="id_sinta1" name="id_sinta">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cvKetua">5. Unggah CV Anggota 1</label>
                                        <a href="#">alsdkfasjldfasdf.pdf</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab">
                            <h6>(Boleh dilewati)</h6>
                            <div class="row">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label for="pakegak">
                                            Apakah Ingin Menambahkan Anggota 2?
                                            <input style="margin-left:5px;" type="checkbox" name="pakegak">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-anggota2" style="display: none;">
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="anggota1">1. Nama Anggota 2</label>
                                            <select class="form-control select2 nm_dosen ag2" style="width: 100%;" id="anggota2" name="dosen[]">
                                                <option value="">-- Cari Nama Dosen --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nidn">2. NIDN / NIDK</label>
                                            <div class="custom-file">
                                                <input type="number" disabled class="form-control ag2" id="nidn2" name="nidn">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="pangkat">3. Pangkat / Jabatan Fungsional</label>
                                            <div class="custom-file">
                                                <input type="text" disabled class="form-control ag2" id="pangkat2" name="pangkat[]">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="id_sinta">4. ID-Sinta/Scopus</label>
                                            <div class="custom-file">
                                                <input type="number" class="form-control ag2" id="id_sinta2" name="id_sinta">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cvKetua">5. Unggah CV Anggota 2</label>
                                            <a href="#">alsdkfasjldfasdf.pdf</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="mahasiswa1">Nama Mahasiswa 1</label>
                                        <input type="text" class="form-control" id="mahasiswa1" placeholder="Nama Lengkap" name="mahasiswa" value="">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="nimmahasiswa1">Nomor Induk Mahasiswa</label>
                                        <input type="text" class="form-control" id="nimmahasiswa1" placeholder="NIM" name="nimmahasiswa" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="jurusan1">Jurusan</label>
                                        <input type="text" class="form-control" id="jurusan1" placeholder="Jurusan" name="jurusan" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="prodi1">Program Studi</label>
                                        <input type="text" class="form-control" id="prodi1" placeholder="Program Studi" name="prodi" value="">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="mahasiswa2">Nama Mahasiswa 2</label>
                                        <input type="text" class="form-control" id="mahasiswa2" placeholder="Nama Lengkap" name="mahasiswa" value="">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="nimmahasiswa2">Nomor Induk Mahasiswa</label>
                                        <input type="text" class="form-control" id="nimmahasiswa2" placeholder="NIM" name="nimmahasiswa" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="jurusan2">Jurusan</label>
                                        <input type="text" class="form-control" id="jurusan2" placeholder="Jurusan" name="jurusan" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="prodi2">Program Studi</label>
                                        <input type="text" class="form-control" id="prodi2" placeholder="Program Studi" name="prodi" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="append-group"></div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="button" id="addButton" class="btn btn-success" value="Tambah">
                                </div>
                                <div class="col-sm-6" style="text-align: right;">
                                    <input type="button" id="removeButton" class="btn btn-danger" value="Hapus">
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputFile">File Proposal</label>
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="Proposal" name="proposal">
                                                <label class="custom-file-label" for="Proposal" id="labelProposan">Pilih file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="button" id="b_test" value="Submit">
                        </div>
                    </form>
                    <div style="overflow:auto;">
                        <div style="float:right;">
                            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<script src="<?= base_url() . JS_DOSEN; ?>edit_pnbp_dsn.js?random=<?= uniqid(); ?>"></script>

<script type="text/javascript">
    $('.select2').select2();
</script>


<script type="text/javascript">
    $(document).ready(function() {
        // cvKetua labelcvKetua anggota1 labelAnggota1 anggota2 labelAnggota2 Proposal labelProposan Rab labelRab
        // const formUpload = ['cvKetua', 'anggota1', 'anggota2', 'Proposal' ,'Rab'];
        // const labelUpload = ['labelcvKetua', 'labelAnggota1', 'labelAnggota2', 'labelProposan' ,'labelRab'];
        const regex = /[\/\\]([\w\d\s\.\-\(\)]+)$/;

        $('#cvKetua').on('change', function() {
            const fileName = $(this).val();
            console.log(fileName);
            $('#labelcvKetua').text(fileName.match(regex)[1]);
        });

        $('#cvAnggota1').on('change', function() {
            const fileName2 = $(this).val();
            $('#labelAnggota1').text(fileName2.match(regex)[1]);
        });

        $('#cvAnggota2').on('change', function() {
            const fileName3 = $(this).val();
            $('#labelAnggota2').text(fileName3.match(regex)[1]);
        });

        $('#Proposal').on('change', function() {
            const fileName4 = $(this).val();
            $('#labelProposan').text(fileName4.match(regex)[1]);
        });

        $('#Rab').on('change', function() {
            const fileName5 = $(this).val();
            $('#labelRab').text(fileName5.match(regex)[1]);
        });


        var counter = 3;

        $("#addButton").click(function() {

            if (counter > 50) {
                alert("Only 50 Select option allow");
                return false;
            }

            var newSelectDiv = $(document.createElement('div'))
                .attr("id", 'append' + counter);

            newSelectDiv.after().html('<hr>' +
                '<div class="row">' +
                '<div class="col-sm-8">' +
                '<div class="form-group">' +
                '<label for="mahasiswa' + counter + '">Nama Mahasiswa ' + counter + '</label>' +
                '<input type="text" class="form-control" id="mahasiswa' + counter + '" placeholder="Nama Lengkap" name="mahasiswa">' +
                '</div>' +
                '</div>' +
                '<div class="col-sm-4">' +
                '<div class="form-group">' +
                '<label for="nimmahasiswa' + counter + '">Nomor Induk Mahasiswa</label>' +
                '<input type="text" class="form-control" id="nimmahasiswa' + counter + '" placeholder="NIM" name="nimmahasiswa">' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-sm-4">' +
                '<div class="form-group">' +
                '<label for="aktmhs' + counter + '">Tahun Angkatan</label>' +
                '<input type="number" class="form-control" min="1900" max="2099" step="1" value="2017" id="aktmhs' + counter + '" name="aktmhs">' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-sm-6">' +
                '<div class="form-group">' +
                '<label for="jurusan' + counter + '">Jurusan</label>' +
                '<input type="text" class="form-control" id="jurusan' + counter + '" placeholder="Jurusan" name="jurusan">' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="row">' +
                '<div class="col-sm-8">' +
                '<div class="form-group">' +
                '<label for="prodi' + counter + '">Program Studi</label>' +
                '<input type="text" class="form-control" id="prodi' + counter + '" placeholder="Program Studi" name="prodi">' +
                '</div>' +
                '</div>' +
                '</div>');

            newSelectDiv.appendTo(".append-group");


            counter++;
        });

        $("#removeButton").click(function() {
            if (counter == 3) {
                alert("Batas minimum sudah tercapai");
                return false;
            }

            counter--;

            $("#append" + counter).remove();

        });
    });
</script>
    <script>
    $(window).on("load", function() {
    $('#overlay').fadeOut(400);
});
    </script>