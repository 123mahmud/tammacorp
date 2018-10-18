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
          <div class="page-title">Form Order Pembelian</div>
      </div>
      <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
          <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
          <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
          <li class="active">Order Pembelian</li><li><i class="fa fa-angle-right"></i>&nbsp;Form Order Pembelian&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
      </ol>
      <div class="clearfix">
      </div>
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
              <li class="active"><a href="#alert-tab" data-toggle="tab">Form Order Pembelian</a></li>
            </ul>

            <div id="generalTabContent" class="tab-content responsive">
              <div id="alert-tab" class="tab-pane fade in active">
                <div class="row">
                
                  <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">  
                    <div class="col-md-5 col-sm-6 col-xs-8" >
                      <h4>Form Order Pembelian</h4>
                    </div>

                    <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                      <a href="{{ url('purchasing/orderpembelian/order') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                    </div>
                  </div>
             
            
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <form method="POST" id="form_create_po" name="formCreatePo">
                      {{ csrf_field() }}
                      <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">
                        
                        <div class="col-md-3 col-sm-12 col-xs-12">
                          <label class="tebal">No PO</label>
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <input type="text" readonly="" class="form-control input-sm" name="kodePo" value="{{$codePO}}">
                          </div>
                        </div>
                        
                        <div class="col-md-3 col-sm-12 col-xs-12">
                          <label class="tebal">Staff</label>
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <input type="text" readonly="" class="form-control input-sm" name="namaStaff" value="{{$staff['nama']}}">
                            <input type="hidden" readonly="" class="form-control input-sm" name="idStaff" value="{{$staff['id']}}">
                          </div>
                        </div>
                        
                        <div class="col-md-3 col-sm-12 col-xs-12">
                          <label class="tebal">Tanggal Order Pembelian</label>
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <input id="tanggalPo" class="form-control input-sm datepicker2 " name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                          </div> 
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                          <label class="tebal">Cara Pembayaran</label>
                        </div>
  
                        <div class="col-md-3 col-sm-12 col-xs-12">
                          <div class="form-group">
                              <select class="form-control input-sm" name="methodBayar" id="method_bayar">
                                  <option value="CASH">Tunai</option>
                                  <option value="DEPOSIT">Deposit</option>
                                  <option value="CREDIT">Tempo</option>
                              </select>
                          </div>  
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                          <label class="tebal">Kode Rencana</label>
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                          <div class="form-group" id="divSelectPlan">
                            <select class="form-control input-sm" id="cari_kode_plan" name="cariKodePlan" style="width: 100%;">
                              <option value=""> - Pilih Kode Rencana</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                          <label class="tebal">Suplier</label>
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                          <div class="form-group" id="divSelectSup">
                            <select class="form-control input-sm" id="cari_sup" name="cariSup" style="width: 100%;">
                              <option value=""> - Pilih Supplier</option>
                            </select>
                          </div>
                        </div>

                        <div id="appending"></div>

                      </div>

                      <div class="table-responsive">
                          <table id="tabel-form-po" class="table tabelan table-bordered table-striped">
                            <thead>
                              <tr>
                                <th style="text-align: center;" width="5%">No</th>
                                <th width="25%">Kode | Barang</th>
                                <th width="10%">Qty</th>
                                <th width="7%">Satuan</th>
                                <th width="13%">Harga Prev</th>
                                <th width="15%">Harga Satuan</th>
                                <th width="15%">Total</th>
                                <th width="10%">Stok Gudang</th>
                                <th style="text-align: center;" width="5%">Aksi</th>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                      </div>

                      <div class="col-md-3 col-md-offset-9 col-sm-6 col-sm-offset-6 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top: 10px;">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <label class="tebal">Total Harga</label>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <input type="text" readonly="" id="total_gross" class="input-sm form-control" name="totalGross" readonly style="text-align:right;">
                          </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <label class="tebal">Potongan Harga</label>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <input type="text" class="input-sm form-control numberinput" id="potongan_harga" name="potonganHarga" readonly style="text-align:right;">
                          </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <label class="tebal">Diskon</label>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <input type="text" class="input-sm form-control numberinput" id="diskon_harga" name="diskonHarga" readonly style="text-align:right;">
                          </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <label class="tebal">PPN</label>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <input type="text" class="input-sm form-control numberinput" id="ppn_harga" name="ppnHarga" readonly style="text-align:right;">
                          </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <label class="tebal">Total</label>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <input type="text" readonly="" class="input-sm form-control" id="total_nett" name="totalNett" style="text-align:right;">
                          </div>
                        </div>

                      </div>

                      <div align="right" style="padding-top:10px;">
                        <div id="div_button_save" class="form-group">
                          <button type="button" id="button_save" class="btn btn-primary" onclick="simpanPo()">Simpan Data</button> 
                        </div>
                      </div>
                    
                    </form>
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
                       
@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script src="{{ asset("js/inputmask/inputmask.jquery.js") }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    //fix to issue select2 on modal when opening in firefox
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};

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

    $('.datepicker').datepicker({
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months"
    });

    $('.datepicker2').datepicker({
        format:"dd-mm-yyyy",
        autoclose: true
    });

    //select2
    $( "#cari_sup" ).select2({
      placeholder: "Pilih Supplier...",
      ajax: {
          url: baseUrl + '/purchasing/rencanapembelian/get-supplier',
          dataType: 'json',
          data: function (params) {
            return {
                q: $.trim(params.term)
            };
          },
          processResults: function (data) {
              return {
                  results: data
              };
          },
          cache: true
      }, 
    });

    $( "#cari_kode_plan" ).select2({
      placeholder: "Pilih Kode Rencana...",
      ajax: {
          url: baseUrl + '/purchasing/orderpembelian/get-data-rencana-beli',
          dataType: 'json',
          data: function (params) {
            return {
                q: $.trim(params.term)
            };
          },
          processResults: function (data) {
              return {
                  results: data
              };
          },
          cache: true
      }, 
    });

    $('#method_bayar').change(function() {
      //remove child div inside appending-form before appending
      $('#appending div').remove();
      var metode = $(this).val();
      if (metode == "DEPOSIT") 
      {
        $('#appending div').remove();
        $('#appending').append('<div class="col-md-3 col-sm-12 col-xs-12">'
                                  +'<label class="tebal">Batas Terakhir Pengiriman</label>'
                              +'</div>'
                              +'<div class="col-md-3 col-sm-12 col-xs-12">'
                                +'<div class="form-group">'
                                  +'<input type="text" id="apd_tgl" name="apdTgl" class="form-control datepicker3 input-sm">'
                                +'</div>'
                              +'</div>');

        $('.datepicker3').datepicker({
          format:"dd-mm-yyyy",
          autoclose: true
        });
      }
      else if(metode == "CREDIT")
      {
        $('#appending div').remove();
        $('#appending').append('<div class="col-md-3 col-sm-12 col-xs-12">'
                                  +'<label class="tebal">TOP (Termin Of Payment)</label>'
                              +'</div>'
                              +'<div class="col-md-3 col-sm-12 col-xs-12">'
                                +'<div class="form-group">'
                                  +'<input type="text" id="apd_tgl" name="apdTgl" class="form-control datepicker3 input-sm">'
                                +'</div>'
                              +'</div>');

        $('.datepicker3').datepicker({
          format:"dd-mm-yyyy",
          autoclose: true
        });
      }
    });

    //set default value each field
    $('[name="potonganHarga"]').val(convertToRupiah(0));
    $('[name="diskonHarga"]').val("0%");
    $('[name="ppnHarga"]').val("0%");
    $('[name="totalNett"]').val("0");
    //panggil fungsi hitung total penjualan Gross
    totalPembelianGross();

    $('#cari_kode_plan').change(function() {
      //remove existing appending row
      $('tr').remove('.tbl_form_row');
      var id = $(this).val();
      $.ajax({
        url : baseUrl + "/purchasing/orderpembelian/get-data-form/"+id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          //object to store select2 data
          var dataSelect = {
              id: data.data_header[0].s_id,
              text: data.data_header[0].s_company
          };

          if ($('#cari_sup').find("option[value='" + dataSelect.id + "']").length) {
            $('#cari_sup').val(dataSelect.id).trigger('change');
          } else { 
            // Create a DOM Option and pre-select by default
            var newOption = new Option(dataSelect.text, dataSelect.id, true, true);
            // Append it to the select
            $('#cari_sup').append(newOption).trigger('change');
          } 

          var totalHarga = 0;
          var key = 1;
          i = randString(5);
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            var qtyCost = data.data_isi[key-1].d_pcspdt_qtyconfirm;
            $('#tabel-form-po').append('<tr class="tbl_form_row" id="row'+i+'">'
                            +'<td style="text-align:center">'+key+'</td>'
                            +'<td><input type="text" value="'+data.data_isi[key-1].i_code+' | '+data.data_isi[key-1].i_name+'" name="fieldNamaItem[]" class="form-control input-sm" readonly/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].i_id+'" name="fieldItemId[]" class="form-control input-sm"/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcspdt_id+'" name="fieldidPlanDt[]" class="form-control input-sm"/></td>'
                            +'<td>'
                            +'<input type="text" value="'+qtyCost+'" name="fieldQtyTxt[]" class="form-control currency input-sm" id="qtytxt_'+i+'" readonly style="text-align:right;"/>'
                            +'<input type="hidden" value="'+qtyCost+'" name="fieldQty[]" class="form-control numberinput input-sm" id="qty_'+i+'"/></td>'
                            +'<td><input type="text" value="'+data.data_isi[key-1].m_sname+'" name="fieldSatuan[]" class="form-control input-sm" readonly/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].m_sid+'" name="fieldIdSatuan[]" class="form-control input-sm" readonly/></td>'
                            +'<td><input type="text" value="'+convertDecimalToRupiah(data.data_isi[key-1].d_pcspdt_prevcost)+'" name="fieldHargaPrev[]" class="form-control input-sm" readonly style="text-align:right;"/></td>'
                            +'<td><input type="text" value="'+convertDecimalToRupiah(data.data_isi[key-1].d_pcspdt_prevcost)+'" name="fieldHarga[]" id="'+i+'" class="form-control input-sm field_harga numberinput" style="text-align:right;"/></td>'
                            +'<td><input type="text" value="'+convertDecimalToRupiah(data.data_isi[key-1].d_pcspdt_prevcost * qtyCost)+'" name="fieldHargaTotal[]" class="form-control input-sm hargaTotalItem" id="total_'+i+'" readonly style="text-align:right;"/></td>'
                            +'<td><input type="text" value="'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'" name="fieldStok[]" class="form-control input-sm" readonly style="text-align:right;"/></td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove btn-sm">X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
          });
          //set readonly to enabled
          $('#potongan_harga').attr('readonly',false);
          $('#diskon_harga').attr('readonly',false);
          $('#ppn_harga').attr('readonly',false);
          totalPembelianGross();
          totalPembelianNett();
          $(this).maskFunc();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
      });
    });

    $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr('id');
        $('#row'+button_id+'').remove();
        totalPembelianGross();
        totalPembelianNett();
    });

    //event focus on input harga
    $(document).on('focus', '.field_harga',  function(e){
        $(this).val("");
        $('#button_save').attr('disabled', true);
    });

    $(document).on('focus', '#potongan_harga',  function(e){
        $(this).val("");
        $('#button_save').attr('disabled', true);
    });

    $(document).on('focus', '#diskon_harga',  function(e){
        $(this).val("");
        $('#button_save').attr('disabled', true);
    });

    $(document).on('focus', '#ppn_harga',  function(e){
        $(this).val("");
        $('#button_save').attr('disabled', true);
    });

    //event onblur input harga
    $(document).on('blur', '.field_harga',  function(e){
      if ($(this).val() == "") { $(this).val(0) };
      var getid = $(this).attr("id");
      var harga = $(this).val();
      var qtyOrder = $('#qty_'+getid+'').val();
      //hitung nilai harga total
      var valueHargaTotal = convertToRupiah(qtyOrder * harga);
      //ubah format ke rupiah
      var hargaRp = convertToRupiah($(this).val());
      $(this).val(hargaRp);
      $('#total_'+getid+'').val(valueHargaTotal);
      totalPembelianGross();
      totalPembelianNett();
      $('#button_save').attr('disabled', false);
    });

    //event onblur potongan harga
    $(document).on('blur', '#potongan_harga',  function(e){
      if ($(this).val() == "") { $(this).val(0) };
      //ubah format ke rupiah
      var potonganRp = convertToRupiah($(this).val());
      $(this).val(potonganRp);
      totalPembelianNett();
      $('#button_save').attr('disabled', false);
    });

    //event onblur diskon
    $(document).on('blur', '#diskon_harga',  function(e){
      if ($(this).val() == "") { $(this).val(0) };
      //ubah format ke diskon
      var discSimbol = $(this).val();
      $(this).val(discSimbol+'%');
      totalPembelianNett();
      $('#button_save').attr('disabled', false);
    });

    //event onblur ppn
    $(document).on('blur', '#ppn_harga',  function(e){
      if ($(this).val() == "") { $(this).val(0) };
      //ubah format ke diskon
      var ppnSimbol = $(this).val();
      $(this).val(ppnSimbol+'%');
      totalPembelianNett();
      $('#button_save').attr('disabled', false);
    });

    //force integer input in textfield
    $('.numberinput').bind('keypress', function (e) {
      return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

    //validasi
    $("#form_create_po").validate({
      rules:{
        tanggal: "required",
        method_bayar: "required",
        cariSup: "required",
        cariKodePlan: "required"
      },
      errorPlacement: function() {
        return false;
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

    $('#cari_sup').change(function(event) {
      if($(this).val() != ""){
        $('#divSelectSup').removeClass('has-error').addClass('has-valid');
      }else{
        $('#divSelectSup').addClass('has-error').removeClass('has-valid');
      }
    });

    $('#cari_kode_plan').change(function(event) {
      if($(this).val() != ""){
        $('#divSelectPlan').removeClass('has-error').addClass('has-valid');
      }else{
        $('#divSelectPlan').addClass('has-error').removeClass('has-valid');
      }
    });
  //end jquery  
  });
  
  function convertDecimalToRupiah(decimal) 
  {
    var angka = parseInt(decimal);
    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    return hasil+',00';
  }

  function randString(angka) 
  {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < angka; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  }

  function convertToRupiah(angka) 
  {
    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    return hasil+',00'; 
  }

  function convertToAngka(rupiah)
  {
    return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
  }

  function convertDiscToAngka(disc) {
    return parseInt(disc.replace('%', ''), 10);
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

  function totalPembelianGross(){
    var inputs = document.getElementsByClassName( 'hargaTotalItem' ),
    hasil  = [].map.call(inputs, function( input ) {
        if(input.value == '') input.value = 0;
        return input.value;
    });
    console.log(hasil);
    var total = 0;
    for (var i = hasil.length - 1; i >= 0; i--){

      hasil[i] = convertToAngka(hasil[i]);
      hasil[i] = parseInt(hasil[i]);
      total = total + hasil[i];
    }
      if (isNaN(total)) {
          total=0;
        }
    total = convertToRupiah(total);
    // console.log(total);
    $('[name="totalGross"]').val(total);
  }

  function totalPembelianNett() 
  {
    var totalGross = convertToAngka($('#total_gross').val());
    var potongan = convertToAngka($('#potongan_harga').val());
    var disc = convertDiscToAngka($('#diskon_harga').val());
    var tax = convertDiscToAngka($('#ppn_harga').val());
    var discValue = totalGross * disc / 100;
    //var taxValue = totalGross * tax / 100;
    //hitung total pembelian nett
    // var hasilNett = (parseInt(totalGross) - parseInt(potongan + discValue)) + parseInt(taxValue);
    var hasilNett = (parseInt(totalGross) - parseInt(potongan + discValue));
    var taxValue = hasilNett * tax / 100;
    var finalValue = parseInt(hasilNett + taxValue);
    $('#total_nett').val(convertToRupiah(finalValue));
  }

  function simpanPo()
  {
    var IsValid = $("form[name='formCreatePo']").valid();
    if(IsValid)
    {
      var countRow = $('#tabel-form-po tr').length;
      if(countRow > 1)
      {
        $('#divSelectSup').removeClass('has-error');
        $('#divSelectPlan').removeClass('has-error');
        $('#button_save').text('Menyimpan...');
        $('#button_save').attr('disabled',true); 
        $.ajax({
            url : baseUrl + "/purchasing/orderpembelian/simpan-po",
            type: "POST",
            dataType: "JSON",
            data: $('#form_create_po').serialize(),
            success: function(response)
            {
              if(response.status == "sukses")
              {
                iziToast.success({
                  position: 'center',
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#button_save').text('Simpan Data');
                    $('#button_save').attr('disabled',false); 
                    window.location.href = baseUrl+"/purchasing/orderpembelian/order";
                  }
                });
              }
              else
              {
                iziToast.error({
                  position: 'center',
                  title: 'Pemberitahuan',
                  message: "Data Gagal disimpan !",
                  onClosing: function(instance, toast, closedBy){
                    $('#button_save').text('Simpan Data');
                    $('#button_save').attr('disabled',false);
                    window.location.href = baseUrl+"/purchasing/rencanapembelian/rencana";
                  }
                });
              }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              iziToast.error({
                position: 'topRight',
                title: 'Pemberitahuan',
                message: "Data gagal disimpan !"
              });
            }
        });
      }
      else
      {
        iziToast.warning({
          position: 'center',
          message: "Mohon isi data pada tabel form !"
        });
      }
    }
    else //else validation
    {
      iziToast.warning({
        position: 'center',
        message: "Mohon Lengkapi data form !",
        onClosing: function(instance, toast, closedBy){
          $('#divSelectSup').addClass('has-error');
          $('#divSelectPlan').addClass('has-error');
        }
      });
    }
  }

</script>
@endsection