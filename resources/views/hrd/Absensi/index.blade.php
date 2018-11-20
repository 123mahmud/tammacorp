@extends('main')
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Absensi</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Absensi</li>
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
              <a href="#alert-tab" data-toggle="tab">Absensi Manajemen</a>
            </li>
            <li><a href="#note-tab" data-toggle="tab" onclick="detTanggal()">Absensi Produksi</a></li>
                            {{-- <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> --> --}}
          </ul>

          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                  <div style="margin-left:-5px;">

                    <div class="panel-body">
                    		<a href="javascript:void(0);" onclick="javascipt:window.open('{{url('/public/assets/berkas/absensi-manajemen/contoh-master-manajemen.xlsx')}}');"><button class="btn btn-success">Download Contoh Master</button></a>
                        <a href="{{ url('/export/id-manajemen') }}"><button class="btn btn-success">Download ID Manajemen</button></a>
                    		<form
                          style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;     margin-bottom: 16px;"
                          action="{{url('/import/data-manajemen')}}"
                          class="form-horizontal"
                          method="POST"
                          enctype="multipart/form-data">
                          {{csrf_field()}}
                    			<input type="file" class="form-control-file" name="file">
                    			<input type="submit" value="Upload" class="btn btn-primary">
                    		</form>
                    </div>

                      <div class="col-md-1 col-sm-3 col-xs-12">
                          <label class="tebal">Tanggal:</label>
                      </div>
                        <form id="date">
                          <div class="col-md-3 col-sm-6 col-xs-12">
                              <div class="form-group">
                                  <div class="input-daterange input-group">
                                      <input id="datepicker01" class="form-control input-sm"
                                        name="tanggal">
                                        <span class="input-group-addon">-</span>
                                        <input id="datepicker02" class="input-sm form-control datepicker2"
                                               name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                                  </div>
                              </div>
                          </div>
                        </form>

                        <div class="col-md-2 col-sm-3 col-xs-12" align="center">
                            <button class="btn btn-primary btn-sm btn-flat autoCari" type="button"
                                    onclick="getTanggal()">
                                <strong>
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </strong>
                            </button>
                            <button class="btn btn-info btn-sm btn-flat refresh-data2" type="button"
                                    onclick="getTanggal()">
                                <strong>
                                    <i class="fa fa-undo" aria-hidden="true"></i>
                                </strong>
                            </button>
                        </div>

                      <div class="col-md-1 col-sm-3 col-xs-12">
                          <label class="tebal">Devisi:</label>
                      </div>

                      <div class="col-md-5 col-sm-3 col-xs-12" align="right">
                          <select name="tampilData" id="tampil_data" onchange="getTanggal()" class="form-control input-sm">
                            @foreach ($devisi as $divisi)
                              <option value="{{$divisi->c_id}}" class="form-control input-sm">{{$divisi->c_divisi}}</option>
                            @endforeach
                          </select>
                      </div>
                    </div>
                </div>


                <div class="col-lg-12">
                <div class="panel-body">
                  <div class="table-responsive">
                    <form id="Absensi">
                    <table id="tableAbsensi" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Tanggal</th>
                          <th>Kode - Nama Pegawai</th>
                          <th>Jam Kerja</th>
                          <th>Jam Masuk</th>
                          <th>Jam Pulang</th>
                          <th>Scan Masuk</th>
                          <th>Scan Pulang</th>
                          <th>Terlambat</th>
                          <th>Total Kerja</th>
                        </tr>
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
            </div>
            <!-- div note-tab -->
                <div id="note-tab" class="tab-pane fade">
                    <div class="row">
                        <div class="panel-body">

                          @include('hrd.Absensi.data-absensi')
                        </div>
                    </div>
                </div>
                <!-- End DIv note-tab -->
          </div>
        </div>
        @endsection @section('extra_scripts')
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
          $.extend($.fn.dataTableExt.oJUIClasses, extensions)

          var date = new Date();
          var newdate = new Date(date);

          newdate.setDate(newdate.getDate() - 6);
          var nd = new Date(newdate);

          $('.datepicker').datepicker({
              format: "mm",
              viewMode: "months",
              minViewMode: "months"
          });

          $('#datepicker01').datepicker({
              autoclose: true,
              format: "dd-mm-yyyy",
              endDate: 'today'
          }).datepicker("setDate", nd);

          $('#tanggal1').datepicker({
              autoclose: true,
              format: "dd-mm-yyyy",
              endDate: 'today'
          }).datepicker("setDate", nd);

          $('#tanggal2').datepicker({
              autoclose: true,
              format: "dd-mm-yyyy",
              endDate: 'today'
          });

          getTanggal();

        });

        function getTanggal(){
          $('#tableAbsensi').dataTable().fnDestroy();
          var tgl1 = $("#datepicker01").val();
          var tgl2 = $("#datepicker02").val();
          var data = $("#tampil_data").val();
          $('#tableAbsensi').DataTable({
              "scrollY": 500,
              "scrollX": true,
              "paging":  false,
              "autoWidth": false,
              "ajax": {
                  url: baseUrl + "/hrd/absensi/table/manajemen/" + tgl1 + "/" + tgl2 + "/" + data,
                  type: 'GET'
              },
              "columns": [
                // {"data" : "DT_Row_Index", orderable: false, searchable: false, "width" : "5%"},
                {"data" : 'tanggal', name: 'pegawai', width:"10%"},
                {"data" : 'pegawai', name: 'Alpha', orderable: false, width:"10%"},
                {"data" : 'apm_jam_kerja', name: 'apm_jam_kerja', orderable: false, width:"10%"},
                {"data" : 'apm_jam_masuk', name: 'apm_jam_masuk', orderable: false, width:"10%"},
                {"data" : 'apm_jam_pulang', name: 'apm_jam_pulang', orderable: false, width:"10%"},
                {"data" : 'apm_scan_masuk', name: 'apm_scan_masuk', orderable: false, width:"10%"},
                {"data" : 'apm_scan_pulang', name: 'apm_scan_pulang', orderable: false, width:"10%"},
                {"data" : 'apm_terlambat', name: 'apm_terlambat', orderable: false, width:"10%"},
                {"data" : 'apm_jml_jamkerja', name: 'apm_jml_jamkerja', orderable: false, width:"10%"},
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
      };

      function detTanggal(){
        $('#detailAbsensi').dataTable().fnDestroy();
        var tgl1 = $("#tanggal1").val();
        var tgl2 = $("#tanggal2").val();
        var tampil = $("#tampilDet").val();
        $('#detailAbsensi').DataTable({
            "ajax": {
                url: baseUrl + "/hrd/absensi/detail/" + tgl1 + "/" +tgl2+ "/" + tampil,
                type: 'GET'
            },
            "columns": [
              {"data" : 'tanggal', name: 'pegawai', width:"10%"},
              {"data" : 'pegawai', name: 'Alpha', orderable: false, width:"10%"},
              {"data" : 'app_jam_kerja', name: 'app_jam_kerja', orderable: false, width:"10%"},
              {"data" : 'app_jam_masuk', name: 'app_jam_masuk', orderable: false, width:"10%"},
              {"data" : 'app_jam_pulang', name: 'app_jam_pulang', orderable: false, width:"10%"},
              {"data" : 'app_scan_masuk', name: 'app_scan_masuk', orderable: false, width:"10%"},
              {"data" : 'app_scan_pulang', name: 'app_scan_pulang', orderable: false, width:"10%"},
              {"data" : 'app_terlambat', name: 'app_terlambat', orderable: false, width:"10%"},
              {"data" : 'app_jml_jamkerja', name: 'app_jml_jamkerja', orderable: false, width:"10%"},
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

        @endsection
