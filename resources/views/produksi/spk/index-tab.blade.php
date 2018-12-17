<div id="index-tab" class="tab-pane fade in active">
    <div class="row" style="margin-top: -5px;">
        <div class="panel-body">

            <div class="col-md-2 col-sm-3 col-xs-12">
                <label class="tebal">Tanggal SPK</label>
            </div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <div class="input-daterange input-group">
                        <input id="tanggal1" class="form-control input-sm datepicker1" name="tanggal" type="text">
                        <span class="input-group-addon">-</span>
                        <input id="tanggal2" class="input-sm form-control datepicker2" name="tanggal" type="text"
                               value="{{ date('d-m-Y') }}">
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                <button class="btn btn-primary btn-sm btn-flat autoCari" type="button" onclick="cariTanggal()">
                    <strong>
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </strong>
                </button>
                <button class="btn btn-info btn-sm btn-flat" type="button" onclick="refreshTabel()">
                    <strong>
                        <i class="fa fa-undo" aria-hidden="true"></i>
                    </strong>
                </button>
            </div>

            <div class="table-responsive" style="padding-top: 15px;">
                <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data1">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th width="10%">Tanggal</th>
                        <th width="30%">No Spk</th>
                        <th>Item</th>
                        <th>Jumlah</th>
                        <th>Jumlah Produksi</th>
                        <th>Status</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>