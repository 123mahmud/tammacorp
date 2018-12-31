<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog modal-lg">
      
    
      <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="background-color: #e77c38;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="color: white;">Form Pembuatan Formula</h4>
          </div>

          <div class="modal-body">

            <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 15px;padding-top: 15px; ">               
              <form id="myForm" onsubmit="return false">
              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Nama Item<font color="red">*</font></label>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                  <input type="text" class="form-control input-sm" name="namaitem" id="namaitem">
                  <input type="hidden" class="form-control input-sm" name="id_item" id="id_item">
                </div>
              </div>           

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Jumlah Hasil Produksi<font color="red">*</font></label>
              </div>

              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                 <input style="text-align: right;" autocomplete="off" type="number" class="form-control input-sm" name="hasil_item" id="hasil_item">
                </div>
              </div>

              <div class="col-md-4 col-sm-4 col-xs-12">
                  <label class="tebal">Satuan<font color="red">*</font></label>
              </div>

              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                  <select class="form-control" id="satuan-item" name="satuanItem[]">
                  </select>
                </div>
              </div>
            </form>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:20px;padding-top:20px; ">
                 <div class="col-md-6 col-sm-6 col-xs-12">
                   <label class="control-label tebal" >Masukan Kode / Nama Bahan Baku</label>
                      <div class="input-group input-group-sm" style="width: 100%;">
                          <input type="text" id="bahan_baku" name="bahan_baku" class="form-control">
                          <input type="hidden" id="i_id" name="i_id" class="form-control">        
                          <input type="hidden" id="i_name" name="i_name" class="form-control">
                          <input type="hidden" id="i_code" name="i_code" class="form-control">                                  
                      </div>
                  </div>        
                  <div class="col-md-3 col-sm-3 col-xs-12">
                   <label class="control-label tebal">Masukan Jumlah</label>
                      <div class="input-group input-group-sm" style="width: 100%;">
                         <input type="number" id="qty" name="qty" class="form-control text-right" >
                      </div>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                   <label class="control-label tebal">Satuan</label>
                      <div class="input-group input-group-sm" style="width: 100%;">
                        <select class="form-control" id="satuan" name="satuan">
                        </select>
                      </div>
                  </div>
            </div>
                  <div class="table-responsive">
                    <table class="table tabelan table-bordered table-hover dt-responsive" id="resep-detail" width="100%">
                     <thead align="right">
                      <tr>
                        <th width="10%">Kode</th>
                        <th width="55%">Nama Item</th>
                        <th width="20%">Jumlah</th>  
                        <th width="5%">Satuan</th>                           
                        <th width="10%"></th>
                      </tr>
                     </thead> 
                     <tbody>
                      
                     </tbody>
                    </table>
                  </div>

          </div>
      
          <div class="modal-footer" style="border-top: none;">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="btn-simpan" onclick="simpanResep()">Simpan Data</button>
          </div>

           
        </div>

         
      
    </div>

</div>