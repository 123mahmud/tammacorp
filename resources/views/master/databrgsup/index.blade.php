@extends('main')
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Master Data Relasi Barang & Supplier</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Master Data Relasi Barang & Supplier</li>
    </ol>
    <div class="clearfix"></div>
  </div>
  <!--BEGIN PAGE CONTENT PAGE-->
  <div class="page-content fadeInRight">
    <div id="tab-general">
      <div class="row mbl">
        <div class="col-lg-12">
          <div class="col-md-12">
            <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
            </div>
          </div>
      
          <ul id="generalTab" class="nav nav-tabs">
            <li class="active"><a href="#index-tab" data-toggle="tab" onclick="showTabelIndex()">Data Barang</a></li>
            <li><a href="#supplier-tab" data-toggle="tab" onclick="showTabelSupplier()">Data Supplier</a></li>
            <!-- <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
          </ul>
          
          <div id="generalTabContent" class="tab-content responsive">
            <!-- div index-tab -->
            @include('master.databrgsup.tab-index')
            @include('master.databrgsup.tab-supplier')
          </div>

        </div>
      </div>
    </div>  
  </div>
  <!--END PAGE WRAPPER-->
  @include('master.databrgsup.modal-barang')
  @include('master.databrgsup.modal-supplier')
</div>

@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    //fix to issue select2 on modal when opening in firefox
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    //add bootstrap class to datatable
    var extensions = {
        "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);

    $(".modal").on("hidden.bs.modal", function(){
      $('tr').remove('.tbl_modal_row');
    });
    showTabelIndex();
  }); //end jquery

  function showTabelIndex() {
    $('#tbl-index').dataTable({
      destroy: true,
      processing : true,
      serverside : true,
      ajax : {
        url : baseUrl + "/master/databrgsup/datatable-index",
        type: 'GET'
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
        {"data" : "i_name", "width" : "30%"},
        {"data" : "i_code", "width" : "30%"},
        {"data" : "qty_sup", "width" : "15%"},
        {"data" : "action", orderable: false, searchable: false, "width" : "20%"}
      ],
      "responsive": true,
      "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
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

  function hapus(id) {
    iziToast.question({
      timeout: 20000,
      close: false,
      overlay: true,
      displayMode: 'once',
      // id: 'question',
      zindex: 999,
      title: 'Hapus Data',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
            $.ajax({
              type: "POST",
              url : baseUrl + "/master/databrgsup/delete-barang",
              data: {id:id, "_token": "{{ csrf_token() }}"},
              success: function(response){
                if(response.status == "sukses")
                {
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.success({
                    position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                    title: 'Pemberitahuan',
                    message: response.pesan,
                    onClosing: function(instance, toast, closedBy){
                      refresh();
                    }
                  });
                }
                else
                {
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.error({
                    position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                    title: 'Pemberitahuan',
                    message: response.pesan,
                    onClosing: function(instance, toast, closedBy){
                      refresh();
                    }
                  }); 
                }
              },
              error: function(){
                iziToast.warning({
                  icon: 'fa fa-times',
                  message: 'Terjadi Kesalahan!'
                });
              },
              async: false
            });
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }
    
  function edit(id) {
    $.ajax({
      type: "GET",
      url : baseUrl + "/master/databrgsup/edit-barang",
      data: {id},
      success: function(data){
      },
      complete:function (argument) {
        window.location=(this.url)
      },
      error: function(){
       
      },
      async: false
    });  
  }

  function detail(id) 
  {
    $.ajax({
      url : baseUrl + "/master/databrgsup/detail-barang/",
      type: "GET",
      dataType: "JSON",
      data : {id:id},
      success: function(data)
      {
        var i = randString(5);
        var key = 1;
        $('#lblNamaBarang').text(data.data[0].i_code+' '+data.data[0].i_name);
        //loop data
        Object.keys(data.data).forEach(function(){
          $('#tabel-detail-barang').append('<tr class="tbl_modal_row" id="row'+i+'">'
                          +'<td align="center">'+key+'</td>'
                          +'<td>'+data.data[key-1].s_company+'</td>'
                          +'<td>'+data.data[key-1].s_address+'</td>'
                          +'</tr>');
          key++;  
          i = randString(5);
        });
        $('#modal-barang').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function hapus(id)
  {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Hapus Data',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url: baseUrl +'/master/databrgsup/delete-barang',
            type: "POST",
            dataType: "JSON",
            data: {id:id, "_token": "{{ csrf_token() }}"},
            success: function(response)
            {
              if(response.status == "sukses")
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.success({
                  position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#tbl-index').DataTable().ajax.reload();
                  }
                });
              }
              else
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.error({
                  position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#tbl-index').DataTable().ajax.reload();
                  }
                }); 
              }
            },
            error: function(){
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
              iziToast.warning({
                icon: 'fa fa-times',
                message: 'Terjadi Kesalahan!'
              });
            },
            async: false
          }); 
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function showTabelSupplier() {
    $('#tbl-supplier').dataTable({
      destroy: true,
      processing : true,
      serverside : true,
      ajax : {
        url : baseUrl + "/master/databrgsup/datatable-supplier",
        type: 'GET'
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
        {"data" : "s_company", "width" : "30%"},
        {"data" : "s_address", "width" : "30%"},
        {"data" : "qty_brg", "width" : "15%"},
        {"data" : "action", orderable: false, searchable: false, "width" : "20%"}
      ],
      "responsive": true,
      "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
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

  function editSup(id) {
    $.ajax({
      type: "GET",
      url : baseUrl + "/master/databrgsup/edit-supplier",
      data: {id},
      success: function(data){
      },
      complete:function (argument) {
        window.location=(this.url)
      },
      error: function(){
       
      },
      async: false
    });  
  }

  function hapusSup(id) {
    iziToast.question({
      timeout: 20000,
      close: false,
      overlay: true,
      displayMode: 'once',
      // id: 'question',
      zindex: 999,
      title: 'Hapus Data',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
            $.ajax({
              type: "POST",
              url : baseUrl + "/master/databrgsup/delete-supplier",
              data: {id:id, "_token": "{{ csrf_token() }}"},
              success: function(response){
                if(response.status == "sukses")
                {
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.success({
                    position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                    title: 'Pemberitahuan',
                    message: response.pesan,
                    onClosing: function(instance, toast, closedBy){
                      refresh2();
                    }
                  });
                }
                else
                {
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.error({
                    position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                    title: 'Pemberitahuan',
                    message: response.pesan,
                    onClosing: function(instance, toast, closedBy){
                      refresh2();
                    }
                  }); 
                }
              },
              error: function(){
                iziToast.warning({
                  icon: 'fa fa-times',
                  message: 'Terjadi Kesalahan!'
                });
              },
              async: false
            });
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function detailSup(id) 
  {
    $.ajax({
      url : baseUrl + "/master/databrgsup/detail-supplier/",
      type: "GET",
      dataType: "JSON",
      data : {id:id},
      success: function(data)
      {
        var i = randString(5);
        var key = 1;
        $('#lblNamaSup').text(data.data[0].s_company);
        $('#lblAlamatSup').text(data.data[0].s_address);
        //loop data
        Object.keys(data.data).forEach(function(){
          $('#tabel-detail-supplier').append('<tr class="tbl_modal_row" id="row'+i+'">'
                          +'<td align="center">'+key+'</td>'
                          +'<td>'+data.data[key-1].i_code+'</td>'
                          +'<td>'+data.data[key-1].i_name+'</td>'
                          +'</tr>');
          key++;  
          i = randString(5);
        });
        $('#modal-supplier').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function randString(angka) 
  {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < angka; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  }

  function refresh() {
    $('#tbl-index').DataTable().ajax.reload();
  }

  function refresh2() {
    $('#tbl-supplier').DataTable().ajax.reload();
  }
</script>
@endsection()