@extends('main') 
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Master Tunjangan</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Master Tunjangan</li>
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
              <a href="#alert-tab" data-toggle="tab">Master Tunjangan</a>
            </li>
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:-10px;margin-bottom: 15px;">
                  <div class="col-md-5 col-sm-6 col-xs-8">
                    <h4>Form Master Tunjangan</h4>
                  </div>
                  <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                    <a href="{{ url('hrd/payroll/setting-gaji') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                  </div>
                </div>
                <div class="col-md-12">
                  <form method="POST" action="{{ url('hrd/payroll/simpan-tunjangan') }}" id="form_tunjangan">
                    {{ csrf_field() }}
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px; padding-bottom:5px;padding-top:15px;padding-left:-10px;padding-right: -10px; ">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <label class="tebal">Nama Tunjangan</label>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="nama" class="form-control input-sm">
                        </div>
                      </div>

                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <label class="tebal">Periode</label>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <select id="" name="periode" class="form-control input-sm">
                            <option value="">--pilih Periode--</option>
                            <option value="ST">Statis</option>
                            <option value="JM">Jam</option>
                            <option value="HR">Hari</option>
                            <option value="MG">Minggu</option>
                            <option value="BL">Bulan</option>
                            <option value="TH">Tahun</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <label class="tebal">Nilai Tunjangan</label>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="nilai" class="form-control input-sm currency">
                        </div>
                      </div>
                      
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <input type="button" value="Batal" class="btn btn-danger btn-block" onclick="batal()">
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <input type="submit" value="Simpan" class="btn btn-primary btn-block">
                      </div>
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
@section('extra_scripts')
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script src="{{ asset("js/inputmask/inputmask.jquery.js") }}"></script>
<script type="text/javascript">
  $(document).ready(function() { 
    //mask money
    $.fn.maskFunc = function(){
      $('.currency').inputmask("currency", {
        radixPoint: ",",
        groupSeparator: ".",
        digits: 2,
        autoGroup: true,
        prefix: '', //Space after $, this will not truncate the first character.
        rightAlign: false,
        oncleared: function () { self.Value(''); }
      });
    }

    $(this).maskFunc();
  }); 

  function batal() {
    $('#form_tunjangan')[0].reset();
  }
</script> 
@endsection