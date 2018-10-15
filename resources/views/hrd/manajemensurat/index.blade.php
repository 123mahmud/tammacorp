@extends('main') 

@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Manajemen Surat</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Manajemen Surat</li>
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
              <a href="#index-tab" data-toggle="tab" onclick="cariTanggal()">Manajemen Surat</a>
            </li>
            {{-- <li>
              <a href="#finishResult-tab" data-toggle="tab" onclick="cariTanggal2()">Daftar SPK Selesai</a>
            </li> --}}
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <!-- /div index-tab -->
            <div id="index-tab" class="tab-pane fade in active">
              <div class="row" style="margin-top: -5px;">
                <div class="panel-body">



                  <div class="table-responsive">
                    <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" cellpadding="0" id="data1">
                      <tbody>
                        <!-- <tr>
                          <td><a href="{{route('form_application_print')}}" class="btn btn-block btn-secondary">Application form</a></td>
                        </tr> -->
                        <tr>
                          <td><a href="{{route('form_kenaikan_gaji')}}" class="btn btn-block btn-secondary">Form kenaikan gaji atau tingkat</a></td>
                        </tr>
                        <tr>
                          <td><a href="{{route('form_laporan_leader')}}" class="btn btn-block btn-secondary">Form laporan leader</a></td>
                        </tr>
                        <tr>
                          <td><a href="{{route('form_overhandle')}}" class="btn btn-block btn-secondary">Form overhandle</a></td>
                        </tr>
                        <tr>
                          <td><a href="{{route('form_permintaan')}}" class="btn btn-block btn-secondary">Form permintaan</a></td>
                        </tr>
                        <tr>
                          <td><a href="{{route('form_keterangan_kerja')}}" class="btn btn-block btn-secondary">Surat keterangan kerja</a></td>
                        </tr>
                        <tr>
                          <td><a href="{{ url('hrd/manajemensurat/surat-phk') }}" class="btn btn-block btn-secondary">Surat pemutusan hubungan kerja</a></td>
                        </tr>
                      </tbody>
                    </table> 
                  </div>
                </div>
              </div>
            </div>
            <!-- /div index-tab -->

            <!-- div finishResult-tab -->
            {{-- @include('produksi.spk.finish-result-tab') --}}
            <!-- End DIv finishResult-tab -->

          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection 

@section("extra_scripts")

{{-- <script src="{{ asset ('assets/script/icheck.min.js') }}"></script> --}}

<script type="text/javascript">
  var extensions = {
    "sFilterInput": "form-control input-sm",
    "sLengthSelect": "form-control input-sm"
  }
  // Used when bJQueryUI is false
  $.extend($.fn.dataTableExt.oStdClasses, extensions);
  // Used when bJQueryUI is true
  $.extend($.fn.dataTableExt.oJUIClasses, extensions);
  $('#tbl_jabatan').DataTable({
    processing: true,
    // responsive:true,
    serverSide: true,
    ajax: {
      url: '{{ url("hrd/datajabatan/data-jabatan") }}',
    },
    columnDefs: [
      {
        targets: 0,
        className: 'center d_id'
      },
    ],
    "columns": [
      { "data": "kode" },
      { "data": "c_posisi" },
      { "data": "c_divisi" },
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
      url: '{{ url("hrd/datajabatan/edit-jabatan") }}' + '/' + a,
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
            url: '{{ url("hrd/datajabatan/delete-jabatan") }}' + '/' + id,
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
</script> 
@endsection