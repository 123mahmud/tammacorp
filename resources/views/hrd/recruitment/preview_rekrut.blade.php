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
  .divided{
    border-bottom: 1px solid black;
  }
  .text-lightgreen{
    color: lightgreen;
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
                      
                      <div class="row tamma-bg" style="margin-top: -23px;padding-top: 23px;padding-bottom: 10px;border-radius: unset;margin-bottom: 15px;">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                          

                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="form-group">
                                <label class="bold s16 underline">Data Pelamar</label>
                              </div>
                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Nama</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="" value="{{$data->p_name}}">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Nomor Identitas</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="" value="{{$data->p_nip}}">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Alamat</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="" value="{{$data->p_address}}">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Alamat Sekarang</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="" value="{{$data->p_address_now}}">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Tempat Lahir</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="" value="{{$data->p_birth_place}}">
                              </div>
                            </div>
                         
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Tanggal Lahir</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="" value="{{date("d-M-Y", strtotime($data->p_birthday))}}">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Pendidikan</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="" value="{{$data->p_education}}">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Email</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="" value="{{$data->p_email}}">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Nomor Telpon/WA</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="" value="{{$data->p_tlp}}">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Agama</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="" value="{{$data->p_religion}}">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Status</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                @if ($data->p_status == 'M')
                                  <input type="text" class="form-control input-sm" readonly="" name="" value="Menikah">
                                @else
                                  <input type="text" class="form-control input-sm" readonly="" name="" value="Belum Menikah">
                                @endif
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Nama Suami/Istri</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="" value="{{$data->p_wife_name}}">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Anak</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="" value="{{$data->p_child}}">
                              </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <label>Promo dari pelamar</label>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <textarea cols="30" rows="7" class="form-control input-sm" readonly>{{$data->p_promo}}</textarea>
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">

                          <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="form-group">
                                <label class="bold s16 underline">Riwayat Pendidikan Terakhir</label>
                              </div>
                            </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Nama Sekolah/Universitas</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="" value="{{$data->p_schoolname}}">
                            </div>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Tahun Masuk</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="" value="{{$data->p_yearin}}">
                            </div>
                          </div>


                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Tahun Lulus</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="" value="{{$data->p_yearout}}">
                            </div>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Jurusan</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="" value="{{$data->p_jurusan}}">
                            </div>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Nilai</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="" value="{{$data->p_nilai}}">
                            </div>
                          </div>

                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">

                          <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="form-group">
                                <label class="bold s16 underline">Daftar Riwayat Hidup</label>
                              </div>
                            </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Nama Perusahaan</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="" value="{{$cv1[0]['d_cv_company']}}">
                            </div>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Tahun Awal</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="" value="{{$cv1[0]['d_cv_thnmasuk']}}">
                            </div>
                          </div>


                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Tahun Akhir</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="" value="{{$cv1[0]['d_cv_thnkeluar']}}">
                            </div>
                          </div>


                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Job Desc</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <textarea name="" class="form-control input-sm" id="" rows="3" readonly>{{$cv1[0]['d_cv_jobdesc']}}</textarea>
                            </div>
                          </div>

                          <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="form-group divided">
                            </div>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Nama Perusahaan</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="" value="{{$cv2[0]['d_cv_company']}}">
                            </div>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Tahun Awal</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="" value="{{$cv2[0]['d_cv_thnmasuk']}}">
                            </div>
                          </div>


                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Tahun Akhir</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <input type="text" class="form-control input-sm" readonly="" name="" value="{{$cv2[0]['d_cv_thnkeluar']}}">
                            </div>
                          </div>


                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <label>Job Desc</label>
                          </div>

                          <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                              <textarea name="" class="form-control input-sm" id="" rows="3" readonly>{{$cv2[0]['d_cv_jobdesc']}}</textarea>
                            </div>
                          </div>
                        </div>
                      </div>   

                      <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <label class="bold s16 underline">Kelengkapan Berkas</label>
                            </div>
                          </div>

                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                              <?php $d_drh = $drh[0]['bks_name']; ?>
                              <label>CV</label>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="" value="{{$d_drh}}">
                              </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                              @if ($d_drh == '')
                                <a href="javascript:void(0);" onclick="javascipt:window.open('{{url('/public/assets/berkas/dokumen-pelamar/'.$d_drh)}}');" class="popup btn btn-info disabled">Lihat Berkas</a>
                              @else
                                <a href="javascript:void(0);" onclick="javascipt:window.open('{{url('/public/assets/berkas/dokumen-pelamar/'.$d_drh)}}');" class="popup btn btn-info">Lihat Berkas</a>
                              @endif
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                              <?php $d_ija = $ijasah[0]['bks_name']; ?>
                              <label>Ijazah</label>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="" value="{{$d_ija}}">
                              </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                              @if ($d_ija == '')
                                <a href="javascript:void(0);" onclick="javascipt:window.open('{{url('/public/assets/berkas/dokumen-pelamar/'.$d_ija)}}');" class="popup btn btn-info disabled">Lihat Berkas</a>
                              @else
                                <a href="javascript:void(0);" onclick="javascipt:window.open('{{url('/public/assets/berkas/dokumen-pelamar/'.$d_ija)}}');" class="popup btn btn-info">Lihat Berkas</a>
                              @endif
                            </div>
                          </div>

                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                              <?php $d_serti = $serti[0]['bks_name']; ?>
                              <label>KTP</label>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="" value="{{$d_serti}}">
                              </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                              @if ($d_serti == '')
                                <a href="javascript:void(0);" onclick="javascipt:window.open('{{url('/public/assets/berkas/dokumen-pelamar/'.$d_serti)}}');" class="popup btn btn-info disabled">Lihat Berkas</a>
                              @else
                                <a href="javascript:void(0);" onclick="javascipt:window.open('{{url('/public/assets/berkas/dokumen-pelamar/'.$d_serti)}}');" class="popup btn btn-info">Lihat Berkas</a>
                              @endif
                            </div>
                          </div>
                          
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                              <?php $d_lain = $lain[0]['bks_name']; ?>
                              <label>Lain-lain</label>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="form-group">
                                <input type="text" class="form-control input-sm" readonly="" name="" value="{{$d_lain}}">
                              </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                              @if ($d_lain == '')
                                <a href="javascript:void(0);" onclick="javascipt:window.open('{{url('/public/assets/berkas/dokumen-pelamar/'.$d_lain)}}');" class="popup btn btn-info disabled">Lihat Berkas</a>
                              @else
                                <a href="javascript:void(0);" onclick="javascipt:window.open('{{url('/public/assets/berkas/dokumen-pelamar/'.$d_lain)}}');" class="popup btn btn-info">Lihat Berkas</a>
                              @endif
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top: 15px;">
                          <a href="{{route('rekrut')}}" class="btn btn-default">Kembali</a>
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

@endsection
@section("extra_scripts")
    <script type="text/javascript">



      $('.datepicker').datepicker({
        format:"dd-mm-yyyy"
      });
      $('.datepicker2').datepicker({
        format:"dd M yyyy"
      }); 
      $('.datepicker3').datepicker({
        timeFormat:  "hh:mm:ss"
      });       
      </script>
@endsection()