@extends('main')
@section('content')
    <!--BEGIN PAGE WRAPPER-->
    <div id="page-wrapper">
        <!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
            <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                <div class="page-title">Data Garapan Produksi</div>
            </div>
            <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i
                            class="fa fa-angle-right"></i>&nbsp;&nbsp;
                </li>
                <li><i></i>&nbsp;Produksi&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                <li class="active">Data Garapan Produksi</li>
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
                            <li class="active"><a href="#alert-tab" data-toggle="tab" onclick="cariTanggal()">Data Garapan Produksi</a></li>
                            <li><a href="#note-tab" data-toggle="tab" onclick="cariData()">Data Garapan Produksi</a></li>
                        </ul>
                        <div id="generalTabContent" class="tab-content responsive">

                            <div id="alert-tab" class="tab-pane fade in active">
                                <div class="row">
                                  <form id="formGarapan">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                      <div class="col-md-2 col-sm-12 col-xs-12">
                                          <label class="tebal">Rumah Produksi :</label>
                                      </div>
                                      <div class="col-md-4 col-sm-12 col-xs-12">
                                          <div class="form-group" align="pull-left">
                                              <select class="form-control input-sm" id="Rumah" name="c_rumah_produksi"
                                              style="width: 100%;" onclick="cariTanggal()">
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
                                              <select class="form-control input-sm" id="Item"
                                              name="d_hg_cid" style="width: 100%;" onclick="cariTanggal()">
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
                                            <select class="form-control input-sm" id="Jabatan"
                                            name="c_jabatan_pro_id" style="width: 100%;" onclick="cariTanggal()">
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
                                            <input id="tanggal" class="form-control input-sm datepicker1"
                                                    name="d_hg_tgl" type="text" value="">
                                          </div>

                                      </div>

                                      <div class="col-md-1 col-sm-12 col-xs-12" align="right">
                                        <button class="btn btn-primary btn-sm btn-flat autoCari" type="button"
                                        onclick="cariTanggal()">
                                            <strong>
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                            </strong>
                                        </button>
                                      </div>

                                        <div class="panel-body">
                                          <div class="table-responsive">
                                            <table class="table tabelan table-bordered table-hover" id="tableGarapan"
                                                   width="100%">
                                                <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>NIK - Nama Pegawai</th>
                                                    <th>Item Produksi</th>
                                                </tr>
                                                </thead>

                                                <tbody>

                                                </tbody>
                                            </table>

                                          </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <button style="float: right" class="btn btn-primary" type="button"
                                              onclick="saveGarapan()">Simpan
                                            </button>
                                        </div>
                                      </form>
                                    </div>

                                </div>
                            </div>
                            <!-- /div alert-tab -->

                            <!-- div note-tab -->
                            <div id="note-tab" class="tab-pane fade">
                                <div class="row">
                                    <div class="panel-body">
                                        @include('produksi.Garapan.data-garapan')
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

                            $('.currenc').inputmask("currency", {
                               radixPoint: ".",
                               groupSeparator: ".",
                               digits: 2,
                               autoGroup: true,
                               prefix: '', //Space after $, this will not truncate the first character.
                               rightAlign: false,
                               oncleared: function () { self.Value(''); }
                            });

                            cariTanggal();                           

                        });

                        function cariTanggal() {
                           $('.currenc').inputmask("currency", {
                               radixPoint: ".",
                               groupSeparator: ".",
                               digits: 2,
                               autoGroup: true,
                               prefix: '', //Space after $, this will not truncate the first character.
                               rightAlign: false,
                               oncleared: function () { self.Value(''); }
                            });
                            $('#tableGarapan').dataTable().fnDestroy();
                            var Rumah = $('#Rumah').val();
                            var Item = $('#Item').val();
                            var Jabatan = $('#Jabatan').val();
                            var tgl = $('#tanggal').val();
                            var tableActual = $('#tableGarapan').DataTable({
                              "scrollY": 500,
                              "scrollX": true,
                              "paging":  false,
                              "autoWidth": false,
                                "ajax": {
                                    url: baseUrl + "/produksi/garapan/table/" + Rumah + "/" + Item + "/" + Jabatan + "/" + tgl,
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

                        function saveGarapan(){
                          $.ajaxSetup({
                              headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                          });
                          var a = $('#formGarapan').serialize();
                          $.ajax({
                              url: baseUrl + "/produksi/garapan/save",
                              type: 'GET',
                              data: a,
                              success: function (response) {
                                if (response.status == 'sukses') {
                                  iziToast.success({
                                      timeout: 5000,
                                      position: "topLeft",
                                      icon: 'fa fa-chrome',
                                      title: '',
                                      message: 'Berhasil Tersimpan.'
                                  });
                                }else {
                                  iziToast.error({
                                      position: "topLeft",
                                      title: '',
                                      message: 'Gagal Tersimpan.'
                                  });
                                }
                              }
                            });
                        }

                        function cariData() {
                            $('#data-garapan').dataTable().fnDestroy();
                            $('#tableGarapan').dataTable().fnDestroy();
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

                    </script>
@endsection()
