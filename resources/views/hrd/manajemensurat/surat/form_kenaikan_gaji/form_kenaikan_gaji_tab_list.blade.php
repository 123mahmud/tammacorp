<div id="list-tab" class="tab-pane fade in">
  <div class="table-responsive">
    <table class="table tabelan table-bordered table-hover table-striped" width="100%" cellspacing="0" id="tbl-promosi">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Tanggal Buat</th>
          <th>Nama Pegawai</th>
          <th>Kenaikan</th>
          <th>Diusulkan oleh</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td align="center">
            {{-- <div class="btn-group btn-group-sm">
              <a href="{{route('form_kenaikan_gaji_print')}}" target="_blank" class="btn btn-info" title="Print"><i class="fa fa-print"></i></a>
              <button class="btn btn-danger" title="Hapus"><i class="fa fa-trash-o"></i></button>
            </div> --}}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div align="right" style="margin-top: 15px;">
    <a href="{{route('manajemensurat')}}" class="btn btn-default">Kembali</a>
  </div>
</div>