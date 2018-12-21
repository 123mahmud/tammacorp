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
        <div class="page-title">Laporan Penjualan Grosir</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Laporan Penjualan Grosir</li>
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
            <li class="active"><a href="#report-tab" data-toggle="tab">Daftar Penjualan Grosir</a></li>
            <li><a href="#draft-tab" data-toggle="tab">Daftar Draft Penjualan Grosir</a></li>
          </ul>

          <div id="generalTabContent" class="tab-content responsive">            
            @include('penjualan.laporangrosir.tab-laporan')          

            @include('penjualan.laporangrosir.tab-draft')          

          </div>
        </div>
      </div>
    </div>
  </div>
  <!--END TITLE & BREADCRUMB PAGE-->
  <!-- modal -->
  <!-- /modal -->
</div>
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
      autoclose: true,
      format:"dd-mm-yyyy",
      endDate: 'today'
    });//datepicker("setDate", "0");

    
    //force integer input in textfield
    $('input.numberinput').bind('keypress', function (e) {
        return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

    // fungsi jika modal hidden
    $(".modal").on("hidden.bs.modal", function(){
      $('tr').remove('.tbl_modal_detail_row');
      $('tr').remove('.tbl_modal_edit_row');
      //remove span class in modal detail
      $("#txt_span_status").removeClass();
      $('#txt_span_status_edit').removeClass();
    });

    /*$('#tampil_data').on('change', function() {
      lihatLaporanByTgl();
    })*/

    $('.refresh-data-history').click(function(event) {
      $('#tbl-history').DataTable().ajax.reload();
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

  /*function lihatLaporanByTgl(){
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    $.ajax({
      url: baseUrl + "/penjualan/laporanRetail/get-data-laporan/"+tgl1+"/"+tgl2,
      type: "GET",
      dataType: "JSON",
      success: function(response)
      {
        var $tbody = $('#tbl-laporan tbody');
        // clear table
        $tbody.empty();
        i = randString(5);
        var last = "";

        $.each(response.data, function(key, value) {
          // create new row
          var $row  = $("<tr></tr>");

          // append the outlet td if appropriate
          if(last != value.i_code)
          {
            // use array filter on the dataset to count rows for rowspan
            var len = response.data.filter(function(i,n){ return n.i_code === value.i_code }).length;
            // append the ted
            console.log(len);
            $row.append(  "<td align='left' rowspan='"+len+"'><font size='1'>"+ value.i_code +"</font></td>");
            // set up for next time
            last = value.i_code;
            console.log(last);
          }

          // append the rest of the td
          //$row.append("<td class='barang' style='text-align:left; vertical-align:middle'>"+ value.i_code +"</td>");
          $row.append("<td class='barang' style='text-align:left; vertical-align:middle'>"+ value.s_note +"</td>");
          $row.append("<td style='text-align:right; vertical-align:middle'>"+ value.s_date +"</td>");
          $row.append("<td style='text-align:right; vertical-align:middle'>"+ value.s_date +"</td>");
          $row.append("<td style='text-align:right; vertical-align:middle'>"+ value.c_name +"</td>");
          $row.append("<td style='text-align:right; vertical-align:middle'>1</td>");
          $row.append("<td style='text-align:right; vertical-align:middle'>"+ value.m_sname +"</td>");
          $row.append("<td style='text-align:right; vertical-align:middle'>"+ convertDecimalToRupiah(value.sd_price) +"</td>");
          $row.append("<td style='text-align:right; vertical-align:middle'>"+ convertDecimalToRupiah(value.sd_disc_value) +"</td>");
          $row.append("<td style='text-align:right; vertical-align:middle'>"+ value.sd_disc_percent +"%</td>");
          $row.append("<td style='text-align:right; vertical-align:middle'>"+ value.s_date +"</td>");
          //$row.append("<td></td>");
          $row.append("<td style='text-align:left; vertical-align:middle'>"+convertDecimalToRupiah(value.sd_total) +"</td>");
          //$("<td></td>");
          // append the row to the body
          $tbody.append($row);
        });
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }*/

  function lihatLaporanByTgl(){
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    $('#btn_print').html(
      '<div class="btn-group">'+
        '<a class="btn btn-primary" href="'+ baseUrl +'/penjualan/grosir/print_laporan_penjualan/'+ tgl1 +'/'+ tgl2 +'" '+ 
        'target="_blank"><i class="fa fa-print"></i>&nbsp;Print</a>'+
        '<a class="btn btn-warning" href="'+ baseUrl +'/penjualan/grosir/pdf_laporan_penjualan/'+ tgl1 +'/'+ tgl2 +'"><i class="fa fa-file-pdf-o"> PDF</i></a>'+
      '</div>'
      );
    $('#tbl-laporan').dataTable({
        "destroy": true,
        "processing" : true,
        "serverside" : true,
        "ajax" : {
          url: baseUrl + "/penjualan/laporanGrosir/get-data-laporan/"+tgl1+"/"+tgl2,
          type: 'GET'
        },
        "columns" : [
          {"data" : "nama", "width" : "15%", name: 'first'},
          {"data" : "s_note", "width" : "10%"},
          {"data" : "s_date", "width" : "10%"},
          {"data" : "s_date", "width" : "5%"},
          {"data" : "c_name", "width" : "10%"},
          {"data" : "kurs", "width" : "5%"},
          {"data" : "m_sname", "width" : "10%"},
          {"data" : "sd_qty", "width" : "5%"},
          {"data" : "sd_price", "width" : "10%"},
          {"data" : "sd_disc_value", "width" : "10%"},
          {"data" : "sd_disc_percent", "width" : "5%"},
          {"data" : "sd_total", "width" : "10%"}
        ],
        "rowsGroup": [
          'first:name'
        ],
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
  }
  
  function lihatLaporanByTglDraft(){
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    
    $('#tbl-draft').dataTable({
        "destroy": true,
        "processing" : true,
        "serverside" : true,
        "ajax" : {
          url: baseUrl + "/penjualan/laporan_grosir/get_data_laporan_draft/"+tgl1+"/"+tgl2,
          type: 'GET'
        },
        "columns" : [
          {"data" : "nama", "width" : "15%", name: 'first'},
          {"data" : "s_note", "width" : "10%"},
          {"data" : "s_date", "width" : "10%"},
          {"data" : "s_date", "width" : "5%"},
          {"data" : "c_name", "width" : "10%"},
          {"data" : "kurs", "width" : "5%"},
          {"data" : "m_sname", "width" : "10%"},
          {"data" : "sd_qty", "width" : "5%"},
          {"data" : "sd_price", "width" : "10%"},
          {"data" : "sd_disc_value", "width" : "10%"},
          {"data" : "sd_disc_percent", "width" : "5%"},
          {"data" : "sd_total", "width" : "10%"}
        ],
        "rowsGroup": [
          'first:name'
        ],
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
  }

  function convertDecimalToRupiah(decimal) 
  {
    var angka = parseInt(decimal);
    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    var hasil = rupiah.split('',rupiah.length-1).reverse().join('');
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

</script>
@endsection()