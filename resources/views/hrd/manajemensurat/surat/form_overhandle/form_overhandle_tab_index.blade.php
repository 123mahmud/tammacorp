<!-- /div form-tab -->
<div id="form-tab" class="tab-pane fade in active">
  
      
      <form id="forum_overhandle">
        <div class="row tamma-bg tamma-bg-form-top">
          <div class="col-md-12">

           

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>No Surat Serah Terima Tugas</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group height25px">
                 
                  <input type="text" class="form-control input-sm" readonly="" name="kode" id="kode" value="{{$code}}">
                
                </div>
              </div>

                {{-- <div class="col-md-6 hidden-sm hidden-xs" style="height: 50px">
                  
                </div> --}}

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Nama Karyawan 1</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <select class="form-control input-sm select2" name="karyawan1" id="karyawan1">
                    <option value="">--Pilih Karyawan</option>
                    @foreach($pegawai as $index => $karyawan1)
                      <option value="{{$karyawan1->c_id}}">{{$karyawan1->c_nama}} - {{$karyawan1->c_posisi}}</option>
                    @endforeach
                    <input type="hidden" name="nama1" id="nama1" value="">
                    <input type="hidden" name="alamat1" id="alamat1" value="">
                    <input type="hidden" name="nik1" id="nik1" value="">
                    <input type="hidden" name="ktp1" id="ktp1" value="">
                    <input type="hidden" name="posisi1" id="posisi1" value="">
                    
                  </select>
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Telah melakukan serah terima tugas sebagai</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group height25px">
                 
                  <input type="text" class="form-control input-sm" name="tugas" id="tugas">
                
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Nama Karyawan 2</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <select class="form-control input-sm select2" name="karyawan2" id="karyawan2">
                    <option value="">--Pilih Karyawan</option>
                    @foreach($pegawai as $index => $karyawan2)
                      <option value="{{$karyawan2->c_id}}">{{$karyawan2->c_nama}} - {{$karyawan2->c_posisi}}</option>
                    @endforeach
                    <input type="hidden" name="nama2" id="nama2" value="">
                    <input type="hidden" name="alamat2" id="alamat2" value="">
                    <input type="hidden" name="nik2" id="nik2" value="">
                    <input type="hidden" name="ktp2" id="ktp2" value="">
                    <input type="hidden" name="posisi2" id="posisi2" value="">
                  </select>
                </div>
              </div>

              <div class="col-md-3 col-sm-12 col-xs-12">
                <label>Dari Tanggal</label>
              </div>

              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                  <div class="input-group input-daterange">
                    <input type="text" class="form-control input-sm" id="tgl_awal" name="tgl_awal">
                    <span class="input-group-addon">-</span>
                    <input type="text" class="form-control input-sm" id="tgl_akhir" name="tgl_akhir">

                  </div>
                </div>
              </div>

              <div class="col-md-3 hidden-sm hidden-xs height45px">
                
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Di buat di</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group height25px">
                 
                  <input type="text" class="form-control input-sm" name="dibuat" id="dibuat">
                
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Tanggal</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group height25px">
                 
                  <input type="text" class="form-control input-sm datepicker" name="tanggal" id="tanggal" value="{{date('d-m-Y')}}">
                
                </div>
              </div>

          </div>
        </div>
      </form>

        <div align="right" style="margin-top: 15px;">
          <button class="btn btn-primary btn-simpan">Simpan</button>
          <a href="{{route('manajemensurat')}}" class="btn btn-default">Kembali</a>
        </div>

      
</div>
<!-- /div form-tab -->