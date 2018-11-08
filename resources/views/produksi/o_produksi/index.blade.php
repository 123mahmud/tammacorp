@extends('main')
@section('content')
    <link href="http://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>

    <!--BEGIN PAGE WRAPPER-->
    <div id="page-wrapper">
        <!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
            <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                <div class="page-title">Form Manajemen Output Produksi</div>
            </div>
            <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i
                            class="fa fa-angle-right"></i>&nbsp;&nbsp;
                </li>
                <li><i></i>&nbsp;Produksi&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                <li class="active">Manajemen Output Produksi</li>
                <li><i class="fa fa-angle-right"></i>&nbsp;Form Manajemen Output Produksi&nbsp;&nbsp;</i>&nbsp;&nbsp;
                </li>
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
                            <li class="active"><a href="#alert-tab" data-toggle="tab">Form Manajemen Output Produksi</a>
                            </li>
                            {{--        <li><a href="#note-hasil-produksi" data-toggle="tab">Form Hasil Produksi</a></li> --}}
                        </ul>
                        <div id="generalTabContent" class="tab-content responsive">
                            <div id="alert-tab" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12" align="right">
                                        <a href="#" data-toggle="modal" data-target="#create" class="btn btn-box-tool"
                                           style="margin-bottom: 15px;"><i class="fa fa-plus"></i>&nbsp;Tambah Hasil
                                            Produksi</a>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <form onsubmit="return false" autocomplete="off">

                                            <div class="col-md-2 col-sm-3 col-xs-12">
                                                <label class="tebal">Tanggal Persetujuan</label>
                                            </div>

                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <div class="input-daterange input-group">
                                                        <input id="tanggal1" class="form-control input-sm datepicker1"
                                                               name="tanggal" type="text">
                                                        <span class="input-group-addon">-</span>
                                                        <input id="tanggal2" class="input-sm form-control datepicker2"
                                                               name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-3 col-xs-12" align="left">
                                                <button class="btn btn-primary btn-sm btn-flat autoCari" type="button"
                                                        onclick="cariTanggal()">
                                                    <strong>
                                                        <i class="fa fa-search" aria-hidden="true"></i>
                                                    </strong>
                                                </button>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12" style="margin-bottom: 15px;"
                                                 align="right">

                                                <select name="tampilData" id="tampil_data"
                                                        class="form-control input-sm" onchange="cariTanggal()">
                                                    <option value="Semua" class="form-control">Tampilkan Data : Semua
                                                    </option>
                                                    <option value="Belum-dikirim" class="form-control">
                                                        Tampilkan Data : Belum Terkirim
                                                    </option>
                                                    <option value="Dikirim" class="form-control">Tampilkan Data :
                                                        Di kirim
                                                    </option>
                                                    <option value="Terkirim" class="form-control">Tampilkan Data :
                                                        Di Terima
                                                    </option>
                                                </select>

                                            </div>
                                            <!-- Modal -->
                                            @include('produksi.o_produksi.modal-create')
                                            
                                            <div class="panel-body">
                                                <div class="table-responsive">

                                                    <table class="table tabelan table-bordered table-striped"
                                                           id="oProduct" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>Tanggal Spk</th>
                                                            <th>Nota Spk</th>
                                                            <th>Produksi</th>
                                                            <th>Nama Item</th>
                                                            <th>Waktu Selesai</th>
                                                            <th>Jumlah</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
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

                @endsection
                @section("extra_scripts")
                    <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
                    <script src="http://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
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

                            var timepicker = new TimePicker('time', {
                                lang: 'en',
                                theme: 'dark'
                            });
                            timepicker.on('change', function (evt) {

                                var value = (evt.hour || '00') + ':' + (evt.minute || '00');
                                evt.element.value = value;

                            });

                            $('#create').on('shown.bs.modal', function () {
                                //fungsi
                            })

                            cariTanggal();
                        });



                        var date = new Date();
                        var newdate = new Date(date);

                        newdate.setDate(newdate.getDate() - 3);
                        var nd = new Date(newdate);

                        $('.datepicker').datepicker({
                            format: "mm",
                            viewMode: "months",
                            minViewMode: "months"
                        });
                        $('.datepicker1').datepicker({
                            autoclose: true,
                            format: "dd-mm-yyyy"
                        }).datepicker("setDate", nd);
                        $('.datepicker2').datepicker({
                            autoclose: true,
                            format: "dd-mm-yyyy"
                        });//.datepicker("setDate", "0");

                        function SetTanggalProduksi() {
                            var tgl1 = $('#TanggalProduksi').val();
                            $.ajax({
                                url: baseUrl + '/produksi/o_produksi/select2/spk/' + tgl1,
                                type: 'get',
                                success: function (response) {
                                    $("#ubahselect").html(response);
                                    $("#cari_spk").select2();
                                }
                            })
                        }

                        function setResultSpk() {
                            var x = document.getElementById("cari_spk").value;
                            $.ajax({
                                url: baseUrl + '/produksi/o_produksi/select2/pilihspk/' + x,
                                type: 'get',
                                success: function (response) {
                                    $('#NamaItem').val(response[0].i_name);
                                    $('#JumlahItemSpk').val(response[0].pp_qty);
                                    $('#JumlahItemHasilSpk').val(response[0].prdt_qty);
                                    $('#spk_id').val(response[0].spk_id);
                                    $('#id_item').val(response[0].i_id);
                                }
                            })
                        }

                        function maxQty() {
                            var qty_plan = parseInt($("#JumlahItemSpk").val());
                            var qty_result = parseInt($("#JumlahItemHasilSpk").val());
                            var JumlahItem = parseInt($("#JumlahItem").val());
                            var total = qty_plan - qty_result;

                            if (qty_plan < JumlahItem) {
                                $("#JumlahItem").val('');
                                toastr.warning('Jumlah Pembuatan tidak boleh melebihi rencana');
                            } else if (JumlahItem > total) {
                                $("#JumlahItem").val('');
                                toastr.warning('Jumlah Pembuatan tidak boleh melebihi rencana');
                            }
                        }

                        function simpanHasilProduct() {
                            $('.PostingHasil').attr('disabled', 'disabled');
                            var tgl = $('#TanggalHasilProduksi').val(),
                                spk_id = $('#spk_id').val(),
                                time = $('#time').val(),
                                spk_item = $("#id_item").val(),
                                spk_qty = $("#JumlahItem").val();
                            prdt_produksi = $("#prdt_produksi").val();
                            $.ajax({
                                url: baseUrl + "/produksi/o_produksi/store",
                                type: 'get',
                                data: {
                                    tgl: tgl,
                                    spk_id: spk_id,
                                    spk_item: spk_item,
                                    spk_qty: spk_qty,
                                    time: time,
                                    prdt_produksi: prdt_produksi
                                },
                                success: function (response) {
                                    if (response.status == 'sukses') {
                                        $("#JumlahItem").val('');
                                        $("#NamaItem").val('');
                                        $("#mySelect").val('');
                                        $("#time").val('');
                                        $("#spk_ref").val('');
                                        $("#JumlahItemSpk").val('');
                                        $("#TanggalProduksi").val('');
                                        oProduct.ajax.reload();
                                        iziToast.success({
                                            timeout: 5000,
                                            position: "topRight",
                                            icon: 'fa fa-chrome',
                                            title: '',
                                            message: 'Berhasil ditambahkan.'
                                        });
                                        $('.PostingHasil').removeAttr('disabled', 'disabled');
                                        $("input[name='Tanggal_Produksi']").focus();
                                    } else {
                                        iziToast.error({
                                            position: "topRight",
                                            title: '',
                                            message: 'Gagal menyimpan.'
                                        });
                                        $('.PostingHasil').removeAttr('disabled', 'disabled');
                                    }
                                }
                            })
                        }

                        function cariTanggal(){
                            $('#oProduct').dataTable().fnDestroy();
                            var tgl1 = $('#tanggal1').val();
                            var tgl2 = $('#tanggal2').val();
                            var tampil = $('#tampil_data').val();
                           $('#oProduct').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: {
                                url: baseUrl + "/produksi/o_produksi/tabel/" + tgl1 + "/" + tgl2 + "/" + tampil,
                            },
                            columns: [
                                {data: 'pr_date', name: 'pr_date'},
                                {data: 'spk_code', name: 'spk_code'},
                                {data: 'mp_name', name: 'mp_name'},
                                {data: 'i_name', name: 'i_name', orderable: false},
                                {data: 'prdt_date', name: 'prdt_date'},
                                {data: 'prdt_qty', name: 'prdt_qty', className: 'right'},
                                {data: 'prdt_status', name: 'prdt_status'},
                                {data: 'action', name: 'action'},
                            ],
                            "responsive": true,

                            "pageLength": 10,
                            "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                            "language": {
                                "searchPlaceholder": "Cari Data",
                                "emptyTable": "Tidak ada data",
                                "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
                                "sSearch": '<i class="fa fa-search"></i>',
                                "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
                                "infoEmpty": "",
                                "paginate": {
                                    "previous": "Sebelumnya",
                                    "next": "Selanjutnya",
                                }
                            }
                        });
                        }

                    </script>
@endsection()
