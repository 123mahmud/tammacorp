@extends('main')
@section('content')
    <!--BEGIN PAGE WRAPPER-->
    <div id="page-wrapper">
        <!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
            <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                <div class="page-title">Payroll Pegawai Produksi</div>
            </div>
            <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i
                            class="fa fa-angle-right"></i>&nbsp;&nbsp;
                </li>
                <li><i></i>&nbsp;Produksi&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                <li class="active">Payroll Pegawai Produksi</li>
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
                            <li class="active"><a href="#alert-tab" data-toggle="tab" onclick="cariData()">Data Pegawai Produksi</a></li>
                            <li><a href="#note-tab" data-toggle="tab" onclick="cariGaji();pilihAbsensi()">Payroll Pegawai Produksi</a></li>
                        </ul>
                        <div id="generalTabContent" class="tab-content responsive">

                            <div id="alert-tab" class="tab-pane fade in active">
                            {{-- <div id="note-tab" class="tab-pane"> --}}
                                <div class="row">

                                  <div class="col-md-2 col-sm-12 col-xs-12">
                                      <label class="tebal">Rumah Produksi :</label>
                                  </div>
                                  <div class="col-md-4 col-sm-12 col-xs-12">
                                      <div class="form-group" align="pull-left">
                                          <select class="form-control input-sm" id="rumahData" name="c_rumah_produksi"
                                          style="width: 100%;" onclick="cariData()">
                                              @foreach ($produksi as $data)
                                                  <option class="form-control pemilik-gudang" value="{{ $data->mp_id }}">
                                                      - {{ $data->mp_name }}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-2 col-sm-12 col-xs-12">
                                      <label class="tebal">Item Produksi :</label>
                                  </div>
                                  <div class="col-md-4 col-sm-12 col-xs-12">
                                      <div class="form-group" align="pull-left">
                                          <select class="form-control input-sm" id="itemData"
                                          name="d_hg_cid" style="width: 100%;" onclick="cariData()">
                                              @foreach ($m_gaji_pro as $data)
                                                  <option class="form-control pemilik-gudang" value="{{ $data->c_id }}">
                                                      - {{ $data->nm_gaji }}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                  </div>

                                  <div class="col-md-2 col-sm-12 col-xs-12">
                                      <label class="tebal">Jabatan Pegawai :</label>
                                  </div>
                                  <div class="col-md-4 col-sm-12 col-xs-12">
                                      <div class="form-group" align="pull-left">
                                        <select class="form-control input-sm" id="jabatanData"
                                        name="c_jabatan_pro_id" style="width: 100%;" onclick="cariData()">
                                            @foreach ($c_jabatan_pro as $data)
                                                <option class="form-control pemilik-gudang" value="{{ $data->c_id }}">
                                                    - {{ $data->c_jabatan_pro }}</option>
                                            @endforeach
                                        </select>
                                      </div>
                                  </div>

                                  <div class="col-md-2 col-sm-12 col-xs-12">
                                      <label class="tebal">Tanggal :</label>
                                  </div>
                                  <div class="col-md-3 col-sm-12 col-xs-12">
                                      <div class="form-group" align="pull-left">
                                        <div class="input-daterange input-group">
                                           <input id="tanggal01" class="form-control input-sm datepicker1"
                                                   name="tanggal" type="text" value="">
                                           <span class="input-group-addon">-</span>
                                           <input id="tanggal02" class="input-sm form-control datepicker2"
                                                  name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                                        </div>
                                      </div>
                                  </div>

                                  <div class="col-md-1 col-sm-12 col-xs-12" align="right">
                                    <button class="btn btn-primary btn-sm btn-flat autoCari" type="button"
                                    onclick="cariData()">
                                        <strong>
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </strong>
                                    </button>
                                  </div>

                                      <div class="panel-body">
                                        <div class="table-responsive">
                                          <form id="formGarapan">
                                          <table class="table tabelan table-bordered table-hover" id="data-garapan"
                                                 width="100%">
                                              <thead>
                                              <tr>
                                                  {{-- <th>No.</th> --}}
                                                  <th>No.</th>
                                                  <th>NIK - Nama Pegawai</th>
                                                  <th>Item Produksi</th>
                                              </tr>
                                              </thead>

                                              <tbody>

                                              </tbody>
                                          </table>
                                          </form>
                                        </div>
                                      </div>

                                </div>
                            </div>

                            <div class="modal fade" id="myModalView" role="dialog">
                                <div class="modal-dialog modal-lg">
                                  <form id="myForm">
                                    <!-- Modal content-->
                                      <div class="modal-content">
                                        <div class="modal-header" style="background-color: #e77c38;">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title" style="color: white;">Payroll Pegawain Produksi</h4>
                                        </div>
                                        <div id="view-payroll">

                                        </div>
                                      </div>
                                    </form>
                                  </div>
                              </div>
                            <!-- /div alert-tab -->

                            <!-- div note-tab -->
                            <div id="note-tab" class="tab-pane fade">
                                <div class="row">
                                    <div class="panel-body">
                                        @include('hrd.payroll-produksi.data-garapan')
                                    </div>
                                </div>
                            </div>
                            <!--/div note-tab -->

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

                            newdate.setDate(newdate.getDate() - 2);
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
                            });

                            cariData();

                        });

                        function cariData() {
                            $('#data-garapan').dataTable().fnDestroy();
                            var Rumah = $('#rumahData').val();
                            var Item = $('#itemData').val();
                            var Jabatan = $('#jabatanData').val();
                            var tgl1 = $('#tanggal01').val();
                            var tgl2 = $('#tanggal02').val();
                            var tableActual = $('#data-garapan').DataTable({
                              "scrollY": 500,
                              "scrollX": true,
                              "paging":  false,
                              "autoWidth": false,
                                "ajax": {
                                    url: baseUrl + "/produksi/garapan/table/data/" + Rumah + "/" + Item + "/" + Jabatan + "/" + tgl1 + "/" + tgl2,
                                    type: 'GET'
                                },
                                "columns": [
                                  {"data" : "DT_Row_Index", searchable: false, "width" : "5%", className: "right"},
                                  {"data": 'pegawai', name: 'pegawai', "width": "55%"},
                                  {"data": 'item', name: 'Jumbo', "width": "40%"},
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

                        function cariGaji() {
                            $('#dataGaji').dataTable().fnDestroy();
                            var pilih = $('#pilihAbsensi').val()
                            if (pilih == 'GR') 
                            {
                              var Rumah = $('#rumahGaji').val();
                              var Jabatan = $('#jabatanGaji').val();
                              var tgl1 = $('#tanggal03').val();
                              var tgl2 = $('#tanggal04').val();
                              var tableActual = $('#dataGaji').DataTable({
                                "scrollY": 500,
                                "scrollX": true,
                                "paging":  false,
                                "autoWidth": false,
                                  "ajax": {
                                      url: baseUrl + "/hrd/payroll/table/gaji/GR/" + Rumah + "/" + Jabatan + "/" + tgl1 + "/" + tgl2,
                                      type: 'GET'
                                  },
                                  "columns": [
                                      {"data" : "DT_Row_Index", orderable: false, searchable: false, "width" : "5%"},
                                      {"data": 'kode', name: 'kode', "width": "20%"},
                                      {"data": 'pegawai', name: 'pegawai', "width": "55%"},
                                      {"data": 'gaji', name: 'gaji', "width": "20%"},
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
                            else
                            {
                              var Rumah = $('#rumahGaji').val();
                              var Jabatan = $('#jabatanGaji').val();
                              var tgl1 = $('#tanggal03').val();
                              var tgl2 = $('#tanggal04').val();
                              var tableActual = $('#dataGaji').DataTable({
                                "scrollY": 500,
                                "scrollX": true,
                                "paging":  false,
                                "autoWidth": false,
                                  "ajax": {
                                      url: baseUrl + "/hrd/payroll/table/gaji/" + Rumah + "/" + Jabatan + "/" + tgl1 + "/" + tgl2,
                                      type: 'GET'
                                  },
                                  "columns": [
                                      {"data" : "DT_Row_Index", orderable: false, searchable: false, "width" : "5%"},
                                      {"data": 'kode', name: 'kode', "width": "20%"},
                                      {"data": 'pegawai', name: 'pegawai', "width": "55%"},
                                      {"data": 'gaji', name: 'gaji', "width": "20%"},
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
                        }
                            

                        function detailGaji(id, tgl1, tgl2){
                          var tgl1 = $('#tanggal03').val();
                          var tgl2 = $('#tanggal04').val();
                          var pilih = $('#pilihAbsensi').val()
                          if (pilih == 'GR') 
                          {
                            $.ajax({
                              url : baseUrl + "/hrd/payroll/lihat-gaji/GR/"+ id + "/" + tgl1 + "/" + tgl2,
                              type: "get",
                              success: function(response){
                                $('#view-payroll').html(response);
                              }
                            })
                          }
                          else
                          {
                            $.ajax({
                              url : baseUrl + "/hrd/payroll/lihat-gaji/"+ id + "/" + tgl1 + "/" + tgl2,
                              type: "get",
                              success: function(response){
                                $('#view-payroll').html(response);
                              }
                            })
                          }
                          
                        }

                        function pilihAbsensi(){
                          var pilih = $('#pilihAbsensi').val()
                          $.ajax({
                            url : baseUrl + "/hrd/payroll/pilih/absensi/" + pilih,
                            type: "get",
                            success: function(response){
                              var key = 1;
                              Object.keys(response).forEach(function(){
                                $('#jabatanGaji').append($('<option>', { 
                                  value: response[key-1].c_id,
                                  text : response[key-1].c_jabatan_pro
                                  }));
                                key++;
                              });

                            }
                          })
                          $("#jabatanGaji").empty();
                          cariGaji();
                        }

                    </script>
@endsection()
