
                  <form action="get" id="save_penerimaan">
                            <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">

                                <div class="col-md-4 col-sm-3 col-xs-12"> 
                              
                                  <label class="tebal">No Transfer</label>
                                  
                                </div>
                                <div class="col-md-8 col-sm-9 col-xs-12">
                                  <div class="form-group">
                                      <input type="hidden" readonly name="ti_id" value="{{$transferItem->ti_id}}" class=" input-sm">
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
                                      <input type="text" id="" readonly="true" name="admin" class="form-control input-sm"
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
                                      <input disabled="" type="text" id="" name="ri_keterangan" class="form-control input-sm" value="{{$transferItem->ti_note}}">
                                    </div>                                
                                  </div>
                                </div>
                            </div>
                       
                      </form>
                        <div class="table-responsive">
                          <table class="table tabelan table-bordered table-hover dt-responsive" id="detail-terima" >
                           <thead align="right">
                            <tr>
                              <th width="10%">Kode</th>
                             <th width="50%">Nama Item</th>
                             <th width="10%">stok</th>
                             <th width="10%">Jumlah Kirim</th>
                             <th width="10%">Jumlah Terima</th>                              
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
                                            {{number_format($data->s_qty,0,'.',',')}}</td>
                                          @endif
                                      <td class="text-right">{{$data->tidt_qty_send}}
                                          <input type="hidden" value="{{$data->tidt_qty_send}}" id="qtySend-{{$data->i_id}}">
                                      </td>                                     
                                      <td>
                                        <input id="qtyreceived-{{$data->i_id}}"
                                        onkeyup="HitungQtyRecieved('{{$data->i_id}}');cekQty(this, event);" type="text" name="qtyRecieved[]"  class="form-control text-right terima currency-x" value="{{$data->tidt_qty_received}}">
                                      </td>
                                    </tr>
                              @endforeach
                           </tbody>
                          </table>
                        </div>

                                       
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                {{--   @if(Auth::user()->punyaAkses('Ritail Transfer','ma_insert')) --}}
                    <button class="btn btn-primary simpanPenerimaan" type="button" onclick="simpaPenerimaan()">Simpan</button> 
               {{--    @endif --}}
                  </div>
                    
                  
<script type="text/javascript">
tablePenerimaan=$('#detail-terima').DataTable();
var item = $('#save_penerimaan :input').serialize();

  function HitungQtyRecieved(id){  
    var qtySend = $('#qtySend-'+id).val();
    var qtyRecieved = $('#qtyreceived-'+id).val();

    if(parseFloat(qtySend)<parseFloat(qtyRecieved)){
      toastr.warning('Jumlah Terima Melebihi Approve');
      $('#qtyreceived-'+id).val('');
    }
  }

  // function cekQty(inField, e){
  //   var a = 0;
  //   $('input.discpercent:text').each(function(evt){
  //     var getIndex = a;
  //     var dataInput = $('input.terima:text:eq('+getIndex+')').val();
  //     var dataInput1 = $('input.discvalue:text:eq('+getIndex+')').val();

  //     }
  //   a++;
  // }

</script>