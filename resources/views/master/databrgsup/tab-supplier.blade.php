<div id="supplier-tab" class="tab-pane fade">
  <div class="row" style="margin-top:-15px;">
    <div align="left" class="col-md-6 col-sm-6 col-xs-6" style="margin-bottom:10px;">
      <button class="btn btn-box-tool btn-sm btn-flat" type="button" id="btn_refresh_index" onclick="refresh2()">
        <i class="fa fa-undo" aria-hidden="true">&nbsp;</i> Refresh
      </button>
    </div>

    <div align="right" class="col-md-6 col-sm-6 col-xs-6" style="margin-bottom:10px;">
      <a href="{{ url('master/databrgsup/tambah-supplier') }}">
        <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
          <i class="fa fa-plus" aria-hidden="true">
          &nbsp;
          </i>Tambah Data
        </button>
      </a>
    </div>
   
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="table-responsive">
        <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tbl-supplier">
          <thead>
            <tr>
              <th class="wd-15p" width="5%">NO</th>
              <th class="wd-15p" width="30%">Nama Supplier</th>
              <th class="wd-15p" width="30%">Alamat</th>
              <th class="wd-15p" width="15%">Qty Barang</th>
              <th class="wd-15p" width="15%">Aksi</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table> 
      </div>                                       
    </div>
  </div>
</div>