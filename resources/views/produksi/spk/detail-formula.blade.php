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
        <div class="col-md-4 col-sm-3 col-xs-12">
            <div class="">
                <label class="tebal">Hpp  {{ $item->i_name }} :</label>
            </div>
        </div>
        <div class="col-md-8 col-sm-3 col-xs-12">
            <div class="form-group">
                <input class="form-control" readonly="" type="text" name="id_spk" id="id_spkD"
                       value="{{ number_format( $item->spk_hpp,2,',','.')}}">
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
                    <th>Kode - Nama Item</th>
                    <th width="15%">Kebutuhan</th>
                    <th width="15%">Stok</th>
                    <th width="5%">Satuan</th>
                    <th width="20%">hpp</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($formula as $form)
                   <tr>
                        <td>{{ $form->i_code }} -  {{ $form->i_name }}</td>
                        <td class="text-right">{{ number_format( $form->fr_value,2,',','.')}}</td>
                        <td class="text-right">
                            {{ number_format( $form->s_qty,2,',','.')}}
                            <input type="text" style="display:none" class="form-control cekSisa" value="{{ number_format( $form->s_qty - $form->fr_value,2,',','.')}}">
                        </td>
                        <td>{{ $form->m_sname }}</td>
                        <td>
                            <span class="pull-right">   
                                {{ number_format( $form->fr_hpp,2,',','.')}}
                            </span>
                        </td>
                    </tr>
                @endforeach
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
            <button type="button" class="btn btn-danger siapProses" onclick="ubahStatus({{ $id }})">Proses</button>
    @endif
</div>


<!-- end detail order-->

<script type="text/javascript">
    $('#detailFormula').dataTable();

</script>
