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
      <div class="page-title">Manajemen Scoreboard & KPI</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Manajemen Scoreboard & KPI</li>
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
              <a href="#index-tab" data-toggle="tab">Konfirmasi KPI</a>
            </li>
            <li><a href="#score-tab" data-toggle="tab" onclick="lihatScoreByTgl()">Data Scoreboard</a></li>
          </ul>

          <div id="generalTabContent" class="tab-content responsive">
            <!-- /div alert-tab -->
            @include('hrd.manajemenkpix.tab-index')
            @include('hrd.manajemenkpix.tab-score')
          </div>

        </div>
      </div>
    </div>
  </div> 
  @include('hrd.manajemenkpix.modal')
  @include('hrd.manajemenkpix.modal-detail')
  @include('hrd.manajemenkpix.modal-detail-score')
  @include('hrd.manajemenkpix.modal-edit')
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
      newdate.setDate(newdate.getDate()-3);
      var nd = new Date(newdate);
      
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
        //$('tr').remove('.tbl_modal_detail_row');
        $('#appending div').remove();
        $('#e_appending div').remove();
        $('#d_appending div').remove();
        $('#ds_appending div').remove();
        $('tr').remove('.tbl_modal_detail_row');
        //remove class all jquery validation error
        $('.form-group').find('.error').removeClass('error');
        $('.form-group').removeClass('has-valid has-error');
        //reset all input txt field
        $('#form-input-kpi')[0].reset();
        $('#form-edit-kpi')[0].reset();
        $('#form-detail-kpi')[0].reset();
        $('#form-detail-score')[0].reset();
      });

      //select2
      $('.select2').select2({
      });

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
        var jenis = $(this).val();

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

      //validasi
      $("#form-input-kpi").validate({
        rules:{
          tglKpi : "required"
        },
        errorPlacement: function() {
            return false;
        },
        submitHandler: function(form) {
          form.submit();
        }
      });

      $("#form-edit-kpi").validate({
        rules:{
          eTglKpi : "required"
        },
        errorPlacement: function() {
            return false;
        },
        submitHandler: function(form) {
          form.submit();
        }
      });

      //load fungsi
      lihatKpiByTgl();
    });//end jquery

    function lihatKpiByTgl()
    {
      var tgl1 = $('#tanggal1').val();
      var tgl2 = $('#tanggal2').val();
      var tampil = $('#k_confirm').val();
      $('#tbl-index').dataTable({
        "destroy": true,
        "processing" : true,
        "serverside" : true,
        "ajax" : {
          url: baseUrl + "/hrd/manscorekpi/get-kpi-by-tgl/"+tgl1+"/"+tgl2+"/"+tampil,
          type: 'GET'
        },
        "columns" : [
          {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
          {"data" : "tglBuat", "width" : "10%"},
          {"data" : "d_kpix_code", "width" : "10%"},
          {"data" : "c_nama", "width" : "19%"},
          {"data" : "status", "width" : "15%"},
          {"data" : "tglConfirm", "width" : "15%"},
          {"data" : "d_kpix_scoretotal", "width" : "10%"},
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

    function lihatScoreByTgl()
    {
      var tgl1 = $('#tanggal3').val();
      var tgl2 = $('#tanggal4').val();
      var tampil = $('#s_confirm').val();
      $('#tbl-score').dataTable({
        "destroy": true,
        "processing" : true,
        "serverside" : true,
        "ajax" : {
          url: baseUrl + "/hrd/manscorekpi/get-score-by-tgl/"+tgl1+"/"+tgl2+"/"+tampil,
          type: 'GET'
        },
        "columns" : [
          {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
          {"data" : "tglBuat", "width" : "10%"},
          {"data" : "d_kpi_code", "width" : "10%"},
          {"data" : "c_nama", "width" : "30%"},
          {"data" : "status", "width" : "15%"},
          {"data" : "tglConfirm", "width" : "15%"},
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

    function confirmKpi(id) 
    {
      $.ajax({
        url : baseUrl + "/hrd/manscorekpi/get-edit/"+id,
        type: "GET",
        dataType: "JSON",
        success: function(response)
        {
          var date = response.data[0].d_kpix_date;
          if(date != null) { var newTglKpix = date.split("-").reverse().join("-"); }

          $('#e_old').val(response.data[0].d_kpix_id);
          $('#e_tgl_kpix').val(newTglKpix);
          $('#e_divisi').val(response.pegawai.c_divisi);
          $('#e_iddivisi').val(response.data[0].kpix_div_id);
          $('#e_jabatan').val(response.pegawai.c_posisi);
          $('#e_idjabatan').val(response.data[0].kpix_div_id);
          $('#e_pegawai').val(response.pegawai.c_nama);
          $('#e_idpegawai').val(response.data[0].d_kpix_pid);
          
          var i = randString(5);
          var key = 1;
          var tgl = "";
          //loop data
          Object.keys(response.data).forEach(function()
          {
            tgl = response.data[key-1].kpix_deadline;
            if(tgl != null) { var newTgl = tgl.split("-").reverse().join("-"); }
            $('#e_appending').append(
                '<div class="col-md-9 col-sm-9 col-xs-9">'
                  +'<label class="tebal">'+response.data[key-1].kpix_name+' | Bobot : <span style="color:#8080ff;">'+response.data[key-1].kpix_bobot+'</span> | Target : <span style="color:#8080ff;">'+response.data[key-1].kpix_target+'</span> | Deadline : <span style="color:#8080ff;">'+newTgl+'</span></label>'
                +'</div>'
                +'<div class="col-md-3 col-sm-3 col-xs-3">'
                  +'<label class="tebal">Score</span></label>'
                +'</div>'
                +'<div class="col-md-9 col-sm-9 col-xs-9">'
                  +'<div class="form-group">'
                    +'<input type="text" id="e_value_kpi" name="e_value_kpix[]" class="form-control input-sm" value="'+response.data[key-1].d_kpixdt_value+'">'
                    +'<input type="hidden" id="e_index_kpi" name="e_index_kpix[]" class="form-control input-sm" value="'+response.data[key-1].kpix_id+'">'
                    +'<input type="hidden" id="e_dt" name="e_index_dt[]" class="form-control input-sm" value="'+response.data[key-1].d_kpixdt_id+'">'
                  +'</div>'
                +'</div>'
                +'<div class="col-md-3 col-sm-3 col-xs-3">'
                  +'<div class="form-group">'
                    +'<input type="text" id="e_score_kpi" name="e_score_kpix[]" class="form-control input-sm" value="'+response.scoreKpi[key-1]+'">'
                     +'<input type="hidden" id="e_bobot_kpi" name="e_bobot_kpix[]" class="form-control input-sm" value="'+response.data[key-1].kpix_bobot+'">'
                  +'</div>'
                +'</div>');
            i = randString(5);
            key++;
          });
          $('#modal_edit_data').modal('show');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
      });
    }

    function detailKpi(id) 
    {
      $.ajax({
        url : baseUrl + "/hrd/manscorekpi/get-edit/"+id,
        type: "GET",
        dataType: "JSON",
        success: function(response)
        {
          var date = response.data[0].d_kpix_date;
          if(date != null) { var newKpixDate = date.split("-").reverse().join("-"); }

          $('#d_tanggal').text(newKpixDate);
          $('#d_divisi').text(response.pegawai.c_divisi);
          $('#d_jabatan').text(response.pegawai.c_posisi);
          $('#d_pegawai').text(response.pegawai.c_nama);
          
          var i = randString(5);
          var key = 1;
          var totBobot = 0;
          var totScore = 0;
          //loop data
          Object.keys(response.data).forEach(function()
          {
            $('#d_appending').append(
                '<tr class="tbl_modal_detail_row">'
                  +'<td>'+key+'</td>'
                  +'<td>'+response.data[key-1].kpix_bobot+'</td>'
                  +'<td>'+response.data[key-1].kpix_name+'</td>'
                  +'<td>'+response.data[key-1].kpix_target+'</td>'
                  +'<td>'+response.data[key-1].d_kpixdt_value+'</td>'
                  +'<td>'+response.data[key-1].d_kpixdt_score+'</td>'
                  +'<td>'+response.data[key-1].d_kpixdt_scoreakhir+'</td>'
                +'</tr>');
            totBobot += parseInt(response.data[key-1].kpix_bobot);
            totScore += parseFloat(response.data[key-1].d_kpixdt_scoreakhir);
            i = randString(5);
            key++;
          });
          $('#d_appending').append(
                '<tr class="tbl_modal_detail_row">'
                  +'<td colspan = "2" align="center"><strong>Total Bobot : '+totBobot+'</strong></td>'
                  +'<td colspan = "5" align="center"><strong>Total Skor Akhir : '+totScore+'</strong></td>'
                +'</tr>');
          $('#modal_detail_data').modal('show');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
      });
    }

    function detailScore(id) {
      $.ajax({
        url : baseUrl + "/hrd/manajemenkpipegawai/get-edit/"+id,
        type: "GET",
        dataType: "JSON",
        success: function(response)
        {
          var date = response.data[0].d_kpi_date;
          if(date != null) { var newDueDate = date.split("-").reverse().join("-"); }

          $('#ds_old').val(response.data[0].d_kpi_id);
          $('#ds_idpegawai').val(response.data[0].d_kpi_pid);
          $('#ds_pegawai').val(response.pegawai.c_nama);
          $('#ds_tgl_kpi').val(newDueDate);
          $('#ds_divisi').val(response.pegawai.c_divisi);
          $('#ds_iddivisi').val(response.data[0].kpi_div_id);
          $('#ds_jabatan').val(response.pegawai.c_posisi);
          $('#ds_idjabatan').val(response.data[0].kpi_jabatan_id);
          
          var i = randString(5);
          var key = 1;
          //loop data
          Object.keys(response.data).forEach(function()
          {
            $('#ds_appending').append(
                '<div class="col-md-12 col-sm-12 col-xs-12">'
                  +'<label class="tebal">'+response.data[key-1].kpi_name+'</label>'
                +'</div>'
                +'<div class="col-md-12 col-sm-12 col-xs-12" id="row'+i+'">'
                  +'<div class="form-group">'
                    +'<textarea class="form-control input-sm" id="ds_value_kpi" name="ds_value_kpi[]" rows="3" readonly>'+response.data[key-1].d_kpidt_value+'</textarea>'
                    +'<input type="hidden" id="ds_index_kpi" name="ds_index_kpi[]" class="form-control input-sm" value="'+response.data[key-1].kpi_id+'" readonly>'
                  +'</div>'
                +'</div>');
            i = randString(5);
            key++;
          });
          $('#modal_detail_datascore').modal('show');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
      });
    }

    function updateKpix() 
    {
      iziToast.question({
        close: false,
        overlay: true,
        displayMode: 'once',
        //zindex: 999,
        title: 'Konfirmasi Data KPI',
        message: 'Apakah anda yakin ?',
        position: 'center',
        buttons: [
          ['<button><b>Ya</b></button>', function (instance, toast) {
            var IsValid = $("form[name='formEditKpi']").valid();
            if(IsValid)
            {
              $('#btn_update').text('Confirm...');
              $('#btn_update').attr('disabled',true);
              $.ajax({
                url : baseUrl + "/hrd/manscorekpi/update-data",
                type: "POST",
                dataType: "JSON",
                data: $('#form-edit-kpi').serialize(),
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
                        $('#btn_update').text('Confirm'); //change button text
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
                        $('#btn_update').text('Update'); //change button text
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

    function ubahStatus(id, status) 
    {
      iziToast.question({
        timeout: 20000,
        close: false,
        overlay: true,
        displayMode: 'once',
        title: 'Ubah Status Data',
        message: 'Apakah anda yakin ?',
        position: 'center',
        buttons: [
          ['<button><b>Ya</b></button>', function (instance, toast) {
            $.ajax({
              url : baseUrl + "/hrd/manscorekpi/ubah-status",
              type: "POST",
              dataType: "JSON",
              data: {id:id, status:status, "_token": "{{ csrf_token() }}"},
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

    function randString(angka) 
    {
      var text = "";
      var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

      for (var i = 0; i < angka; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

      return text;
    }

    function refreshTabelIndex() 
    {
      $('#tbl-index').DataTable().ajax.reload();
    }

    function refreshTabelScore() 
    {
      $('#tbl-score').DataTable().ajax.reload();
    }
    
  </script> 
@endsection()