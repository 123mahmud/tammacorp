<!-- detail order-->

          <div id="data-product-plan" class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">

            <div class="col-md-4 col-sm-3 col-xs-12">
              <div class="">
                <label class="tebal">Nama :</label>
              </div>
            </div>
             <div class="col-md-8 col-sm-3 col-xs-12">
              <div class="form-group">
                <input class="form-control" readonly type="text" name="tgl_plan" id="tgl_planD"
                value="{{$pengajuan[0]->c_nama}}">
                 <input class="form-control" type="hidden" name="id_plan" id="id_plan">
              </div>
            </div>

            <div class="col-md-4 col-sm-3 col-xs-12">
              <div class="">
                <label class="tebal">Jenis Pelatihan :</label>
              </div>
            </div>
            <div class="col-md-8 col-sm-3 col-xs-12">
              <div class="form-group">
                <input class="form-control" readonly="" type="text" name="jumlah" id="jumlahD"
                value="{{$pengajuan[0]->dp_name}}">
              </div>
            </div>


          </div>
        <div id="data-product-plan" class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">
          <div class="table-responsive">
            <form id="formula">
              <table class="table tabelan table-hover table-bordered" id="detailFormula" width="100%">
                <thead>
                  <tr>
                    <th width="30%">Waktu</th>
                    <th width="35%">Ekstern</th>
                    <th width="35%">Intern</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ $pengajuan[0]->pp_fpd_ket }}</td>
                    <td>{{ $pengajuan[1]->pp_fpd_ket }}</td>
                    <td>{{ $pengajuan[2]->pp_fpd_ket }}</td>
                  </tr>
                </tbody>
              </table>
            </form>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>

        </div>


<!-- end detail order-->

<script type="text/javascript">
  $('#detailFormula').dataTable();

</script>
