<div class="modal fade" id="modal-barang" role="dialog">
  <div class="modal-dialog" style="width: 90%;margin: auto;">
      
    <form method="get" action="#">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #e77c38;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color: white;">Detail Data Relasi Barang ke Supplier</h4>
        </div>

        <div class="modal-body">
          <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">                          
            <div class="col-md-12 col-sm-12 col-xs-12">
              <label class="tebal">Nama Barang : </label>
              <label id="lblNamaBarang"></label>
            </div>
          </div>
         
          <div class="table-responsive">
            <table id="tabel-detail-barang" class="table tabelan table-bordered table-striped">
              <thead>
                <tr>
                  <th width="5%" style="text-align: center;">No</th>
                  <th width="45%" style="text-align: center;">Nama Supplier</th>
                  <th width="50%" style="text-align: center;">Alamat</th>
                </tr>
              </thead>
              <tbody id="div_item">
              </tbody>
            </table>
            <div align="right">
              <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!-- /Modal content-->
    </form>   
    <!-- /Form-->
  </div>
</div>