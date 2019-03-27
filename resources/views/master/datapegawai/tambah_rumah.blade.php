@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Rumah Produksi</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Data Pegawai</li><li><i class="fa fa-angle-right"></i>&nbsp;Rumah Produksi&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
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
            <li class="active"><a href="#alert-tab" data-toggle="tab">Form Rumah Produksi</a></li>
            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
                <div class="col-md-12" style="margin-top: -10px;margin-bottom: 20px;">
                  <div class="col-md-5 col-sm-6 col-xs-8">
                    <h4>Tambah Rumah Produksi</h4>
                  </div>
                  <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                    <a href="{{ url('master/datapegawai/pegawai') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                  </div>
                </div>
                <hr>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <form id="form-save">
                    <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">
                      <div class="col-md-2 col-sm-3 col-xs-12">
                        <label class="tebal">Rumah Produksi</label>
                      </div>
                      <div class="col-md-10 col-sm-9 col-xs-12">
                        <div class="form-group">
                          <input type="text" class="form-control input-sm" value="" id="id" name="mp_name">
                        </div>
                      </div>
                      <div class="col-md-12">
                        
                      </div>
                      <div class="col-md-2 col-sm-3 col-xs-12">
                        <label class="tebal">Alamat</label>
                      </div>
                      <div class="col-md-10 col-sm-9 col-xs-12">
                        <div class="form-group">
                          <div class="input-icon right">
                            <input type="text" id="nama" name="mp_alamat" class="form-control input-sm" value="">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div align="right">
                      <div class="form-group">
                        <button type="button" name="tambah_data" class="btn btn-primary" onclick="simpanData()">Simpan Data</button>
                      </div>
                    </div>
                    
                  </form>
                  
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
                            
@endsection
@section("extra_scripts")
<script type="text/javascript">     

    function simpanData(){
      var id = $("#id").val();
      var nama = $("#nama").val();

      if(id == '' || id == null ){
        toastr.warning('Data Harus Diisi!','Peringatan')

        return false;
      }

      if(nama == '' || nama == null ){
        toastr.warning('Data Harus Diisi!','Peringatan')

        return false;
      }
      
      $.ajax({
        url: baseUrl + "/master/datapegawai/simpan-rumah",
        type:'get',
        data: $('#form-save').serialize(),
        success:function(response){
        toastr.success('Data Telah Tersimpan!','Pemberitahuan')
          if (response.status == 'sukses') {
            window.location = ('{{ url('master/datapegawai/pegawai') }}')
          }
        
        }
      })

    }


</script>
@endsection                            
