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
            <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                <div class="page-title">Stock Opname</div>
            </div>
            <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i
                            class="fa fa-angle-right"></i>&nbsp;&nbsp;
                </li>
                <li><i></i>&nbsp;Inventory&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                <li class="active">Stock Opname</li>
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
                            <li class="active"><a href="#alert-tab" data-toggle="tab">Stock Opname</a></li>
                            <li><a href="#note-tab" data-toggle="tab" onclick="getTanggal()">Daftar Stock Opname</a></li>
                        </ul>

                        <div id="generalTabContent" class="tab-content responsive">

                            <!-- Div #alert-tab -->
                        @include('inventory.stockopname.daftar')
                        <!-- End Div #alert-tab -->

                        <!-- Div #note-tab -->
                        @include('inventory.stockopname.history')
                        <!-- End Div #note-tab -->

                        <!-- Div #detail-opname -->
                        @include('inventory.stockopname.modal-opname')
                        <!-- End Div #detail-opname -->

                            <!-- Div #label-badge-tab -->
                            <div id="label-badge-tab" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <!-- Isi Content -->
                                    </div>
                                </div>
                            </div>
                            <!-- End Div #label-badge-tab -->

                        </div>

                    </div>

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

            tableOpname = $('#tabelOpname').DataTable();

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

            $("#namaitem").focus(function () {
                var key = 1;
                var comp = $('#pemilik').val();
                var position = $('#posisi').val();
                $("#namaitem").autocomplete({
                    source: baseUrl + '/inventory/namaitem/autocomplite/'+comp+'/'+position,
                    minLength: 1,
                    select: function (event, ui) {
                        $('#namaitem').val(ui.item.item);
                        $('#i_id').val(ui.item.id);
                        $('#i_code').val(ui.item.i_code);
                        $('#i_name').val(ui.item.i_name);
                        $('#m_sname').val(ui.item.m_sname);
                        $('#s_qty').val(ui.item.s_qty);
                        $('#s_qtykw').val(ui.item.s_qtykw);
                        $("input[name='qtyReal']").focus();
                    }
                });
                $("#namaitem").val('');
                $("#i_id").val('');
                $('#i_code').val('');
                $("#i_name").val('');
                $("#m_sname").val('');
                $("#s_qty").val('');
                $("#s_qtykw").val('');
                $("#qtyReal").val('');
              });
            });

            $('#qtyReal').keypress(function (e) {
                var charCode;
                if ((e.which && e.which == 13)) {
                    charCode = e.which;
                } else if (window.event) {
                    e = window.event;
                    charCode = e.keyCode;
                }
                if ((e.which && e.which == 13)) {
                    var qtyReal = $('#qtyReal').val();
                    if (qtyReal == '') {
                        toastr.warning('Masukan jumlah Real.');
                        return false;
                    }
                    tambahOpname();
                    $("#namaitem").val('');
                    $("#i_id").val('');
                    $('#i_code').val('');
                    $("#i_name").val('');
                    $("#m_sname").val('');
                    $("#s_qty").val('');
                    $("#s_qtyKw").val('');
                    $('#qtyReal').val('');
                    $("input[name='item']").focus();
                    return false;
                }
            });

          var index = 0;
          var tamp = [];
        function tambahOpname(){
          var i_id = $("#i_id").val();
          var namaitem = $('#namaitem').val();
          var s_qty = $('#s_qty').val();
          var s_qtykw = $('#s_qtykw').val();
          var m_sname = $('#m_sname').val();
          var qtyReal = $('#qtyReal').val();
          var opname = parseFloat(qtyReal) - parseFloat(s_qty);
          opname = opname.toFixed(2);
          var opnameKw = parseFloat(qtyReal) - parseFloat(s_qty);
          opnameKw = opnameKw;
          // opnameKw = parseInt(opname);
          opnameKw = convertToRupiah(opnameKw);
          var Hapus = '<div class="text-center"><button type="button" class="btn btn-danger hapus" onclick="hapus(this)"><i class="fa fa-trash-o"></i></button></div>';
          var index = tamp.indexOf(i_id);

        if ( index == -1){
          tableOpname.row.add([
            namaitem+'<input type="hidden" name="i_id[]" id="" class="i_id" value="'+i_id+'">',

            '<input type="hidden" name="qty" id="s-qty" class="form-control text-right s-qty-' + i_id + '" readonly value="'+s_qty+'"><input type="text" name="qtykw" id="s-qtykw" class="form-control text-right" readonly value="'+s_qtykw+'">',

            m_sname,

            '<input type="number" name="real" id="real" class="form-control text-right qty-real-' + i_id + '" onkeyup="hitungOpname(\'' + i_id + '\', \'' + s_qty + '\')" value="'+qtyReal+'">',

            '<input type="hidden" name="opname[]" id="opname" class="form-control text-right opname-' + i_id + '" readonly value="'+opname+'"><input type="text" name="" id="opnameKw" class="form-control text-right opnameKw-' + i_id + '" readonly value="'+opnameKw+'">',

            Hapus
            ]);
          tableOpname.draw();
          index++;
          tamp.push(i_id);

        }else{

          toastr.warning('item sudah ada');
            $("#namaitem").val('');
            $("#i_id").val('');
            $('#i_code').val('');
            $("#i_name").val('');
            $("#m_sname").val('');
            $("#s_qty").val('');
            $("#s_qtyKw").val('');
            $("#qtyReal").val('');
            $("input[name='item']").focus();
          }
        }

        function hapus(a){
          var par = a.parentNode.parentNode;
            tableOpname.row(par).remove().draw(false);

              var inputs = document.getElementsByClassName( 'i_id' ),
          names  = [].map.call(inputs, function( input ) {
              return input.value;
          });
          tamp = names;
        }

        function simpanOpname(){
          $('.kirim-opname').attr('disabled', 'disabled');
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          var a = $('#opname :input').serialize();
          var b = $('#tbOpname :input').serialize();
          $.ajax({
            url : baseUrl + '/inventory/namaitem/simpanopname',
            type: 'GET',
            data: a + '&' + b,
            success: function (response, nota) {
              if (response.status == 'sukses') {
                tableOpname.row().clear().draw(false);
                var inputs = document.getElementsByClassName('i_id'),
                    names = [].map.call(inputs, function (input) {
                        return input.value;
                    });
                tamp = names;
                var nota = response.nota.o_nota;
                iziToast.success({
                    timeout: 5000,
                    position: "topRight",
                    icon: 'fa fa-chrome',
                    title: nota,
                    message: 'Telah terkirim.'
                });
                $('.kirim-opname').removeAttr('disabled', 'disabled');
              } else {
                iziToast.error({
                    position: "topRight",
                    title: '',
                    message: 'Mohon melengkapi data.'
                });
                $('.kirim-opname').removeAttr('disabled', 'disabled');
              }
            }
          });
        }

        function getTanggal() {
          $('#tableHistory').dataTable().fnDestroy();
          var tgl1 = $('#tanggal1').val();
          var tgl2 = $('#tanggal2').val();
          var tableFormula = $('#tableHistory').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url : baseUrl + "/inventory/namaitem/history/"+tgl1+'/'+tgl2,
            },
            columns: [
            {data: 'date', name: 'date', width: '20%'},
            {data: 'o_nota', name: 'o_nota'},
            {data: 'comp', name: 'comp'},
            {data: 'position', name: 'position'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
          });
        }

        function hitungOpname(id, qty){
          var real = $('.qty-real-'+id).val();
          qty = parseFloat(qty).toFixed(2);
          real = parseFloat(real).toFixed(2);
          var opname = real - qty;
          opname = opname.toFixed(2);
          $('.opname-'+id).val(opname);
          //kw
          var opnameKw = real - qty;
          opnameKw = convertToRupiah(opnameKw);
          $('.opnameKw-'+id).val(opnameKw);
          
        }

        function OpnameDet(id) {
          $.ajax({
              url: baseUrl + "/inventory/namaitem/detail/",
              type: "get",
              data: {x: id},
              success: function (response) {
                  $('#view-formula').html(response);
              }
          })

        }

        function clearTable(){
          tableOpname.row().clear().draw(false);
          var inputs = document.getElementsByClassName('i_id'),
              names = [].map.call(inputs, function (input) {
                  return input.value;
              });
          tamp = names;
        }

        function convertToRupiah(angka) {
            var rupiah = '';
            var angkarev = angka.toString().split('').reverse().join('');
            for (var i = 0; i < angkarev.length; i++) if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
            var hasil = rupiah.split('', rupiah.length - 1).reverse().join('');
            return hasil;
        }

        function convertToAngka(rupiah) {
            return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
        }

    </script>
@endsection
