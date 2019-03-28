<!-- detail order-->

<div id="data-product-plan" class="col-md-12 col-sm-12 col-xs-12"
     style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">
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
    

</div>


<!-- end detail order-->

<script type="text/javascript">
    $('#detailFormula').dataTable();

</script>
