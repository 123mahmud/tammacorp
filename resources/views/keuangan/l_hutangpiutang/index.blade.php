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
          <div class="col-lg-12">
              
            <div class="col-md-12">
              <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
              </div>
            </div>

            <ul id="generalTab" class="nav nav-tabs">
              <li class="active"><a href="#htgbeli-tab" data-toggle="tab">Hutang Pembelian</a></li>
              <li><a href="#htgjual-tab" data-toggle="tab">Hutang Penjualan</a></li>
              <!-- <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
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
    @include('keuangan.l_hutangpiutang.modal-detail-htgbeli')
    <!-- /modal -->
                  <!-- Modal -->
              <div class="modal fade" id="modal_buku_besar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document" style="width: 35%;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">Setting Buku Besar</h4>
                    </div>

                    <form id="form-jurnal" method="get" action="{{ route('laporan_hutang.index') }}" target="_blank">
                    <div class="modal-body">
                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Periode
                        </div>

                        <div class="col-md-4 durasi_bulan_buku_besar">
                          <input type="text" name="durasi_1_buku_besar_bulan" placeholder="periode Mulai" class="form-control" id="d1_buku_besar" autocomplete="off" required readonly style="cursor: pointer;">
                        </div>

                        <div class="col-md-1">
                          s/d
                        </div>

                        <div class="col-md-4 durasi_bulan_buku_besar">
                          <input type="text" name="durasi_2_buku_besar_bulan" placeholder="Periode Akhir" class="form-control" id="d2_buku_besar" autocomplete="off" required readonly style="cursor: pointer;">
                        </div>

                      </div>

                      <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-3">
                          Pilih Customer
                        </div>

                        <div class="col-md-9 durasi_bulan_buku_besar">
                          <select id="hitPenjualan" class="form-control select-2" name="akun_1">
                            <option value="all">Semua</option>
                            @foreach ($customer as $cus)
                              <option value="{{ $cus->c_id }}">{{ $cus->c_name }}</option>
                            @endforeach
                          </select>
                        </div>

                      </div>

                    </div>
                    
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary" onclick="lihatHutang()">Proses</button>
                    </div>

                    </form>
                  </div>
                </div>
              </div>
  <!--END PAGE WRAPPER-->  
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
    lihatHutangByTanggal();

    $('.select-2').select2();
  }); //end jquery

  function lihatHutangByTanggal()
  {
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    $('#tbl-htgbeli').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url: baseUrl + "/keuangan/l_hutangpiutang/get_hutang_by_tgl/"+tgl1+"/"+tgl2,
        type: 'GET'
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"},
        {"data" : "d_pcs_code", "width" : "20%"},
        {"data" : "s_company", "width" : "35%"},
        {"data" : "tglPo", "width" : "10%"},
        {"data" : "tglSelesai", "width" : "10%"},
        {"data" : "hargaTotalNet", "width" : "15%"},
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

  function lihatHutang(){
    
  }


</script>
@endsection()