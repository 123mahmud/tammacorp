@extends('main')
@section('content')
    <!--BEGIN PAGE WRAPPER-->
    <div id="page-wrapper">
        <!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
            <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                <div class="page-title">Manajemen Produksi</div>
            </div>

            <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i
                            class="fa fa-angle-right"></i>&nbsp;&nbsp;
                </li>
                <li><i></i>&nbsp;Produksi&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                <li class="active">Manajemen Produksi</li>
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
                            <li class="active"><a href="#index-tab" data-toggle="tab" onclick="cariTanggal()">Manajemen
                                    SPK</a></li>
                            <li><a href="#finishResult-tab" data-toggle="tab" onclick="cariTanggal2()">Daftar SPK
                                    Selesai</a></li>
                        </ul>

                        <div id="generalTabContent" class="tab-content responsive">

                        @include('produksi.spk.formula-tab')
                        <!-- /div index-tab -->
                        @include('produksi.spk.index-tab')
                        <!-- /div index-tab -->
                        @include('produksi.spk.inputdata-tab')
                        <!-- div finishResult-tab -->
                        @include('produksi.spk.finish-result-tab')
                        <!-- End DIv finishResult-tab -->

                        </div>

                    </div>
                </div>
            </div>


            @endsection
            @section("extra_scripts")
                <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
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

                        cariTanggal();

                        $('#myModalView').on('shown.bs.modal', function () {
                            total();
                        }) 
                    });


                    var date = new Date();
                    var newdateIndex = new Date(date);
                    var newdate = new Date(date);

                    newdateIndex.setDate(newdate.getDate() - 30);
                    newdate.setDate(newdate.getDate() - 3);

                    var ndi = new Date(newdateIndex);
                    var nd = new Date(newdate);

                    $('.datepicker').datepicker({
                        autoclose: true,
                        format: "dd-mm-yyyy",
                        endDate: 'today'
                    }).datepicker("setDate", ndi);

                    $('.datepicker1').datepicker({
                        autoclose: true,
                        format: "dd-mm-yyyy",
                        endDate: 'today'
                    }).datepicker("setDate", nd);

                    $('.datepicker2').datepicker({
                        autoclose: true,
                        format: "dd-mm-yyyy",
                        endDate: 'today'
                    });

                    function cariTanggal() {
                        var tgl1 = $('#tanggal1').val();
                        var tgl2 = $('#tanggal2').val();
                        var indexTable = $('#data1').DataTable({
                            "destroy": true,
                            "processing": true,
                            "serverside": true,
                            "ajax": {
                                url: baseUrl + "/produksi/spk/get_spk_by_tgl/" + tgl1 + '/' + tgl2,
                                type: 'GET'
                            },
                            "columns": [
                                {"data": "DT_Row_Index", orderable: true, searchable: false, "width": "5%"},
                                {"data": 'spk_date', name: 'spk_date', "width": "10%"},
                                {"data": 'spk_code', name: 'spk_code', "width": "10%"},
                                {"data": 'i_name', name: 'i_name', "width": "25%"},
                                {"data": 'pp_qty', name: 'pp_qty', "width": "5%", "className": "right"},
                                {"data": 'produksi', name: 'produksi', "width": "5%", "className": "right"},
                                {"data": "status", "width": "10%"},
                                {"data": "action", orderable: false, searchable: false, "width": "10%"},
                            ],
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

                    function cariTanggal2() {
                        var tgl1 = $('#tanggal3').val();
                        var tgl2 = $('#tanggal4').val();
                        var finishTable = $('#data3').DataTable({
                            "destroy": true,
                            "processing": true,
                            "serverside": true,
                            "ajax": {
                                url: baseUrl + "/produksi/spk/get_spk_by_tglCL/" + tgl1 + '/' + tgl2,
                                type: 'GET'
                            },
                            "columns": [
                                {"data": "DT_Row_Index", orderable: true, searchable: false, "width": "5%"},
                                {"data": 'spk_date', name: 'spk_date', "width": "10%"},
                                {"data": 'spk_code', name: 'spk_code', "width": "10%"},
                                {"data": 'i_name', name: 'i_name', "width": "25%"},
                                {"data": 'pp_qty', name: 'pp_qty', "width": "5%", "className": "right"},
                                {"data": 'produksi', name: 'produksi', "width": "5%", "className": "right"},
                                {"data": "status", "width": "10%"},
                                {"data": "action", orderable: false, searchable: false, "width": "10%"},
                            ],
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

                    function ubahStatus(id) {
                        iziToast.show({
                          color: 'red',
                          title: 'Peringatan',
                          message: 'yakin ingin merubah status SPK!',
                          position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                          progressBarColor: 'rgb(0, 255, 184)',
                          buttons: [
                            [
                              '<button>Ok</button>',
                              function (instance, toast) {
                                instance.hide({
                                  transitionOut: 'fadeOutUp'
                                }, toast);
                                                // ajax delete data to database
                            $.ajax({
                                url: baseUrl + "/produksi/spk/ubah-status-spk/" + id,
                                type: "get",
                                dataType: "JSON",
                                success: function (response) {
                                    $('#myModalView').modal('hide');
                                    if (response.status == "sukses") {
                                        refreshTabel();
                                    }else if(response.status == 'gagal'){
                                        alert(response.pesan);
                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    alert('Error updating data');
                                }
                            });
                            }
                            ],
                            [
                              '<button>Close</button>',
                               function (instance, toast) {
                                instance.hide({
                                  transitionOut: 'fadeOutUp'
                                }, toast);
                              }
                            ]
                          ]
                        });
                        
                    }

                    function refreshTabel() {
                        $('#data1').DataTable().ajax.reload();
                    }

                    function detailManSpk(id) {

                        $.ajax({
                            url: baseUrl + "/produksi/spk/lihat-detail/",
                            type: "get",
                            data: {x: id},
                            success: function (response) {
                                $('#view-formula').html(response);
                            }
                        })

                    }

                    function inputData(id) {
                        $.ajax({
                            url: baseUrl + "/produksi/spk/input-data/",
                            type: "get",
                            data: {x: id},
                            success: function (response) {
                                $('#view-actual').html(response);
                            }
                        })
                    }

                    function saveActual(id) {
                        var myForm = $('#myFormActual').serialize();
                        $.ajax({
                            url: baseUrl + "/produksi/o_produksi/save/actual/" + id,
                            type: "get",
                            data: myForm,
                            success: function (response) {
                                if (response.status == 'sukses') {
                                    $('#myModalActual').modal('hide');
                                    iziToast.success({
                                        timeout: 5000,
                                        position: "topRight",
                                        icon: 'fa fa-chrome',
                                        title: '',
                                        message: 'Data actual tersimpan.'
                                    });
                                } else {
                                    iziToast.error({
                                        position: "topRight",
                                        title: '',
                                        message: 'Data actual gagal tersimpan.'
                                    });
                                }
                            }
                        })
                    }

                    function total(inField, e)
                    {
                        $('.siapProses').removeAttr('disabled','disabled');
                        var a = 0;
                        $('input.cekSisa:text').each(function(evt){
                            var getIndex = a;
                            var dataValue = $('input.cekSisa:text:eq('+getIndex+')').val();
                            dataValue = parseFloat(dataValue).toFixed(2);
                            var hasil = dataValue;      
                            hasil = parseFloat(hasil).toFixed(2);
                            if (hasil < 0.00) {
                                $('.siapProses').attr('disabled','disabled');
                            }
                            a++;
                        })
                    }
                    

                </script>
@endsection()