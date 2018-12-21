@extends('main')
@section('content')
    <!--BEGIN PAGE WRAPPER-->
    <div id="page-wrapper">
        <!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
            <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                <div class="page-title">Profil Perusahaan</div>
            </div>
            <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i
                            class="fa fa-angle-right"></i>&nbsp;&nbsp;
                </li>
                <li><i></i>&nbsp;System&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                <li class="active">Profil Perusahaan</li>
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

                    </div>

                    <div class="col-lg-12">


                        <div class="row">
                            <div class="col-md-12"><h2>Profile: {{ $data->cp_name }}</h2>

                                <div class="row mtl">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="text-center mbl">
                                              @if($data->cp_image == null)
                                              <img src="http://lorempixel.com/640/480/business/1/" style="text-align: center;" alt="" class="img-responsive"/>
                                              @else
                                              <img src="{{ $data->cp_image }}" style="text-align: center;" alt="" class="img-responsive"/>
                                              @endif
                                            </div>
                                        </div>
                                        <table class="table table-striped table-hover">
                                            <tbody>
                                            <tr>
                                                <td>Nama Perusahaan</td>
                                                <td>{{ $data->cp_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Address</td>
                                                <td>{{ $data->cp_address }}</td>
                                            </tr>
                                            <tr>
                                                <td>Pemilik</td>
                                                <td>{{ $data->cp_owner }}</td>
                                            </tr>
                                            <tr>
                                                <td>Berdiri</td>
                                                <td>{{ Carbon\Carbon::parse($data->cp_date)->format('d M Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td>No Telp</td>
                                                <td>{{ $data->cp_telp }}</td>
                                            </tr>
                                            <tr>
                                                <td>No Telp 2</td>
                                                <td>{{ $data->cp_telp2 }}</td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td>{{ $data->cp_email }}</td>
                                            </tr>
                                            <tr>
                                                <td>Fax</td>
                                                <td>{{ $data->cp_fax }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-9">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a href="#tab-edit" data-toggle="tab">Edit Profil Perusahaan</a>
                                            </li>
                                        </ul>
                                        <div id="generalTabContent" class="tab-content">
                                            <div id="tab-edit" class="tab-pane fade in active">
                                                <form action="profil-perusahaanu/update" method="post" class="form-horizontal"  accept-charset="UTF-8" enctype="multipart/form-data">
                                                  <h3>Edit Profil Perusahaan</h3>
                                                  {{ csrf_field() }}
                                                    <div class="form-group">
                                                      <label class="col-sm-3 control-label">Nama Perusahaan</label>

                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-9">
                                                                  <input type="text" placeholder="Nama Perusahaan" class="form-control" name="companyname" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group"><label class="col-sm-3 control-label">Pemilik</label>
                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-9"><input type="text" placeholder="Nama Pemilik" class="form-control" name="ownername" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group"><label class="col-sm-3 control-label">Berdiri</label>
                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-4"><input id="datepicker-normal" type="text" class="form-control" name="companydate" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                      <label class="col-sm-3 control-label">Alamat</label>
                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-9"><textarea rows="3" name="companyaddress" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group"><label class="col-sm-3 control-label">No Telp</label>
                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-9"><input type="text" placeholder="Nomor Telpon" class="form-control" name="telp" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group"><label class="col-sm-3 control-label">No Telp 2</label>
                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-9"><input type="text" placeholder="Nomor Telpon 2" class="form-control" name="telp2" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group"><label class="col-sm-3 control-label">No Fax</label>
                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-9"><input type="text" placeholder="Faximile" class="form-control" name="fax" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group"><label class="col-sm-3 control-label">No Email</label>
                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-9"><input type="text" placeholder="Email" class="form-control" name="email" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group"><label class="col-sm-3 control-label">Logo</label>
                                                        <div class="col-sm-9 controls">
                                                            <div class="row">
                                                                <div class="col-xs-9"><input type="file" class="form-control" name="fileImage" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <button type="submit" class="btn btn-green btn-block">Update</button>
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
        </div>
    </div>

@endsection
@section("extra_scripts")
    <script type="text/javascript">
      $('#datepicker-normal').datepicker({
        format:"dd-mm-yyyy",
        autoclose:true
      })
    </script>
@endsection