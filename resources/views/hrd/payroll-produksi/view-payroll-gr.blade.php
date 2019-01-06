        <div id="data-product-plan" class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">
        <div class="col-md-4 col-sm-3 col-xs-12">
          <div class="">
            <label class="tebal">Nama Pegawai:</label>
          </div>
        </div>
         <div class="col-md-8 col-sm-3 col-xs-12">
          <div class="form-group">
            <input class="form-control" readonly type="text" name="tgl_plan" id="tgl_planD"
            value="{{ $garapan[0]->c_nama }}">
             <input class="form-control" type="hidden" name="id_plan" id="id_plan">
          </div>
        </div>

        <div class="col-md-4 col-sm-3 col-xs-12">
          <div class="">
            <label class="tebal">Jabatan Pegawai :</label>
          </div>
        </div>
        <div class="col-md-8 col-sm-3 col-xs-12">
          <div class="form-group">
            <input class="form-control" readonly="" type="text" name="item" id="itemD" value="{{ $garapan[0]->c_jabatan_pro }}">
          </div>
        </div>
      </div>
        <div id="data-product-plan" class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">
          <div class="table-responsive">
              <table class="table tabelan table-hover table-bordered" id="detailFormula" width="100%">
                <thead>
                  <tr>
                    <th width="40%">Nama Item</th>
                    <th width="10%">Regular</th>
                    <th width="25%">Harga</th>
                    <th width="25%">Total</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($garapan as $data)
                  <tr>
                    <td>{{ $data->nm_gaji }}</td>
                    <td class="text-right">{{ number_format( $data->dataGaji + $data->dataLembur,0,'.',',') }}</td>
                    <td class="text-right">{{ number_format( $data->c_gaji,0,'.',',') }}</td>
                    <td class="text-right">{{ number_format(( $data->dataGaji+ $data->dataLembur) * $data->c_gaji,0,'.',',') }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
          </div>
        </div>

        <div id="data-product-plan" class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">
          <div class="table-responsive">
              <table class="table tabelan table-hover table-bordered" id="detailLembur" width="100%">
                <thead>
                  <tr>
                    <th width="40%">Nama Item</th>
                    <th width="10%">Lembur</th>
                    <th width="25%">Harga</th>
                    <th width="25%">Total</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($garapan as $data)
                  <tr>
                    <td>{{ $data->nm_gaji }}</td>
                    <td class="text-right">{{ number_format($data->dataLembur,0,'.',',') }}</td>
                    <td class="text-right">{{ number_format($data->c_lembur,0,'.',',') }}</td>
                    <td class="text-right">{{ number_format($data->dataLembur * $data->c_lembur,0,'.',',') }}</td>
                  </tr>

                  @endforeach
                  <tr>
                    <td colspan="3" style="text-align:left;font-weight: bold;">Pendapatan Total</td>
                    <td  class="text-right" style="font-weight: bold;">{{ number_format($total,0,'.',',') }}</td>
                  </tr>
                </tbody>
              </table>
          </div>
        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-warning" onclick="printPayPro({{ $id }})">Print</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>


<!-- end detail order-->

  <script type="text/javascript">
    //$('#detailFormula').dataTable();
    //$('#detailLembur').dataTable();
     function printPayPro(id) 
     {
        var tgl1 = $('#tanggal03').val();
        var tgl2 = $('#tanggal04').val();
        window.open(baseUrl + "/hrd/payroll/print-gaji/GR/" + id + "/" + tgl1 + "/" + tgl2, "_blank");
     }
  </script>
