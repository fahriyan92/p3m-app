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
                    <?php if (!empty($dt_proposal)): ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="inputJudul">Judul</label>
                                <input type="text" class="form-control" id="inputJudul" placeholder="Judul Penelitian"
                                    value="<?= $dt_proposal->judul; ?>" name="judulPenelitianDosenPNBP" disabled>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="">Nama Ketua</label>
                                    <input readonly class="form-control text-capitalize" type="text"
                                        value="<?= $dt_proposal->nama_ketua ?> - <?= $dt_proposal->nidn_ketua ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="biayadiusulkan">Biaya yang diusulkan</label>
                                <input type="text" class="form-control" id="biayadiusulkan"
                                    value="<?= rupiah($dt_proposal->biaya_usulan); ?>" placeholder="Rp.8.500.000,-"
                                    name="biayadiusulkan" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="tglmulai">Lama Penelitian (mulai)</label>
                                <input type="date" class="form-control" data-inputmask-inputformat="dd/mm/yyyy"
                                    id="tglmulai" placeholder="mulai" name="tglmulai"
                                    value="<?= $dt_proposal->mulai; ?>" disabled>
                            </div>
                        </div>
                        <div class="col-sm-1" style="text-align: center; margin-top:36px">
                            <span> - </span>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="tglakhir">(akhir)</label>
                                <input type="date" class="form-control" id="tglakhir"
                                    data-inputmask-inputformat="dd/mm/yyyy" placeholder="akhir" name="tglakhir"
                                    value="<?= $dt_proposal->akhir; ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="div-table w-100">
                            <div class="table">
                                <div class="tr">
                                    <div class="td">No</div>
                                    <div class="td" style="width: 30%;">Komponen Penilaian</div>
                                    <div class="td">Keterangan</div>
                                    <div class="td">File Laporan</div>
                                </div>
                                <div class="tr">
                                    <div class="td"></div>
                                    <div class="td font-weight-bold">Luaran Wajib</div>
                                </div>
                                <div class="tr">
                                    <div class="td">1</div>
                                    <div class="td">Artikel prosiding ber-ISBN</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#w_b1">
                                            Laporkan
                                        </button>
                                        <div class="modal fade" id="w_b1" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Artikel prosiding
                                                            ber-ISBN</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form
                                                        action="<?= empty($berkas) ? base_url("upload_berkas_pengabdian/up_wb1/$idproposal") : base_url("upload_berkas_pengabdian/edit_wb1/$idproposal") ?>"
                                                        method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" name="wb1">
                                                                <label class="custom-file-label" for="w_b1">Choose
                                                                    file</label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <input class="btn btn-primary" type="submit" name="upload"
                                                                value="Simpan" />
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->w_b1)) {
                                            echo '<button type="button" class="btn btn-danger">Tidak Ada Berkas</button>';
                                        } else {
                                            echo '<a href="' . base_url("assets/berkas/file_laporan/") . $berkas->w_b1 . '"><button type="button" class="btn btn-success">Unduh</button></a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="tr">
                                    <div class="td">2</div>
                                    <div class="td">Artikel pada media massa cetak/elektronik</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#w_b2">
                                            Laporkan
                                        </button>
                                        <div class="modal fade" id="w_b2" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Artikel pada
                                                            media massa cetak/elektronik</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form
                                                        action="<?= empty($berkas) ? base_url("upload_berkas_pengabdian/up_wb2/$idproposal") : base_url("upload_berkas_pengabdian/edit_wb2/$idproposal") ?>"
                                                        method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" name="wb2">
                                                                <label class="custom-file-label" for="w_b2">Choose
                                                                    file</label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <input class="btn btn-primary" type="submit" name="upload"
                                                                value="Simpan" />
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->w_b2)) {
                                            echo '<button type="button" class="btn btn-danger">Tidak Ada Berkas</button>';
                                        } else {
                                            echo '<a href="' . base_url("assets/berkas/file_laporan/") . $berkas->w_b2 . '"><button type="button" class="btn btn-success">Unduh</button></a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="tr">
                                    <div class="td">3</div>
                                    <div class="td">Video kegiatan</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#w_b3">
                                            Laporkan
                                        </button>
                                        <div class="modal fade" id="w_b3" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Video kegiatan
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form
                                                        action="<?= empty($berkas) ? base_url("upload_berkas_pengabdian/up_wb3/$idproposal") : base_url("upload_berkas_pengabdian/edit_wb3/$idproposal") ?>"
                                                        method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" name="wb3">
                                                                <label class="custom-file-label" for="w_b3">Choose
                                                                    file</label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <input class="btn btn-primary" type="submit" name="upload"
                                                                value="Simpan" />
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->w_b3)) {
                                            echo '<button type="button" class="btn btn-danger">Tidak Ada Berkas</button>';
                                        } else {
                                            echo '<a href="' . base_url("assets/berkas/file_laporan/") . $berkas->w_b3 . '"><button type="button" class="btn btn-success">Unduh</button></a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="tr">
                                    <div class="td">4</div>
                                    <div class="td">HKI (Hak Cipta)</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#w_b4">
                                            Laporkan
                                        </button>
                                        <div class="modal fade" id="w_b4" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">HKI (Hak Cipta)
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form
                                                        action="<?= empty($berkas) ? base_url("upload_berkas_pengabdian/up_wb4/$idproposal") : base_url("upload_berkas_pengabdian/edit_wb4/$idproposal") ?>"
                                                        method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" name="wb4">
                                                                <label class="custom-file-label" for="w_b2">Choose
                                                                    file</label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <input class="btn btn-primary" type="submit" name="upload"
                                                                value="Simpan" />
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->w_b4)) {
                                            echo '<button type="button" class="btn btn-danger">Tidak Ada Berkas</button>';
                                        } else {
                                            echo '<a href="' . base_url("assets/berkas/file_laporan/") . $berkas->w_b4 . '"><button type="button" class="btn btn-success">Unduh</button></a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="tr">
                                    <div class="td">5</div>
                                    <div class="td">Peningkatan Level Keberdayaan Mitra</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#w_b5">
                                            Laporkan
                                        </button>
                                        <div class="modal fade" id="w_b5" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Peningkatan Level
                                                            Keberdayaan Mitra</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form
                                                        action="<?= empty($berkas) ? base_url("upload_berkas_pengabdian/up_wb5/$idproposal") : base_url("upload_berkas_pengabdian/edit_wb5/$idproposal") ?>"
                                                        method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" name="wb5">
                                                                <label class="custom-file-label" for="w_b5">Choose
                                                                    file</label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <input class="btn btn-primary" type="submit" name="upload"
                                                                value="Simpan" />
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->w_b5)) {
                                            echo '<button type="button" class="btn btn-danger">Tidak Ada Berkas</button>';
                                        } else {
                                            echo '<a href="' . base_url("assets/berkas/file_laporan/") . $berkas->w_b5 . '"><button type="button" class="btn btn-success">Unduh</button></a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="tr">
                                    <div class="td"></div>
                                    <div class="td font-weight-bold">Luaran Tambahan</div>
                                </div>
                                <div class="tr">
                                    <div class="td">1</div>
                                    <div class="td">Artikel jurnal pengabdian masyarakat</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#t_b1">
                                            Laporkan
                                        </button>
                                        <div class="modal fade" id="t_b1" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Artikel jurnal
                                                            pengabdian masyarakat</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form
                                                        action="<?= empty($berkas) ? base_url("upload_berkas_pengabdian/up_tb1/$idproposal") : base_url("upload_berkas_pengabdian/edit_tb1/$idproposal") ?>"
                                                        method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" name="tb1">
                                                                <label class="custom-file-label" for="tb1">Choose
                                                                    file</label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <input class="btn btn-primary" type="submit" name="upload"
                                                                value="Simpan" />
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->t_b1)) {
                                            echo '<button type="button" class="btn btn-danger">Tidak Ada Berkas</button>';
                                        } else {
                                            echo '<a href="' . base_url("assets/berkas/file_laporan/") . $berkas->t_b1 . '"><button type="button" class="btn btn-success">Unduh</button></a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="tr">
                                    <div class="td">2</div>
                                    <div class="td">Buku ber ISBN</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#t_b2">
                                            Laporkan
                                        </button>
                                        <div class="modal fade" id="t_b2" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Buku ber ISBN</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form
                                                        action="<?= empty($berkas) ? base_url("upload_berkas_pengabdian/up_tb2/$idproposal") : base_url("upload_berkas_pengabdian/edit_tb2/$idproposal") ?>"
                                                        method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" name="tb2">
                                                                <label class="custom-file-label" for="tb2">Choose
                                                                    file</label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <input class="btn btn-primary" type="submit" name="upload"
                                                                value="Simpan" />
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->t_b2)) {
                                            echo '<button type="button" class="btn btn-danger">Tidak Ada Berkas</button>';
                                        } else {
                                            echo '<a href="' . base_url("assets/berkas/file_laporan/") . $berkas->t_b2 . '"><button type="button" class="btn btn-success">Unduh</button></a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="tr">
                                    <div class="td">3</div>
                                    <div class="td">Bahan ajar</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#t_b3">
                                            Laporkan
                                        </button>
                                        <div class="modal fade" id="t_b3" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Bahan ajar</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form
                                                        action="<?= empty($berkas) ? base_url("upload_berkas_pengabdian/up_tb3/$idproposal") : base_url("upload_berkas_pengabdian/edit_tb3/$idproposal") ?>"
                                                        method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" name="tb3">
                                                                <label class="custom-file-label" for="tb3">Choose
                                                                    file</label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <input class="btn btn-primary" type="submit" name="upload"
                                                                value="Simpan" />
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->t_b3)) {
                                            echo '<button type="button" class="btn btn-danger">Tidak Ada Berkas</button>';
                                        } else {
                                            echo '<a href="' . base_url("assets/berkas/file_laporan/") . $berkas->t_b3 . '"><button type="button" class="btn btn-success">Unduh</button></a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="tr">
                                    <div class="td">4</div>
                                    <div class="td">Metode atau sistem; Produk (Barang atau Jasa)</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#t_b4">
                                            Laporkan
                                        </button>
                                        <div class="modal fade" id="t_b4" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Metode atau sistem; Produk (Barang atau Jasa)</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form
                                                        action="<?= empty($berkas) ? base_url("upload_berkas_pengabdian/up_tb4/$idproposal") : base_url("upload_berkas_pengabdian/edit_tb4/$idproposal") ?>"
                                                        method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" name="tb4">
                                                                <label class="custom-file-label" for="tb4">Choose
                                                                    file</label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <input class="btn btn-primary" type="submit" name="upload"
                                                                value="Simpan" />
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->t_b4)) {
                                            echo '<button type="button" class="btn btn-danger">Tidak Ada Berkas</button>';
                                        } else {
                                            echo '<a href="' . base_url("assets/berkas/file_laporan/") . $berkas->t_b4 . '"><button type="button" class="btn btn-success">Unduh</button></a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="tr">
                                    <div class="td">5</div>
                                    <div class="td">Perbaikan tata nilai masyarakat (seni budaya, sosial, politik, keamanan, ketenteraman, pendidikan, kesehatan)</div>
                                    <div class="td">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#t_b5">
                                            Laporkan
                                        </button>
                                        <div class="modal fade" id="t_b5" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Perbaikan tata nilai masyarakat (seni budaya, sosial, politik, keamanan, ketenteraman, pendidikan, kesehatan)</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form
                                                        action="<?= empty($berkas) ? base_url("upload_berkas_pengabdian/up_tb5/$idproposal") : base_url("upload_berkas_pengabdian/edit_tb5/$idproposal") ?>"
                                                        method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" name="tb5">
                                                                <label class="custom-file-label" for="tb5">Choose
                                                                    file</label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <input class="btn btn-primary" type="submit" name="upload"
                                                                value="Simpan" />
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="td">
                                        <?php
                                        if (empty($berkas->t_b5)) {
                                            echo '<button type="button" class="btn btn-danger">Tidak Ada Berkas</button>';
                                        } else {
                                            echo '<a href="' . base_url("assets/berkas/file_laporan/") . $berkas->t_b5 . '"><button type="button" class="btn btn-success">Unduh</button></a>';
                                        }
                                        ?>
                                    </div>
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
<script>
    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>