    <div class="col-md-2 col-sm-3 col-xs-12">
        <label class="tebal">Tanggal Belanja</label>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
            <div class="input-daterange input-group">
                <input id="tanggal5" class="form-control input-sm datepicker1"
                       name="tanggal"
                       type="text" {{-- value="{{ date('d-m-Y') }} --}}">
                <span class="input-group-addon">-</span>
                <input id="tanggal6" class="input-sm form-control datepicker2"
                       name="tanggal" type="text" value="{{ date('d-m-Y') }}">
            </div>
        </div>
    </div>


    <div class="col-md-3 col-sm-3 col-xs-12" align="center">
        <button class="btn btn-primary btn-sm btn-flat autoCari" type="button"
                onclick="cariTanggalPagu()">
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

    <div class="table-responsive">
        <table class="table tabelan table-bordered table-hover dt-responsive" id="tableKonfirmPagu" style="width: 100%;">
            <thead>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nota</th>
                <th>Customer</th>
                <th>Total Belanja</th>
                <th>Status</th>
                <th>Aksi</th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>