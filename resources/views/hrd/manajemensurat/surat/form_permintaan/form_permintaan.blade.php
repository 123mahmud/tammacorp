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
      <div class="page-title">Form Permintaan Karyawan Baru</div>
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
      <li class="active">Form Permintaan Karyawan Baru</li>
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
              <a href="#form-tab" data-toggle="tab">Form Permintaan Karyawan Baru</a>
            </li>
            <li>
              <a href="#list-tab" data-toggle="tab">List Form Permintaan Karyawan Baru</a>
            </li>
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <!-- /div form-tab -->
            @include('hrd.manajemensurat.surat.form_permintaan.form_permintaan_tab_index')
            <!-- /div form-tab -->

            {{-- list-tab --}}
            @include('hrd.manajemensurat.surat.form_permintaan.form_permintaan_tab_list')
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
  $(document).ready(function(){

        var extensions = {
              "sFilterInput": "form-control input-sm",
              "sLengthSelect": "form-control input-sm"
            }
            // Used when bJQueryUI is false
            $.extend($.fn.dataTableExt.oStdClasses, extensions);
            // Used when bJQueryUI is true
            $.extend($.fn.dataTableExt.oJUIClasses, extensions);

            $('#form_permintaan_table').DataTable({
              destroy:true,
              processing: true,
              // responsive:true,
              serverSide: true,
              ajax: {
                url: '{{ route("form_permintaan_datatable") }}',
              },
              columnDefs: [
                {
                  targets: 0,
                  className: 'center d_id'
                },
              ],
              "columns": [
                { "data": "DT_Row_Index" },
                { "data": "tgl_pengujian" },
                { "data": "tgl_masuk" },
                { "data": "pkb_departement"},
                { "data": "aksi"},
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
        


       

        $('a[href="#list-tab"]').on('click', function(){
          nav_table();
        });

        $('.datepicker').datepicker({
          format : 'dd-mm-yyyy'
        });

        $('.select2').select2();


    
        $('.input-daterange').datepicker({
          'format': 'dd-mm-yyyy',
        });

        $('.hanya_angka').maskMoney({
          thousands : ',',
          decimal : '.'
        });

        



  });   


        $('.btn-simpan').on('click', function(){

          var forum_permintaan_asli = $('#forum_permintaan_asli').serialize();

          $posisi = $('#posisi');

          $pendidikan = $('#pendidikan');

          // $('#forum_permintaan_asli').validate().form();

          // var validator = $("#forum_permintaan_asli").validate({
          //   rules : {
          //     department : "required",
          //     tgl_pengujian : "required",
          //     tgl_masuk : "required",
          //     posisi : "required",
          //     jumlah_butuh: "required",
          //     jumlah_karyawan : "required",
          //     usia : "required",
          //     pendidikan : "required",
          //     pengalaman : "required",
          //     gaji : "required"

          //   },
          //   messages : {
          //     posisi : "Silahkan Pilih Posisi!",
          //     pendidikan : "Silahkan Pilih Pendidikan!"
          //   }
          // });


          $.ajax({
            url : baseUrl+'/hrd/manajemensurat/tambah_form_permintaan',
            data: forum_permintaan_asli,
            method : 'GET',
            dataType : "JSON",
            success : function(response){
              iziToast.success({
                title : "Sukses!",
                message : "Data Berhasil Disimpan"
              });
              $("html, body").animate({ scrollTop: 0 }, "slow");
              $('#forum_permintaan_asli')[0].reset();
              $('#generalTab').find('a[href="#list-tab"]').click();
            },
            error : function(response){
              iziToast.error({
                title : "Gagal",
                message : "Data Gagal Disimpan"
              });
            }

          });

        });
        

        function nav_table(){

          $('#form_permintaan_table').DataTable().ajax.reload();

        }

        function hapus(id)
        {
          $.ajax({
            url : baseUrl + '/hrd/manajemensurat/hapus_form_permintaan/' + id,
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
</script> 
@endsection