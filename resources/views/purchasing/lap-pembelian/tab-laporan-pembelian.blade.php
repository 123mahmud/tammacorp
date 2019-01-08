<div id="supplier-tab" class="tab-pane fade">
  <div class="panel-body">
    <div class="row">

      <div class="col-md-2 col-sm-3 col-xs-12">
        <label class="tebal">Periode Laporan</label>
      </div>

      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
          <div class="input-daterange input-group">
            <input id="tanggal5" class="form-control input-sm datepicker5" name="iTanggal5" type="text">
            <span class="input-group-addon">-</span>
            <input id="tanggal6" class="input-sm form-control datepicker6" name="iTanggal6" type="text" value="{{ date('d-m-Y') }}">
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-3 col-xs-12" align="center">
        <button class="btn btn-primary btn-sm btn-flat autoCari" type="button" onclick="lapPemSupp()">
          <strong>
            <i class="fa fa-search" aria-hidden="true"></i>
          </strong>
        </button>
        <button class="btn btn-info btn-sm btn-flat refresh-data-harian" type="button">
          <strong>
            <i class="fa fa-undo" aria-hidden="true"></i>
          </strong>
        </button>
      </div>

      <div id="btn_print_namasupp" class="col-md-3 col-sm-3 col-xs-12" align="right">
      </div>

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
          <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tbl-pemsupplier">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Supplier</th>
                <th>Tanggal</th>
                <th>Nama Item</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Satuan</th>
                <th>Total Harga</th>
              </tr>
            </thead>

            <tbody>
            </tbody>
        </table> 
        </div>
      </div>
                
    </div>
  </div>
</div>