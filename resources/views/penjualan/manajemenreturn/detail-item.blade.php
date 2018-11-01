<div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-top:10px;padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;"> 
        <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Nama Pelanggan :</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblCodePlan">{{ $data[0]->c_name }}</label>
              </div>  
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Nota :</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblTglPlan">{{ $data[0]->s_note }}</label>
              </div>  
            </div>
            
            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Jumlah Return :</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblStaff">Rp. {{ number_format(  $data[0]->dsr_price_return,2,',','.')}}</label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">S Gross :</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblSupplier">Rp. {{ number_format(  $data[0]->dsr_sgross,2,',','.')}}</label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">Total Disc :</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblSupplier">Rp. {{ number_format( $data[0]->dsr_disc_value,2,',','.')}}</label>
              </div>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <label class="tebal">S Net :</label>
            </div>

            <div class="col-md-3 col-sm-12 col-xs-12">
              <div class="form-group">
                <label id="lblSupplier">Rp. {{ number_format( $data[0]->dsr_net,2,',','.')}}</label>
              </div>
            </div>

          </div>
{{-- </div> --}}

<table class="table tabelan table-bordered table-hover" id="TbDtDetail">
    <thead>
        <tr>
            <th>Nama</th>
            <th width="5%">Jumlah</th>
            <th width="5%">return</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th width="10%">Disc Percent</th>
            <th>Disc Value</th>
            <th>Jumlah return</th>
            <th width="20%">Total</th>
        </tr>
    </thead>
    <tbody>
{{--         @foreach ($detalis as $index => $detail)
        <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $detail->i_name }}</td>
            <td><span class="pull-right">
                {{$detail->sd_qty}}
            </span>
        </td>
        <td>
            {{ $detail->m_sname }}
        </td>
        <td>Rp.
            <span class="pull-right">
                {{ number_format($detail->sd_price,2,',','.')}}
            </span>
        </td>
        <td><span class="pull-right">
            @if($detail->sd_disc_percent == null)
            0
            @else
            {{$detail->sd_disc_percent}}
            @endif
            %
        </span>
    </td>
    <td>Rp.
        <span class="pull-right">
            {{ number_format($detail->sd_disc_value,2,',','.')}}
        </span>
    </td>
    <td>Rp.
        <span class="pull-right">
            {{ number_format($detail->sd_total,2,',','.')}}
        </span>
    </td>
</tr>
@endforeach --}}
</tbody>
</table>
<script>
$('#TbDtDetail').DataTable();
</script>