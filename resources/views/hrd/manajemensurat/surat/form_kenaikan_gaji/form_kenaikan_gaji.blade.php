@extends('main') 

@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Form Kenaikan Gaji atau Tingkat</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
          <a href="{{route('manajemensurat')}}">Manajemen Surat</a>
          &nbsp;&nbsp;
          <i class="fa fa-angle-right"></i>
      </li>
      <li class="active">Form Kenaikan Gaji atau Tingkat</li>
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
              <a href="#form-tab" data-toggle="tab">Form Kenaikan Gaji atau Tingkat</a>
            </li>
            <li>
              <a href="#list-tab" data-toggle="tab">List Form Kenaikan Gaji atau Tingkat</a>
            </li>
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <!-- /div form-tab -->
            @include('hrd.manajemensurat.surat.form_kenaikan_gaji.form_kenaikan_gaji_tab_index')
            <!-- /div form-tab -->
            {{-- list-tab --}}
            @include('hrd.manajemensurat.surat.form_kenaikan_gaji.form_kenaikan_gaji_tab_list')
            {{-- end list-tab --}}

          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection 

@section("extra_scripts")


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
  
  $('.datepicker').datepicker({
    format : 'dd-mm-yyyy'
  });
  $('.select2').select2();
</script> 
@endsection