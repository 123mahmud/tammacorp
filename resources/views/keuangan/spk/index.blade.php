@extends('main')
@section('content')
  <!--BEGIN PAGE WRAPPER-->
  <div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
            <div class="page-title">Manajemen SPK</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><i></i>&nbsp;Produksi&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Manajemen SPK</li>
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
              <li class="active"><a href="#index-tab" data-toggle="tab">Rencana Produksi</a></li>
              <li ><a href="#manajemen-spk-tab" data-toggle="tab" onclick="cariTanggalSpk()">Manajemen SPK</a></li>
            </ul>
            <div id="generalTabContent" class="tab-content responsive">
              <!-- div index-tab -->
              @include('keuangan.spk.tab-index')
              <!-- /div index-tab -->
              <!-- div manajemen-spk-tab -->
              @include('keuangan.spk.tab-manajemen-spk')
              <!-- /div manajemen-spk-tab -->
              <!-- div manajemen-spk-tab -->
              @include('keuangan.spk.detail-spk')
              <!-- /div manajemen-spk-tab -->
            </div>
          </div>
        </div>
      </div>
      {{-- /div tab-general --}}
    </div>
  </div>

  <!-- Modal -->
  @include('keuangan.spk.create-spk')
  <!-- End Modal -->
  <!-- Modal -->
  @include('keuangan.spk.edit-spk')
  <!-- End Modal -->

@endsection

@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
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
    newdate.setDate(newdate.getDate()-3);
    var nd = new Date(newdate);

    $('.datepicker1').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy",
      endDate: 'today'
    }).datepicker("setDate", nd);

    $('.datepicker2').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy",
      endDate: 'today'
    });

    $('.datepicker').datepicker({
      format: "mm",
      viewMode: "months",
      minViewMode: "months"
    });

    $('#edit-data').on('shown.bs.modal', function () {
      $('.draft').attr('disabled','disabled');
      $('.final').attr('disabled','disabled');
    })

    $('#create-data').on('shown.bs.modal', function () {
      $('.draft').attr('disabled','disabled');
      $('.final').attr('disabled','disabled');
    })

  });

    //datatable
    var indexTable = $('#table-index').DataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax": {
          url : baseUrl + "/keuangan/spk/get-data-tabel-index",
          type: 'GET'
      },
      "columns": [
        // {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"},
        {"data" : 'pp_date', name: 'spk_date', "width" : "10%"},
        {"data" : 'i_name', name: 'spk_code', "width" : "70%"},
        {"data" : 'pp_qty', name: 'i_name', "width" : "10%", "className" : "right"},
        {"data" : "action", orderable: false, searchable: false, "width" : "5%"},
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

  function total(inField, e){
    $('.draft').removeAttr('disabled','disabled');
    $('.final').removeAttr('disabled','disabled');
    var a = 0;
    $('input.f_value:text').each(function(evt){
      var getIndex = a;
      var dataValue = $('input.f_value:text:eq('+getIndex+')').val();
      var dataStok = $('input.d_stock:text:eq('+getIndex+')').val();
      dataStok = parseFloat(dataStok);
      dataValue = parseFloat(dataValue);
      var hasil = dataStok - dataValue;
      hasil = parseFloat(hasil);
      if (hasil < 0.00) {
         $('.final').attr('disabled','disabled');
      }
      var convHasil = convertToRupiah(hasil);
      $('input.hasil:text:eq('+getIndex+')').val(convHasil);
    a++;
    })
  }

  function BuatSpk(id,tgl,jumlah,iditem){
    $.ajax({
      url         : baseUrl+'/produksi/spk/create-id/'+iditem,
      type        : 'get',
      timeout     : 10000,
      dataType    :'json',
      success     : function(response){
        if(response.status=='sukses'){
          $('#id_spk').val(response.id_spk);
          $('#create-data').modal('show');
          $('#id_plan').val(id);
          $('#tgl_plan').val(tgl);
          $('#iditem').val(iditem);
          $('#item').val(response.i_name.i_name);
          $('#jumlah').val(jumlah);
          tabelFormula(iditem, jumlah);
        }
      }
    });
  }

  function tabelFormula(iditem, jumlah){
    $('#tableFormula').dataTable().fnDestroy();
    $('#tableFormula').DataTable({
      responsive:true,
      destroy: true,
      processing: true,
      serverSide: true,
        ajax: {
            url : baseUrl + "/produksi/lihatadonan/tabel/"+iditem+'/'+jumlah,
             error: function (jqXHR, textStatus, errorThrown) {
                $('#create-data').modal('hide');
                iziToast.error({
                    position: "topRight",
                    title: '',
                    message: 'Rumus Formula Belum di Buat!'
                });

            }
        },
        columns: [
        {data: 'f_bb', name: 'f_bb'},
        {data: 'f_value', name: 'f_value'},
        {data: 'm_sname', name: 'm_sname'},
        {data: 'd_stock', name: 'd_stock', orderable: false},
        {data: 'purchesing', name: 'purchesing', orderable: false},
        ],
      });
  }

  function editSpk(id){
    $.ajax({
      url         : baseUrl+'/produksi/spk/edit/'+id,
      type        : 'get',
      dataType    :'json',
      success     : function(response){
        if(response.status=='sukses'){
          $('#edit-data').modal('show');
          $('#id_spkD').val(response.data.spk_code);
          $('#id_plan').val(id);
          $('#tgl_planD').val(response.data.pp_date);
          $('#iditem').val(iditem);
          $('#itemD').val(response.data.i_name);
          $('#id_spkk').val(response.data.spk_id);
          $('#jumlahD').val(response.data.pp_qty);
          var iditem = response.data.pp_item;
          var jumlah = response.data.pp_qty;
          tabelDraftFormula(iditem, jumlah);
        }
      }
    })
  }

  function tabelDraftFormula(iditem, jumlah){
    var formulaDraft = $('#tabelDraftFormula').DataTable({
      responsive:true,
      destroy: true,
      processing: true,
      serverSide: true,
        ajax: {
            url : baseUrl + "/produksi/lihatadonan/tabel/"+iditem+'/'+jumlah,
        },
        columns: [
        // {data : 'DT_Row_Index', orderable: true, searchable: false},
        {data: 'f_bb', name: 'f_bb'},
        {data: 'f_value', name: 'f_value'},
        {data: 'm_sname', name: 'm_sname'},
        {data: 'd_stock', name: 'd_stock', orderable: false},
        {data: 'purchesing', name: 'purchesing', orderable: false},
        ],
      });
  }


  function tambahSpk(){
    cariTanggal();
    $('#table-production-plan').modal('show');
  }

  function draft(status){
    $('.draft').attr('disabled','disabled');
    var dataPlan=$('#data-product-plan :input').serialize(); //spk.create-spk
    var dataSpk=$('#data-spk :input').serialize(); //spk.create-spk
    var idformula=$('#formula :input').serialize();
      $.ajax({
        url         : baseUrl + '/produksi/spk/draft/simpan-spk',
        type        : 'get',
        timeout     : 10000,
        dataType    :'json',
        data        :dataPlan+'&'+dataSpk+'&status='+status+'&'+idformula,
        success     : function(response){
          if(response.status=='sukses') {
            iziToast.success({timeout: 5000,
                        position: "topRight",
                        icon: 'fa fa-chrome',
                        title: '',
                        message: 'SPK di setujui sebagi draft.'});
            $('#create-data').modal('hide');
            indexTable.ajax.reload();
            $('.draft').removeAttr('disabled','disabled');
          }else{
            iziToast.error({position: "topRight",
                        title: '',
                        message: 'SPK gagal di setujui.'});
            $('.draft').removeAttr('disabled','disabled')
          }
        }
      });
    }

  function final(status){
    $('.final').attr('disabled','disabled');
    var dataPlan=$('#data-product-plan :input').serialize(); //spk.create-spk
    var dataSpk=$('#data-spk :input').serialize(); //spk.create-spk
    var idformula=$('#formula :input').serialize();
    $.ajax({
      url         : baseUrl+'/produksi/spk/final/simpan-spk',
      type        : 'get',
      timeout     : 10000,
      dataType    :'json',
      data        :dataPlan+'&'+dataSpk+'&status='+status+'&'+idformula,
      success     : function(response) {
        if(response.status=='sukses'){
          iziToast.success({timeout: 5000,
                        position: "topRight",
                        icon: 'fa fa-chrome',
                        title: '',
                        message: 'SPK berhasil di setujui.'});
          $('#create-data').modal('hide');
          indexTable.ajax.reload();
          $('.final').removeAttr('disabled','disabled');
        }else{
          iziToast.error({position: "topRight",
                        title: '',
                        message: 'SPK gagal di setujui.'});
          $('.final').removeAttr('disabled','disabled');
        }
      }
    });
  }

  function cariTanggalSpk(){
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    var tampil = $('#tampil_data').val();
    spkTable = $('#table-spk').DataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax": {
          url : baseUrl + "/keuangan/spk/get-data-tabel-spk/"+tgl1+"/"+tgl2+"/"+tampil,
          type: 'GET'
      },
      "columns": [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"},
        {"data" : 'spk_date', name: 'spk_date', "width" : "10%"},
        {"data" : 'spk_code', name: 'spk_code', "width" : "10%"},
        {"data" : 'i_name', name: 'i_name', "width" : "25%"},
        {"data" : 'pp_qty', name: 'pp_qty', "width" : "10%"},
        {"data" : "status", "width" : "10%"},
        {"data" : "action", orderable: false, searchable: false, "width" : "15%"},
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

  $('#tampil_data').on('change', function() {
    cariTanggalSpk();
  })


  function refreshTabel() {
    $('#table-index').DataTable().ajax.reload();
  }

  function refreshTabelSpk() {
    $('#table-spk').DataTable().ajax.reload();
  }

  function detailManSpk(id){
    $.ajax({
      url : baseUrl + "/keuangan/spk/lihat-detail/",
      type: "get",
      data: {x:id},
      success: function(response){
        $('#view-formula').html(response);
      }
    })
  }

  function updateFinal(FN){
    $('.final').attr('disabled','disabled');
    id = $('#id_spkk').val();
    var idformula =$('#formulaDraft :input').serialize();
    $.ajax({
      url   : baseUrl + "/keuangan/spk/update-status/" + id,
      type  : "get",
      dataType: "JSON",
      data  :idformula,
      success: function(response){
      if(response.status=='sukses'){
        iziToast.success({timeout: 5000,
                      position: "topRight",
                      icon: 'fa fa-chrome',
                      title: '',
                      message: 'SPK berhasil di setujui.'});
        $('#edit-data').modal('hide');
        cariTanggalSpk();
        $('.final').removeAttr('disabled','disabled');
      }else{
        iziToast.error({position: "topRight",
                      title: '',
                      message: 'SPK gagal di setujui.'});
        $('.final').removeAttr('disabled','disabled');
      }
      }
    });
  }

  function convertToRupiah(angka) {
            var rupiah = '';
            var angkarev = angka.toString().split('').reverse().join('');
            for (var i = 0; i < angkarev.length; i++) if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
            var hasil = rupiah.split('', rupiah.length - 1).reverse().join('');
            return hasil;
        }

</script>
@endsection()
