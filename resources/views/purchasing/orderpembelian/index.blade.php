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
            <div class="page-title">Order Pembelian</div>
        </div>

        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Order Pembelian</li>
        </ol>

        <div class="clearfix">
        </div>
      </div>

      <div class="page-content fadeInRight">
          <div class="col-lg-12" >
                <div class="col-lg-1" >
                </div>
                <div class="col-lg-2" >
                    <div style="background-color: #777;color: white;" class="alert alert-primary alert-dismissible" title="DP sudah Lunas">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>NOTICE !</strong> <br>
                        <label class="badge badge-pill badge-primary waiting">{{ $waiting }}</label>
                        waiting
                    </div>
                </div>
                <div class="col-lg-2" >
                    <div style="background-color: #ff6a00;color: white;" class="alert alert-primary alert-dismissible" title="DP sudah Lunas">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>NOTICE !</strong> <br>
                        <label class="badge badge-pill badge-primary confirm">{{ $confirm }}</label>
                        Diseujui
                    </div>
                </div>
                <div class="col-lg-2" >
                    <div style="background-color: #5cb85c;color: white;" class="alert alert-primary alert-dismissible" title="DP sudah Lunas">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>NOTICE !</strong> <br>
                        <label class="badge badge-pill badge-primary dapat_edit">{{ $dapat_edit }}</label>
                        dapat_edit
                    </div>
                </div>
                <div class="col-lg-2" >
                    <div style="background-color: #8d10dc;color: white;" class="alert alert-primary alert-dismissible" title="DP sudah Lunas">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>NOTICE !</strong> <br>
                        <label class="badge badge-pill badge-primary received">{{ $received }}</label>
                        received
                    </div>
                </div>
                <div class="col-lg-2" >
                    <div style="background-color: #d9534f;color: white;" class="alert alert-primary alert-dismissible" title="DP sudah Lunas">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>NOTICE !</strong> <br>
                        <label class="badge badge-pill badge-primary revisi">{{ $revisi }}</label>
                        revisi
                    </div>
                </div>
            </div>
        <div id="tab-general">
          <div class="row mbl">
            <div class="col-lg-12">
              @if (count($tempo) > 0)
                <div class="col-md-12">
                  <div class="panel panel-primary copyright-wrap" id="copyright-wrap">
                    <div class="panel-heading">Jatuh Tempo Pengiriman
                      <button type="button" class="close" data-target="#copyright-wrap" data-dismiss="alert"> <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="panel-body">
                      @foreach ($tempo as $key => $val)
                        <?php $key++; ?>
                        <p>{{$key.'. '.$val->d_pcs_code.' | '.$val->s_company.' | '.date('d M Y',strtotime($val->d_pcs_duedate))}}</p>
                      @endforeach
                    </div>
                  </div>
                </div>
              @endif

              <!-- <div class="col-md-4">
                <div class="panel panel-primary copyright-wrap" id="copyright-wrap">
                  <div class="panel-heading">Copyright Info
                    <button type="button" class="close" data-target="#copyright-wrap" data-dismiss="alert"> <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  </div>
                  <div class="panel-body">&copy; some random dude</a>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="panel panel-primary copyright-wrap" id="copyright-wrap">
                  <div class="panel-heading">Copyright Info
                    <button type="button" class="close" data-target="#copyright-wrap" data-dismiss="alert"> <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                  </div>
                  <div class="panel-body">&copy; some random dude</a>
                  </div>
                </div>
              </div> -->

              <div class="col-md-12">
                <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                </div>
              </div>

              <ul id="generalTab" class="nav nav-tabs ">
                <li class="active"><a href="#index-tab" data-toggle="tab">Order Pembelian</a></li>
                <li><a href="#note-tab" data-toggle="tab" onclick="lihatHistorybyTgl()">History Order Pembelian</a></li>
              </ul>

              <div id="generalTabContent" class="tab-content responsive">
                
                <!-- div index-tab -->  
                @include('purchasing.orderpembelian.tab-index')
                <!-- div history-tab -->
                @include('purchasing.orderpembelian.tab-history')
  
              </div>

            </div>
          </div>
        </div>
      </div>

      <!-- modal -->
      <!-- modal detail -->
      @include('purchasing.orderpembelian.modal')
      <!-- modal edit -->
      @include('purchasing.orderpembelian.modal-edit')
      <!-- modal detail peritem -->
      @include('purchasing.orderpembelian.modal-detail-peritem')
      <!-- /modal -->
  </div>

@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script src="{{ asset("js/inputmask/inputmask.jquery.js") }}"></script>
<script type="text/javascript">
  var save_method;
  $(document).ready(function() {
    //fix to issue select2 on modal when opening in firefox
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    //add bootstrap class to datatable
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
        digits: 2,
        autoGroup: true,
        prefix: '', //Space after $, this will not truncate the first character.
        rightAlign: false,
        oncleared: function () { self.Value(''); }
      });
    }

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

    // fungsi jika modal hidden
    $(".modal").on("hidden.bs.modal", function(){
      $('tr').remove('.tbl_modal_row');
      $('tr').remove('.tbl_modal_edit_row');
      $('tr').remove('.tbl_modal_detailmsk_row');
      //remove span class in modal detail
      $("#txt_span_status_detail").removeClass();
      $('#txt_span_status_edit').removeClass();
    });

    //event focus on input harga
    $(document).on('focus', '.field_harga',  function(e){
      $('#button_save').attr('disabled', true);
    });

    $(document).on('focus', '#potongan_harga',  function(e){
        var potHarga = convertToAngka($(this).val());
        $(this).val(potHarga);
        $('#button_save').attr('disabled', true);
    });

    $(document).on('focus', '#diskon_harga',  function(e){
        var discChar = convertToAngka($(this).val());
        $(this).val(discChar);
        $('#button_save').attr('disabled', true);
    });

    $(document).on('focus', '#ppn_harga',  function(e){
        var ppnChar = convertToAngka($(this).val());
        $(this).val(ppnChar);
        $('#button_save').attr('disabled', true);
    });

    //event onblur input harga
    $(document).on('blur', '.field_harga',  function(e){
      var getid = $(this).attr("id");
      var harga = $(this).val();
      var qtyOrder = $('#qty_'+getid+'').val();
      //hitung nilai harga total
      harga = harga.replace('.','');
      var valueHargaTotal = parseInt(qtyOrder) * parseFloat(harga.replace(',','.'));
      $('#total_'+getid+'').val(valueHargaTotal);
      //panggil fungsi
      totalPembelianGross();
      totalPembelianNett();
      $('#button_save').attr('disabled', false);
    });

    //event onblur potongan harga
    $(document).on('blur', '#potongan_harga',  function(e){
      //ubah format ke rupiah
      var potonganRp = convertToRupiah($(this).val());
      $(this).val(potonganRp);
      totalPembelianNett();
      $('#button_save').attr('disabled', false);
    });

    //event onblur diskon
    $(document).on('blur', '#diskon_harga',  function(e){
      //ubah format ke diskon
      var discSimbol = $(this).val();
      $(this).val(discSimbol+'%');
      totalPembelianNett();
      $('#button_save').attr('disabled', false);
    });

    //event onblur ppn
    $(document).on('blur', '#ppn_harga',  function(e){
      //ubah format ke diskon
      var ppnSimbol = $(this).val();
      $(this).val(ppnSimbol+'%');
      totalPembelianNett();
      $('#button_save').attr('disabled', false);
    });

    $('#tampil_data').on('change', function() {
      lihatHistorybyTgl();
    })

    //load fungsi
    lihatOrderByTanggal();

  });

  function detailOrder(id) 
  {
    $('#append-modal-detail div').remove();
    $.ajax({
      url : baseUrl + "/purchasing/orderpembelian/get-data-detail/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var i = randString(5);
        var key = 1;
        $('#txt_span_status_detail').text(data.spanTxt);
        $("#txt_span_status_detail").addClass('label'+' '+data.spanClass);
        $('#lblNoOrder').text(data.header[0].d_pcs_code);
        $('#lblCaraBayar').text(data.header[0].d_pcs_method);
        $('#lblTglOrder').text(data.header[0].d_pcs_date_created);
        $('#lblTglKirim').text(data.header[0].d_pcs_date_received);
        $('#lblStaff').text(data.header[0].m_name);
        $('#lblSupplier').text(data.header[0].s_company);
        $('[name="totalHarga"]').val(data.header2.hargaBruto);
        $('[name="diskonHarga"]').val(data.header2.nilaiDiskon);
        $('[name="ppnHarga"]').val(data.header2.nilaiPajak);
        $('[name="totalHargaFinal"]').val(data.header2.hargaNet);
        if (data.header[0].d_pcs_method != "CASH") 
        {
          $('#append-modal-detail div').remove();
          var metode = data.header[0].d_pcs_method;
          if (metode == "DEPOSIT") 
          {
            $('#append-modal-detail div').remove();
            $('#append-modal-detail').append('<div class="col-md-3 col-sm-12 col-xs-12">'
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
            $('#append-modal-detail div').remove();
            $('#append-modal-detail').append('<div class="col-md-3 col-sm-12 col-xs-12">'
                                      +'<label class="tebal">TOP (Termin Of Payment)</label>'
                                  +'</div>'
                                  +'<div class="col-md-3 col-sm-12 col-xs-12">'
                                    +'<div class="form-group">'
                                      +'<label id="dueDate">'+data.header[0].d_pcs_duedate+'</label>'
                                    +'</div>'
                                  +'</div>');
          }
        }
        //loop data
        Object.keys(data.data_isi).forEach(function(){
          $('#tabel-order').append('<tr class="tbl_modal_row" id="row'+i+'">'
                          +'<td>'+key+'</td>'
                          +'<td>'+data.data_isi[key-1].i_code+' | '+data.data_isi[key-1].i_name+'</td>'
                          +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                          +'<td>'+data.data_isi[key-1].d_pcsdt_qty+'</td>'
                          +'<td>'+data.data_stok[key-1].qtyStok+' '+data.data_satuan[key-1]+'</td>'
                          +'<td>'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_prevcost)+'</td>'
                          +'<td>'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_price)+'</td>'
                          +'<td>'+convertDecimalToRupiah(data.data_isi[key-1].d_pcsdt_total)+'</td>'
                          +'</tr>');
          key++;  
          i = randString(5);
        });
        $('#append-footer-detail').html('<a href="'+ baseUrl +'/purchasing/orderpembelian/print/'+id+'" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i>&nbsp;Print</a>'+
          '<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>');
        $('#modal-detail').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function lihatHistorybyTgl()
  {
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    var tampil = $('#tampil_data').val();
    $('#tbl-history').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url: baseUrl + "/purchasing/orderpembelian/get-data-tabel-history/"+tgl1+"/"+tgl2+"/"+tampil,
        type: 'GET'
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
        {"data" : "d_pcs_code", "width" : "10%"},
        {"data" : "i_name", "width" : "15%"},
        {"data" : "m_sname", "width" : "10%"},
        {"data" : "s_company", "width" : "15%"},
        {"data" : "tglBuat", "width" : "10%"},
        {"data" : "d_pcsdt_qtyconfirm", "width" : "5%"},
        {"data" : "tglTerima", "width" : "10%"},
        {"data" : "qtyTerima", "width" : "5%"},
        {"data" : "status", "width" : "10%"},
        {"data" : "action", "width" : "5%"}
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

  function lihatOrderByTanggal()
  {
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    $('#tbl-index').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url: baseUrl + "/purchasing/orderpembelian/get-order-by-tgl/"+tgl1+"/"+tgl2,
        type: 'GET'
      },
      columnDefs: [
        {
          targets: 6 ,
          className: 'right format_money'
        },
      ],
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
        {"data" : "tglOrder", "width" : "10%"},
        {"data" : "d_pcs_code", "width" : "10%"},
        {"data" : "m_name", "width" : "7%"},
        {"data" : "s_company", "width" : "13%"},
        {"data" : "d_pcs_method", "width" : "5%"},
        {"data" : "hargaTotalNet", "width" : "12%"},
        {"data" : "tglMasuk", "width" : "10%"},
        {"data" : "status", "width" : "7%"},
        {"data" : "action", orderable: false, searchable: false, "width" : "17%"}
      ],
      "responsive":true,
      "pageLength": 10,
      "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
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


    $.ajax({
        url: baseUrl + "/purchasing/orderpembelian/get-order-by-tgl-span/" + tgl1 + '/' + tgl2,
        type: 'get',
        success: function (response) {
            $('.waiting').html(response.waiting);
            $('.confirm').html(response.confirm);
            $('.dapat_edit').html(response.dapat_edit);
            $('.received').html(response.received);
            $('.revisi').html(response.revisi);
        }
    });

  }

  function detailMasukPeritem(id) 
  {
    $.ajax({
      url : baseUrl + "/purchasing/orderpembelian/get-penerimaan-peritem/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        var dateCreated = data.header[0].d_pcs_date_created;
        var newDateCreated = dateCreated.split("-").reverse().join("-");
        //ambil data ke json->modal
        $('#lblHeadItem').text('( '+data.isi[0].i_code+' '+data.isi[0].i_name+' )');
        $('#lblHeadPo').text(data.header[0].d_pcs_code);
        $('#lblHeadQty').text(data.header[0].d_pcsdt_qty);
        $('#lblHeadTglPo').text(data.header[0].d_pcs_date_created);
        $('#lblHeadSup').text(data.header[0].s_company);
        //loop data
        Object.keys(data.isi).forEach(function(){
          $('#tabel-detail-peritem').append('<tr class="tbl_modal_detailmsk_row">'
                          +'<td>'+key+'</td>'
                          +'<td>'+data.isi[key-1].i_code+' '+data.isi[key-1].i_name+'</td>'
                          +'<td>'+data.isi[key-1].m_sname+'</td>'
                          +'<td>'+data.isi[key-1].d_tbdt_qty+'</td>'
                          +'<td>'+data.isi[key-1].d_tb_code+'</td>'
                          +'<td>'+data.tanggalTerima[key-1]+'</td>'
                          +'</tr>');
          key++;
        });
        $('#modal_detail_peritem').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function editOrder(id) 
  {
    $('#append-modal-edit div').remove();
    $.ajax({
      url : baseUrl + "/purchasing/orderpembelian/get-edit-order/"+id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var totalHarga = 0;
        var key = 1;
        i = randString(5);
        $('#txt_span_status_edit').text(data.spanTxt);
        $("#txt_span_status_edit").addClass('label'+' '+data.spanClass);
        $('#id_purchase_edit').val(data.header[0].d_pcs_id);
        $('#lblNoOrderEdit').text(data.header[0].d_pcs_code);
        $('#lblCaraBayarEdit').text(data.header[0].d_pcs_method);
        $('#lblTglOrderEdit').text(data.header[0].d_pcs_date_created);
        $('#lblStaffEdit').text(data.header[0].m_name);
        $('#lblTglKirimEdit').text(data.header[0].d_pcs_date_received);
        $('#lblSupplierEdit').text(data.header[0].s_company);
        $('#total_gross').val(convertDecimalToRupiah(data.header[0].d_pcs_total_gross))
        $('#potongan_harga').val(convertDecimalToRupiah(data.header[0].d_pcs_discount))
        $('#diskon_harga').val(data.header[0].d_pcs_disc_percent+'%')
        $('#ppn_harga').val(data.header[0].d_pcs_tax_percent+'%')
        $('#total_nett').val(convertDecimalToRupiah(data.header[0].d_pcs_total_net))
        if (data.header[0].d_pcs_method != "CASH") 
        {
          $('#append-modal-edit div').remove();
          var metode = data.header[0].d_pcs_method;
          if (metode == "DEPOSIT") 
          {
            $('#append-modal-edit div').remove();
            $('#append-modal-edit').append('<div class="col-md-3 col-sm-12 col-xs-12">'
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
            $('#append-modal-edit div').remove();
            $('#append-modal-edit').append('<div class="col-md-3 col-sm-12 col-xs-12">'
                                      +'<label class="tebal">TOP (Termin Of Payment)</label>'
                                  +'</div>'
                                  +'<div class="col-md-3 col-sm-12 col-xs-12">'
                                    +'<div class="form-group">'
                                      +'<label id="dueDate">'+data.header[0].d_pcs_duedate+'</label>'
                                    +'</div>'
                                  +'</div>');
          }
        }
        //loop data
        Object.keys(data.data_isi).forEach(function(){
          var qtyCost = data.data_isi[key-1].d_pcsdt_qty;
          $('#tabel-edit').append(
            '<tr class="tbl_modal_edit_row">'
              +'<td style="text-align:center">'+key+'</td>'
              +'<td>'
                +'<input type="text" value="'+data.data_isi[key-1].i_code+' | '+data.data_isi[key-1].i_name+'" name="fieldNamaItem[]" class="form-control input-sm" readonly/>'
                +'<input type="hidden" value="'+data.data_isi[key-1].i_id+'" name="fieldItemId[]" class="form-control input-sm"/>'
                +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsdt_id+'" name="fieldIdPurchaseDt[]" class="form-control input-sm"/>'
                +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsdt_idpdt+'" name="fieldIdPlanDt[]" class="form-control input-sm"/>'
              +'</td>'
              +'<td>'
                +'<input type="text" value="'+separatorRibuan(qtyCost)+'" name="fieldQtyTxt[]" class="form-control input-sm" id="qtytxt_'+i+'" readonly style="text-align:right;"/>'
                +'<input type="hidden" value="'+qtyCost+'" name="fieldQty[]" class="form-control input-sm" id="qty_'+i+'"/>'
              +'</td>'
              +'<td>'
                +'<input type="text" value="'+data.data_isi[key-1].m_sname+'" name="fieldSatuan[]" class="form-control input-sm" readonly/>'
              +'</td>'
              +'<td>'
                +'<input type="text" value="'+data.data_isi[key-1].d_pcsdt_prevcost+'" name="fieldHargaPrev[]" class="form-control input-sm currency" readonly style="text-align:right;"/>'
              +'</td>'
              +'<td>'
                +'<input type="text" value="'+data.data_isi[key-1].d_pcsdt_price+'" name="fieldHarga[]" id="'+i+'" class="form-control input-sm field_harga currency" style="text-align:right;"/>'
              +'</td>'
              +'<td>'
                +'<input type="text" value="'+data.data_isi[key-1].d_pcsdt_total+'" name="fieldHargaTotal[]" class="form-control input-sm hargaTotalItem currency" id="total_'+i+'" readonly style="text-align:right;"/>'
              +'</td>'
              +'<td>'
                +'<input type="text" value="'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'" name="fieldStok[]" class="form-control input-sm" readonly style="text-align:right;"/>'
              +'</td>'
              +'<td>'
                +'<button name="remove" id="'+i+'" class="btn btn-danger btn_remove btn-sm">X</button>'
              +'</td>'
            +'</tr>');
          i = randString(5);
          key++;
        });
        $(this).maskFunc();
        $('#modal-edit').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function submitEdit()
  {
    iziToast.question({
      timeout: 20000,
      close: false,
      overlay: true,
      displayMode: 'once',
      title: 'Ubah Status',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url : baseUrl + "/purchasing/orderpembelian/update-data-order",
            type: "post",
            dataType: "JSON",
            data: $('#form-edit-order').serialize(),
            success: function(response)
            {
              if(response.status == "sukses")
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.success({
                  position: 'center',
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#btn_update').text('Update'); 
                    $('#btn_update').attr('disabled',false);
                    $('#modal-edit').modal('hide');
                    $('#tbl-index').DataTable().ajax.reload();
                  }
                });
              }
              else
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.error({
                  position: 'center', 
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#btn_update').text('Update');
                    $('#btn_update').attr('disabled',false);
                    $('#modal-edit').modal('hide');
                    $('#tbl-index').DataTable().ajax.reload();
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

  function deleteOrder(idPo, idPlan)  {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Hapus data PO',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url : baseUrl + "/purchasing/orderpembelian/delete-data-order",
            type: "POST",
            dataType: "JSON",
            data: {idPo:idPo, idPlan:idPlan, "_token": "{{ csrf_token() }}"},
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
                    $('#tbl-index').DataTable().ajax.reload();
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
                    $('#tbl-index').DataTable().ajax.reload();
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

  function convertDecimalToRupiah(decimal) 
  {
    var angka = parseInt(decimal);
    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    return hasil+',00';
  }

  function convertIntToRupiah(angka) 
  {
    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) 
      if(i%3 == 0) 
        rupiah += angkarev.substr(i,3)+'.';
    var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    return hasil+',00'; 
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
    $('[name="totalGrossEdit"]').val(total);
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
    var hasilNett = (parseInt(totalGross) - parseInt(potongan + discValue));
    var taxValue = hasilNett * tax / 100;
    var finalValue = parseInt(hasilNett + taxValue);
    // $('#total_nett').val(convertToRupiah(finalValue));
    // var hasilNett = (parseInt(totalGross) - (parseInt(potongan + discValue)) + taxValue);
    $('[name="totalNettEdit"]').val(convertToRupiah(finalValue));
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

  function separatorRibuan(num)
  {
    var num_parts = num.toString().split(".");
    num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return num_parts.join(".");
  }

  function separatorRibuanRp(num)
  {
    var num_parts = num.toString().split(".");
    num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return 'Rp. '+num_parts.join(",");
  }

  function refreshTabelIndex() 
  {
    $('#tbl-index').DataTable().ajax.reload();
  }

</script>
@endsection()