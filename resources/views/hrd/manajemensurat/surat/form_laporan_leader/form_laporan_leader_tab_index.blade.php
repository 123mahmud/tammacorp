<!-- /div form-tab -->
<div id="form-tab" class="tab-pane fade in active">
  
      
        <form id="forum_laporan_leader">

          <div class="row tamma-bg tamma-bg-form-top">
            <div class="col-md-12">


                <div class="col-md-3 col-sm-6 col-xs-12">
                  <label>PIC</label>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <select class="select2" name="pic" id="pic">
                      <option value="">--Pilih PIC--</option>
                      @foreach($pic as $index => $picx)
                        <option value="{{$picx->c_id}}">{{$picx->c_nama}} - {{$picx->c_posisi}}</option>
                      @endforeach
                      <input type="hidden" name="nama" id="nama">
                    </select>
                  </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                  <label>Hari</label>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <input type="text" class="form-control input-sm datepicker" name="hari" id="hari">
                  </div>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                  <label>Divisi</label>
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                  <div class="form-group">
                    <input type="text" class="form-control input-sm" readonly="" name="divisi" id="divisi">
                  </div>
                </div>

                
               
            </div>
          </div>

          <div class="table-responsive" style="margin-top: 15px;">
            <table width="100%" class="table tabelan table-bordered table-hover table-striped" id="tabel_aktifitas">
              <thead>
                <tr>
                  <th width="1%"></th>
                  <th>Aktivitas</th>
                  <th>Keterangan</th>
                  <th width="5%"></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="vmiddle">#</td>
                  <td><textarea type="text" class="form-control" name="aktifitas[]" rows="3"></textarea></td>
                  <td><textarea type="text" class="form-control" name="keterangan[]" rows="3"></textarea></td>
                  <td class="vmiddle">
                    <button class="btn btn-primary btn-sm tambah" type="button"><i class="fa fa-plus"></i></button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

        </form>
        <div align="right" style="margin-top: 15px;">
          <button class="btn btn-primary btn-simpan" type="button">Simpan</button>
          <a href="{{route('manajemensurat')}}" class="btn btn-default">Kembali</a>
        </div>

      
</div>
<!-- /div form-tab -->