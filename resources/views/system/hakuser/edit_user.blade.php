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

                                <div class="col-md-12 col-sm-12 col-xs-12"
                                     style="margin-top: -10px;margin-bottom: 15px;">
                                    <div class="col-md-5 col-sm-6 col-xs-8">
                                        <h4>Form Manajemen User</h4>
                                    </div>
                                    <div class="col-md-7 col-sm-6 col-xs-4" align="right"
                                         style="margin-top:5px;margin-right: -25px;">
                                        <a href="{{ url('system/hakuser/user') }}" class="btn"><i
                                                    class="fa fa-arrow-left"></i></a>
                                    </div>

                                    <form id="data-user">
                                        {{csrf_field()}}
                                        <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg"
                                             style="padding-bottom: 10px;padding-top: 20px;margin-bottom: 15px;">

                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                <label class="tebal">Username
                                                    <font color="red">*</font>
                                                </label>
                                            </div>

                                            <div class="col-md-3 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <input id="m_id" type="hidden" class="form-control input-sm" name="m_id"
                                                           value="{{$mem->m_id}}">
                                                    <input type="text" class="form-control input-sm" name="Username"
                                                           value="{{$mem->m_username}}">
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                <label class="tebal">Password Baru</label>
                                            </div>

                                            <div class="col-md-3 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-sm"
                                                           name="PassBaru" placeholder="Abaikan bila tidak Merubah">
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                <label class="tebal">Nama Lengkap
                                                    <font color="red">*</font>
                                                </label>
                                            </div>

                                            <div class="col-md-3 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-sm" name="NamaLengkap"
                                                           value="{{$mem->m_name}}">
                                                    <input type="hidden" name="IdPegawai" class="form-control input-sm" value="{{$mem->m_pegawai_id}}">
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                <label class="tebal">Password Lama</label>
                                            </div>

                                            <div class="col-md-3 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-sm" name="PassLama" disabled>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-4 col-xs-12">

                                                <label class="tebal">Tanggal Lahir
                                                    <font color="red">*</font>
                                                </label>
                                            </div>

                                            <div class="col-md-3 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <input class="form-control input-sm" type="text" name="TanggalLahir"
                                                        value="{{$mem->c_lahir}}" readonly>
                                                </div>

                                            </div>

                                            <div class="col-md-3 col-sm-4 col-xs-12">

                                                <label class="tebal">Jabatan/Posisi
                                                    <font color="red">*</font>
                                                </label>
                                            </div>
                                            <div class="col-md-3 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <input class="form-control input-sm" type="text" name="pp_jabatan" id="pp_jabatan"
                                                        value="{{$posisi->c_posisi}}" readonly>
                                                    <input type="hidden" class="form-control input-sm" name="id_jabatan" id="id_jabatan" 
                                                        value="{{$posisi->c_jabatan_id}}">
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                <label class="tebal">Alamat
                                                    <font color="red">*</font>
                                                </label>
                                            </div>

                                            <div class="col-md-9 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <textarea name="alamat" class="form-control" readonly>{{$mem->m_addr}}</textarea>
                                                </div>
                                            </div>

                                            <div align="right" style="padding-top:10px;">
                                                <div id="div_button_save" class="form-group">
                                                    <button type="button" id="button_save" class="btn btn-primary" onclick="perbaruiDataUser()">Simpan Data
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
    
                                        <div class="col-md-12" id="detail" style="display: ;">
                                            <label class="tebal">- Hak Akses User</label>

                                            <div class="table-responsive">

                                                <table class="table tabelan table-bordered table-hover"
                                                       id="data-detail">
                                                    <thead>
                                                    <tr>
                                                        <th>Nama Menu</th>
                                                        <th>Lihat</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $nomor=1;
                                                        @endphp

                                                        @foreach($mem_access as $index => $data)

                                                            @if($data->a_parrent == 0)
                                                                <tr style="background: #f7e8e8">
                                                                    <td>
                                                                        <input type="hidden" name="id_access[]"
                                                                               value="{{$data->a_id}}">
                                                                        {{$nomor}}. &nbsp;
                                                                        <strong>{{$data->a_name}}</strong>
                                                                    </td>
                                                                    <td>
                                                                        @if($data->ma_read=='Y') 
                                                                            <input type="hidden" value="Y" class="checkbox"
                                                                                name="view[]" id="view-{{$data->a_id}}">
                                                                            <input type="checkbox" class="checkbox"
                                                                               onchange="simpanView('{{$data->a_id}}')"
                                                                               id="view1-{{$data->a_id}}" checked>
                                                                        @else
                                                                            <input type="hidden" value="N" class="checkbox"
                                                                                name="view[]" id="view-{{$data->a_id}}">
                                                                            <input type="checkbox" class="checkbox"
                                                                               onchange="simpanView('{{$data->a_id}}')"
                                                                               id="view1-{{$data->a_id}}">
                                                                        @endif
                                                                    </td>
                                                                    @php
                                                                        $nomor++;
                                                                    @endphp
                                                                </tr>
                                                            @else
                                                                <tr>
                                                                    <td>
                                                                        <input type="hidden" name="id_access[]"
                                                                               value="{{$data->a_id}}">
                                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$data->a_name}}
                                                                    </td>
                                                                    <td>
                                                                        @if($data->ma_read=='Y') 
                                                                            <input type="hidden" value="Y" class="checkbox"
                                                                                name="view[]" id="view-{{$data->a_id}}">
                                                                            <input type="checkbox" class="checkbox"
                                                                               onchange="simpanView('{{$data->a_id}}')"
                                                                               id="view1-{{$data->a_id}}" checked>
                                                                        @else
                                                                            <input type="hidden" value="N" class="checkbox"
                                                                                name="view[]" id="view-{{$data->a_id}}">
                                                                            <input type="checkbox" class="checkbox"
                                                                               onchange="simpanView('{{$data->a_id}}')"
                                                                               id="view1-{{$data->a_id}}">
                                                                        @endif
                                                                    </td>
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
<!-- END PAGE WRAPPER -->
@endsection
@section("extra_scripts")
    <script type="text/javascript">
        function perbaruiDataUser() {
            var m_id = $('#m_id').val();
            $.ajax({
                url: baseUrl + '/system/hakuser/perbarui-user/' + m_id,
                type: 'post',
                timeout: 10000,
                data: $('#data-user').serialize(),
                dataType: 'json',
                success: function (response) {
                    if(response.status == "sukses")
                    {
                      iziToast.success({
                        position: 'center',
                        title: 'Pemberitahuan',
                        message: response.pesan,
                        onClosing: function(instance, toast, closedBy){
                           window.location = baseUrl + '/system/hakuser/user';
                        }
                      });
                    }
                    else
                    {
                      iziToast.error({
                        position: 'center',
                        title: 'Pemberitahuan',
                        message: response.pesan,
                        onClosing: function(instance, toast, closedBy){
                           window.location = baseUrl + '/system/hakuser/user';
                        }
                      });
                    }
                },
                error: function(){
                    iziToast.error({
                        position: 'topRight',
                        title: 'Pemberitahuan',
                        message: "Data gagal disimpan !"
                    });
                }
            });
        }

        function simpanView(id) {
            $('#status-' + id).val(1);

            if ($('#view1-' + id).prop('checked')) {
                $('#view-' + id).val('Y')
            } else {
                $('#view-' + id).val('N')
            }
        }

        function simpanInsert(id) {
            $('#status-' + id).val(1);
            if ($('#insert1-' + id).prop('checked')) {
                $('#insert-' + id).val('Y')
            } else {
                $('#insert-' + id).val('N')
            }
        }

        function simpanUpdate(id) {
            $('#status-' + id).val(1);
            if ($('#update1-' + id).prop('checked')) {
                $('#update-' + id).val('Y')
            } else {
                $('#update-' + id).val('N')
            }
        }

        function simpanDelete(id) {
            $('#status-' + id).val(1);
            if ($('#delete1-' + id).prop('checked')) {
                $('#delete-' + id).val('Y')
            } else {
                $('#delete-' + id).val('N')
            }
        }

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

        $("#perusahaan").load("/master/datasuplier/tambah_suplier", function () {
            $("#perusahaan").focus();
        });

        $('input[name="PassBaru"]').keyup(function(event) {
            var str = $(this).val();
            if(str.trim() != '')
            {
                $('input[name="PassLama"]').attr('disabled', false);
            }else{
                $('input[name="PassLama"]').val('').attr('disabled', true);
            }
        });
    </script>
@endsection                            
