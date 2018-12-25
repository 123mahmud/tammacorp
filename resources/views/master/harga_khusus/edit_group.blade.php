@extends('main') @section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Data Group</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Data Group</li>
      <li>
        <i class="fa fa-angle-right"></i>&nbsp;Edit Data Group&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
    </ol>
    <div class="clearfix">
    </div>
  </div>
  <div class="page-content">
    <div id="tab-general">
      <div class="row mbl">
        <div class="col-lg-12">

          <div class="col-md-12">
            <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
            </div>
          </div>

          <ul id="generalTab" class="nav nav-tabs">
            <li class="active">
              <a href="#alert-tab" data-toggle="tab">Data Group</a>
            </li>
            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px; margin-bottom: 10px;">
                  <div class="col-md-5 col-sm-6 col-xs-8">
                    <h4>Edit Data Group</h4>
                  </div>
                  <div class="col-md-7 col-sm-6 col-xs-4 " align="right" style="margin-top:5px;margin-right: -25px;">
                    <a href="{{ url('master/grouphargakhusus/index') }}" class="btn">
                      <i class="fa fa-arrow-left"></i>
                    </a>
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 15px;">

                  <form method="GET" id="group">
                    <table class="table">
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Nama Posisi</label>
                      </div>
                      <div class="col-md-10 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input required type="text" name="pg_name" id="c_posisi" class="form-control input-sm" value="{{ $group->pg_name}}">
                        </div>
                      </div>
                    </table>
                    <div class="col-sm-12">
                      <input type="submit" value="Simpan" onclick="updateGroup({{$group->pg_id}});" class="btn btn-warning pull-right submitDivisi">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script type="text/javascript">
        function updateGroup(id){
           $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
        $('.submitDivisi').attr('disabled', 'disabled');
        $.ajax({
            url: baseUrl + "/master/grouphargakhusus/updategroup/" + id,
            type: 'GET',
            data: $('#group').serialize(),
            success: function (response) {
                if (response.status == 'sukses') {
                    iziToast.success({
                        timeout: 5000,
                        position: "topRight",
                        icon: 'fa fa-chrome',
                        title: '',
                        message: 'Data Berhasil di Update.'
                    });
                    window.location.href = baseUrl + "/master/grouphargakhusus/index";
                } else {
                    iziToast.error({
                        position: "topRight",
                        title: '',
                        message: 'Data Gagal di Update.'
                    });
                    $('.submitDivisi').removeAttr('disabled', 'disabled');
                }
            }
        })
        }
      </script>
      @endsection