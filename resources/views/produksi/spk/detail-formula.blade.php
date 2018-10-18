<!-- detail order-->

<div id="data-product-plan" class="col-md-12 col-sm-12 col-xs-12 tamma-bg"
     style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">

    @foreach ($spk as $item)
        <div class="col-md-4 col-sm-3 col-xs-12">
            <div class="">
                <label class="tebal">Tanggal Rencana :</label>
            </div>
        </div>
        <div class="col-md-8 col-sm-3 col-xs-12">
            <div class="form-group">
                <input class="form-control" readonly type="text" name="tgl_plan" id="tgl_planD"
                       value="{{ $item->pp_date }}">
                <input class="form-control" type="hidden" name="id_plan" id="id_plan">
            </div>
        </div>

        <div class="col-md-4 col-sm-3 col-xs-12">
            <div class="">
                <label class="tebal">Item :</label>
            </div>
        </div>
        <div class="col-md-8 col-sm-3 col-xs-12">
            <div class="form-group">
                <input class="form-control" readonly="" type="hidden" name="iditem" id="iditem">
                <input class="form-control" readonly="" type="text" name="item" id="itemD" value="{{ $item->i_name }}">
            </div>
        </div>

        <div class="col-md-4 col-sm-3 col-xs-12">
            <div class="">
                <label class="tebal">Jumlah :</label>
            </div>
        </div>
        <div class="col-md-8 col-sm-3 col-xs-12">
            <div class="form-group">
                <input class="form-control" readonly="" type="text" name="jumlah" id="jumlahD"
                       value="{{ $item->pp_qty }}">
            </div>
        </div>

        <div class="col-md-4 col-sm-3 col-xs-12">
            <div class="">
                <label class="tebal">No SPK :</label>
            </div>
        </div>
        <div class="col-md-8 col-sm-3 col-xs-12">
            <div class="form-group">
                <input class="form-control" readonly="" type="text" name="id_spk" id="id_spkD"
                       value="{{ $item->spk_code }}">
            </div>
        </div>
    @endforeach
</div>
<div id="data-product-plan" class="col-md-12 col-sm-12 col-xs-12"
     style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">
    <div class="table-responsive">
        <form id="formula">
            <table class="table tabelan table-hover table-bordered" id="detailFormula" width="100%">
                <thead>
                <tr>
                    <th width="5%">Kode Item</th>
                    <th>Nama Item</th>
                    <th width="5%">Kebutuhan</th>
                    <th width="5%">Satuan</th>
                    <th width="20%">hpp</th>
                </tr>
                </thead>
                <tbody>
                @for ($i = 0; $i < count($formula); $i++)
                   <tr>
                        <td>{{ $formula[$i]['i_code'] }}</td>
                        <td>{{ $formula[$i]['i_name'] }}</td>
                        <td class="text-right">{{ number_format( $formula[$i]['fr_value'],0,',','.')}}</td>
                        <td>{{ $formula[$i]['m_sname'] }}</td>
                        <td>Rp.
                            <span class="pull-right">
                                {{ number_format($bambang[$i],2,',','.')}}
                            </span>
                                </td>
                            </tr>
                @endfor



                </tbody>
            </table>
        </form>
    </div>
</div>

<div class="modal-footer">
    <a class="btn btn-primary" target="_blank" href="{{route('spk_print', ['spk_id' => $item->spk_id])}}"><i
                class="fa fa-print"></i>&nbsp;Print</a>
    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
    @if ($ket == 'AP')
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="ubahStatus({{ $id }})">Proses</button>
    @endif
</div>


<!-- end detail order-->

<script type="text/javascript">
    $('#detailFormula').dataTable();

</script>
