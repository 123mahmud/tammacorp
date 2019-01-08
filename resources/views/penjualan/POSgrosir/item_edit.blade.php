<div class="col-md-12 tamma-bg"
     style="margin-top: 5px;margin-bottom: 5px;margin-bottom: 20px; padding-bottom:20px;padding-top:20px;">
    <div class="col-md-6">
        <label class="control-label tebal" for="">Masukan Kode / Nama</label>
        <div class="input-group input-group-sm" style="width: 100%;">
            <input type="text" id="namaitem" name="item" class="form-control">
            <input type="hidden" id="kode" name="sd_item" class="form-control">
            <input type="hidden" id="harga" name="sd_sell" class="form-control">
            <input type="hidden" id="detailnama" name="nama" class="form-control">
            <input type="hidden" id="satuan" name="satuan" class="form-control">
            <input type="hidden" id="i-type" name="i-type" class="form-control">
        </div>
    </div>
    <div class="col-md-3">
        <label class="control-label tebal" name="qty">Masukan Jumlah</label>
        <div class="input-group input-group-sm" style="width: 100%;">
            <input type="number" id="qty" name="qty" class="form-control">
        </div>
    </div>
    <div class="col-md-3">
        <label class="control-label tebal" name="qty">Kuantitas Stok</label>
        <div class="input-group input-group-sm" style="width: 100%;">
            <input type="hidden" id="s_qty" name="s_qty" class="form-control" readonly>
            <input type="number" id="s_qtycon" name="s_qtycon" readonly class="form-control">
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table tabelan table-bordered table-hover dt-responsive" id="detail-penjualan">
        <thead align="right">
        <tr>
            <th>Nama</th>
            <th width="2%">Jumlah</th>
            <th width="2%">Satuan</th>
            <th width="15%">Harga</th>
            <th width="11%">Disc Percent</th>
            <th>Disc Value</th>
            <th width="15%">Total</th>
            <th>
                <button class="hidden" onclick="tambahEdit()">add</button>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($edit as $x)
            <tr>
                <td>
                    {{ $x->i_name }}
                    <input type="hidden" name="sd_sales[]" class="sd_sales" value="{{ $x->sd_sales }}">
                    <input type="hidden" name="sd_detailid[]" class="sd_detailid" value="{{ $x->sd_detailid }}">

                    <input type="hidden" name="kode_item[]" class="kode_item kode" value="{{ $x->i_id }}">
                    <input type="hidden" name="nama_item[]" class="nama_item" value="{{ $x->i_name }}">
                </td>
                <td>
                    <input size="30" style="text-align:right" type="number" name="sd_qty[]"
                           class="sd_qty form-control qty-{{$x->i_id }}" value="{{$x->sd_qty }}"
                           onkeyup="UpdateHarga('{{ $x->i_id }}'); qtyInput('{{ $x->s_qty }}','{{ $x->i_id }}')"
                           onchange="qtyInput('{{ $x->s_qty }}','{{ $x->i_id }}')"
                           onclick="UpdateHarga('{{ $x->i_id }}')"
                           onchange="qtyInput('{{ $x->i_type }}','{{ $x->s_qty }}','{{ $x->i_id }}')">
                </td>
                <td>
                    {{ $x->m_sname }}<input type="hidden" name="satuan[]" class="satuan" value="{{ $x->m_sname }}">
                </td>
                <td>
                    <input type="text" size="10" readonly name="harga_item[]"
                           class="harga_item form-control harga-{{ $x->i_id }}" style="text-align: right;"
                           value="Rp.{{ number_format($x->sd_price,2,',','.')}}">
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" style="text-align:right"
                               onkeyup="discpercent(this, event);autoJumValPercent();dataInput(this, event)"
                               name="sd_disc_percent[]"
                               @if($x->sd_disc_percent == '0') readonly="true" @else @endif
                               class="form-control discpercent hasildiscpercent discpercent-{{ $x->i_id }}"
                               value="@if($x->sd_disc_percent == '0')@else{{ $x->sd_disc_percent }} @endif">
                        <span class="input-group-addon">%</span>
                    </div>
                    <input name="totalValuePercent[]" type="text" value="0" style="display:none"
                           class="form-control totalValuePercent jumTotValuePercent totalValuePercent-{{ $x->i_id }}">
                </td>
                <td>
                    <input type="text" style="text-align:right"
                           onkeyup="discvalue(this, event);autoJumValValue();rege(event,'discvalue-{{ $x->i_id }}');"
                           class="form-control discvalue hasildiscvalue discvalue-{{ $x->i_id }} pricevalue-{{ $x->i_id }}"
                           name="sd_disc_value[]"
                           onblur="setRupiah(event,'discvalue-{{ $x->i_id }}')"
                           onclick="setAwal('event','discvalue-{{ $x->i_id }}')"
                           @if($x->sd_disc_value == '0')  readonly="true" @else @endif
                           value="Rp.@if($x->sd_disc_value == null) @else {{ number_format($x->sd_disc_value / $x->sd_qty,2,',','.')}}  @endif">
                    <input type="text" size="200" readonly name="totaldiscvalue[]" id="totaldiscvalue" style="display:none" class="form-control totaldiscvalue totaldiscvalue-{{ $x->i_id }}" value="{{ (int)$x->sd_disc_value }}">
                </td>
                <td>
                    <input type="text" size="200" readonly style="text-align:right" name="hasil[]" id="hasil"
                           class="form-control hasil hasil-{{ $x->i_id }}"
                           value="Rp. {{ number_format( $x->sd_total ,2,',','.')}}">
                </td>
                <td>
                    <button type="button" class="btn btn-danger hapus" onclick="hapus(this)"><i
                                class="fa fa-trash-o"></i></button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


<script type="text/javascript">

    var hpercent = 0;

    function discpercentEdit(inField, e) {
        var a = 0;
        $('input.discpercent:text').each(function (evt) {
            var getIndex = a; //alert(getIndex);
            var dataInput = $('input.discpercent:text:eq(' + getIndex + ')').val();
            var diskon = $('input.discpercent:text:eq(' + getIndex + ')').val();
            var harga = $('input.harga_item:text:eq(' + getIndex + ')').val();
            var qty = $('input.sd_qty:eq(' + getIndex + ')').val();
            harga = convertToAngka(harga);
            harga = parseInt(harga);
            diskon = parseInt(diskon);
            qty = parseInt(qty);
            if (isNaN(diskon)) {
                diskon = 0;
            }
            hasill = harga * qty;
            if (diskon >= 100) {
                diskon = 0;
                $('input.discpercent:text:eq(' + getIndex + ')').val(0);
            }
            hpercent = hasill * diskon / 100;
            $('input.totalValuePercent:text:eq(' + getIndex + ')').val(hpercent);
            autoJumValPercent();
            a++;
        })
    }

    function discvalueEdit(inField, e) {
        var a = 0;
        $('input.discvalue:text').each(function (evt) {
            var getIndex = a;
            var dataInput = $('input.discvalue:text:eq(' + getIndex + ')').val();
            var diskon = $('input.discvalue:text:eq(' + getIndex + ')').val();
            var harga = $('input.harga_item:text:eq(' + getIndex + ')').val();
            var qty = $('input.sd_qty:eq(' + getIndex + ')').val();
            harga = convertToAngka(harga);
            harga = parseInt(harga);
            diskon = parseInt(diskon);
            qty = parseInt(qty);
            if (isNaN(diskon)) {
                diskon = 0;
            }
            hasil = harga * qty;
            if (diskon > hasil) {
                diskon = 0;
                $('input.discvalue:text:eq(' + getIndex + ')').val(0);
            }
            autoJumValValue();
            a++;
        })
    }
</script>