<div id="index-tab" class="tab-pane fade in active">
  <div class="row" style="margin-top:-15px;">
    @if ($message = Session::has('sukses'))
      <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Sukses!</strong> {{ Session::get('sukses') }}
      </div>
    @elseif($message = Session::has('gagal'))
      <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Gagal!</strong> {{ Session::get('gagal') }}
      </div>
    @endif
    <div align="left" class="col-md-6 col-sm-6 col-xs-6" style="margin-bottom:10px;">
      <button class="btn btn-box-tool btn-sm btn-flat" type="button" id="btn_refresh_index" onclick="refresh()">
        <i class="fa fa-undo" aria-hidden="true">&nbsp;</i> Refresh
      </button>
    </div>

    <div align="right" class="col-md-6 col-sm-6 col-xs-6" style="margin-bottom:10px;">
      <a href="{{ url('master/databrgsup/tambah-barang') }}">
        <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
          <i class="fa fa-plus" aria-hidden="true">
          &nbsp;
          </i>Tambah Data
        </button>
      </a>
    </div>
   
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="table-responsive">
        <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tbl-index">
          <thead>
            <tr>
              <th class="wd-15p" width="5%">NO</th>
              <th class="wd-15p" width="30%">Nama Barang</th>
              <th class="wd-15p" width="30%">Kode Barang</th>
              <th class="wd-15p" width="15%">Qty Supplier</th>
              <th class="wd-15p" width="15%">Aksi</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table> 
      </div>                                       
    </div>
  </div>
</div>