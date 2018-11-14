    <div class="col-md-1 col-sm-12 col-xs-12">
      <label class="tebal">Input Resi :</label>
    </div>
    <form id="resi">
    <div class="col-md-3 col-sm-12 col-xs-12">
      <div class="form-group">
        <input type="text" class="form-control input-sm" name="resi">
      </div>
    </div>
    </form>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <label class="tebal">Tabel Terima Salah Barang :</label>
    </div>

    <table class="table tabelan table-bordered table-hover" id="TbDtDetailSB">
        <thead>
            <tr>
                <th width="60%">Nama</th>
                <th width="20%">Jumlah</th>
                <th width="20%">Satuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataSB as $SB)
            <tr>
                <td>{{ $SB->i_name }}</td>
                <td><span class="pull-right">
                        {{ $SB->dsrs_qty }}
                    </span>
                </td>
                <td>{{ $SB->m_sname }}</td>
            </tr>
            @endforeach
            
        </tbody>
    </table>

    <div class="modal-footer">

        @if ($dataSB[0]->dsr_status_terima == 'WT')
            <button type="button" class="btn btn-info" onclick="terimaSB({{ $dataSB[0]->dsr_id }})" id="button_confirm_return">Terima</button>
        @endif
        
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
    </div>

<script>
$('#TbDtDetail').DataTable();
$('#TbDtDetailSB').DataTable();
</script>