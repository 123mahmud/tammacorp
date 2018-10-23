@extends('main')
@section('content')
<style>
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
      <div class="page-title">Form Edit Master KPI</div>
    </div>
    
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Master Master KPI</li><li><i class="fa fa-angle-right"></i>&nbsp;Form Edit Master KPI&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
    </ol>
    
    <div class="clearfix"></div>
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
            <li class="active"><a href="#alert-tab" data-toggle="tab">Form Edit Master KPI</a></li>
          </ul>
          
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:-10px;margin-bottom: 15px;">
                  <div class="col-md-5 col-sm-6 col-xs-8">
                    <h4>Form Edit Master KPI</h4>
                  </div>
                  
                  <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                    <a href="{{ url('master/datakpi/index') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                  </div>
                </div>
                
                <div class="col-md-12 col-sm-12 col-xs-12 " style="margin-top:15px;">
                  <form method="POST" id="form-save" name="formSave">  
                    {{ csrf_field() }}
                    <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg div-form-area" style="margin-bottom: 20px; padding-bottom:5px;padding-top:15px;padding-left:-10px;padding-right: -10px; ">
                      <input type="hidden" name="kode_old" value="{{ $data->kpix_id }}">

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Divisi<span style="color: red">*</span></label>
                      </div>

                      <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="form-group" id="divSelectDivisiEdit">
                          <input type="hidden" id="h_divisi" name="h_divisi" value="{{ $data->c_divisi }}" class="form-control input-sm" readonly> 
                          <input type="hidden" id="h_divisiid" name="h_divisiid" value="{{ $data->kpix_div_id }}" class="form-control input-sm" readonly> 
                          <select class="form-control input-sm select2" id="e_divisi" name="e_divisi" style="width: 100% !important;">
                          </select>
                        </div> 
                      </div>

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Jabatan<span style="color: red">*</span></label>
                      </div>

                      <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="form-group" id="divSelectJabatanEdit">
                          <input type="hidden" id="h_jabatan" name="h_jabatan" value="{{ $data->c_posisi }}" class="form-control input-sm" readonly> 
                          <input type="hidden" id="h_jabatanid" name="h_jabatanid" value="{{ $data->kpix_jabatan_id }}" class="form-control input-sm" readonly> 
                          <select class="form-control input-sm select2" id="e_jabatan" name="e_jabatan" style="width: 100% !important;">
                          </select>
                        </div> 
                      </div>

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Nama Pegawai<span style="color: red">*</span></label>
                      </div>

                      <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="form-group" id="divSelectPegawaiEdit">
                          <input type="hidden" id="h_pegawai" name="h_pegawai" value="{{ $data->c_nama }}" class="form-control input-sm" readonly> 
                          <input type="hidden" id="h_pegawaiid" name="h_pegawaiid" value="{{ $data->kpix_p_id }}" class="form-control input-sm" readonly> 
                          <select class="form-control input-sm select2" id="e_pegawai" name="e_pegawai" style="width: 100% !important;">
                          </select>
                        </div> 
                      </div>

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Nama Indikator<span style="color: red">*</span></label>
                      </div>

                      <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="e_nama" name="e_nama" class="form-control input-sm" value="{{ $data->kpix_name }}">
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Deadline KPI</label>
                      </div>

                      <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="form-group">
                          @if ($data->kpix_deadline != null)
                            <input type="text" id="e_deadline" name="e_deadline" class="form-control input-sm datepicker2" value="{{ date('d-m-Y',strtotime($data->kpix_deadline)) }}">
                          @else
                            <input type="text" id="e_deadline" name="e_deadline" class="form-control input-sm datepicker2">
                          @endif
                          
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Bobot KPI<span style="color: red">*</span></label>
                      </div>

                      <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="e_bobot" name="e_bobot" class="form-control input-sm" value="{{ $data->kpix_bobot }}">
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">target KPI<span style="color: red">*</span></label>
                      </div>

                      <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="e_target" name="e_target" class="form-control input-sm" value="{{ $data->kpix_target }}">
                        </div>
                      </div>

                      <div class="col-md-12 col-sm-12 col-xs-12" align="right" id="change_function">
                        <button type="button" id="btn_simpan" class="btn btn-primary" onclick="updateData()">Update Data</button>
                      </div>
                    </div>

                    <div class="col-md-12 col-sm-4 col-xs-12">
                      <label class="tebal" style="color: red">Keterangan : * Wajib diisi.</label>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

</div>                     
@endsection
@section("extra_scripts")
<script src="{{ asset("js/inputmask/inputmask.jquery.js") }}"></script>
<script type="text/javascript">
  $( document ).ready(function() {
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

    $('.datepicker2').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy"
    });
    
    $('.select2').select2({
    });

    //select2 option selected
    $selectedDivisi = $("<option></option>").val($('#h_divisiid').val()).text($('#h_divisi').val());
    $("#e_divisi").append($selectedDivisi);

    $selectedJabatan = $("<option></option>").val($('#h_jabatanid').val()).text($('#h_jabatan').val());
    $("#e_jabatan").append($selectedJabatan);

    $selectedPegawai = $("<option></option>").val($('#h_pegawaiid').val()).text($('#h_pegawai').val());
    $("#e_pegawai").append($selectedPegawai);

    $( "#e_divisi" ).select2({
      placeholder: "Pilih Divisi...",
      ajax: {
        url: baseUrl + '/master/datalowongan/lookup-data-divisi',
        dataType: 'json',
        data: function (params) {
          return {
              q: $.trim(params.term)
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

    $('#e_divisi').change(function() 
    {
      if($(this).val() != ""){
        $('#divSelectDivisiEdit').removeClass('has-error').addClass('has-valid');
        $('#e_jabatan').empty().attr('disabled', false);
        $('#e_pegawai').empty().attr('disabled', false);
      }else{
        $('#divSelectDivisiEdit').addClass('has-error').removeClass('has-valid');
        $('#e_jabatan').empty().attr('disabled', true);
        $('#e_pegawai').empty().attr('disabled', true);
      }

      var divisi = $('#e_divisi').val();
      $("#e_jabatan").select2({
        placeholder: "Pilih Jabatan...",
        ajax: {
          url: baseUrl + '/master/datascore/lookup-data-jabatan',
          dataType: 'json',
          data: function (params) {
            return {
                q : $.trim(params.term),
                divisi : divisi
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

    $('#e_jabatan').change(function() 
    {
      if($(this).val() != ""){
        $('#divSelectJabatanEdit').removeClass('has-error').addClass('has-valid');
        $('#e_pegawai').empty().attr('disabled', false);
      }else{
        $('#divSelectDivisiEdit').addClass('has-error').removeClass('has-valid');
        $('#e_pegawai').empty().attr('disabled', true);
      }

      var divisi = $('#e_divisi').val();
      var jabatan = $('#e_jabatan').val();
      $("#e_pegawai").select2({
        placeholder: "Pilih Pegawai...",
        ajax: {
          url: baseUrl + '/master/datascore/lookup-data-pegawai',
          dataType: 'json',
          data: function (params) {
            return {
                q : $.trim(params.term),
                divisi : divisi,
                jabatan : jabatan
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
    $("#form-save").validate({
      // Specify validation rules
      rules:{
          e_divisi : "required",
          e_jabatan : "required",
          e_pegawai : "required",
          e_nama : "required",
          e_bobot : "required",
          e_target : "required", 
      },
      errorPlacement: function() {
          return false;
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

    $(document).on('click', '.btn_remove', function(){
      var button_id = $(this).attr('id');
      $('#row'+button_id+'').remove();
    });
  }); //end jquery

  function updateData() {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Update Data Master KPI',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          var IsValid = $("form[name='formSave']").valid();
          if(IsValid)
          {
            $('.div-form-area input, .div-form-area select').each(
              function(index){  
                var input = $(this);
                $('#'+input.attr('id')).removeClass('has-error').addClass('has-valid');
                $('#divSelectDivisiEdit').removeClass('has-error').addClass('has-valid');
                $('#divSelectJabatanEdit').removeClass('has-error').addClass('has-valid');
                $('#divSelectPegawaiEdit').removeClass('has-error').addClass('has-valid');
              }
            );
            $('#btn_simpan').text('Saving...');
            $('#btn_simpan').attr('disabled',true);
            $.ajax({
              url : baseUrl + "/master/datakpi/update-kpi",
              type: "POST",
              dataType: "JSON",
              data: $('#form-save').serialize(),
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
                      window.location.href = baseUrl+"/master/datakpi/index";
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
                      window.location.href = baseUrl+"/master/datakpi/index";
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
                $('.div-form-area input, .div-form-area select').each(
                  function(index){  
                    var input = $(this);
                    $('#'+input.attr('id')).addClass('has-error').removeClass('has-valid');
                    $('#divSelectDivisiEdit').addClass('has-error').removeClass('has-valid');
                    $('#divSelectJabatanEdit').addClass('has-error').removeClass('has-valid');
                    $('#divSelectPegawaiEdit').addClass('has-error').removeClass('has-valid');
                  }
                );
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

  function randString(angka) 
  {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < angka; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  }
</script>
@endsection                            
