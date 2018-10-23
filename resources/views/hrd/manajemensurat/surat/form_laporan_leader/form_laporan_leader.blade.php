@extends('main') 

@section('extra_styles')
<style type="text/css">
  .vmiddle{
    vertical-align: middle !important;
  }
</style>
@endsection

@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Form Laporan Leader</div>
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
      <li class="active">Form Laporan Leader</li>
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
              <a href="#form-tab" data-toggle="tab">Form Laporan Leader</a>
            </li>
            <li>
              <a href="#list-tab" data-toggle="tab">List Form Laporan Leader</a>
            </li>
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <!-- /div form-tab -->
            @include('hrd.manajemensurat.surat.form_laporan_leader.form_laporan_leader_tab_index')
            <!-- /div form-tab -->

            {{-- list-tab --}}
            @include('hrd.manajemensurat.surat.form_laporan_leader.form_laporan_leader_tab_list')
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
  $('#tabel_laporan_leader').DataTable({
    processing: true,
    // responsive:true,
    serverSide: true,
    ajax: {
      url: '{{ url("hrd/manajemensurat/form_laporan_leader_datatable") }}',
    },
    columnDefs: [
      {
        targets: 0,
        className: 'center d_id'
      },
    ],
    "columns": [
      { "data": "DT_Row_Index" },
      { "data": "hari" },
      { "data": "fll_pic" },
      { "data": "fll_divisi"},
      { "data": "aksi" }
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

  function hapus(id){
    $.ajax({
      url:baseUrl+'/hrd/manajemensurat/form_laporan_leader_hapus/' +id,
      data:{
        "id":id,
        "method":"delete",
        "_token": '{{csrf_token()}}'
    },
      dataType:"JSON",
      success:function(response){
        nav_table();
        iziToast.success({
          title:"Sukses!",
          message:"Data Berhasil Dihapus"
        });
      },
      error:function(response){
        iziToast.error({
          title:"Gagal!",
          message:"Data Gagal Dihapus"
        });
      }

    });
  }
  
  $('.datepicker').datepicker({
    format : 'dd-mm-yyyy'
  });
  $('.select2').select2();

  $('.btn-simpan').on('click', function(){
    var forum_laporan_leader = $('#forum_laporan_leader').serialize();

    $.ajax({
      url: baseUrl + '/hrd/manajemensurat/form_laporan_leader_tambah',
      data: forum_laporan_leader,
      dataType:"JSON",
      success:function(response){
        $('html, body').animate({scrollTop:0}, "slow");
        $('#generalTab').find('a[href="#list-tab"]').click();
        $('#forum_laporan_leader')[0].reset();
        $('#nama').val('');
        $('#divisi').val('');
        iziToast.success({
          title:"Sukses!",
          message:"Data Berhasil Disimpan"
        });
        $('.hapus').click();
      },
      error:function(response){
        iziToast.error({
          title:"Gagal!",
          message:"Data Gagal Disimpan"
        });
      }
    });
  });

  function nav_table(){
    $('#tabel_laporan_leader').DataTable().ajax.reload();
  }

  $('a[href="#list-tab"]').on('click', function(){
    nav_table();
  });

  $('#pic').on('change', function(){
    var pic = $('#pic').val();

    $('.btn-simpan').attr('disabled', true);

    $.ajax({
      url:baseUrl+'/hrd/manajemensurat/form_laporan_leader_autocomplete',
      data:{pic},
      dataType:"JSON",
      success:function(response){
        $('.btn-simpan').attr('disabled', false);
        $('#nama').val(response[0].c_nama);
        $('#divisi').val(response[0].c_divisi);
      },
      error:function(response){
        $('.btn-simpan').attr('disabled', false);
      }
    });

  });

  $(document).ready(function(){
    var plus_append = 1;
    $(document).on('click', '.tambah', function(){
      if(plus_append != 12){
        plus_append+=1;
        $('#tabel_aktifitas tbody').append(
          '<tr>'+
            '<td class="vmiddle">#</td>'+
            '<td><textarea class="form-control" name="aktifitas[]" rows="3"></textarea></td>'+
            '<td><textarea class="form-control" name="keterangan[]" rows="3"></textarea></td>'+
            '<td class="vmiddle"><button type="button" class="btn btn-danger hapus"><i class="fa fa-trash-o"></i></button>'+
          '</tr>'
          );
      } else {
        alert('sudah 12');
      }
      
    });
    $(document).on('click', '.hapus', function(){
      $(this).parents('tr').remove();
      plus_append -= 1;
    });
  });

</script> 
@endsection