<div class="modal fade" id="modal-edit" role="dialog">
  <div class="modal-dialog" style="width: 90%;margin: auto;">
      
    <form method="post" id="form-edit-order">
      {{ csrf_field() }}
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Edit Order Pembelian</h4>
        </div>

        <div class="modal-body">
          <label class="tebal">Status : </label>&nbsp;&nbsp;
          <span class="" id="txt_span_status_edit"></span>
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">No Order Pembelian</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblNoOrderEdit"></label>
              </div>  
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Cara Pembayaran</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblCaraBayarEdit"></label>
              </div>  
            </div>
            
            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Tanggal Order Pembelian</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblTglOrderEdit"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Nama Staff</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblStaffEdit"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Tanggal Pengiriman</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblTglKirimEdit"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Suplier</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblSupplierEdit"></label>
              </div>
            </div>

            <div id="append-modal-edit"></div>
          </div>

          <input type="hidden" id="id_purchase_edit" name="idPurchaseEdit">  

          <div class="table-responsive">
            <table id="tabel-edit" class="table tabelan table-bordered table-striped">
              <thead>
                <tr>
                  <th style="text-align: center;" width="5%">No</th>
                  <th width="25%">Kode | Barang</th>
                  <th width="7%">Qty</th>
                  <th width="7%">Satuan</th>
                  <th width="13%">Harga Prev</th>
                  <th width="13%">Harga</th>
                  <th width="15%">Total</th>
                  <th width="10%">Stok Gudang</th>
                  <th style="text-align: center;" width="5%">Aksi</th>
                </tr>
              </thead>
              <tbody id="div_item">
                
              </tbody>
            </table>
          </div>

          <div class="col-md-3 col-md-offset-9 col-sm-6 col-sm-offset-6 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top: 10px;">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Total Harga</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <input type="text" readonly="" id="total_gross" class="input-sm form-control" name="totalGrossEdit" style="text-align:right;">
              </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Potongan Harga</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <input type="text" class="input-sm form-control numberinput" id="potongan_harga" name="potonganHargaEdit" style="text-align:right;">
              </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Diskon</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <input type="text" class="input-sm form-control numberinput" id="diskon_harga" name="diskonHargaEdit" style="text-align:right;">
              </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">PPN</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <input type="text" class="input-sm form-control numberinput" id="ppn_harga" name="ppnHargaEdit" style="text-align:right;">
              </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Total</label>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="form-group">
                <input type="text" readonly="" class="input-sm form-control" id="total_nett" name="totalNettEdit" style="text-align:right;">
              </div>
            </div>

          </div>          
        </div>
    
        <div class="modal-footer" style="border-top: none;">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="submitEdit()" id="button_save">Simpan Data</button>
        </div>

      </div>
      <!-- /Modal content-->
    </form>   
    <!-- /Form-->
  </div>
</div>