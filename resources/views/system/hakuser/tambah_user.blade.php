@extends('main')
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
            <div class="page-title">Form Manajemen User</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i
                        class="fa fa-angle-right"></i>&nbsp;&nbsp;
            </li>
            <li><i></i>&nbsp;System&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Manajemen User</li>
            <li><i class="fa fa-angle-right"></i>&nbsp;Form Manajemen User&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
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
                        <li class="active"><a href="#alert-tab" data-toggle="tab">Form Manajemen User</a></li>
                        <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                        <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                    </ul>
                    <div id="generalTabContent" class="tab-content responsive">
                        <div id="alert-tab" class="tab-pane fade in active">
                            <div class="row">

                                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">
                                    <div class="col-md-5 col-sm-6 col-xs-8">
                                        <h4>Form Manajemen User</h4>
                                    </div>
                                    <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                                        <a href="{{ url('system/hakuser/user') }}" class="btn">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>

                                    <form id="data-user">
                                        {{csrf_field()}}
                                        <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg"
                                             style="padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">

                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                <label class="tebal">Username<font color="red">*</font></label>
                                            </div>

                                            <div class="col-md-3 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-sm" name="username" value="" id="username">
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                <label class="tebal">Password<font color="red">*</font></label>
                                            </div>

                                            <div class="col-md-3 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-sm" name="password" value="" id="password">
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                <label class="tebal">Nama Lengkap<font color="red">*</font></label>
                                            </div>

                                            <div class="col-md-3 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <input type="text" name="NamaLengkap" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                                                    <input type="hidden" name="IdPegawai" class="form-control input-sm ui-autocomplete-input">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-4 col-xs-12">

                                                <label class="tebal">Tanggal Lahir<font color="red">*</font></label>
                                            </div>
                                            <div class="col-md-3 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <input class="form-control input-sm disable" value="" type="text" name="TanggalLahir" readonly>
                                                </div>

                                            </div>

                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                <label class="tebal">Alamat<font color="red">*</font></label>
                                            </div>

                                            <div class="col-md-9 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <textarea name="alamat" class="form-control" readonly></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                <label class="tebal">Jabatan/Posisi:</label>
                                            </div>

                                            <div class="col-md-9 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                  <input type="text" class="form-control input-sm" name="pp_jabatan" id="pp_jabatan" readonly>
                                                  <input type="hidden" class="form-control input-sm" name="id_jabatan" id="id_jabatan" readonly>
                                                </div>
                                            </div>

                                            <div align="right" style="padding-top:10px;">
                                                <div id="div_button_save" class="form-group">
                                                    <button type="button" id="button_save" class="btn btn-primary div_button_save" 
                                                        onclick="simpanDataUser()">Simpan Data
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-12" id="detail">
                                            <label class="tebal">- Hak Akses User</label>


                                            <div class="table-responsive">
                                                <table class="table tabelan table-bordered table-hover" id="data-detail">
                                                    <thead>
                                                    <tr>
                                                        <th>Nama Menu</th>
                                                        <th>Lihat</th>
                                               {{--      <th>Tambah</th>
                                                        <th>Perbarui</th>
                                                        <th>Hapus</th>
                                                        <th>Laporan</th>
                                                        <th>Unlock</th> --}}
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $nomor=1;
                                                        @endphp

                                                        @foreach($access as $index => $data)
                                                            @if($data->a_parrent == 0)
                                                                <tr style="background: #f7e8e8">
                                                                    <td>
                                                                        <input type="hidden" name="id_access[]" value="{{$data->a_id}}">
                                                                        {{$nomor}}. &nbsp; <strong>{{$data->a_name}}</strong>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="hidden" value="N" class="checkbox" name="view[]" id="view-{{$data->a_id}}"> 
                                                                        <input type="checkbox" class="checkbox" 
                                                                            onchange="simpanView('{{$data->a_id}}')" 
                                                                            id="view1-{{$data->a_id}}">
                                                                    </td>
                                                                    {{-- <td>
                                                                        <input type="hidden" value="N" class="checkbox"
                                                                               name="insert[]" id="insert-{{$data->a_id}}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="hidden" value="N" class="checkbox"
                                                                               name="update[]" id="update-{{$data->a_id}}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="hidden" value="N" class="checkbox"
                                                                               name="delete[]" id="delete-{{$data->a_id}}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="hidden" value="N" class="checkbox"
                                                                               name="laporan[]"
                                                                               id="laporan-{{$data->a_id}}">
                                                                    </td>
                                                                    <td>

                                                                        <input type="hidden" value="N" class="checkbox"
                                                                               name="unlock[]" id="unlock-{{$data->a_id}}">

                                                                    </td> --}}
                                                                    @php
                                                                        $nomor++;
                                                                    @endphp
                                                                </tr>
                                                            @else
                                                                <tr>
                                                                    <td>
                                                                        <input type="hidden" name="id_access[]" value="{{$data->a_id}}">
                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$data->a_name}}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="hidden" value="N" class="checkbox" name="view[]" 
                                                                            id="view-{{$data->a_id}}">
                                                                        <input type="checkbox" class="checkbox" 
                                                                            onchange="simpanView('{{$data->a_id}}')"
                                                                            id="view1-{{$data->a_id}}">
                                                                    </td>
                                                                    {{-- <td class="text-center">
                                                                        <input type="checkbox" class="checkbox"
                                                                               onchange="simpanInsert('{{$data->a_id}}')"
                                                                               id="insert1-{{$data->a_id}}">

                                                                        <input type="hidden" value="N" class="checkbox"
                                                                               name="insert[]" id="insert-{{$data->a_id}}">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" class="checkbox"
                                                                               onchange="simpanUpdate('{{$data->a_id}}')"
                                                                               id="update1-{{$data->a_id}}">

                                                                        <input type="hidden" value="N" class="checkbox"
                                                                               name="update[]" id="update-{{$data->a_id}}">

                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" class="checkbox"
                                                                               onchange="simpanDelete('{{$data->a_id}}')"
                                                                               id="delete1-{{$data->a_id}}">

                                                                        <input type="hidden" value="N" class="checkbox"
                                                                               name="delete[]" id="delete-{{$data->a_id}}">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" class="checkbox"
                                                                               name="laporan[]"
                                                                               onchange="simpanLaporan('{{$data->a_id}}')"
                                                                               id="laporan-{{$data->a_id}}">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" class="checkbox"
                                                                               name="unlock[]"
                                                                               onchange="simpanUnlock('{{$data->a_id}}')"
                                                                               value="1" id="unlock-{{$data->a_id}}">
                                                                    </td> --}}
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
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
<!--END PAGE WRAPPER-->
@endsection
@section("extra_scripts")
    {{--<script src="{{ asset ('assets/script/icheck.min.js') }}"></script> --}}
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

            //autocomplete
            $('input[name="NamaLengkap"]').focus(function() {
               var key = 1;
               $('input[name="NamaLengkap"]').autocomplete({
                  source: baseUrl+'/system/hakuser/autocomplete-pegawai',
                  minLength: 1,
                  select: function(event, ui) {
                    $('input[name="NamaLengkap"]').val(ui.item.label);
                    $('input[name="IdPegawai"]').val(ui.item.id);
                    $('input[name="TanggalLahir"]').val(ui.item.lahir_txt);
                    $('input[name="id_jabatan"]').val(ui.item.jabatan_id);
                    $('input[name="pp_jabatan"]').val(ui.item.jabatan_txt);
                    $('textarea[name="alamat"]').text(ui.item.alamat_txt);
                  }
                });
                $('input[name="NamaLengkap"]').val('');
                $('input[name="IdPegawai"]').val('');
                $('input[name="TanggalLahir"]').val('');
                $('input[name="id_jabatan"]').val('');
                $('input[name="pp_jabatan"]').val('');
                $('textarea[name="alamat"]').text('');
            });
        });


        function simpanDataUser() {
            $('.div_button_save').attr('disabled', 'disabled');
            $.ajax({
                url: baseUrl + '/system/hakuser/simpan-user',
                type: 'POST',
                timeout: 10000,
                data: $('#data-user').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == 'sukses') {
                        window.location = baseUrl + '/system/hakuser/user';
                        $('.div_button_save').removeAttr('disabled', 'disabled');
                        iziToast.success({
                            timeout: 5000,
                            position: "topRight",
                            icon: 'fa fa-chrome',
                            title: '',
                            message: 'User Baru Tersimpan.'
                        });
                    }else{
                        $('.div_button_save').removeAttr('disabled', 'disabled');
                        iziToast.error({
                            position: "topRight",
                            title: '',
                            message: 'Mohon melengkapi data.'
                        });
                    }
                }
            });
        }

        function simpanView(id) {
            if ($('#view1-' + id).prop('checked')) {
                $('#view-' + id).val('Y')
            } else {
                $('#view-' + id).val('N')
            }
        }


        // function simpanInsert(id) {
        //     if ($('#insert1-' + id).prop('checked')) {
        //         $('#insert-' + id).val('Y')
        //     } else {
        //         $('#insert-' + id).val('N')
        //     }
        // }


        // function simpanUpdate(id) {

        //     if ($('#update1-' + id).prop('checked')) {
        //         $('#update-' + id).val('Y')
        //     } else {
        //         $('#update-' + id).val('N')
        //     }
        // }

        // function simpanDelete(id) {
        //     if ($('#delete1-' + id).prop('checked')) {
        //         $('#delete-' + id).val('Y')
        //     } else {
        //         $('#delete-' + id).val('N')
        //     }
        // }
    </script>
@endsection
