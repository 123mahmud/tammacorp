<!-- /div form-tab -->
<div id="form-tab" class="tab-pane fade in active">
  
      
      <form id="forum_permintaan_asli">
        <div class="row tamma-bg tamma-bg-form-top">
          <div class="col-md-12">

           

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Departement</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group height25px">
                 
                  <input type="text" class="form-control input-sm" name="department" id="department">
                
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Tanggal Pengujian</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group height25px">
                 
                  <input type="text" class="form-control input-sm datepicker" name="tgl_pengujian" id="tgl_pengujian">
                
                </div>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Tanggal Masuk</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group height25px">
                 
                  <input type="text" class="form-control input-sm datepicker" name="tgl_masuk" id="tgl_masuk">
                
                </div>
              </div>


          </div>
        </div>

        <div class="table-responsive" style="margin-top: 15px;">
          <table class="table tabelan table-hover table-bordered table-striped" width="100%">
            <thead>
              <tr>
                <th width="1%">No</th>
                <th style="text-align: center;" colspan="2">PERSYARATAN</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td width="30%">Posisi</td>
                <td>
                  <select class="select2" id="posisi" name="posisi">
                    <option value="">--Pilih Posisi--</option>  
                    @for($i=0;$i<count($daita);$i++)

                      <option value="{{$daita[$i]->c_posisi}}">{{$daita[$i]->c_posisi}}</option>

                    @endfor

                  </select>
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td>Jumlah yang dibutuhkan</td>
                <td><input type="number" min="0" class="form-control input-sm" name="jumlah_butuh" id="jumlah_butuh"></td>
              </tr>
              <tr>
                <td>3</td>
                <td>Jumlah karyawan sekarang</td>
                <td><input type="number" min="0" class="form-control input-sm" name="jumlah_karyawan" id="jumlah_karyawan"></td>
              </tr>
              <tr>
                <td>4</td>
                <td>Untuk penambahan/penggantian</td>
                <td><input type="number" min="0" class="form-control input-sm" name="penambahan" id="penambahan"></td>
              </tr>
              <tr>
                <td>5</td>
                <td>Alasan</td>
                <td><input type="text" class="form-control input-sm" name="alasan" id="alasan"></td>
              </tr>
              <tr>
                <td>6</td>
                <td>Usia</td>
                <td><input type="number" min="1" class="form-control input-sm" name="usia" id="usia"></td>
              </tr>
              <tr>
                <td>7</td>
                <td>Jenis Kelamin</td>
                <td>
                  <select class="form-control input-sm" name="jk" id="jk">
                    <option value="l">Laki-laki</option>
                    <option value="p">Perempuan</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td>8</td>
                <td>Pendidikan</td>
                <td>
                  <select class="form-control input-sm" name="pendidikan" id="pendidikan">
                    <option value="">--Pilih Pendidikan--</option>

                      
                        <option value="SD">SD</option>

                      
                        <option value="SMP">SMP</option>

                      
                        <option value="SMA">SMA</option>

                      
                        <option value="SMK">SMK</option>

                      
                        <option value="D1">D1</option>

                      
                        <option value="D3">D3</option>

                      
                        <option value="S1">S1</option>

                      
                        <option value="S2">S2</option>

                      
                        <option value="S3">S3</option>

                      
                   </select>
                </td>
              </tr>
              <tr>
                <td>9</td>
                <td>Pengalaman</td>
                <td><input type="text" class="form-control input-sm" name="pengalaman" id="pengalaman"></td>
              </tr>
              <tr>
                <td>10</td>
                <td>Keahlian Khusus</td>
                <td><input type="text" class="form-control input-sm" name="keahlian" id="keahlian"></td>
              </tr>
              <tr>
                <td>11</td>
                <td>Gaji</td>
                <td><input type="text" class="form-control input-sm hanya_angka pull-right" name="gaji" id="gaji"></td>
              </tr>
              <tr>
                <td>12</td>
                <td>Keterangan</td>
                <td><input type="text" class="form-control input-sm" name="keterangan" id="keterangan"></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div align="right" style="margin-top: 15px;">
          <button type="button" class="btn btn-primary btn-simpan">Simpan</button>
          <a href="{{route('manajemensurat')}}" class="btn btn-default">Kembali</a>
        </div>
      </form>
      
</div>
<!-- /div form-tab -->