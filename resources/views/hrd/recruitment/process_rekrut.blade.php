@extends('main')
@section('extra_styles')
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
  .bold{
    font-weight: bold;
  }
  .underline{
    text-decoration: underline;
  }
  .italic{
    font-style: italic;
  }
  .s16{
    font-size: 16px;
  }

  fieldset{
    border: 1px solid black;
  }

  .abu-abu {
        background-color: #d7dae0;
      }
</style>
@endsection
@section('content')
  <!--BEGIN PAGE WRAPPER-->
  <div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
      <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
          <div class="page-title">Recruitment</div>
      </div>
      <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
          <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
          <li><i></i>&nbsp;HRD&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
          <li class="active">Recruitment</li>
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
              <li class="active"><a href="#alert-tab" data-toggle="tab">Recruitment</a></li>
              <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
              <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
            </ul>

            <div id="generalTabContent" class="tab-content responsive">
              @include('hrd.recruitment.test_interview')
              @include('hrd.recruitment.lolos_interview')

              <div id="alert-tab" class="tab-pane fade in active">
                <form method="POST" id="form-app" name="formApp">
                  {{ csrf_field() }}
                  <div class="row tamma-bg" style="margin-top: -23px;padding-top: 23px;padding-bottom: 10px;border-radius: unset;margin-bottom: 15px;">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label class="bold s16">Data Pelamar</label>
                        </div>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <label>Nama Pelamar</label>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <input type="text" class="form-control input-sm" readonly id="ip_nama" name="nama" value="{{$data->p_name}}">
                          <input type="hidden" class="form-control input-sm" readonly id="ip_id" name="id" value="{{$data->p_id}}">
                          <input type="hidden" class="form-control input-sm" readonly id="ip_status" name="status" value="{{$data->p_apply_status}}">
                          <input type="hidden" class="form-control input-sm" readonly id="ip_statusdt" name="statusdt" value="{{$data->p_apply_statusdt}}">
                          <input type="hidden" class="form-control input-sm" name="h_divisi" id="h_divisi" value="{{$vacancy->l_divisi}}">
                          <input type="hidden" class="form-control input-sm" name="h_level" id="h_level" value="{{$vacancy->l_subdivisi}}">
                          <input type="hidden" class="form-control input-sm" name="h_posisi" id="h_posisi" value="{{$vacancy->l_jabatan}}">
                        </div>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <label>No. HP</label>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <input type="text" class="form-control input-sm" readonly="" id="ip_tlp" name="tlp" value="{{$data->p_tlp}}">
                        </div>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <label>Jabatan yang dilamar</label>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <input type="text" class="form-control input-sm" name="jabatan" id="ip_jabatan" value="{{$vacancy->c_divisi}}" readonly>
                        </div>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <label>Posisi</label>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                          <input type="text" class="form-control input-sm" name="posisi" id="ip_posisi" value="{{$vacancy->c_posisi.' | '.$vacancy->c_subdivisi}}" readonly>
                        </div>
                      </div>

                    </div>

                    <div class="col-md-6 col-sm-12 col-xs-12">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label class="bold s16">Status Pelamar</label>
                        </div>
                      </div>

                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <label style="font-style: oblique; font-size: 16px; color: blue;">{{$data->p_st_name}}</label>
                        <label style="font-style: oblique; font-size: 16px;">( {{$data->p_stdt_name}} )</label>
                        <br>
                        @if ($data->p_apply_statusdt == 4)
                          @if (!empty($jadwal_i))
                            <label style="font-style: oblique; font-size: 16px; font-weight: bold;">Jadwal Interview</label>
                            <br>
                            <label style="font-style: oblique; font-size: 14px;">Tanggal : {{ date('d-m-Y', strtotime( $jadwal_i->pj_date)) }}</label>
                            <br>
                            <label style="font-style: oblique; font-size: 14px;">Jam : {{ $jadwal_i->pj_time }} WIB</label>
                            <br>
                            <label style="font-style: oblique; font-size: 14px;">Lokasi : {{ $jadwal_i->pj_lokasi }}</label>
                            <br>
                            <label style="font-style: oblique; font-size: 14px;">PIC : {{ $jadwal_i->c_nik }} - {{ $jadwal_i->c_nama }}</label>
                          @endif
                        @elseif ($data->p_apply_statusdt == 7)
                          @if (!empty($jadwal_p))
                            <label style="font-style: oblique; font-size: 16px; font-weight: bold;">Jadwal Presentasi</label>
                            <br>
                            <label style="font-style: oblique; font-size: 14px;">Tanggal : {{ date('d-m-Y', strtotime( $jadwal_p->pj_date)) }}</label>
                            <br>
                            <label style="font-style: oblique; font-size: 14px;">Jam : {{ $jadwal_p->pj_time }} WIB</label>
                            <br>
                            <label style="font-style: oblique; font-size: 14px;">Lokasi : {{ $jadwal_p->pj_lokasi }}</label>
                            <br>
                            <label style="font-style: oblique; font-size: 14px;">PIC : {{ $jadwal_p->c_nik }} - {{ $jadwal_p->c_nama }}</label>
                          @endif
                        @endif
                        
                        
                      </div>                    
                    </div>

                    @if ($data->p_apply_statusdt == 4 || $data->p_apply_statusdt == 10)
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <label class="bold s16">Review Interview Peserta</label>
                              @if (!empty($jadwal_i))
                                <p>{{ $jadwal_i->pj_review_i }}</p>
                              @endif
                          </div>
                        </div>
                      </div> 
                    @elseif ($data->p_apply_statusdt == 7)
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <label class="bold s16">Review Presentasi Peserta</label>
                            @if (!empty($jadwal_p))
                              <p>{{ $jadwal_p->pj_review_p }}</p>
                            @endif
                          </div>
                        </div>
                      </div>
                    @endif
                  </div>   

                  <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                      <fieldset style="padding-top: 15px;" id="fs_approve1">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <label class="s16 bold underline">Approval 1</label>
                          </div>
                        </div>
                        @foreach ($approve1 as $val)
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <label>
                                <input type="radio" name="approval_1" id="{{'app_'.$val->p_stdt_id}}" class="approval_1" value="{{$val->p_stdt_id}}" 
                                @if ($val->p_stdt_id == $cek_app1)
                                  checked
                                @endif> 
                                {{$val->p_stdt_name}}
                              </label>
                            </div>
                          </div>
                        @endforeach
                      </fieldset>                           
                    </div>

                    <div class="col-md-4 col-sm-12 col-xs-12">
                      <fieldset style="padding-top: 15px;" id="fs_approve2">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <label class="s16 bold underline">Approval 2</label>
                          </div>
                        </div>
                        
                        @foreach ($approve2 as $val)
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <label>
                              <input type="radio" name="approval_2" id="{{'app_'.$val->p_stdt_id}}" class="approval_2" value="{{$val->p_stdt_id}}"
                                @if ($val->p_stdt_id == $cek_app2)
                                  checked
                                @endif> 
                                {{$val->p_stdt_name}}
                            </label>
                          </div>
                        </div>
                        @endforeach
                      </fieldset>                           
                    </div>

                    <div class="col-md-4 col-sm-12 col-xs-12">
                      <fieldset style="padding-top: 15px;" id="fs_approve3">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <label class="s16 bold underline">Approval 3</label>
                          </div>
                        </div>

                        @foreach ($approve3 as $val)
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                              @if ($val->p_stdt_id == 10)
                                <label class="hidden">
                                  <input type="radio" name="approval_3" id="{{'app_'.$val->p_stdt_id}}" class="approval_3" value="{{$val->p_stdt_id}}"
                                  @if ($val->p_stdt_id == $cek_app3)
                                    checked
                                  @endif> 
                                  {{$val->p_stdt_name}}
                                </label>
                              @else
                                <label>
                                  <input type="radio" name="approval_3" id="{{'app_'.$val->p_stdt_id}}" class="approval_3" value="{{$val->p_stdt_id}}"
                                  @if ($val->p_stdt_id == $cek_app3)
                                    checked
                                  @endif> 
                                  {{$val->p_stdt_name}}
                                </label>
                              @endif
                            </div>
                          </div>
                        @endforeach
                      </fieldset>                         
                    </div>
                  </div>
                </form>
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top: 15px;" id="appending">
                  </div>
                </div>
              </div><!-- /div alert-tab -->

              <!-- div note-tab -->
              <div id="note-tab" class="tab-pane fade">
                <div class="row">
                  <div class="panel-body">
                    <!-- Isi Content -->we we we
                  </div>
                </div>
              </div>
              <!--/div note-tab -->

              <!-- div label-badge-tab -->
              <div id="label-badge-tab" class="tab-pane fade">
                <div class="row">
                  <div class="panel-body">
                    <!-- Isi content -->we
                  </div>
                </div>
              </div>
              <!-- /div label-badge-tab -->
            </div>
  
          </div>
        </div>

      </div>
    </div>

  </div>
  <!--END PAGE WRAPPER-->
@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      
      // $('.modal_checkbox').click(function(){

      //   $this = $(this);

      //   $attr =  $this.find('input').attr('id');

      //   $checked = $this.find('div').hasClass('checked');

      //   if ($checked === false) {
          
      //     $('#'+$attr).modal('show');
      //   }
      // });

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
      // newdate.setDate(newdate.getDate()-30);
      newdate.setDate(newdate.getDate()-30);
      var nd = new Date(newdate);

      $('.datepicker1').datepicker({
        autoclose: true,
        format:"dd-mm-yyyy",
        endDate: 'today'
      }).datepicker("setDate", nd);

      $('.datepicker2').datepicker({
        autoclose: true,
        format:"dd-mm-yyyy"
      }).datepicker("setDate", "0");

      if ($('#ip_status').val() == '1') 
      {
        $('.approval_1').attr('disabled', false);
        $('.approval_2').attr('disabled', true);
        $('.approval_3').attr('disabled', true);
        $('#fs_approve1').removeClass('abu-abu');
        $('#fs_approve2').addClass('abu-abu');
        $('#fs_approve3').addClass('abu-abu');
        $('#appending').append('<button class="btn btn-primary" id="btn_app"onclick="approval1()">Process</button>'
                                +'<a href="'+baseUrl+'/hrd/recruitment/rekrut" class="btn btn-default">Back</a>');
      }
      else if($('#ip_status').val() == '2')
      {
        if ($('#ip_statusdt').val() == '2') 
        {
          $('.approval_1').attr('disabled', true);
          $('.approval_2').attr('disabled', true);
          $('.approval_3').attr('disabled', true);
          $('#fs_approve1').addClass('abu-abu');
          $('#fs_approve2').addClass('abu-abu');
          $('#fs_approve3').addClass('abu-abu');
          $('#appending').append('<button class="btn btn-primary" id="btn_app" disabled>Process</button>'
                                +'<a href="'+baseUrl+'/hrd/recruitment/rekrut" class="btn btn-default">Back</a>');
        }
        else if($('#ip_statusdt').val() == '3')
        {
          $('.approval_1').attr('disabled', false);
          $('.approval_2').attr('disabled', true);
          $('.approval_3').attr('disabled', true);
          $('#fs_approve1').removeClass('abu-abu');
          $('#fs_approve2').addClass('abu-abu');
          $('#fs_approve3').addClass('abu-abu');
          $('#appending').append('<button class="btn btn-primary" id="btn_app" onclick="update_aproval1()">Process</button>'
                                +'<a href="'+baseUrl+'/hrd/recruitment/rekrut" class="btn btn-default">Back</a>');
        }
        else if($('#ip_statusdt').val() == '4')
        {
          $('.approval_1').attr('disabled', true);
          $('.approval_2').attr('disabled', false);
          $('.approval_3').attr('disabled', true);
          $('#fs_approve1').addClass('abu-abu');
          $('#fs_approve2').removeClass('abu-abu');
          $('#fs_approve3').addClass('abu-abu');
          $('#appending').append('<button class="btn btn-warning pull-left" onclick="skipApproval2({{$data->p_id}})">Skip Approval 2</button>'
                                +'<button class="btn btn-success pull-left" onclick="jadwalInterview()">Set Jadwal</button>'
                                +'<button class="btn btn-primary" id="btn_app" onclick="approval2()">Process</button>'
                                +'<a href="'+baseUrl+'/hrd/recruitment/rekrut" class="btn btn-danger">Back</a>');
        }
      }
      else if($('#ip_status').val() == '3')
      {
        if ($('#ip_statusdt').val() == '5') 
        {
          $('.approval_1').attr('disabled', true);
          $('.approval_2').attr('disabled', true);
          $('.approval_3').attr('disabled', true);
          $('#fs_approve1').addClass('abu-abu');
          $('#fs_approve2').addClass('abu-abu');
          $('#fs_approve3').addClass('abu-abu');
          $('#appending').append('<button class="btn btn-primary" id="btn_app" disabled>Process</button>'
                                +'<a href="'+baseUrl+'/hrd/recruitment/rekrut" class="btn btn-default">Back</a>');
        }
        else if($('#ip_statusdt').val() == '6')
        {
          $('.approval_1').attr('disabled', true);
          $('.approval_2').attr('disabled', false);
          $('.approval_3').attr('disabled', true);
          $('#fs_approve1').addClass('abu-abu');
          $('#fs_approve2').removeClass('abu-abu');
          $('#fs_approve3').addClass('abu-abu');
          $('#appending').append('<button class="btn btn-primary" id="btn_app" onclick="update_aproval2()">Process</button>'
                                +'<a href="'+baseUrl+'/hrd/recruitment/rekrut" class="btn btn-default">Back</a>');
        }
        else if($('#ip_statusdt').val() == '7')
        {
          $('.approval_1').attr('disabled', true);
          $('.approval_2').attr('disabled', true);
          $('.approval_3').attr('disabled', false);
          $('#fs_approve1').addClass('abu-abu');
          $('#fs_approve2').addClass('abu-abu');
          $('#fs_approve3').removeClass('abu-abu');
          $('#appending').append('<button class="btn btn-success pull-left" onclick="jadwalPresentasi()">Set Jadwal</button>'
                                 +'<button class="btn btn-primary" id="btn_app" onclick="approval3()">Process</button>'
                                 +'<a href="'+baseUrl+'/hrd/recruitment/rekrut" class="btn btn-default">Back</a>');
        }
      }
      else if($('#ip_status').val() == '4')
      {
        if ($('#ip_statusdt').val() == '8') 
        {
          $('.approval_1').attr('disabled', true);
          $('.approval_2').attr('disabled', true);
          $('.approval_3').attr('disabled', true);
          $('#fs_approve1').addClass('abu-abu');
          $('#fs_approve2').addClass('abu-abu');
          $('#fs_approve3').addClass('abu-abu');
          $('#appending').append('<button class="btn btn-primary" id="btn_app" disabled>Process</button>'
                                +'<a href="'+baseUrl+'/hrd/recruitment/rekrut" class="btn btn-default">Back</a>');
        }
        else if ($('#ip_statusdt').val() == '9') 
        {
          $('.approval_1').attr('disabled', true);
          $('.approval_2').attr('disabled', true);
          $('.approval_3').attr('disabled', true);
          $('#fs_approve1').addClass('abu-abu');
          $('#fs_approve2').addClass('abu-abu');
          $('#fs_approve3').addClass('abu-abu');
          /*$('#appending').append('<button class="btn btn-primary" id="btn_app" onclick="final_approval()">Process</button>'
                                +'<a href="'+baseUrl+'/hrd/recruitment/rekrut" class="btn btn-default">Back</a>');*/
          $('#appending').append('<button class="btn btn-primary" id="btn_app" disabled>Process</button>'
                                +'<a href="'+baseUrl+'/hrd/recruitment/rekrut" class="btn btn-default">Back</a>');
        }
        else if ($('#ip_statusdt').val() == '10') 
        {
          $('.approval_1').attr('disabled', true);
          $('.approval_2').attr('disabled', true);
          $('.approval_3').attr('disabled', false);
          $('#fs_approve1').addClass('abu-abu');
          $('#fs_approve2').addClass('abu-abu');
          $('#fs_approve3').removeClass('abu-abu');
          /*$('#appending').append('<button class="btn btn-primary" id="btn_app" onclick="final_approval()">Process</button>'
                                +'<a href="'+baseUrl+'/hrd/recruitment/rekrut" class="btn btn-default">Back</a>');*/
          $('#appending').append('<button class="btn btn-primary" id="btn_app" onclick="approval3_skip()">Process</button>'
                                +'<a href="'+baseUrl+'/hrd/recruitment/rekrut" class="btn btn-default">Back</a>');
        } 
      }

      //validasi
      $("#form-app").validate({
        rules:{
            approval_1: "required"
        },
        errorPlacement: function() {
            return false;
        },
        submitHandler: function(form) {
          form.submit();
        }
      });

      $("#form-interview").validate({
        rules:{
            i_tgl: "required",
            i_jam: "required",
            i_lokasi: "required",
            i_pic: "required"
        },
        errorPlacement: function() {
            return false;
        },
        submitHandler: function(form) {
          form.submit();
        }
      });

      $("#form-presentasi").validate({
        rules:{
            p_tgl: "required",
            p_jam: "required",
            p_lokasi: "required",
            p_pic: "required"
        },
        errorPlacement: function() {
            return false;
        },
        submitHandler: function(form) {
          form.submit();
        }
      });

      //autocomplete w/parameters
      $( "#i_pic" ).focus(function() {
        var key = 1;
        $("#i_pic").autocomplete({
          source: function(request, response) {
            $.ajax({
              url: baseUrl + "/hrd/recruitment/autocomplete-pic",
              dataType: "JSON",
              data: {
                term : request.term
              },
              success: function(data) {
                response(data);
              }
            });
          },
          select: function(event, ui) {
            $('#i_pic_id').val(ui.item.id);
            $('#i_pic').val(ui.item.label);
          },
          minLength: 1,
          delay: 300
        });
        $('#i_pic').val('');
        $('#i_pic_id').val('');
      });

      $( "#p_pic" ).focus(function() {
        var key = 1;
        $("#p_pic").autocomplete({
          source: function(request, response) {
            $.ajax({
              url: baseUrl + "/hrd/recruitment/autocomplete-pic",
              dataType: "JSON",
              data: {
                term : request.term
              },
              success: function(data) {
                response(data);
              }
            });
          },
          select: function(event, ui) {
            $('#p_pic_id').val(ui.item.id);
            $('#p_pic').val(ui.item.label);
          },
          minLength: 1,
          delay: 300
        });
        $('#p_pic').val('');
        $('#p_pic_id').val('');
      });

      // var timepicker = new TimePicker('i_jam', {
      //     lang: 'en',
      //     theme: 'dark'
      // });
      // timepicker.on('change', function (evt) {

      //   var value = (evt.hour || '00') + ':' + (evt.minute || '00');
      //   evt.element.value = value;
      // });

      var timepicker = new TimePicker(['i_jam', 'p_jam'], {
        theme: 'dark', // 'blue-grey'
        lang: 'en'
      });

      timepicker.on('change', function(evt) {
        var value = (evt.hour || '00') + ':' + (evt.minute || '00');

        if (evt.element.id == 'i_jam') {
          evt.element.value = value;
        } else {
          evt.element.value = value;
        }
      });

    });//end jquery

    function approval1() 
    {
      var IsValid = $("form[name='formApp']").valid();
      if(IsValid){
        $.ajax({
          type: "POST",
          url : baseUrl + "/hrd/recruitment/approval_1",
          data: $('#form-app').serialize(),
          success: function(response)
          {
            if(response.status == "sukses")
            {
              iziToast.success({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: response.pesan,
                onClosing: function(instance, toast, closedBy){
                   window.location.href = baseUrl+"/hrd/recruitment/rekrut";
                }
              });
            }
            else
            {
              iziToast.error({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: "Data Gagal disimpan !",
                onClosing: function(instance, toast, closedBy){
                   window.location.href = baseUrl+"/hrd/recruitment/rekrut";
                }
              });
            }              
          },
          error: function()
          {
            iziToast.error({
              position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
              title: 'Pemberitahuan',
              message: "Data gagal disimpan !"
            });
          },
          async: false
        });
      }
      else //else validation
      {
        iziToast.warning({
          //icon: 'fa fa-microphone',
          position: 'center',
          message: "Mohon Lengkapi data form !"
        });
      }
    }

    function update_aproval1() 
    {
      var IsValid = $("form[name='formApp']").valid();
      if(IsValid){
        $.ajax({
          type: "POST",
          url : baseUrl + "/hrd/recruitment/update_approval_1",
          data: $('#form-app').serialize(),
          success: function(response)
          {
            if(response.status == "sukses")
            {
              iziToast.success({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: response.pesan,
                onClosing: function(instance, toast, closedBy){
                   window.location.href = baseUrl+"/hrd/recruitment/rekrut";
                }
              });
            }
            else
            {
              iziToast.error({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: "Data Gagal disimpan !",
                onClosing: function(instance, toast, closedBy){
                   window.location.href = baseUrl+"/hrd/recruitment/rekrut";
                }
              });
            }              
          },
          error: function()
          {
            iziToast.error({
              position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
              title: 'Pemberitahuan',
              message: "Data gagal disimpan !"
            });
          },
          async: false
        });
      }
      else //else validation
      {
        iziToast.warning({
          //icon: 'fa fa-microphone',
          position: 'center',
          message: "Mohon Lengkapi data form !"
        });
      }
    }

    function approval2() 
    {
      var IsValid = $("form[name='formApp']").valid();
      if(IsValid){
        $.ajax({
          type: "POST",
          url : baseUrl + "/hrd/recruitment/approval_2",
          data: $('#form-app').serialize(),
          success: function(response)
          {
            if(response.status == "sukses")
            {
              iziToast.success({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: response.pesan,
                onClosing: function(instance, toast, closedBy){
                   window.location.href = baseUrl+"/hrd/recruitment/rekrut";
                }
              });
            }
            else
            {
              iziToast.error({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: "Data Gagal disimpan !",
                onClosing: function(instance, toast, closedBy){
                   window.location.href = baseUrl+"/hrd/recruitment/rekrut";
                }
              });
            }              
          },
          error: function()
          {
            iziToast.error({
              position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
              title: 'Pemberitahuan',
              message: "Data gagal disimpan !"
            });
          },
          async: false
        });
      }
      else //else validation
      {
        iziToast.warning({
          //icon: 'fa fa-microphone',
          position: 'center',
          message: "Mohon Lengkapi data form !"
        });
      }
    }

    function update_aproval2() 
    {
      var IsValid = $("form[name='formApp']").valid();
      if(IsValid){
        $.ajax({
          type: "POST",
          url : baseUrl + "/hrd/recruitment/update_approval_2",
          data: $('#form-app').serialize(),
          success: function(response)
          {
            if(response.status == "sukses")
            {
              iziToast.success({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: response.pesan,
                onClosing: function(instance, toast, closedBy){
                   window.location.href = baseUrl+"/hrd/recruitment/rekrut";
                }
              });
            }
            else
            {
              iziToast.error({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: "Data Gagal disimpan !",
                onClosing: function(instance, toast, closedBy){
                   window.location.href = baseUrl+"/hrd/recruitment/rekrut";
                }
              });
            }              
          },
          error: function()
          {
            iziToast.error({
              position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
              title: 'Pemberitahuan',
              message: "Data gagal disimpan !"
            });
          },
          async: false
        });
      }
      else //else validation
      {
        iziToast.warning({
          //icon: 'fa fa-microphone',
          position: 'center',
          message: "Mohon Lengkapi data form !"
        });
      }
    }

    function skipApproval2(idPelamar) {
      iziToast.question({
        close: false,
        overlay: true,
        displayMode: 'once',
        //zindex: 999,
        title: 'Skip Approval ke 2 (Khusus Lowongan Staff)',
        message: 'Apakah anda yakin ?',
        position: 'center',
        buttons: [
          ['<button><b>Ya</b></button>', function (instance, toast) {
            $.ajax({
              url : baseUrl + "/hrd/recruitment/skip_approval_2",
              type: "POST",
              dataType: "JSON",
              data: {id:idPelamar, "_token": "{{ csrf_token() }}"},
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
                      window.location.href = baseUrl+"/hrd/recruitment/rekrut";
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
                      window.location.href = baseUrl+"/hrd/recruitment/rekrut";
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
          }, true],
          ['<button>Tidak</button>', function (instance, toast) {
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
          }],
        ]
      });
    }

    function approval3() 
    {
      var IsValid = $("form[name='formApp']").valid();
      if(IsValid){
        $.ajax({
          type: "POST",
          url : baseUrl + "/hrd/recruitment/approval_3",
          data: $('#form-app').serialize(),
          success: function(response)
          {
            if(response.status == "sukses")
            {
              iziToast.success({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: response.pesan,
                onClosing: function(instance, toast, closedBy){
                   window.location.href = baseUrl+"/hrd/recruitment/rekrut";
                }
              });
            }
            else
            {
              iziToast.error({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: "Data Gagal disimpan !",
                onClosing: function(instance, toast, closedBy){
                   window.location.href = baseUrl+"/hrd/recruitment/rekrut";
                }
              });
            }              
          },
          error: function()
          {
            iziToast.error({
              position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
              title: 'Pemberitahuan',
              message: "Data gagal disimpan !"
            });
          },
          async: false
        });
      }
      else //else validation
      {
        iziToast.warning({
          //icon: 'fa fa-microphone',
          position: 'center',
          message: "Mohon Lengkapi data form !"
        });
      }
    }

    function approval3_skip() 
    {
      var IsValid = $("form[name='formApp']").valid();
      if(IsValid){
        $.ajax({
          type: "POST",
          url : baseUrl + "/hrd/recruitment/approval_3_skip",
          data: $('#form-app').serialize(),
          success: function(response)
          {
            if(response.status == "sukses")
            {
              iziToast.success({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: response.pesan,
                onClosing: function(instance, toast, closedBy){
                   window.location.href = baseUrl+"/hrd/recruitment/rekrut";
                }
              });
            }
            else
            {
              iziToast.error({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: "Data Gagal disimpan !",
                onClosing: function(instance, toast, closedBy){
                   window.location.href = baseUrl+"/hrd/recruitment/rekrut";
                }
              });
            }              
          },
          error: function()
          {
            iziToast.error({
              position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
              title: 'Pemberitahuan',
              message: "Data gagal disimpan !"
            });
          },
          async: false
        });
      }
      else //else validation
      {
        iziToast.warning({
          //icon: 'fa fa-microphone',
          position: 'center',
          message: "Mohon Lengkapi data form !"
        });
      }
    }

    function jadwalInterview() 
    {
      var id = $('#ip_id').val();
      $.ajax({
        url : baseUrl + "/hrd/recruitment/get-jadwal-interview/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(response)
        {
          if (response.data.length > 0) {
            var date = response.data[0].pj_date;
            var tglbaru = date.split("-").reverse().join("-");
            $('#i_pjadwal_id').val(response.data[0].pj_id);
            $('#i_pelamarid').val(response.data[0].pj_pid);
            $('#i_tgl').val(tglbaru);
            $('#i_jam').val(response.data[0].pj_time);
            $('#i_lokasi').val(response.data[0].pj_lokasi);
            $('#i_pic').val(response.data[0].c_nik+' '+response.data[0].c_nama);
            $('#i_pic_id').val(response.data[0].pj_pmid);
            $('#i_review1').val(response.data[0].pj_review_i);
          }else{
            $('#i_pjadwal_id').val('');
            $('#i_pelamarid').val(id);
            $('#i_tgl').val('');
            $('#i_jam').val('');
            $('#i_lokasi').val('');
            $('#i_pic').val('');
            $('#i_pic_id').val('');
            $('#i_review1').val('');
          }
          
          $('#test_interview').modal('show');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
      });
    }

    function procJadwalInterview() 
    {
      var IsValid = $("form[name='formInterview']").valid();
      if(IsValid){
        $.ajax({
          type: "POST",
          url : baseUrl + "/hrd/recruitment/proc-jadwal-interview",
          data: $('#form-interview').serialize(),
          success: function(response)
          {
            if(response.status == "sukses")
            {
              iziToast.success({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: response.pesan,
                onClosing: function(instance, toast, closedBy){
                   $('#test_interview').modal('hide');
                   location.reload();
                }
              });
            }
            else
            {
              iziToast.error({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: "Data Gagal disimpan !",
                onClosing: function(instance, toast, closedBy){
                   $('#test_interview').modal('hide');
                   location.reload();
                }
              });
            }              
          },
          error: function()
          {
            iziToast.error({
              position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
              title: 'Pemberitahuan',
              message: "Data gagal disimpan !",
              onClosing: function(instance, toast, closedBy){
                $('#test_interview').modal('hide');
                location.reload();
              }
            });
          },
          async: false
        });
      }
      else //else validation
      {
        iziToast.warning({
          //icon: 'fa fa-microphone',
          position: 'center',
          message: "Mohon Lengkapi data form !"
        });
      }
    }

    function jadwalPresentasi() 
    {
      var id = $('#ip_id').val();
      $.ajax({
        url : baseUrl + "/hrd/recruitment/get-jadwal-presentasi/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(response)
        {
          if (response.data.length > 0) {
            var date = response.data[0].pj_date;
            var tglbaru = date.split("-").reverse().join("-");
            $('#p_pjadwal_id').val(response.data[0].pj_id);
            $('#p_pelamarid').val(response.data[0].pj_pid);
            $('#p_tgl').val(tglbaru);
            $('#p_jam').val(response.data[0].pj_time);
            $('#p_lokasi').val(response.data[0].pj_lokasi);
            $('#p_pic').val(response.data[0].c_nik+' '+response.data[0].c_nama);
            $('#p_pic_id').val(response.data[0].pj_pmid);
          }else{
            $('#p_pjadwal_id').val('');
            $('#p_pelamarid').val(id);
            $('#p_tgl').val('');
            $('#p_jam').val('');
            $('#p_lokasi').val('');
            $('#p_pic').val('');
            $('#p_pic_id').val('');
          }
          
          $('#test_presentasi').modal('show');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
      });
    }

    function procJadwalPresentasi() 
    {
      var IsValid = $("form[name='formPresentasi']").valid();
      if(IsValid){
        $.ajax({
          type: "POST",
          url : baseUrl + "/hrd/recruitment/proc-jadwal-presentasi",
          data: $('#form-presentasi').serialize(),
          success: function(response)
          {
            if(response.status == "sukses")
            {
              iziToast.success({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: response.pesan,
                onClosing: function(instance, toast, closedBy){
                   $('#test_presentasi').modal('hide');
                   location.reload();
                }
              });
            }
            else
            {
              iziToast.error({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: "Data Gagal disimpan !",
                onClosing: function(instance, toast, closedBy){
                   $('#test_presentasi').modal('hide');
                   location.reload();
                }
              });
            }              
          },
          error: function()
          {
            iziToast.error({
              position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
              title: 'Pemberitahuan',
              message: "Data gagal disimpan !",
              onClosing: function(instance, toast, closedBy){
                $('#test_presentasi').modal('hide');
                location.reload();
              }
            });
          },
          async: false
        });
      }
      else //else validation
      {
        iziToast.warning({
          //icon: 'fa fa-microphone',
          position: 'center',
          message: "Mohon Lengkapi data form !"
        });
      }
    }

  </script>
@endsection()