<!-- detail order-->

<div id="data-product-plan" class="col-md-12 col-sm-12 col-xs-12"
     style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">
    <div class="table-responsive">
        <form id="formula">
            <table class="table tabelan table-hover table-bordered" id="detailFormula" width="100%">
                <thead>
                <tr>
                    <th width="5%">No.</th>
                    <th>Kode - Nama Item</th>
                    <th>i_type</th>
                    <th>Opname</th>
                    <th>Satuan</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($data as $index => $opname)
                    <tr>
                         <td>{{$index + 1}}</td>
                         <td>{{$opname->i_code}} - {{$opname->i_name}}</td>
                         <td>{{$opname->i_type}}</td>
                         <td>
                             <span class="pull-right">
                                 {{ number_format($opname->od_opname,0,',','.')}}
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
