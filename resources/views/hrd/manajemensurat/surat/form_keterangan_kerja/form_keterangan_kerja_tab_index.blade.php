{{-- div form-tab --}}
<div id="form-tab" class="tab-pane fade in active">
  
    <form id="forum_keterangan_kerja">      

        <div class="row tamma-bg tamma-bg-form-top">
          <div class="col-md-12">

           

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>No Surat Keterangan Kerja</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                 
                  <input type="text" class="form-control input-sm" readonly="" name="kode" id="kode" value="{{$kode_surat}}">
                
                </div>
              </div>

               <div class="col-md-6 hidden-sm hidden-xs" style="height: 50px">
                  {{-- empty --}}
                </div>
               

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Nama Karyawan 1</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <select class="form-control input-sm select2" id="karyawan1" name="karyawan1">
                    <option value="">--Pilih Karyawan</option>
                    @foreach($pegawai as $index => $pegawai1)
                      <option value="{{$pegawai1->c_id}}">{{$pegawai1->c_nama}} - {{$pegawai1->c_posisi}}</option>
                    @endforeach
                  </select>
                  <input type="hidden" id="nama1" name="nama1">
                  <input type="hidden" id="posisi1" name="posisi1">
                  <input type="hidden" id="alamat1" name="alamat1">
                </div>
              </div>
               <div class="col-md-6 hidden-sm hidden-xs" style="height: 50px">
                  
                </div>
              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Nama Karyawan 2</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                  <select class="form-control input-sm select2" id="karyawan2" name="karyawan2">
                    <option>--Pilih Karyawan</option>
                    @foreach($pegawai as $index => $pegawai2)
                      <option value="{{$pegawai2->c_id}}">{{$pegawai2->c_nama}} - {{$pegawai2->c_posisi}}</option>
                    @endforeach
                  </select>
                  <input type="hidden" id="nama2" name="nama2">
                  <input type="hidden" id="jk2" name="jk2" value="">
                  <input type="hidden" id="ttl2" name="ttl2">
                  <input type="hidden" id="alamat2" name="alamat2">
                </div>
              </div>

               <div class="col-md-6 hidden-sm hidden-xs" style="height: 50px">
                  
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
                <label>Posisi sebagai</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group height25px">
                 
                  <input type="text" class="form-control input-sm" readonly="" id="posisi2" name="posisi2">
                
                </div>
              </div>


          </div>
        </div>

    </form>

        <div align="right" style="margin-top: 15px;">
          <button class="btn btn-primary btn-simpan" type="button">Simpan</button>
          <a href="{{route('manajemensurat')}}" class="btn btn-default">Kembali</a>
        </div>


      
</div>
<!-- /div form-tab 