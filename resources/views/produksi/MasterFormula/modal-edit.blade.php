
            <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 15px;padding-top: 15px; ">
            @foreach ($data as $item)
              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Nama Item<font color="red">*</font></label>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                  <input type="text" class="form-control input-sm" readonly name="namaitem" 
                  id="namaitemEdit" value="{{ $item->i_name }}">
                  <input type="hidden" class="form-control input-sm" name="id_item" 
                  id="id_itemEdit" value="{{ $item->i_id }}">
                </div>
              </div>           

              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Jumlah Hasil Produksi<font color="red">*</font></label>
              </div>

              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                 <input style="text-align: right;" autocomplete="off" type="number" class="form-control input-sm" name="hasil_item" id="hasil_itemEdit" value="{{ (int)$item->fr_result }}">
                </div>
              </div>

              <div class="col-md-4 col-sm-4 col-xs-12">
                  <label class="tebal">Satuan<font color="red">*</font></label>
              </div>

              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                  <select class="form-control" id="satuan-itemEdit" name="satuanItem[]">
                    <option value="{{ $item->i_sat1 }}">{{ $item->m_sname }}</option>
                    <option value="{{ $item->i_sat2 }}">{{ $item->m_sname }}</option>
                    <option value="{{ $item->i_sat3 }}">{{ $item->m_sname }}</option>
                  </select>
                </div>
              </div>
              @endforeach 
            </div>
            
            <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:20px;padding-top:20px; ">
                 <div class="col-md-6 col-sm-6 col-xs-12">
                   <label class="control-label tebal" >Masukan Kode / Nama Bahan Baku</label>
                      <div class="input-group input-group-sm" style="width: 100%;">
                          <input type="text" id="bahan_bakuEdit" name="bahan_baku" class="form-control">
                          <input type="hidden" id="i_idEdit" name="i_id" class="form-control">        
                          <input type="hidden" id="i_nameEdit" name="i_name" class="form-control">
                          <input type="hidden" id="i_codeEdit" name="i_code" class="form-control">                                  
                      </div>
                  </div>        
                  <div class="col-md-3 col-sm-3 col-xs-12">
                   <label class="control-label tebal">Masukan Jumlah</label>
                      <div class="input-group input-group-sm" style="width: 100%;">
                         <input type="number" id="qtyEdit" name="qty" class="form-control text-right" >
                      </div>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                   <label class="control-label tebal">Satuan</label>
                      <div class="input-group input-group-sm" style="width: 100%;">
                        <select class="form-control" id="satuanEdit" name="satuan">
                        </select>
                      </div>
                  </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 15px;padding-top: 15px; ">
                  <div class="table-responsive">
                    <table class="table tabelan table-bordered table-hover dt-responsive" id="edit-detail" width="100%">
                     <thead align="right">
                      <tr>
                        <th>Kode</th>
                        <th>Nama Item</th>
                        <th>Jumlah</th>  
                        <th>Satuan</th>                           
                        <th></th>
                      </tr>
                     </thead> 
                     <tbody>
                      @foreach ($formula as $data)
                      <tr>
                        <td>
                          {{ $data->i_code }}
                          <input type="hidden" name="i_id[]" id="" class="i_id" value="{{ $data->i_id }}">
                        </td>
                        <td>
                          {{ $data->i_name }}
                        </td>
                        <td>
                          <input type="number" name="qty[]" id="" class="form-control text-right" 
                          value="{{ (int)$data->f_value }}">
                        </td>
                        <td>
                          {{ $data->m_sname }}
                          <input type="hidden" name="satuan[]" id="" class="" 
                          value="{{ $data->f_scale }}">
                        </td>
                        <td>
                          <div class="text-center"><button type="button" class="btn btn-danger hapus" onclick="hapusEdit(this)"><i class="fa fa-trash-o"></i></button><div>
                        </td>
                      </tr>
                      @endforeach
                     </tbody>
                    </table>
                  </div>
            </div>


<script>
  tableResepEdit = $('#edit-detail').DataTable();

  $( "#bahan_bakuEdit" ).focus(function(){
    var key = 1;
    $( "#bahan_bakuEdit" ).autocomplete({
      source: baseUrl+'/produksi/masterformula/autocomplete',
      minLength: 1,
      select: function(event, ui) {
        $('#i_idEdit').val(ui.item.id);
        $('#i_nameEdit').val(ui.item.name);
        Object.keys(ui.item.satuan).forEach(function(){
          $('#satuanEdit').append($('<option>', { 
            value: ui.item.id_satuan[key-1],
            text : ui.item.satuan[key-1]
            }));
          key++;
        });
        $('#i_codeEdit').val(ui.item.i_code);
        $("input[name='qty']").focus();
        }
    });
    $("#satuanEdit").empty();
    $("#bahan_bakuEdit" ).val('');
    $('#i_idEdit').val('');
    $('#i_nameEdit').val('');
    $('#i_codeEdit').val('');
    $("input[name='qty']").val('');
  });

  function tambahResepEdit(){
    var i_id = [];
    i_id [0] = $('#i_idEdit').val();
    var i_code = $('#i_codeEdit').val();
    var i_name = $('#i_nameEdit').val();
    var qty = $('#qtyEdit').val();
    var idSatuan = $('#satuanEdit option:selected').val();
    var satuan = $('#satuanEdit option:selected').text();
    var hapus = '<div class="text-center"><button type="button" class="btn btn-danger hapus" onclick="hapus(this)"><i class="fa fa-trash-o"></i></button><div>'
    var index = tamp.indexOf(i_id);

    var inputs = document.getElementsByClassName( 'i_id' ),
    idItem  = [].map.call(inputs, function( input ) {
        return input.value;
    });
    var res = i_id.filter( function(n) { return !this.has(n) }, new Set(idItem) );
    //length : menghitung array
    if ( res.length != 0 ){
      tableResepEdit.row.add([
        i_code+'<input type="hidden" name="i_id[]" id="" class="i_id" value="'+i_id+'">',
        i_name+'',
        '<input type="number" name="qty[]" id="" class="form-control text-right" value="'+qty+'">',
        satuan+'<input type="hidden" name="satuan[]" id="" class="" value="'+idSatuan+'">',
        hapus
        ]);
      tableResepEdit.draw();

    }else{
      toastr.warning('item sudah ada');
        $('#bahan_bakuEdit').val('');
        $('#satuanEdit').val('');
        $('#qtyEdit').val('');
        $("input[name='bahan_baku']").focus();
    }
  }

    $('#qtyEdit').keypress(function(e){
        var charCode;
        if ((e.which && e.which == 13)) {
          charCode = e.which;
        }else if (window.event) {
            e = window.event;
            charCode = e.keyCode;
        }
        if ((e.which && e.which == 13)){
          var bahan_baku  = $('#bahan_bakuEdit').val();
          var qty         = $('#qtyEdit').val();
          var satuan      = $('#satuanEdit').val();
          if(bahan_baku == '' || qty == ''){
            toastr.warning('Item dan Jumlah tidak boleh kosong!!');
            return false;
        }else{
          tambahResepEdit();
            $('#bahan_bakuEdit').val('');
            $('#satuanEdit').val('');
            $('#qtyEdit').val('');
            $("input[name='bahan_baku']").focus(); 
             return false;
        }

        }
     });

  function hapusEdit(a){
    var par = a.parentNode.parentNode;
      tableResepEdit.row(par).remove().draw(false);

        var inputs = document.getElementsByClassName( 'i_id' ),
    names  = [].map.call(inputs, function( input ) {
        return input.value;
    });
    tamp = names;
  }
</script>