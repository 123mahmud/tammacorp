<!-- detail order-->
<div id="data-product-plan" class="col-md-12 col-sm-12 col-xs-12 tamma-bg"
   style="margin-bottom: 20px; padding-bottom:20px;padding-top:20px; ">
   <div class="col-md-4 col-sm-3 col-xs-12">
      <div class="">
         <label class="tebal">Berat Adonan :</label>
      </div>
   </div>
   <div class="col-md-6 col-sm-3 col-xs-12">
      <div class="form-group">
         @if($actual == null)
         <input class="form-control text-right input-sm currenc" type="text" name="ac_adonan" id="ac_adonan"
         value="">
         @else
         <input class="form-control text-right input-sm currenc" type="text" name="ac_adonan" id="ac_adonan"
         value="{{$actual->ac_adonan}}">
         @endif
      </div>
   </div>
   <div class="col-md-2 col-sm-3 col-xs-12">
      <div class="form-group">
         <input class="form-control input-sm" readonly type="text" name="" id=""
         value="KG">
      </div>
   </div>
   <div class="col-md-4 col-sm-3 col-xs-12">
      <div class="">
         <label class="tebal">Berat Kriwilan :</label>
      </div>
   </div>
   <div class="col-md-6 col-sm-3 col-xs-12">
      <div class="form-group">
         @if($actual == null)
         <input class="form-control text-right input-sm currenc" type="text" name="ac_kriwilan" id="ac_kriwilan"
         value="">
         @else
         <input class="form-control text-right input-sm currenc" type="text" name="ac_kriwilan" id="ac_kriwilan"
         value="{{$actual->ac_kriwilan}}">
         @endif
      </div>
   </div>
   <div class="col-md-2 col-sm-3 col-xs-12">
      <div class="form-group">
         <input class="form-control input-sm" readonly type="text" name="" id=""
         value="KG">
      </div>
   </div>
   <div class="col-md-4 col-sm-3 col-xs-12">
      <div class="">
         <label class="tebal">Berat Sampah :</label>
      </div>
   </div>
   <div class="col-md-6 col-sm-3 col-xs-12">
      <div class="form-group">
         @if($actual == null)
         <input class="form-control text-right input-sm currenc" type="text" name="ac_sampah" id="ac_sampah"
         value="">
         @else
         <input class="form-control text-right input-sm currenc" type="text" name="ac_sampah" id="ac_sampah"
         value="{{$actual->ac_sampah}}">
         @endif
      </div>
   </div>
   <div class="col-md-2 col-sm-3 col-xs-12">
      <div class="form-group">
         <input class="form-control input-sm" readonly type="text" name="" id=""
         value="KG">
      </div>
   </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
   <label class="tebal">Masukan jumlah sisa adonan di tabel jika masih dapat terpakai :</label>
</div>
<div id="data-product-plan" class="col-md-12 col-sm-12 col-xs-12"
     style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">
   <div class="table-responsive" style="padding-top: 15px;">
      <div id="tabelSpkFinish">
         <table class="table tabelan table-hover table-bordered dt-responsive" id="input-sisa" width="100%">
            <thead>
               <tr>
                  <th width="30%">Kode - Nama Item</th>
                  <th width="30%">Kebutuhan</th>
                  <th width="30%">Sisa</th>
                  <th width="10%">Satuan</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($dataFormula as $formula)
               <tr>
                  <td>{{ $formula->i_code }} - {{ $formula->i_name }}</td>
                  <td>
                     <input type="text" name="sisa" class="form-control input-sm text-right currenc" value="{{ number_format($formula->fr_value,2,'.',',') }}" readonly>
                  </td>
                  <td><input type="text" name="sisa" class="form-control input-sm text-right currenc"></td>
                  <td>{{ $formula->m_sname }}</td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</div>
   <div class="modal-footer">
      <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" onclick="saveActual({{$spk->spk_id}})">Final</button>
   </div>
<!-- end detail order-->
<script type="text/javascript">
    $('#input-sisa').dataTable();

    $('.currenc').inputmask("currency", {
         radixPoint: ".",
         groupSeparator: ".",
         digits: 2,
         autoGroup: true,
         prefix: '', //Space after $, this will not truncate the first character.
         rightAlign: false,
         oncleared: function () { self.Value(''); }
      });

</script>