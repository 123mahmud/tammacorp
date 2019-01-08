{{--               <div class="row" style="padding-left: 30px; padding-bottom: 10px">
                <div class="col-md-2 col-sm-2 col-xs-2">
                  <label class="tebal">Tanggal</label>
                </div>

                <div class="col-md-6 col-sm-6 col-xs-6">
                  <div class="form-group" style="display: ">
                    <div class="input-daterange input-group">
                      <input id="tgl1" class="form-control input-sm datepicker1 " name="tgl1" type="text" value="{{ date('d-m-Y') }}">
                      <span class="input-group-addon">-</span>
                      <input id="tgl2" class="input-sm form-control datepicker2" name="tgl2" type="text" value="{{ date('d-m-Y') }}">
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3 row">
                  <button class="btn btn-primary btn-sm btn-flat fa fa-search" type="button" onclick="cariTanggal()">
                  </button>
                  <button class="btn btn-info btn-sm btn-flat fa fa-undo" type="button" onclick="refresh()">
                  </button>
                </div>
              </div> --}}
              <div class="row">
                <button type="button" title="Tambah Rencana" onclick="tambahPlan()" class="btn btn-box-tool" style="margin-bottom: 15px; float: right">
                  <i class="fa fa-plus"></i>&nbsp;Tambah Rencana Produksi
                </button>
                <h4 id="judul-plan" style="padding-bottom: 5px; margin-left: 10px">Tes</h4>
              </div>
              <div class="table-responsive">
                <table class="table tabelan table-bordered table-hover" id="tablePlan">
                  <thead>
                    <th style="width:20%;">Tanggal</th>
                    <th>Jumlah Rencana Produksi</th>
                    <th style="width:20%;">Status SPK</th>
                    <th style="width:14%; text-align: center;">Aksi</th>
                  </thead>
                  <tbody id="table-search">     
                           
                  <?php $x=0; ?>
                  @if(count($plan) > 0)
                    <input type="text" class="hidden" name="pp_item" id="pp_item" value="{{$id}}">
                    @foreach($plan as $pn)
                      
                      @if($pn->pp_isspk == 'N')
                      <tr>
                        <td> 
                          <span class="hide">{{$pn->pp_date}}</span>
                          <input id="tanggal{{$x}}" class="form-control" readonly name="tanggal{{$x}}" type="text" value="{{ date('d-m-Y', strtotime($pn->pp_date)) }}">
                        </td>
                        <td>
                          <input name="pp_qty{{$x}}" type="number" class="form-control" style="text-align:right;"
                          value="{{ $pn->pp_qty }}">
                        </td>
                        <td>
                          <i class="fa fa-times"></i>  Rencana
                        </td>
                        <td>
                          <!--   -->
                          <button type="button" class="btn btn-info pull-right"  onclick="tambahPlan()" style="margin-bottom: 5px; margin-right: 15px">
                            <i class="glyphicon glyphicon-plus"></i>
                          </button>
                          <button type="button" class="btn btn-danger hapus" onclick="hapusPlan(this)" disabled="true">
                            <i class="glyphicon glyphicon-minus"></i>
                          </button>
                        </td>
                      </tr>
                      <?php $x++; ?>
                      @endif
                      
                      @if($pn->pp_isspk == 'Y')
                      <tr>
                        <td> 
                          <span class="hide">{{$pn->pp_date}}</span>
                          <input id="tanggal" class="form-control" name="tanggal" type="text" value="{{ date('d-m-Y', strtotime($pn->pp_date)) }}" readonly="">
                        </td>
                        <td>
                          <input name="pp_qty" type="number" class="form-control" style="text-align:right;"
                          value="{{ $pn->pp_qty }}" readonly="">
                        </td>
                        <td>
                          <i class="fa fa-check"></i>  SPK
                        </td>
                        <td>
                          <button type="button" class="btn btn-danger hapus" disabled="true" onclick="hapusPlan(this)">
                            <i class="glyphicon glyphicon-minus"></i>
                          </button>
                          <button type="button" class="btn btn-info" onclick="tambahPlan()">
                            <i class="glyphicon glyphicon-plus"></i>
                          </button> 
                        </td>
                      </tr>
                      @endif
                      
                      @if($pn->pp_isspk == 'P')
                      <tr>
                        <td> 
                          <span class="hide">{{$pn->pp_date}}</span>
                          <input id="tanggal" class="form-control datepicker3" name="tanggal" type="text" value="{{ date('d-m-Y', strtotime($pn->pp_date)) }}" readonly="">
                        </td>
                        <td>
                          <input name="pp_qty" type="number" class="form-control" style="text-align:right;"
                          value="{{ $pn->pp_qty }}" readonly="">
                        </td>
                        <td>
                          <i class="fa fa-check"></i>  Produksi 
                        </td>
                        <td>
                          <button type="button" class="btn btn-info pull-right" onclick="tambahPlan()" style="margin-bottom: 5px; margin-right: 15px"><i class="glyphicon glyphicon-plus"></i></button>
                          <button type="button" class="btn btn-danger hapus" disabled="true" onclick="hapusPlan(this)"><i class="glyphicon glyphicon-minus"></i></button>
                        </td>
                      </tr>
                      @endif
                      
                    @endforeach

                  @else
                    <?php $x = 1; ?>
                    <tr>
                      <input type="text" class="hidden" name="pp_item" id="pp_item" value="{{$id}}">
                      <td>
                        <span class="hide">{{date('d-m-Y')}}</span>
                        <input type="text" name="tanggal0" readonly class="form-control datepicker3" value="{{ date('d-m-Y') }}">
                      </td>
                      <td>
                        <input name="pp_qty0" type="number" class="form-control input-sm" style="text-align:right;">
                      </td>
                      <td>
                        <i class="fa fa-times"></i>  Rencana
                      </td>
                      <td>
                        <button type="button" class="btn btn-info pull-right" onclick="tambahPlan()" style="margin-bottom: 5px; margin-right: 15px"><i class="glyphicon glyphicon-plus"></i></button>
                        <button type="button" class="btn btn-danger hapus" onclick="hapusPlan(this)" disabled="true"><i class="glyphicon glyphicon-minus"></i></button>
                      </td>
                    </tr>
                  @endif
                  <input type="text" class="hidden" name="rowPlan" id="rowPlan" value="{{$x}}">
                  </tbody>
                            
                </table>
              </div>

              <div style="border-top: 1px solid #444;">
                <table  style="margin-top: 15px" class="tebal">
                  <tr style="margin-top: 10px">
                    <td width="100px">Produksi</td>
                    <td style="text-align: right">{{ $spk['P'] }}</td>
                  </tr>
                  <tr style="margin-top: 10px">
                    <td>SPK</td>
                    <td style="text-align: right">{{ $spk['Y'] }}</td>
                  </tr>
                  <tr style="margin-top: 10px">
                    <td>Rencana</td>
                    <td style="text-align: right">{{ $spk['N'] }}</td>
                  </tr>
                  <tr style="border-top: 1px solid #444; margin-top: 10px">
                    <td>Total</td>
                    <td style="text-align: right">{{ $spk['P'] + $spk['N'] + $spk['Y'] }}</td>
                  </tr>
                </table>
              </div>


<script type="text/javascript">

  tablePlan=$('#tablePlan').DataTable({
    "responsive":true,
    "pageLength": 10,
    "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
    "language": {
        "searchPlaceholder": "Cari Data",
        "emptyTable": "Tidak ada data",
        "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
        "infoFiltered" : "",
        "sSearch": '<i class="fa fa-search"></i>',
        "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
        "infoEmpty": "",
        "zeroRecords": "Data tidak ditemukan",
        "paginate": {
                "previous": "Sebelumnya",
                "next": "Selanjutnya",
            }
      },

  });
  var date = new Date();
  var newdate = new Date(date);

  newdate.setDate(newdate.getDate()-3);
  var nd = new Date(newdate);

  $('.datepicker1').datepicker({
    autoclose: true,
    format:"dd-mm-yyyy",
    endDate: 'today'
  }).datepicker("setDate", nd);  

  $('.datepicker2').datepicker({
      format:"dd-mm-yyyy",
      endDate: 'today'
    });    

  $('.datepicker2').on('changeDate', function(ev){
    $(this).datepicker('hide');
  });

  $.fn.dataTableExt.afnFiltering.push(
      function( settings, data, dataIndex ) {
        if($('#tgl1').val() != undefined || $('#tgl2').val() != undefined){
          var tgl1 = $('#tgl1').val().toString();
          var y = tgl1.slice(-4);
          var m = tgl1.slice(3,5);
          var d = tgl1.slice(0,2);
          var tgl2 = $('#tgl2').val().toString();
          var y2 = tgl2.slice(-4);
          var m2 = tgl2.slice(3,5);
          var d2 = tgl2.slice(0,2);
          if(y == '' || m == '' || d == ''){
            var min = NaN;
          }else{
            var min = new Date(y,m-1,d);  
          }
          if(y2 == '' || m2 == '' || d2 == ''){
            var max = NaN;
          }else{
            var max = new Date(y2,m2-1,d2);
            max.setDate(max.getDate()+1);
          }
        }else{
          var min = NaN;
          var max = NaN;
        }
        var age = new Date(data[0].slice(0,10));
        if ( ( isNaN( min ) && isNaN( max ) ) ||
             ( isNaN( min ) && age <= max ) ||
             ( min <= age   && isNaN( max ) ) ||
             ( min <= age   && age <= max ) )
        {
            return true;
        }
      
      return false;
    });

  function tambahPlan() {         
    var Hapus = '<button type="button" class="btn btn-info pull-right" onclick="tambahPlan()" style="margin-bottom: 5px; margin-right: 15px"><i class="glyphicon glyphicon-plus"></i></button><button type="button" class="btn btn-danger hapus" onclick="hapusPlan(this)"><i class="glyphicon glyphicon-minus"></i></button>';
    var rowPlan = parseInt($("#rowPlan").val());
      tablePlan.row.add([
        '<span class="hide">{{date('Y-m-d')}}</span><input type="text" readonly name="tanggal'+rowPlan+'" class="form-control" readonly value="{{ date('d-m-Y') }}">',
        '<input name="pp_qty'+rowPlan+'" type="number" class="form-control input-sm" style="text-align:right;">',
        '<i class="fa fa-times"></i>  Rencana',
        Hapus
      ]);
    tablePlan.draw();
    rowPlan=rowPlan+1;
    $("#rowPlan").val(rowPlan);
  
    $('.datepicker3').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy",
      endDate: 'today',
      defaultDate: new Date()
      });
    
  }

  function hapusPlan(a){
    var par = a.parentNode.parentNode;
      tablePlan.row(par).remove().draw(false);
  }

  function cariTanggal(){
      tablePlan.draw();
  } 

  function refresh(){
    $('#tgl1').val(nd);
    $('#tgl2').val("setDate");
      tablePlan.draw();
  }

</script>