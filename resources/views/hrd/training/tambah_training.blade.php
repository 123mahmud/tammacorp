@extends('main')
@section('extra_styles')
<style type="text/css">
  .bold{
    font-weight: bold;
  }
  .div-answer{
    margin-left: 15px;
    margin-right: 15px;
  }
</style>
@endsection
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
      <!--BEGIN TITLE & BREADCRUMB PAGE-->
      <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
          <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
              <div class="page-title">Form Training Pegawai</div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
              <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li><i></i>&nbsp;HRD&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li><i></i>&nbsp;Training&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li class="active">Form Training Pegawai</li>
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
                      <li class="active"><a href="#alert-tab" data-toggle="tab">Form Training Pegawai</a></li>
                      <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                      <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
                    </ul>
                    <div id="generalTabContent" class="tab-content responsive">

                      <div id="alert-tab" class="tab-pane fade in active">

                        <div class="row" align="right"  style="margin-top: -10px;margin-bottom: 15px;">
                          <div class="col-md-10 col-sm-10 col-xs-10" align="left">
                            <h4>Form Training Pegawai</h4>
                          </div>
                          <div class="col-md-2 col-sm-2 col-xs-2">
                            <a href="{{route('training')}}" class="btn btn-box-tool"><i class="fa fa-arrow-left"></i></a>
                          </div>
                        </div>

                        <div class="row">
                          <form id="simpanPengajuan">

                          <div class="col-md-12 col-sm-12 col-xs-12 ">

                            <div class="col-md-12 tamma-bg" style="margin-top: 5px;
                            margin-bottom: 20px;margin-bottom: 25px; padding-bottom:25px;padding-top:25px;">

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <label class="bold">Nama:</label>
                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <input type="text" readonly="" class="form-control input-sm" name="namaStaff" value="{{$staff['nama']}}">
                                  <input type="hidden" readonly="" class="form-control input-sm" name="idStaff" value="{{$staff['id']}}">
                                </div>
                              </div>

                              <div class="col-md-2 col-sm-6 col-xs-12">
                                <label class="bold">Jabatan/Posisi:</label>
                              </div>

                              <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <select name="pp_jabatan" id="tampil_data" class="form-control input-sm">
                                      <option value="{{$jabatan->j_id}}" class="form-control input-sm">{{$jabatan->c_posisi}}</option>
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <label class="bold">Jenis Pelatihan:</label>
                              </div>

                              <div class="col-md-9 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <select name="jenis_pelatihan" id="tampil_data" class="form-control input-sm">
                                      <option value="" class="form-control input-sm">- Pilih Jenis Pelatihan</option>
                                    @foreach ($pelatihan as $data)
                                      <option value="{{$data->dp_id}}" class="form-control input-sm">{{$data->dp_name}}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-3 col-sm-6 col-xs-12">
                                <label class="bold">Nama Atasan:</label>
                              </div>

                              <div class="col-md-9 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <select name="pp_nama_atasan" id="tampil_data" class="form-control input-sm">
                                      <option value="" class="form-control input-sm">-Pilih Nama Atasan</option>
                                    @foreach ($staf as $data)
                                      <option value="{{$data->mp_id}}" class="form-control input-sm">{{$data->c_nama}}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>

                            </div>

                          </div>
                          </form>
                        </div>
                        <div align="right" style="margin-top: 10px;">
                          <button class="btn btn-primary simpanButton" onclick="simpan();">Simpan</button>
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
    <script type="text/javascript">
    $(document).ready(function () {
        var extensions = {
            "sFilterInput": "form-control input-sm",
            "sLengthSelect": "form-control input-sm"
        }
        // Used when bJQueryUI is false
        $.extend($.fn.dataTableExt.oStdClasses, extensions);
        // Used when bJQueryUI is true
        $.extend($.fn.dataTableExt.oJUIClasses, extensions);

      });

      function simpan() {
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $('.simpanButton').attr('disabled', 'disabled');
          var a = $('#simpanPengajuan').serialize();
          $.ajax({
              url: baseUrl + "/hrd/training/save",
              type: 'GET',
              data: a,
              success: function (response, customer) {
                  if (response.status == 'sukses') {
                      iziToast.success({
                          timeout: 5000,
                          position: "topRight",
                          icon: 'fa fa-chrome',
                          title: '',
                          message: 'Data customer tersimpan.'
                      });
                      $('#simpanPengajuan')[0].reset();
                      window.location.href = "{{route('training')}}";
                      $('.simpanButton').removeAttr('disabled', 'disabled');
                  } else {
                      iziToast.error({
                          position: "topRight",
                          title: '',
                          message: 'Mohon melengkapi data.'
                      });
                      $('.simpanButton').removeAttr('disabled', 'disabled');
                  }
              }
          })
      }

    </script>
@endsection()
