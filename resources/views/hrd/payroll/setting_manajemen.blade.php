@extends('main') @section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Setting Gaji</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Setting Gaji</li>
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
              <a href="#tunjangan-tab" data-toggle="tab">Tunjangan</a>
            </li>
            <li>
              <a href="#alert-tab" data-toggle="tab">Produksi</a>
            </li>
            <li>
              <a href="#potongan" data-toggle="tab">Potongan</a>
            </li>
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <div id="transfer" class="tab-pane fade in active">
              <div class="row">
                <div class="panel-body">
                  <div class="row" style="margin-top:-20px;">
                    <div class="col-lg-12">
                      <div class="pull-right" style="margin-bottom: 10px;">
                        <a href="{{ url('hrd/payroll/tambah-gaji-man') }}">
                          <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                            <i class="fa fa-plus" aria-hidden="true">
                              &nbsp;
                            </i>Tambah Data
                          </button>
                        </a>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                          <table id="tbl_man" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
                            <thead>
                              <tr>
                                <th>Nama</th>
                                <th>SMA</th>
                                <th>D3</th>
                                <th>S1</th>
                                <th>Pangkat</th>
                                <th>Action</th>
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
            <!-- div note-tab -->
            <div id="tunjangan-tab" class="tab-pane fade">
              <div class="row">
                <div class="panel-body">
                  <div class="row" style="margin-top:-20px;">
                    <div class="col-lg-12">
                      <div class="pull-right" style="margin-bottom: 10px;">
                        <a href="{{ url('hrd/payroll/set-tunjangan-pegawai-man') }}">
                          <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                            <i class="fa fa-gear" aria-hidden="true">
                              &nbsp;
                            </i>Set Tunjangan Pegawai
                          </button>
                        </a>
                        <a href="{{ url('hrd/payroll/tambah-tunjangan') }}">
                          <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                            <i class="fa fa-plus" aria-hidden="true">
                              &nbsp;
                            </i>Tambah Data
                          </button>
                        </a>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                          <table id="tbl_tunjangan" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0">
                            <thead>
                              <tr>
                                <th class="wd-15p">Nama</th>
                                <th class="wd-15p">Periode</th>
                                <th class="wd-15p">Nilai</th>
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
            <div id="alert-tab" class="tab-pane fade">
              <div class="row">
                <div class="panel-body">
                  <div class="row" style="margin-top:-20px;">
                    <div class="col-lg-12">
                      <div class="pull-right" style="margin-bottom: 10px;">
                        <a href="{{ url('hrd/payroll/tambah-gaji-pro') }}">
                          <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                            <i class="fa fa-plus" aria-hidden="true">
                              &nbsp;
                            </i>Tambah Data
                          </button>
                        </a>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                          <table id="tbl_pro" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
                            <thead>
                              <tr>
                                <th class="wd-15p">Nama</th>
                                <th class="wd-15p">Gaji</th>
                                <th class="wd-15p">Lembur</th>
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
            <div id="potongan" class="tab-pane fade">
              <div class="row">
                <div class="panel-body">
                  <div class="row" style="margin-top:-20px;">
                    <div class="col-lg-12">
                      <div class="pull-right" style="margin-bottom: 10px;">
                        <a href="{{ url('hrd/payroll/tambah-potongan') }}">
                          <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                            <i class="fa fa-plus" aria-hidden="true">
                              &nbsp;
                            </i>Tambah Data
                          </button>
                        </a>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                          <table id="tbl_pot" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
                            <thead>
                              <tr>
                                <th class="wd-15p">Nama</th>
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
      @endsection @section('extra_scripts')
      <script type="text/javascript">
        function samakan() {
          var jum = $('#jumlah').val();
          console.log(jum);
          $('#sd').val(jum);
          $('#smp').val(jum);
          $('#sma').val(jum);
          $('#d1').val(jum);
          $('#d2').val(jum);
          $('#d3').val(jum);
          $('#s1').val(jum);
        }
        var extensions = {
          "sFilterInput": "form-control input-sm",
          "sLengthSelect": "form-control input-sm"
        }
        // Used when bJQueryUI is false
        $.extend($.fn.dataTableExt.oStdClasses, extensions);
        // Used when bJQueryUI is true
        $.extend($.fn.dataTableExt.oJUIClasses, extensions)
        $('#tbl_man').DataTable({
          processing: true,
          // responsive:true, 
          serverSide: true,
          ajax: {
            url: '{{ url("hrd/payroll/datatable-gaji-man") }}',
          },
          columnDefs: [
            {
              targets: 0,
              className: 'center d_id'
            },
          ],
          "columns": [
            { "data": "nm_gaji" },
            { "data": "sma" },
            { "data": "d3" },
            { "data": "s1" },
            { "data": "pangkat" },
            { "data": "action" }
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
        $('#tbl_tunjangan').DataTable({
          processing: true,
          // responsive:true, 
          serverSide: true,
          ajax: {
            url: '{{ url("hrd/payroll/datatable-tunjangan-man") }}',
          },
          columnDefs: [
            {
              targets: 0,
              className: 'center d_id'
            },
          ],
          "columns": [
            { "data": "tman_nama" },
            { "data": "periode" },
            { "data": "nilai" },
            { "data": "action" }
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
        $('#tbl_pro').DataTable({
          processing: true,
          // responsive:true, 
          serverSide: true,
          ajax: {
            url: '{{ url("hrd/payroll/datatable-gaji-pro") }}',
          },
          columnDefs: [
            {
              targets: 0,
              className: 'center d_id'
            },
          ],
          "columns": [
            { "data": "nm_gaji" },
            { "data": "gaji" },
            { "data": "lembur" },
            { "data": "action" }
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
        $('#tbl_pot').DataTable({
          processing: true,
          // responsive:true, 
          serverSide: true,
          ajax: {
            url: '{{ url("hrd/payroll/datatable-potongan") }}',
          },
          columnDefs: [
            {
              targets: 0,
              className: 'center d_id'
            },
          ],
          "columns": [
            { "data": "c_nama" },
            { "data": "action" }
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
            url: '{{ url("hrd/payroll/edit-gaji-man/") }}' + '/' + a,
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
                  url: '{{ url("hrd/payroll/delete-gaji-man") }}' + '/' + id,
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
                window.location.reload();
                instance.hide(toast, { transitionOut: 'fadeOut' }, 'button');

              }, true],
              ['<button>TIDAK</button>', function (instance, toast) {

                instance.hide(toast, { transitionOut: 'fadeOut' }, 'button');

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
        function editTunjangan(a) {
          var parent = $(a).parents('tr');
          var id = $(parent).find('.d_id').text();
          console.log(id);
          $.ajax({
            type: "PUT",
            url: '{{ url("hrd/payroll/edit-tunjangan-man/") }}' + '/' + a,
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
        function hapusTunjangan(id) {
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
                  url: '{{ url("hrd/payroll/delete-tunjangan") }}' + '/' + id,
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
                window.location.reload();
                instance.hide(toast, { transitionOut: 'fadeOut' }, 'button');

              }, true],
              ['<button>TIDAK</button>', function (instance, toast) {

                instance.hide(toast, { transitionOut: 'fadeOut' }, 'button');

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
            url: '{{ url("hrd/payroll/edit-gaji-pro/") }}' + '/' + a,
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
                  url: '{{ url("hrd/payroll/delete-gaji-pro") }}' + '/' + id,
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
                window.location.reload();
                instance.hide(toast, { transitionOut: 'fadeOut' }, 'button');

              }, true],
              ['<button>TIDAK</button>', function (instance, toast) {

                instance.hide(toast, { transitionOut: 'fadeOut' }, 'button');

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
        function editPot(a) {
          var parent = $(a).parents('tr');
          var id = $(parent).find('.d_id').text();
          console.log(id);
          $.ajax({
            type: "PUT",
            url: '{{ url("hrd/payroll/edit-potongan/") }}' + '/' + a,
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
        function hapusPot(id) {
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
                  url: '{{ url("hrd/payroll/delete-potongan") }}' + '/' + id,
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
                window.location.reload();
                instance.hide(toast, { transitionOut: 'fadeOut' }, 'button');

              }, true],
              ['<button>TIDAK</button>', function (instance, toast) {

                instance.hide(toast, { transitionOut: 'fadeOut' }, 'button');

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
      </script> @endsection