<div class="modal fade" id="test_interview" role="dialog">
  <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Test Interview</h4>
        </div>

        <div class="modal-body">
          <form method="POST" id="form-interview" name="formInterview">
          {{ csrf_field() }}
            <div class="row">

              <input type="hidden" class="form-control" name="i_pelamarid" id="i_pelamarid">
              <input type="hidden" class="form-control" name="i_pjadwal_id" id="i_pjadwal_id">
              <div class="col-md-4 col-sm-4 col-xs-12">
                <label>Tanggal Interview</label>
              </div>

              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control input-sm datepicker2" readonly="" style="cursor: pointer;" name="i_tgl" id="i_tgl">
                </div>
              </div>

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label>Jam</label>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control input-sm timepicker" name="i_jam" id="i_jam">
                </div>
              </div>

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label>Lokasi</label>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">
                  <input type="text" class="form-control input-sm" name="i_lokasi" id="i_lokasi">
                </div>
              </div>

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label title="Person In Charge, adalah istilah yg digunakan untuk menunjukkan siapa orang yg bertangung jawab menangani hal tertentu.">PIC</label>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">
                  <input type="text" id="i_pic" class="form-control ui-autocomplete-input input-sm" autocomplete="off" name="i_pic">
                  <input type="hidden" class="form-control input-sm" name="i_pic_id" id="i_pic_id">
                </div>
              </div>

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label title="Review Interview.">Review Interview</label>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">
                  <textarea name="i_review1" id="i_review1" maxlength="300" cols="30" rows="4" class="form-control" placeholder="Review Interview Peserta (Maks : 300 Karakter)"></textarea>
                </div>
              </div>
            </div>
          </form>
        </div>
    
        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-info" onclick="procJadwalInterview()">Submit</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
      <!-- /Modal content-->
  </div>

</div>