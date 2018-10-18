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
                  <form method="POST" id="form_proses" name="formProses">
                    {{csrf_field()}}
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
                        <input type="hidden" class="form-control input-sm" name="i_sup" id="i_sup" value="{{$val['sup_id']}}">
                      </div>
                    </div>

                    <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                      <button class="btn btn-primary btn-sm btn-flat" type="button" onclick="kunciSupplier()">
                        <strong>
                          <i class="fa fa-lock" aria-hidden="true"></i>
                        </strong>
                      </button>
                      <button class="btn btn-success btn-sm btn-flat" id="btn-proses-append" type="button" disabled onclick="prosesSupplier()">
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
                        <tbody id="tbody_append">
                          <tr>
                            <td>
                              <input type="text" class="form-control input-sm" readonly="" name="item[]" value="{{$data[0]['i_code']." | ".$data[0]['i_name']}}">
                              <input type="hidden" class="form-control input-sm" name="itemid[]" value="{{$data[0]['item_id']}}" id="i_itemid">
                              <input type="hidden" class="form-control input-sm" name="tgl1[]" id="tgl_1" value="{{$data[0]['tanggal1']}}">
                              <input type="hidden" class="form-control input-sm" name="tgl2[]" id="tgl_2" value="{{$data[0]['tanggal2']}}">
                            </td>
                            <td>
                              <input type="text" class="form-control input-sm" readonly="" name="satuan[]" value="{{$data[0]['satuan']}}">
                              <input type="hidden" class="form-control input-sm" name="satuanid[]" value="{{$data[0]['i_sat1']}}">
                            </td>
                            <td>
                              <input type="text" class="form-control input-sm currency" readonly="" name="stok[]" value="{{$data[0]['stok']}}" style="text-align:right;">
                              <input type="hidden" class="form-control input-sm" readonly="" name="stokRaw[]" value="{{$data[0]['stok']}}" style="text-align:right;">
                            </td>
                            <td>
                              <input type="text" class="form-control input-sm" readonly="" name="remaining[]" value="{{number_format($data[0]['selisih'],0,",",".")}}" style="text-align:right;">
                              <input type="hidden" class="form-control input-sm" readonly="" name="remainingRaw[]" value="{{$data[0]['selisih']}}">
                            </td>
                            <td>
                              <input type="text" class="form-control input-sm currency" name="qtyreq[]" value="{{abs($data[0]['selisih'])}}" style="text-align:right;">
                            </td>
                            <td align="center">
                              -
                            </td>
                          </tr>
                        </tbody>
                      </table> 
                    </div>
                  </form>
                  <div align="right" style="padding-top:10px;">
                    <div id="div_button_save" class="form-group">
                      <button type="button" id="button_submit" class="btn btn-primary" onclick="submit()">Submit Data</button> 
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

    $(document).on('click', '.btn_remove', function(e){
      e.preventDefault();
      var button_id = $(this).attr('id');
      $('#row'+button_id+'').remove();
    });
    
    $('#index_sup').change(function(event) {
      $('#i_sup').val($(this).val());
    });

  });//end jquery

  function kunciSupplier() {
    if ($('#index_sup').is('[disabled=disabled]')) {
      $('#index_sup').attr('disabled', false);
      $('#btn-proses-append').attr('disabled', true);
    }else{
      $('#index_sup').attr('disabled', true);
      $('#btn-proses-append').attr('disabled', false);
    }
  }

  function prosesSupplier() {
    var idsup = $('#index_sup').val();
    var item = $('#i_itemid').val();
    var tgl1 = $('#tgl_1').val();
    var tgl2 = $('#tgl_2').val();
    $.ajax({
      url : baseUrl + "/purchasing/rencanabahanbaku/suggest-item",
      data : {idsup:idsup, item:item, tgl1:tgl1, tgl2:tgl2},
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var i = randString(5);
        var key = 1;
        Object.keys(data.data).forEach(function(){
            $('#tbody_append').append(
                '<tr class="tbl_form_row" id="row'+i+'">'
                  +'<td>'
                    +'<input type="text" class="form-control input-sm" readonly name="item[]" value="'+data.data[key-1].i_code+' | '+data.data[key-1].i_name+'">'
                    +'<input type="hidden" class="form-control input-sm" name="itemid[]" value="'+data.data[key-1].item_id+'">'
                    +'<input type="hidden" class="form-control input-sm" name="tgl1[]" id="tgl_1" value="'+data.data[key-1].tanggal1+'">'
                    +'<input type="hidden" class="form-control input-sm" name="tgl2[]" id="tgl_2" value="'+data.data[key-1].tanggal2+'">'
                  +'</td>'
                  +'<td>'
                    +'<input type="text" class="form-control input-sm" readonly name="satuan[]" value="'+data.data[key-1].satuan+'">'
                    +'<input type="hidden" class="form-control input-sm" name="satuanid[]" value="'+data.data[key-1].i_sat1+'">'
                  +'</td>'
                  +'<td>'
                    +'<input type="text" class="form-control input-sm currency" readonly name="stok[]" value="'+data.data[key-1].stok+'" style="text-align:right;">'
                    +'<input type="hidden" class="form-control input-sm" readonly name="stokRaw[]" value="'+data.data[key-1].stok+'">'
                  +'</td>'
                  +'<td>'
                    +'<input type="text" class="form-control input-sm" readonly name="remaining[]" value="'+formatAngka(data.data[key-1].selisih)+'" style="text-align:right;">'
                    +'<input type="hidden" class="form-control input-sm" readonly name="remainingRaw[]" value="'+data.data[key-1].selisih+'">'
                  +'</td>'
                  +'<td>'
                    +'<input type="text" class="form-control input-sm currency" name="qtyreq[]" value="'+data.data[key-1].abs_selisih+'" style="text-align:right;">'
                  +'</td>'
                  +'<td>'
                   +'<button name="remove" id="'+i+'" class="btn btn-danger btn_remove btn-sm">X</button>'
                  +'</td>'
                +'</tr>');
            i = randString(5);
            key++;
          });
          $(this).maskFunc();
      },
      error: function ()
      {
      },
      async: false
    });
  }

  function submit() 
  {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Proses ke rencana pembelian ?',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $('#button_submit').text('Memproses...');
          $('#button_submit').attr('disabled',true);
          $.ajax({
            url : baseUrl + "/purchasing/rencanabahanbaku/submit-data",
            type: "POST",
            dataType: "JSON",
            data: $('#form_proses').serialize(),
            success: function(response)
            {
              if(response.status == "sukses")
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.success({
                  position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#button_submit').text('Submit Data');
                    $('#button_submit').attr('disabled',false);
                    window.location.href = baseUrl+"/purchasing/rencanabahanbaku/bahan";
                  }
                });
              }
              else
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.error({
                  position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#button_submit').text('Submit Data');
                    $('#button_submit').attr('disabled',false);
                    window.location.href = baseUrl+"/purchasing/rencanabahanbaku/bahan";
                  }
                }); 
              }
            },
            error: function(){
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
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

  function formatAngka(decimal) 
  {
    var angka = parseInt(decimal);
    var fAngka = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++){
      if(i%3 == 0) fAngka += angkarev.substr(i,3)+'.';
    } 
    var hasil = fAngka.split('',fAngka.length-1).reverse().join('');
    return hasil;
  }

  function refreshTabel() 
  {
    $('#data').DataTable().ajax.reload();
  }

</script>
@endsection()