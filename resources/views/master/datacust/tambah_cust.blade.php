@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Form Master Data Customer</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Master Data Customer</li><li><i class="fa fa-angle-right"></i>&nbsp;Form Master Data Customer&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
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
                              <li class="active"><a href="#alert-tab" data-toggle="tab">Form Master Data Customer</a></li>
                            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                        </ul>
                        <div id="generalTabContent" class="tab-content responsive">
                          <div id="alert-tab" class="tab-pane fade in active">
                          <div class="row">
                            <div class="col-md-12" style="margin-top: -10px;margin-bottom: 20px;">
                           <div class="col-md-5 col-sm-6 col-xs-8">
                             <h4>Form Master Data Customer</h4>
                           </div>
                           <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                             <a href="{{ url('master/datacust/cust') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                           </div>
                         </div>
                        <hr>
                         <div class="col-md-12 col-sm-12 col-xs-12">

                            <form method="get" id="form_cust" action="simpan_cust">
                              <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">
{{--                                 <div class="col-md-2 col-sm-3 col-xs-12">

                                      <label class="tebal">ID Customer</label>

                                </div>
                                <div class="col-md-4 col-sm-9 col-xs-12">
                                  <div class="form-group">
                                      <input type="text" class="form-control input-sm" readonly="true" name="id_cus_ut" value="{{$id_cust}}">
                                      <input type="hidden" name="id_cus_ut" value="{{$id_cust}}">
                                  </div>
                                </div> --}}
                                <div class="col-md-2 col-sm-3 col-xs-12">


                                      <label class="tebal">Nama Customer<font color="red">*</font></label>

                                </div>
                                <div class="col-md-4 col-sm-9 col-xs-12">
                                  <div class="form-group">
                                    <div class="input-icon right">
                                      <i class="glyphicon glyphicon-user"></i>
                                      <input type="text" id="nama_cus" name="nama_cus" class="form-control input-sm" value="{{ old('nama_cus') }}">

                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-2 col-sm-3 col-xs-12">

                                      <label class="tebal">Tanggal Lahir</label>

                                </div>
                                <div class="col-md-4 col-sm-9 col-xs-12">
                                  <div class="form-group">
                                    <div class="input-icon right">
                                      <i class="glyphicon glyphicon-calendar"></i>
                                      <input type="text" id="tgl_lahir" name="tgl_lahir" class="form-control input-sm datepicker" >
                                    </div>
                                  </div>
                                </div>



                                <div class="col-md-2 col-sm-3 col-xs-12">

                                      <label class="tebal">E-mail</label>

                                </div>
                                <div class="col-md-4 col-sm-9 col-xs-12">
                                  <div class="form-group">
                                    <div class="input-icon right">
                                      <i class="glyphicon glyphicon-envelope"></i>
                                      <input type="email" id="email" name="email" class="form-control input-sm"  value="{{ old('email') }}">

                                    </div>
                                  </div>
                                </div>

                                <div class="col-md-2 col-sm-3 col-xs-12">

                                      <label class="tebal">Tipe Customer</label>

                                </div>
                                <div class="col-md-4 col-sm-9 col-xs-12">
                                  <div class="form-group">

                                      <select name="tipe_cust" id="tipe_cust" class="form-control input-sm">
                                        <option value="RT">Retail</option>
                                        <option value="GR">Online</option>
                                      </select>

                                  </div>
                                </div>

                                <div class="col-md-2 col-sm-3 col-xs-12">


                                      <label class="tebal">Nomor HP<font color="red">*</font></label>

                                </div>

                                <div class="col-md-4 col-sm-9 col-xs-12">
                                  <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1">+62</span>
                                    <input type="text" id="no_hp" name="no_hp1" class="form-control input-sm"  value="{{ old('no_hp') }}">

                                    <span class="input-group-addon" id="basic-addon1">+62</span>
                                    <input type="text" id="no_hp" name="no_hp2" class="form-control input-sm"  value="{{ old('no_hp') }}">
                                  </div>
                                </div>
                                <div class="col-md-2 col-sm-3 col-xs-12">

                                      <label class="tebal">Kelas Customer</label>

                                </div>
                                <div class="col-md-4 col-sm-9 col-xs-12">
                                  <div class="form-group">

                                      <select name="c_class" id="c_class" class="form-control input-sm">
                                        <option value="C">C</option>
                                        <option value="B">B</option>
                                        <option value="A">A</option>
                                      </select>

                                  </div>
                                </div>

                                <div class="col-md-2 col-sm-3 col-xs-12">

                                      <label class="tebal">Wilayah</label>

                                </div>
                                <div class="col-md-4 col-sm-9 col-xs-12">
                                  <div class="form-group">
                                    <div class="input-icon right">
                                      <i class="glyphicon glyphicon-envelope"></i>
                                      <input type="text" id="wilayah" name="wilayah" class="form-control input-sm"  value="{{ old('email') }}">

                                    </div>
                                  </div>
                                </div>

                                <div class="col-md-2 col-sm-3 col-xs-12">


                                      <label class="tebal">Alamat</label>

                                </div>
                                <div class="col-md-4 col-sm-9 col-xs-12">
                                  <div class="form-group">
                                    <div class="input-icon right">
                                      <i class="glyphicon glyphicon-home"></i>
                                      <textarea id="alamat" name="alamat" class="form-control input-sm"  value="{{ old('alamat') }}"></textarea>
                                    </div>
                                  </div>
                                </div>

                              </div>

                              <div align="right">
                                <div class="form-group">
                                  <button type="button" name="tambah_data" class="btn btn-primary" onclick="simpan()">Simpan Data</button>
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

    function simpan (){
      

      var nama = $("#nama_cus").val();
      var tgl_lahir = $("#tgl_lahir").val();
      var email = $("#email").val();
      var no_hp = $("#no_hp").val();
      var alamat = $("#alamat").val();

      if(nama == '' || nama == null ){

       toastr.warning('Data Harus nama Diisi!','Peringatan');
        return false;
      }

      if(no_hp == '' || no_hp == null ){

       toastr.warning('Data Harus no hp Diisi!','Peringatan');
        return false;
      }

      $.ajax({
        url : baseUrl + "/master/datacust/simpan_cust",
        type:'POST',
        data: $('#form_cust').serialize(),
        success:function(response){
          if (response.status=='sukses') {
            toastr.info('Data berhasil di simpan.');
            window.location = (baseUrl+'/master/datacust/cust');
          }else{
            toastr.error('Data gagal di simpan.');
          }
        }
      })

    }


    $(document).on("click","input[name='tambah_data']",function(e){


      });

      $("#nama_cus").load("/master/datacust/tambah_cust", function(){
      $("#nama_cus").focus();
      });

  $('.datepicker').datepicker({
    autoclose: true,
    format:"dd-mm-yyyy",
    endDate: 'today'
    });//datepicker("setDate", "0");

</script>
@endsection
