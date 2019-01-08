@extends('main')
@section('content')
    <!--BEGIN PAGE WRAPPER-->
    <div id="page-wrapper">
        <!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
            <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                <div class="page-title">Monitoring Order & Stock</div>
            </div>
            <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i
                            class="fa fa-angle-right"></i>&nbsp;&nbsp;
                </li>
                <li><i></i>&nbsp;Produksi&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                <li class="active">Monitoring Order & Stock</li>
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
                            <li class="active"><a href="#alert-tab" data-toggle="tab">Monitoring Order & Stock</a></li>
                        </ul>
                        <div id="generalTabContent" class="tab-content responsive">
                            <div id="alert-tab" class="tab-pane fade in active">
                                <div class="row" style="margin-top:-15px;">
                                    <!-- Modal Nota-->
                                    <div class="modal fade" id="nota" role="dialog">
                                        <div class="modal-dialog modal-lg">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color: #e77c38;">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                    <h4 class="modal-title" style="color: white;">Jumlah Nota</h4>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="table-responsive" id="table-nota">

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-warning " data-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal -->

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="col-md-8 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
                                        <div style="margin-left:-30px;">
                                          <div class="col-md-3 col-sm-2 col-xs-12">
                                            <label class="tebal">Tanggal Order</label>
                                          </div>

                                          <div class="col-md-6 col-sm-7 col-xs-12">
                                            <div class="form-group" style="display: ">
                                              <div class="input-daterange input-group">
                                                <input id="tanggal1" class="form-control input-sm datepicker1 " name="tanggal" type="text">
                                                <span class="input-group-addon">-</span>
                                                <input id="tanggal2" class="input-sm form-control datepicker2" name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                                          <button class="btn btn-primary btn-sm btn-flat fa fa-search" type="button" id="cariTanggal" onclick="cariOrder()">
                                           
                                          </button>
                                          <button class="btn btn-info btn-sm btn-flat" type="button" id="refresh" onclick="cariOrder()">
                                            <strong>
                                              <i class="fa fa-undo" aria-hidden="true"></i>
                                            </strong>
                                          </button>
                                        </div>
                                        
                                      </div>

                                        <div class="table-responsive" style="margin-top:10px;">
                                            <table class="table tabelan table-hover table-bordered" width="100%"
                                                   cellspacing="0" id="data">
                                                <thead>
                                                <tr>
                                                    <th>Kode Item</th>
                                                    <th width="25%">Nama Item</th>
                                                    <th>No Nota</th>
                                                    <th>Jumlah Order</th>
                                                    <th>Stok Grosir</th>
                                                    <th>Stok Produksi</th>
                                                    <th>Jumlah Kebutuhan</th>
                                                    <th>Jumlah Rencana Produksi</th>
                                                    <th>Jumlah Kekuarangan</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="note-tab" class="tab-pane fade">

                            </div><!--/div note-tab -->
                            <!-- div label-badge-tab -->
                            <div id="label-badge-tab" class="tab-pane fade">
                                <div class="row">
                                    <div class="panel-body">
                                        <!-- Isi content -->
                                    </div>
                                </div>
                            </div><!-- /div label-badge-tab -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section("extra_scripts")
    <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {

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

            $('.datepicker').datepicker({
              format: "mm",
              viewMode: "months",
              minViewMode: "months"
            });
            $('.datepicker1').datepicker({
              autoclose: true,
              format:"dd-mm-yyyy",
              endDate: 'today'
            }).datepicker("setDate", nd);
            $('.datepicker2').datepicker({
              autoclose: true,
              format:"dd-mm-yyyy",
              endDate: 'today'
            });//.datepicker("setDate", "0"); 

            cariOrder();

            $(document).on('click','.nota',function(){
                var id = $(this).data('id');
                var tgl1 = $(this).data('tgl1');
                var tgl2 = $(this).data('tgl2');
                var i_name = $(this).data('name');
                  $.ajax({
                    url : baseUrl + "/produksi/monitoringprogres/nota/"+id+"/"+tgl1+"/"+tgl2,
                    type: 'GET',     
                      success:function(response)
                      {
                        $('#table-nota').html(response);
                        $("#judul-item").text(i_name);
                      }
                  });
                });

            });

        function cariOrder()
        {   
            $('#data').dataTable().fnDestroy();
            var tgl1 = $('#tanggal1').val();
            var tgl2 = $('#tanggal2').val();
            var table = $('#data').dataTable({
                "responsive": true,
                "pageLength": 10,
                "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                "language": {
                    "searchPlaceholder": "Cari Data",
                    "emptyTable": "Tidak ada data",
                    "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
                    "infoFiltered": "",
                    "sSearch": '<i class="fa fa-search"></i>',
                    "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
                    "infoEmpty": "",
                    "zeroRecords": "Data tidak ditemukan",
                    "paginate": {
                        "previous": "Sebelumnya",
                        "next": "Selanjutnya",
                    }
                },

                "ajax": {
                    "url": baseUrl + "/penjualan/monitoringorder/tabel/" + tgl1 + "/" + tgl2,
                    "type": "GET",

                },
                "columns": [
                    {"data": "pp_item"},
                    {"data": "i_name"},
                    {"data": "nota"},
                    {"data": "jumlah", "className": "dt-body-right"},
                    { "data": "s_qtyGro" ,"className" : "dt-body-right" },
                    { "data": "s_qtyPro" ,"className" : "dt-body-right" },
                    {"data": "j_butuh", "className": "dt-body-right"},
                    {"data": "pp_qty", "className": "dt-body-right"},
                    {"data": "j_kurang", "className": "dt-body-right"},
                ],
                "order": [2, 'desc'],

            });

            $.fn.dataTable.ext.errMode = 'none';

            $('#data').on('error.dt', function (e, settings, techNote, message) {
                    location.reload();
            })
        }

        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd",
            altFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true
        });

    </script>
@endsection()