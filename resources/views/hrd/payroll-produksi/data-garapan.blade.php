    <div class="col-md-2 col-sm-12 col-xs-12">
        <label class="tebal">Rumah Produksi :</label>
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="form-group" align="pull-left">
            <select class="form-control input-sm" id="rumahGaji" name="c_rumah_produksi"
            style="width: 100%;" onclick="cariGaji()">
                @foreach ($produksi as $data)
                    <option class="form-control pemilik-gudang" value="{{ $data->mp_id }}">
                        - {{ $data->mp_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-2 col-sm-12 col-xs-12">
        <label class="tebal">Pilih Jenis :</label>
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="form-group" align="pull-left">
            <select class="form-control input-sm" id="pilihAbsensi" name="pilihAbsensi"
            style="width: 100%;" onchange="pilihAbsensi()">
                    <option class="form-control" value="GR">Garapan</option>
                    <option class="form-control" value="HR">Garapan - Harian</option>
            </select>
        </div>
    </div>

    <div class="col-md-2 col-sm-12 col-xs-12">
        <label class="tebal">Jabatan Pegawai :</label>
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="form-group" align="pull-left">
          <select class="form-control input-sm" id="jabatanGaji" onchange="cariGaji()">
          </select>
        </div>
    </div>

    <div class="col-md-2 col-sm-12 col-xs-12">
        <label class="tebal">Tanggal :</label>
    </div>
    <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="form-group" align="pull-left">
          <div class="input-daterange input-group">
             <input id="tanggal03" class="form-control input-sm datepicker1"
                     name="tanggal" type="text" value="">
             <span class="input-group-addon">-</span>
             <input id="tanggal04" class="input-sm form-control datepicker2"
                    name="tanggal" type="text" value="{{ date('d-m-Y') }}">
          </div>
        </div>
    </div>

    <div class="col-md-1 col-sm-12 col-xs-12" align="right">
      <button class="btn btn-primary btn-sm btn-flat autoCari" type="button"
      onclick="cariGaji()">
          <strong>
              <i class="fa fa-search" aria-hidden="true"></i>
          </strong>
      </button>
    </div>



    <div class="panel-body">
      <div class="table-responsive">
        <form id="formGarapan">
        <table class="table tabelan table-bordered table-hover" id="dataGaji"
               width="100%">
            <thead>
            <tr>
                <th>No.</th>
                <th>Kode</th>
                <th>NIK - Nama Pegawai</th>
                <th>Lihat Gaji</th>
            </tr>
            </thead>

            <tbody>

            </tbody>
        </table>
        </form>
      </div>
    </div>
