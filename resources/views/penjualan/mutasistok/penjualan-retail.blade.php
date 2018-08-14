<div id="penjualan-retail" class="tab-pane fade">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-2 col-sm-3 col-xs-12">
                <label class="tebal">Tanggal</label>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <div class="input-daterange input-group">
                        <input id="tanggal" class="form-control input-sm datepicker1" name="tanggal" type="text">
                        <span class="input-group-addon">-</span>
                        <input id="tanggal" class="input-sm form-control datepicker2" name="tanggal" type="text"
                               value="{{ date('d-m-Y') }}">
                    </div>
                </div>
            </div>
            <div class=" col-md-3 col-sm-3 col-xs-12" align="center">
                <button class="btn btn-primary btn-sm btn-flat" type="button">
                    <strong>
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </strong>
                </button>
                <button class="btn btn-info btn-sm btn-flat" type="button">
                    <strong>
                        <i class="fa fa-undo" aria-hidden="true"></i>
                    </strong>
                </button>
            </div>
            <div class="table-responsive" style="margin-top: 50px;">
                <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0"
                       id="PenjualanRetail">
                    <thead>
                    <tr>
                        <th>Tanggal | Waktu</th>
                        <th>Kode Item</th>
                        <th>Nama Item</th>
                        <th>Milik Item</th>
                        <th>Ket Item</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <th>Sisa</th>
                        <th>Detail</th>
                        <th>Nota Reff</th>
                    </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
