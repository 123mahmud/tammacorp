<!-- /div form-tab -->
<div id="form-tab" class="tab-pane fade in active">
  <form method="POST" action="{{ url('hrd/manajemensurat/simpan-naikjabatan') }}" id="form_naik_jabatan" enctype="multipart/form-data">
    {{ csrf_field() }}
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
            <input type="text" class="form-control input-sm" name="divisi" readonly>
            <input type="hidden" class="form-control input-sm" name="iddivisi">
          </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <label>Tanggal mulai kerja</label>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="form-group">
            <input class="form-control input-sm" name="tgl_awal_masuk" type="text" readonly>
          </div>
        </div>
        
        <!-- <div class="col-md-3 col-sm-6 col-xs-12">
          <label>Kenaikan</label>
        </div>
        
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="form-group">
            <label><input type="radio" class="form-control" value="gaji" name="kenaikan"> Gaji</label><br>
            <label><input type="radio" class="form-control" value="tingkat" name="kenaikan"> Tingkat/Grade</label>
          </div>
        </div> -->
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
              <input type="text" class="form-control input-sm" readonly="" name="level">
              <input type="hidden" class="form-control input-sm" name="idlevel">
            </td>
          </tr>
          <tr>
            <td>Gaji Pokok</td>
            <td><input type="text" class="form-control input-sm" name="gaji_now" readonly></td>
            <td><input type="text" class="form-control input-sm" name="gaji" readonly></td>
          </tr>
          <tr>
            <td>Efektif per Tanggal</td>
            <td>
              <input class="form-control input-sm" name="tanggal_now" type="text" readonly>
            </td>
            <td>
              <input type="text" class="form-control input-sm datepicker1" name="tanggal">
            </td>
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
          <textarea class="form-control" cols="3" name="alasan"></textarea>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        <label>Diusulkan Oleh</label>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="form-group">
          <select class="form-control select2" name="rekomendasi"></select>
        </div>
      </div>

      <div class="col-md-2 col-sm-6 col-xs-12">
          <label>Dari Divisi | Jabatan</label>
      </div>
      <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
          <input type="text" class="form-control input-sm" name="divisi_rekom" readonly>
          <input type="hidden" class="form-control input-sm" name="iddivisi_rekom">
          <input type="hidden" class="form-control input-sm" name="idjabatan_rekom">
        </div>
      </div>
    </div>

    <div align="right" style="margin-top: 15px;">
      <input type="submit" class="btn btn-primary" value="Simpan" />
      <a href="{{route('manajemensurat')}}" class="btn btn-default">Kembali</a>
    </div>
  </form>

</div>
<!-- /div form-tab -->