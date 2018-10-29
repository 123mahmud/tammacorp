
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
                                      <input disabled type="text" id="" name="ri_keterangan" class="form-control input-sm" value="{{$transferItem->ti_note}}">
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
                             <th width="10%"> Setujui</th>                            
                             <th width="10%"> Kirim</th> 
                             
                            </tr>
                           </thead> 
                           <tbody>
                              @foreach($transferItemDt as $data)
                                    <tr>
                                      <td>
                                          {{$data->i_code}}
                                          <input type="hidden" name="tidt_item[]"  class="form-control" value="{{$data->tidt_item}}">
                                          <input type="hidden" name="tidt_id[]"  class="form-control" 
                                          value="{{$data->tidt_id}}">
                                          <input type="hidden" name="tidt_detail[]"  class="form-control" 
                                          value="{{$data->tidt_detail}}">
                                      </td>
                                      <td>{{$data->i_name}}</td>
                                      <td class="text-right">@if($data->s_qty=='')
                                            0
                                          @else
                                            {{$data->s_qty}}</td>
                                          @endif
                                      <td class="text-right">
                                         <input id="qty-{{$data->i_id}}" type="hidden" name="qty[]"  class="form-control" value="{{$data->tidt_qty}}">
                                        {{$data->tidt_qty}}</td>
                                      <td class="text-right">
                                        <input onkeyup="aktifSend('{{$data->i_id}}');HitungQtyApprove('{{$data->i_id}}');" id="qtyAppr-{{$data->i_id}}" type="number" name="qtyAppr[]"  class="form-control text-right" value="{{$data->tidt_qty_appr}}">
                                      </td>
                                      <td class="text-right">
                                        <input onkeyup="HitungQtySend('{{$data->i_id}}');" id="qtySend-{{$data->i_id}}" 
                                        @if($data->tidt_qty_appr=='' && $data->tidt_qty_send=='') readonly="" @endif 
                                        type="number" name="qtySend[]"  class="form-control text-right" value="{{$data->tidt_qty_send}}" >
                                      </td>
                                    </tr>
                              @endforeach
                           </tbody>
                          </table>
                        </div>

                                       
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary simpanApprove" type="button" onclick="simpanApprove()">Simpan</button> 
                  </div>
                    
                  
<script type="text/javascript">
tableReq=$('#detail-req').DataTable();
var item = $('#save_request :input').serialize();
//var data = tableReq.$('input').serialize();
function aktifSend(id) {  
  var kondisi=$('#qtyAppr-'+id).val();
  if(kondisi!=''){
    $('#qtySend-'+id).removeAttr('readonly',false);
  }
  else if(kondisi==''){
    $('#qtySend-'+id).attr('readonly',true);
    $('#qtySend-'+id).val('');
  
  }
  
}

function HitungQtyApprove(id){
  var qty = $('#qty-'+id).val();
  var qtyAppr = $('#qtyAppr-'+id).val();
  if(parseFloat(qty)<parseFloat(qtyAppr)){
    toastr.warning('Jumlah Approve Melebihi Permintaan');
    $('#qtyAppr-'+id).val('');
      $('#qtySend-'+id).attr('readonly',true);
  }
}

function HitungQtySend(id){
  var qtyAppr = $('#qtyAppr-'+id).val();
  var qtySend = $('#qtySend-'+id).val();
  if(parseFloat(qtyAppr)<parseFloat(qtySend)){
    toastr.warning('Jumlah Kirim Melebihi Approve');
    $('#qtySend-'+id).val('');
  }
}
   
</script>