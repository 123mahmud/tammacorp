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
                            <li class=""><a href="#monitoringpenjualan" data-toggle="tab">Monitoring Penjualan</a></li>
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
                                        <div class="table-responsive" style="margin-top:10px;">
                                            <table class="table tabelan table-hover table-bordered" width="100%"
                                                   cellspacing="0" id="data">
                                                <thead>
                                                <tr>
                                                    <th>Kode Item</th>
                                                    <th width="25%">Nama Item</th>
                                                    <th>No Nota</th>
                                                    <th>Jumlah Order</th>
                                                    <th>Jumlah Stok</th>
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
                            <div id="monitoringpenjualan" class="tab-pane fade in active">
                                <div class="row" style="margin-top:-15px;">
                                    <div class="row">
                                        <div class="panel-body">
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>Range Tanggal</label>
                                                    <div>
                                                        <div class="input-daterange input-group" id="range-tanggal">
                                                            <input type="text" class="form-control start" name="start" value="{{ Carbon\Carbon::now('Asia/Jakarta')->format('m/d/Y')  }}" />
                                                            <span class="input-group-addon bg-custom text-white b-0">to</span>
                                                            <input type="text" class="form-control end" name="end" value="{{ Carbon\Carbon::now('Asia/Jakarta')->format('m/d/Y')  }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
        var datepicker_today;
        $(document).ready(function () {

            datepicker_today = $('#range-tanggal').datepicker({
                autoclose: true,
                toggleActive: true,
                todayHighlight: true,
                format: 'dd/mm/yyyy'
            });

            var extensions = {
                "sFilterInput": "form-control input-sm",
                "sLengthSelect": "form-control input-sm"
            }
// Used when bJQueryUI is false
            $.extend($.fn.dataTableExt.oStdClasses, extensions);
// Used when bJQueryUI is true
            $.extend($.fn.dataTableExt.oJUIClasses, extensions);
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
                    "url": baseUrl + "/penjualan/monitoringorder/tabel",
                    "type": "GET",

                },
                "columns": [
                    {"data": "pp_item"},
                    {"data": "i_name"},
                    {"data": "nota"},
                    {"data": "jumlah", "className": "dt-body-right"},
                    {"data": "s_qty", "className": "dt-body-right"},
                    {"data": "j_butuh", "className": "dt-body-right"},
                    {"data": "pp_qty", "className": "dt-body-right"},
                    {"data": "j_kurang", "className": "dt-body-right"},
                ],
                "order": [2, 'desc'],

            });

            $.fn.dataTable.ext.errMode = 'none';

            $('#data')
                .on('error.dt', function (e, settings, techNote, message) {
                    location.reload();
                })

            $(document).on('click', '.nota', function () {
                var a = $(this).data('id');
                $.ajax({
                    url: baseUrl + "/penjualan/monitoringorder/nota/" + a,
                    type: 'get',
                    success: function (response) {
                        $('#table-nota').html(response);
                    }
                });
            });

        });

        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd",
            altFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true
        });

    </script>
@endsection()