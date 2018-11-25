            <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 15px;padding-top: 15px; ">
              @foreach ($data as $item)
              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Nama Item</label>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                  <input type="text" readonly class="form-control input-sm" name="namaitem" id="namaitem" value="{{ $item->i_name }}">
                </div>
              </div> 
              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Jumlah Hasil Produksi</label>
              </div>

              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                  <input style="text-align: right;" readonly autocomplete="off" type="number" class="form-control input-sm" name="hasil_item" id="hasil_item" value="{{ (int)$item->fr_result }}">
                </div>
              </div>

              <div class="col-md-4 col-sm-4 col-xs-12">
                  <label class="tebal">Satuan</label>
              </div>

              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                   <input type="text" class="form-control input-sm" readonly name="namaitem" id="namaitem" value="{{ $item->m_sname }}">
                </div>
              </div>
              @endforeach
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 15px;padding-top: 15px; ">

            <div class="table-responsive">
              <table class="table tabelan table-bordered table-hover dt-responsive" id="formula-detail" >
               <thead align="right">
                <tr>
                  <th width="10%">No</th>
                  <th width="70%">Nama Item</th>
                  <th width="5%">Jumlah</th>  
                  <th width="10%">Satuan</th>                           
                </tr>
               </thead> 
               <tbody>
                @foreach ($formula as $index => $data)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $data->i_name }}</td>
                  <td>{{ (int)$data->f_value }}</td>
                  <td>{{ $data->m_sname }}</td>
                </tr>
                @endforeach
               </tbody>
              </table>
            </div>
          </div>

<script>
  $('#formula-detail').DataTable();
  
</script>