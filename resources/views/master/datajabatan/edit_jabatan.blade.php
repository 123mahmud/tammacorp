@extends('main') @section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Data Jabatan</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Data Jabatan</li>
      <li>
        <i class="fa fa-angle-right"></i>&nbsp;Edit Data Jabatan&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
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
              <a href="#alert-tab" data-toggle="tab">Data Jabatan</a>
            </li>
            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px; margin-bottom: 10px;">
                  <div class="col-md-5 col-sm-6 col-xs-8">
                    <h4>Edit Data Jabatan</h4>
                  </div>
                  <div class="col-md-7 col-sm-6 col-xs-4 " align="right" style="margin-top:5px;margin-right: -25px;">
                    <a href="{{ url('master/datajabatan/datajabatan') }}" class="btn">
                      <i class="fa fa-arrow-left"></i>
                    </a>
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 15px;">

                  <form method="POST" class="form" action="{{ url('master/datajabatan/update-jabatan') }}/{{$jabatan->c_id}}" enctype="multipart/form-data"
                    style="font-family:Arial;">
                    {{ csrf_field() }} {{ method_field('PUT') }}
                    <table class="table">
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Divisi</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select disabled id="divisi" name="c_divisi_id" class="form-control input-sm">
                            <?php foreach($divisi as $div){ ?>
                            <?php if($div->c_id == $jabatan->c_divisi_id){ ?>
                            <option value="{{ $div->c_id }}" selected="">{{ $div->c_divisi }}</option>
                            <?php }else{ ?>
                            <option value="{{ $div->c_id }}">{{ $div->c_divisi }}</option>
                            <?php }} ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Posisi</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select disabled id="divisi" name="c_sub_divisi_id" class="form-control input-sm">
                            <option>--pilih posisi--</option>
                            <?php foreach($subdivisi as $sdiv){ ?>
                            <?php if($sdiv->c_id == $jabatan->c_sub_divisi_id){ ?>
                            <option value="{{ $sdiv->c_id }}" selected="">{{ $sdiv->c_subdivisi }}</option>
                            <?php }else{ ?>
                            <option value="{{ $sdiv->c_id }}">{{ $sdiv->c_subdivisi }}</option>
                            <?php }} ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Nama Jabatan</label>
                      </div>
                      <div class="col-md-10 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input required type="text" name="c_posisi" id="c_posisi" class="form-control input-sm" value="{{ $jabatan->c_posisi }}">
                        </div>
                      </div>
                    </table>
                    <div class="col-sm-12">
                      <input type="submit" value="Simpan" class="btn btn-warning pull-right">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endsection