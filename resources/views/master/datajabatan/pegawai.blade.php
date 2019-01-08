@extends('main') @section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Master Data Pegawai</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;Master&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Master Data Pegawai</li>
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
              <a href="#alert-tab" data-toggle="tab">Master Data Pegawai</a>
            </li>
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row" style="margin-top:-20px;">
                <div class="col-md-12 col-sm-12 col-xs-12 " style="margin-top:15px;">
                  
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 10px;">
                  
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="table-responsive">
                    <table id="tbl_pegawai" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
                      <thead>
                        <tr>
                          <th class="wd-15p">ID</th>
                          <th class="wd-15p">NIK</th>
                          <th class="wd-15p">Nama Pegawai</th>
                          <th class="wd-15p">Tahun Masuk</th>
                          <th class="wd-15p">Tugas</th>
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
          </div>
        </div>
      </div>
      @endsection @section("extra_scripts")
      <script type="text/javascript">
        var extensions = {
          "sFilterInput": "form-control input-sm",
          "sLengthSelect": "form-control input-sm"
        }
        // Used when bJQueryUI is false
        $.extend($.fn.dataTableExt.oStdClasses, extensions);
        // Used when bJQueryUI is true
        $.extend($.fn.dataTableExt.oJUIClasses, extensions);

        $('#tbl_pegawai').DataTable({
          processing: true,
          // responsive:true,
          serverSide: true,
          ajax: {
            url: '{{ url("/hrd/datajabatan/datatable-pegawai") }}' + "/" + '{{Request::segment(4)}}'+ "/" + '{{Request::segment(5)}}',
          },
          columnDefs: [
            {
              targets: 0,
              className: 'center d_id'
            },
          ],
          "columns": [
            { "data": "c_code" },
            { "data": "c_nik" },
            { "data": "c_nama" },
            { "data": "c_tahun_masuk" },
            { "data": "c_posisi" },
            { "data": "action" },
          ],
          "responsive": true,

          "pageLength": 10,
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



        function edit(a) {
          var parent = $(a).parents('tr');
          var id = $(parent).find('.d_id').text();
          console.log(id);
          $.ajax({
            type: "PUT",
            url: '{{ url("master/datapegawai/edit-pegawai") }}' + '/' + a,
            data: { id },
            success: function (data) {
            },
            complete: function (argument) {
              window.location = (this.url)
            },
            error: function () {

            },
            async: false
          });
        }
        $('#tgl_masuk').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd'
        });
        function getpro(sel)
        {
          $('input.nik').val(sel);
        }
      </script> @endsection