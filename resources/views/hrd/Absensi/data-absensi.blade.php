    <div class="panel-body">
        <div class="container">
            <a href="javascript:void(0);" onclick="javascipt:window.open('{{url('/public/assets/berkas/absensi-produksi/contoh-excel-produksi.xlsx')}}');"><button class="btn btn-success">Download Contoh Excel</button></a>
            <a href="javascript:void(0);" onclick="javascipt:window.open('{{url('/public/assets/berkas/absensi-produksi/master-produksi.xlsx')}}');"><button class="btn btn-success">Download Master Produksi</button></a>
            <form
          style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;     margin-bottom: 16px;"
          action="{{url('/import/data-produksi')}}"
          class="form-horizontal"
          method="POST"
          enctype="multipart/form-data">
          {{csrf_field()}}
                <input type="file" class="form-control-file" name="file-produksi">
                <input type="submit" value="Upload" class="btn btn-primary">
            </form>
        </div>
    </div>
    <div class="col-md-2 col-sm-3 col-xs-12">
        <label class="tebal">Tanggal :</label>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
            <div class="input-daterange input-group">
                <input id="tanggal1" class="form-control input-sm datepicker1 "
                       name="tanggal" type="text">
                <span class="input-group-addon">-</span>
                <input id="tanggal2" class="input-sm form-control datepicker2"
                       name="tanggal" type="text" value="{{ date('d-m-Y') }}">
            </div>
        </div>
    </div>

    <div class="col-md-2 col-sm-3 col-xs-12" align="center">
        <button class="btn btn-primary btn-sm btn-flat autoCari" type="button"
                onclick="detTanggal()">
            <strong>
                <i class="fa fa-search" aria-hidden="true"></i>
            </strong>
        </button>
        <button class="btn btn-info btn-sm btn-flat refresh-data2" type="button"
                onclick="detTanggal()">
            <strong>
                <i class="fa fa-undo" aria-hidden="true"></i>
            </strong>
        </button>
    </div>

    <div class="col-md-4 col-sm-3 col-xs-12" align="left">
        <select name="tampilDet" id="tampilDet" onchange="detTanggal()" class="form-control input-sm">
          @foreach ($produksi as $rumah)
            <option value="{{$rumah->mp_id}}" class="form-control input-sm">{{$rumah->mp_name}}</option>
          @endforeach
        </select>
    </div>
    <div class="panel-body">
    <div class="table-responsive">
      <table id="detailAbsensi" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
        <thead>
          <tr>
            <th>No.</th>
            <th>Kode - Nama Pegawai</th>
            <th>Alpha</th>
            <th>Izin</th>
            <th>Sakit</th>
            <th>Cuti</th>
            <th>Hadir</th>
          </tr>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
    </div>
  </div>
