<div class="modal fade" id="modal-detail-rev" role="dialog">
  <div class="modal-dialog" style="width: 90%;margin: auto;"> 
    <form method="post" id="form-revisi-po">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Detail Revisi PO</h4>
        </div>

        <div class="modal-body">
          <label class="tebal">Status : </label>&nbsp;&nbsp;
          <span class="" id="txt_span_status_detail_rev"></span>
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
            {{ csrf_field() }}
            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">No Order Pembelian</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblNoOrder"></label>
              </div>  
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Cara Pembayaran</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblCaraBayar"></label>
              </div>  
            </div>
            
            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Tanggal Order Pembelian</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblTglOrder"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Nama Staff</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblStaffRev"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Tanggal Pengiriman</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblTglKirim"></label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Suplier</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblSupplierRev"></label>
              </div>
            </div>

            <div id="append-modal-detail"></div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Total Harga</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <input type="text" readonly="" class="input-sm form-control" name="totalHarga" style="text-align: right;">
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Total Diskon</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <input type="text" readonly="" class="input-sm form-control" name="diskonHarga" style="text-align: right;">
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">PPN</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <input type="text" readonly="" class="input-sm form-control" name="ppnHarga" style="text-align: right;">
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Total</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <input type="text" readonly="" class="input-sm form-control" name="totalHargaFinal" style="text-align: right;">
              </div>
            </div>

          </div>
          
          <div class="table-responsive">
            <table id="tabel-order" class="table tabelan table-bordered table-striped">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th width="20%">Nama Item</th>
                  <th width="10%">Satuan</th>
                  <th width="10%">Qty</th>
                  <th width="10%">Stok Gudang</th>
                  <th width="15%">Harga Prev</th>
                  <th width="15%">Harga</th>
                  <th width="15%">Total</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
    
        <div id="divBtnModal" class="modal-footer" style="border-top: none;">

      </div>
      <!-- /Modal content-->
    </form>   
    <!-- /Form-->
  </div>
</div>