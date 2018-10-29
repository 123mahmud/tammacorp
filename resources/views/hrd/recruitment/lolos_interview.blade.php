<div class="modal fade" id="test_presentasi" role="dialog">
  <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Jadwal Presentasi</h4>
        </div>

        <div class="modal-body">
          <form method="POST" id="form-presentasi" name="formPresentasi">
          {{ csrf_field() }}
            <div class="row">

              <input type="hidden" class="form-control" name="p_pelamarid" id="p_pelamarid">
              <input type="hidden" class="form-control" name="p_pjadwal_id" id="p_pjadwal_id">
              <div class="col-md-4 col-sm-4 col-xs-12">
                <label>Tanggal Presentasi</label>
              </div>

              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control input-sm datepicker2" readonly="" style="cursor: pointer;" name="p_tgl" id="p_tgl">
                </div>
              </div>

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label>Jam</label>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control input-sm timepicker" name="p_jam" id="p_jam">
                </div>
              </div>

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label>Lokasi</label>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control input-sm" name="p_lokasi" id="p_lokasi">
                </div>
              </div>

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label title="Person In Charge, adalah istilah yg digunakan untuk menunjukkan siapa orang yg bertangung jawab menangani hal tertentu.">PIC</label>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">
                  <input type="text" id="p_pic" class="form-control ui-autocomplete-input input-sm" autocomplete="off" name="p_pic">
                  <input type="hidden" class="form-control input-sm" name="p_pic_id" id="p_pic_id">
                </div>
              </div>

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label title="Review Presentasi.">Review Presentasi</label>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">
                  <textarea name="p_review1" id="p_review1" maxlength="300" cols="30" rows="4" class="form-control" placeholder="Review Presentasi Peserta (Maks : 300 Karakter)"></textarea>
                </div>
              </div>

            </div>
          </form>
        </div>
    
        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-info" onclick="procJadwalPresentasi()">Submit</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /Modal content-->
  </div>

</div>