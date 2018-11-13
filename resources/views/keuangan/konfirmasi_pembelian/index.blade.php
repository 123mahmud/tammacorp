@extends('main')
@section('content')
<style type="text/css">
  .ui-autocomplete { z-index:2147483647; }
</style>
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
        <div class="page-title">Konfirmasi Data Pembelian</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Keuangan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Konfirmasi Data Pembelian</li>
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
            <li class="active"><a href="#alert-tab" data-toggle="tab">Daftar Rencana Pembelian</a></li>
            <li><a href="#order-tab" data-toggle="tab" onclick="daftarTabelOrder()">Daftar Order Pembelian</a></li>
            <li><a href="#return-tab" data-toggle="tab" onclick="daftarTabelReturn()">Daftar Return Pembelian</a></li>
            <li><a href="#belanjaharian-tab" data-toggle="tab" onclick="daftarTabelBelanja()">Daftar Belanja Harian</a></li>
            <li><a href="#returnPenjualan-tab" data-toggle="tab" onclick="daftarReturnPenjualan()">Daftar Return Penjualan</a></li>
          </ul>

          <div id="generalTabContent" class="tab-content responsive">
            <!-- tab daftar pembelian plan -->
            @include('keuangan.konfirmasi_pembelian.tab-daftar')     
            <!-- tab daftar pembelian order -->
            @include('keuangan.konfirmasi_pembelian.tab-order')
            <!-- tab daftar return pembelian -->
            @include('keuangan.konfirmasi_pembelian.tab-return')
            <!-- tab daftar belanja harian -->
            @include('keuangan.konfirmasi_pembelian.tab-belanjaharian')
            <!-- tab daftar return penjualan -->
            @include('keuangan.konfirmasi_pembelian.tab-returnpenjualan')
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--END TITLE & BREADCRUMB PAGE-->
  <!-- modal -->
    <!--modal confirm orderplan-->
    @include('keuangan.konfirmasi_pembelian.modal-confirm')
    <!--modal confirm order-->
    @include('keuangan.konfirmasi_pembelian.modal-confirm-order')
    <!--modal confirm return-->
    @include('keuangan.konfirmasi_pembelian.modal-confirm-return')
    <!--modal confirm belanja harian-->
    @include('keuangan.konfirmasi_pembelian.modal-confirm-belanjaharian')
  <!-- /modal -->
  <!-- End DIv note-tab -->
<!-- div label-badge-tab -->
 {{--  mahmud --}}
  <div class="modal fade" id="myItem" role="dialog">
    <div class="modal-dialog modal-lg"
         style="width: 90%;margin-left: auto;margin-top: 30px;">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #e77c38;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color: white;">Nama Item</h4>

            </div>
            <div class="modal-body">
                <div id="xx">

                </div>
            </div>
            <div id="buttonDetail" class="modal-footer">

            </div>
        </div>

    </div>
  </div>

  <div class="modal fade" id="myItemSB" role="dialog">
      <div class="modal-dialog modal-lg"
           style="width: 90%;margin-left: auto;margin-top: 30px;">

          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header" style="background-color: #e77c38;">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title" style="color: white;">Nama Item</h4>

              </div>
              <div class="modal-body">
                  <div id="sb">

                  </div>
              </div>
              <div id="buttonDetail" class="modal-footer">

              </div>
          </div>

      </div>
  </div>
  {{-- end mahmud --}}
</div>
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

    $('#tbl-daftar').dataTable({
        "destroy": true,
        "processing" : true,
        "serverside" : true,
        "ajax" : {
          url: baseUrl + "/keuangan/konfirmasipembelian/get-data-tabel-daftar",
          type: 'GET'
        },
        "columns" : [
          {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
          {"data" : "tglBuat", "width" : "10%"},
          {"data" : "d_pcsp_code", "width" : "10%"},
          {"data" : "m_name", "width" : "15%"},
          {"data" : "s_company", "width" : "25%"},
          {"data" : "tglConfirm", "width" : "15%"},
          {"data" : "status", "width" : "10%"},
          {"data" : "action", orderable: false, searchable: false, "width" : "5%"}
        ],
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

    //force integer input in textfield
    $('input.numberinput').bind('keypress', function (e) {
        return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

    // fungsi jika modal hidden
    $(".modal").on("hidden.bs.modal", function(){
      $('tr').remove('.tbl_modal_detail_row');
      //remove span class in modal detail
      $("#txt_span_status_confirm").removeClass();
      $("#txt_span_status_order_confirm").removeClass();
      $("#txt_span_status_return_confirm").removeClass();
    });

    $(document).on('click', '.btn_remove_row', function(event){
        event.preventDefault();
        var button_id = $(this).attr('id');
        $('#row'+button_id+'').remove();
    });

    $(document).on('click', '.btn_remove_row_order', function(event){
        event.preventDefault();
        var button_id = $(this).attr('id');
        $('#row'+button_id+'').remove();
    });

    //event change, apabila status !fn = maka btn_remove disabled
    $('#status_confirm').change(function(event) {
      //alert($(this).val());
      if($(this).val() == "FN")
      {
        $('.btn_remove_row').attr('disabled', false);
        $('.crfmField').attr('readonly', false);
      }
      else if ($(this).val() == "WT")
      {
        $('.btn_remove_row').attr('disabled', true);
        $('.crfmField').val('0').attr('readonly', true);
      }
      else
      {
        $('.btn_remove_row').attr('disabled', true);
        $('.crfmField').attr('readonly', true);
      }
    });

    //event change, apabila status !fn = maka btn_remove disabled
    $('#status_order_confirm').change(function(event) {
      //alert($(this).val());
      if($(this).val() != "CF")
      {
        $('.btn_remove_row_order').attr('disabled', true);
      }
      else
      {
        $('.btn_remove_row_order').attr('disabled', false); 
      }
    });

    //event change, apabila status !fn = maka btn_remove disabled
    $('#status_belanja_confirm').change(function(event) {
      //alert($(this).val());
      if($(this).val() != "CF")
      {
        $('.btn_remove_row_order').attr('disabled', true);
      }
      else
      {
        $('.btn_remove_row_order').attr('disabled', false); 
      }
    });

    //event onblur input harga
    $(document).on('blur', '.field_qty_confirm',  function(e){
      var getid = $(this).attr("id");
      var qtyConfirm = $(this).val();
      var harga = convertToAngka($('#price_'+getid+'').text());
      //hitung nilai harga total
      var valueHargaTotal = convertToRupiah(qtyConfirm * harga);
      $('#total_'+getid+'').text(valueHargaTotal);
      $('#button_confirm_order').attr('disabled', false);
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
  
  function konfirmasiPlanAll(id) 
  {
      $.ajax({
      url : baseUrl + "/keuangan/konfirmasipembelian/confirm-plan/"+id+"/all",
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        var i = randString(5);
        //ambil data ke json->modal
        $('#txt_span_status_confirm').text(data.spanTxt);
        $("#txt_span_status_confirm").addClass('label'+' '+data.spanClass);
        $("#id_plan").val(data.header[0].d_pcsp_id);
        $("#status_confirm").val(data.header[0].d_pcsp_status);
        $('#lblCodeConfirm').text(data.header[0].d_pcsp_code);
        $('#lblTglConfirm').text(data.header[0].d_pcsp_datecreated);
        $('#lblStaffConfirm').text(data.header[0].m_name);
        $('#lblSupplierConfirm').text(data.header[0].s_company);
        
        if ($("#status_confirm").val() != "FN") 
        {
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            $('#tabel-confirm').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                            +'<td>'+key+'</td>'
                            +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                            +'<td align="right">'+formatAngka(data.data_isi[key-1].d_pcspdt_qty)+'</td>'
                            +'<td><input type="text" value="'+data.data_isi[key-1].d_pcspdt_qty+'" name="fieldConfirm[]" class="form-control input-sm crfmField currency" style="text-align:right;"/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcspdt_id+'" name="fieldIdDt[]" class="form-control"/></td>'
                            +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                            +'<td align="right">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcspdt_prevcost)+'</td>'
                            +'<td align="right">'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'</td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove_row btn-sm" disabled>X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
            $(this).maskFunc();
          });
        }
        else
        {
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            $('#tabel-confirm').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                            +'<td>'+key+'</td>'
                            +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                            +'<td align="right">'+formatAngka(data.data_isi[key-1].d_pcspdt_qty)+'</td>'
                            +'<td><input type="text" value="'+data.data_isi[key-1].d_pcspdt_qtyconfirm+'" name="fieldConfirm[]" class="form-control input-sm crfmField currency" style="text-align:right;"/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcspdt_id+'" name="fieldIdDt[]" class="form-control"/></td>'
                            +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                            +'<td align="right">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcspdt_prevcost)+'</td>'
                            +'<td align="right">'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'</td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove_row btn-sm">X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
          });
          $(this).maskFunc();
        }
        
        $('#modal-confirm').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
      });
  }
   
  function konfirmasiPlan(id) 
  {
      $.ajax({
      url : baseUrl + "/keuangan/konfirmasipembelian/confirm-plan/"+id+"/confirmed",
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        var i = randString(5);
        //ambil data ke json->modal
        $('#txt_span_status_confirm').text(data.spanTxt);
        $("#txt_span_status_confirm").addClass('label'+' '+data.spanClass);
        $("#id_plan").val(data.header[0].d_pcsp_id);
        $("#status_confirm").val(data.header[0].d_pcsp_status);
        $('#lblCodeConfirm').text(data.header[0].d_pcsp_code);
        $('#lblTglConfirm').text(data.header[0].d_pcsp_datecreated);
        $('#lblStaffConfirm').text(data.header[0].m_name);
        $('#lblSupplierConfirm').text(data.header[0].s_company);
        
        if ($("#status_confirm").val() != "FN") 
        {
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            $('#tabel-confirm').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                            +'<td>'+key+'</td>'
                            +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                            +'<td align="right">'+formatAngka(data.data_isi[key-1].d_pcspdt_qty)+'</td>'
                            +'<td><input type="text" value="'+data.data_isi[key-1].d_pcspdt_qtyconfirm+'" name="fieldConfirm[]" class="form-control input-sm crfmField currency" style="text-align:right;"/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcspdt_id+'" name="fieldIdDt[]" class="form-control"/></td>'
                            +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                            +'<td align="right">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcspdt_prevcost)+'</td>'
                            +'<td align="right">'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'</td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove_row btn-sm" disabled>X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
            $(this).maskFunc();
          });
        }
        else
        {
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            $('#tabel-confirm').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                            +'<td>'+key+'</td>'
                            +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                            +'<td align="right">'+formatAngka(data.data_isi[key-1].d_pcspdt_qty)+'</td>'
                            +'<td><input type="text" value="'+data.data_isi[key-1].d_pcspdt_qtyconfirm+'" name="fieldConfirm[]" class="form-control input-sm crfmField currency" style="text-align:right;"/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcspdt_id+'" name="fieldIdDt[]" class="form-control"/></td>'
                            +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                            +'<td align="right">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcspdt_prevcost)+'</td>'
                            +'<td align="right">'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'</td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove_row btn-sm">X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
          });
          $(this).maskFunc();
        }
        
        $('#modal-confirm').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
      });
  }

  function daftarTabelOrder() 
  {
    $('#tbl-order').dataTable({
        "destroy": true,
        "processing" : true,
        "serverside" : true,
        "ajax" : {
          url: baseUrl + "/keuangan/konfirmasipembelian/get-data-tabel-order",
          type: 'GET'
        },
        "columns" : [
          {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
          {"data" : "tglOrder", "width" : "10%"},
          {"data" : "d_pcs_code", "width" : "10%"},
          {"data" : "m_name", "width" : "10%"},
          {"data" : "s_company", "width" : "25%"},
          {"data" : "tglConfirm", "width" : "10%"},
          {"data" : "hargaTotalNet", "width" : "15%"},
          {"data" : "status", "width" : "10%"},
          {"data" : "action", orderable: false, searchable: false, "width" : "5%"}
        ],
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
  } 

  function daftarTabelReturn() 
  {
    $('#tbl-return').dataTable({
        "destroy": true,
        "processing" : true,
        "serverside" : true,
        "ajax" : {
          url: baseUrl + "/keuangan/konfirmasipembelian/get-data-tabel-return",
          type: 'GET'
        },
        "columns" : [
          {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
          {"data" : "tglReturn", "width" : "10%"},
          {"data" : "d_pcsr_code", "width" : "10%"},
          {"data" : "m_name", "width" : "10%"},
          {"data" : "metode", "width" : "15%"},
          {"data" : "s_company", "width" : "15%"},
          {"data" : "hargaTotal", "width" : "15%"},
          {"data" : "status", "width" : "10%"},
          {"data" : "tglConfirm", "width" : "10%"},
          {"data" : "action", orderable: false, searchable: false, "width" : "10%"}
        ],
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
  }

  function daftarTabelBelanja() 
  {
    $('#tbl-belanjaharian').dataTable({
        "destroy": true,
        "processing" : true,
        "serverside" : true,
        "ajax" : {
          url: baseUrl + "/keuangan/konfirmasipembelian/get-data-tabel-belanjaharian",
          type: 'GET'
        },
        "columns" : [
          {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
          {"data" : "tglBelanja", "width" : "10%"},
          {"data" : "d_pcsh_code", "width" : "10%"},
          {"data" : "m_name", "width" : "10%"},
          {"data" : "d_pcsh_peminta", "width" : "15%"},
          {"data" : "tglConfirm", "width" : "10%"},
          {"data" : "hargaTotal", "width" : "15%"},
          {"data" : "status", "width" : "10%"},
          {"data" : "action", orderable: false, searchable: false, "width" : "10%"}
        ],
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
  }

  function konfirmasiOrder(id,type) 
  {
    $.ajax({
      url : baseUrl + "/keuangan/konfirmasipembelian/confirm-order/"+id+"/"+type,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        var i = randString(5);
        //ambil data ke json->modal
        $('#txt_span_status_order_confirm').text(data.spanTxt);
        $("#txt_span_status_order_confirm").addClass('label'+' '+data.spanClass);
        $("#id_order").val(data.header[0].d_pcs_id);
        $("#status_order_confirm").val(data.header[0].d_pcs_status);
        $('#lblCodeOrderConfirm').text(data.header[0].d_pcs_code);
        $('#lblTglOrderConfirm').text(data.header[0].d_pcs_date_created);
        $('#lblStaffOrderConfirm').text(data.header[0].m_name);
        $('#lblSupplierOrderConfirm').text(data.header[0].s_company);
        if (data.header[0].d_pcs_method != "CASH") 
        {
          $('#append-modal-order div').remove();
          var metode = data.header[0].d_pcs_method;
          if (metode == "DEPOSIT") 
          {
            $('#append-modal-order div').remove();
            $('#append-modal-order').append('<div class="col-md-3 col-sm-12 col-xs-12">'
                                      +'<label class="tebal">Batas Terakhir Pengiriman</label>'
                                  +'</div>'
                                  +'<div class="col-md-3 col-sm-12 col-xs-12">'
                                    +'<div class="form-group">'
                                      +'<label id="dueDate">'+data.header[0].d_pcs_duedate+'</label>'
                                    +'</div>'
                                  +'</div>');
          }
          else if(metode == "CREDIT")
          {
            $('#append-modal-order div').remove();
            $('#append-modal-order').append('<div class="col-md-3 col-sm-12 col-xs-12">'
                                      +'<label class="tebal">TOP (Termin Of Payment)</label>'
                                  +'</div>'
                                  +'<div class="col-md-3 col-sm-12 col-xs-12">'
                                    +'<div class="form-group">'
                                      +'<label id="dueDate">'+data.header[0].d_pcs_duedate+'</label>'
                                    +'</div>'
                                  +'</div>');
          }
        }

        if ($("#statusOrderConfirm").val() != "CF") 
        {
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            $('#tabel-order-confirm').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                            +'<td>'+key+'</td>'
                            +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                            +'<td align="right">'+formatAngka(data.data_isi[key-1].d_pcsdt_qty)+'</td>'
                            +'<td><input type="text" value="'+data.data_isi[key-1].d_pcsdt_qty+'" name="fieldConfirmOrder[]" id="'+i+'" class="form-control input-sm field_qty_confirm currency" readonly style="text-align:right;"/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsdt_id+'" name="fieldIdDtOrder[]" class="form-control input-sm"/></td>'
                            +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                            +'<td align="right">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_prevcost)+'</td>'
                            +'<td align="right" id="price_'+i+'">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_price)+'</td>'
                            +'<td align="right" id="total_'+i+'">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_total)+'</td>'
                            +'<td align="right">'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'</td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove_row_order btn-sm" disabled>X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
          });
          $(this).maskFunc();
        }
        else
        {
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            $('#tabel-order-confirm').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                            +'<td>'+key+'</td>'
                            +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                            +'<td>'+formatAngka(data.data_isi[key-1].d_pcsdt_qty)+'</td>'
                            +'<td><input type="text" value="'+data.data_isi[key-1].d_pcsdt_qty+'" name="fieldConfirmOrder[]" id="'+i+'" class="form-control input-sm field_qty_confirm currency" readonly style="text-align:right;"/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsdt_id+'" name="fieldIdDtOrder[]" class="form-control input-sm"/></td>'
                            +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                            +'<td align="right">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_prevcost)+'</td>'
                            +'<td align="right" id="price_'+i+'">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_price)+'</td>'
                            +'<td align="right" id="total_'+i+'">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_total)+'</td>'
                            +'<td align="right">'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'</td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove_row_order btn-sm">X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
          });
          $(this).maskFunc();
        }
        
        $('#modal-confirm-order').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error get data from ajax');
      }
    });
  }

  function konfirmasiReturn(id,type) 
  {
    $.ajax({
      url : baseUrl + "/keuangan/konfirmasipembelian/confirm-return/"+id+"/"+type,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        var i = randString(5);
        $('#txt_span_status_return_confirm').text(data.spanTxt);
        $("#txt_span_status_return_confirm").addClass('label'+' '+data.spanClass);
        $("#id_return").val(data.header[0].d_pcsr_id);
        $("#status_return_confirm").val(data.header[0].d_pcsr_status);
        $('#lblCodeReturnConfirm').text(data.header[0].d_pcsr_code);
        $('#lblTglReturnConfirm').text(data.header2.tanggalReturn);
        $('#lblStaffReturnConfirm').text(data.header[0].m_name);
        $('#lblSupplierReturnConfirm').text(data.header[0].s_company);
        $('#lblTotalReturnConfirm').text(data.header2.hargaTotalReturn);
        
        if ($("#status_return_confirm").val() != "CF") 
        {
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            $('#tabel-return-confirm').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                            +'<td class="center">'+key+'</td>'
                            +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                            +'<td class="right">'+formatAngka(data.poQty[key-1].d_pcsdt_qty)+'</td>'
                            +'<td class="right">'+formatAngka(data.data_isi[key-1].d_pcsrdt_qty)+'</td>'
                            +'<td class="right">'+formatAngka(data.data_isi[key-1].d_pcsrdt_qty)
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsrdt_qty+'" name="fieldConfirmReturn[]" id="'+i+'" class="form-control input-sm field_qty_confirm currency">'
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsrdt_id+'" name="fieldIdDtReturn[]" class="form-control input-sm"/></td>'
                            +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                            +'<td id="price_'+i+'" class="right">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsrdt_price)+'</td>'
                            +'<td id="total_'+i+'" class="right">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsrdt_pricetotal)+'</td>'
                            +'<td class="right">'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'</td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove_row_order btn-sm" disabled>X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
          });
          $(this).maskFunc();
        }
        else
        {
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            $('#tabel-return-confirm').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                            +'<td class="center">'+key+'</td>'
                            +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                            +'<td class="right">'+formatAngka(data.poQty[key-1].d_pcsdt_qty)+'</td>'
                            +'<td class="right">'+formatAngka(data.data_isi[key-1].d_pcsrdt_qty)+'</td>'
                            +'<td class="right">'+formatAngka(data.data_isi[key-1].d_pcsrdt_qty)
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsrdt_qty+'" name="fieldConfirmReturn[]" id="'+i+'" class="form-control input-sm field_qty_confirm currency">'
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsrdt_id+'" name="fieldIdDtReturn[]" class="form-control input-sm"/></td>'
                            +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                            +'<td id="price_'+i+'" class="right">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsrdt_price)+'</td>'
                            +'<td id="total_'+i+'" class="right">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsrdt_pricetotal)+'</td>'
                            +'<td class="right">'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'</td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove_row_order btn-sm">X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
          });
          $(this).maskFunc();
        }
        
        $('#modal-confirm-return').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function konfirmasiBelanjaHarian(id,type) 
  {
    $.ajax({
      url : baseUrl + "/keuangan/konfirmasipembelian/confirm-belanjaharian/"+id+"/"+type,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        var i = randString(5);
        $('#txt_span_status_belanja_confirm').text(data.spanTxt);
        $("#txt_span_status_belanja_confirm").addClass('label'+' '+data.spanClass);
        $("#id_belanja").val(data.header[0].d_pcsh_id);
        $("#status_belanja_confirm").val(data.header[0].d_pcsh_status);
        $('#lblCodeBelanjaConfirm').text(data.header[0].d_pcsh_code);
        $('#lblTglBelanjaConfirm').text(data.header[0].d_pcsh_date);
        $('#lblPemintaBelanjaConfirm').text(data.header[0].d_pcsh_peminta);
        $('#lblKeperluanBelanjaConfirm').text(data.header[0].d_pcsh_keperluan);
        $('#lblTotalBelanjaConfirm').text(convertDecimalToRupiah(data.header[0].d_pcsh_totalprice));
        
        if ($("#status_belanja_confirm").val() != "CF") 
        {
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            $('#tabel-belanja-confirm').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                            +'<td>'+key+'</td>'
                            +'<td>'+data.data_isi[key-1].i_code+' | '+data.data_isi[key-1].i_name+'</td>'
                            +'<td>'+data.data_isi[key-1].d_pcshdt_qty+'</td>'
                            +'<td>'+data.data_isi[key-1].d_pcshdt_qty
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcshdt_qty+'" name="fieldConfirmBelanja[]" id="'+i+'" class="form-control input-sm field_qty_confirm currency">'
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcshdt_id+'" name="fieldIdDtBelanja[]" class="form-control input-sm"/></td>'
                            +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                            +'<td id="price_'+i+'">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcshdt_price)+'</td>'
                            +'<td id="total_'+i+'">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcshdt_pricetotal)+'</td>'
                            +'<td align="right">'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'</td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove_row_order btn-sm" disabled>X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
          });
          $(this).maskFunc();
        }
        else
        {
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            $('#tabel-belanja-confirm').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                            +'<td>'+key+'</td>'
                            +'<td>'+data.data_isi[key-1].i_code+' | '+data.data_isi[key-1].i_name+'</td>'
                            +'<td>'+data.data_isi[key-1].d_pcshdt_qty+'</td>'
                            +'<td>'+data.data_isi[key-1].d_pcshdt_qty
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcshdt_qty+'" name="fieldConfirmBelanja[]" id="'+i+'" class="form-control input-sm field_qty_confirm currency">'
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcshdt_id+'" name="fieldIdDtBelanja[]" class="form-control input-sm"/></td>'
                            +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                            +'<td id="price_'+i+'">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcshdt_price)+'</td>'
                            +'<td id="total_'+i+'">'+convertDecimalToRupiah(data.data_isi[key-1].d_pcshdt_pricetotal)+'</td>'
                            +'<td align="right">'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'</td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove_row_order btn-sm">X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
          });
          $(this).maskFunc();
        }
        
        $('#modal-confirm-belanjaharian').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }
 
  function submitConfirm(id) {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999, //jika form pd modal, jgn digunakan
      title: 'Konfirmasi rencana pembelian',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $('#button_confirm').text('Proses...');
          $('#button_confirm').attr('disabled',true);
          $.ajax({
            url : baseUrl + "/keuangan/konfirmasipembelian/confirm-plan-submit",
            type: "post",
            dataType: "JSON",
            data: $('#form-confirm-plan').serialize(),
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
                    $('#modal-confirm').modal('hide');
                    $('#button_confirm').text('Konfirmasi'); 
                    $('#button_confirm').attr('disabled',false); 
                    $('#tbl-daftar').DataTable().ajax.reload();
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
                    $('#modal-confirm').modal('hide');
                    $('#button_confirm').text('Konfirmasi'); //change button text
                    $('#button_confirm').attr('disabled',false); //set button enable 
                    $('#tbl-daftar').DataTable().ajax.reload();
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

  function submitOrderConfirm(id) {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999, //jika form pd modal, jgn digunakan
      title: 'Konfirmasi PO',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $('#button_confirm_order').text('Proses...');
          $('#button_confirm_order').attr('disabled',true);
          $.ajax({
            url : baseUrl + "/keuangan/konfirmasipembelian/confirm-order-submit",
            type: "post",
            dataType: "JSON",
            data: $('#form-confirm-order').serialize(),
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
                    $('#modal-confirm-order').modal('hide');
                    $('#button_confirm_order').text('Konfirmasi');
                    $('#button_confirm_order').attr('disabled',false); 
                    $('#tbl-order').DataTable().ajax.reload();
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
                    $('#modal-confirm-order').modal('hide');
                    $('#button_confirm_order').text('Konfirmasi');
                    $('#button_confirm_order').attr('disabled',false); 
                    $('#tbl-order').DataTable().ajax.reload();
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

  function submitReturnConfirm(id) {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999, //jika form pd modal, jgn digunakan
      title: 'Konfirmasi Retur Pembelian',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $('#button_confirm_return').text('Proses...'); //change button text
          $('#button_confirm_return').attr('disabled',true); //set button disable 
          $.ajax({
            url : baseUrl + "/keuangan/konfirmasipembelian/confirm-return-submit",
            type: "post",
            dataType: "JSON",
            data: $('#form-confirm-return').serialize(),
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
                    $('#modal-confirm-return').modal('hide');
                    $('#button_confirm_return').text('Konfirmasi'); //change button text
                    $('#button_confirm_return').attr('disabled',false); //set button enable 
                    $('#tbl-return').DataTable().ajax.reload();
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
                    $('#modal-confirm-return').modal('hide');
                    $('#button_confirm_return').text('Konfirmasi'); //change button text
                    $('#button_confirm_return').attr('disabled',false); //set button enable 
                    $('#tbl-return').DataTable().ajax.reload();
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

  function submitBelanjaConfirm(id) {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999, //jika form pd modal, jgn digunakan
      title: 'Konfirmasi Belanja Harian',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $('#button_confirm_belanja').text('Proses...'); 
          $('#button_confirm_belanja').attr('disabled',true); 
          $.ajax({
            url : baseUrl + "/keuangan/konfirmasipembelian/confirm-belanjaharian-submit",
            type: "post",
            dataType: "JSON",
            data: $('#form-confirm-belanjaharian').serialize(),
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
                    $('#modal-confirm-belanjaharian').modal('hide');
                    $('#button_confirm_belanja').text('Konfirmasi'); //change button text
                    $('#button_confirm_belanja').attr('disabled',false); //set button enable 
                    $('#tbl-belanjaharian').DataTable().ajax.reload();
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
                    $('#modal-confirm-belanjaharian').modal('hide');
                    $('#button_confirm_belanja').text('Konfirmasi'); //change button text
                    $('#button_confirm_belanja').attr('disabled',false); //set button enable 
                    $('#tbl-belanjaharian').DataTable().ajax.reload();
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

  function refreshTabelDaftar() 
  {
    $('#tbl-daftar').DataTable().ajax.reload();
  }

  function refreshTabelOrder() 
  {
    $('#tbl-order').DataTable().ajax.reload();
  }

  function refreshTabelBharian() 
  {
    $('#tbl-belanjaharian').DataTable().ajax.reload();
  }

  function refreshTabelReturn() 
  {
    $('#tbl-return').DataTable().ajax.reload();
  } 

  //mahmud
  function daftarReturnPenjualan(){
    var tablePenjualan = $('#tbl-returnpenjualan').DataTable({
    destroy: true,
    processing: true,
    serverSide: true,
    ajax: {
        url : baseUrl + "/keuangan/tabel/returnpenjualan",
    },
    columns: [
      //{data: 'DT_Row_Index', name: 'DT_Row_Index'},
      {data: 'dsr_date', name: 'dsr_date'},
      {data: 'dsr_code', name: 'dsr_code'},
      {data: 'dsr_method', name: 'dsr_method'},
      {data: 'dsr_jenis_return', name: 'dsr_jenis_return'},
      {data: 'dsr_type_sales', name: 'dsr_type_sales'},
      {data: 'dsr_status', name: 'dsr_status'},
      {data: 'action', name: 'action', orderable: false, searchable: false},
    ],
    language: {
      searchPlaceholder: "Cari Data",
      emptyTable: "Tidak ada data",
      sInfo: "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
      sSearch: '<i class="fa fa-search"></i>',
      sLengthMenu: "Menampilkan &nbsp; _MENU_ &nbsp; Data",
      infoEmpty: "",
      paginate: {
            previous: "Sebelumnya",
            next: "Selanjutnya",
         }
    }
  });  
  }

  function refreshReturnPenjualan(){
    daftarReturnPenjualan();
  }

  function lihatDetail(id){
     $.ajax({
        url: baseUrl + "/keuangan/returnpenjualan/getdata",
        type: 'get',
        data: {x: id},
        success: function (response) {
          $('#xx').html(response);
        }
    });
  }

function lihatDetailSB(id){
     $.ajax({
          url: baseUrl + "/keuangan/returnpenjualan/getdata/sb",
          type: 'get',
          data: {x: id},
          success: function (response) {
            $('#sb').html(response);
          }
      });
  }

  function submitReturnPenjualan(id){
    var status = $('#status_return_confirm').val();
    $.ajax({
        url: baseUrl + "/keuangan/returnpenjualan/update/" + status + '/' + id,
        type: 'get',
        success: function (response) {
          if (response.status == 'sukses') {
                    daftarReturnPenjualan();
                    $('#myItem').modal('hide');
                    $('#myItemSB').modal('hide');
                    iziToast.success({
                        timeout: 5000,
                        position: "topRight",
                        icon: 'fa fa-chrome',
                        title: '',
                        message: 'Berhasil Merubah Status.'
                    });
          }else{
                    iziToast.error({
                        position: "topRight",
                        title: '',
                        message: 'Gagal Merubah Status.'
                    });
          }
        }
    });

  }
  //end mahmud

</script>
@endsection()