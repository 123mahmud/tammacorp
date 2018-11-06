@extends('main')
@section('content')
    <style type="text/css">
        .ui-autocomplete {
            z-index: 2147483647;
        }
    </style>
    <!--BEGIN PAGE WRAPPER-->
    <div id="page-wrapper">
        <!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
            @if ($ket == 'create')
                <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                    <div class="page-title">Form Entri Penjualan Grosir/Online</div>
                </div>
            @else
                <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                    <div class="page-title">Form Edit Penjualan Grosir/Online</div>
                </div>
            @endif
            <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i
                            class="fa fa-angle-right"></i>&nbsp;&nbsp;
                </li>
                <li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                <li class="active">Form Entri Penjualan Grosir/Online</li>
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
                            <li class="active"><a href="#alert-tab" data-toggle="tab">Form Penjualan</a></li>
                            <li><a href="#note-tab" data-toggle="tab" onclick="cariTanggal()">Nota Penjualan</a></li>
                            <li><a href="#label-badge-tab" data-toggle="tab" onclick="cariTanggalJual()">Item
                                    Penjualan</a></li>
                            <li><a href="#nav-stock" data-toggle="tab">Stock Grosir</a></li>
                        </ul>
                        <div id="generalTabContent" class="tab-content responsive">
                            <!-- Trigger the modal with a button -->
                            <!-- Modal -->
                            <div class="modal fade" id="myModal" role="dialog">
                                <div class="modal-dialog">

                                    <form id="save_customer">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color: #e77c38;">
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                                <h4 class="modal-title" style="color: white;">Form Master Data
                                                    Pelanggan</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg"
                                                     style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">
                                                    <div class="col-md-4 col-sm-3 col-xs-12">
                                                        <label class="tebal" name="nama_cus">Namaaaa<font
                                                                    color="red">*</font></label>
                                                    </div>
                                                    <div class="col-md-8 col-sm-9 col-xs-12">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <i class="glyphicon glyphicon-user"></i>
                                                                <input type="hidden" id="namahidden">
                                                                <input type="text" id="nama_cus" name="nama_cus"
                                                                       class="form-control input-sm">
                                                                @if ($errors->has('nama_cus'))
                                                                    <span class="help-block">
                                    <strong>{{ $errors->first('nama_cus') }}</strong>
                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-3 col-xs-12">
                                                        <label class="tebal">Tanggal Lahir</label>
                                                    </div>
                                                    <div class="col-md-8 col-sm-9 col-xs-12">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <i class="glyphicon glyphicon-calendar"></i>
                                                                <input maxlength="10" type="text" id="tgl_lahir"
                                                                       name="tgl_lahir"
                                                                       class="form-control input-sm datepicker3"
                                                                       value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-3 col-xs-12">
                                                        <label class="tebal">E-mail<font color="red">*</font></label>
                                                    </div>
                                                    <div class="col-md-8 col-sm-9 col-xs-12">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <i class="glyphicon glyphicon-envelope"></i>
                                                                <input type="email" id="email" name="email"
                                                                       class="form-control input-sm"
                                                                       value="{{ old('email') }}">
                                                                @if ($errors->has('email'))
                                                                    <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-3 col-xs-12">
                                                        <label class="tebal">Tipe Pelanggan</label>
                                                    </div>
                                                    <div class="col-md-8 col-sm-9 col-xs-12">
                                                        <div class="form-group">
                                                            <select name="tipe_cust" id="tipe_cust"
                                                                    class="form-control input-sm">
                                                                <option value="GR">Online</option>
                                                                <option value="RT">retail</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-3 col-xs-12">
                                                        <label class="tebal">Kelas Pelanggan</label>
                                                    </div>
                                                    <div class="col-md-8 col-sm-9 col-xs-12">
                                                        <div class="form-group">
                                                            <select name="class_cust" id="class_cust"
                                                                    class="form-control input-sm">
                                                                <option value="C">C</option>
                                                                <option value="B">B</option>
                                                                <option value="A">A</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-3 col-xs-12">
                                                        <label class="tebal">Nomor HP1<font color="red">*</font></label>
                                                    </div>
                                                    <div class="col-md-8 col-sm-9 col-xs-12">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"
                                                                      id="basic-addon1">+62</span>
                                                                <input type="text" id="no_hp" name="no_hp1"
                                                                       class="form-control input-sm"
                                                                       value="{{ old('no_hp') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-3 col-xs-12">
                                                        <label class="tebal">Nomor HP2</label>
                                                    </div>
                                                    <div class="col-md-8 col-sm-9 col-xs-12">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"
                                                                      id="basic-addon1">+62</span>
                                                                <input type="text" id="no_hp" name="no_hp2"
                                                                       class="form-control input-sm"
                                                                       value="{{ old('no_hp') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-3 col-xs-12">
                                                        <label class="tebal">Wilayah</label>
                                                    </div>
                                                    <div class="col-md-8 col-sm-9 col-xs-12">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <input type="text" id="c_region" name="c_region"
                                                                       class="form-control input-sm"
                                                                       value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-3 col-xs-12">
                                                        <label class="tebal">Alamat<font color="red">*</font></label>
                                                    </div>
                                                    <div class="col-md-8 col-sm-9 col-xs-12">
                                                        <div class="form-group">
                                                            <div class="input-icon right">
                                                                <i class="glyphicon glyphicon-home"></i>
                                                                <textarea id="alamat" name="alamat"
                                                                          class="form-control input-sm"
                                                                          value="{{ old('alamat') }}"></textarea>

                                                                @if ($errors->has('alamat'))
                                                                    <span class="help-block">
                                    <strong>{{ $errors->first('alamat') }}</strong>
                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">
                                                    Close
                                                </button>
                                                <button class="btn btn-danger simpanCus" type="button"
                                                        onclick="simpan()">Simpan Data
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        @if($ket == 'create')

                            <!-- div alert-tab -->
                                <div id="alert-tab" class="tab-pane fade in active">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg"
                                                 style="padding-bottom: 25px;padding-top: 5px;">
                                                <form id="save_sform">
                                                    <div class="col-md-9 col-sm-6 col-xs-12" style="margin-top: 15px;">
                                                        <label class="control-label tebal" for="nama">Nama
                                                            Pelanggan<font color="red">*</font></label>
                                                        <div class="input-group input-group-sm" style="width: 100%;"
                                                             ondblclick="document.getElementById('nama-customer').disabled=false;">
                                                            <input type="text" id="nama-customer" name="s_member"
                                                                   class="form-control" required>
                                                            <input type="hidden" id="id_cus" name="id_cus"
                                                                   class="form-control">
                                                            <span class="input-group-btn">
                              <button type="button" class="btn btn-info btn-sm btn_simpan" data-toggle="modal"
                                      data-target="#myModal">
                                  <i class="fa fa-plus"></i>
                              </button>
                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9 col-sm-6 col-xs-12" style="margin-top: 15px;">
                                                        <label class="control-label tebal" for="alamat">Alamat Pelanggan<font
                                                                    color="red">*</font></label>
                                                        <div class="input-group input-group-sm" style="width: 100%;">
                                                            <input type="text" id="alamat2" name="sm_alamat" readonly
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-top: 15px;">
                                                        <label for="tgl_faktur" class="control-label tebal">Tanggal
                                                            Faktur</label>
                                                        <div class="input-group input-group-sm" style="width: 100%;">
                                                            <input id="tgl_faktur" type="text" name="s_date"
                                                                   class="form-control" readonly="readonly"
                                                                   value="{{ date('d-m-Y') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9 col-sm-6 col-xs-12" style="margin-top: 15px;">
                                                        <label class="control-label tebal" for="alamat">Kelas Pelanggan
                                                            <font color="red">*</font>
                                                        </label>
                                                        <div class="input-group input-group-sm" style="width: 100%;">
                                                            <input type="text" id="c-class" readonly name="c-class"
                                                                   class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-6 col-xs-12" style="margin-top: 15px;">
                                                        <label class="control-label tebal" for="no_faktur">Jatuh
                                                            Tempo</label>
                                                        <div class="input-group input-group-sm" style="width: 100%;">
                                                            <input type="text" id="no_faktur" name="s_jatuh_tempo"
                                                                   class="form-control datepicker4" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div style="padding-top: 10px;padding-bottom: 10px;">

                                                @include('penjualan.POSgrosir.item')

                                            </div>
                                        </div>
                                        <form id="save_item">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="col-md-3 col-md-offset-9 col-sm-6 col-sm-offset-6 col-xs-12 tamma-bg"
                                                     style="margin-bottom: 20px; padding-bottom:5px;padding-top: 10px;">
                                                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                                                        <div class="form-group">
                                                            <label class="control-label tebal" for="penjualan">Total
                                                                Penjualan</label>
                                                            <div class="input-group input-group-sm"
                                                                 style="width: 100%;">
                                                                <input type="text" name="s_gross" readonly="true"
                                                                       id="totalMapPenjualan" class="form-control"
                                                                       style="text-align: right;" value="0">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="s_disc_percent" readonly="true" id=""
                                                               class="form-control TotDisPercent totalPercentValue"
                                                               style="text-align: right;" value="0">
                                                        <input type="hidden" name="s_disc_value" readonly="true" id=""
                                                               class="form-control TotDisValue i_priceValue totalPercentValue"
                                                               style="text-align: right;" value="0"
                                                               onkeyup="rege(event,'i_priceValue');"
                                                               onblur="setRupiah(event,'i_priceValue')"
                                                               onclick="setAwal('event','i_priceValue')">
                                                        <div class="form-group">
                                                            <label class="control-label tebal" for="discount">Total
                                                                Discount</label>
                                                            <div class="input-group input-group-sm"
                                                                 style="width: 100%;">
                                                                <input type="text" name="totalDiscount" readonly="true"
                                                                       id="Total_Discount"
                                                                       class="form-control totalPenjualan"
                                                                       style="text-align: right;" value="0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group" type="hidden">
                                                            <label class="control-label tebal"
                                                                   for="penjualan">PPN</label>
                                                            <div class="input-group input-group-sm"
                                                                 style="width: 100%;">
                                                                <input type="text" type="hidden" name="s_pajak"
                                                                       readonly="true" class="form-control"
                                                                       style="text-align: right;" value="0">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label tebal" for="discount">Total
                                                                Amount</label>
                                                            <div class="input-group input-group-sm "
                                                                 style="width: 100%;">
                                                                <input type="text" name="s_net" readonly="true"
                                                                       id="total"
                                                                       class="form-control totalAmount totalPenjualan"
                                                                       style="text-align: right;" value="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Start Modal Proses -->
                                            @include('penjualan.POSgrosir.modal_status')
                                            <!-- End Modal Proses -->
                                            <!-- Start Modal Proses -->
                                            @include('penjualan.POSgrosir.modal_progres')
                                            <!-- End Modal Proses -->
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <button style="float: left" class="btn btn-warning simpanDraft"
                                                        type="button" onclick="sal_save_draft()">Draft
                                                </button>&nbsp;&nbsp;
                                                <button class="btn btn-info simpanProgres" data-toggle="modal"
                                                        data-target="#prosesProgres" type="button">On Progress
                                                </button>
                                                <button style="float: right" class="btn btn-primary" type="button"
                                                        data-toggle="modal" data-target="#proses">Submit
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                        @else
                            @if (count($edit) == 0)
                            @else
                                @include('penjualan.POSgrosir.index_edit')
                            @endif
                        @endif
                        <!-- div note-tab -->
                            <div id="note-tab" class="tab-pane fade">
                                @include('penjualan.POSgrosir.NotaPenjualan.dt_notaJual')
                            </div>
                            <!-- End DIv note-tab -->

                            <!-- Modal Detail Nota -->
                            <div class="modal fade" id="myItem" role="dialog">
                                <div class="modal-dialog modal-lg"
                                     style="width: 90%;margin-left: auto;margin-top: 30px;">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #e77c38;">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title" style="color: white;">Nama Item</h4>

                                        </div>
                                        <div class="modal-body">
                                            <div id="detailNota">

                                            </div>
                                        </div>
                                        <div id="tombolPrint" class="modal-footer">

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- End Modal Detail Nota -->

                            <!-- Modal Detail Nota -->
                            <div class="modal fade" id="modalStatus" role="dialog">
                                <div class="modal-dialog" style="width: 300px;">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #e77c38;">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title" style="color: white;">Pilih untuk Merubah
                                                Status</h4>

                                        </div>
                                        <div class="modal-body">
                                            <div id="ubahStatusSales">

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close
                                            </button>
                                            <button type="button" class="btn btn-primary status" onclick="saveStatus()">
                                                Simpan
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- End Modal Detail Nota -->

                            <!-- div label-badge-tab -->
                            <div id="label-badge-tab" class="tab-pane fade">
                                <div class="row">
                                    <div class="panel-body">

                                        <div class="col-md-2 col-sm-3 col-xs-12">
                                            <label class="tebal">Tanggal Belanja</label>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <div class="input-daterange input-group">
                                                    <input id="tanggal3" class="form-control input-sm datepicker1"
                                                           name="tanggal"
                                                           type="text" {{-- value="{{ date('d-m-Y') }} --}}">
                                                    <span class="input-group-addon">-</span>
                                                    <input id="tanggal4" class="input-sm form-control datepicker2"
                                                           name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                                            <button class="btn btn-primary btn-sm btn-flat autoCari" type="button"
                                                    onclick="cariTanggalJual()">
                                                <strong>
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </strong>
                                            </button>
                                            <button class="btn btn-info btn-sm btn-flat" type="button">
                                                <strong>
                                                    <i class="fa fa-undo" aria-hidden="true"></i>
                                                </strong>
                                            </button>
                                        </div>

                                        <div class="table-responsive">
                                            <div id="Data_Jual">
                                                @include('/penjualan/POSgrosir/ItemPenjualan/Data_JualGrosir')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end div label-badge-tab -->

                            @include('penjualan.POSgrosir.StokGrosir.stock')
                        </div>
                    </div>
                    <!-- End div generalTab -->
                </div>
            </div>
        </div>
    </div>

@endsection
@section("extra_scripts")

    <script src="{{ asset ('assets/script/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
    @include('penjualan.POSgrosir.jquery_simpan_sales')

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
                format: "dd-mm-yyyy",
                endDate: 'today'
            }).datepicker("setDate", nd);
            $('.datepicker2').datepicker({
                autoclose: true,
                format: "dd-mm-yyyy",
                endDate: 'today'
            });//.datepicker("setDate", "0");
            $('.datepicker3').datepicker({
                autoclose: true,
                format: "dd-mm-yyyy",
                endDate: 'today'
            });//.datepicker("setDate", "0");
            var newdate7 = new Date(date);
            newdate7.setDate(newdate7.getDate() + 7);
            var nd7 = new Date(newdate7);
            $('.datepicker4').datepicker({
                autoclose: true,
                format: "dd-mm-yyyy",
                // endDate: 'today'
            }).datepicker("setDate", nd7);

            $("#nama-customer").autocomplete({
                source: baseUrl + '/penjualan/POSretail/retail/autocomplete',
                minLength: 1,
                select: function (event, ui) {
                    $("#nama-customer").attr("disabled", 'true');
                    $('#id_cus').val(ui.item.id);
                    $('#nama-customer').val(ui.item.label);
                    $('#alamat2').val(ui.item.alamat);
                    $('#c-class').val(ui.item.c_class);
                    $("input[name='item']").focus();
                }
            });

            $('#nama-customer').keypress(function (e) {
                var charCode;
                if ((e.which && e.which == 13)) {
                    charCode = e.which;
                } else if (window.event) {
                    e = window.event;
                    charCode = e.keyCode;
                }
                if ((e.which && e.which == 13)) {
                    $("#nama-customer").attr("disabled", 'true');
                    $("input[name='item']").focus();
                }
            });

            UpdateTotal();
            updateKembalian();
            dataInput();
            discpercentEdit();
            discvalueEdit();
            updateKembalianDP();

        });

        tableDetail = $('#detail-penjualan').DataTable();

        function totalPenjualan() {
            var inputs = document.getElementsByClassName('totalPenjualan'),
                hasil = [].map.call(inputs, function (input) {
                    if (input.value == '') input.value = 0;
                    return input.value;
                });

            var total = 0;
            for (var i = hasil.length - 1; i >= 0; i--) {

                hasil[i] = convertToAngka(hasil[i]);
                hasil[i] = parseInt(hasil[i]);
                total = total + hasil[i];
            }
            if (isNaN(total)) {
                total = 0;
            }
            total = convertToRupiah(total);
            $('#totalMapPenjualan').val(total);
        }

        function totalPenjualanDel() {
            var inputs = document.getElementsByClassName('totalPenjualan'),
                hasil = [].map.call(inputs, function (input) {
                    if (input.value == '') input.value = 0;
                    return input.value;
                });

            var total = 0;
            for (var i = hasil.length - 1; i >= 0; i--) {

                hasil[i] = convertToAngka(hasil[i]);
                hasil[i] = parseInt(hasil[i]);
                total = total + hasil[i];
            }
            if (isNaN(total)) {
                total = 0;
            }
            total = convertToRupiah(total);
            $('#totalMapPenjualan').val(total);
        }

        $(document).ready(function () {
            $('.autoCari').trigger('click');
        });

        function lihatDetail(idDetail) {
            $.ajax({
                url: baseUrl + "/penjualan/POSgrosir/getdata",
                type: 'GET',
                data: {x: idDetail},
                success: function (response) {
                    $('#tombolPrint').html(
                        '<div class="btn-group" style="margin-right:10px;">' +
                        '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">' +
                        '<i class="fa fa-print"></i>&nbsp;Print&nbsp;<span class="caret"></span></button>' +
                        '<ul class="dropdown-menu" role="menu" style="text-align:left;">' +
                        '<li><a target="_blank" href="' + baseUrl + '/penjualan/POSgrosir/print/' + idDetail + '"><i class="fa fa-print"></i>&nbsp;Print Faktur</a></li>' +
                        '<li><a target="_blank" href="' + baseUrl + '/penjualan/POSgrosir/print_surat_jalan/' + idDetail + '"><i class="fa fa-print"></i>&nbsp;Print Surat Jalan</a></li>' +
                        '<li><a target="_blank" href="' + baseUrl + '/penjualan/print_jangan_dibanting/' + idDetail + '"><i class="fa fa-print"></i>&nbsp;Print Jangan Di Banting</a></li>' +
                        '</ul>' +
                        '</div>' +

                        '<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>');
                    $('#detailNota').html(response);
                }
            });
        }

        // customer
        $("#nama-customer").focus(function () {
            var key = 1;
            $("#nama-customer").autocomplete({
                source: baseUrl + '/penjualan/POSretail/retail/autocomplete',
                minLength: 1,
                select: function (event, ui) {
                    $('#id_cus').val(ui.item.id);
                    $('#nama-customer').val(ui.item.label);
                    $('#alamat2').val(ui.item.alamat);
                    $('#c-class').val(ui.item.c_class);
                }
            });
            $("#alamat2").val('');
            $("#nama-customer").val('');
            $('#c-class').val('');
            $("#s_qty").val('');
            $("#qty").val('');
            $("#namaitem").val('');
            tableDetail.row().clear().draw(false);
            var inputs = document.getElementById('kode'),
                names = [].map.call(inputs, function (input) {
                    return input.value;
                });
            tamp = names;
        });

        //namaitem
        $("#namaitem").focus(function () {
            var key = 1;
            var TC = $('#c-class').val();
            $("#namaitem").autocomplete({
                source: baseUrl + '/penjualan/POSgrosir/grosir/autocompleteitem/' + TC,
                minLength: 1,
                select: function (event, ui) {
                    $('#harga').val(ui.item.harga);
                    $('#kode').val(ui.item.kode);
                    $('#detailnama').val(ui.item.nama);
                    $('#namaitem').val(ui.item.label);
                    $('#satuan').val(ui.item.satuan);
                    if (ui.item.s_qty == null) {
                        $('#s_qty').val('0');
                    } else {
                        $('#s_qty').val(ui.item.s_qty);
                    }
                    $('#qty').val(ui.item.qty);
                    $('#i-type').val(ui.item.i_type);
                    $('#qty').val('');
                    $("input[name='qty']").focus();
                }
            });
            $("#s_qty").val('');
            $("#qty").val('');
            $("#namaitem").val('');
        });

                @if ($ket == 'create')
        var index = 0;
        var tamp = [];

        function tambah() {
            var kode = $('#kode').val();
            var nama = $('#detailnama').val();
            var type = $('#i-type').val();
            var harga = SetFormRupiah($('#harga').val());
            var y = ($('#harga').val());
            var qty = parseInt($('#qty').val());
            var satuan = $('#satuan').val();
            var hasil = parseFloat(qty * y).toFixed(2);
            var x = SetFormRupiah(hasil);
            // var b = angkaDesimal(x);
            var stok = $('#s_qty').val();
            var pricevalue = 'pricevalue-' + kode + '';
            var event = 'event';
            var Hapus = '<button type="button" class="btn btn-danger hapus" onclick="hapus(this)"><i class="fa fa-trash-o"></i></button>';
            var index = tamp.indexOf(kode);

            if (index == -1) {
                tableDetail.row.add([

                    nama + '<input type="hidden" name="kode_item[]" class="kode_item kode" value="' + kode + '"><input type="hidden" name="nama_item[]" class="nama_item" value="' + nama + '"> ',

                    '<input size="30" style="text-align:right" type="number"  name="sd_qty[]" class="sd_qty form-control qty-' + kode + '" value="' + qty + '" onkeyup="UpdateHarga(\'' + kode + '\');qtyInput(\'' + type + '\',\'' + stok + '\', \'' + kode + '\');totalPenjualan()" onclick="UpdateHarga(\'' + kode + '\')" onchange="qtyInput(\'' + type + '\',\'' + stok + '\', \'' + kode + '\')"> ',

                    satuan + '<input type="hidden" name="satuan[]" class="satuan" value="' + satuan + '"> ',

                    '<input type="text" size="10" readonly style="text-align:right" name="harga_item[]" class="harga_item form-control harga-' + kode + '" value="' + harga + '"> ',

                    '<div class="input-group"><input type="text" size="11"  style="text-align:right" name="sd_disc_percent[]" class="form-control discpercent discpercent-' + kode + '" value="0" onkeyup="discpercent(this, event);autoJumValPercent()"><span class="input-group-addon">%</span></div> <input name="totalValuePercent[]" type="text" value="0" style="display:none" class="form-control totalValuePercent jumTotValuePercent totalValuePercent-' + kode + '">',

                    '<input type="text" size="10"  style="text-align:right" name="sd_disc_value[]" class="form-control discvalue hasildiscvalue pricevalue-' + kode + '" placeholder="0" onkeyup="discvalue(this, event);autoJumValValue();rege(event,\'' + pricevalue + '\')"  onblur="setRupiah(event,\'' + pricevalue + '\')" onclick="setAwal(\'' + event + '\',\'' + pricevalue + '\')"><input type="text" size="200" readonly name="totaldiscvalue[]" id="totaldiscvalue" style="display:none" class="form-control totaldiscvalue totaldiscvalue-' + kode + '" value="">',

                    '<input type="text" size="200" readonly style="text-align:right" name="hasil[]" id="hasil" class="form-control hasil hasil-' + kode + '" value="' + x + '"><input type="hidden" size="200" readonly style="text-align:right" name="" id="hasil2" class="hasil2 form-control" value="">',
                    Hapus
                ]);
                tableDetail.draw();

                index++;
                tamp.push(kode);
            } else {
                var qtyLawas = parseInt($(".qty-" + kode).val());
                $(".qty-" + kode).val(qtyLawas + qty);
                var q = parseInt(qtyLawas + qty);
                var l = parseFloat(q * y).toFixed(2);
                ;
                var k = SetFormRupiah(l);
                $(".hasil-" + kode).val(k);
                UpdateHarga(+kode)
            }

            $(function () {
                var values = $("input[name='sd_qty[]']")
                    .map(function () {
                        return $(this).val();
                    }).get();
            });

            UpdateTotal();
            UpdateSubTotal();
            autoJumValPercent();
        }

        $('#qty').keypress(function (e) {
            var charCode;
            if ((e.which && e.which == 13)) {
                charCode = e.which;
            } else if (window.event) {
                e = window.event;
                charCode = e.keyCode;
            }
            if ((e.which && e.which == 13)) {

                var isi = parseInt($('#qty').val());
                if (isNaN(isi)) {
                    return false;
                }
                var jumlah = $('#detailnama').val();
                var stok = parseInt($('#s_qty').val());
                var data1 = $('#nama-customer').val();
                var data2 = $('#c-class').val();
                var itype = $('#i-type').val();
                var c = isi > stok;
                if (itype == 'BP') {
                    if (isi == '' || jumlah == '' || data1 == '' || data2 == '') {
                        toastr.warning('Nama Customer tidak boleh kosong!');
                        return false;
                    }
                    var kode = $('#kode').val();
                    tambah();
                    qtyInput(stok, kode);
                    $("input[name='item']").val('');
                    $("input[name='s_qty']").val('');
                    $("input[name='qty']").val('');
                    $("input[name='item']").focus();
                    return false;
                } else {
                    if (isi == '' || jumlah == '' || stok == '' || data1 == '' || data2 == '' || c) {
                        toastr.warning('Pembelian Barang jual melebihi stok!');
                        return false;
                    }
                    var kode = $('#kode').val();
                    tambah();
                    qtyInput(stok, kode);
                    $("input[name='item']").val('');
                    $("input[name='s_qty']").val('');
                    $("input[name='qty']").val('');
                    $("input[name='item']").focus();
                    return false;
                }
            }
        });

        @else
        $("input[name='item']").focus();

        function tambahEdit() {
            var kode = [];
            kode [0] = $('#kode').val();
            var nama = $('#detailnama').val();
            var type = $('#i-type').val();
            var harga = SetFormRupiah($('#harga').val());
            var y = ($('#harga').val());
            var qty = parseInt($('#qty').val());
            var satuan = $('#satuan').val();
            var hasil = parseFloat(qty * y).toFixed(2);
            var x = SetFormRupiah(hasil);
            var b = angkaDesimal(x);
            var stok = $('#s_qty').val();
            var pricevalue = 'pricevalue-' + kode + '';
            var Hapus = '<button type="button" class="btn btn-danger hapus" onclick="hapus(this)"><i class="fa fa-trash-o"></i></button>';
            var inputs = document.getElementsByClassName('kode_item'),
                idItem = [].map.call(inputs, function (input) {
                    return input.value;
                });

            var res = kode.filter(function (n) {
                return !this.has(n)
            }, new Set(idItem));
            //length : menghitung array
            if (res.length != 0) {

                tableDetail.row.add([
                    nama + '<input type="hidden" name="kode_item[]" class="kode_item kode" value="' + kode + '"><input type="hidden" name="nama_item[]" class="nama_item" value="' + nama + '"> ',

                    '<input size="30" style="text-align:right" type="number"  name="sd_qty[]" class="sd_qty form-control qty-' + kode + '" value="' + qty + '" onkeyup="UpdateHarga(\'' + kode + '\');qtyInput(\'' + type + '\',\'' + stok + '\', \'' + kode + '\');totalPenjualan()" onclick="UpdateHarga(\'' + kode + '\')" onchange="qtyInput(\'' + type + '\',\'' + stok + '\', \'' + kode + '\')"> ',

                    satuan + '<input type="hidden" name="satuan[]" class="satuan" value="' + satuan + '"> ',

                    '<input type="text" size="10" readonly style="text-align:right" name="harga_item[]" class="harga_item form-control harga-' + kode + '" value="' + harga + '"> ',

                    '<div class="input-group"><input type="text" size="11"  style="text-align:right" name="sd_disc_percent[]" class="form-control discpercent discpercent-' + kode + '" value="0" onkeyup="discpercent(this, event);autoJumValPercent()"><span class="input-group-addon">%</span></div> <input name="totalValuePercent[]" type="text" value="0" style="display:none" class="form-control totalValuePercent jumTotValuePercent totalValuePercent-' + kode + '">',

                    '<input type="text" size="10"  id="discmasmoney" style="text-align:right" name="sd_disc_value[]" class="form-control discvalue hasildiscvalue pricevalue-' + kode + '" value="0" onkeyup="discvalue(this, event);autoJumValValue();rege(event,\'' + pricevalue + '\')"  onblur="setRupiah(event,\'' + pricevalue + '\')" onclick="setAwal(\'' + event + '\',\'' + pricevalue + '\')" ><input type="text" size="200" readonly name="totaldiscvalue[]" id="totaldiscvalue" style="display:none" class="form-control totaldiscvalue totaldiscvalue-' + kode + '" value="">',

                    '<input type="text" size="200" readonly style="text-align:right" name="hasil[]" id="hasil" class="form-control hasil hasil-' + kode + '" value="' + x + '"><input type="hidden" size="200" readonly style="text-align:right" name="" id="hasil2" class="hasil2 form-control" value="">',
                    Hapus

                ]);
                tableDetail.draw();
            } else {

                var qtyLawas = parseInt($(".qty-" + kode).val());
                $(".qty-" + kode).val(qtyLawas + qty);
                var q = parseInt(qtyLawas + qty);
                var l = parseFloat(q * y).toFixed(2);
                ;
                var k = SetFormRupiah(l);
                $(".hasil-" + kode).val(k);
            }

            $(function () {
                var values = $("input[name='sd_qty[]']")
                    .map(function () {
                        return $(this).val();
                    }).get();
            });

            UpdateTotal();
            UpdateSubTotal();
            autoJumValPercent();
        }

        $('#qty').keypress(function (e) {
            var charCode;
            if ((e.which && e.which == 13)) {
                charCode = e.which;
            } else if (window.event) {
                e = window.event;
                charCode = e.keyCode;
            }
            if ((e.which && e.which == 13)) {

                var isi = parseInt($('#qty').val());
                var jumlah = $('#detailnama').val();
                var stok = parseInt($('#s_qty').val());
                var data1 = $('#nama-customer').val();
                var data2 = $('#c-class').val();
                var itype = $('#i-type').val();
                var c = isi > stok;
                if (itype == 'BP') {
                    if (isi == '' || jumlah == '' || data1 == '' || data2 == '') {
                        toastr.warning('Nama Customer tidak boleh kosong!');
                        return false;
                    }
                    var kode = $('#kode').val();
                    tambahEdit();
                    qtyInput(stok, kode);
                    $("input[name='item']").val('');
                    $("input[name='s_qty']").val('');
                    $("input[name='qty']").val('');
                    $("input[name='item']").focus();
                    return false;
                } else {
                    if (isi == '' || jumlah == '' || stok == '' || data1 == '' || data2 == '' || c) {
                        toastr.warning('Pembelian Barang jual melebihi stok!');
                        return false;
                    }
                    var kode = $('#kode').val();
                    tambahEdit();
                    qtyInput(stok, kode);
                    $("input[name='item']").val('');
                    $("input[name='s_qty']").val('');
                    $("input[name='qty']").val('');
                    $("input[name='item']").focus();
                    return false;
                }
            }
        });

                @endif

        var hpercent = 0;

         function discpercent(inField, e) {
            var getIndex = $('input.discpercent:text').index(inField);
            var dataInput = $('input.discpercent:text:eq(' + getIndex + ')').val();
            if (dataInput == '' || dataInput == '0') {
                $('input.discvalue:text:eq(' + getIndex + ')').attr("readonly", false);
                // $('input.discpercent:text:eq(' + getIndex + ')').val(0);
            } else {
                $('input.discvalue:text:eq(' + getIndex + ')').attr("readonly", true);
            }
            var diskon = $('input.discpercent:text:eq(' + getIndex + ')').val();
            var harga = $('input.harga_item:text:eq(' + getIndex + ')').val();
            var qty = $('input.sd_qty:eq(' + getIndex + ')').val();
            harga = convertToAngka(harga);
            harga = parseInt(harga);
            diskon = parseInt(diskon);
            qty = parseInt(qty);
            if (isNaN(diskon)) {
                diskon = 0;
            }
            hasill = harga * qty;
            if (diskon >= 100) {
                diskon = 0;
                $('input.discpercent:text:eq(' + getIndex + ')').val(0);
            }
            hpercent = hasill * diskon / 100;
            $('input.totalValuePercent:text:eq(' + getIndex + ')').val(hpercent);
            hasill = hasill - (hasill * diskon / 100);
            hasill = convertToRupiah(hasill);
            var dispercent = $('input.hasil:text:eq(' + getIndex + ')').val(hasill);
            UpdateTotal();
            autoJumValPercent();
        }

        function discvalue(inField, e) {
            var getIndex = $('input.discvalue:text').index(inField);
            var dataInput = $('input.discvalue:text:eq(' + getIndex + ')').val();
            if (dataInput == '' || dataInput == '0') {
                $('input.discpercent:text:eq(' + getIndex + ')').attr("readonly", false);
                $('input.discvalue:text:eq(' + getIndex + ')').val(0);
            } else {
                $('input.discpercent:text:eq(' + getIndex + ')').attr("readonly", true);
            }
            var diskon = $('input.discvalue:text:eq(' + getIndex + ')').val();
            var harga = $('input.harga_item:text:eq(' + getIndex + ')').val();
            var qty = $('input.sd_qty:eq(' + getIndex + ')').val();
            var harga = $('input.harga_item:text:eq(' + getIndex + ')').val();
            harga = convertToAngka(harga);
            harga = parseInt(harga);
            diskon = parseInt(diskon);
            qty = parseInt(qty);
            if (isNaN(diskon)) {
                diskon = 0;
            }
            hasil = harga * qty;
            if (diskon > hasil) {
                diskon = 0;
                $('input.discvalue:text:eq(' + getIndex + ')').val(0);
            }
            console.log(diskon * qty);
            $('input.totaldiscvalue:text:eq(' + getIndex + ')').val(diskon * qty);
            hasil = hasil - diskon * qty;

            hasil = convertToRupiah(hasil);
            $('input.hasil:text:eq(' + getIndex + ')').val(hasil);
            UpdateTotal();
            autoJumValValue();
        }

         function autoJumValValue() {
            var inputs = document.getElementsByClassName('totaldiscvalue'),
                hasil = [].map.call(inputs, function (input) {
                    if (input.value == '') input.value = 0;
                    return input.value;
                });


            var total = 0;
            for (var i = hasil.length - 1; i >= 0; i--) {

                hasil[i] = convertToAngka(hasil[i]);
                hasil[i] = parseInt(hasil[i]);
                total = total + hasil[i];
            }
            if (isNaN(total)) {
                total = 0;
            }
            // alert(total);
            $('.TotDisValue').val(total);
            totalPercentValue();
        }

        function autoJumValPercent() {
            var inputs = document.getElementsByClassName('jumTotValuePercent'),
                hasil = [].map.call(inputs, function (input) {
                    return input.value;
                });
            var total = 0;
            for (var i = hasil.length - 1; i >= 0; i--) {
                hasil[i] = parseInt(hasil[i]);
                total = total + hasil[i];
            }
            total = convertToRupiah(total);
            $('.TotDisPercent').val(total);
            totalPercentValue();
        }

        function totalPercentValue() {
            var inputs = document.getElementsByClassName('totalPercentValue'),
                hasil = [].map.call(inputs, function (input) {
                    return input.value;
                });

            var total = 0;
            for (var i = hasil.length - 1; i >= 0; i--) {
                hasil[i] = convertToAngka(hasil[i]);
                hasil[i] = parseInt(hasil[i]);
                total = total + hasil[i];
            }
            total = convertToRupiah(total);

            $('#Total_Discount').val(total);
        }

        $('.total').keyup(function () {
            var sum = angkaDesimal($('#total').val());
            var bayar = angkaDesimal($('#bayar').val());
            var hasil = parseFloat(bayar - sum).toFixed(2);
            $('#kembalian').val(SetFormRupiah(hasil));
        });

        function UpdateTotal() {
            var inputs = document.getElementsByClassName('hasil'),
                hasil = [].map.call(inputs, function (input) {
                    return input.value;
                });
            var total = 0;

            for (var i = hasil.length - 1; i >= 0; i--) {
                hasil[i] = convertToAngka(hasil[i]);
                hasil[i] = parseInt(hasil[i]);
                total = total + hasil[i];
            }
            total = convertToRupiah(total);
            $('#total').val(total);
            $('#totalPayment').val(total);
            $('#totalPaymentDp').val(total);
        }

        function UpdateSubTotal() {
            var x = angkaDesimal($('#Total_Discount').val());
            var y = angkaDesimal($('.totalAmount').val());
            x = parseFloat(x);
            y = parseFloat(y);
            var jumlahsub = x + y;
            jumlahsub = convertToRupiah(jumlahsub);
            $('#totalMapPenjualan').val(jumlahsub);
        }

        function hapus(a) {
            var par = a.parentNode.parentNode;
            tableDetail.row(par).remove().draw(false);

            var sum = 0;
            $('.hasil').each(function () {
                sum += Number($(this).val());
            });
            $('#total').val(sum);

            var inputs = document.getElementsByClassName('kode'),
                names = [].map.call(inputs, function (input) {
                    return input.value;
                });
            tamp = names;
            UpdateTotal();
            autoJumValValue();
            totalPenjualanDel();
            autoJumValPercent();
            totalPenjualan();
        }

        function UpdateHarga(kode) {
            var qty = $('.qty-' + kode).val();
            var harga = $('.harga-' + kode).val();
            var hasil = convertToAngka(harga);
            hasil = hasil * qty;
            var hasilRp = convertToRupiah(hasil);
            $('.hasil-' + kode).val(hasilRp);
            $('.pricevalue-' + kode).val('0');
            $('.discpercent-' + kode).val('');
            $('.totalValuePercent-' + kode).val('0');
            $('.totaldiscvalue-' + kode).val('0');
            autoJumValPercent();
            UpdateTotal();
            autoJumValValue();
            totalPercentValue();
            totalPenjualan();
            dataInput();
        }

        function qtyInput(type, stok, kode) {
            if (type == 'BJ') {
                input = $('.qty-' + kode).val();
                input = parseInt(input);
                stok = parseInt(stok);
                if (input > stok || input < 1) {
                    toastr.warning('Pembelian melebihi stok!');
                    $('.qty-' + kode).val(0);
                }
                UpdateHarga(kode);
            }
        }

        //request
        $("#rnamaitem").autocomplete({
            source: baseUrl + '/penjualan/POSretail/retail/autocompletereq',
            minLength: 1,
            select: function (event, ui) {
                $('#rnamaitem').val(ui.item.label);
                $('#rharga').val(ui.item.harga);
                $('#rkode').val(ui.item.kode);
                $('#rdetailnama').val(ui.item.nama);
                $('#rsatuan').val(ui.item.satuan);
                $('#rstok').val(ui.item.stok);

                $('#rqty').val(ui.item.qty);
            }
        });

        var rindex = 0;
        var rtamp = [];

        function tambahreq() {
            var kode = $('#rkode').val();
            var nama = $('#rdetailnama').val();
            var satuan = $('#rsatuan').val();
            var qty = $('#rqty').val();
            var stok = $('#rstok').val();
            var Hapus = '<button type="button" class="btn btn-danger hapus" onclick="rhapus(this)"><i class="fa fa-trash-o"></i></button>';
            var rindex = rtamp.indexOf(kode);


            if (rindex == -1) {
                tableReq.row.add([
                    kode + '<input type="hidden" name="kode_item[]" class="kode_item" value="' + kode + '"> ',
                    nama + '<input type="hidden" name="nama_item[]" class="nama_item" value="' + nama + '"> ',
                    '<input size="30" style="text-align:right" type="text"  name="sd_qty[]" class="sd_qty form-control" value="' + qty + '"> ',
                    satuan + '<input type="hidden" name="satuan[]" class="satuan" value="' + satuan + '"> ',
                    '',
                    Hapus
                ]);

                tableReq.draw();
                rindex++;
                rtamp.push(kode);
            } else {
                toastr.warning('item sudah ada');
            }
        }

        function rhapus(a) {
            var par = a.parentNode.parentNode;
            tableReq.row(par).remove().draw(false);
        }

        function convertToRupiah(angka) {
            var rupiah = '';
            var angkarev = angka.toString().split('').reverse().join('');
            for (var i = 0; i < angkarev.length; i++) if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
            var hasil = 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
            return hasil + ',00';
        }

        function convertToAngka(rupiah) {
            return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
        }


        $(document).on('click', '#c .pagination a', function (event) {
            $('#loading').css('display', '')
            $('li').removeClass('active');
            $(this).parent('li').addClass('active');
            event.preventDefault();
            var myurl = $(this).attr('href');
            var page = $(this).attr('href').split('page=')[1];
            getData(page);

        });


        //thoriq

        // paginate stock

        function getData(page) {

            $.ajax(
                {
                    url: baseUrl + '/penjualan/POSgrosir/stock/table-stock?page=' + page,
                    type: "get",
                    datatype: "html",

                })
                .done(function (data) {
                    $("#table-stock").html(data);
                    $('#loading').css('display', 'none')

                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    $('#loading').css('display', 'none')
                });

        }

        //paginate stock selesai

        //total kembalian final
        var hasil = 0;
        // $('.simpanFinal').attr('disabled', 'disabled');

        function updateKembalian() {
            var inputs = document.getElementsByClassName('totPayment'),
                hasil = [].map.call(inputs, function (input) {
                    return input.value;
                });
            var total = 0;
            for (var i = hasil.length - 1; i >= 0; i--) {
                hasil[i] = convertToAngka(hasil[i]);
                hasil[i] = parseInt(hasil[i]);
                total = total + hasil[i];
            }
            if (isNaN(total)) {
                total = 0;
            }
            total = convertToRupiah(total);
            // alert(total);
            $('#totPembayaran').val(total);
            var sum = angkaDesimal($('#totPembayaran').val());
            var bayar = angkaDesimal($('#totalPayment').val());
            var hasil = parseInt(sum - bayar).toFixed(2);
            if (hasil <= 0) {
                diskon = 0;
            }
            $('#kembalian').val(SetFormRupiah(hasil));

            if (hasil < 0) {
                $('#kembalian').css('background-color', 'red');
                // $('.simpanFinal').attr('disabled', 'disabled');
            } else {
                $('#kembalian').css('background-color', 'yellow');
                // $('.simpanFinal').removeAttr('disabled', 'disabled');
            }
        }

        function updateKembalianDP() {
            var inputs = document.getElementsByClassName('totPaymentDP'),
                hasil = [].map.call(inputs, function (input) {
                    return input.value;
                });
            var total = 0;
            for (var i = hasil.length - 1; i >= 0; i--) {
                hasil[i] = convertToAngka(hasil[i]);
                hasil[i] = parseInt(hasil[i]);
                total = total + hasil[i];
            }
            if (isNaN(total)) {
                total = 0;
            }
            total = convertToRupiah(total);
            // alert(total);
            $('#totPembayaranDP').val(total);
            var sum = angkaDesimal($('#totalPaymentDp').val());
            var bayar = angkaDesimal($('.totPaymentDP').val());
            var hasil = parseInt(bayar - sum).toFixed(2);
            console.log(hasil);
            if (hasil <= 0) {
                diskon = 0;
            }
            $('#kembalianDP').val(SetFormRupiah(hasil));
            if (hasil < 0) {
                $('#kembalianDP').css('background-color', 'red');
            } else {
                $('#kembalianDP').css('background-color', 'yellow');
            }
        }

        UpdateTotalPayment();

        function UpdateTotalPayment() {
            var inputs = document.getElementsByClassName('bandingPayment'),
                hasil = [].map.call(inputs, function (input) {
                    return input.value;
                });
            // console.log(hasil);
            var total = 0;

            for (var i = hasil.length - 1; i >= 0; i--) {
                hasil[i] = convertToAngka(hasil[i]);
                hasil[i] = parseInt(hasil[i]);
                total = total + hasil[i];
                if (isNaN(total)) {
                    total = 0;
                }
            }
            // console.log(total);
            total = convertToRupiah(total);
            $('#totPembayaran').val(total);
        }

        //var random
        function guid() {
            function s4() {
                return Math.floor((1 + Math.random()) * 0x10000)
                    .toString(16)
                    .substring(1);
            }

            return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
        }

        var dataPayment = 0;

        function tambahPayment() {
            var td = [], select = [];
            var table = document.getElementById('tablePayment');
            var tr = table.getElementsByTagName('tr');
            for (var i = 0; i < tr.length; i++) {
                td[i] = tr[i].getElementsByTagName('td')[0];
                select[i] = td[i].getElementsByTagName('select')[0];
            }
            var data = 'data0=';
            for (var i = 0; i < select.length; i++) {
                data += select[i].value + '&';
                data += 'data' + (i + 1) + '=';
            }
            data += '&length=' + select.length;


            $.ajax({
                url: baseUrl + "/pembayaran/POSgrosir/pay-methode",
                type: 'get',
                data: data,
                dataType: 'json',
                success: function (dataPayment) {
                    guid();
                    UpdateTotalPayment();
                    var i = 0;
                    $html = '<tr><td><select name="sp_method[]" id="sp_method" class="form-control">';
                    for (i; i < dataPayment.length; i++) {
                        //if(dataPayment[i].pm_id != except){
                        var isi = dataPayment[i]['pm_name'];
                        var isi2 = dataPayment[i]['pm_id'];
                        $html += '<option value=' + isi2 + '>' + isi + '</option>';
                        //}
                    }

                    var uuid = guid();
                    var event = 'event';
                    var Rp = 'rupiah-' + uuid + '';
                    var spm = "'#sp_method'";
                    $html += '</select></td><td><input type="text" name="sp_nominal[]" id="" value="" class="form-control bandingPayment totPayment rupiah-' + uuid + '" autocomplete="off" onkeyup="updateKembalian();rege(event,\'' + Rp + '\')" style="text-align: right;" onblur="setRupiah(event,\'' + Rp + '\')" onclick="setAwal(\'' + event + '\',\'' + Rp + '\')"></td> <td><button type="button" class="btn btn-info" onclick="tambahPayment()"><i class="glyphicon glyphicon-plus"></i></button> <button type="button" class="btn btn-danger hapus" onclick="hapusPayment(this)"><i class="glyphicon glyphicon-minus"></i></button></td></tr>';
                    $(".mc").append($html);
                }
            });


        }

        function hapusPayment(a) {
            var par = a.parentNode.parentNode;
            $(par).remove();
            updateKembalian();
            UpdateTotalPayment();
        }

        //js rupiah

        function rege(evt, data) {
            var hitungKoma = 0;
            var uang = $('.' + data).val();

            var code = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);

            for (m = 0; m < uang.length; m++) {
//            if ((uang.charAt(0)) == '-') {
//
//            }
                if ((uang.charAt(m)) == ',') {
                    hitungKoma++;
                }
                if (hitungKoma == 1 || hitungKoma == 0) {
                    if (code == 37 || code == 39 || code == 16 || code == 36 && code == 8
                        && code >= 48 || code <= 57) {

                    } else {

                        uang = $('.' + data).val().replace(/[^0-9,-]*/g, '');
                        $('.' + data).val(uang);


                    }

                } else if (hitungKoma > 1) {
                    toastr.warning('Harap perikasa kembali inputan anda');
                    var $notifyContainer = $('#toast-container').closest('.toast-top-center');
                    if ($notifyContainer) {
                        // align center
                        var windowHeight = $(window).height() - 90;
                        $notifyContainer.css("margin-top", windowHeight / 2);
                    }
                    return false;

                }
            }
        }

        //
        function setRupiah(evt, nilai) {
            $minus = 0;
            var code = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
            var uangDe;
            if (code != 37 && code != 39 && code != 16 && code != 36 && code != 8)
                var uang = $('.' + nilai).val().replace(/[^0-9,-]*/g, '');
            $('.' + nilai).val(uang);
            var hitungKoma = 0;
            var pisah = new Array();
            var chekArray;
            for (o = 0; o < uang.length; o++) {
                if ((uang.charAt(0)) == '-' && uang.length > 1) {
                    $minus = 1;
                    uang = uang.replace(/[^0-9,]*/g, '');


                }

                else if ((uang.charAt(0)) == '-' && uang.length == 1) {
                    uang.replace(/[^0-9,]*/g, '');
                    uang = '';
                }
                if ((uang.charAt(o)) == ',') {
                    hitungKoma++;
                    if (hitungKoma == 1) {
                        uangDe = parseFloat(uang.replace(',', '.')).toFixed(2);
                        uang = uangDe.replace('.', ',');
                        chekArray = uang.split(',');

                    } else if (hitungKoma > 1) {
                        toastr.warning('Harap perikasa kembali inputan anda');
                        var $notifyContainer = $('#toast-container').closest('.toast-top-center');
                        if ($notifyContainer) {
// align center
                            var windowHeight = $(window).height() - 90;
                            $notifyContainer.css("margin-top", windowHeight / 2);
                        }
                        return false;
                    }
                }

            }
            if ($.isArray(chekArray)) {

                var rev = parseInt(chekArray[0], 10).toString().split('').reverse().join('');
                var rev2 = '';
                for (var l = 0; l < rev.length; l++) {
                    rev2 += rev[l];
                    if ((l + 1) % 3 === 0 && l !== (rev.length - 1)) {
                        rev2 += '.';
                    }
                }
                if (chekArray[1] == '' && $minus == 0) {
                    $('.' + nilai).val('Rp. ' + rev2.split('').reverse().join('') + ',' + '00');
                }
                if (chekArray[1] == '' && $minus > 0) {
                    $('.' + nilai).val('Rp. -' + rev2.split('').reverse().join('') + ',' + '00');
                }
                if (chekArray[1] != '' && $minus == 0) {
                    $('.' + nilai).val('Rp. ' + rev2.split('').reverse().join('') + ',' + chekArray[1]);
                }
                if (chekArray[1] != '' && $minus > 0) {
                    $('.' + nilai).val('Rp. -' + rev2.split('').reverse().join('') + ',' + chekArray[1]);
                }
//            else{
//                $('.' + nilai).val('Rp. ' + rev2.split('').reverse().join('') + ',' +chekArray[1]);
//            }
            } else {
                var rev = parseInt(uang, 10).toString().split('').reverse().join('');
                var rev2 = '';
                for (var u = 0; u < rev.length; u++) {
                    rev2 += rev[u];
                    if ((u + 1) % 3 === 0 && u !== (rev.length - 1)) {
                        rev2 += '.';
                    }
                }
                if ($minus == 0) {
                    $('.' + nilai).val('Rp. ' + rev2.split('').reverse().join('') + ',' + '00');
                }
                if ($minus > 0) {
                    $('.' + nilai).val('Rp. -' + rev2.split('').reverse().join('') + ',' + '00');
                }
                if (uang == '' || uang == '0') {
                    $('.' + nilai).val('');
                }
            }
        }

        function setAwal(evt, nilai) {
            var code = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
            if (code != 37 || code != 39 || code != 16 || code != 36 || code != 8)
                var uang = $('.' + nilai).val().replace(/[^0-9,-]*/g, '');

            var array = uang.split(',');

            if (array[1] == '00') {
                $('.' + nilai).val(array[0]);
            } else {
                $('.' + nilai).val(uang);
            }
        }

        //end js rupiah

        //fungsi barcode
        function uniKeyCode(event) {
            var code = $('#namaitem').val();
            $.ajax({
                url: baseUrl + "/penjualan/POSgrosir/setbarcode",
                type: 'get',
                data: {code: code},
                success: function (response) {
                    if (response.length == 1) {
                        $('#namaitem').val(response[0].i_code + ' - ' + response[0].i_name);
                        $("input[name='qty']").focus();
                        $('#qty').val(1);
                        $('#kode').val(response[0].i_code);
                        $('#harga').val(response[0].m_psell);
                        $('#detailnama').val(response[0].i_name);
                        $('#satuan').val(response[0].i_sat1);
                        $('#s_qty').val(response[0].s_qty);
                    }
                }
            })
        }

        function saveStatus() {
            $('.status').attr('disabled', 'disabled');
            var id = $('#idSales').val();
            var status = $('#setStatus').val();
            var oldStatus = $('#oldStatus').val();
            var a = $('#resi').val();
            $.ajax({
                url: baseUrl + '/pembayaran/POSgrosir/changestatus',
                type: 'get',
                timeout: 10000,
                data: {id: id, status: status, oldStatus: oldStatus, resi : a},
                success: function (response) {
                    if (response.status == 'sukses') {
                        cariTanggal();
                        iziToast.success({
                            timeout: 5000,
                            position: "topRight",
                            icon: 'fa fa-chrome',
                            title: '',
                            message: 'Status berhasil di update.'
                        });
                        $('#modalStatus').modal('hide');
                        $('.status').removeAttr('disabled', 'disabled');
                    } else {
                        iziToast.error({
                            position: "topRight",
                            title: '',
                            message: 'Status gagal di update.'
                        });
                        $('.status').removeAttr('disabled', 'disabled');
                    }
                }
            });
        }

        function cariRiwayat() {
            var tgl1 = $('#Rtgl1').val();
            var tgl2 = $('#Rtgl2').val();
            $.ajax({
                url: baseUrl + "/penjualan/POSgrosir/get-riwayat/" + tgl1 + '/' + tgl2,
                type: 'get',

                success: function (response) {
                    // $('#dt_nota_jual').html(response);
                }
            });
        }

        function tampilDataGrosir(sel) {
            //alert(sel.value);
            var tgl1 = $('#tanggal1').val();
            var tgl2 = $('#tanggal2').val();
            var tampil = sel.value;
            $('#data2').DataTable({
                "responsive": true,
                "destroy": true,
                "processing": true,
                "serverside": true,
                "ajax": {
                    url: baseUrl + "/penjualan/POSgrosir/get-tanggal/" + tgl1 + '/' + tgl2 + '/' + tampil,
                    type: 'GET'
                },
                "columns": [
                    // {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
                    {"data": "sDate", "width": "5%"},
                    {"data": "s_note", "width": "15%"},
                    {"data": "c_name", "width": "20%"},
                    {"data": "sGross", "width": "10%"},
                    {"data": "status", "width": "5%"},
                    {"data": "action", orderable: false, searchable: false, "width": "10%"},
                    {"data": "action2", orderable: false, searchable: false, "width": "10%"},
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

        function cariTanggal() {
            var tgl1 = $('#tanggal1').val();
            var tgl2 = $('#tanggal2').val();
            var tampil = $('#tampil_data').val();
            //$('#dt_nota_jual').html(response);
            tableNota = $('#data2').DataTable({
                "responsive": true,
                "destroy": true,
                "processing": true,
                "serverside": true,
                "ajax": {
                    url: baseUrl + "/penjualan/POSgrosir/get-tanggal/" + tgl1 + '/' + tgl2 + '/' + tampil,
                    type: 'GET'
                },
                "columns": [
                    // {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
                    {"data": "sDate", "width": "5%"},
                    {"data": "s_note", "width": "15%"},
                    {"data": "c_name", "width": "15%"},
                    {"data": "sGross", "width": "10%"},
                    {"data": "status", "width": "5%"},
                    {"data": "s_resi", "width": "5%"},
                    {"data": "action", orderable: false, searchable: false, "width": "10%"},
                    {"data": "action2", orderable: false, searchable: false, "width": "10%"},
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

        function cariTanggalJual() {
            var tgl1 = $('#tanggal3').val();
            var tgl2 = $('#tanggal4').val();
            $('#data3').DataTable({
                "responsive": true,
                "destroy": true,
                "processing": true,
                "serverside": true,
                "ajax": {
                    url: baseUrl + "/penjualan/POSgrosir/get-tanggaljual/" + tgl1 + '/' + tgl2,
                    type: 'GET'
                },
                "columns": [
                    // {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
                    {"data": "i_code", "width": "5%"},
                    {"data": "i_name", "width": "20%"},
                    {"data": "type", "width": "5%"},
                    {"data": "m_gname", "width": "5%"},
                    {"data": "jumlah", "width": "5%", "className": "right"},
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

        function ubahStatus(idDetail, status) {
            $.ajax({
                url: baseUrl + "/penjualan/POSgrosir/ubahstatus",
                type: 'get',
                data: {status: status, id: idDetail},
                success: function (response) {
                    $('#ubahStatusSales').html(response);
                }
            });
        }

        var tabelStock = $('#tabelStock').DataTable({
            responsive: true,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: baseUrl + "/penjualan/POSgrosir/stock/table-stock",
            },
            columns: [
                {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false},
                {data: 'i_name', name: 'i_name'},
                {data: 'i_type', name: 'i_type'},
                {data: 'm_gname', name: 'm_gname'},
                {data: 's_qty', name: 's_qty', "className": "right"},
            ],
        });

        function dataInput(inField, e) {
            var a = 0;
            $('input.discpercent:text').each(function (evt) {
                var getIndex = a;
                var dataInput = $('input.discpercent:text:eq(' + getIndex + ')').val();
                var dataInput1 = $('input.discvalue:text:eq(' + getIndex + ')').val();
                if (dataInput == '' || dataInput1 == '0') {
                    if (dataInput == '' && dataInput1 == 'Rp. 0,00  ') {
                        $('input.discvalue:text:eq(' + getIndex + ')').attr("readonly", false);
                        $('input.discpercent:text:eq(' + getIndex + ')').attr("readonly", false);
                        getIndex += 1;
                    } else {
                        $('input.discvalue:text:eq(' + getIndex + ')').attr("readonly", false);
                        getIndex += 1;
                    }
                } else {
                    $('input.discvalue:text:eq(' + getIndex + ')').attr("readonly", true);
                    getIndex += 1;
                }
                a++;
            })
        }

        function distroyNota(id) {
            iziToast.show({
                color: 'red',
                title: 'Peringatan',
                message: 'Apakah anda yakin!',
                position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                progressBarColor: 'rgb(0, 255, 184)',
                buttons: [
                    [
                        '<button>Ok</button>',
                        function (instance, toast) {
                            instance.hide({
                                transitionOut: 'fadeOutUp'
                            }, toast);
                            $.ajax({
                                type: 'get',
                                url: baseUrl + "/penjualan/POSretail/retail/distroy/" + id,
                                success: function () {
                                    tableNota.ajax.reload();
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
    </script>
@endsection()
