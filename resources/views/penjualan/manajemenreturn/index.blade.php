@extends('main')
@section('content')
  <!--BEGIN PAGE WRAPPER-->
  <div id="page-wrapper">
      <!--BEGIN TITLE & BREADCRUMB PAGE-->
      <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
          <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
              <div class="page-title">Manajemen Return Penjualan</div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
              <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li class="active">Manajemen Return Penjualan</li>
          </ol>
          <div class="clearfix">
          </div>
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
                  <li class="active"><a href="#alert-tab" data-toggle="tab">Manajemen Return Penjualan</a></li>
                </ul>
                    <div id="generalTabContent" class="tab-content responsive">
                      <div id="alert-tab" class="tab-pane fade in active">
                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div align="right" style="margin-bottom: 10px;">
                              <a href="{{ url('/penjualan/returnpenjualan/tambahreturn') }}">
                                <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                                  <i class="fa fa-plus" aria-hidden="true">&nbsp;</i>
                                  Tambah Data
                                </button>
                              </a>
                            </div>
                            <div class="table-responsive">
                              <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tabel-sales-return">
                                <thead>
                                  <tr>
                                    <th class="wd-10p">Tgl Return</th>
                                    <th class="wd-15p">Nota</th>
                                    <th class="wd-10p">Metode</th>
                                    <th class="wd-10p">Jenis Return</th>
                                    <th class="wd-15p">Type Sales</th>
                                    <th class="wd-15p">Status</th>
                                    <th class="wd-15p">Aksi</th>
                                  </tr>
                                </thead>

                                <tbody>                 
                                </tbody>
                              </table> 
                            </div>   
                          </div> 
                        </div>    
                      </div>
                    <!-- /div alert-tab -->
                    <!-- End DIv note-tab -->

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

                     <!-- div label-badge-tab -->

                                         <!-- End DIv note-tab -->

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

                            <!-- div label-badge-tab -->

                  </div>
                </div>

@endsection
@section("extra_scripts")
  <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
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

      $('.datepicker').datepicker({
        format: "mm",
        viewMode: "months",
        minViewMode: "months"
      });
      $('.datepicker2').datepicker({
        format:"dd/mm/yyyy"
      });

  });

  var dataHarga =  $('#tabel-sales-return').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url : baseUrl + "/penjualan/returnpenjualan/tabel",
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

  function lihatDetail(id){
     $.ajax({
          url: baseUrl + "/penjualan/returnpenjualan/getdata",
          type: 'get',
          data: {x: id},
          success: function (response) {
            $('#xx').html(response);
          }
      });
  }

  function lihatDetailSB(id){
     $.ajax({
          url: baseUrl + "/penjualan/returnpenjualan/getdata/SB",
          type: 'get',
          data: {x: id},
          success: function (response) {
            $('#sb').html(response);
          }
      });
  }

  function simpanReturn(id){
      $.ajax({
          url: baseUrl + "/penjualan/returnpenjualan/return/"+ id,
          type: 'GET',
          success: function (response) {
            if (response.status == 'sukses') {
              iziToast.success({
                        timeout: 5000,
                        position: "topRight",
                        icon: 'fa fa-chrome',
                        title: '',
                        message: 'Data customer tersimpan.'
                    });
              window.open(baseUrl + "/penjualan/returnpenjualan/printreturn/" + id );
              window.open(baseUrl + "/penjualan/returnpenjualan/printfaktur/" + id );
            }else{
              iziToast.error({
                        position: "topRight",
                        title: '',
                        message: 'Mohon melengkapi data.'
                    });
            }
          }
      });
    }
  </script>
  
@endsection()