<div class="modal fade" id="modal_tambah_data" role="dialog">
  <div class="modal-dialog" style="width: 70%;margin: auto;">
    
    <form method="post" id="form-input-payroll" name="formInputPayroll">
      {{ csrf_field() }}
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Input Data Payroll Manajemen</h4>
        </div>

        <div class="modal-body">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-bottom: 10px;margin-bottom: 15px;">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Periode</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group" style="display: ">
                <div class="input-daterange input-group">
                  <input id="i_tgl1" data-provide="datepicker" class="form-control input-sm datepicker1" name="i_tgl1" type="text">
                  <span class="input-group-addon">-</span>
                  <input id="i_tgl2" data-provide="datepicker" class="input-sm form-control datepicker2" name="i_tgl2" type="text" value="{{ date('d-m-Y') }}">
                </div>
              </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Divisi</label>
            </div>

             <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group divDivisi">
                  <select class="form-control input-sm select2 i_divisi" id="i_divisi" name="i_divisi" style="width: 100% !important;">
                  </select>
                </div>  
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Jabatan</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group divJabtan">
                  <select class="form-control input-sm select2 i_jabatan" id="i_jabatan" name="i_jabatan" style="width: 100% !important;" disabled="">
                  </select>
                </div>  
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Nama Pegawai</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group divPegawai">
                  <select class="form-control input-sm select2 i_pegawai" id="i_pegawai" name="i_pegawai" style="width: 100% !important;" disabled="">
                  </select>
                </div>  
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <button type="button" class="btn btn-primary col-md-12 col-sm-12 col-xs-12" onclick="setFieldModal()" id="btn_proses" disabled>Proses Data</button>
            </div>
                        
          </div>

          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-bottom: 10px;margin-bottom: 15px;">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Gaji Pokok</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control input-sm currency" name="i_gapok" id="i_gapok" readonly>
              </div>  
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Total Tunjangan</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control input-sm currency" name="i_tunjangan" id="i_tunjangan" readonly>
              </div>  
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Total Potongan</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control input-sm currency" name="i_potongan" id="i_potongan" readonly>
              </div>  
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Total Gaji</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <input type="text" class="form-control input-sm currency" name="i_totgaji" id="i_totgaji" readonly>
              </div>  
            </div>

            <div id="appending-modal"></div>
            
          </div>

        </div>
    
        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-info" onclick="submitPayrollMan()" id="btn_simpan" disabled>Submit</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /Modal content-->
    </form>   
    <!-- /Form-->

  </div>

  </div>
</div>