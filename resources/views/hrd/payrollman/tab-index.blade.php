<div id="index-tab" class="tab-pane fade in active">
  <div class="row tamma-bg tamma-bg-form-top">
    <div class="col-md-12 col-sm-12 col-xs-12">

      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
          <label style="font-weight: bold;font-size: 16px;">Pencarian Berdasarkan :</label>
        </div>
      </div>

      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="form-group" style="float: right;">
          <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_tambah_data"><i class="fa fa-plus"></i></button>
          <button class="btn btn-primary btn-sm" onclick="lihatPayrollByTgl()"><i class="fa fa-search"></i></button>
          <button class="btn btn-default btn-sm" onclick="refreshTabelIndex()"><i class="fa fa-refresh"></i></button>
        </div>
      </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">

      <div class="col-md-2 col-sm-2 col-xs-12">
        <label>Tanggal Awal</label>
      </div>

      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
          <input id="tgl_index1" class="form-control input-sm datepicker1" name="tgl_index1" type="text">
        </div>
      </div>

      <div class="col-md-2 col-sm-2 col-xs-12">
        <label>Sampai Tanggal</label>
      </div>

      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
          <input id="tgl_index2" class="form-control input-sm datepicker2" name="tgl_index2" type="text" value="{{ date('d-m-Y') }}">
        </div>
      </div>

      <div class="col-md-2 col-sm-2 col-xs-12">
        <label>Divisi</label>
      </div>

      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
          <select class="form-control input-sm" name="headDivisi" id="head_divisi" onchange="lihatPayrollByTgl()">
            <option value="semua"> Tampilkan Semua </option>

              @foreach($data as $val)
                <option value="{{$val->c_id}}">{{$val->c_divisi}}</option>
              @endforeach

           </select>
        </div>
      </div>

      <div class="col-md-2 col-sm-2 col-xs-12">
        <label>Status</label>
      </div>

      <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="form-group">
          <select class="form-control input-sm" name="headStatus" id="head_status" onchange="lihatPayrollByTgl()">
            <option value="ALL"> Tampilkan Semua </option>
            <option value="Y"> Sudah Dicetak </option>
            <option value="N"> Belum Dicetak </option>
          </select>
        </div>
      </div>

    </div>

  </div>
  <div class="table-responsive" style="margin-top: 15px;">
    <table class="table tabelan table-hover table-bordered data-table" width="100%" cellspacing="0" id="tbl-index">
      <thead>
          <tr>
            <th class="wd-10p">Code</th>
            <th class="wd-10p">Tanggal</th>
            <th class="wd-10p">Periode</th>
            <th class="wd-10p">NIP</th>
            <th class="wd-10p">Nama</th>
            <th class="wd-10p">Total Gaji</th>
            <th class="wd-10p">Tgl Cetak</th>
            <th style="text-align: center;">Aksi</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
    
    </table> 
  </div>                                       
</div><!-- /div alert-tab -->