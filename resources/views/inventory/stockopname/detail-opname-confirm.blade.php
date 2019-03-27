<!-- detail order-->
<div id="data-product-plan" class="col-md-12 col-sm-12 col-xs-12"
    style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">
    <div class="col-md-12 col-sm-12 col-xs-12"  style="padding-bottom: 10px;">
        <div style="margin-left:-5px;">
            <div class="col-md-1" style="padding: 3px">
                <label class="tebal">Status :</label>
            </div>
            <div class="col-md-4" style="padding: 3px">
                <select name="pemilik-gudang" id="confirm" class="form-control input-sm">
                    @if ($status->o_confirm == 'WT')
                            <option value="WT" selected>Waiting</option>
                            <option value="AP">Aprrove</option>
                    @elseif ($status->o_confirm == 'AP')
                            <option value="WT">Waiting</option>
                            <option value="AP" selected>Aprrove</option>
                    @elseif ($status->o_confirm == 'CL')
                            <option value="CL" selected>Clear</option>
                    @endif
                </select>
                
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <form id="formula">
            <table class="table tabelan table-hover table-bordered" id="detailFormula" width="100%">
                <thead>
                    <tr>
                        <th width="25%">Kode - Nama Item</th>
                        <th width="10%">Type Item</th>
                        <th width="20%">Stock System</th>
                        <th width="20%">Stock Real</th>
                        <th width="20%">Opname</th>
                        <th width="5%">Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $opname)
                    <tr>
                        <td>{{$opname->i_code}} - {{$opname->i_name}}</td>
                        <td>
                            @if ($opname->i_type == 'BB')
                            Bahan baku
                            @elseif ($opname->i_type == 'BJ')
                            Barang jual
                            @else
                            Barang Produksi
                            @endif
                        </td>
                        <td>
                            <span class="pull-right">
                                {{ number_format($opname->od_system,2,',','.')}}
                            </span>
                        </td>
                        <td>
                            <span class="pull-right">
                                {{ number_format($opname->od_real,2,',','.')}}
                            </span>
                        </td>
                        <td>
                            <span class="pull-right">
                                {{ number_format($opname->od_opname,2,',','.')}}
                            </span>
                        </td>
                        <td>{{$opname->m_sname}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
</div>
<div class="modal-footer" id="btn-modal">
    @if ($status->o_confirm != 'CL')
        <button type="button" class="btn btn-primary" onclick="updateConfirm({{ $status->o_id }})">Update</button>
    @endif
    
    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
</div>
<!-- end detail order-->
<script type="text/javascript">
$('#detailFormula').dataTable();
</script>