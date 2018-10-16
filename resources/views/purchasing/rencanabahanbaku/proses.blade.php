@extends('main')
@section('content')
<style type="text/css">
  .ui-autocomplete { z-index:2147483647; }
  .error { border: 1px solid #f00; }
  .valid { border: 1px solid #8080ff; }
  .has-error .select2-selection {
    border: 1px solid #f00 !important;
  }
  .has-valid .select2-selection {
    border: 1px solid #8080ff !important;
  }
</style>
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Proses Rencana pembelian bahan baku</div>
    </div>
    
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Proses Rencana pembelian bahan baku</li>
    </ol>

    <div class="clearfix"></div>
  </div>
  <!--END TITLE & BREADCRUMB PAGE-->
  <div class="page-content fadeInRight">
    <div id="tab-general">
      <div class="row mbl">
        <div class="col-lg-12">
          <div class="col-md-12">
            <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
            </div>
          </div>
      
          <ul id="generalTab" class="nav nav-tabs">
            <li class="active"><a href="#alert-tab" data-toggle="tab">Proses Rencana pembelian bahan baku</a></li>
          </ul>
          
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                  <div class="col-md-2 col-sm-3 col-xs-12">
                    <label class="tebal">Supplier</label>
                  </div>

                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="form-group">
                      <select class="form-control input-sm" name="supplier" id="index_sup">
                        @foreach($d_sup as $val)
                          <option value="{{$val['sup_id']}}">{{$val['sup_txt']}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                    <button class="btn btn-primary btn-sm btn-flat" type="button" onclick="kunciSupplier()">
                      <strong>
                        <i class="fa fa-lock" aria-hidden="true"></i>
                      </strong>
                    </button>
                    <button class="btn btn-success btn-sm btn-flat" type="button" onclick="prosesSupplier()">
                      <strong>
                        <i class="fa fa-check" aria-hidden="true"></i>
                      </strong>
                    </button>
                    <a href="{{ url('purchasing/rencanabahanbaku/bahan') }}" class="btn btn-default btn-sm btn-flat">
                      <i class="fa fa-arrow-left"></i>
                    </a>
                  </div>

                  <div class="table-responsive">
                    <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
                      <thead>
                        <tr>
                          <th style="text-align: center; width: 35%;">Nama Item</th>
                          <th style="text-align: center; width: 15%;">Satuan</th>
                          <th style="text-align: center; width: 15%;">Stok</th>
                          <th style="text-align: center; width: 15%;">Kekurangan</th>
                          <th style="text-align: center; width: 15%;">Qty</th>
                          <th style="text-align: center; width: 5%;">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <input type="text" class="form-control input-sm" readonly="" name="item[]" value="{{$data[0]['i_name']." | ".$data[0]['i_code']}}">
                            <input type="hidden" class="form-control input-sm" name="itemid[]" value="{{$data[0]['item_id']}}">
                            <input type="hidden" class="form-control input-sm" name="tgl1[]" id="tgl_1" value="{{$data[0]['tanggal1']}}">
                            <input type="hidden" class="form-control input-sm" name="tgl2[]" id="tgl_2" value="{{$data[0]['tanggal2']}}">
                          </td>
                          <td>
                            <input type="text" class="form-control input-sm" readonly="" name="satuan[]" value="{{$data[0]['satuan']}}">
                            <input type="hidden" class="form-control input-sm" name="satuanid[]" value="{{$data[0]['i_sat1']}}">
                          </td>
                          <td>
                            <input type="text" class="form-control input-sm currency" readonly="" name="stok[]" value="{{$data[0]['stok']}}">
                          </td>
                          <td>
                            <input type="text" class="form-control input-sm" readonly="" name="remaining[]" value="{{number_format($data[0]['selisih'],0,",",".")}}">
                          </td>
                          <td>
                            <input type="text" class="form-control input-sm currency" name="qtyreq[]" value="{{abs($data[0]['selisih'])}}">
                          </td>
                          <td align="center">
                            -
                          </td>
                        </tr>
                      </tbody>
                    </table> 
                  </div> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--END PAGE WRAPPER-->
<!-- modal-detail -->
@include('purchasing.rencanabahanbaku.modal-detail')
@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script src="{{ asset("js/inputmask/inputmask.jquery.js") }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    var extensions = {
        "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);
    
    $.fn.maskFunc = function(){
      $('.currency').inputmask("currency", {
        radixPoint: ",",
        groupSeparator: ".",
        digits: 0,
        autoGroup: true,
        prefix: '', //Space after $, this will not truncate the first character.
        rightAlign: false,
        oncleared: function () { self.Value(''); }
      });
    }
    $(this).maskFunc();

    var date = new Date();
    var newdate = new Date(date);

    newdate.setDate(newdate.getDate()-30);
    var nd = new Date(newdate);

    $('.datepicker1').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy",
      endDate: 'today'
    }).datepicker("setDate", nd);

    $('.datepicker2').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy",
      endDate: 'today'
    });//datepicker("setDate", "0");
    
  });//end jquery

  /*function lihatRencanaByTanggal()
  {
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    var tampil = $('#tampil_data').val();
    $('#data').dataTable({
      destroy: true,
      processing: true,
      serverSide: true,
      ajax : {
        url: baseUrl + "/purchasing/rencanabahanbaku/get-rencana-bytgl/"+tgl1+"/"+tgl2,
        type: 'GET'
      },
      "columns" : [
        {"data" : "i_name", "width" : "30%"},
        {"data" : "qtyTotal", "width" : "15%"},
        {"data" : "stok", "width" : "15%"},
        {"data" : "kekurangan", "width" : "15%"},
        {"data" : "qtyorderplan", "width" : "15%"},
        {"data" : "action", orderable: false, searchable: false, "width" : "10%"}
      ],
      "responsive": true,
      "lengthMenu": [[-1], ["All"]],
      "language": {
        "searchPlaceholder": "Cari Data",
        "emptyTable": "Tidak ada data",
        "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
        "sSearch": '<i class="fa fa-search"></i>',
        "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
        "infoEmpty": "",
        "paginate": {
              "previous": "Sebelumnya",
              "next": "Selanjutnya",
        }
      }
    });
  }*/

  function kunciSupplier() {
    if ($('#index_sup').is('[disabled=disabled]')) {
      $('#index_sup').attr('disabled', false);
    }else{
      $('#index_sup').attr('disabled', true);
    }
  }

  function prosesSupplier() {
    var idsup = $('#index_sup').val();
    var tgl1 = $('#tgl_1').val();
    var tgl2 = $('#tgl_2').val();
    $.ajax({
      url : baseUrl + "/purchasing/rencanabahanbaku/suggest-item",
      data : {idsup:idsup, tgl1:tgl1, tgl2:tgl2},
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
      },
      error: function ()
      {
      },
      async: false
    });
  }

  function gantiStatus(id, isPO) {
    iziToast.question({
      timeout: 20000,
      close: false,
      overlay: true,
      displayMode: 'once',
      // id: 'question',
      zindex: 999,
      title: 'Ubah Status',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
            $.ajax({
              type: "POST",
              url: baseUrl + "/purchasing/rencanabahanbaku/ubah-status-spk",
              data: {id:id, isPO:isPO, "_token": "{{ csrf_token() }}"},
              success: function(response){
                if(response.status == "sukses")
                {
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.success({
                    position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                    title: 'Pemberitahuan',
                    message: response.pesan,
                    onClosing: function(instance, toast, closedBy){
                      refreshTabel();
                    }
                  });
                }
                else
                {
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.error({
                    position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                    title: 'Pemberitahuan',
                    message: response.pesan,
                    onClosing: function(instance, toast, closedBy){
                      refreshTabel();
                    }
                  }); 
                }
              },
              error: function(){
                iziToast.warning({
                  icon: 'fa fa-times',
                  message: 'Terjadi Kesalahan!'
                });
              },
              async: false
            });
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function randString(angka) 
  {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < angka; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  }

  function refreshTabel() 
  {
    $('#data').DataTable().ajax.reload();
  }

</script>
@endsection()