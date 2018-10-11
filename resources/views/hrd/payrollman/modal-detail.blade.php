<div class="modal fade" id="modal_detail_data" role="dialog">
  <div class="modal-dialog" style="width: 70%;margin: auto;">
    
    <form method="post" id="form-detail" name="formDetail">
      {{ csrf_field() }}
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Detail Data Payroll Manajemen</h4>
        </div>

        <div class="modal-body">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-bottom: 10px;margin-bottom: 15px;">
            
            <div class="col-md-7 col-sm-7 col-xs-12">
              <label class="tebal">Tanggal : </label>
              <span id="d_tanggal">
            </div>

            <div class="col-md-5 col-sm-5 col-xs-12">
              <label class="tebal">Periode : </label>
              <span id="periode">
            </div>

            <div class="col-md-7 col-sm-7 col-xs-12">
              <label class="tebal">Divisi : </label>
              <span id="d_divisi">
            </div>

            <div class="col-md-5 col-sm-5 col-xs-12">
              <label class="tebal">Jabatan : </label>
              <span id="d_jabatan">
            </div>

            <div class="col-md-7 col-sm-7 col-xs-12">
              <label class="tebal">Pegawai : </label>
              <span id="d_pegawai">
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12" style="padding-top: 10px;padding-bottom: 10px;">
            </div>

            <div class="table-responsive">
              <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tabel-detail">
                <thead>
                  <tr>
                    <th class="wd-10p" style="width: 10%">No</th>
                    <th class="wd-10p" style="width: 70%">Keterangan</th>
                    <th class="wd-10p" style="width: 20%">Nilai</th>
                  </tr>
                </thead>
                <tbody id="d_appending"></tbody>              
              </table>
            </div>
                        
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