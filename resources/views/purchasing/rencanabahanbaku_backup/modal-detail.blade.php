<!-- detail order-->
<div class="modal fade" id="detail-data" role="dialog">
  <div class="modal-dialog modal-lg"">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Detail SPK</h4>
        </div>
        <div class="modal-body">
                  
          <div id="data-product-plan" class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">
            

            <div class="col-md-4 col-sm-3 col-xs-12">
              <div class="">
                <label class="tebal">Tanggal Rencana :</label>
              </div>
            </div>
             <div class="col-md-8 col-sm-3 col-xs-12">
              <div class="form-group">
                <input class="form-control" readonly="" type="text" name="tgl_plan" id="tgl_plan"> 
                 <input class="form-control" type="hidden" name="id_plan" id="id_plan">               
              </div>
            </div>

            <div class="col-md-4 col-sm-3 col-xs-12">
              <div class="">
                <label class="tebal">Item :</label>
              </div>
            </div>
            <div class="col-md-8 col-sm-3 col-xs-12">
              <div class="form-group">                
                <input class="form-control" readonly="" type="hidden" name="iditem" id="iditem">                
                <input class="form-control" readonly="" type="text" name="item" id="item">                
              </div>
            </div>

            <div class="col-md-4 col-sm-3 col-xs-12">
              <div class="">
                <label class="tebal">Jumlah :</label>
              </div>
            </div>
            <div class="col-md-8 col-sm-3 col-xs-12">
              <div class="form-group">
                <input class="form-control" readonly="" type="text" name="jumlah" id="jumlah">                
              </div>
            </div>

                      <div class="col-md-4 col-sm-3 col-xs-12">
              <div class="">
                <label class="tebal">No SPK :</label>
              </div>
            </div>
            <div class="col-md-8 col-sm-3 col-xs-12">
              <div class="form-group">
                <input class="form-control" readonly="" type="text" name="id_spk" id="id_spk">               
              </div>
            </div> 

          </div>

          <div class="table-responsive">
            <form id="formula">
              <table class="table tabelan table-hover table-bordered" id="tableFormula">
                <thead>
                  <tr>
                    <th>Bahan Baku</th>
                    <th>Kebutuhan</th>
                    <th width="5%">Satuan</th>
                    <th>Stok</th>
                    <th width="5%">Satuan</th>
                    <th>Sisa</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </form>
            </div>
            
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>

      </div>
    
  </div>
</div>
<!-- end detail order-->

