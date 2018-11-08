<div id="index-tab" class="tab-pane fade in active">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">

      <div class="col-md-2 col-sm-3 col-xs-12">
        <label class="tebal">Periode Laporan</label>
      </div>

      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
          <div class="input-daterange input-group">
            <input id="tanggal1" class="form-control input-sm datepicker1" name="iTanggal1" type="text">
            <span class="input-group-addon">-</span>
            <input id="tanggal2" class="input-sm form-control datepicker2" name="iTanggal2" type="text" value="{{ date('d-m-Y') }}">
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-3 col-xs-12" align="center">
        <button class="btn btn-primary btn-sm btn-flat autoCari" type="button" onclick="laporanByTanggal()">
          <strong>
            <i class="fa fa-search" aria-hidden="true"></i>
          </strong>
        </button>
        <button class="btn btn-info btn-sm btn-flat refresh-data-history" type="button" onclick="refreshTabel()">
          <strong>
            <i class="fa fa-undo" aria-hidden="true"></i>
          </strong>
        </button>
      </div>
      
      <div id="btn_print" class="col-md-3 col-sm-3 col-xs-12" align="right">
      </div>
      <!-- <div id="btn_print" class="col-md-3 col-sm-3 col-xs-12" align="right">
        <a class="btn btn-primary" href="{{ url('purchasing/lap-pembelian/print-lap-beli') }}" target="_blank">
          <i class="fa fa-print"></i>&nbsp;Print
        </a>
      </div> -->

      <div class="table-responsive">
        <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode</th>
              <th>Staff</th>
              <th>Supplier</th>
              <th>Tanggal</th>
              <th>Harga Nett</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table> 
      </div> 
    </div>
  </div>
</div>