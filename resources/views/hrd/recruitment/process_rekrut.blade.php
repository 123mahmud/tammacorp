@extends('main')
@section('extra_styles')
<style type="text/css">
  
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
              @include('hrd.recruitment.diterima')

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
                          <input type="text" class="form-control input-sm" name="jabatan" id="ip_jabatan" value="{{$data->l_name}}" readonly>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6 col-sm-12 col-xs-12">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <label class="bold s16">Status Pelamar</label>
                        </div>
                      </div>

                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <label style="font-style: oblique; font-size: 16px; color: blue;">{{$data->p_st_name}}</label>
                        <label style="font-style: oblique; font-size: 16px;">( {{$data->p_stdt_name}} )</label>
                      </div>                    
                    </div>
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
                              <label>
                                <input type="radio" name="approval_3" id="{{'app_'.$val->p_stdt_id}}" class="approval_3" value="{{$val->p_stdt_id}}"
                                @if ($val->p_stdt_id == $cek_app3)
                                  checked
                                @endif> 
                                {{$val->p_stdt_name}}
                              </label>
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
          $('#appending').append('<button class="btn btn-primary" id="btn_app" onclick="approval2()">Process</button>'
                                +'<a href="'+baseUrl+'/hrd/recruitment/rekrut" class="btn btn-default">Back</a>');
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
          $('#appending').append('<button class="btn btn-primary" id="btn_app" onclick="approval3()">Process</button>'
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

      
      $('#app_3').prop( "checked", true );

    });  

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

  </script>
@endsection()