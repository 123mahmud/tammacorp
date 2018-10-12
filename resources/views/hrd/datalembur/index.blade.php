@extends('main') 
@section('content')
<style type="text/css">
  .ui-autocomplete { z-index:2147483647; }
  .error { border: 1px solid #f00; }
  .valid { border: 1px solid #8080ff; }
  .has-error .select2-selection {
    border: 1px solid #f00 !important;
  }
  .has-valid .select2-selection {
    border: 1px solid #8080ff !important;
  }
</style>
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Data Lembur Pegawai</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Data Lembur Pegawai</li>
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
              <a href="#alert-tab" data-toggle="tab">Data Lembur Pegawai</a>
            </li>
          </ul>

          <div id="generalTabContent" class="tab-content responsive">
            <!-- /div alert-tab -->
            @include('hrd.datalembur.tab-index')
          </div>

        </div>
      </div>
    </div>
  </div> 
  @include('hrd.datalembur.modal')
  @include('hrd.datalembur.modal-detail')
  @include('hrd.datalembur.modal-edit')
</div>
@endsection 
@section("extra_scripts")
  <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      //fix to issue select2 on modal when opening in firefox
      $.fn.modal.Constructor.prototype.enforceFocus = function() {};

      var extensions = {
          "sFilterInput": "form-control input-sm",
          "sLengthSelect": "form-control input-sm"
      }
      // Used when bJQueryUI is false
      $.extend($.fn.dataTableExt.oStdClasses, extensions);
      // Used when bJQueryUI is true
      $.extend($.fn.dataTableExt.oJUIClasses, extensions);

      var date = new Date();
      var newdate = new Date(date);
      newdate.setDate(newdate.getDate()-30);
      var nd = new Date(newdate);

      //timepicker
      var timepicker = new TimePicker(['jam_awal', 'jam_akhir','jam_awal_edit', 'jam_akhir_edit'], {
        theme: 'dark', // 'blue-grey'
        lang: 'en'
      });

      timepicker.on('change', function(evt) {
        var value = (evt.hour || '00') + ':' + (evt.minute || '00');
        if (evt.element.id == 'jam_awal') {
          evt.element.value = value;
        } else {
          evt.element.value = value;
        }
      });
      //end timepicker
      
      //datepicker
      $('.datepicker1').datepicker({
        autoclose: true,
        format:"dd-mm-yyyy",
        endDate: 'today'
      }).datepicker("setDate", nd);

      $('.datepicker2').datepicker({
        autoclose: true,
        format:"dd-mm-yyyy",
        endDate: 'today'
      });//datepicker("setDate", "0");
      //end datepicker
      
      // fungsi jika modal hidden
      $(".modal").on("hidden.bs.modal", function(){
        //remove append tr
        $('tr').remove('.tbl_modal_detail_row');
        //remove class all jquery validation error
        $('.form-group').find('.error').removeClass('error');
        $('.form-group').removeClass('has-valid has-error');
        //reset all input txt field
        $('#form-lembur')[0].reset();
        $('#form-lembur-detail')[0].reset();
        //empty select2 field
        $('.jenis_pegawai').val('');
        $('.kode_divisi').empty();
        $('.kode_jabatan').empty();
        $('.pegawai').empty();
      });

      //select2
      $('.select2').select2({
      });

      var jenis;
      var divisi;
      $('.jenis_pegawai').change(function() 
      {
        if($(this).val() != ""){
          $('.divjenis').removeClass('has-error').addClass('has-valid');
          $('.kode_divisi').empty().attr('disabled', false);
          $('.kode_jabatan').empty().attr('disabled', false);
          $('.pegawai').empty().attr('disabled', false);
        }else{
          $('.divjenis').addClass('has-error').removeClass('has-valid');
          $('.kode_divisi').empty().attr('disabled', true);
          $('.kode_jabatan').empty().attr('disabled', true);
          $('.pegawai').empty().attr('disabled', true);
        }

        $('.kode_divisi').empty().attr('disabled', false);
        $('.kode_jabatan').empty().attr('disabled', false);
        jenis = $(this).val();

        $(".kode_divisi").select2({
          placeholder: "Pilih Divisi",
          ajax: {
            url: baseUrl + '/hrd/datalembur/lookup-data-divisi',
            dataType: 'json',
            data: function (params) {
              return {
                  q: $.trim(params.term),
                  jenis : jenis
              };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
          }, 
        });
      });

      $('.kode_divisi').change(function() 
      {
        if($(this).val() != ""){
          $('.divDivisi').removeClass('has-error').addClass('has-valid');
        }else{
          $('.divDivisi').addClass('has-error').removeClass('has-valid');
        }
        $('.kode_jabatan').empty().attr('disabled', false);
        divisi = $(this).val();
        var jenis2 = jenis;
        // console.log(jenis2);
        $(".kode_jabatan").select2({
          placeholder: "Pilih Jabatan...",
          ajax: {
            url: baseUrl + '/hrd/datalembur/lookup-data-jabatan',
            dataType: 'json',
            data: function (params) {
              return {
                  q: $.trim(params.term),
                  divisi : divisi,
                  jenis : jenis2
              };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
          }, 
        });
      });

      $('.kode_jabatan').change(function() 
      {
        if($(this).val() != ""){
          $('.divJabatan').removeClass('has-error').addClass('has-valid');
        }else{
          $('.divJabatan').addClass('has-error').removeClass('has-valid');
        }
        $('.pegawai').empty().attr('disabled', false);
        var divisi2 = divisi;
        var jabatan = $(this).val();
        var jenis3 = jenis;
        $(".pegawai").select2({
          placeholder: "Pilih Nama Pegawai...",
          ajax: {
            url: baseUrl + '/hrd/datalembur/lookup-data-pegawai',
            dataType: 'json',
            data: function (params) {
              return {
                  q: $.trim(params.term),
                  divisi : divisi2,
                  jabatan : jabatan,
                  jenis : jenis3,
              };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
          }, 
        });
      });

      $('.pegawai').change(function(event) {
        if($(this).val() != ""){
          $('.divPegawai').removeClass('has-error').addClass('has-valid');
          $('#namapeg').val($(this).text());
          $('#namapeg_edit').val($(this).text());
        }else{
          $('.divPegawai').addClass('has-error').removeClass('has-valid');
          $('#namapeg').val("");
          $('#namapeg_edit').val("");
        }
      });

      //validasi
      $("#form-lembur").validate({
        rules:{
          jenis_pegawai: "required",
          tglLembur: "required",
          jamAwal: "required",
          jamAkhir: "required",
          kodeDivisi: "required",
          kodeJabatan: "required",
          pegawai: "required",
          keperluan: "required",
        },
        errorPlacement: function() {
            return false;
        },
        submitHandler: function(form) {
          form.submit();
        }
      });

      $("#form-lembur-edit").validate({
        rules:{
          jenis_pegawai_edit: "required",
          tglLemburEdit: "required",
          jamAwalEdit: "required",
          jamAkhirEdit: "required",
          kodeDivisiEdit: "required",
          kodeJabatanEdit: "required",
          pegawai_edit: "required",
          keperluan_edit: "required",
        },
        errorPlacement: function() {
            return false;
        },
        submitHandler: function(form) {
          form.submit();
        }
      });

      //load fungsi
      lihatLemburByTanggal();

    });//end jquery

    function lihatLemburByTanggal()
    {
      var tgl1 = $('#tanggal1').val();
      var tgl2 = $('#tanggal2').val();
      $('#tbl-index').dataTable({
        "destroy": true,
        "processing" : true,
        "serverside" : true,
        "ajax" : {
          url: baseUrl + "/hrd/datalembur/get-lembur-by-tgl/"+tgl1+"/"+tgl2,
          type: 'GET'
        },
        "columns" : [
          {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
          {"data" : "tglBuat", "width" : "10%"},
          {"data" : "d_lembur_code", "width" : "10%"},
          {"data" : "jenis_peg", "width" : "10%"},
          {"data" : "d_lembur_nama", "width" : "20%"},
          {"data" : "d_lembur_keperluan", "width" : "20%"},
          {"data" : "action", orderable: false, searchable: false, "width" : "15%"}
        ],
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

    function detailLembur(id, $jenis) 
    {
      $.ajax({
        url : baseUrl + "/hrd/datalembur/get-detail/"+id+"/"+$jenis,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          var date = data.data[0].d_lembur_date;
          if(date != null) { var newDueDate = date.split("-").reverse().join("-"); }
          var jenpeg = data.data[0].d_lembur_jenispeg;
          if(jenpeg != "MAN") { var newJenPeg = "Manajemen"; } else{ var newJenPeg = "Produksi"; }
          
          //ambil data ke json->modal
          $('#jenis_peg_det').val(newJenPeg);
          $('#tgl_lembur_det').val(newDueDate);
          $('#jam_awal_det').val(data.data[0].d_lembur_stime);
          $('#jam_akhir_det').val(data.data[0].d_lembur_etime);
          $('#divisi_det').val(data.divisi);
          $('#jabatan_det').val(data.jabatan);
          $('#pegawai_det').val(data.pegawai);
          $('#keperluan_det').val(data.data[0].d_lembur_keperluan);
          $('#append-detail').html(
            '<a href="'+ baseUrl +'/hrd/datalembur/print/'+ id +'/'+ jenpeg +'" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i>&nbsp;Print</a>'
            +'<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>');
          $('#modal_detail_data').modal('show');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
      });
    }

    function editLembur(id, $jenis) 
    {
      $.ajax({
        url : baseUrl + "/hrd/datalembur/get-edit/"+id+"/"+$jenis,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          var date = data.data[0].d_lembur_date;
          if(date != null) { var newDueDate = date.split("-").reverse().join("-"); }

          var jenpeg = data.data[0].d_lembur_jenispeg;
          if(jenpeg != "MAN") { var newJenPeg = "pro"; } else{ var newJenPeg = "man"; }
          
          $('#tgl_lembur_edit').val(newDueDate);
          $('#jam_awal_edit').val(data.data[0].d_lembur_stime);
          $('#jam_akhir_edit').val(data.data[0].d_lembur_etime);
          
          $("#jenis_pegawai_edit").val(newJenPeg).trigger('change');
          var selectedDivisi = $("<option></option>").val(data.divisi).text(data.divisiTxt);
          $("#kode_divisi_edit").append(selectedDivisi);
          var selectedJabatan = $("<option></option>").val(data.jabatan).text(data.jabatanTxt);
          $('#kode_jabatan_edit').append(selectedJabatan);
          var selectedPegawai = $("<option></option>").val(data.data[0].d_lembur_pid).text(data.pegawai);
          $('#pegawai_edit').append(selectedPegawai);

          $('#keperluan_edit').val(data.data[0].d_lembur_keperluan);
          $('#namapeg_edit').val(data.pegawai);
          $('#lemburid_edit').val(data.data[0].d_lembur_id);
          $('#modal_edit_data').modal('show');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
      });
    }

    function submitLembur() {
      iziToast.question({
        close: false,
        overlay: true,
        displayMode: 'once',
        //zindex: 999,
        title: 'Simpan Data Lembur',
        message: 'Apakah anda yakin ?',
        position: 'center',
        buttons: [
          ['<button><b>Ya</b></button>', function (instance, toast) {
            var IsValid = $("form[name='formLembur']").valid();
            if(IsValid)
            {
              $('.divjenis').removeClass('has-error');
              $('.divDivisi').removeClass('has-error');
              $('.divJabatan').removeClass('has-error');
              $('.divPegawai').removeClass('has-error');
              $('#btn_simpan').text('Saving...');
              $('#btn_simpan').attr('disabled',true);
              $.ajax({
                url : baseUrl + "/hrd/datalembur/simpan-lembur",
                type: "POST",
                dataType: "JSON",
                data: $('#form-lembur').serialize(),
                success: function(response)
                {
                  if(response.status == "sukses")
                  {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    iziToast.success({
                      position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                      title: 'Pemberitahuan',
                      message: response.pesan,
                      onClosing: function(instance, toast, closedBy){
                        $('#btn_simpan').text('Submit'); //change button text
                        $('#btn_simpan').attr('disabled',false); //set button enable
                        $('#modal_tambah_data').modal('hide');
                        $('#tbl-index').DataTable().ajax.reload();
                      }
                    });
                  }
                  else
                  {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    iziToast.error({
                      position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                      title: 'Pemberitahuan',
                      message: response.pesan,
                      onClosing: function(instance, toast, closedBy){
                        $('#btn_simpan').text('Submit'); //change button text
                        $('#btn_simpan').attr('disabled',false); //set button enable
                        $('#modal_tambah_data').modal('hide');
                        $('#tbl-index').DataTable().ajax.reload();
                      }
                    }); 
                  }
                },
                error: function(){
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.warning({
                    icon: 'fa fa-times',
                    message: 'Terjadi Kesalahan!'
                  });
                },
                async: false
              }); 
            }
            else
            {
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
              iziToast.warning({
                position: 'center',
                message: "Mohon Lengkapi data form !",
                onClosing: function(instance, toast, closedBy){
                  $('.divjenis').addClass('has-error');
                  $('.divDivisi').addClass('has-error');
                  $('.divJabatan').addClass('has-error');
                  $('.divPegawai').addClass('has-error');
                }
              });
            } //end check valid
          }, true],
          ['<button>Tidak</button>', function (instance, toast) {
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
          }],
        ]
      });
    }

    function updateLembur() {
      iziToast.question({
        close: false,
        overlay: true,
        displayMode: 'once',
        //zindex: 999,
        title: 'Update Data Lembur',
        message: 'Apakah anda yakin ?',
        position: 'center',
        buttons: [
          ['<button><b>Ya</b></button>', function (instance, toast) {
            var IsValid2 = $("form[name='formLemburEdit']").valid();
            if(IsValid2)
            {
              $('.divjenis').removeClass('has-error');
              $('.divDivisi').removeClass('has-error');
              $('.divJabatan').removeClass('has-error');
              $('.divPegawai').removeClass('has-error');
              $('#btn_update').text('Saving...');
              $('#btn_update').attr('disabled',true);
              $.ajax({
                url : baseUrl + "/hrd/datalembur/update-lembur",
                type: "POST",
                dataType: "JSON",
                data: $('#form-lembur-edit').serialize(),
                success: function(response)
                {
                  if(response.status == "sukses")
                  {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    iziToast.success({
                      position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                      title: 'Pemberitahuan',
                      message: response.pesan,
                      onClosing: function(instance, toast, closedBy){
                        $('#btn_update').text('Submit'); //change button text
                        $('#btn_update').attr('disabled',false); //set button enable
                        $('#modal_edit_data').modal('hide');
                        $('#tbl-index').DataTable().ajax.reload();
                      }
                    });
                  }
                  else
                  {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    iziToast.error({
                      position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                      title: 'Pemberitahuan',
                      message: response.pesan,
                      onClosing: function(instance, toast, closedBy){
                        $('#btn_update').text('Submit'); //change button text
                        $('#btn_update').attr('disabled',false); //set button enable
                        $('#modal_edit_data').modal('hide');
                        $('#tbl-index').DataTable().ajax.reload();
                      }
                    }); 
                  }
                },
                error: function(){
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.warning({
                    icon: 'fa fa-times',
                    message: 'Terjadi Kesalahan!'
                  });
                },
                async: false
              }); 
            }
            else
            {
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
              iziToast.warning({
                position: 'center',
                message: "Mohon Lengkapi data form !",
                onClosing: function(instance, toast, closedBy){
                  $('.divjenis').addClass('has-error');
                  $('.divDivisi').addClass('has-error');
                  $('.divJabatan').addClass('has-error');
                  $('.divPegawai').addClass('has-error');
                }
              });
            } //end check valid
          }, true],
          ['<button>Tidak</button>', function (instance, toast) {
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
          }],
        ]
      });
    }

    function hapuslLembur(id) 
    {
      iziToast.question({
        timeout: 20000,
        close: false,
        overlay: true,
        displayMode: 'once',
        title: 'Hapus data',
        message: 'Apakah anda yakin ?',
        position: 'center',
        buttons: [
          ['<button><b>Ya</b></button>', function (instance, toast) {
            $.ajax({
              url : baseUrl + "/hrd/datalembur/delete-lembur",
              type: "POST",
              dataType: "JSON",
              data: {id:id, "_token": "{{ csrf_token() }}"},
              success: function(response)
              {
                if(response.status == "sukses")
                {
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.success({
                    position: 'topRight',
                    title: 'Pemberitahuan',
                    message: response.pesan,
                    onClosing: function(instance, toast, closedBy){
                      $('#tbl-index').DataTable().ajax.reload();
                    }
                  });
                }
                else
                {
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.error({
                    position: 'topRight',
                    title: 'Pemberitahuan',
                    message: response.pesan,
                    onClosing: function(instance, toast, closedBy){
                      $('#tbl-index').DataTable().ajax.reload();
                    }
                  });
                }
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                iziToast.error({
                  icon: 'fa fa-times',
                  message: 'Terjadi Kesalahan!'
                });
              }
            });
          }, true],
          ['<button>Tidak</button>', function (instance, toast) {
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
          }],
        ]
      });
    }
    
  </script> 
@endsection()