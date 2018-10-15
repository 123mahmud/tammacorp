<!-- /div form-tab -->
<div id="form-tab" class="tab-pane fade in active">

  <div class="row tamma-bg tamma-bg-form-top">
    <div class="col-md-12">

        <div class="col-md-3 col-sm-6 col-xs-12">
          <label>Nama</label>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="form-group">
           
            <select class="form-control input-sm select2" name="pegawai"></select>
          
          </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <label>Departement</label>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="form-group">
            <input type="text" class="form-control input-sm" name="divisi">
            <input type="hidden" class="form-control input-sm" name="iddivisi">
          </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <label>Tanggal mulai kerja</label>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="form-group">
            <input class="form-control input-sm datepicker1" name="tgl_awal_masuk" type="text">
          </div>
        </div>
        
        <div class="col-md-3 col-sm-6 col-xs-12">
          <label>Kenaikan</label>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="form-group">
            <label><input type="radio" class="form-control" value="gaji" name="kenaikan"> Gaji</label><br>
            <label><input type="radio" class="form-control" value="tingkat" name="kenaikan"> Tingkat/Grade</label>
          </div>
        </div>
        
        

    </div>
  </div>

  <div class="table-responsive" style="margin-top: 15px;">
    <table class="table tabelan table-hover table-bordered table-striped">
      <thead>
        <tr>
          <th></th>
          <th>Kondisi Saat ini</th>
          <th>Diusulkan</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Jabatan</td>
          <td>
            <input type="text" class="form-control input-sm" name="jabatan_now" readonly>
            <input type="hidden" class="form-control input-sm" name="idjabatan_now">
          </td>
          <td>
            <select class="form-control input-sm select2" name="jabatan"></select>
          </td>
        </tr>
        <tr>
          <td>Grade / Tingkat</td>
          <td>
            <input type="text" class="form-control input-sm" readonly="" name="level_now">
            <input type="hidden" class="form-control input-sm" name="idlevel_now">
          </td>
          <td>
            <input type="text" class="form-control input-sm" readonly="" name="">
          </td>
        </tr>
        <tr>
          <td>Gaji Pokok</td>
          <td><input type="text" class="form-control input-sm" name="gaji_now" readonly></td>
          <td><input type="text" class="form-control input-sm" name=""></td>
        </tr>
        <tr>
          <td>Efektif per Tanggal</td>
          <td>
            <input class="form-control input-sm datepicker1" name="tanggal_now" type="text">
          </td>
          <td><input type="text" class="form-control input-sm datepicker1" name=""></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="row tamma-bg tamma-bg-form-mid">
    
    <div class="col-md-12">
      <label>Alasan Kenaikan</label>
    </div>

    <div class="col-md-12">
      <div class="form-group">
        <textarea class="form-control" cols="3"></textarea>
      </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <label>Diusulkan Oleh</label>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="form-group">
        <select class="form-control select2">
          <option>--Pilih--</option>
        </select>
      </div>
    </div>
  </div>

  <div align="right" style="margin-top: 15px;">
    <button class="btn btn-primary">Simpan</button>
    <a href="{{route('manajemensurat')}}" class="btn btn-default">Kembali</a>
  </div>

</div>
<!-- /div form-tab -->