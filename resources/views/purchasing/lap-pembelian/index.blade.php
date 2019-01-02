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
      <div class="page-title">Laporan Pembelian</div>
    </div>
    
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Laporan Pembelian</li>
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
            <li class="active"><a href="#index-tab" data-toggle="tab" onclick="laporanByTanggal()">Laporan Pembelian PO</a></li>
            <li><a href="#harian-tab" data-toggle="tab" onclick="lapHarianByTgl()">Laporan Belanja Harian</a></li>
            <li><a href="#supplier-tab" data-toggle="tab" onclick="lapPemSupp()">Laporan Pembelian Supplier</a></li>
          </ul>
          
          <div id="generalTabContent" class="tab-content responsive">
            <!-- div index-tab -->  
            @include('purchasing.lap-pembelian.tab-index')
            <!-- div lap2-tab -->
            @include('purchasing.lap-pembelian.tab-laporan-harian')

            @include('purchasing.lap-pembelian.tab-laporan-pembelian')
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
<script type="text/javascript">
  var tanggal1;
  var tanggal2;
  var tanggal3;
  var tanggal4;
  $(document).ready(function() {
    var extensions = {
        "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);
    
    //force integer input in textfield
    $('input.numberinput').bind('keypress', function (e) {
        return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

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

    tanggal1 = $('#tanggal1').val();
    tanggal2 = $('#tanggal2').val();
    tanggal3 = $('#tanggal3').val();
    tanggal4 = $('#tanggal4').val();

    $('#tanggal1').change(function(event) {
      tanggal1 = $(this).val();
      $('#btn_print a').remove();
      $('#btn_print').html('<a href="'+ baseUrl +'/purchasing/lap-pembelian/print-lap-beli/'+tanggal1+'/'+tanggal2+'" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i>&nbsp;Print</a>');
    });

    $('#tanggal2').change(function(event) {
      tanggal2 = $(this).val();
      $('#btn_print a').remove();
      $('#btn_print').html('<a href="'+ baseUrl +'/purchasing/lap-pembelian/print-lap-beli/'+tanggal1+'/'+tanggal2+'" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i>&nbsp;Print</a>');
    });

    $('#tanggal3').change(function(event) {
      tanggal3 = $(this).val();
      $('#btn_print_harian a').remove();
      $('#btn_print_harian').html('<a href="'+ baseUrl +'/purchasing/lap-pembelian/print-lap-bharian/'+tanggal3+'/'+tanggal4+'" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i>&nbsp;Print</a>');
    });

    $('#tanggal4').change(function(event) {
      tanggal4 = $(this).val();
      $('#btn_print_harian a').remove();
      $('#btn_print_harian').html('<a href="'+ baseUrl +'/purchasing/lap-pembelian/print-lap-bharian/'+tanggal3+'/'+tanggal4+'" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i>&nbsp;Print</a>');
    });

    $('#tanggal6').change(function(event) {
      tanggal6 = $(this).val();
      $('#btn_print_namasupp a').remove();
      $('#btn_print_namasupp').html('<a href="'+ baseUrl +'/purchasing/lap-pembelian/print-lap-pembelian/'+tanggal5+'/'+tanggal6+'" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i>&nbsp;Print</a>');
    });

     // fungsi jika modal hidden
    $(".modal").on("hidden.bs.modal", function(){
      $('tr').remove('.tbl_modal_row');
    });
    
    $('#btn_print').html('<a href="'+ baseUrl +'/purchasing/lap-pembelian/print-lap-beli/'+tanggal1+'/'+tanggal2+'" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i>&nbsp;Print</a>');
    $('#btn_print_harian').html('<a href="'+ baseUrl +'/purchasing/lap-pembelian/print-lap-bharian/'+tanggal3+'/'+tanggal4+'" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i>&nbsp;Print</a>');
    $('#btn_print_namasupp').html('<a href="'+ baseUrl +'/purchasing/lap-pembelian/print-lap-pembelian/'+tanggal5+'/'+tanggal6+'" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i>&nbsp;Print</a>');

    laporanByTanggal();
  });//end jquery

  function laporanByTanggal()
  {
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    $('#data').dataTable({
      destroy: true,
      processing: true,
      serverSide: true,
      ajax : {
        url: baseUrl + "/purchasing/lap-pembelian/get-laporan-bytgl/"+tgl1+"/"+tgl2,
        type: 'GET'
      },
      columnDefs: [
        {
          targets: 0 ,
          className: 'center'
        }, 
        {
          targets: 6 ,
          className: 'right format_money'
        },
      ],
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"},
        {"data" : "d_pcs_code", "width" : "15%"},
        {"data" : "d_pcs_method", "width" : "10%"},
        {"data" : "m_name", "width" : "10%"},
        {"data" : "s_company", "width" : "30%"},
        {"data" : "tglOrder", "width" : "10%"},
        {"data" : "nett", "width" : "20%"}
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
  }

  function lapHarianByTgl()
  {
    var tgl3 = $('#tanggal3').val();
    var tgl4 = $('#tanggal4').val();
    $('#tbl-harian').dataTable({
      destroy: true,
      processing: true,
      serverSide: true,
      ajax : {
        url: baseUrl + "/purchasing/lap-pembelian/get-bharian-bytgl/"+tgl3+"/"+tgl4,
        type: 'GET'
      },
      columnDefs: [
        {
          targets: 0 ,
          className: 'center'
        }, 
        {
          targets: 6 ,
          className: 'right format_money'
        },
      ],
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"},
        {"data" : "d_pcsh_code", "width" : "10%"},
        {"data" : "m_name", "width" : "15%"},
        {"data" : "d_pcsh_peminta", "width" : "20%"},
        {"data" : "d_pcsh_keperluan", "width" : "20%"},
        {"data" : "tglOrder", "width" : "10%"},
        {"data" : "nett", "width" : "20%"}
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

  function lapPemSupp()
  {
    var tgl5 = $('#tanggal5').val();
    var tgl6 = $('#tanggal6').val();
    $('#tbl-pemsupplier').dataTable({
      destroy: true,
      processing: true,
      serverSide: true,
      ajax : {
        url: baseUrl + "/purchasing/lap-supplier/get-bytgl/"+tgl5+"/"+tgl6,
        type: 'GET'
      },
      columnDefs: [
        {
          targets: 0 ,
          className: 'center'
        }, 
      ],
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"},
        {"data" : "s_company", "width" : "20%"},
        {"data" : "d_pcs_date_created", "width" : "10%"},
        {"data" : "i_name", "width" : "20%"},
        {"data" : "d_pcsdt_price", "width" : "15%"},
        {"data" : "d_pcsdt_qtyconfirm", "width" : "10%"},
        {"data" : "m_sdetname", "width" : "10%"},
        {"data" : "total-harga", "width" : "15%"}
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
  }

</script>
@endsection()