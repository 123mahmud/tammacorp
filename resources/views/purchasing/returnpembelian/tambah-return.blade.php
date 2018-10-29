@extends('main')
@section('content')
<style type="text/css">
  .ui-autocomplete { z-index:2147483647; }
  .select2-container { margin: 0; }
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
          <div class="page-title">Form Return Pembelian</div>
      </div>

      <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Return Pembelian</li><li><i class="fa fa-angle-right"></i>&nbsp;Form Return Pembelian&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
      </ol>

      <div class="clearfix"></div>
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
              <li class="active"><a href="#alert-tab" data-toggle="tab">Form Return Pembelian</a></li>
              <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
              <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
            </ul>

            <div id="generalTabContent" class="tab-content responsive" >
              <div id="alert-tab" class="tab-pane fade in active">
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">
                    <div class="col-md-5 col-sm-6 col-xs-8">
                      <h4>Form Return Pembelian</h4>
                    </div>

                    <div class="col-md-7 col-sm-6 col-xs-4 " align="right" style="margin-top:5px;margin-right: -25px;">
                      <a href="{{ url('purchasing/returnpembelian/pembelian') }}" class="btn">
                        <i class="fa fa-arrow-left"></i>
                      </a>
                    </div>
                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">
                    <div class="col-md-2 col-sm-3 col-xs-12">
                      <label class="tebal">Metode Return</label>
                    </div>

                    <div class="col-md-4 col-sm-9 col-xs-12">
                      <div class="form-group">
                        <select class="form-control input-sm" id="pilih_metode_return" name="pilihMetodeReturn" style="width: 100%;">
                          <option value=""> - Pilih Metode Return</option>
                          <option value="TK"> Tukar Barang </option>
                          <option value="PN"> Potong Nota </option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <!-- START div#header_form -->
                  <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:15px;" id="header_form">
                    <form method="post" id="form_return_pembelian" name="formReturnPembelian">
                      {{ csrf_field() }}
                      <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 10px; padding-top:10px;padding-bottom:20px;" id="appending-form">
                      </div>
                    </form>
                  </div>
                  <!-- END div#header_form -->

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

    $('.datepicker').datepicker({
      format: "mm-yyyy",
      viewMode: "months",
      minViewMode: "months"
    });

    //autofill
    $('#pilih_metode_return').change(function()
    {
      //remove child div inside appending-form before appending
      $('#appending-form div').remove();
      var method = $(this).val();
      var methodTxt = $(this).text();
      if (method == "") 
      {
        //alert("Mohon untuk Memilih salah satu dari metode return pembelian")
        $('#appending-form div').remove();
      }
      else if(method == "TK")
      {
        //remove child div inside appending-form before appending
        $('#appending-form div').remove();
        $('#appending-form').append('<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Nota Pembelian</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<select class="form-control input-sm select2" id="cari_nota_purchase" name="cariNotaPurchase" style="width: 100% !important;">'
                                          +'<option> - Pilih Nota Pembelian</option>'
                                        +'</select>'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Kode Return</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="kodeReturn" readonly="" class="form-control input-sm" value="{{$codeRP}}">'
                                        +'<input type="hidden" name="metodeReturn" readonly="" class="form-control input-sm">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Tanggal Return</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input id="tanggalReturn" class="form-control input-sm datepicker2 " name="tanggal" type="text" value="{{ date('d-m-Y') }}">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Staff</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="namaStaff" readonly="" class="form-control input-sm" id="nama_staff" value="{{ $staff['nama'] }}">'
                                        +'<input type="hidden" name="idStaff" readonly="" class="form-control input-sm" id="id_staff" value="{{ $staff['id'] }}">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Supplier</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="namaSup" readonly="" class="form-control input-sm" id="nama_sup">'
                                        +'<input type="hidden" name="idSup" readonly="" class="form-control input-sm" id="id_sup">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Metode Bayar</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="methodBayar" readonly="" class="form-control input-sm" id="method_bayar">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Nilai Total Pembelian</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="nilaiTotalGross" readonly="" class="form-control input-sm right" id="nilai_total_gross">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Nilai Total Diskon</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="nilaiTotalDisc" readonly="" class="form-control input-sm right" id="nilai_total_disc">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Nilai Pajak</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="nilaiTotalTax" readonly="" class="form-control input-sm right" id="nilai_total_tax">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Nilai Total Pembelian (Nett)</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="nilaiTotalNett" readonly="" class="form-control input-sm right" id="nilai_total_nett">'
                                         +'<input type="hidden" name="nilaiTotalReturnRaw" readonly="" class="form-control input-sm" id="nilai_total_return_raw">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="table-responsive">'
                                      +'<table class="table tabelan table-bordered" id="tabel-form-return">'
                                        +'<form method="POST" id="form_create_po">'
                                          +'{{ csrf_field() }}'
                                          +'<thead>'
                                            +'<tr>'
                                              +'<th width="5%">No</th>'
                                              +'<th width="30%">Kode | Barang</th>'
                                              +'<th width="10%">Qty</th>'
                                              +'<th width="10%">Satuan</th>'
                                              +'<th width="15%">Harga</th>'
                                              +'<th width="15%">Total</th>'
                                              +'<th width="10%">Stok</th>'
                                              +'<th width="5%">Aksi</th>'
                                            +'</tr>'
                                          +'</thead>'
                                          +'<tbody id="div_item">'
                                          +'</tbody>'
                                        +'</form>'
                                      +'</table>'
                                    +'</div>'
                                      +'<div align="right">'
                                        +'<div id="div_button_save" class="form-group">'
                                          +'<button type="button" id="button_save" class="btn btn-primary" onclick="simpanReturn()">Simpan Data</button>'
                                        +'</div>'
                                      +'</div>');
      }
      else
      {
        //remove child div inside appending-form before appending
        $('#appending-form div').remove();
        $('#appending-form').append('<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Nota Pembelian</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<select class="form-control input-sm select2" id="cari_nota_purchase" name="cariNotaPurchase" style="width: 100% !important;">'
                                          +'<option> - Pilih Nota Pembelian</option>'
                                        +'</select>'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Kode Return</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="kodeReturn" readonly="" class="form-control input-sm" value="{{$codeRP}}">'
                                        +'<input type="hidden" name="metodeReturn" readonly="" class="form-control input-sm">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Tanggal Return</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input id="tanggalReturn" class="form-control input-sm datepicker2 " name="tanggal" type="text" value="{{ date('d-m-Y') }}">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Staff</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="namaStaff" readonly="" class="form-control input-sm" id="nama_staff" value="{{ $staff['nama'] }}">'
                                        +'<input type="hidden" name="idStaff" readonly="" class="form-control input-sm" id="id_staff" value="{{ $staff['id'] }}">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Supplier</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="namaSup" readonly="" class="form-control input-sm" id="nama_sup">'
                                        +'<input type="hidden" name="idSup" readonly="" class="form-control input-sm" id="id_sup">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Metode Bayar</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="methodBayar" readonly="" class="form-control input-sm" id="method_bayar">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Nilai Total Pembelian</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="nilaiTotalGross" readonly="" class="form-control input-sm right" id="nilai_total_gross">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Nilai Total Diskon</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="nilaiTotalDisc" readonly="" class="form-control input-sm right" id="nilai_total_disc">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Nilai Pajak</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="nilaiTotalTax" readonly="" class="form-control input-sm right" id="nilai_total_tax">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Nilai Total Pembelian (Nett)</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="nilaiTotalNett" readonly="" class="form-control input-sm right" id="nilai_total_nett">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="col-md-2 col-sm-3 col-xs-12">'
                                      +'<label class="tebal">Nilai Total Return</label>'
                                    +'</div>'
                                    +'<div class="col-md-4 col-sm-9 col-xs-12">'
                                      +'<div class="form-group">'
                                        +'<input type="text" name="nilaiTotalReturn" readonly="" class="form-control input-sm right" id="nilai_total_return">'
                                        +'<input type="hidden" name="nilaiTotalReturnRaw" readonly="" class="form-control input-sm" id="nilai_total_return_raw">'
                                      +'</div>'
                                    +'</div>'
                                    +'<div class="table-responsive">'
                                      +'<table class="table tabelan table-bordered" id="tabel-form-return">'
                                        +'<form method="POST" id="form_create_po">'
                                          +'{{ csrf_field() }}'
                                          +'<thead>'
                                            +'<tr>'
                                              +'<th width="5%">No</th>'
                                              +'<th width="30%">Kode | Barang</th>'
                                              +'<th width="10%">Qty</th>'
                                              +'<th width="10%">Satuan</th>'
                                              +'<th width="15%">Harga</th>'
                                              +'<th width="15%">Total</th>'
                                              +'<th width="10%">Stok</th>'
                                              +'<th width="5%">Aksi</th>'
                                            +'</tr>'
                                          +'</thead>'
                                          +'<tbody id="div_item">'
                                          +'</tbody>'
                                        +'</form>'
                                      +'</table>'
                                    +'</div>'
                                      +'<div align="right">'
                                        +'<div id="div_button_save" class="form-group">'
                                          +'<button type="button" id="button_save" class="btn btn-primary" onclick="simpanReturn()">Simpan Data</button>'
                                        +'</div>'
                                      +'</div>');
      }
      //select2
      $( "#cari_nota_purchase" ).select2({
        placeholder: "Pilih Nota Pembelian...",
        ajax: {
          url: baseUrl + '/purchasing/returnpembelian/lookup-data-pembelian',
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

      //datepicker
      $('.datepicker2').datepicker({
        autoclose: true,
        format:"dd-mm-yyyy",
        endDate: 'today'
      });
      
      //event onchange select option
      $('#cari_nota_purchase').change(function() {
        //remove existing appending row
        $('tr').remove('.tbl_form_row');
        var idPo = $('#cari_nota_purchase').val();
        $.ajax({
          url : baseUrl + "/purchasing/returnpembelian/get-data-form/"+idPo,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
            //total diskon didapat dari value diskon + percentase diskon
            var discTotalVal = parseInt(data.data_header[0].d_pcs_discount)+parseInt(data.data_header[0].d_pcs_disc_value);
            var totalGross = data.data_header[0].d_pcs_total_gross;
            var taxPercent = data.data_header[0].d_pcs_tax_percent;
            var totalTax = data.data_header[0].d_pcs_tax_value;
            //persentase diskon berdasarkan total harga bruto
            var percentDiscTotalGross = parseFloat(discTotalVal*100/totalGross);
            //console.log(percentDiscTotalGross);
            //harga total setelah diskon dan 
            var totalNett = data.data_header[0].d_pcs_total_net;
            //data header
            $('#nama_sup').val(data.data_header[0].s_company);
            $('#id_sup').val(data.data_header[0].s_id);
            $('#method_bayar').val(data.data_header[0].d_pcs_method);
            $('[name="metodeReturn"]').val($('#pilih_metode_return').val());
            $('#nilai_total_gross').val(convertDecimalToRupiah(totalGross));
            $('#nilai_total_disc').val(convertDecimalToRupiah(discTotalVal));
            $('#nilai_total_tax').val(convertDecimalToRupiah(totalTax));
            $('#nilai_total_nett').val(convertDecimalToRupiah(totalNett));
            var totalHarga = 0;
            var key = 1;
            i = randString(5);
            //loop data
            Object.keys(data.data_isi).forEach(function(){
              var hargaTotalItemGross = data.data_isi[key-1].d_pcsdt_total;
              var qtyCost = data.data_isi[key-1].d_pcsdt_qtyconfirm;
              //harga total per item setelah kena diskon & pajak
              var hargaTotalItemNet = Math.round(parseFloat(hargaTotalItemGross - (hargaTotalItemGross * percentDiscTotalGross/100) + ((hargaTotalItemGross - (hargaTotalItemGross * percentDiscTotalGross/100)) * taxPercent/100)).toFixed(2));
              console.log(hargaTotalItemNet);
              //harga satuan per item setelah kena diskon & pajak
              //var hargaSatuanItemNet = Math.round(parseFloat(hargaTotalItemNet/qtyCost).toFixed(2));
              var hargaSatuanItemNet = hargaTotalItemNet/qtyCost;
              var hargaTotalPerRow = hargaSatuanItemNet * qtyCost;
              //console.log(hargaSatuanItemNet);
              $('#tabel-form-return').append('<tr class="tbl_form_row" id="row'+i+'">'
                              +'<td style="text-align:center">'+key+'</td>'
                              +'<td><input type="text" value="'+data.data_isi[key-1].i_code+' | '+data.data_isi[key-1].i_name+'" name="fieldNamaItem[]" class="form-control input-sm" readonly/>'
                              +'<input type="hidden" value="'+data.data_isi[key-1].i_id+'" name="fieldItemId[]" class="form-control input-sm"/>'
                              +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsrdt_id+'" name="fieldIdPcsRtrDet[]" class="form-control input-sm"/></td>'
                              +'<td><input type="text" value="'+qtyCost+'" name="fieldQty[]" class="form-control numberinput input-sm field_qty right" id="'+i+'"/>'
                              +'<input type="hidden" value="'+qtyCost+'" name="fieldQtyAnchor[]" class="form-control numberinput input-sm qty_anchor" id="qtyAnchor_'+i+'"/></td>'
                              +'<td><input type="text" value="'+data.data_isi[key-1].m_sname+'" name="fieldSatuanTxt[]" class="form-control input-sm" readonly/>'
                              +'<input type="hidden" value="'+data.data_isi[key-1].m_sid+'" name="fieldSatuanId[]" class="form-control input-sm" readonly/></td>'
                              +'<td><input type="text" value="'+convertDecimalToRupiah(hargaSatuanItemNet)+'" name="fieldHarga[]" id="cost_'+i+'" class="form-control input-sm field_harga numberinput right" readonly/>'
                              +'<input type="hidden" value="'+hargaSatuanItemNet+'" name="fieldHargaRaw[]" id="costRaw_'+i+'" class="form-control input-sm field_harga_raw numberinput right" readonly/></td>'
                              +'<td><input type="text" value="'+convertDecimalToRupiah(hargaTotalPerRow)+'" name="fieldHargaTotal[]" class="form-control input-sm hargaTotalItem right" id="total_'+i+'" readonly/>'
                              +'<input type="hidden" value="'+hargaTotalPerRow+'" name="fieldHargaTotalRaw[]" id="totalRaw_'+i+'" class="form-control input-sm hargaTotalItemRaw numberinput" readonly/></td>'
                              +'<td><input type="text" value="'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'" name="fieldStokTxt[]" class="form-control input-sm right" readonly/>'
                              +'<input type="hidden" value="'+data.data_stok[key-1].qtyStok+'" name="fieldStokVal[]" class="form-control input-sm" readonly/></td>'
                              +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove btn-sm">X</button></td>'
                              +'</tr>');
              i = randString(5);
              key++;
            });
            //set readonly to enabled
            totalNilaiReturn();
            totalNilaiReturnRaw();
            //force integer input in textfield
            $('input.numberinput').bind('keypress', function (e) {
                return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
            });
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error get data from ajax');
          }
        });
      });
 
    });

    $(document).on('click', '.btn_remove', function(){
      var button_id = $(this).attr('id');
      $('#row'+button_id+'').remove();
      totalNilaiReturn();
      totalNilaiReturnRaw();
    });

    //event focus on input qty
    $(document).on('focus', '.field_qty',  function(e){
      var qty = $(this).val();
      $(this).val(qty);
      $('#button_save').attr('disabled', true);
    });

    $(document).on('blur', '.field_qty',  function(e){
      var getid = $(this).attr("id");
      var qtyReturn = $(this).val();
      var cost = $('#costRaw_'+getid+'').val();
      var hasilTotal = parseInt(qtyReturn * cost);
      var hasilTotalRaw = parseFloat(qtyReturn * cost).toFixed(2);
      var totalCost = $('#total_'+getid+'').val(convertDecimalToRupiah(hasilTotal));
      var totalCostRaw = $('#totalRaw_'+getid+'').val(hasilTotalRaw);
      // $(this).val(potonganRp);
      totalNilaiReturn();
      totalNilaiReturnRaw();
      $('#button_save').attr('disabled', false);
    });

    $(document).on('keyup', '.field_qty', function(e) {
      var val = parseInt($(this).val());
      var getid = $(this).attr("id");
      var anchor = $('#qtyAnchor_'+getid+'').val();
      //console.log(anchor());
      if (val > anchor || $(this).val() == "" || val == 0) {
        $(this).val(anchor);
      }
    });

    //validasi
    $("#form_return_pembelian").validate({
      rules:{
        tanggal: "required"
      },
      errorPlacement: function() {
          return false;
      },
      submitHandler: function(form) {
        form.submit();
      }
    });
  //end jquery
  });

  function randString(angka) 
  {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < angka; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  }

  function simpanReturn() {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      zindex: 999,
      title: 'Simpan Retur Pembelian',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          var IsValid = $("form[name='formReturnPembelian']").valid();
          if(IsValid)
          {
            var countRow = $('#div_item tr').length;
            if(countRow >= 1)
            {
              $('#button_save').text('Menyimpan...'); //change button text
              $('#button_save').attr('disabled',true); //set button disable 
              $.ajax({
                url : baseUrl + "/purchasing/returnpembelian/simpan-data-return",
                type: "POST",
                dataType: "JSON",
                data: $('#form_return_pembelian').serialize(),
                success: function(response)
                {
                  if(response.status == "sukses")
                  {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    iziToast.success({
                      position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                      title: 'Pemberitahuan',
                      message: response.pesan,
                      onClosing: function(instance, toast, closedBy){
                        $('#button_save').text('Simpan Data'); //change button text
                        $('#button_save').attr('disabled',false); //set button enable 
                        window.location.href = baseUrl+"/purchasing/returnpembelian/pembelian";
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
                        $('#button_save').text('Simpan Data'); //change button text
                        $('#button_save').attr('disabled',false); //set button enable 
                        window.location.href = baseUrl+"/purchasing/returnpembelian/pembelian";
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
            }
            else
            {
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
              iziToast.warning({
                 position: 'center',
                 message: "Mohon isi data pada tabel form !"
              });
            }//end check count form table
          }
          else
          {
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            iziToast.warning({
              position: 'center',
              message: "Mohon Lengkapi data form !"
            });
          } //end check valid
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function convertDecimalToRupiah(decimal) 
  {
    var angka = parseInt(decimal);
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

  function convertToRupiah(angka) 
  {
    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    return hasil+',00'; 
  }

  function totalNilaiReturn()
  {
    var inputs = document.getElementsByClassName( 'hargaTotalItem' ),
    hasil  = [].map.call(inputs, function( input ) 
    {
      if(input.value == '') input.value = 0;
      return input.value;
    });
    //console.log(hasil);
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
    $('[name="nilaiTotalReturn"]').val(total);
  }

  function totalNilaiReturnRaw()
  {
    var inputs = document.getElementsByClassName( 'hargaTotalItemRaw' ),
    hasil  = [].map.call(inputs, function( input ) 
    {
      if(input.value == '') input.value = 0;
      return input.value;
    });
    //console.log(hasil);
    var total = 0;
    for (var i = 0; i < hasil.length; i++){
      total = (parseFloat(total) + parseFloat(hasil[i])).toFixed(2);
      // console.log(total);
    }
      if (isNaN(total)) {
        total = parseFloat(0).toFixed(2);
      }
    $('[name="nilaiTotalReturnRaw"]').val(total);
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
</script>
@endsection                            
