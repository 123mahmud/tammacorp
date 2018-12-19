<!-- Modal -->
<div class="modal fade" id="modal_analisa_cashflow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 35%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Setting Cashflow</h4>
      </div>

      <form id="form-jurnal" method="get" action="{{ route('analisa.cashflow') }}" target="_blank">

      <div class="modal-body">
        <div class="row" style="margin-bottom: 15px;">
          <div class="col-md-4">
            Type Analisa
          </div>

          <div class="col-md-8">
            <select class="form-control" name="jenis">
              <option value="bulanan">Bulanan</option>
              <option value="akumulasi">Akmulasi</option>
            </select>
          </div>
        </div>
      </div>
      
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Proses</button>
      </div>

      </form>
    </div>
  </div>
</div>