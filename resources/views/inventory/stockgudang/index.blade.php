@extends('main')
@section('content')
    <!--BEGIN PAGE WRAPPER-->
    <div id="page-wrapper">
        <!--BEGIN TITLE & BREADCRUMB PAGE-->
        <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
            <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                <div class="page-title">Stock Gudang</div>
            </div>
            <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i
                            class="fa fa-angle-right"></i>&nbsp;&nbsp;
                </li>
                <li><i></i>&nbsp;Inventory&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                <li class="active">Stock Gudang</li>
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
                            <li class="active"><a href="#alert-tab" data-toggle="tab">Stock Gudang</a></li>
                        </ul>

                        <div id="generalTabContent" class="tab-content responsive">

                            <!-- Div #alert-tab -->
                        @include('inventory.stockgudang.daftar')
                        <!-- End Div #alert-tab -->

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

            $('#tabelGudang').DataTable();

        });

        function pilihGudang()
        {
            var x = document.getElementById("pemilik").value;
            var y = document.getElementById("posisi").value;
            $.ajax({
                url: baseUrl + '/inventory/namaitem/tablegudang/'+x+'/'+y,
                type: 'GET',
                success: function (response) {
                  $('#tabelGudang').DataTable({
                   responsive: true,
                   destroy: true,
                   processing: true,
                   serverSide: true,
                   ajax: {
                       url: baseUrl + '/inventory/namaitem/tablegudang/'+x+'/'+y,
                   },
                   columns: [
                       {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, width: '5%'},
                       {data: 'item', name: 'item'},
                       {data: 'type', name: 'type'},
                       {data: 's_qty', name: 's_qty'},
                       {data: 'm_sname', name: 'm_sname'},
                   ],
           });
                }
              })
        }

        function kirim(inField, e){
          var a = 0;
          $('.input-real').each(function (evt) {
              var getIndex = a;
              var dataInput = $('.input-real:eq(' + getIndex + ')').val();
                if (dataInput != '') {
                  $('.kirim-opname').removeAttr('disabled', 'disabled');
                  // $('.kirim-opname').attr('disabled', 'disabled');
                  alert('d');
                }else {
                  alert('e')
                  // $('.kirim-opname').removeAttr('disabled', 'disabled');
                  $('.kirim-opname').attr('disabled', 'disabled');
                }
              a++;
          })
        }

    </script>
@endsection
