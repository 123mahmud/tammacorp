<div class="modal fade" id="modal_edit_data" role="dialog">
  <div class="modal-dialog" style="width: 70%;margin: auto;">
    
    <form method="post" id="form-edit-kpi" name="formEditKpi">
      {{ csrf_field() }}
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Konfirmasi Data KPI</h4>
        </div>

        <div class="modal-body">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-bottom: 10px;margin-bottom: 15px;">

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Tanggal</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Divisi</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <input id="e_tgl_kpix" class="form-control input-sm datepicker2" name="eTglKpix" type="text">
              </div>  
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group">
                <input type="text" name="e_divisi" id="e_divisi" class="form-control input-sm" readonly>
                <input type="hidden" name="e_iddivisi" id="e_iddivisi" class="form-control input-sm" readonly>
                <input type="hidden" name="e_old" id="e_old" class="form-control input-sm" readonly>
              </div>  
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Jabatan</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <label class="tebal">Pegawai</label>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group divSelectJabatan">
                <input type="text" name="e_jabatan" id="e_jabatan" class="form-control input-sm" readonly>
                <input type="hidden" name="e_idjabatan" id="e_idjabatan" class="form-control input-sm" readonly>
              </div>  
            </div>

            <div class="col-md-6 col-sm-6 col-xs-6">
              <div class="form-group divSelectJabatan">
                <input type="text" name="e_pegawai" id="e_pegawai" class="form-control input-sm" readonly>
                <input type="hidden" name="e_idpegawai" id="e_idpegawai" class="form-control input-sm" readonly>
              </div>  
            </div>

            <div id="e_appending"></div> {{-- appending --}}        
          </div>

        </div>
    
        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-info" onclick="updateKpix()" id="btn_update">Update</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /Modal content-->
    </form>   
    <!-- /Form-->

  </div>

  </div>
</div>