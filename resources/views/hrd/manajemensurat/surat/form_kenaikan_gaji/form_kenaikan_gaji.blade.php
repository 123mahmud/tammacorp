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
              <a href="#list-tab" data-toggle="tab" onclick="getListPromosi()">List Form Kenaikan Gaji atau Tingkat</a>
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
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>

<script type="text/javascript">
  var id_divisi;
  var gaji;
  $(document).ready(function () {

    //fix to issue select2 on modal when opening in firefox
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        
    $('.datepicker1').datepicker({
      autoclose: true,
      format : 'dd-mm-yyyy'
    });

    //$('.select2').select2();
    $("select[name='pegawai']").select2({
      placeholder: "Pilih Pegawai",
      ajax: {
        url: baseUrl + '/hrd/manajemensurat/lookup-data-pegawai2',
        dataType: 'JSON',
        data: function (params) {
          return {
              q: $.trim(params.term)
          };
        },
        processResults: function (data) {
          data = data.map(function (item) {
              return {
                  id: item.id,
                  text: item.text,
                  divisi: item.divisi,
                  txtDivisi: item.txtDivisi,
                  tglAwalMasuk : item.tglAwalMasuk,
                  jabatan: item.jabatan,
                  txtJabatan : item.txtJabatan,
                  level: item.level,
                  txtLevel : item.txtLevel,
                  gapok : item.gapok
              };
          });
          return { results: data };
        },
        cache: true
      },
    });

    $("select[name='pegawai']").change(function(event) {
      var dataSelect = $("select[name='pegawai']").select2('data')[0];
      id_divisi = dataSelect.divisi;
      gaji = convertDecimalToRupiah(dataSelect.gapok);
      if(dataSelect.tglAwalMasuk != null) { var newDate = dataSelect.tglAwalMasuk.split("-").reverse().join("-"); }
      $("input[name='divisi']").val(dataSelect.txtDivisi);
      $("input[name='iddivisi']").val(dataSelect.divisi);
      $("input[name='tgl_awal_masuk']").val(newDate);
      $("input[name='jabatan_now']").val(dataSelect.txtJabatan);
      $("input[name='idjabatan_now']").val(dataSelect.jabatan);
      $("input[name='level_now']").val(dataSelect.txtLevel);
      $("input[name='idlevel_now']").val(dataSelect.level);
      $("input[name='tanggal_now']").val(newDate);
      $("input[name='gaji_now']").val(gaji);
    });

    $("select[name='jabatan']").select2({
      placeholder: "Pilih Jabatan",
      ajax: {
        url: baseUrl + '/hrd/manajemensurat/lookup-data-jabatan',
        dataType: 'JSON',
        data: function (params) {
          return {
              q: $.trim(params.term),
              divisi : id_divisi
          };
        },
        processResults: function (data) {
          data = data.map(function (item) {
              return {
                  id: item.id,
                  text: item.text,
                  idlevel: item.idlevel,
                  level: item.level
              };
          });
          return { results: data };
        },
        cache: true
      },
    });

    $("select[name='jabatan']").change(function(event) {
      var dataSelect = $("select[name='jabatan']").select2('data')[0];
      $("input[name='level']").val(dataSelect.level);
      $("input[name='idlevel']").val(dataSelect.idlevel);
      $("input[name='gaji']").val(gaji);
    });

    $("select[name='rekomendasi']").select2({
      placeholder: "Pilih Pegawai",
      ajax: {
        url: baseUrl + '/hrd/manajemensurat/lookup-data-pegawai2',
        dataType: 'JSON',
        data: function (params) {
          return {
              q: $.trim(params.term)
          };
        },
        processResults: function (data) {
          data = data.map(function (item) {
              return {
                  id: item.id,
                  text: item.text,
                  divisi: item.divisi,
                  txtDivisi: item.txtDivisi,
                  jabatan: item.jabatan,
                  txtJabatan : item.txtJabatan,
              };
          });
          return { results: data };
        },
        cache: true
      },
    });

    $("select[name='rekomendasi']").change(function(event) {
      var dataSelect = $("select[name='rekomendasi']").select2('data')[0];
      $("input[name='divisi_rekom']").val(dataSelect.txtDivisi+' | '+dataSelect.txtJabatan);
      $("input[name='iddivisi_rekom']").val(dataSelect.divisi);
      $("input[name='idjabatan_rekom']").val(dataSelect.jabatan);
    });

  });//end jquery

  function convertDecimalToRupiah(decimal) 
  {
    var angka = parseInt(decimal);
    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    var hasil = rupiah.split('',rupiah.length-1).reverse().join('');
    return hasil+',00';
  }

  function getListPromosi() {
    $('#tbl-promosi').DataTable({
      destroy: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: '{{ url("hrd/manajemensurat/data-promosi") }}',
      },
      columnDefs: [
        {
          targets: 0,
          className: 'center d_id'
        },
      ],
      "columns": [
        { "data": "nj_code" },
        { "data": "tanggal" },
        { "data": "c_nama" },
        { "data": "type" },
        { "data": "usul" },
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
              url: '{{ url("hrd/manajemensurat/delete-surat-promosi") }}' + '/' + id,
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