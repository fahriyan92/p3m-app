<style>
    .white-space {
        white-space: pre-wrap;
    }

    .table {
        display: table;
        border-collapse: collapse;
    }

    .table .tr {
        display: table-row;
        border: 1px solid #ddd;
    }

    .table .tr:first-child {
        font-weight: bold;
        border-bottom: 2px solid #ddd;
    }

    .table .tr:nth-child(even) {
        background-color: #F9F9F9;
    }

    .table .tr .td {
        display: table-cell;
        padding: 8px;
        border-left: 1px solid #ddd;
    }

    .table .tr .td:first-child {
        border-left: 0;
    }

    /* Not necessary for table styling */
    .div-table,
    .table-tag {
        float: left;
        margin: 2em;
    }

    .div-table .title,
    .table-tag .title {
        text-align: center;
        padding-bottom: 0.5em;
    }
</style>

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        <?= $judul; ?>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <?= $brdcrmb; ?>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <?= $namakelompok; ?>
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($dt_proposal)) : ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputJudul">Judul</label>
                                    <input type="text" class="form-control" id="inputJudul" placeholder="Judul Penelitian" value="<?= $dt_proposal->judul; ?>" name="judulPenelitianDosenPNBP" disabled>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="">Nama Ketua</label>
                                    <input readonly class="form-control text-capitalize" type="text" value="<?= $dt_proposal->nama_ketua ?> - <?= $dt_proposal->nidn_ketua ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="biayadiusulkan">Biaya yang diusulkan</label>
                                <input type="text" class="form-control" id="biayadiusulkan" value="<?= rupiah($dt_proposal->biaya_usulan); ?>" placeholder="Rp.8.500.000,-" name="biayadiusulkan" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="tglmulai">Lama Penelitian (mulai)</label>
                                <input type="date" class="form-control" data-inputmask-inputformat="dd/mm/yyyy" id="tglmulai" placeholder="mulai" name="tglmulai" value="<?= $dt_proposal->mulai; ?>" disabled>
                            </div>
                        </div>
                        <div class="col-sm-1" style="text-align: center; margin-top:36px">
                            <span> - </span>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="tglakhir">(akhir)</label>
                                <input type="date" class="form-control" id="tglakhir" data-inputmask-inputformat="dd/mm/yyyy" placeholder="akhir" name="tglakhir" value="<?= $dt_proposal->akhir; ?>" disabled>
                            </div>
                        </div>
                    </div>


                    <div class="row">

                        <div class="div-table w-100">

                            <p><b>I. Laporan Berkas dan Luaran Wajib & Tambahan</b></p>
                            <div class="table">

                                <div class="tr">
                                    <div class="td">No</div>
                                    <div class="td">Komponen Penilaian</div>
                                    <div class="td">Unggah / Edit / Hapus File</div>
                                    <div class="td">File Laporan</div>
                                    <div class="td">Deskripsi</div>
                                </div>
                                <div class="tr">
                                    <div class="td"></div>
                                    <div class="td font-weight-bold">Laporan Berkas</div>
                                </div>
                                <div class="tr">
                                    <div class="td">1</div>
                                    <div class="td">Laporan Kemajuan</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#laporan_kemajuan">
                                            <?= empty($berkas->b_laporan_kemajuan) ? 'Unggah File' : 'Edit / Hapus File' ?>
                                        </button>
                                        <div class="modal fade" id="laporan_kemajuan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Laporan Kemajuan
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="file_laporan_kemajuan">PILIH METODE UNGGAH</label>
                                                            <select id="file_laporan_kemajuan" class="form-control" onchange="MetodeUnggahLaporan(this);">
                                                                <option></option>
                                                                <option id="metode_file_kemajuan">File</option>
                                                                <option id="metode_url_kemajuan">URL</option>
                                                            </select>
                                                        </div>
                                                        <div id="metode_file_kemajuan_select" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_berkas_laporan_kemajuan/$idproposal") : base_url("Upload_berkas_penelitian/edit_berkas_laporan_kemajuan/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Laporan Kemajuan</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input name="berkas_laporan_kemajuan" type="file" class="custom-file-input" id="berkas_laporan_kemajuan" accept="application/pdf">
                                                                        <label class="custom-file-label" for="berkas_laporan_kemajuan">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->b_laporan_kemajuan) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->b_laporan_kemajuan)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_berkas_laporan_kemajuan/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div id="metode_url_kemajuan_select" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_berkas_laporan_kemajuan_url/$idproposal") : base_url("Upload_berkas_penelitian/edit_berkas_laporan_kemajuan_url/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon3">https://example.com/</span>
                                                                    </div>
                                                                    <input type="url" class="form-control" name="berkas_laporan_kemajuan_url" id="berkas_laporan_kemajuan_url" aria-describedby="basic-addon3">
                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->b_laporan_kemajuan) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->b_laporan_kemajuan)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_berkas_laporan_kemajuan/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->b_laporan_kemajuan)) {
                                            echo '<button type="button" class="btn btn-danger">Masih Belum Ada File</button>';
                                        } elseif (filter_var($berkas->b_laporan_kemajuan, FILTER_VALIDATE_URL)) {
                                            echo '<a target="_blank"href="' . $berkas->b_laporan_kemajuan . '">' . $berkas->b_laporan_kemajuan . '</a>';
                                        } else {
                                            echo '<a target="_blank"href="' . base_url("assets/berkas/file_laporan/penelitian/") . $berkas->b_laporan_kemajuan . '">' . $berkas->b_laporan_kemajuan . '</a>';
                                        }
                                        ?>


                                    </div>
                                    <div class="td">
                                        <?php if (empty($deskripsi->d_laporan_kemajuan)) : ?>
                                            <a type="button" data-toggle="modal" data-target="#TidakdeskripsiKemajuan">
                                                <button type="button" class="btn btn-danger">Klik Disini Untuk Menambahkan Deskripsi</button>
                                            </a>
                                            <div class="modal fade" id="TidakdeskripsiKemajuan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Kemajuan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_deskripsi_kemajuan/$idproposal") : base_url("Upload_berkas_penelitian/edit_deskripsi_kemajuan/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="deskripsi_kemajuan" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($deskripsi->d_laporan_kemajuan) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <a type="button" data-toggle="modal" data-target="#AdadeskripsiKemajuan">
                                                <p class="text-break"><?= $deskripsi->d_laporan_kemajuan ?></p>
                                            </a>
                                            <div class="modal fade" id="AdadeskripsiKemajuan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Kemajuan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_deskripsi_kemajuan/$idproposal") : base_url("Upload_berkas_penelitian/edit_deskripsi_kemajuan/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="deskripsi_kemajuan" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($deskripsi->d_laporan_kemajuan) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                                <?php if (isset($deskripsi->d_laporan_kemajuan)) : ?>
                                                                    <form action="<?= base_url("Upload_berkas_penelitian/hapus_deskripsi_kemajuan/$idproposal") ?>">
                                                                        <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                    </form>
                                                                <?php endif; ?>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="tr">
                                    <div class="td">2</div>
                                    <div class="td">Laporan Akhir</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#laporan_akhir">
                                            <?= empty($berkas->b_laporan_akhir) ? 'Unggah File' : 'Edit / Hapus File' ?>
                                        </button>
                                        <div class="modal fade" id="laporan_akhir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Laporan Akhir
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="file_laporan_akhir">PILIH METODE UNGGAH</label>
                                                            <select id="file_laporan_akhir" class="form-control" onchange="MetodeUnggahLaporan(this);">
                                                                <option></option>
                                                                <option id="metode_file_akhir">File</option>
                                                                <option id="metode_url_akhir">URL</option>
                                                            </select>
                                                        </div>
                                                        <div id="metode_file_akhir_select" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_berkas_laporan_akhir/$idproposal") : base_url("Upload_berkas_penelitian/edit_berkas_laporan_akhir/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Laporan Akhir</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input name="berkas_laporan_akhir" type="file" class="custom-file-input" id="berkas_laporan_akhir" accept="application/pdf">
                                                                        <label class="custom-file-label" for="berkas_laporan_akhir">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->b_laporan_akhir) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->b_laporan_akhir)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_berkas_laporan_akhir/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div id="metode_url_akhir_select" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_berkas_laporan_akhir_url/$idproposal") : base_url("Upload_berkas_penelitian/edit_berkas_laporan_akhir_url/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon3">https://example.com/</span>
                                                                    </div>
                                                                    <input type="url" class="form-control" name="berkas_laporan_akhir_url" id="berkas_laporan_akhir_url" aria-describedby="basic-addon3">
                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->b_laporan_akhir) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->b_laporan_akhir)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_berkas_laporan_akhir/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->b_laporan_akhir)) {
                                            echo '<button type="button" class="btn btn-danger">Masih Belum Ada File</button>';
                                        } elseif (filter_var($berkas->b_laporan_akhir, FILTER_VALIDATE_URL)) {
                                            echo '<a target="_blank"href="' . $berkas->b_laporan_akhir . '">' . $berkas->b_laporan_akhir . '</a>';
                                        } else {
                                            echo '<a target="_blank"href="' . base_url("assets/berkas/file_laporan/penelitian/") . $berkas->b_laporan_akhir . '">' . $berkas->b_laporan_akhir . '</a>';
                                        }
                                        ?>


                                    </div>
                                    <div class="td">
                                        <?php if (empty($deskripsi->d_laporan_akhir)) : ?>
                                            <a type="button" data-toggle="modal" data-target="#TidakdeskripsiAkhir">
                                                <button type="button" class="btn btn-danger">Klik Disini Untuk Menambahkan Deskripsi</button>
                                            </a>
                                            <div class="modal fade" id="TidakdeskripsiAkhir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Akhir</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_deskripsi_akhir/$idproposal") : base_url("Upload_berkas_penelitian/edit_deskripsi_akhir/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="deskripsi_akhir" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($deskripsi->d_laporan_akhir) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <a type="button" data-toggle="modal" data-target="#AdadeskripsiAkhir">
                                                <p class="text-break"><?= $deskripsi->d_laporan_akhir ?></p>
                                            </a>
                                            <div class="modal fade" id="AdadeskripsiAkhir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Akhir</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_deskripsi_akhir/$idproposal") : base_url("Upload_berkas_penelitian/edit_deskripsi_akhir/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="deskripsi_akhir" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($deskripsi->d_laporan_akhir) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                                <?php if (isset($deskripsi->d_laporan_akhir)) : ?>
                                                                    <form action="<?= base_url("Upload_berkas_penelitian/hapus_deskripsi_akhir/$idproposal") ?>">
                                                                        <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                    </form>
                                                                <?php endif; ?>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="tr">
                                    <div class="td">3</div>
                                    <div class="td">Laporan Keuangan</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#laporan_keuangan">
                                            <?= empty($berkas->b_laporan_keuangan) ? 'Unggah File' : 'Edit / Hapus File' ?>
                                        </button>
                                        <div class="modal fade" id="laporan_keuangan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Laporan Keuangan
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="file_laporan_keuangan">PILIH METODE UNGGAH</label>
                                                            <select id="file_laporan_keuangan" class="form-control" onchange="MetodeUnggahLaporan(this);">
                                                                <option></option>
                                                                <option id="metode_file_keuangan">File</option>
                                                                <option id="metode_url_keuangan">URL</option>
                                                            </select>
                                                        </div>
                                                        <div id="metode_file_keuangan_select" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_berkas_laporan_keuangan/$idproposal") : base_url("Upload_berkas_penelitian/edit_berkas_laporan_keuangan/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Laporan Keuangan</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input name="berkas_laporan_keuangan" type="file" class="custom-file-input" id="berkas_laporan_keuangan" accept="application/pdf">
                                                                        <label class="custom-file-label" for="berkas_laporan_keuangan">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->b_laporan_keuangan) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->b_laporan_keuangan)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_berkas_laporan_keuangan/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div id="metode_url_keuangan_select" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_berkas_laporan_keuangan_url/$idproposal") : base_url("Upload_berkas_penelitian/edit_berkas_laporan_keuangan_url/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon3">https://example.com/</span>
                                                                    </div>
                                                                    <input type="url" class="form-control" name="berkas_laporan_keuangan_url" id="berkas_laporan_keuangan_url" aria-describedby="basic-addon3">
                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->b_laporan_keuangan) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->b_laporan_keuangan)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_berkas_laporan_keuangan/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->b_laporan_keuangan)) {
                                            echo '<button type="button" class="btn btn-danger">Masih Belum Ada File</button>';
                                        } elseif (filter_var($berkas->b_laporan_keuangan, FILTER_VALIDATE_URL)) {
                                            echo '<a target="_blank"href="' . $berkas->b_laporan_keuangan . '">' . $berkas->b_laporan_keuangan . '</a>';
                                        } else {
                                            echo '<a target="_blank"href="' . base_url("assets/berkas/file_laporan/penelitian/") . $berkas->b_laporan_keuangan . '">' . $berkas->b_laporan_keuangan . '</a>';
                                        }
                                        ?>


                                    </div>
                                    <div class="td">
                                        <?php if (empty($deskripsi->d_laporan_keuangan)) : ?>
                                            <a type="button" data-toggle="modal" data-target="#TidakdeskripsiKeuangan">
                                                <button type="button" class="btn btn-danger">Klik Disini Untuk Menambahkan Deskripsi</button>
                                            </a>
                                            <div class="modal fade" id="TidakdeskripsiKeuangan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Keuangan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_deskripsi_keuangan/$idproposal") : base_url("Upload_berkas_penelitian/edit_deskripsi_keuangan/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="deskripsi_keuangan" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($deskripsi->d_laporan_keuangan) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <a type="button" data-toggle="modal" data-target="#AdadeskripsiKeuangan">
                                                <p class="text-break"><?= $deskripsi->d_laporan_keuangan ?></p>
                                            </a>
                                            <div class="modal fade" id="AdadeskripsiKeuangan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Keuangan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_deskripsi_keuangan/$idproposal") : base_url("Upload_berkas_penelitian/edit_deskripsi_keuangan/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="deskripsi_keuangan" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($deskripsi->d_laporan_keuangan) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                                <?php if (isset($deskripsi->d_laporan_keuangan)) : ?>
                                                                    <form action="<?= base_url("Upload_berkas_penelitian/hapus_deskripsi_keuangan/$idproposal") ?>">
                                                                        <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                    </form>
                                                                <?php endif; ?>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="tr">
                                    <div class="td"></div>
                                    <div class="td font-weight-bold">Luaran Wajib</div>
                                </div>
                                <div class="tr">
                                    <div class="td">1</div>
                                    <div class="td">Berupa naskah akademik yang dapat berupa policy brief, rekomendasi kebijakan, atau model kebijakan strategis terhadap suatu permasalahan di unit institusi atau instansi lain.</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#w_b1">
                                            <?= empty($berkas->w_b1) ? 'Unggah File' : 'Edit / Hapus File' ?>
                                        </button>
                                        <div class="modal fade" id="w_b1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Berupa naskah akademik yang dapat berupa policy brief, rekomendasi kebijakan, atau model kebijakan strategis terhadap suatu permasalahan di unit institusi atau instansi lain.
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="file_luaran_wb1">PILIH METODE UNGGAH</label>
                                                            <select id="file_luaran_wb1" class="form-control" onchange="MetodeLuaranCheck(this);">
                                                                <option></option>
                                                                <option id="luaran_file_wb1">File</option>
                                                                <option id="luaran_url_wb1">URL</option>
                                                            </select>
                                                        </div>
                                                        <div id="luaran_file_select_wb1" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_wb1/$idproposal") : base_url("Upload_berkas_penelitian/edit_wb1/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Luaran Wajib
                                                                            1</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input name="wb1" type="file" class="custom-file-input" id="wb1" accept="application/pdf">
                                                                        <label class="custom-file-label" for="wb1">Choose
                                                                            file</label>
                                                                    </div>

                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="ds1" class="form-control" id="wb1" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->w_b1) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->w_b1)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_wb1/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div id="luaran_url_select_wb1" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_wb1_url/$idproposal") : base_url("Upload_berkas_penelitian/edit_wb1_url/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon3">https://example.com/</span>
                                                                    </div>
                                                                    <input type="url" class="form-control" name="wb1" id="wb1" aria-describedby="basic-addon3">
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="ds1" class="form-control" id="wb1" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->w_b1) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->w_b1)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_wb1/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->w_b1)) {
                                            echo '<button type="button" class="btn btn-danger">Masih Belum Ada File</button>';
                                        } elseif (filter_var($berkas->w_b1, FILTER_VALIDATE_URL)) {
                                            echo '<a target="_blank"href="' . $berkas->w_b1 . '">' . $berkas->w_b1 . '</a>';
                                        } else {
                                            echo '<a target="_blank"href="' . base_url("assets/berkas/file_laporan/penelitian/") . $berkas->w_b1 . '">' . $berkas->w_b1 . '</a>';
                                        }
                                        ?>


                                    </div>
                                    <div class="td">
                                        <?php if (empty($deskripsi->d_w1)) : ?>
                                            <a type="button" data-toggle="modal" data-target="#Tidakd_w1">
                                                <button type="button" class="btn btn-danger">Klik Disini Untuk Menambahkan Deskripsi</button>
                                            </a>
                                            <div class="modal fade" id="Tidakd_w1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Wajib 1</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_w1/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_w1/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_w1" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($deskripsi->d_w1) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <a type="button" data-toggle="modal" data-target="#Adad_w1">
                                                <p class="text-break"><?= $deskripsi->d_w1 ?></p>
                                            </a>
                                            <div class="modal fade" id="Adad_w1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Wajib 1</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_w1/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_w1/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_w1" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->w_b1) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                                <?php if (isset($deskripsi->d_w1)) : ?>
                                                                    <form action="<?= base_url("Upload_berkas_penelitian/hapus_d_w1/$idproposal") ?>">
                                                                        <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                    </form>
                                                                <?php endif; ?>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- <div class="td">
                                    <p style="text-align: center;">Testing</p>
                                </div> -->
                                </div>
                                <div class="tr">
                                    <div class="td">2</div>
                                    <div class="td">Artikel di jurnal internasional yang terindeks pada database minimal Q3 dengan status minimal submitted</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#w_b2">
                                            <?= empty($berkas->w_b2) ? 'Unggah File' : 'Edit / Hapus File' ?>
                                        </button>
                                        <div class="modal fade" id="w_b2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Artikel di jurnal internasional yang terindeks pada database minimal Q3 dengan status minimal submitted</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="file_luaran_wb2">PILIH METODE UNGGAH</label>
                                                            <select id="file_luaran_wb2" class="form-control" onchange="MetodeLuaranCheck(this);">
                                                                <option></option>
                                                                <option id="luaran_file_wb2">File</option>
                                                                <option id="luaran_url_wb2">URL</option>
                                                            </select>
                                                        </div>
                                                        <div id="luaran_file_select_wb2" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_wb2/$idproposal") : base_url("Upload_berkas_penelitian/edit_wb2/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Luaran Wajib
                                                                            2</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input name="wb2" type="file" class="custom-file-input" id="wb2" accept="application/pdf">
                                                                        <label class="custom-file-label" for="wb2">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="ds2" class="form-control" id="wb2" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->w_b2) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->w_b2)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_wb2/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div id="luaran_url_select_wb2" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_wb2_url/$idproposal") : base_url("Upload_berkas_penelitian/edit_wb2_url/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon3">https://example.com/</span>
                                                                    </div>
                                                                    <input type="url" class="form-control" name="wb2" id="wb2" aria-describedby="basic-addon3">
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="ds2" class="form-control" id="wb2" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->w_b2) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->w_b2)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_wb2/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->w_b2)) {
                                            echo '<button type="button" class="btn btn-danger">Masih Belum Ada File</button>';
                                        } elseif (filter_var($berkas->w_b2, FILTER_VALIDATE_URL)) {
                                            echo '<a target="_blank"href="' . $berkas->w_b2 . '">' . $berkas->w_b2 . '</a>';
                                        } else {
                                            echo '<a target="_blank"href="' . base_url("assets/berkas/file_laporan/penelitian/") . $berkas->w_b2 . '">' . $berkas->w_b2 . '</a>';
                                        }
                                        ?>
                                    </div>
                                    <div class="td">
                                        <?php if (empty($deskripsi->d_w2)) : ?>
                                            <a type="button" data-toggle="modal" data-target="#Tidakd_w2">
                                                <button type="button" class="btn btn-danger">Klik Disini Untuk Menambahkan Deskripsi</button>
                                            </a>
                                            <div class="modal fade" id="Tidakd_w2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Wajib 2</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_w2/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_w2/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_w2" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($deskripsi->d_w2) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <a type="button" data-toggle="modal" data-target="#Adad_w2">
                                                <p class="text-break"><?= $deskripsi->d_w2 ?></p>
                                            </a>
                                            <div class="modal fade" id="Adad_w2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Wajib 2</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_w2/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_w2/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_w2" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->w_b1) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                                <?php if (isset($deskripsi->d_w2)) : ?>
                                                                    <form action="<?= base_url("Upload_berkas_penelitian/hapus_d_w2/$idproposal") ?>">
                                                                        <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                    </form>
                                                                <?php endif; ?>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- <div class="td">
                                    <p style="text-align: center;">Testing</p>
                                </div> -->
                                </div>
                                <div class="tr">
                                    <div class="td">3</div>
                                    <div class="td">MoU (signed atau rintisan) kerjasama penelitian dengan mitra Luar Negeri</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#w_b3">
                                            <?= empty($berkas->w_b3) ? 'Unggah File' : 'Edit / Hapus File' ?>
                                        </button>
                                        <div class="modal fade" id="w_b3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">MoU (signed atau rintisan) kerjasama penelitian dengan mitra Luar Negeri
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="file_luaran_wb3">PILIH METODE UNGGAH</label>
                                                            <select id="file_luaran_wb3" class="form-control" onchange="MetodeLuaranCheck(this);">
                                                                <option></option>
                                                                <option id="luaran_file_wb3">File</option>
                                                                <option id="luaran_url_wb3">URL</option>
                                                            </select>
                                                        </div>
                                                        <div id="luaran_file_select_wb3" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_wb3/$idproposal") : base_url("Upload_berkas_penelitian/edit_wb3/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Luaran Wajib
                                                                            3</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input name="wb3" type="file" class="custom-file-input" id="wb3" accept="application/pdf">
                                                                        <label class="custom-file-label" for="wb3">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="ds3" class="form-control" id="wb3" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->w_b3) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->w_b3)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_wb3/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div id="luaran_url_select_wb3" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_wb3_url/$idproposal") : base_url("Upload_berkas_penelitian/edit_wb3_url/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon3">https://example.com/</span>
                                                                    </div>
                                                                    <input type="url" class="form-control" name="wb3" id="wb3" aria-describedby="basic-addon3">
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="ds3" class="form-control" id="wb3" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->w_b3) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->w_b3)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_wb3/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->w_b3)) {
                                            echo '<button type="button" class="btn btn-danger">Masih Belum Ada File</button>';
                                        } elseif (filter_var($berkas->w_b3, FILTER_VALIDATE_URL)) {
                                            echo '<a target="_blank"href="' . $berkas->w_b3 . '">' . $berkas->w_b3 . '</a>';
                                        } else {
                                            echo '<a target="_blank"href="' . base_url("assets/berkas/file_laporan/penelitian/") . $berkas->w_b3 . '">' . $berkas->w_b3 . '</a>';
                                        }
                                        ?>
                                    </div>
                                    <div class="td">
                                        <?php if (empty($deskripsi->d_w3)) : ?>
                                            <a type="button" data-toggle="modal" data-target="#Tidakd_w3">
                                                <button type="button" class="btn btn-danger">Klik Disini Untuk Menambahkan Deskripsi</button>
                                            </a>
                                            <div class="modal fade" id="Tidakd_w3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Wajib 3</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_w3/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_w3/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_w3" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($deskripsi->d_w3) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <a type="button" data-toggle="modal" data-target="#Adad_w3">
                                                <p class="text-break"><?= $deskripsi->d_w3 ?></p>
                                            </a>
                                            <div class="modal fade" id="Adad_w3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Wajib 3</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_w3/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_w3/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_w3" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->w_b1) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                                <?php if (isset($deskripsi->d_w3)) : ?>
                                                                    <form action="<?= base_url("Upload_berkas_penelitian/hapus_d_w3/$idproposal") ?>">
                                                                        <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                    </form>
                                                                <?php endif; ?>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- <div class="td">
                                    <p style="text-align: center;">Testing</p>
                                </div> -->
                                </div>
                                <div class="tr">
                                    <div class="td"></div>
                                    <div class="td font-weight-bold">Luaran Tambahan</div>
                                </div>
                                <div class="tr">
                                    <div class="td">1</div>
                                    <div class="td">Jurnal Nasional Terakreditasi atau Jurnal Internasional atau
                                        Jurnal
                                        Internasional Bereputasi
                                    </div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#t_b1">
                                            <?= empty($berkas->t_b1) ? 'Unggah File' : 'Edit / Hapus File' ?>
                                        </button>
                                        <div class="modal fade" id="t_b1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Jurnal Nasional Terakreditasi atau Jurnal Internasional atau
                                                            Jurnal
                                                            Internasional Bereputasi
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="file_luaran_tb1">PILIH METODE UNGGAH</label>
                                                            <select id="file_luaran_tb1" class="form-control" onchange="MetodeLuaranCheck(this);">
                                                                <option></option>
                                                                <option id="luaran_file_tb1">File</option>
                                                                <option id="luaran_url_tb1">URL</option>
                                                            </select>
                                                        </div>
                                                        <div id="luaran_file_select_tb1" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_tb1/$idproposal") : base_url("Upload_berkas_penelitian/edit_tb1/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Luaran Tambahan 1</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input name="tb1" type="file" class="custom-file-input" id="tb1" accept="application/pdf">
                                                                        <label class="custom-file-label" for="tb1">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="dt1" class="form-control" id="tb1" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->t_b1) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->t_b1)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_tb1/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div id="luaran_url_select_tb1" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_tb1_url/$idproposal") : base_url("Upload_berkas_penelitian/edit_tb1_url/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon3">https://example.com/</span>
                                                                    </div>
                                                                    <input type="url" class="form-control" name="tb1" id="tb1" aria-describedby="basic-addon3">
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="dt1" class="form-control" id="tb1" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->t_b1) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->t_b1)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_tb1/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->t_b1)) {
                                            echo '<button type="button" class="btn btn-danger">Masih Belum Ada File</button>';
                                        } elseif (filter_var($berkas->t_b1, FILTER_VALIDATE_URL)) {
                                            echo '<a target="_blank"href="' . $berkas->t_b1 . '">' . $berkas->t_b1 . '</a>';
                                        } else {
                                            echo '<a target="_blank"href="' . base_url("assets/berkas/file_laporan/penelitian/") . $berkas->t_b1 . '">' . $berkas->t_b1 . '</a>';
                                        }
                                        ?>
                                    </div>
                                    <div class="td">
                                        <?php if (empty($deskripsi->d_t1)) : ?>
                                            <a type="button" data-toggle="modal" data-target="#Tidakd_t1">
                                                <button type="button" class="btn btn-danger">Klik Disini Untuk Menambahkan Deskripsi</button>
                                            </a>
                                            <div class="modal fade" id="Tidakd_t1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Tambahan 1</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_t1/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_t1/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_t1" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($deskripsi->d_t1) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <a type="button" data-toggle="modal" data-target="#Adad_t1">
                                                <p class="text-break"><?= $deskripsi->d_t1 ?></p>
                                            </a>
                                            <div class="modal fade" id="Adad_t1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Tambahan 1</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_t1/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_t1/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_t1" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->w_b1) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                                <?php if (isset($deskripsi->d_t1)) : ?>
                                                                    <form action="<?= base_url("Upload_berkas_penelitian/hapus_d_t1/$idproposal") ?>">
                                                                        <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                    </form>
                                                                <?php endif; ?>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- <div class="td">
                                    <p style="text-align: center;">Testing</p>
                                </div> -->
                                </div>
                                <div class="tr">
                                    <div class="td">2</div>
                                    <div class="td">HKI berupa Paten, Paten Sederhana, Hak Cipta, Perlindungan
                                        Varietas
                                        Tanaman, Desain Tata Letak Sirkuit Terpadu, Naskah kebijakan dengan status
                                        Terdaftar
                                    </div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#t_b2">
                                            <?= empty($berkas->t_b2) ? 'Unggah File' : 'Edit / Hapus File' ?>
                                        </button>
                                        <div class="modal fade" id="t_b2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">HKI berupa Paten, Paten Sederhana, Hak Cipta, Perlindungan
                                                            Varietas
                                                            Tanaman, Desain Tata Letak Sirkuit Terpadu, Naskah kebijakan dengan status
                                                            Terdaftar
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="file_luaran_tb2">PILIH METODE UNGGAH</label>
                                                            <select id="file_luaran_tb2" class="form-control" onchange="MetodeLuaranCheck(this);">
                                                                <option></option>
                                                                <option id="luaran_file_tb2">File</option>
                                                                <option id="luaran_url_tb2">URL</option>
                                                            </select>
                                                        </div>
                                                        <div id="luaran_file_select_tb2" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_tb2/$idproposal") : base_url("Upload_berkas_penelitian/edit_tb2/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Luaran Tambahan 2</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input name="tb2" type="file" class="custom-file-input" id="tb2" accept="application/pdf">
                                                                        <label class="custom-file-label" for="tb2">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="dt2" class="form-control" id="tb2" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->t_b2) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->t_b2)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_tb2/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div id="luaran_url_select_tb2" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_tb2_url/$idproposal") : base_url("Upload_berkas_penelitian/edit_tb2_url/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon3">https://example.com/</span>
                                                                    </div>
                                                                    <input type="url" class="form-control" name="tb2" id="tb2" aria-describedby="basic-addon3">
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="dt2" class="form-control" id="tb2" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->t_b2) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->t_b2)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_tb2/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->t_b2)) {
                                            echo '<button type="button" class="btn btn-danger">Masih Belum Ada File</button>';
                                        } elseif (filter_var($berkas->t_b2, FILTER_VALIDATE_URL)) {
                                            echo '<a target="_blank"href="' . $berkas->t_b2 . '">' . $berkas->t_b2 . '</a>';
                                        } else {
                                            echo '<a target="_blank"href="' . base_url("assets/berkas/file_laporan/penelitian/") . $berkas->t_b2 . '">' . $berkas->t_b2 . '</a>';
                                        }
                                        ?>
                                    </div>
                                    <div class="td">
                                        <?php if (empty($deskripsi->d_t2)) : ?>
                                            <a type="button" data-toggle="modal" data-target="#Tidakd_t2">
                                                <button type="button" class="btn btn-danger">Klik Disini Untuk Menambahkan Deskripsi</button>
                                            </a>
                                            <div class="modal fade" id="Tidakd_t2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Tambahan 2</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_t2/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_t2/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_t2" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($deskripsi->d_t2) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <a type="button" data-toggle="modal" data-target="#Adad_t2">
                                                <p class="text-break"><?= $deskripsi->d_t2 ?></p>
                                            </a>
                                            <div class="modal fade" id="Adad_t2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Tambahan 2</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_t2/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_t2/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_t2" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->w_b1) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                                <?php if (isset($deskripsi->d_t2)) : ?>
                                                                    <form action="<?= base_url("Upload_berkas_penelitian/hapus_d_t2/$idproposal") ?>">
                                                                        <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                    </form>
                                                                <?php endif; ?>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- <div class="td">
                                    <p style="text-align: center;">Testing</p>
                                </div> -->
                                </div>
                                <div class="tr">
                                    <div class="td">3</div>
                                    <div class="td">Draft Buku hasil penelitian atau bahan ajar</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#t_b3">
                                            <?= empty($berkas->t_b3) ? 'Unggah File' : 'Edit / Hapus File' ?>
                                        </button>
                                        <div class="modal fade" id="t_b3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Draft Buku hasil penelitian atau bahan ajar
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="file_luaran_tb3">PILIH METODE UNGGAH</label>
                                                            <select id="file_luaran_tb3" class="form-control" onchange="MetodeLuaranCheck(this);">
                                                                <option></option>
                                                                <option id="luaran_file_tb3">File</option>
                                                                <option id="luaran_url_tb3">URL</option>
                                                            </select>
                                                        </div>
                                                        <div id="luaran_file_select_tb3" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_tb3/$idproposal") : base_url("Upload_berkas_penelitian/edit_tb3/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Luaran Tambahan 3</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input name="tb3" type="file" class="custom-file-input" id="tb3" accept="application/pdf">
                                                                        <label class="custom-file-label" for="tb3">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="dt3" class="form-control" id="tb3" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->t_b3) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->t_b3)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_tb3/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div id="luaran_url_select_tb3" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_tb3_url/$idproposal") : base_url("Upload_berkas_penelitian/edit_tb3_url/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon3">https://example.com/</span>
                                                                    </div>
                                                                    <input type="url" class="form-control" name="tb3" id="tb3" aria-describedby="basic-addon3">
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="dt3" class="form-control" id="tb3" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->t_b3) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->t_b3)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_tb3/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->t_b3)) {
                                            echo '<button type="button" class="btn btn-danger">Masih Belum Ada File</button>';
                                        } elseif (filter_var($berkas->t_b3, FILTER_VALIDATE_URL)) {
                                            echo '<a target="_blank"href="' . $berkas->t_b3 . '">' . $berkas->t_b3 . '</a>';
                                        } else {
                                            echo '<a target="_blank"href="' . base_url("assets/berkas/file_laporan/penelitian/") . $berkas->t_b3 . '">' . $berkas->t_b3 . '</a>';
                                        }
                                        ?>
                                    </div>
                                    <div class="td">
                                        <?php if (empty($deskripsi->d_t3)) : ?>
                                            <a type="button" data-toggle="modal" data-target="#Tidakd_t3">
                                                <button type="button" class="btn btn-danger">Klik Disini Untuk Menambahkan Deskripsi</button>
                                            </a>
                                            <div class="modal fade" id="Tidakd_t3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Tambahan 3</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_t3/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_t3/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_t3" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($deskripsi->d_t3) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <a type="button" data-toggle="modal" data-target="#Adad_t3">
                                                <p class="text-break"><?= $deskripsi->d_t3 ?></p>
                                            </a>
                                            <div class="modal fade" id="Adad_t3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Tambahan 3</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_t3/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_t3/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_t3" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->w_b1) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                                <?php if (isset($deskripsi->d_t3)) : ?>
                                                                    <form action="<?= base_url("Upload_berkas_penelitian/hapus_d_t3/$idproposal") ?>">
                                                                        <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                    </form>
                                                                <?php endif; ?>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- <div class="td">
                                    <p style="text-align: center;">Testing</p>
                                </div> -->
                                </div>
                                <div class="tr">
                                    <div class="td">4</div>
                                    <div class="td">Book chapter yang diterbitkan oleh penerbit bereputasi dan
                                        ber-ISBN
                                    </div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#t_b4">
                                            <?= empty($berkas->t_b4) ? 'Unggah File' : 'Edit / Hapus File' ?>
                                        </button>
                                        <div class="modal fade" id="t_b4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Book chapter yang diterbitkan oleh penerbit bereputasi dan
                                                            ber-ISBN
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="file_luaran_tb4">PILIH METODE UNGGAH</label>
                                                            <select id="file_luaran_tb4" class="form-control" onchange="MetodeLuaranCheck(this);">
                                                                <option></option>
                                                                <option id="luaran_file_tb4">File</option>
                                                                <option id="luaran_url_tb4">URL</option>
                                                            </select>
                                                        </div>
                                                        <div id="luaran_file_select_tb4" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_tb4/$idproposal") : base_url("Upload_berkas_penelitian/edit_tb4/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Luaran Tambahan 4</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input name="tb4" type="file" class="custom-file-input" id="tb4" accept="application/pdf">
                                                                        <label class="custom-file-label" for="tb4">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="dt4" class="form-control" id="tb4" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->t_b4) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->t_b4)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_tb4/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div id="luaran_url_select_tb4" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_tb4_url/$idproposal") : base_url("Upload_berkas_penelitian/edit_tb4_url/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon3">https://example.com/</span>
                                                                    </div>
                                                                    <input type="url" class="form-control" name="tb4" id="tb4" aria-describedby="basic-addon3">
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="dt4" class="form-control" id="tb4" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->t_b4) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->t_b4)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_tb4/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->t_b4)) {
                                            echo '<button type="button" class="btn btn-danger">Masih Belum Ada File</button>';
                                        } elseif (filter_var($berkas->t_b4, FILTER_VALIDATE_URL)) {
                                            echo '<a target="_blank"href="' . $berkas->t_b4 . '">' . $berkas->t_b4 . '</a>';
                                        } else {
                                            echo '<a target="_blank"href="' . base_url("assets/berkas/file_laporan/penelitian/") . $berkas->t_b4 . '">' . $berkas->t_b4 . '</a>';
                                        }
                                        ?>
                                    </div>
                                    <div class="td">
                                        <?php if (empty($deskripsi->d_t4)) : ?>
                                            <a type="button" data-toggle="modal" data-target="#Tidakd_t4">
                                                <button type="button" class="btn btn-danger">Klik Disini Untuk Menambahkan Deskripsi</button>
                                            </a>
                                            <div class="modal fade" id="Tidakd_t4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Tambahan 4</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_t4/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_t4/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_t4" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($deskripsi->d_t4) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <a type="button" data-toggle="modal" data-target="#Adad_t4">
                                                <p class="text-break"><?= $deskripsi->d_t4 ?></p>
                                            </a>
                                            <div class="modal fade" id="Adad_t4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Tambahan 4</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_t4/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_t4/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_t4" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->w_b1) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                                <?php if (isset($deskripsi->d_t4)) : ?>
                                                                    <form action="<?= base_url("Upload_berkas_penelitian/hapus_d_t4/$idproposal") ?>">
                                                                        <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                    </form>
                                                                <?php endif; ?>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- <div class="td">
                                    <p style="text-align: center;">Testing</p>
                                </div> -->
                                </div>
                                <div class="tr">
                                    <div class="td">5</div>
                                    <div class="td">Keynote speaker dalam temu ilmiah (internasional, nasional dan
                                        lokal)</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#t_b5">
                                            <?= empty($berkas->t_b5) ? 'Unggah File' : 'Edit / Hapus File' ?>
                                        </button>
                                        <div class="modal fade" id="t_b5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Keynote speaker dalam temu ilmiah (internasional, nasional dan
                                                            lokal)
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="file_luaran_tb5">PILIH METODE UNGGAH</label>
                                                            <select id="file_luaran_tb5" class="form-control" onchange="MetodeLuaranCheck(this);">
                                                                <option></option>
                                                                <option id="luaran_file_tb5">File</option>
                                                                <option id="luaran_url_tb5">URL</option>
                                                            </select>
                                                        </div>
                                                        <div id="luaran_file_select_tb5" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_tb5/$idproposal") : base_url("Upload_berkas_penelitian/edit_tb5/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Luaran Tambahan 5</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input name="tb5" type="file" class="custom-file-input" id="tb5" accept="application/pdf">
                                                                        <label class="custom-file-label" for="tb5">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="dt5" class="form-control" id="tb5" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->t_b5) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->t_b5)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_tb5/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div id="luaran_url_select_tb5" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_tb5_url/$idproposal") : base_url("Upload_berkas_penelitian/edit_tb5_url/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon3">https://example.com/</span>
                                                                    </div>
                                                                    <input type="url" class="form-control" name="tb5" id="tb5" aria-describedby="basic-addon3">
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="dt5" class="form-control" id="tb5" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->t_b5) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->t_b5)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_tb5/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->t_b5)) {
                                            echo '<button type="button" class="btn btn-danger">Masih Belum Ada File</button>';
                                        } elseif (filter_var($berkas->t_b5, FILTER_VALIDATE_URL)) {
                                            echo '<a target="_blank"href="' . $berkas->t_b5 . '">' . $berkas->t_b5 . '</a>';
                                        } else {
                                            echo '<a target="_blank"href="' . base_url("assets/berkas/file_laporan/penelitian/") . $berkas->t_b5 . '">' . $berkas->t_b5 . '</a>';
                                        }
                                        ?>
                                    </div>
                                    <div class="td">
                                        <?php if (empty($deskripsi->d_t5)) : ?>
                                            <a type="button" data-toggle="modal" data-target="#Tidakd_t5">
                                                <button type="button" class="btn btn-danger">Klik Disini Untuk Menambahkan Deskripsi</button>
                                            </a>
                                            <div class="modal fade" id="Tidakd_t5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Tambahan 5</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_t5/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_t5/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_t5" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($deskripsi->d_t5) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <a type="button" data-toggle="modal" data-target="#Adad_t5">
                                                <p class="text-break"><?= $deskripsi->d_t5 ?></p>
                                            </a>
                                            <div class="modal fade" id="Adad_t5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Tambahan 5</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_t5/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_t5/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_t5" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->w_b1) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                                <?php if (isset($deskripsi->d_t5)) : ?>
                                                                    <form action="<?= base_url("Upload_berkas_penelitian/hapus_d_t5/$idproposal") ?>">
                                                                        <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                    </form>
                                                                <?php endif; ?>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- <div class="td">
                                    <p style="text-align: center;">Testing</p>
                                </div> -->
                                </div>
                                <div class="tr">
                                    <div class="td">6</div>
                                    <div class="td">Pembicara kunci atau visiting lecturer (internasional)</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#t_b6">
                                            <?= empty($berkas->t_b6) ? 'Unggah File' : 'Edit / Hapus File' ?>
                                        </button>
                                        <div class="modal fade" id="t_b6" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Jurnal Nasional Terakreditasi atau Jurnal Internasional atau
                                                            Jurnal
                                                            Internasional Bereputasi
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="file_luaran_tb6">PILIH METODE UNGGAH</label>
                                                            <select id="file_luaran_tb6" class="form-control" onchange="MetodeLuaranCheck(this);">
                                                                <option></option>
                                                                <option id="luaran_file_tb6">File</option>
                                                                <option id="luaran_url_tb6">URL</option>
                                                            </select>
                                                        </div>
                                                        <div id="luaran_file_select_tb6" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_tb6/$idproposal") : base_url("Upload_berkas_penelitian/edit_tb6/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Luaran Tambahan 6</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input name="tb6" type="file" class="custom-file-input" id="tb6" accept="application/pdf">
                                                                        <label class="custom-file-label" for="tb6">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="dt6" class="form-control" id="tb6" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->t_b6) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->t_b6)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_tb6/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div id="luaran_url_select_tb6" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_tb6_url/$idproposal") : base_url("Upload_berkas_penelitian/edit_tb6_url/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon3">https://example.com/</span>
                                                                    </div>
                                                                    <input type="url" class="form-control" name="tb6" id="tb6" aria-describedby="basic-addon3">
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="dt6" class="form-control" id="tb6" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->t_b6) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->t_b6)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_tb6/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->t_b6)) {
                                            echo '<button type="button" class="btn btn-danger">Masih Belum Ada File</button>';
                                        } elseif (filter_var($berkas->t_b6, FILTER_VALIDATE_URL)) {
                                            echo '<a target="_blank"href="' . $berkas->t_b6 . '">' . $berkas->t_b6 . '</a>';
                                        } else {
                                            echo '<a target="_blank"href="' . base_url("assets/berkas/file_laporan/penelitian/") . $berkas->t_b6 . '">' . $berkas->t_b6 . '</a>';
                                        }
                                        ?>
                                    </div>
                                    <div class="td">
                                        <?php if (empty($deskripsi->d_t6)) : ?>
                                            <a type="button" data-toggle="modal" data-target="#Tidakd_t6">
                                                <button type="button" class="btn btn-danger">Klik Disini Untuk Menambahkan Deskripsi</button>
                                            </a>
                                            <div class="modal fade" id="Tidakd_t6" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Tambahan 6</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_t6/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_t6/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_t6" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($deskripsi->d_t6) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <a type="button" data-toggle="modal" data-target="#Adad_t6">
                                                <p class="text-break"><?= $deskripsi->d_t6 ?></p>
                                            </a>
                                            <div class="modal fade" id="Adad_t6" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Tambahan 6</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_t6/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_t6/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_t6" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->w_b1) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                                <?php if (isset($deskripsi->d_t6)) : ?>
                                                                    <form action="<?= base_url("Upload_berkas_penelitian/hapus_d_t6/$idproposal") ?>">
                                                                        <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                    </form>
                                                                <?php endif; ?>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- <div class="td">
                                    <p style="text-align: center;">Testing</p>
                                </div> -->
                                </div>
                                <div class="tr">
                                    <div class="td">7</div>
                                    <div class="td">Dokumen feasibility study, business plan</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#t_b7">
                                            <?= empty($berkas->t_b7) ? 'Unggah File' : 'Edit / Hapus File' ?>
                                        </button>
                                        <div class="modal fade" id="t_b7" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Jurnal Nasional Terakreditasi atau Jurnal Internasional atau
                                                            Jurnal
                                                            Internasional Bereputasi
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="file_luaran_tb7">PILIH METODE UNGGAH</label>
                                                            <select id="file_luaran_tb7" class="form-control" onchange="MetodeLuaranCheck(this);">
                                                                <option></option>
                                                                <option id="luaran_file_tb7">File</option>
                                                                <option id="luaran_url_tb7">URL</option>
                                                            </select>
                                                        </div>
                                                        <div id="luaran_file_select_tb7" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_tb7/$idproposal") : base_url("Upload_berkas_penelitian/edit_tb7/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Luaran Tambahan 7</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input name="tb7" type="file" class="custom-file-input" id="tb7" accept="application/pdf">
                                                                        <label class="custom-file-label" for="tb7">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="dt7" class="form-control" id="tb7" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->t_b7) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->t_b7)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_tb7/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div id="luaran_url_select_tb7" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_tb7_url/$idproposal") : base_url("Upload_berkas_penelitian/edit_tb7_url/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon3">https://example.com/</span>
                                                                    </div>
                                                                    <input type="url" class="form-control" name="tb7" id="tb7" aria-describedby="basic-addon3">
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="dt7" class="form-control" id="tb7" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->t_b7) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->t_b7)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_tb7/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->t_b7)) {
                                            echo '<button type="button" class="btn btn-danger">Masih Belum Ada File</button>';
                                        } elseif (filter_var($berkas->t_b7, FILTER_VALIDATE_URL)) {
                                            echo '<a target="_blank"href="' . $berkas->t_b7 . '">' . $berkas->t_b7 . '</a>';
                                        } else {
                                            echo '<a target="_blank"href="' . base_url("assets/berkas/file_laporan/penelitian/") . $berkas->t_b7 . '">' . $berkas->t_b7 . '</a>';
                                        }
                                        ?>
                                    </div>
                                    <div class="td">
                                        <?php if (empty($deskripsi->d_t7)) : ?>
                                            <a type="button" data-toggle="modal" data-target="#Tidakd_t7">
                                                <button type="button" class="btn btn-danger">Klik Disini Untuk Menambahkan Deskripsi</button>
                                            </a>
                                            <div class="modal fade" id="Tidakd_t7" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Tambahan 7</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_t7/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_t7/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_t7" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($deskripsi->d_t7) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <a type="button" data-toggle="modal" data-target="#Adad_t7">
                                                <p class="text-break"><?= $deskripsi->d_t7 ?></p>
                                            </a>
                                            <div class="modal fade" id="Adad_t7" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Tambahan 7</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_t7/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_t7/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_t7" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->w_b1) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                                <?php if (isset($deskripsi->d_t7)) : ?>
                                                                    <form action="<?= base_url("Upload_berkas_penelitian/hapus_d_t7/$idproposal") ?>">
                                                                        <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                    </form>
                                                                <?php endif; ?>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- <div class="td">
                                    <p style="text-align: center;">Testing</p>
                                </div> -->
                                </div>
                                <div class="tr">
                                    <div class="td">8</div>
                                    <div class="td">Naskah akademik (policy brief, rekomendasi kebijakan atau model
                                        kebijakan strategis)</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#t_b8">
                                            <?= empty($berkas->t_b8) ? 'Unggah File' : 'Edit / Hapus File' ?>
                                        </button>
                                        <div class="modal fade" id="t_b8" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Jurnal Nasional Terakreditasi atau Jurnal Internasional atau
                                                            Jurnal
                                                            Internasional Bereputasi
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="file_luaran_tb8">PILIH METODE UNGGAH</label>
                                                            <select id="file_luaran_tb8" class="form-control" onchange="MetodeLuaranCheck(this);">
                                                                <option></option>
                                                                <option id="luaran_file_tb8">File</option>
                                                                <option id="luaran_url_tb8">URL</option>
                                                            </select>
                                                        </div>
                                                        <div id="luaran_file_select_tb8" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_tb8/$idproposal") : base_url("Upload_berkas_penelitian/edit_tb8/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Luaran Tambahan 8</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input name="tb8" type="file" class="custom-file-input" id="tb8" accept="application/pdf">
                                                                        <label class="custom-file-label" for="tb8">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="dt8" class="form-control" id="tb8" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->t_b8) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->t_b8)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_tb8/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div id="luaran_url_select_tb8" style="display: none">
                                                            <form action="<?= empty($berkas) ? base_url("Upload_berkas_penelitian/up_tb8_url/$idproposal") : base_url("Upload_berkas_penelitian/edit_tb8_url/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text" id="basic-addon3">https://example.com/</span>
                                                                    </div>
                                                                    <input type="url" class="form-control" name="tb8" id="tb8" aria-describedby="basic-addon3">
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Status Laporan Anda</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="text" name="dt8" class="form-control" id="tb8" aria-describedby="emailHelp" placeholder="Masukkan Deskripsi Laporan Anda">
                                                                    </div>

                                                                </div>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->t_b8) ? 'Unggah File' : 'Edit File' ?>" />
                                                            </form>
                                                            <?php if (isset($berkas->t_b8)) : ?>
                                                                <form action="<?= base_url("Upload_berkas_penelitian/hapus_tb8/$idproposal") ?>">
                                                                    <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                </form>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->t_b8)) {
                                            echo '<button type="button" class="btn btn-danger">Masih Belum Ada File</button>';
                                        } elseif (filter_var($berkas->t_b8, FILTER_VALIDATE_URL)) {
                                            echo '<a target="_blank"href="' . $berkas->t_b8 . '">' . $berkas->t_b8 . '</a>';
                                        } else {
                                            echo '<a target="_blank"href="' . base_url("assets/berkas/file_laporan/penelitian/") . $berkas->t_b8 . '">' . $berkas->t_b8 . '</a>';
                                        }
                                        ?>
                                    </div>
                                    <div class="td">
                                        <?php if (empty($deskripsi->d_t8)) : ?>
                                            <a type="button" data-toggle="modal" data-target="#Tidakd_t8">
                                                <button type="button" class="btn btn-danger">Klik Disini Untuk Menambahkan Deskripsi</button>
                                            </a>
                                            <div class="modal fade" id="Tidakd_t8" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Tambahan 8</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_t8/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_t8/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_t8" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($deskripsi->d_t8) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <a type="button" data-toggle="modal" data-target="#Adad_t8">
                                                <p class="text-break"><?= $deskripsi->d_t8 ?></p>
                                            </a>
                                            <div class="modal fade" id="Adad_t8" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Deskripsi Luaran Tambahan 8</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= empty($deskripsi) ? base_url("Upload_berkas_penelitian/tambah_d_t8/$idproposal") : base_url("Upload_berkas_penelitian/edit_d_t8/$idproposal") ?>" method="post" enctype="multipart/form-data">
                                                                <textarea name="d_t8" class="form-control mb-3" aria-label="Tambahkan Deskripsi"></textarea>
                                                                <input style="width:100%" class="btn btn-primary" type="submit" name="Upload" value="<?= empty($berkas->w_b1) ? 'Tambahkan Deskripsi' : 'Edit Deskripsi' ?>" />
                                                                <?php if (isset($deskripsi->d_t8)) : ?>
                                                                    <form action="<?= base_url("Upload_berkas_penelitian/hapus_d_t8/$idproposal") ?>">
                                                                        <button style="width: 100%" class="btn btn-danger mt-2" type="submit">Hapus</button>
                                                                    </form>
                                                                <?php endif; ?>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- <div class="td">
                                    <p style="text-align: center;">Testing</p>
                                </div> -->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
</div>
<!-- Keterangan Modal -->
<div class="modal fade" id="keteranganModal" tabindex="-1" role="dialog" aria-labelledby="keteranganModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="keteranganModal">Keterangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="font-size: 14px">
                    <p style="margin: 0; padding: 0;"><b>Ukuran File</b> (Tidak berlaku untuk URL) :
                    <ol>
                        <li>File Laporan Kemajuan / Akhir / Keuangan : <b>20MB</b></li>
                        <li>File Luaran Wajib / Tambahan : <b>5MB</b></li>
                    </ol>
                    </p>
                    <p style="margin: 0; padding: 0;"><b>Luaran Wajib</b> : Wajib Mengisi (Disarankan untuk tidak dikosongi)</p>
                    <p style="margin: 0; padding: 0;"><b>Luaran Tambahan</b> : Jika Tidak Ada maka Bisa Dikosongi</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Keterangan Modal
    $(document).ready(function() {
        $('#keteranganModal').modal('show');
    });

    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    function MetodeUnggahLaporan(metodeSelect) {
        if (metodeSelect) {
            // Kemajuan
            fileKemajuanOptionValue = document.getElementById("metode_file_kemajuan").value;
            urlKemajuanOptionValue = document.getElementById("metode_url_kemajuan").value;
            // Akhir
            fileAkhirOptionValue = document.getElementById("metode_file_akhir").value;
            urlAkhirOptionValue = document.getElementById("metode_url_akhir").value;
            // Keuangan
            fileKeuanganOptionValue = document.getElementById("metode_file_keuangan").value;
            urlKeuanganOptionValue = document.getElementById("metode_url_keuangan").value;

            // Kemajuan
            if (fileKemajuanOptionValue == metodeSelect.value) {
                document.getElementById("metode_file_kemajuan_select").style.display = "block";
            } else {
                document.getElementById("metode_file_kemajuan_select").style.display = "none";
            }
            if (urlKemajuanOptionValue == metodeSelect.value) {
                document.getElementById("metode_url_kemajuan_select").style.display = "block";
            } else {
                document.getElementById("metode_url_kemajuan_select").style.display = "none";
            }
            // Akhir
            if (fileAkhirOptionValue == metodeSelect.value) {
                document.getElementById("metode_file_akhir_select").style.display = "block";
            } else {
                document.getElementById("metode_file_akhir_select").style.display = "none";
            }
            if (urlAkhirOptionValue == metodeSelect.value) {
                document.getElementById("metode_url_akhir_select").style.display = "block";
            } else {
                document.getElementById("metode_url_akhir_select").style.display = "none";
            }
            // Keuangan
            if (fileKeuanganOptionValue == metodeSelect.value) {
                document.getElementById("metode_file_keuangan_select").style.display = "block";
            } else {
                document.getElementById("metode_file_keuangan_select").style.display = "none";
            }
            if (urlKeuanganOptionValue == metodeSelect.value) {
                document.getElementById("metode_url_keuangan_select").style.display = "block";
            } else {
                document.getElementById("metode_url_keuangan_select").style.display = "none";
            }
        } else {
            document.getElementById("metode_file_kemajuan_select").style.display = "none";
            document.getElementById("metode_url_kemajuan_select").style.display = "none";
        }
    };

    function MetodeLuaranCheck(fileSelect) {
        if (fileSelect) {
            // Luaran Wajib 1
            luaranFilewb1OptionValue = document.getElementById("luaran_file_wb1").value;
            luaranUrlwb1OptionValue = document.getElementById("luaran_url_wb1").value;

            // Luaran Wajib 2
            luaranFilewb2OptionValue = document.getElementById("luaran_file_wb2").value;
            luaranUrlwb2OptionValue = document.getElementById("luaran_url_wb2").value;

            // Luaran Wajib 3
            luaranFilewb3OptionValue = document.getElementById("luaran_file_wb3").value;
            luaranUrlwb3OptionValue = document.getElementById("luaran_url_wb3").value;

            // Luaran Tambahan 1
            luaranFiletb1OptionValue = document.getElementById("luaran_file_tb1").value;
            luaranUrltb1OptionValue = document.getElementById("luaran_url_tb1").value;

            // Luaran Tambahan 2
            luaranFiletb2OptionValue = document.getElementById("luaran_file_tb2").value;
            luaranUrltb2OptionValue = document.getElementById("luaran_url_tb2").value;

            // Luaran Tambahan 3
            luaranFiletb3OptionValue = document.getElementById("luaran_file_tb3").value;
            luaranUrltb3OptionValue = document.getElementById("luaran_url_tb3").value;

            // Luaran Tambahan 4
            luaranFiletb4OptionValue = document.getElementById("luaran_file_tb4").value;
            luaranUrltb4OptionValue = document.getElementById("luaran_url_tb4").value;

            // Luaran Tambahan 5
            luaranFiletb5OptionValue = document.getElementById("luaran_file_tb5").value;
            luaranUrltb5OptionValue = document.getElementById("luaran_url_tb5").value;

            // Luaran Tambahan 6
            luaranFiletb6OptionValue = document.getElementById("luaran_file_tb6").value;
            luaranUrltb6OptionValue = document.getElementById("luaran_url_tb6").value;

            // Luaran Tambahan 7
            luaranFiletb7OptionValue = document.getElementById("luaran_file_tb7").value;
            luaranUrltb7OptionValue = document.getElementById("luaran_url_tb7").value;

            // Luaran Tambahan 8
            luaranFiletb8OptionValue = document.getElementById("luaran_file_tb8").value;
            luaranUrltb8OptionValue = document.getElementById("luaran_url_tb8").value;

            // Luaran Wajib 1
            if (luaranFilewb1OptionValue == fileSelect.value) {
                document.getElementById("luaran_file_select_wb1").style.display = "block";
            } else {
                document.getElementById("luaran_file_select_wb1").style.display = "none";
            }
            if (luaranUrlwb1OptionValue == fileSelect.value) {
                document.getElementById("luaran_url_select_wb1").style.display = "block";
            } else {
                document.getElementById("luaran_url_select_wb1").style.display = "none";
            }

            // Luaran Wajib 2
            if (luaranFilewb2OptionValue == fileSelect.value) {
                document.getElementById("luaran_file_select_wb2").style.display = "block";
            } else {
                document.getElementById("luaran_file_select_wb2").style.display = "none";
            }
            if (luaranUrlwb2OptionValue == fileSelect.value) {
                document.getElementById("luaran_url_select_wb2").style.display = "block";
            } else {
                document.getElementById("luaran_url_select_wb2").style.display = "none";
            }

            // Luaran Wajib 3
            if (luaranFilewb3OptionValue == fileSelect.value) {
                document.getElementById("luaran_file_select_wb3").style.display = "block";
            } else {
                document.getElementById("luaran_file_select_wb3").style.display = "none";
            }
            if (luaranUrlwb3OptionValue == fileSelect.value) {
                document.getElementById("luaran_url_select_wb3").style.display = "block";
            } else {
                document.getElementById("luaran_url_select_wb3").style.display = "none";
            }

            // Luaran Tambahan 1
            if (luaranFiletb1OptionValue == fileSelect.value) {
                document.getElementById("luaran_file_select_tb1").style.display = "block";
            } else {
                document.getElementById("luaran_file_select_tb1").style.display = "none";
            }
            if (luaranUrltb1OptionValue == fileSelect.value) {
                document.getElementById("luaran_url_select_tb1").style.display = "block";
            } else {
                document.getElementById("luaran_url_select_tb1").style.display = "none";
            }

            // Luaran Tambahan 2
            if (luaranFiletb2OptionValue == fileSelect.value) {
                document.getElementById("luaran_file_select_tb2").style.display = "block";
            } else {
                document.getElementById("luaran_file_select_tb2").style.display = "none";
            }
            if (luaranUrltb2OptionValue == fileSelect.value) {
                document.getElementById("luaran_url_select_tb2").style.display = "block";
            } else {
                document.getElementById("luaran_url_select_tb2").style.display = "none";
            }

            // Luaran Tambahan 3
            if (luaranFiletb3OptionValue == fileSelect.value) {
                document.getElementById("luaran_file_select_tb3").style.display = "block";
            } else {
                document.getElementById("luaran_file_select_tb3").style.display = "none";
            }
            if (luaranUrltb3OptionValue == fileSelect.value) {
                document.getElementById("luaran_url_select_tb3").style.display = "block";
            } else {
                document.getElementById("luaran_url_select_tb3").style.display = "none";
            }

            // Luaran Tambahan 4
            if (luaranFiletb4OptionValue == fileSelect.value) {
                document.getElementById("luaran_file_select_tb4").style.display = "block";
            } else {
                document.getElementById("luaran_file_select_tb4").style.display = "none";
            }
            if (luaranUrltb4OptionValue == fileSelect.value) {
                document.getElementById("luaran_url_select_tb4").style.display = "block";
            } else {
                document.getElementById("luaran_url_select_tb4").style.display = "none";
            }

            // Luaran Tambahan 5
            if (luaranFiletb5OptionValue == fileSelect.value) {
                document.getElementById("luaran_file_select_tb5").style.display = "block";
            } else {
                document.getElementById("luaran_file_select_tb5").style.display = "none";
            }
            if (luaranUrltb5OptionValue == fileSelect.value) {
                document.getElementById("luaran_url_select_tb5").style.display = "block";
            } else {
                document.getElementById("luaran_url_select_tb5").style.display = "none";
            }

            // Luaran Tambahan 6
            if (luaranFiletb6OptionValue == fileSelect.value) {
                document.getElementById("luaran_file_select_tb6").style.display = "block";
            } else {
                document.getElementById("luaran_file_select_tb6").style.display = "none";
            }
            if (luaranUrltb6OptionValue == fileSelect.value) {
                document.getElementById("luaran_url_select_tb6").style.display = "block";
            } else {
                document.getElementById("luaran_url_select_tb6").style.display = "none";
            }

            // Luaran Tambahan 7
            if (luaranFiletb7OptionValue == fileSelect.value) {
                document.getElementById("luaran_file_select_tb7").style.display = "block";
            } else {
                document.getElementById("luaran_file_select_tb7").style.display = "none";
            }
            if (luaranUrltb7OptionValue == fileSelect.value) {
                document.getElementById("luaran_url_select_tb7").style.display = "block";
            } else {
                document.getElementById("luaran_url_select_tb7").style.display = "none";
            }

            // Luaran Tambahan 8
            if (luaranFiletb8OptionValue == fileSelect.value) {
                document.getElementById("luaran_file_select_tb8").style.display = "block";
            } else {
                document.getElementById("luaran_file_select_tb8").style.display = "none";
            }
            if (luaranUrltb8OptionValue == fileSelect.value) {
                document.getElementById("luaran_url_select_tb8").style.display = "block";
            } else {
                document.getElementById("luaran_url_select_tb8").style.display = "none";
            }

        } else {
            // Luaran Wajib 1
            document.getElementById("luaran_file_select_wb1").style.display = "none";
            document.getElementById("luaran_url_select_wb1").style.display = "none";
        }
    };

    var uploadFieldLaporanKemajuan = document.getElementById("berkas_laporan_kemajuan");
    var uploadFieldLaporanAkhir = document.getElementById("berkas_laporan_akhir");
    var uploadFieldLaporanKeuangan = document.getElementById("berkas_laporan_keuangan");

    var uploadFieldLuaranwb1 = document.getElementById("wb1");
    var uploadFieldLuaranwb2 = document.getElementById("wb2");
    var uploadFieldLuaranwb3 = document.getElementById("wb3");
    var uploadFieldLuaranwb4 = document.getElementById("wb4");
    var uploadFieldLuarantb1 = document.getElementById("tb1");
    var uploadFieldLuarantb2 = document.getElementById("tb2");
    var uploadFieldLuarantb3 = document.getElementById("tb3");
    var uploadFieldLuarantb4 = document.getElementById("tb4");
    var uploadFieldLuarantb5 = document.getElementById("tb5");
    var uploadFieldLuarantb6 = document.getElementById("tb6");
    var uploadFieldLuarantb7 = document.getElementById("tb7");
    var uploadFieldLuarantb8 = document.getElementById("tb8");

    uploadFieldLaporanKemajuan.onchange = function() {
        if (this.files[0].size > 20971520) {
            Swal.fire({
                icon: 'error',
                title: 'Mohon Maaf Anda Melebihi Batas Unggah File',
                text: 'Batas Unggah File Laporan Sebesar 20MB',
            })
            this.value = "";
        }
    }
    uploadFieldLaporanAkhir.onchange = function() {
        if (this.files[0].size > 20971520) {
            Swal.fire({
                icon: 'error',
                title: 'Mohon Maaf Anda Melebihi Batas Unggah File',
                text: 'Batas Unggah File Laporan Sebesar 20MB',
            })
            this.value = "";
        }
    }
    uploadFieldLaporanKeuangan.onchange = function() {
        if (this.files[0].size > 20971520) {
            Swal.fire({
                icon: 'error',
                title: 'Mohon Maaf Anda Melebihi Batas Unggah File',
                text: 'Batas Unggah File Laporan Sebesar 20MB',
            })
            this.value = "";
        }
    }

    uploadFieldLuaranwb1.onchange = function() {
        if (this.files[0].size > 5242880) {
            Swal.fire({
                icon: 'error',
                title: 'Mohon Maaf Anda Melebihi Batas Unggah File',
                text: 'Batas Unggah File Laporan Sebesar 5MB',
            })
            this.value = "";
        }
    }
    uploadFieldLuaranwb2.onchange = function() {
        if (this.files[0].size > 5242880) {
            Swal.fire({
                icon: 'error',
                title: 'Mohon Maaf Anda Melebihi Batas Unggah File',
                text: 'Batas Unggah File Laporan Sebesar 5MB',
            })
            this.value = "";
        }
    }
    uploadFieldLuaranwb3.onchange = function() {
        if (this.files[0].size > 5242880) {
            Swal.fire({
                icon: 'error',
                title: 'Mohon Maaf Anda Melebihi Batas Unggah File',
                text: 'Batas Unggah File Laporan Sebesar 5MB',
            })
            this.value = "";
        }
    }
    uploadFieldLuarantb1.onchange = function() {
        if (this.files[0].size > 5242880) {
            Swal.fire({
                icon: 'error',
                title: 'Mohon Maaf Anda Melebihi Batas Unggah File',
                text: 'Batas Unggah File Laporan Sebesar 5MB',
            })
            this.value = "";
        }
    }
    uploadFieldLuarantb2.onchange = function() {
        if (this.files[0].size > 5242880) {
            Swal.fire({
                icon: 'error',
                title: 'Mohon Maaf Anda Melebihi Batas Unggah File',
                text: 'Batas Unggah File Laporan Sebesar 5MB',
            })
            this.value = "";
        }
    }
    uploadFieldLuarantb3.onchange = function() {
        if (this.files[0].size > 5242880) {
            Swal.fire({
                icon: 'error',
                title: 'Mohon Maaf Anda Melebihi Batas Unggah File',
                text: 'Batas Unggah File Laporan Sebesar 5MB',
            })
            this.value = "";
        }
    }
    uploadFieldLuarantb4.onchange = function() {
        if (this.files[0].size > 5242880) {
            Swal.fire({
                icon: 'error',
                title: 'Mohon Maaf Anda Melebihi Batas Unggah File',
                text: 'Batas Unggah File Laporan Sebesar 5MB',
            })
            this.value = "";
        }
    }
    uploadFieldLuarantb5.onchange = function() {
        if (this.files[0].size > 5242880) {
            Swal.fire({
                icon: 'error',
                title: 'Mohon Maaf Anda Melebihi Batas Unggah File',
                text: 'Batas Unggah File Laporan Sebesar 5MB',
            })
            this.value = "";
        }
    }
    uploadFieldLuarantb6.onchange = function() {
        if (this.files[0].size > 5242880) {
            Swal.fire({
                icon: 'error',
                title: 'Mohon Maaf Anda Melebihi Batas Unggah File',
                text: 'Batas Unggah File Laporan Sebesar 5MB',
            })
            this.value = "";
        }
    }
    uploadFieldLuarantb7.onchange = function() {
        if (this.files[0].size > 5242880) {
            Swal.fire({
                icon: 'error',
                title: 'Mohon Maaf Anda Melebihi Batas Unggah File',
                text: 'Batas Unggah File Laporan Sebesar 5MB',
            })
            this.value = "";
        }
    }
    uploadFieldLuarantb8.onchange = function() {
        if (this.files[0].size > 5242885) {
            Swal.fire({
                icon: 'error',
                title: 'Mohon Maaf Anda Melebihi Batas Unggah File',
                text: 'Batas Unggah File Laporan Sebesar 5MB',
            })
            this.value = "";
        }
    }
</script>