<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog" style="width: 500px">
      
    <form id="myForm" onsubmit="return false">
      <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="background-color: #e77c38;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="color: white;">Form Rencana Produksi</h4>
          </div>

          <div class="modal-body">

            <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 15px;padding-top: 15px; ">
              <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
              <input type="hidden" name="pp_id">                      
              <input type="hidden" name="crud">                      

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Nama Item</label>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                  <input type="text" class="form-control input-sm" name="namaitem" id="namaitem">
                </div>
              </div>

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Tanggal</label>
              </div>

              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                  <input type="text" class="form-control input-sm datepicker2" readonly="" name="pp_date" value="{{ date('d-m-Y') }}">
                </div>
              </div>

              

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Jumlah Rencana Produksi</label>
              </div>

              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                 <input style="text-align: right;" type="number" class="form-control input-sm" name="pp_qty">
                </div>
              </div>

            </div>
            
          </div>
      
          <div class="modal-footer" style="border-top: none;">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan Data</button>
          </div>

           
        </div>

      </form>   
      
    </div>

</div>