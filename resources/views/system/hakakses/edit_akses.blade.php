@extends('main')
@section('content')
    <!--BEGIN PAGE WRAPPER-->
    <div id="page-wrapper">
        <!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
            <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                <div class="page-title">Form Manajemen Hak Akses</div>
            </div>
            <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i
                            class="fa fa-angle-right"></i>&nbsp;&nbsp;
                </li>
                <li><i></i>&nbsp;System&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                <li class="active">Manajemen Hak Akses</li>
                <li><i class="fa fa-angle-right"></i>&nbsp;Form Manajemen Hak Akses&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
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
                            <li class="active"><a href="#alert-tab" data-toggle="tab">Form Manajemen Hak Akses</a></li>
                            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                        </ul>
                        <div id="generalTabContent" class="tab-content responsive">
                            <div id="alert-tab" class="tab-pane fade in active">
                                <div class="row">

                                    <div class="col-md-12 col-sm-12 col-xs-12"
                                         style="margin-top: -10px;margin-bottom: 15px;">
                                        <div class="col-md-5 col-sm-6 col-xs-8">
                                            <h4>Form Manajemen Hak Akses</h4>
                                        </div>
                                        <div class="col-md-7 col-sm-6 col-xs-4" align="right"
                                             style="margin-top:5px;margin-right: -25px;">
                                            <a href="{{ url('system/hakakses/akses') }}" class="btn"><i
                                                        class="fa fa-arrow-left"></i></a>
                                        </div>


                                        <form method="POST">

                                            <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg"
                                                 style="padding-bottom: 5px;padding-top: 20px;margin-bottom: 15px;">

                                                <div class="col-md-2 col-sm-4 col-xs-12">
                                                    <label class="tebal">Nama Group</label>
                                                </div>

                                                <div class="col-md-3 col-sm-8 col-xs-12">
                                                    <div class="form-group">
                                                        <input id="id-group" type="hidden" class="form-control input-sm"
                                                               name="id" value="{{$group->g_id}}">
                                                        <input id="nama-group" type="text" class="form-control input-sm"
                                                               name="name"
                                                               value="{{$group->g_name}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-8 col-xs-12">
                                                    <div class="form-group">
                                                        <button type="button" id="button_save" class="btn btn-primary"
                                                                onclick="perbaruiGroup()">Perbarui Data
                                                        </button>
                                                    </div>
                                                </div>


                                            </div>


                                            <div class="table-responsive">
                                                <table class="table tabelan table-bordered table-hover"
                                                       id="data-detail">
                                                    <thead>
                                                    <tr>
                                                        <th>Nama Menu</th>
                                                        <th>Lihat</th>
                                                        <th>Tambah</th>
                                                        <th>Perbarui</th>
                                                        <th>Hapus</th>
                                                        <th>Laporan</th>
                                                        <th>Unlock</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php
                                                        $nomor=1;
                                                    @endphp

                                                    @foreach($groupAccess as $index => $data)

                                                        @if($data->a_parrent==0)
                                                            <tr style="background: #f7e8e8">
                                                                <td>
                                                                    <input type="hidden" name="id_access[]"
                                                                           value="{{$data->a_id}}">
                                                                    {{$nomor}}. &nbsp;
                                                                    <strong>{{$data->a_name}}</strong>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden"
                                                                           @if($data->ga_read=='Y')  value="Y" @else
                                                                           value="N" @endif name="view[]"
                                                                           id="view-{{$data->a_id}}">
                                                                    <input type="" class=" ds"
                                                                           onchange="simpanView('{{$data->a_id}}')"
                                                                           id="view1-{{$data->a_id}}"
                                                                           @if($data->ga_read=='Y') checked="" @endif>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" value="N" class=""
                                                                           name="insert[]" id="insert-{{$data->a_id}}">
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" value="N" class=""
                                                                           name="update[]" id="insert-{{$data->a_id}}">
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" value="N" class=""
                                                                           name="delete[]" id="insert-{{$data->a_id}}">
                                                                    <input type="hidden" name="status[]"
                                                                           id="status-{{$data->a_id}}" value="0">
                                                                </td>
                                                                <td>
                                                                </td>
                                                                <td>
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
                                                                <td class="text-center">
                                                                    <input type="" class=" ds"
                                                                           onchange="simpanView('{{$data->a_id}}')"
                                                                           id="view1-{{$data->a_id}}"
                                                                           @if($data->ga_read=='Y') checked="" @endif>

                                                                    <input type="hidden"
                                                                           @if($data->ga_read=='Y')  value="Y" @else
                                                                           value="N" @endif  name="view[]"
                                                                           id="view-{{$data->a_id}}">

                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="" class=" ds"
                                                                           onchange="simpanInsert('{{$data->a_id}}')"
                                                                           id="insert1-{{$data->a_id}}"
                                                                           @if($data->ga_insert=='Y') checked="" @endif>

                                                                    <input type="hidden"
                                                                           @if($data->ga_insert=='Y')  value="Y" @else
                                                                           value="N" @endif name="insert[]"
                                                                           id="insert-{{$data->a_id}}">
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="" class=""
                                                                           onchange="simpanUpdate('{{$data->a_id}}')"
                                                                           id="update1-{{$data->a_id}}"
                                                                           @if($data->ga_update=='Y') checked="" @endif>

                                                                    <input type="hidden"
                                                                           @if($data->ga_update=='Y')  value="Y" @else
                                                                           value="N" @endif name="update[]"
                                                                           id="update-{{$data->a_id}}">

                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="" class=" ds"
                                                                           onchange="simpanDelete('{{$data->a_id}}')"
                                                                           id="delete1-{{$data->a_id}}"
                                                                           @if($data->ga_delete=='Y') checked="" @endif>

                                                                    <input type="hidden"
                                                                           @if($data->ga_delete=='Y')  value="Y" @else
                                                                           value="N" @endif  id="delete-{{$data->a_id}}"
                                                                           name="delete[]">

                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="" class=" ds" name="laporan[]"
                                                                           onchange="simpanLaporan('{{$data->a_id}}')"
                                                                           id="laporan-{{$data->a_id}}">
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="" class=" ds" name="Unlock[]"
                                                                           onchange="simpanUnlock('{{$data->a_id}}')"
                                                                           value="1" id="Unlock-{{$data->a_id}}">
                                                                    <input type="hidden" name="status[]"
                                                                           id="status-{{$data->a_id}}" value="0">
                                                                </td>
                                                            </tr>
                                                        @endif


                                                    @endforeach
                                                    </tbody>
                                                </table>
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


                        function perbaruiGroup() {
                            var idGroup = $('#id-group').val();
                            var namaGroup = $('#nama-group').val();
                            var dataDetail = $('#data-detail :input').serialize()
                            $.ajax({
                                url: baseUrl + '/system/hakakses/perbarui_akses-group/perbarui-group/' + idGroup,
                                type: 'get',
                                timeout: 10000,
                                data: 'namaGroup=' + namaGroup + '&' + dataDetail,
                                dataType: 'json',
                                success: function (response) {
                                    if (response.status == 'sukses') {
                                        /*   window.location = baseUrl+'/system/hakakses/akses';*/
                                    }

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
                    </script>
@endsection
