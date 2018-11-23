@extends('main') @section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">pegawai</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;Master&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">pegawai</li>
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
              <a href="#transfer" data-toggle="tab">Manajemen</a>
            </li>
            <li>
              <a href="#alert-tab" data-toggle="tab">Produksi</a>
            </li>
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <div id="transfer" class="tab-pane fade in active">
              <div class="row" style="margin-top:-20px;">
                <div class="panel-body">
                  <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 10px;">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                    </div>
                    <!-- <div class="col-md-6 col-sm-12 col-xs-12">
                      <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#myModal">Import</button>
                    </div> -->
                    <div class="col-md-8 col-sm-12 col-xs-12">
                      <a href="{{ url('master/datapegawai/tambah-pegawai') }}">
                        <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                          <i class="fa fa-plus" aria-hidden="true">
                            &nbsp;
                          </i>Tambah Data
                        </button>
                      </a>
                    </div>
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
                            <th class="wd-15p">Jabatan</th>
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
            <!-- div note-tab -->
            <div id="alert-tab" class="tab-pane fade">
              <div class="row">
                <div class="panel-body">
                  <div class="row" style="margin-top:-20px;">
                    <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 10px;">
                      <div class="col-md-4 col-sm-12 col-xs-12">
                      </div>
                      <!-- <div class="col-md-6 col-sm-12 col-xs-12">
                        <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#myModalPro">Import</button>
                      </div> -->
                      <div class="col-md-8 col-sm-12 col-xs-12">
                        <a href="{{ url('master/datapegawai/tambah-pegawai-pro') }}">
                          <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                            <i class="fa fa-plus" aria-hidden="true">
                              &nbsp;
                            </i>Tambah Data
                          </button>
                        </a>
                      </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="table-responsive">
                        <table id="tbl_pegawai_pro" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
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
              <!-- End DIv note-tab -->
            </div>
          <!-- End div generalTab -->
        </div>
      </div>
    </div>
  </div>
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <form action="{{ url('master/datapegawai/import') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Import data pegawai manajemen</h4>
          </div>
          <div class="modal-body">
            {{ csrf_field() }}
            <input type="file" name="import_file" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            <a href="{{ url('master/datapegawai/master-import') }}">
              <button type="button" class="btn btn-info">Download master</button>
            </a>
            <button type="submit" class="btn btn-info">Import</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div id="myModalPro" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <form action="{{ url('master/datapegawai/import-pro') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Import data pegawai produksi</h4>
            </div>
            <div class="modal-body">
              {{ csrf_field() }}
              <input type="file" name="import_file" />
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
              <a href="{{ url('master/datapegawai/master-import-pro') }}">
                <button type="button" class="btn btn-info">Download master</button>
              </a>
              <button type="submit" class="btn btn-info">Import</button>
            </div>
          </form>
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

    var tablePeg = $('#tbl_pegawai').DataTable({
      processing: true,
      // responsive:true,
      serverSide: true,
      ajax: {
        url: '{{ url("master/datapegawai/datatable-pegawai") }}',
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
    var tablePro = $('#tbl_pegawai_pro').DataTable({
      processing: true,
      // responsive:true,
      serverSide: true,
      ajax: {
        url: '{{ url("master/datapegawai/datatable-pegawaipro") }}',
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
        { "data": "c_jabatan_pro" },
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
    function hapus(id) {
      iziToast.question({
        timeout: 20000,
        close: false,
        overlay: true,
        toastOnce: true,
        id: 'question',
        zindex: 999,
        title: 'Hey',
        message: 'Apakah anda yakin?',
        position: 'center',
        buttons: [
          ['<button><b>YA</b></button>', function (instance, toast) {
            $.ajax({
              url: '{{ url("master/datapegawai/delete-pegawai") }}' + '/' + id,
              async: false,
              type: "DELETE",
              data: {
                "id": id,
                "_method": 'DELETE',
                "_token": '{{ csrf_token() }}',
              },
              dataType: "json",
              success: function (data) { }
            });
            tablePeg.ajax.reload();

            instance.hide({
                  transitionOut: 'fadeOutUp'
              }, toast);

          }, true],
          ['<button>TIDAK</button>', function (instance, toast) {

            instance.hide({
                  transitionOut: 'fadeOutUp'
              }, toast);

          }]
        ],
        onClosing: function (instance, toast, closedBy) {
          console.info('Closing | closedBy: ' + closedBy);
        },
        onClosed: function (instance, toast, closedBy) {
          console.info('Closed | closedBy: ' + closedBy);
        }
      });
    }
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
    function hapusPro(id) {
      iziToast.question({
        timeout: 20000,
        close: false,
        overlay: true,
        toastOnce: true,
        id: 'question',
        zindex: 999,
        title: 'Hey',
        message: 'Apakah anda yakin?',
        position: 'center',
        buttons: [
          ['<button><b>YA</b></button>', function (instance, toast) {
            $.ajax({
              url: '{{ url("master/datapegawai/delete-pegawai-pro") }}' + '/' + id,
              async: false,
              type: "DELETE",
              data: {
                "id": id,
                "_method": 'DELETE',
                "_token": '{{ csrf_token() }}',
              },
              dataType: "json",
              success: function (data) { }
            });
            tablePro.ajax.reload();
            instance.hide({
                  transitionOut: 'fadeOutUp'
              }, toast);

          }, true],
          ['<button>TIDAK</button>', function (instance, toast) {

            instance.hide({
                  transitionOut: 'fadeOutUp'
              }, toast);

          }]
        ],
        onClosing: function (instance, toast, closedBy) {
          console.info('Closing | closedBy: ' + closedBy);
        },
        onClosed: function (instance, toast, closedBy) {
          console.info('Closed | closedBy: ' + closedBy);
        }
      });
    }
    function editPro(a) {
      var parent = $(a).parents('tr');
      var id = $(parent).find('.d_id').text();
      console.log(id);
      $.ajax({
        type: "PUT",
        url: '{{ url("master/datapegawai/edit-pegawai-pro") }}' + '/' + a,
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

  </script>
  <style>
    .upload-btn-wrapper {
      position: relative;
      overflow: hidden;
      display: inline-block;
    }

    /* .upload-btn-wrapper input[type=file] {
          font-size: 100px;
          position: absolute;
          left: 0;
          top: 0;
          opacity: 0;
        } */
  </style>
  @endsection