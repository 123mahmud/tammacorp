<form action="get" id="save_request">
    <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">
        <div class="col-md-4 col-sm-3 col-xs-12">
            
            <label class="tebal">No Transfer</label>
            
        </div>
        <div class="col-md-8 col-sm-9 col-xs-12">
            <div class="form-group">
                <input type="text" id="" readonly="true" name="ri_nomor" value="{{$transferItem->ti_code}}" class="form-control input-sm">
            </div>
        </div>
        <div class="col-md-4 col-sm-3 col-xs-12">
            
            <label class="tebal" name="admin">Admin</label>
            
        </div>
        <div class="col-md-8 col-sm-9 col-xs-12">
            <div class="form-group">
                <div class="input-icon right">
                    <i class="glyphicon glyphicon-user"></i>
                    <input type="text" id="" readonly="true" name="admin" class="form-control input-sm" \
                    value="{{ Auth::user()->m_name }}">
                    <input type="hidden" id="" readonly="true" name="ri_admin" class="form-control input-sm" value="{{ Auth::user()->m_id }}">
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-3 col-xs-12">
            
            <label class="tebal">Tanggal</label>
            
        </div>
        <div class="col-md-8 col-sm-9 col-xs-12">
            <div class="form-group">
                <div class="input-icon right">
                    <i class="glyphicon glyphicon-envelope"></i>
                    <input type="text" readonly="true" name="ri_tanggal" class="form-control input-sm" value="{{ date('d-m-Y',strtotime($transferItem->ti_time))}}">
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-3 col-xs-12">
            
            <label class="tebal">Ket</label>
            
        </div>
        <div class="col-md-8 col-sm-9 col-xs-12">
            <div class="form-group">
                <div class="input-icon right">
                    <i class="glyphicon glyphicon-envelope"></i>
                    <input type="text" id="" name="ri_keterangan" class="form-control input-sm" value="{{$transferItem->ti_note}}">
                </div>
            </div>
        </div>
    </div>
    
</form>
<div class="table-responsive">
    <table class="table tabelan table-bordered table-hover dt-responsive" id="detail-req" >
        <thead align="right">
            <tr>
                <th width="10%">Kode</th>
                <th width="50%">Nama Item</th>
                <th width="10%">stok</th>
                <th width="10%">Jumlah</th>
                <th width="10%">Setujui</th>
                <th width="10%">Kirim</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($transferItemDt as $data)
            <tr>
                <td>
                    {{$data->tidt_item}}
                    <input type="hidden" name="tidt_id[]"  class="form-control"
                    value="{{$data->tidt_id}}">
                    <input type="hidden" name="tidt_detail[]"  class="form-control"
                    value="{{$data->tidt_detail}}">
                </td>
                <td>{{$data->i_name}}</td>
                <td>@if($data->s_qty=='')
                    0
                    @else
                {{number_format($data->s_qty,0,'.',',')}}</td>
                @endif
                <td>{{$data->tidt_qty}}</td>
                <td>
                    <input type="text" name="qtyAppr[]"  class="form-control" value="{{$data->tidt_qty_appr}}">
                </td>
                <td>
                    <input id="ty" type="text" name="qtySend[]"  class="form-control qty-terima" value="{{$data->tidt_qty_send}}" >
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
<button class="btn btn-primary" type="button" onclick="simpanApprove()">Simpan</button>
</div>


<script type="text/javascript">
tableReq=$('#detail-req').DataTable();
var item = $('#save_request :input').serialize();
//var data = tableReq.$('input').serialize();

</script>