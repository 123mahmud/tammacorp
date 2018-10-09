<div class="modal fade" id="modal_detail_datascore" role="dialog">
  <div class="modal-dialog" style="width: 70%;margin: auto;">
    
    <form method="post" id="form-detail-score" name="formDetailScore">
      {{ csrf_field() }}
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Detail Data Scoreboard</h4>
        </div>

        <div class="modal-body">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Nama Pegawai</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group divjenis">
                <input type="text" name="ds_pegawai" id="ds_pegawai" class="form-control input-sm" readonly>
                <input type="hidden" name="ds_idpegawai" id="ds_idpegawai" class="form-control input-sm" readonly>
                <input type="hidden" name="ds_old" id="ds_old" class="form-control input-sm" readonly>
              </div>  
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Tanggal</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <input id="ds_tgl_kpi" class="form-control input-sm datepicker2 " name="dTglKpi" type="text" disabled>
              </div>  
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Divisi</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Jabatan</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="text" name="ds_divisi" id="ds_divisi" class="form-control input-sm" readonly>
                <input type="hidden" name="ds_iddivisi" id="ds_iddivisi" class="form-control input-sm" readonly>
              </div>  
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="text" name="ds_jabatan" id="ds_jabatan" class="form-control input-sm" readonly>
                <input type="hidden" name="ds_idjabatan" id="ds_idjabatan" class="form-control input-sm" readonly>
              </div>  
            </div>

            <div id="ds_appending"></div> {{-- appending --}}
                        
          </div>

        </div>
    
        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /Modal content-->
    </form>   
    <!-- /Form-->

  </div>

  </div>
</div>