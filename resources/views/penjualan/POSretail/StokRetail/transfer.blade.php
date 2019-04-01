<div class="modal fade" id="myTransfer" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Request Item</h4>
            </div>
            <div class="modal-body">
                <form action="get" id="save_request">
                    <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg"
                        style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">
                        <div class="col-md-4 col-sm-3 col-xs-12">
                            <label class="tebal" name="admin">Admin</label>
                        </div>
                        <div class="col-md-8 col-sm-9 col-xs-12">
                            <div class="form-group">
                                <div class="input-icon right">
                                    <i class="glyphicon glyphicon-user"></i>
                                    <input type="text" id="" readonly="true" name="admin" class="form-control input-sm"
                                    value="{{ Auth::user()->m_name }}">
                                    <input type="hidden" id="" readonly="true" name="ri_admin"
                                    class="form-control input-sm" value="{{ Auth::user()->m_id }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-3 col-xs-12">
                            <label class="tebal">Tanggal</label>
                        </div>
                        <div class="col-md-8 col-sm-9 col-xs-12">
                            <div class="form-group">
                                <div class="input-icon right">
                                    <i class="glyphicon glyphicon-envelope"></i>
                                    <input type="text" readonly="true" name="ri_tanggal" class="form-control input-sm"
                                    value="{{ date('d-m-Y') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-3 col-xs-12">
                            <label class="tebal">Ket</label>
                        </div>
                        <div class="col-md-8 col-sm-9 col-xs-12">
                            <div class="form-group">
                                <div class="input-icon right">
                                    <i class="glyphicon glyphicon-envelope"></i>
                                    <input type="text" id="ri_keterangan" name="ri_keterangan"
                                    class="form-control input-sm" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg"
                        style="margin-bottom: 20px; padding-bottom:20px;padding-top:20px; ">
                        <div class="col-md-9 col-sm-6 col-xs-12">
                            <label class="control-label tebal">Masukan Kode / Nama</label>
                            <div class="input-group input-group-sm" style="width: 100%;">
                                <input type="text" id="rnamaitem" name="rnamaitem" class="form-control">
                                <input type="hidden" id="rkode" name="rsd_item" class="form-control">
                                <input type="hidden" id="code" class="form-control">
                                <input type="hidden" id="rdetailnama" name="rnama" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <label class="control-label tebal">Masukan Jumlah</label>
                            <div class="input-group input-group-sm" style="width: 100%;">
                                <input type="text" id="rqty" name="rqty" class="form-control currency-x text-right">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table tabelan table-bordered table-hover dt-responsive" id="detail-req"
                            style="width: 100%">
                            <thead align="right">
                                <tr>
                                    <th width="15%">Kode</th>
                                    <th width="60%">Nama Item</th>
                                    <th width="20%">Jumlah</th>
                                    <th width="5%" class="text-center">
                                        <button class="hidden" onclick="tambahreq()">add</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                <button class="btn btn-primary simpan-transfer" type="button" onclick="simpanTransfer()">Simpan</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $('#save_request').submit(function (event) {
        return false;
    })
</script>