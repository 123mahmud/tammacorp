@extends('main') 

@section('extra_styles')
<style type="text/css">
  @media (min-width: 992px){
    .height25px{
      height: 25px;
    }
    .height45px{
      height: 45px;
    }
  }
</style>
@endsection

@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Form Keterangan Kerja</div>
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
      <li class="active">Form Keterangan Kerja</li>
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
              <a href="#form-tab" data-toggle="tab">Form Keterangan Kerja</a>
            </li>
            <li>
              <a href="#list-tab" data-toggle="tab">List Form Keterangan Kerja</a>
            </li>
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <!-- /div form-tab -->
            @include('hrd.manajemensurat.surat.form_keterangan_kerja.form_keterangan_kerja_tab_index')
            <!-- /div form-tab -->

            {{-- list-tab --}}
            @include('hrd.manajemensurat.surat.form_keterangan_kerja.form_keterangan_kerja_tab_list')
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
  $('#tabel_keterangan').DataTable({
    processing: true,
    // responsive:true,
    serverSide: true,
    ajax: {
      url: '{{ url("hrd/manajemensurat/form_keterangan_kerja_datatable") }}',
    },
    columnDefs: [
      {
        targets: 0,
        className: 'center d_id'
      },
    ],
    "columns": [
      { "data": "DT_Row_Index" },
      { "data": "tanggal_buat"},
      { "data": "fkj_kode" },
      { "data": "fkjdt_nama1" },
      { "data": "fkjdt_nama2"},
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
  
  $('.datepicker').datepicker({
    format : 'dd-mm-yyyy'
  });

  $('.select2').select2();


  $('.input-daterange').datepicker({
    'format': 'dd-mm-yyyy',
    changeMonth : true
  });

  function nav_table(){
    $('#tabel_keterangan').DataTable().ajax.reload();
  }

  $('a[href="#list-tab"]').on('click', function(){
    nav_table();
  });

  function hapus(id){
    $.ajax({
      url: baseUrl+'/hrd/manajemensurat/form_keterangan_kerja_hapus/'+id,
      dataType:"JSON",
      async:false,
      data:{
        "id":id,
        "method":"DELETE",
        "_token":"{{csrf_token()}}"
      },
      success:function(response){
        iziToast.success({
          title:"Sukses!",
          message:"Data Berhasil Dihapus"
        });
        $('#kode').attr('readonly', false);
        $('#kode').val(response);
        $('#kode').attr('readonly', true);
        nav_table();
      },
      error:function(response){
        iziToast.error({
          title:"Gagal!",
          message:"Data Gagal Dihapus"
        });
      }

    })
  }

  $('#karyawan1').on('change', function(){
    var karyawan1 = $('#karyawan1').val();
    $('.btn-simpan').attr('disabled', true);
    $.ajax({
      url : baseUrl + '/hrd/manajemensurat/form_keterangan_kerja_autocomplete',
      dataType : "JSON",
      data : {karyawan1},
      success : function(response){
        $('.btn-simpan').attr('disabled', false);
        $('#nama1').val(response[0].c_nama);
        $('#posisi1').val(response[0].c_posisi);
        $('#alamat1').val(response[0].c_alamat);
      },
      error: function(response){
        $('.btn-simpan').attr('disabled', true);
      }
    })

  });

  $('#karyawan2').on('change', function(){
    var karyawan2 = $('#karyawan2').val();
    $('.btn-simpan').attr('disabled', true);
    $.ajax({
      url : baseUrl + '/hrd/manajemensurat/form_keterangan_kerja_autocomplete2',
      dataType : "JSON",
      data : {karyawan2},
      success : function(response){
        $('.btn-simpan').attr('disabled', false);
        $('#nama2').val(response[0].c_nama);
        $('#posisi2').val(response[0].c_posisi);
        $('#alamat2').val(response[0].c_alamat);
        $('#ttl2').val(response[0].c_lahir);
      },
      error: function(response){
        $('.btn-simpan').attr('disabled', true);
      }
    })

  });

  $('.btn-simpan').on('click', function(){
    var forum_keterangan_kerja = $('#forum_keterangan_kerja').serialize();

    $.ajax({

      url: baseUrl+'/hrd/manajemensurat/form_keterangan_kerja_tambah',
      dataType: "JSON",
      data: forum_keterangan_kerja,
      success:function(response){
        
        $('#forum_keterangan_kerja')[0].reset();
        $('#nama1').val('');
        $('#posisi1').val('');
        $('#alamat1').val('');
        $('#nama2').val('');
        $('#posisi2').val('');
        $('#alamat2').val('');
        $('#ttl2').val('');
        $('#kode').attr('readonly', false);
        $('#kode').val(response[0]);
        $('#kode').attr('readonly', true);
        $('#generalTab').find('a[href="#list-tab"]').click();
        $('html, body').animate({scrollTop:0},"slow");
        iziToast.success({
          title:"Sukses!",
          message:"Data Berhasil Disimpan"
        });
      },
      error:function(response){
        iziToast.error({
          title:"Gagal!",
          message: "Data Gagal Disimpan"
        });
      }

    });
  });
</script> 
@endsection