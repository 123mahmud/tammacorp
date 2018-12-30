@extends('main')
@section('content')
    <style>
      .transaksi-wrapper{
        border: 1px solid #eee;
        border-radius: 10px;
        box-shadow: 0px 0px 10px #ccc;
        text-align: center;
        background: none;
        margin-left: 4.8em;
      }

      .transaksi-wrapper .icon{
        padding: 70px 0px 45px 0px;
        background: none;
        border-bottom: 1px solid #eee;
      }

      .transaksi-wrapper .icon i{
        font-size: 75pt;
      }

      .transaksi-wrapper .text{
        color: #999;
        font-size: 14pt;
        padding: 20px 0px;
        cursor: pointer;
      }

      .transaksi-wrapper .text:hover{
        color: #0d47a1;
      }
    </style>
  <!--BEGIN PAGE WRAPPER-->
  <div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
      <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
          <div class="page-title">Laporan Hutang Piutang</div>
      </div>
      <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
          <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
          <li><i></i>&nbsp;Keuangan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
          <li class="active">Laporan Hutang Piutang</li>
      </ol>
      <div class="clearfix"></div>
    </div>

    <div class="page-content fadeInRight">
      <div id="tab-general">
        <div class="row mbl">
          <div class="col-md-12 col-sm-12 col-xs-12">
              
            <div class="col-md-12">
              <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
              </div>
            </div>

            <ul id="generalTab" class="nav nav-tabs">
              <li class="active"><a href="#htgbeli-tab" data-toggle="tab">Laporan Hutang Piutang</a></li>
              <li><a href="#htgjual-tab" data-toggle="tab">Laporan Pembayaran</a></li>
            </ul>

            <div id="generalTabContent" class="tab-content responsive">
              <!-- div htgbeli-tab -->  
              @include('keuangan.l_hutangpiutang.tab-htgbeli')
              <!-- div htgjual-tab -->
              @include('keuangan.l_hutangpiutang.tab-htgjual')
            </div>
  
          </div>
        </div>
      </div><!-- end div#tab-general -->
    </div><!-- end div.page-content -->
    <!-- modal -->
    <!-- modal detail hutang pembelian -->
  {{--   @include('keuangan.l_hutangpiutang.modal-detail-htgbeli') --}}
    <!-- /modal -->
  </div>

@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script type="text/javascript">
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

    var date = new Date();
    var newdate = new Date(date);

    newdate.setDate(newdate.getDate()-7);
    var nd = new Date(newdate);

      $('.datepicker').datepicker({
        format: "mm",
        viewMode: "months",
        minViewMode: "months"
      });
      $('.datepicker1').datepicker({
        autoclose: true,
        format:"dd-mm-yyyy",
        // endDate: 'today'
      });
      $('.datepicker2').datepicker({
        autoclose: true,
        format:"dd-mm-yyyy",
        // endDate: 'today'
      });//.datepicker("setDate", "0"); 
      $('.datepicker3').datepicker({
        autoclose: true,
        format:"dd-mm-yyyy",
        // endDate: 'today'
      });
      $('.datepicker4').datepicker({
        autoclose: true,
        format:"dd-mm-yyyy",
        // endDate: 'today'
      });//.datepicker("setDate", "0"); 
    //force integer input in textfield
    $('input.numberinput').bind('keypress', function (e) {
        return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

    // fungsi jika modal hidden
    $(".modal").on("hidden.bs.modal", function(){
      //remove append tr
      $('tr').remove('.tbl_modal_detailhtg_row');
      //remove appending div
      $('#append-modal-detail div').remove();
      //set datepicker to today 
      $('.datepicker2').datepicker('setDate', 'today');  
    });

    //load list hutang
    $('.select-1').select2();
    $('.select-2').select2();
  }); //end jquery


</script>
@endsection()