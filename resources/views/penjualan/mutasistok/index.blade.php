@extends('main')
@section('content')
    <style type="text/css">
        .ui-autocomplete {
            z-index: 2147483647;
        }
    </style>
    <!--BEGIN PAGE WRAPPER-->
    <div id="page-wrapper">
        <!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
            <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                <div class="page-title">Mutasi Stok & Retail</div>
            </div>
            <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i
                            class="fa fa-angle-right"></i>&nbsp;&nbsp;
                </li>
                <li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                <li class="active">Mutasi Stok & Retail</li>
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
                            <li class="active">
                                <a href="#grosir-retail" data-toggle="tab">Grosir ke Retail</a>
                            </li>
                            <li class=""><a href="#monitoringpenjualan" data-toggle="tab" onclick="cari()">Monitoring Penjualan</a></li>
                            {{--<li>--}}
                                {{--<a href="#penjualan-retail" data-toggle="tab">Penjualan Retail</a>--}}
                            {{--</li>--}}
                        </ul>
                        <div id="generalTabContent" class="tab-content responsive">
                            <!-- grosir-retail -->
                        @include('penjualan.mutasistok.grosir-retail')
                        <!-- end grosir-retail  -->

                            <div id="monitoringpenjualan" class="tab-pane fade in">
                                <div class="row" style="margin-top:-15px;">
                                    <div class="row">
                                        <div class="panel-body form-horizontal">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="col-md-4">
                                                        <div class="input-daterange input-group" id="range-tanggal">
                                                            <input type="text" class="form-control input-sm start" name="start" value="{{ Carbon\Carbon::now('Asia/Jakarta')->format('m-d-Y')  }}" />
                                                            <span class="input-group-addon bg-custom">-</span>
                                                            <input type="text" class="form-control input-sm end" name="end" value="{{ Carbon\Carbon::now('Asia/Jakarta')->format('m-d-Y')  }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" class="form-control input-sm namacustomer" id="namacustomer" placeholder="Nama Customer">
                                                        <input type="hidden" class="form-control input-sm idCustomer" id="idCustomer">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input type="text" autocomplete="off" class="ui-autocomplete-input form-control input-sm namabarang" id="namabarang" placeholder="Nama Barang">
                                                        <input type="hidden" class="form-control input-sm idBarang" id="idBarang">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <select name="tampilData" id="tampil_data" onchange="tampilDataGrosir(this);" class="form-control input-sm">
                                                            <option value="Semua" class="form-control">Semua</option>
                                                            <option value="Retail" class="form-control">Retail</option>
                                                            <option value="Grosir" class="form-control">Grosir</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button class="btn btn-primary btn-sm" onclick="cari()"><i class="fa fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data-monitor">
                                                    <thead>
                                                    <tr>
                                                        <th>Nama Pembeli</th>
                                                        <th>Nota</th>
                                                        <th>Tanggal</th>
                                                        <th>Nama Barang</th>
                                                        <th>Qty</th>
                                                        <th>Harga</th>
                                                        <th>Disk Value</th>
                                                        <th>Disk %</th>
                                                        <th>DPP</th>
                                                        <th>PPN</th>
                                                        <th>Total</th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- div label-badge-tab -->
                            <div id="label-badge-tab" class="tab-pane fade">
                                <div class="row">
                                    <div class="panel-body">
                                        <!-- Isi content -->
                                    </div>
                                </div>
                            </div>
                            <!-- /div label-badge-tab -->
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
        var datamonitor;
        var datepicker_today;
        $(document).ready(function() {
            datepicker_today = $('#range-tanggal').datepicker({
                autoclose: true,
                toggleActive: true,
                todayHighlight: true,
                format: 'dd-mm-yyyy'
            });

            $('#namabarang').autocomplete({
                source: baseUrl + '/penjualan/POSretail/retail/transfer-item',
                minLength: 1,
                select: function (event, ui) {
                    $('.idBarang').val(ui.item.id);
                }
            });

            $("#namacustomer").autocomplete({
                source: baseUrl + '/penjualan/POSretail/retail/autocomplete',
                minLength: 1,
                select: function (event, ui) {
                    $('.idCustomer').val(ui.item.id);
                }
            });

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

            newdate.setDate(newdate.getDate() - 3);
            var nd = new Date(newdate);

            $('.datepicker').datepicker({
                format: "mm",
                viewMode: "months",
                minViewMode: "months"
            });

            $('.datepicker1').datepicker({
                autoclose: true,
                format: "dd-mm-yyyy",
                endDate: 'today'
            }).datepicker("setDate", nd);

            $('.datepicker2').datepicker({
                autoclose: true,
                format: "dd-mm-yyyy",
                endDate: 'today'
            });//datepicker("setDate", "0");

            getTanggal();

        });
        
        function cari() {
            var start = $('.start').val();
            var end = $('.end').val();
            var customer = $('#idCustomer').val();
            var item = $('#idBarang').val();
            var tampil = $('#tampil_data').val();

            if (start == ''){
                start = 'awal';
            }
            if (end == ''){
                end = 'akhir';
            }
            if (customer == ''){
                customer = 'semua';
            }
            if (item == ''){
                item = 'semua';
            }

            $("#data-monitor").dataTable().fnDestroy();

            datamonitor = $('#data-monitor').dataTable({
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
                    "url": baseUrl + '/penjualan/mutasi/monitoring-penjualan/' + tampil,
                    "data": {start: start, end: end, customer: customer, barang: item},
                    "type": "GET",

                },
                "columns": [
                    {"data": "c_name"},
                    {"data": "s_note"},
                    {"data": "s_date"},
                    {"data": "i_name"},
                    {"data": "sd_qty", className: 'right'},
                    {"data": "Harga"},
                    {"data": "sd_disc_value"},
                    {"data": "sd_disc_vpercent"},
                    {"data": "Dpp"},
                    {"data": "Ppn"},
                    {"data": "sd_total"},
                ],

            });
        }
        
        function getTanggal(){
          $('#GrosirRetail').dataTable().fnDestroy();
          var tgl1 = $('#tanggal1').val();
          var tgl2 = $('#tanggal2').val();
          $('#GrosirRetail').DataTable({
              processing: true,
              serverSide: true,
              ajax: {
                  url: baseUrl + "/penjualan/mutasi/stock/grosir-retail/"+tgl1+'/'+tgl2,
              },
              columns: [
                  {data: 'sm_date', name: 'sm_date', orderable: false, searchable: false},
                  {data: 'i_name', name: 'i_name', orderable: false},
                  {data: 'comp', name: 'comp', orderable: false},
                  {data: 'position', name: 'position', orderable: false},
                  {data: 'smc_note', name: 'smc_note', orderable: false},
                  {data: 'sm_qty', name: 'sm_qty', orderable: false, className: 'right'},
                  {data: 'sm_qty_used', name: 'sm_qty_used', orderable: false, className: 'right'},
                  {data: 'sm_qty_sisa', name: 'sm_qty_sisa', orderable: false, className: 'right'},
                  {data: 'sm_detail', name: 'sm_detail', orderable: false},
                  {data: 'sm_reff', name: 'sm_reff', orderable: false, searchable: false},
              ],
          });
        }


    </script>
@endsection()
