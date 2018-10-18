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
      <div class="page-title">Form Overhandle</div>
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
      <li class="active">Form Overhandle</li>
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
              <a href="#form-tab" data-toggle="tab">Form Overhandle</a>
            </li>
            <li>
              <a href="#list-tab" data-toggle="tab">List Form Overhandle</a>
            </li>
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <!-- /div form-tab -->
            @include('hrd.manajemensurat.surat.form_overhandle.form_overhandle_tab_index')
            <!-- /div form-tab -->

            {{-- list-tab --}}
            @include('hrd.manajemensurat.surat.form_overhandle.form_overhandle_tab_list')
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
  $('#tabel_overhandle').DataTable({
    processing: true,
    // responsive:true,
    serverSide: true,
    ajax: {
      url: '{{ url("hrd/manajemensurat/form_overhandle_datatable") }}',
    },
    columnDefs: [
      {
        targets: 0,
        className: 'center id'
      },
    ],
    "columns": [
      { "data": "DT_Row_Index" },
      { "data": "tgl" },
      { "data": "foh_surat" },
      { "data": "fohdt_nama1" },
      { "data": "fohdt_nama2" },
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

  function nav_table(){
    $('#tabel_overhandle').DataTable().ajax.reload();
  }

  $('a[href="#list-tab"]').on('click', function(){
    nav_table();
  });

    function hapus(id)
        {
          $.ajax({
            url : baseUrl + '/hrd/manajemensurat/hapus_form_overhandle/' + id,
            async: false,
            data: {
                "id":id,
                "_method": 'DELETE',
                "_token": '{{ csrf_token() }}'
              },
            dataType : "JSON",
            success:function(response){
              iziToast.success({
                title:"Sukses!",
                message:"Data Berhasil Dihapus"
              });
              nav_table();
            },
            error:function(response){
              iziToast.error({
                title:"Gagal!",
                message:"Data Gagal Dihapus"
              });
            }
          });
        }

  $(document).ready(function(){
    
        $('.input-daterange').datepicker({
          'format': 'dd-mm-yyyy',
        });
    $('#karyawan1').on('change', function(){
      $('.btn-simpan').attr("disabled", true);
      var id_karyawan1 = $('#karyawan1').val();

      if (!(id_karyawan1 === '') ) {

       $.ajax({
        url: baseUrl+"/hrd/manajemensurat/form_overhandle_autocomplete/",
        data:{id_karyawan1},
        dataType: "JSON",
        success:function(response){
          $('.btn-simpan').attr('disabled', false);
          // return response;
          $('#nama1').val(response[0].c_nama);
          $('#alamat1').val(response[0].c_alamat);
          $('#nik1').val(response[0].c_nik);
          $('#ktp1').val(response[0].c_ktp);
          $('#posisi1').val(response[0].c_posisi);
        },
        error:function(){
          $('.btn-simpan').attr('disabled', false);
        }

       });
      }else{
        $('#posisi1').val('');
        $('#nama1').val('');
        $('#alamat1').val('');
        $('#nik1').val('');
        $('#ktp1').val('');

      }

    });

    $('#karyawan2').on('change', function(){
      $('.btn-simpan').attr("disabled", true);
      var id_karyawan2 = $('#karyawan2').val();
      if (!(id_karyawan2 === '') ) {
       $.ajax({
        url: baseUrl+"/hrd/manajemensurat/form_overhandle_autocomplete2/",
        data:{id_karyawan2},
        dataType: "JSON",
        success:function(response){
          // return response;
          $('.btn-simpan').attr('disabled', false);
          $('#nama2').val(response[0].c_nama);
          $('#alamat2').val(response[0].c_alamat);
          $('#nik2').val(response[0].c_nik);
          $('#ktp2').val(response[0].c_ktp);
          $('#posisi2').val(response[0].c_posisi);
        },
        error:function(){
          $('.btn-simpan').attr('disabled', false);
        }

       });
     }else{
        $('#posisi2').val('');
        $('#nama2').val('');
        $('#alamat2').val('');
        $('#nik2').val('');
        $('#ktp2').val('');

      }
    });

    $('.btn-simpan').on('click', function(){
      var forum_overhandle = $('#forum_overhandle').serialize();

      $.ajax({
        url : baseUrl + '/hrd/manajemensurat/form_overhandle_tambah',
        dataType : "JSON",
        mathod:"GET",
        data: forum_overhandle,
        success:function(response){
          $('#forum_overhandle')[0].reset();
          $('#posisi1').val('');
          $('#nama1').val('');
          $('#alamat1').val('');
          $('#nik1').val('');
          $('#ktp1').val('');
          $('#posisi2').val('');
          $('#nama2').val('');
          $('#alamat2').val('');
          $('#nik2').val('');
          $('#ktp2').val('');

          $("html, body").animate({ scrollTop: 0 }, "slow");
          $('#generalTab').find('a[href="#list-tab"]').click();
          iziToast.success({
            title:"Sukses!",
            message:"Data Berhasil Disimpan"
          });
        },
        error:function(response){
          iziToast.error({
            title:"Gagal!",
            message:"Data Gagal Disimpan"
          });
        }

      })
    });

  });
</script> 
@endsection