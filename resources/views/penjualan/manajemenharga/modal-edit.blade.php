
            <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 15px;padding-top: 15px; ">
              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Kode Item<font color="red">*</font></label>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                  <input type="text" class="form-control input-sm" readonly name="kode-item" 
                  id="kode-item" value="{{ $data->i_code }}">
                  <input type="hidden" class="form-control input-sm" name="m_pid" 
                  id="m_pid" value="{{ $data->m_pid }}">
                </div>
              </div> 
              <div class="col-md-4 col-sm-4 col-xs-12">
                <label class="tebal">Nama Item<font color="red">*</font></label>
              </div>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">  
                  <input type="text" class="form-control input-sm" readonly name="namaitem" 
                  id="nama-item" value="{{ $data->i_name }}">
                </div>
              </div>          

            </div>
            
            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 15px;padding-top: 15px; ">
                  <div class="table-responsive">
                    <table class="table tabelan table-bordered table-hover dt-responsive" id="edit-price" width="100%">
                     <thead align="right">
                      <tr>
                        <th>Harga A</th>
                        <th>Harga B</th>
                        <th>Harga C</th>  
                       {{--  <th>HPP</th>  --}}
                        <th>Barang Rusak</th> 
                      </tr>
                     </thead> 
                     <tbody>
                      <tr>
                        <td>
                          <input class="form-control text-right price1"  id="m_psell1" name="m_psell1" placeholder="Rp. 0,00" onkeyup="rege(event,'price1');" onblur="setRupiah(event,'price1')" 
                          onclick="setAwal('event','price1')"
                          value="Rp. {{ number_format($data->m_psell1 ,2,',','.') }}">
                        </td>
                        <td>
                         <input class="form-control text-right price2"  id="m_psell2" name="m_psell2" placeholder="Rp. 0,00" onkeyup="rege(event,'price2');" onblur="setRupiah(event,'price2')" 
                          onclick="setAwal('event','price2')"
                          value="Rp. {{ number_format($data->m_psell2 ,2,',','.') }}">
                        </td>
                        <td>
                         <input class="form-control text-right price3"  id="m_psell3" name="m_psell3" placeholder="Rp. 0,00" onkeyup="rege(event,'price3');" onblur="setRupiah(event,'price3')" 
                          onclick="setAwal('event','price3')"
                          value="Rp. {{ number_format($data->m_psell3 ,2,',','.') }}">
                        </td>
                        {{-- <td>
                         <input class="form-control text-right price4"  id="m_psell4" name="m_psell4" placeholder="Rp. 0,00" onkeyup="rege(event,'price4');" onblur="setRupiah(event,'price4')" 
                          onclick="setAwal('event','price4')"
                          value="Rp. {{ number_format($data->m_hpp ,2,',','.') }}">
                        </td> --}}
                        <td>
                         <input class="form-control text-right price5"  id="m_psell5" name="m_psell5" placeholder="Rp. 0,00" onkeyup="rege(event,'price5');" onblur="setRupiah(event,'price5')" 
                          onclick="setAwal('event','price5')"
                          value="Rp. {{ number_format($data->m_barang_rusak ,2,',','.') }}">
                        </td>
                      </tr>
                     </tbody>
                    </table>
                  </div>
            </div>


<script>
  editPrace = $('#edit-price').DataTable();

 
</script>