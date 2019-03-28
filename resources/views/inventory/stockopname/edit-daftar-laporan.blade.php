@extends('main')
@section('content')
<div id="page-wrapper">
   <!--BEGIN TITLE & BREADCRUMB PAGE-->
   <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
      <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
         <div class="page-title">Stock Opname</div>
      </div>
      <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
         <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i
         class="fa fa-angle-right"></i>&nbsp;&nbsp;
      </li>
      <li><i></i>&nbsp;Inventory&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Stock Opname</li>
   </ol>
   <div class="clearfix">
   </div>
</div>
<div class="page-content fadeInRight">
   <div id="tab-general">
      <div class="row mbl">
         <div class="col-lg-12">
            <div class="col-md-12">
               <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
               </div>
            </div>
            <ul id="generalTab" class="nav nav-tabs">
               <li class="active"><a href="#alert-tab" data-toggle="tab">Edit Stock Opname</a></li>
            </ul>
            <div id="generalTabContent" class="tab-content responsive">
               <div id="alert-tab" class="tab-pane fade in active">
                  <div class="row">
                     <form id="opname">
                        <div class="col-md-2 col-sm-12 col-xs-12">
                           <label class="tebal">Pemilik Item :</label>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                           <div class="form-group" align="pull-left">
                              <select class="form-control input-sm" id="pemilik" name="o_comp"
                                 style="width: 100%;" onchange="clearTable()">
                                 <option class="form-control pemilik-gudang" value="{{ $dataIsi[0]->cg_id }}">
                                 - {{ $dataIsi[0]->cg_cabang }}</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12">
                           <label class="tebal">Nama Staff :</label>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                           <div class="form-group" align="pull-left">
                              <input type="text" readonly="" class="form-control input-sm" name="" value="{{$staff['nama']}}">
                              <input type="hidden" readonly="" class="form-control input-sm" name="o_staff" value="{{$staff['id']}}">
                           </div>
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12">
                           <label class="tebal">Tanggal Opname :</label>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                           <div class="form-group" align="pull-left">
                              <input type="text" class="form-control input-sm datepicker" name="o_date" value="{{ date('d-m-Y') }}">
                           </div>
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12">
                           <label class="tebal">Kode Opname :</label>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                           <div class="form-group" align="pull-left">
                              <input type="text" readonly="" class="form-control input-sm" name="o_nota" value="{{$dataIsi[0]->o_nota}}">
                           </div>
                        </div>
                        
                     </form>
                     <form id="tbOpname">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tabelOpname">
                              <thead>
                                 <tr>
                                    <th width="21%">Kode - Nama Item</th>
                                    <th width="23%">Qty Sistem</th>
                                    <th width="5%">Satuan</th>
                                    <th width="23%">Qty Real</th>
                                    <th width="23%">Opname</th>
                                    <th width="5%">Aksi</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @for ($i = 0; $i < count($dataItem['data_isi']) ; $i++)
                                 <tr>
                                    <td>{{ $dataItem['data_isi'][$i]['i_code'] }} - {{ $dataItem['data_isi'][$i]['i_name'] }}
                                       <input type="hidden" name="i_id[]" id="" class="i_id" value="{{ $dataItem['data_isi'][$i]['i_id'] }}">
                                    </td>
                                    <td>
                                       <input type="text" name="qty[]" id="s-qtykw" class="form-control text-right" readonly value="{{ number_format($dataItem['data_stok'][$i]->qtyStok,2,'.',',') }}">
                                    </td>
                                    <td>
                                       <input type="text" name="" id="s-qtykw" class="form-control" readonly value="{{ $dataItem['data_isi'][$i]['m_sname'] }}"><input type="hidden" name="satuan_id[]" id="s-qtykw" class="form-control text-right" readonly value="{{ $dataItem['data_isi'][$i]['i_sat1'] }}">
                                    </td>
                                    <td>
                                       <input type="text" name="real[]" id="real" class="form-control text-right qty-real-{{ $dataItem['data_isi'][$i]['i_id'] }} ' currenc" onkeyup="hitungOpname({{ $dataItem['data_isi'][$i]['i_id'] }},{{ $dataItem['data_stok'][$i]->qtyStok }})" value="{{ $dataItem['data_isi'][$i]['od_real'] }}">
                                    </td>
                                    <td>
                                       <input type="text" name="opname[]" id="opnameKw" class="form-control text-right opnameKw-{{ $dataItem['data_isi'][$i]['i_id'] }} currenc" readonly value="{{$dataItem['data_stok'][$i]->qtyStok + $dataItem['data_isi'][$i]['od_real']}}">
                                    </td>
                                    <td>
                                       @if ($dataIsi[0]->o_confirm == '')
                                       <div class="text-center">
                                          <button type="button" class="btn btn-danger hapus btn-sm" onclick="hapus(this)"><i class="fa fa-trash-o"></i>
                                          </button>
                                       </div>
                                       @elseif ($dataIsi[0]->o_confirm == 'WT')
                                       <div class="text-center">
                                          <button type="button" class="btn btn-danger hapus btn-sm" onclick="hapus(this)"><i class="fa fa-trash-o"></i>
                                          </button>
                                       </div>
                                       @elseif ($dataIsi[0]->o_confirm == 'AP')
                                       <div class="text-center">
                                          <button type="button" disabled="" class="btn btn-danger hapus btn-sm"><i class="fa fa-trash-o"></i>
                                          </button>
                                       </div>
                                       @endif
                                    </td>
                                 </tr>
                                 @endfor
                              </tbody>
                           </table>
                        </div>
                     </form>
                     <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;margin-bottom: 5px;">
                        @if ($dataIsi[0]->o_confirm == '' )
                           <button class="btn btn-success kirim-opname" style="float: right" type="button" onclick="updateStock({{ $dataIsi[0]->o_id }})">Update Laporan</button>
                        @elseif ($dataIsi[0]->o_confirm == 'WT')
                           <button class="btn btn-success kirim-opname" style="float: right" type="button" onclick="updateStock({{ $dataIsi[0]->o_id }})">Update Pengajuan</button>
                        @elseif ($dataIsi[0]->o_confirm == 'AP')
                           <button class="btn btn-success kirim-opname" style="float: right" type="button" onclick="opnameStock({{ $dataIsi[0]->o_id }})">Opname Stock</button>
                        @endif
                     </div>
                     {{--   onclick="simpanOpname()" --}}
                  </div>
               </div>
               
            </div>
         </div>
      </div>
   </div>
   
   
</div>
</div>
@endsection
@section("extra_scripts")
<script type="text/javascript">

   $(document).ready(function () {
      var extensions = {
          "sFilterInput": "form-control input-sm",
          "sLengthSelect": "form-control input-sm"
      }
      // Used when bJQueryUI is false
      $.extend($.fn.dataTableExt.oStdClasses, extensions);
      // Used when bJQueryUI is true
      $.extend($.fn.dataTableExt.oJUIClasses, extensions);

      tableOpname = $('#tabelOpname').DataTable();

      $('.currenc').inputmask("currency", {
         radixPoint: ".",
         groupSeparator: ".",
         digits: 2,
         autoGroup: true,
         prefix: '', //Space after $, this will not truncate the first character.
         rightAlign: false,
         oncleared: function () { self.Value(''); }
      });

   });

   function hitungOpname(id, qty){
      var real = $('.qty-real-'+id).val();
      real = parseFloat(real.replace(/\,/g,''));
      qty = parseFloat(qty).toFixed(2);
      console.log(qty);
      real = parseFloat(real).toFixed(2);
      console.log(real);
      var opname = real - qty;
      console.log(opname);
      opname = opname.toFixed(2);
      $('.opname-'+id).val(opname);
      //kw
      var opnameKw = real - qty;
      $('.opnameKw-'+id).val(opnameKw);
   }

   function updateStock(id)
   {
      $('.kirim-opname').attr('disabled', 'disabled');
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });
      var a = $('#opname :input').serialize();
      var b = tableOpname.$('input').serialize();
      $.ajax({
         url : baseUrl + '/inventory/namaitem/updateLap/' + id,
         type: 'GET',
         data: a + '&' + b,
         success: function (response, nota) 
         {
            if (response.status == 'sukses') 
            {
               window.open = baseUrl + '/inventory/stockopname/print_stockopname';
               tableOpname.row().clear().draw(false);
               var inputs = document.getElementsByClassName('i_id'),
                  names = [].map.call(inputs, function (input) {
                     return input.value;
                  });
               tamp = names;
               var nota = response.nota.o_nota;
               toastr.info('Berhasl update!');
               window.location.href = baseUrl + "/inventory/stockopname/opname";
               $('.kirim-opname').removeAttr('disabled', 'disabled');
            } 
            else 
            {
               toastr.warning('Mohon melengkapi data!');
               $('.kirim-opname').removeAttr('disabled', 'disabled');
            }
         }
      });
   }

   function hapus(a){
      var par = a.parentNode.parentNode;
      tableOpname.row(par).remove().draw(false);

      var inputs = document.getElementsByClassName( 'i_id' ),
      names  = [].map.call(inputs, function( input ) {
         return input.value;
      });
      tamp = names;
   }

   function opnameStock(id)
   {
      $('.kirim-opname').attr('disabled', 'disabled');
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });
      var a = $('#opname :input').serialize();
      var b = tableOpname.$('input').serialize();
      $.ajax({
         url : baseUrl + '/inventory/namaitem/ubahstok/' + id,
         type: 'GET',
         data: a + '&' + b,
         success: function (response, nota) 
         {
            if (response.status == 'sukses') 
            {
               window.open = baseUrl + '/inventory/stockopname/print_stockopname';
               tableOpname.row().clear().draw(false);
               var inputs = document.getElementsByClassName('i_id'),
                  names = [].map.call(inputs, function (input) {
                     return input.value;
                  });
               tamp = names;
               var nota = response.nota.o_nota;
               toastr.info('Berhasl update stok!');
               window.location.href = baseUrl + "/inventory/stockopname/opname";
               $('.kirim-opname').removeAttr('disabled', 'disabled');
            } 
            else 
            {
               toastr.warning('Mohon melengkapi data!');
               $('.kirim-opname').removeAttr('disabled', 'disabled');
            }
         }
      });
   }
   
</script>
@endsection