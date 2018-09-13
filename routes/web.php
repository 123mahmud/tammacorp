<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('index');
    Route::get('login', 'loginController@authenticate');
    Route::post('login', 'loginController@authenticate');
    Route::get('not-allowed', 'mMemberController@notAllowed');
    Route::get('recruitment', 'RecruitmentController@recruitment');
    Route::post('recruitment/save', 'RecruitmentController@save');
    Route::get('recruitment/cek-email', 'RecruitmentController@cekEmail');
    Route::get('recruitment/cek-wa', 'RecruitmentController@cekWa');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', 'mMemberController@logout');
    Route::get('/home', 'HomeController@home');
    /*Master*/
    Route::get('/master/datasuplier/suplier', 'MasterController@suplier')->name('suplier');
    /* ari */
    /*---------*/
//huda
    Route::get('/hrd/datajabatan', 'Hrd\JabatanController@index');
    Route::get('/hrd/datajabatan/data-jabatan', 'Hrd\JabatanController@jabatanData');
    Route::get('/hrd/datajabatan/edit-jabatan/{id}', 'Hrd\JabatanController@editJabatan');
    Route::get('/hrd/datajabatan/datatable-pegawai/{id}', 'Hrd\JabatanController@pegawaiData');
    Route::post('/hrd/datajabatan/simpan-jabatan', 'Hrd\JabatanController@simpanJabatan');
    Route::put('/hrd/datajabatan/update-jabatan/{id}', 'Hrd\JabatanController@updateJabatan');
    Route::get('/hrd/datajabatan/tambah-jabatan', 'Hrd\JabatanController@tambahJabatan');
    Route::delete('/hrd/datajabatan/delete-jabatan/{id}', 'Hrd\ManajemenSuratController@deleteJabatan');
//surat
    Route::get('/hrd/manajemensurat', 'Hrd\ManajemenSuratController@index');
    Route::get('/hrd/manajemensurat/surat-phk', 'Hrd\ManajemenSuratController@indexPhk');
    Route::get('/hrd/manajemensurat/data-phk', 'Hrd\ManajemenSuratController@phkData');
    Route::post('/hrd/manajemensurat/simpan-phk', 'Hrd\ManajemenSuratController@simpanPhk');
    Route::get('/hrd/manajemensurat/edit-phk/{id}', 'Hrd\ManajemenSuratController@editPhk');
    Route::put('/hrd/manajemensurat/update-phk/{id}', 'Hrd\ManajemenSuratController@updatePhk');
    Route::delete('/hrd/manajemensurat/delete-phk/{id}', 'Hrd\ManajemenSuratController@deletePhk');
//gaji
    Route::get('/hrd/payroll/payroll', 'Hrd\PayrollController@payroll');
    Route::get('/hrd/payroll/view/{id}', 'Hrd\PayrollController@viewPayroll');
    Route::get('/hrd/payroll/tambah/{id}/{peg}', 'Hrd\PayrollController@bayar');
    Route::post('/hrd/payroll/simpan', 'Hrd\PayrollController@simpanDetail');
    Route::get('/hrd/payroll/datatable-payroll', 'Hrd\PayrollController@payrollData');
    Route::get('/hrd/payroll/datatable-view/{id}', 'Hrd\PayrollController@pegawai');
    Route::get('/hrd/payroll/setting-gaji', 'Hrd\GajiController@settingGajiMan');
    Route::get('/hrd/payroll/datatable-gaji-man', 'Hrd\GajiController@gajiManData');
    Route::get('/hrd/payroll/tambah-gaji-man', 'Hrd\GajiController@tambahGajiMan');
    Route::post('/hrd/payroll/simpan-gaji-man', 'Hrd\GajiController@simpanGajiMan');
    Route::get('/hrd/payroll/edit-gaji-man/{id}', 'Hrd\GajiController@editGajiMan');
    Route::put('/hrd/payroll/update-gaji-man/{id}', 'Hrd\GajiController@updateGajiMan');
    Route::delete('/hrd/payroll/delete-gaji-man/{id}', 'Hrd\GajiController@deleteGajiMan');
    Route::get('/hrd/payroll/datatable-gaji-pro', 'Hrd\GajiController@gajiProData');
    Route::get('/hrd/payroll/tambah-gaji-pro', 'Hrd\GajiController@tambahGajiPro');
    Route::post('/hrd/payroll/simpan-gaji-pro', 'Hrd\GajiController@simpanGajiPro');
    Route::get('/hrd/payroll/edit-gaji-pro/{id}', 'Hrd\GajiController@editGajiPro');
    Route::put('/hrd/payroll/update-gaji-pro/{id}', 'Hrd\GajiController@updateGajiPro');
    Route::delete('/hrd/payroll/delete-gaji-pro/{id}', 'Hrd\GajiController@deleteGajiPro');
    Route::get('/hrd/payroll/datatable-potongan', 'Hrd\GajiController@potonganData');
    Route::get('/hrd/payroll/tambah-potongan', 'Hrd\GajiController@tambahPotongan');
    Route::post('/hrd/payroll/simpan-potongan', 'Hrd\GajiController@simpanPotongan');
    Route::get('/hrd/payroll/edit-potongan/{id}', 'Hrd\GajiController@editPotongan');
    Route::put('/hrd/payroll/update-potongan/{id}', 'Hrd\GajiController@updatePotongan');
    Route::delete('/hrd/payroll/delete-potongan/{id}', 'Hrd\GajiController@deletePotongan');
//pegawai
    Route::get('/master/datapegawai/datatable-pegawaipro', 'Master\PegawaiController@pegawaiPro');
    Route::get('/master/datapegawai/tambah-pegawai-pro', 'Master\PegawaiController@tambahPegawaiPro');
    Route::post('/master/datapegawai/simpan-pegawai-pro', 'Master\PegawaiController@simpanPegawaiPro');
    Route::get('/master/datapegawai/edit-pegawai-pro/{id}', 'Master\PegawaiController@editPegawaiPro');
    Route::put('/master/datapegawai/update-pegawai-pro/{id}', 'Master\PegawaiController@updatePegawaiPro');
    Route::delete('/master/datapegawai/delete-pegawai-pro/{id}', 'Master\PegawaiController@deletePegawaiPro');
    Route::post('/master/datapegawai/import-pro', 'Master\PegawaiController@importPegawaiPro');
    Route::get('/master/datapegawai/master-import-pro', 'Master\PegawaiController@getFilePro');
    Route::get('/master/datapegawai/pegawai', 'Master\PegawaiController@pegawai')->name('pegawai');
    Route::get('/master/datapegawai/edit-pegawai/{id}', 'Master\PegawaiController@editPegawai');
    Route::put('/master/datapegawai/update-pegawai/{id}', 'Master\PegawaiController@updatePegawai');
    Route::get('/master/datapegawai/datatable-pegawai', 'Master\PegawaiController@pegawaiData');
    Route::get('/master/datapegawai/tambah-pegawai', 'Master\PegawaiController@tambahPegawai');
    Route::get('/master/datapegawai/data-jabatan/{id}', 'Master\PegawaiController@jabatanData');
    Route::post('/master/datapegawai/simpan-pegawai', 'Master\PegawaiController@simpanPegawai');
    Route::delete('/master/datapegawai/delete-pegawai/{id}', 'Master\PegawaiController@deletePegawai');
    Route::post('/master/datapegawai/import', 'Master\PegawaiController@importPegawai');
    Route::get('/master/datapegawai/master-import', 'Master\PegawaiController@getFile');
    /*Purchasing*/
//rizky
//rencana bahan baku
    Route::get('/purchasing/rencanabahanbaku/bahan', 'Pembelian\RencanaBahanController@index');
    Route::get('/purchasing/rencanabahanbaku/get-rencana-bytgl/{tgl1}/{tgl2}/{tampil}', 'Pembelian\RencanaBahanController@getRencanaByTgl');
    Route::get('/purchasing/rencanabahanbaku/get-detail-rencana/{id}', 'Pembelian\RencanaBahanController@getDetailRencana');
    Route::post('/purchasing/rencanabahanbaku/ubah-status-spk', 'Pembelian\RencanaBahanController@ubahStatus');
//order pembelian
    Route::get('/purchasing/orderpembelian/order', 'Pembelian\OrderPembelianController@order');
    Route::get('/purchasing/orderpembelian/tambah_order', 'Pembelian\OrderPembelianController@tambah_order');
    Route::get('/purchasing/orderpembelian/get-data-tabel-index', 'Pembelian\OrderPembelianController@getDataTabelIndex');
    Route::get('/purchasing/orderpembelian/get-supplier', 'Pembelian\OrderPembelianController@getSupplier');
    Route::get('/purchasing/orderpembelian/get-data-rencana-beli', 'Pembelian\OrderPembelianController@getDataRencanaBeli');
    Route::get('/purchasing/orderpembelian/get-data-detail/{id}', 'Pembelian\OrderPembelianController@getDataDetail');
    Route::get('/purchasing/orderpembelian/get-data-form/{id}', 'Pembelian\OrderPembelianController@getDataForm');
    Route::post('/purchasing/orderpembelian/simpan-po', 'Pembelian\OrderPembelianController@simpanPo');
    Route::get('/purchasing/orderpembelian/get-edit-order/{id}', 'Pembelian\OrderPembelianController@getEditOrder');
    Route::post('/purchasing/orderpembelian/update-data-order', 'Pembelian\OrderPembelianController@updateDataOrder');
    Route::post('/purchasing/orderpembelian/delete-data-order', 'Pembelian\OrderPembelianController@deleteDataOrder');
    Route::get('/purchasing/orderpembelian/get-data-tabel-history/{tgl1}/{tgl2}/{tampil}', 'Pembelian\OrderPembelianController@getDataTabelHistory');
    Route::get('/purchasing/orderpembelian/get-penerimaan-peritem/{id}', 'Pembelian\OrderPembelianController@getPenerimaanPerItem');
    Route::get('/purchasing/orderpembelian/get-order-by-tgl/{tgl1}/{tgl2}', 'Pembelian\OrderPembelianController@getOrderByTgl');
// Ari
    Route::get('/purchasing/orderpembelian/print/{id}', 'Pembelian\OrderPembelianController@print');
// irA
//rencana pembelian
    Route::get('/purchasing/rencanapembelian/rencana', 'Pembelian\RencanaPembelianController@rencana');
    Route::get('/purchasing/rencanapembelian/create', 'Pembelian\RencanaPembelianController@create');
    Route::get('/purchasing/rencanapembelian/get-data-tabel-daftar', 'Pembelian\RencanaPembelianController@getDataTabelDaftar');
    Route::get('/purchasing/rencanapembelian/get-supplier', 'Pembelian\RencanaPembelianController@getDataSupplier');
    Route::get('/purchasing/rencanapembelian/autocomplete-barang', 'Pembelian\RencanaPembelianController@autocompleteBarang');
    Route::post('/purchasing/rencanapembelian/simpan-plan', 'Pembelian\RencanaPembelianController@simpanPlan');
    Route::get('/purchasing/rencanapembelian/get-detail-plan/{id}/{type}', 'Pembelian\RencanaPembelianController@getDetailPlan');
    Route::get('/purchasing/rencanapembelian/get-edit-plan/{id}/{type}', 'Pembelian\RencanaPembelianController@getEditPlan');
    Route::post('/purchasing/rencanapembelian/update-data-plan', 'Pembelian\RencanaPembelianController@updateDataPlan');
    Route::post('/purchasing/rencanapembelian/delete-data-plan', 'Pembelian\RencanaPembelianController@deleteDataPlan');
    Route::get('/purchasing/rencanapembelian/get-data-tabel-history/{tgl1}/{tgl2}/{tampil}', 'Pembelian\RencanaPembelianController@getDataTabelHistory');
    Route::get('/purchasing/rencanapembelian/get-stok-persatuan', 'Pembelian\RencanaPembelianController@getStokPersatuan');
    Route::get('/purchasing/rencanapembelian/get-rencana-by-tgl/{tgl1}/{tgl2}', 'Pembelian\RencanaPembelianController@getRencanaByTgl');
//belanja harian
    Route::get('/purchasing/belanjaharian/belanja', 'Pembelian\BelanjaHarianController@belanja');
    Route::get('/purchasing/belanjaharian/tambah_belanja', 'Pembelian\BelanjaHarianController@tambah_belanja');
    Route::get('/purchasing/belanjaharian/get-data-tabel-index', 'Pembelian\BelanjaHarianController@getDataTabelIndex');
    Route::get('/purchasing/belanjaharian/autocomplete-barang', 'Pembelian\BelanjaHarianController@autocompleteBarang');
    Route::post('/purchasing/belanjaharian/simpan-data-belanja', 'Pembelian\BelanjaHarianController@simpanDataBelanja');
    Route::get('/purchasing/belanjaharian/get-detail-belanja/{id}', 'Pembelian\BelanjaHarianController@getDetailBelanja');
    Route::get('/purchasing/belanjaharian/get-edit-belanja/{id}', 'Pembelian\BelanjaHarianController@getEditBelanja');
    Route::post('/purchasing/belanjaharian/update-data-belanja', 'Pembelian\BelanjaHarianController@updateDataBelanja');
    Route::post('/purchasing/belanjaharian/delete-data-belanja', 'Pembelian\BelanjaHarianController@deleteDataBelanja');
    Route::get('/purchasing/belanjaharian/get-belanja-by-tgl/{tgl1}/{tgl2}', 'Pembelian\BelanjaHarianController@getBelanjaByTgl');
    Route::get('/purchasing/belanjaharian/get-data-masterbarang', 'Pembelian\BelanjaHarianController@getDataMasterBarang');
    Route::get('/purchasing/belanjaharian/get-data-kodesatuan', 'Pembelian\BelanjaHarianController@getDataKodeSatuan');
    Route::post('/purchasing/belanjaharian/simpan-barang', 'Pembelian\BelanjaHarianController@simpanDataBarang');
    Route::post('/purchasing/belanjaharian/simpan-satuan', 'Pembelian\BelanjaHarianController@simpanDataSatuan');
// Ari
    Route::get('/purchasing/belanjaharian/print/{id}', 'Pembelian\BelanjaHarianController@print');
//return pembelian
    Route::get('/purchasing/returnpembelian/pembelian', 'Pembelian\ReturnPembelianController@index');
    Route::get('/purchasing/returnpembelian/tambah-return', 'Pembelian\ReturnPembelianController@tambahReturn');
    Route::get('/purchasing/returnpembelian/lookup-data-pembelian', 'Pembelian\ReturnPembelianController@lookupDataPembelian');
    Route::get('/purchasing/returnpembelian/get-data-form/{id}', 'Pembelian\ReturnPembelianController@getDataForm');
    Route::post('/purchasing/returnpembelian/simpan-data-return', 'Pembelian\ReturnPembelianController@simpanDataReturn');
    Route::get('/purchasing/returnpembelian/get-data-return-pembelian', 'Pembelian\ReturnPembelianController@getDataReturnPembelian');
    Route::get('/purchasing/returnpembelian/get-data-detail/{id}', 'Pembelian\ReturnPembelianController@getDataDetail');
    Route::get('/purchasing/returnpembelian/get-data-detail/{id}/{type}', 'Pembelian\ReturnPembelianController@getDataDetail');
    Route::post('/purchasing/returnpembelian/update-data-return', 'Pembelian\ReturnPembelianController@updateDataReturn');
    Route::post('/purchasing/returnpembelian/delete-data-return', 'Pembelian\ReturnPembelianController@deleteDataReturn');
    Route::get('/purchasing/returnpembelian/get-list-revisi-bytgl/{tgl1}/{tgl2}/{tampil}', 'Pembelian\ReturnPembelianController@getListRevisiByTgl');
    Route::get('/purchasing/returnpembelian/get-return-by-tgl/{tgl1}/{tgl2}', 'Pembelian\ReturnPembelianController@getReturnByTgl');
    Route::get('/purchasing/returnpembelian/get-detail-revisi/{id}','Pembelian\ReturnPembelianController@getDetailRevisi');
    Route::post('/purchasing/returnpembelian/ubah-status-po/{id}','Pembelian\ReturnPembelianController@ubahStatusPo');
//rizky
    Route::get('/purchasing/belanjasuplier/suplier', 'Pembelian\PurchasingController@suplier');
    Route::get('/purchasing/belanjalangsung/langsung', 'Pembelian\PurchasingController@langsung');
    Route::get('/purchasing/belanjaproduk/produk', 'Pembelian\PurchasingController@produk');
    Route::get('/purchasing/rencanabahanbaku/bahan', 'Pembelian\PurchasingController@bahan');
    Route::get('/purchasing/belanjapasar/pasar', 'Pembelian\PurchasingController@pasar');
//rizky
    Route::get('/purchasing/belanjasuplier/suplier', 'Pembelian\PurchasingController@suplier');
    Route::get('/purchasing/belanjalangsung/langsung', 'Pembelian\PurchasingController@langsung');
    Route::get('/purchasing/belanjaproduk/produk', 'Pembelian\PurchasingController@produk');
    Route::get('/purchasing/rencanabahanbaku/bahan', 'Pembelian\PurchasingController@bahan');
    Route::get('/purchasing/belanjapasar/pasar', 'Pembelian\PurchasingController@pasar');
//end purchasing
    /*Inventory*/
    Route::get('/inventory/POSretail/transfer', 'transferItemController@index');
    Route::get('/inventory/POSgrosir/transfer', 'transferItemGrosirController@indexGrosir');
    Route::get('/inventory/p_hasilproduksi/produksi', 'Inventory\PenerimaanBrgProdController@produksi');
    Route::get('/inventory/stockopname/opname', 'Inventory\OpnameGdgController@opname');
    Route::get('/inventory/stockopname/tambah_opname', 'Inventory\OpnameGdgController@tambah_opname');
    Route::get('/inventory/p_returncustomer/cust', 'Inventory\InventoryController@cust');
    Route::get('/inventory/p_hasilproduksi/cari_nota', 'Inventory\InventoryController@cari_nota_produksi');
    Route::get('/inventory/p_returncustomer/cari_nota', 'Inventory\InventoryController@cari_nota_cust');
    /*End Inventory*/
    //mahmud stock opname
    Route::get('/inventory/stockopname/opname', 'Inventory\stockOpnameController@index');
    Route::get('/inventory/namaitem/autocomplite/{x}/{y}', 'Inventory\stockOpnameController@tableOpname');
    Route::get('/inventory/namaitem/simpanopname', 'Inventory\stockOpnameController@saveOpname');
    Route::get('/inventory/namaitem/history/{tgl1}/{tgl2}', 'Inventory\stockOpnameController@history');
    Route::get('/inventory/namaitem/detail', 'Inventory\stockOpnameController@getOPname');
    //mahmud stock gudang
    Route::get('/inventory/datagudang/gudang', 'Inventory\stockGudangController@index');
    Route::get('/inventory/namaitem/tablegudang/{x}/{y}', 'Inventory\stockGudangController@tableGudang');
// Ari
    Route::get('/inventory/POSgrosir/print_setuju/{id}', 'transferItemGrosirController@print_setuju');
    Route::get('/inventory/POSgrosir/print_transfer/{id}', 'transferItemGrosirController@print_transfer');

// End irA
//rizky
//barang_digunakan
    Route::get('/inventory/b_digunakan/barang', 'Inventory\PemakaianBrgGdgController@barang');
    Route::get('/inventory/b_digunakan/get-pemakaian-by-tgl/{tgl1}/{tgl2}', 'Inventory\PemakaianBrgGdgController@getPemakaianByTgl');
    Route::get('/inventory/b_digunakan/lookup-data-gudang', 'Inventory\PemakaianBrgGdgController@lookupDataGudang');
    Route::get('/inventory/b_digunakan/autocomplete-barang', 'Inventory\PemakaianBrgGdgController@autocompleteBarang');
    Route::post('/inventory/b_digunakan/simpan-data-pakai', 'Inventory\PemakaianBrgGdgController@simpanDataPakai');
    Route::get('/inventory/b_digunakan/get-detail/{id}', 'Inventory\PemakaianBrgGdgController@getDataDetail');
    Route::post('/inventory/b_digunakan/update-data-pakai', 'Inventory\PemakaianBrgGdgController@updateDataPakai');
    Route::post('/inventory/b_digunakan/delete-data-pakai', 'Inventory\PemakaianBrgGdgController@deleteDataPakai');
    Route::get('/inventory/b_digunakan/print/{id}', 'Inventory\PemakaianBrgGdgController@printSuratJalan');
    Route::get('/inventory/b_digunakan/get-history-by-tgl/{tgl1}/{tgl2}/{tampil}', 'Inventory\PemakaianBrgGdgController@getHistoryByTgl');
//barang_rusak
    Route::get('/inventory/b_rusak/index', 'Inventory\BarangRusakController@index');
    Route::get('/inventory/b_rusak/get-brg-rusak-by-tgl/{tgl1}/{tgl2}', 'Inventory\BarangRusakController@getBrgRusakByTgl');
    Route::get('/inventory/b_rusak/lookup-data-gudang', 'Inventory\BarangRusakController@lookupDataGudang');
    Route::get('/inventory/b_rusak/autocomplete-barang', 'Inventory\BarangRusakController@autocompleteBarang');
    Route::post('/inventory/b_rusak/simpan-data-rusak', 'Inventory\BarangRusakController@simpanDataRusak');
    Route::get('/inventory/b_rusak/get-detail/{id}', 'Inventory\BarangRusakController@detailBrgRusak');
    Route::get('/inventory/b_rusak/print/{id}', 'Inventory\BarangRusakController@printTandaTerimaRusak');
    Route::post('/inventory/b_rusak/musnahkan-barang-rusak', 'Inventory\BarangRusakController@musnahkanBrgRusak');
    Route::post('/inventory/b_rusak/kembalikan-barang-rusak', 'Inventory\BarangRusakController@kembalikanBrgRusak');
    Route::get('/inventory/b_rusak/get-brg-musnah-by-tgl/{tgl1}/{tgl2}', 'Inventory\BarangRusakController@getBrgMusnahByTgl');
    Route::post('/inventory/b_rusak/simpan-ubah-jenis', 'Inventory\BarangRusakController@simpanUbahJenis');
    Route::post('/inventory/b_rusak/proses-ubah-jenis', 'Inventory\BarangRusakController@prosesUbahJenis');
    Route::get('/inventory/b_rusak/get-brg-ubahjenis-by-tgl/{tgl1}/{tgl2}', 'Inventory\BarangRusakController@getBrgUbahJenisByTgl');
    Route::get('/inventory/b_rusak/get-detail-ubahjenis/{id}', 'Inventory\BarangRusakController@detailBrgUbahJenis');
    Route::post('/inventory/b_rusak/hapus-data-ubahjenis', 'Inventory\BarangRusakController@hapusDataUbah');
//p_hasilproduksi
    Route::get('/inventory/p_hasilproduksi/produksi', 'Inventory\PenerimaanBrgProdController@produksi');
    Route::get('/inventory/p_hasilproduksi/get_data_sj', 'Inventory\PenerimaanBrgProdController@get_data_sj');
    Route::get('/inventory/p_hasilproduksi/list_sj', 'Inventory\PenerimaanBrgProdController@list_sj');
    Route::get('/inventory/p_hasilproduksi/terima_hasil_produksi/{id}/{id2}', 'Inventory\PenerimaanBrgProdController@terima_hasil_produksi');
    Route::get('/inventory/p_hasilproduksi/edit_hasil_produksi/{id}/{id2}', 'Inventory\PenerimaanBrgProdController@edit_hasil_produksi');
    Route::post('/inventory/p_hasilproduksi/simpan_update_data', 'Inventory\PenerimaanBrgProdController@simpan_update_data');
// Route::post('/inventory/p_hasilproduksi/update_data', 'Inventory\PenerimaanBrgProdController@update_data');
    Route::get('/inventory/p_hasilproduksi/get_tabel_data/{id}', 'Inventory\PenerimaanBrgProdController@get_tabel_data');
    Route::get('/inventory/p_hasilproduksi/ubah_status_transaksi/{id}/{id2}', 'Inventory\PenerimaanBrgProdController@ubah_status_transaksi');
    Route::get('/inventory/p_hasilproduksi/get_penerimaan_by_tgl/{tgl1}/{tgl2}/{akses}', 'Inventory\PenerimaanBrgProdController@get_penerimaan_by_tgl');
    Route::get('/inventory/p_hasilproduksi/get_list_waiting_by_tgl/{tgl1}/{tgl2}', 'Inventory\PenerimaanBrgProdController@get_list_waiting_by_tgl');
//p_hasilsupplier
    Route::get('/inventory/p_suplier/suplier', 'Inventory\PenerimaanBrgSupController@suplier');
    Route::get('/inventory/p_suplier/lookup-data-pembelian', 'Inventory\PenerimaanBrgSupController@lookupDataPembelian');
    Route::get('/inventory/p_suplier/get-data-form/{id}', 'Inventory\PenerimaanBrgSupController@getDataForm');
    Route::post('/inventory/p_suplier/simpan-penerimaan', 'Inventory\PenerimaanBrgSupController@simpanPenerimaan');
    Route::get('/inventory/p_suplier/get-datatable-index', 'Inventory\PenerimaanBrgSupController@getDatatableIndex');
    Route::get('/inventory/p_suplier/get-detail-penerimaan/{id}', 'Inventory\PenerimaanBrgSupController@getDataDetail');
    Route::post('/inventory/p_suplier/delete-data-penerimaan', 'Inventory\PenerimaanBrgSupController@deletePenerimaan');
    Route::get('/inventory/p_suplier/get_tabel_data/{id}', 'Inventory\PenerimaanBrgSupController@get_tabel_data');
    Route::get('/inventory/p_suplier/get-list-waiting-bytgl/{tgl1}/{tgl2}', 'Inventory\PenerimaanBrgSupController@getListWaitingByTgl');
    Route::get('/inventory/p_suplier/get-list-received-bytgl/{tgl1}/{tgl2}', 'Inventory\PenerimaanBrgSupController@getListReceivedByTgl');
    Route::get('/inventory/p_suplier/get-penerimaan-peritem/{id}', 'Inventory\PenerimaanBrgSupController@getPenerimaanPeritem');
    Route::get('/inventory/p_suplier/create_suplier', 'Inventory\penerimaanbarang_supController@create_suplier');
    Route::get('/inventory/p_suplier/save_pensuplier', 'Inventory\penerimaanbarang_supController@save_pensuplier')->name('save_pensuplier');
    Route::get('/inventory/p_suplier/edit_pensuplier', 'Inventory\penerimaanbarang_supController@edit_pensuplier')->name('edit_pensuplier');
    Route::get('/inventory/p_suplier/cari_nota', 'Inventory\penerimaanbarang_supController@cari_nota_sup');
    Route::get('/inventory/p_suplier/get_data_po', 'Inventory\PenerimaanBrgSupController@get_data_po');
    Route::get('/inventory/p_suplier/list_po', 'Inventory\PenerimaanBrgSupController@list_po');
    Route::get('/inventory/p_suplier/get-penerimaan-by-tgl/{tgl1}/{tgl2}', 'Inventory\PenerimaanBrgSupController@getPenerimaanByTgl');
// Ari
    Route::get('/inventory/p_suplier/print/{id}', 'Inventory\PenerimaanBrgSupController@print');
// irA
//p_returnsupplier
    Route::get('/inventory/p_returnsupplier/index', 'Inventory\PenerimaanRtrSupController@index');
    Route::get('/inventory/p_returnsupplier/lookup-data-return', 'Inventory\PenerimaanRtrSupController@lookupDataReturn');
    Route::get('/inventory/p_returnsupplier/get-data-form/{id}', 'Inventory\PenerimaanRtrSupController@getDataForm');
    Route::post('/inventory/p_returnsupplier/simpan-penerimaan', 'Inventory\PenerimaanRtrSupController@simpanPenerimaan');
    Route::get('/inventory/p_returnsupplier/get-datatable-index', 'Inventory\PenerimaanRtrSupController@getDatatableIndex');
    Route::get('/inventory/p_returnsupplier/get-detail-penerimaan/{id}', 'Inventory\PenerimaanRtrSupController@getDataDetail');
    Route::post('/inventory/p_returnsupplier/delete-data-penerimaan', 'Inventory\PenerimaanRtrSupController@deletePenerimaan');
    Route::get('/inventory/p_returnsupplier/get-list-waiting-bytgl/{tgl1}/{tgl2}', 'Inventory\PenerimaanRtrSupController@getListWaitingByTgl');
    Route::get('/inventory/p_returnsupplier/get-list-received-bytgl/{tgl1}/{tgl2}', 'Inventory\PenerimaanRtrSupController@getListReceivedByTgl');
    Route::get('/inventory/p_returnsupplier/get-penerimaan-peritem/{id}', 'Inventory\PenerimaanRtrSupController@getPenerimaanPeritem');
    Route::get('/inventory/p_returnsupplier/print/{id}', 'Inventory\PenerimaanRtrSupController@printTandaTerima');
    Route::get('/inventory/p_returnsupplier/get-terimaretur-by-tgl/{tgl1}/{tgl2}', 'Inventory\PenerimaanRtrSupController@getTerimaRtrByTgl');
//end rizky
    /*End Inventory*/
    /*Produksi*/
    Route::get('/produksi/spk/spk', 'ProduksiController@spk');
    Route::get('/produksi/bahanbaku/baku', 'ProduksiController@baku');
    Route::get('/produksi/sdm/sdm', 'ProduksiController@sdm');
    Route::get('/produksi/produksi/produksi2', 'ProduksiController@produksi2');
    Route::get('/produksi/waste/waste', 'ProduksiController@waste');
    Route::get('/produksi/o_produksi/tambah_produksi', 'ProduksiController@tambah_produksi');
//rizky
    Route::get('/produksi/spk/spk', 'Produksi\spkProductionController@spk');
    Route::get('/produksi/spk/ubah-status-spk/{id}', 'Produksi\spkProductionController@ubahStatusSpk');
    Route::get('/produksi/spk/get_spk_by_tgl/{tgl1}/{tgl2}/{stat}', 'Produksi\spkProductionController@getSpkByTgl');
//rizky
//mahmud
    Route::get('produksi/spk/lihat-detail', 'Produksi\spkProductionController@lihatFormula');
    Route::get('produksi/spk/input-data', 'Produksi\spkProductionController@inputData');
    Route::get('/produksi/o_produksi/save/actual/{id}', 'Produksi\spkProductionController@saveActual');
//mahmud
    Route::get('/produksi/o_produksi/index', 'Produksi\ManOutputProduksiController@OutputProduksi');
    Route::get('/produksi/o_produksi/tabel', 'Produksi\ManOutputProduksiController@tabel');
    Route::get('/produksi/o_produksi/store', 'Produksi\ManOutputProduksiController@store');
    Route::get('/produksi/o_produksi/getdata/tabel', 'Produksi\ManOutputProduksiController@tabelDetail');
    Route::get('/produksi/o_produksi/getdata/tabel/kirim', 'Produksi\ManOutputProduksiController@tabelDetailKirim');
    Route::get('/produksi/o_produksi/getdata/{x}', 'Produksi\ManOutputProduksiController@detail');
    Route::get('/produksi/o_produksi/getdata/kirim/{y}', 'Produksi\ManOutputProduksiController@detailKirim');
    Route::get('/produksi/o_produksi/distroy/{id1}/{id2}', 'Produksi\ManOutputProduksiController@distroy');
    Route::get('/produksi/o_produksi/sending/{id1}/{id2}', 'Produksi\ManOutputProduksiController@sending');
    Route::get('/produksi/o_produksi/edit/{id1}/{id2}', 'Produksi\ManOutputProduksiController@edit');
    Route::get('/produksi/o_produksi/lihat/tabelhasil', 'Produksi\ManOutputProduksiController@tabelHasil');
    Route::get('/produksi/o_produksi/select2/spk/{tgl1}', 'Produksi\ManOutputProduksiController@setSpk');
    Route::get('/produksi/o_produksi/select2/pilihspk/{x}', 'Produksi\ManOutputProduksiController@selectDataSpk');
    Route::get('/produksi/o_produksi/save', 'Produksi\ManOutputProduksiController@editQty');
//Pembuatan Surat Jalan
    Route::get('/produksi/suratjalan/index', 'Produksi\PengambilanItemController@SuratJalan');
    Route::get('/produksi/suratjalan/create/delivery', 'Produksi\PengambilanItemController@tabelDelivery');
    Route::get('/produksi/suratjalan/save', 'Produksi\PengambilanItemController@store');
    Route::get('/produksi/pengambilanitem/kirim/tabel/{tgl1}/{tgl2}', 'Produksi\PengambilanItemController@tabelKirim');
    Route::get('/produksi/pengambilanitem/cari/tabel/{tgl1}/{tgl2}', 'Produksi\PengambilanItemController@cariTabelKirim');
    Route::get('/produksi/pengambilanitem/itemkirim/tabel/{id}', 'Produksi\PengambilanItemController@itemTabelKirim');
    Route::get('/produksi/pengambilanitem/lihat/id', 'Produksi\PengambilanItemController@orderId');
// Ari
    Route::get('/produksi/suratjalan/print', 'Produksi\PengambilanItemController@print');
// irA
//mas shomad
// Ari
    Route::get('/produksi/suratjalan/print', 'Produksi\PengambilanItemController@print');
// irA
    /* Monitoring */
    Route::get('/produksi/monitoringprogress/monitoring', 'Produksi\MonitoringProgressController@monitoring');
    Route::get('/produksi/monitoringprogress/tabel', 'Produksi\MonitoringProgressController@tabel');
    Route::get('/produksi/monitoringprogress/plan/{id}', 'Produksi\MonitoringProgressController@plan');
    Route::get('/produksi/monitoringprogress/refresh', 'Produksi\MonitoringProgressController@refresh');
    Route::get('/produksi/monitoringprogress/nota/{id}', 'Produksi\MonitoringProgressController@bukaNota');
    Route::get('/produksi/monitoringprogress/nota/tabel/{id}', 'Produksi\MonitoringProgressController@nota');
    Route::get('/produksi/monitoringprogress/save', 'Produksi\MonitoringProgressController@save');
    /* Rencana Produksi */
    Route::get('/produksi/rencanaproduksi/tabel', 'Produksi\RencanaProduksiController@tabel');
    Route::get('/produksi/rencanaproduksi/produksi', 'Produksi\RencanaProduksiController@produksi');
    Route::get('/produksi/rencanaproduksi/save', 'Produksi\RencanaProduksiController@save');
    Route::get('/produksi/rencanaproduksi/hapus_rencana/{id}', 'Produksi\RencanaProduksiController@hapus_rencana');
    Route::patch('/produksi/rencanaproduksi/produksi/edit_rencana', 'Produksi\RencanaProduksiController@edit_rencana');
    Route::get('/produksi/rencanaproduksi/produksi/autocomplete', 'Produksi\RencanaProduksiController@autocomplete');
//finish mas shomad
//Manajemen Harga 'Mahmud'
    Route::get('/penjualan/manajemenharga/tabelharga', 'Penjualan\ManajemenHargaController@tabelHarga');
    Route::get('/penjualan/manajemenharga/edit/mpsell/{id}', 'Penjualan\ManajemenHargaController@editMpsell');
    Route::post('/penjualan/manajemenharga/update/mpsell', 'Penjualan\ManajemenHargaController@updateMpsell');

//End Manajemen Harga
//Master Formula Mahmud
    Route::get('/master/masterproduksi/index', 'Produksi\MasterFormulaController@index');
    Route::get('/produksi/masterformula/table', 'Produksi\MasterFormulaController@table');
    Route::get('/produksi/masterformula/autocomplete', 'Produksi\MasterFormulaController@autocompFormula');
    Route::get('/produksi/namaitem/autocomplete', 'Produksi\MasterFormulaController@autocompNamaItem');
    Route::post('/produksi/namaitem/save/formula', 'Produksi\MasterFormulaController@saveFormula');
    Route::get('/produksi/namaitem/distroy/formula/{id}', 'Produksi\MasterFormulaController@distroyFormula');
    Route::get('/produksi/namaitem/view/formula', 'Produksi\MasterFormulaController@viewFormula');
    Route::get('/produksi/namaitem/edit/formula', 'Produksi\MasterFormulaController@editFormula');
    Route::post('/produksi/namaitem/update/formula', 'Produksi\MasterFormulaController@updateFormula');
//End Master Formula
    //data actual spk
    Route::get('/produksi/data_actual/tabel/{tgl1}/{tgl2}', 'Produksi\dataActualController@tableActual');
    /*Penjualan*/
    Route::get('/penjualan/manajemenharga/harga', 'PenjualanController@harga');
    Route::get('/penjualan/manajemenharga/tabelharga', 'Penjualan\ManajemenHargaController@tabelHarga');
    Route::get('/penjualan/manajemenpromosi/promosi', 'PenjualanController@promosi');
    Route::get('/penjualan/broadcastpromosi/promosi2', 'PenjualanController@promosi2');
// rencana Penjualan
    Route::get('/penjualan/rencanapenjualan/rencana', 'rencana_penjualan@index');
    Route::get('/penjualan/rencanapenjualan/tambah_rencana', 'rencana_penjualan@tambah_rencana');
    Route::get('/penjualan/rencanapenjualan/datatable_rencana', 'rencana_penjualan@datatable_rencana')->name('datatable_rencana');
    Route::get('/penjualan/rencanapenjualan/datatable_rencana1', 'rencana_penjualan@datatable_rencana1')->name('datatable_rencana1');
    Route::get('/penjualan/rencanapenjualan/datatable_rencana2', 'rencana_penjualan@datatable_rencana2')->name('datatable_rencana2');
    Route::get('/penjualan/rencanapenjualan/save_item', 'rencana_penjualan@save_item');
    Route::get('/penjualan/rencanapenjualan/edit_rencana/{id}', 'rencana_penjualan@edit_rencana');
    Route::get('/penjualan/rencanapenjualan/hapus_rencana/{id}', 'rencana_penjualan@hapus_rencana');
// monitoring penjualan
    Route::get('/penjualan/monitorprogress/progress', 'monitoring_penjualan@progress');
    Route::get('/penjualan/monitorprogress/datatable_progress', 'monitoring_penjualan@datatable_progress')->name('datatable_progress');
    Route::get('/penjualan/monitorprogress/datatable_progress1', 'monitoring_penjualan@datatable_progress1')->name('datatable_progress1');
    Route::get('/penjualan/manajemenreturn/r_penjualan', 'PenjualanController@r_penjualan');
    Route::get('/penjualan/monitoringorder/monitoring', 'PenjualanController@monitoringorder');
    Route::get('/penjualan/mutasistok/mutasi', 'PenjualanController@mutasi');
    Route::get('/penjualan/broadcastpromosi/tambah_promosi2', 'PenjualanController@tambah_promosi2');
//POSRetail
    Route::get('/penjualan/POSretail/index', 'Penjualan\POSRetailController@retail');
    Route::post('/penjualan/POSretail/retail/store', 'Penjualan\POSRetailController@store');
    Route::get('/penjualan/POSretail/retail/autocomplete', 'Penjualan\POSRetailController@autocomplete');
    Route::get('/penjualan/POSretail/retail/setnama/{id}', 'Penjualan\POSRetailController@setnama');
    Route::post('/penjualan/POSretail/retail/sal_save_final', 'Penjualan\POSRetailController@sal_save_final');
    Route::post('/penjualan/POSretail/retail/sal_save_draft', 'Penjualan\POSRetailController@sal_save_draft');
    Route::post('/penjualan/POSretail/retail/sal_save_finalupdate', 'Penjualan\POSRetailController@sal_save_finalUpdate');
    Route::get('/penjualan/POSretail/retail/edit_sales/{id}', 'Penjualan\POSRetailController@edit_sales');
    Route::get('/penjualan/POSretail/retail/distroy/{id}', 'Penjualan\POSRetailController@distroy');
    Route::get('/penjualan/POSretail/retail/autocompleteitem/{tc}', 'Penjualan\POSRetailController@autocompleteitem');
    Route::get('/penjualan/POSretail/retail/transfer-item', 'Penjualan\stockController@transferItem');
    Route::get('/penjualan/POSretail/retail/item_save', 'Penjualan\POSRetailController@item_save');
    Route::get('/penjualan/POSretail/getdata', 'Penjualan\POSRetailController@detail');
    Route::get('/penjualan/POSretail/getdataReq', 'Penjualan\POSRetailController@detailReq');
    Route::get('/penjualan/POSretail/retail/simpan-transfer', 'transferItemController@simpanTransfer');
    Route::get('/penjualan/POSretail/get-tanggal/{tgl1}/{tgl2}/{tampil}', 'Penjualan\POSRetailController@getTanggal');
    Route::get('/penjualan/POSretail/get-tanggaljual/{tgl1}/{tgl2}', 'Penjualan\POSRetailController@getTanggalJual');
    Route::get('/pembayaran/POSretail/pay-methode', 'Penjualan\POSRetailController@PayMethode');
    Route::get('/penjualan/POSretail/setbarcode', 'Penjualan\POSRetailController@setBarcode');
    Route::get('/penjualan/POSretail/stock/table-stock', 'Penjualan\stockController@tableStock');
//Nota
    Route::get('/penjualan/POSretail/print/{id}', 'Penjualan\POSRetailController@print');
    Route::get('/penjualan/POSretail/print_surat_jalan/{id}', 'Penjualan\POSRetailController@print_surat_jalan');
    Route::get('/penjualan/print_jangan_dibanting/{id}', 'Penjualan\POSGrosirController@print_awas_barang_panas');
//ferdy
    Route::get('/penjualan/POSgrosir/print/{id}', 'Penjualan\POSGrosirController@print');
    Route::get('/penjualan/POSgrosir/dp/{id}', 'Penjualan\POSGrosirController@printDP');
    Route::get('/penjualan/POSgrosir/print_surat_jalan/{id}', 'Penjualan\POSGrosirController@print_surat_jalan');
//end ferdy
//POSGrosir
    Route::get('/penjualan/POSgrosir/index', 'Penjualan\POSGrosirController@grosir');
    Route::post('/penjualan/POSgrosir/grosir/store', 'Penjualan\POSGrosirController@store');
    Route::get('/penjualan/POSgrosir/grosir/autocomplete', 'Penjualan\POSGrosirController@autocomplete');
    Route::post('/penjualan/POSgrosir/grosir/sal_save_final', 'Penjualan\POSGrosirController@sal_save_final');
    Route::post('/penjualan/POSgrosir/grosir/sal_save_draft', 'Penjualan\POSGrosirController@sal_save_draft');
    Route::post('/penjualan/POSgrosir/grosir/sal_save_onprogres', 'Penjualan\POSGrosirController@sal_save_onProgres');
    Route::post('/penjualan/POSgrosir/grosir/sal_save_finalupdate', 'Penjualan\POSGrosirController@sal_save_finalUpdate');
    Route::post('/penjualan/POSgrosir/grosir/sal_save_onProgresUpdate', 'Penjualan\POSGrosirController@sal_save_onProgresUpdate');
    Route::get('/penjualan/POSgrosir/grosir/create', 'Penjualan\POSGrosirController@create');
    Route::get('/penjualan/POSgrosir/grosir/create_sal', 'Penjualan\POSGrosirController@create_sal');
    Route::get('/penjualan/POSgrosir/grosir/edit_sales/{id}', 'Penjualan\POSGrosirController@edit_sales');
    Route::get('/penjualan/POSgrosir/grosir/distroy/{id}', 'Penjualan\POSGrosirController@distroy');
    Route::put('/penjualan/POSgrosir/grosir/update/{id}', 'Penjualan\POSGrosirController@update');
    Route::get('/penjualan/POSgrosir/grosir/autocompleteitem/{tc}', 'Penjualan\POSGrosirController@autocompleteitem');
    Route::get('/penjualan/POSgrosir/grosir/item_save', 'Penjualan\POSGrosirController@item_save');
    Route::get('/penjualan/POSgrosir/getdata', 'Penjualan\POSGrosirController@detail');
    Route::get('/penjualan/POSgrosir/get-tanggal/{tgl1}/{tgl2}/{tampil}', 'Penjualan\POSGrosirController@getTanggal');
    Route::get('/penjualan/POSgrosir/get-tanggaljual/{tgl1}/{tgl2}', 'Penjualan\POSGrosirController@getTanggalJual');
    Route::get('/pembayaran/POSgrosir/pay-methode', 'Penjualan\POSGrosirController@PayMethode');
    Route::get('/penjualan/POSgrosir/setbarcode', 'Penjualan\POSGrosirController@setBarcode');
    Route::get('/penjualan/POSgrosir/ubahstatus', 'Penjualan\POSGrosirController@statusMove');
    Route::get('/penjualan/POSgrosir/showNote', 'Penjualan\POSGrosirController@showNote');
    Route::get('/pembayaran/POSgrosir/changestatus', 'Penjualan\POSGrosirController@changeStatus');
//thoriq stock penjualan grosir
    Route::get('/penjualan/POSgrosir/stock/table-stock', 'Penjualan\stockGrosirController@tableStock');
//mutasi Stok Mahmud
    Route::get('/penjualan/mutasi/stock/grosir-retail/{tgl1}/{tgl2}', 'Penjualan\mutasiStokController@tableGrosirRetail');
//End Mutasi
//Monitoring Order Mahmud
    Route::get('/penjualan/monitoringorder/tabel', 'Penjualan\MonitoringOrderController@tabel');
    Route::get('/penjualan/monitoringorder/nota/{id}', 'Penjualan\MonitoringOrderController@bukaNota');
    Route::get('/penjualan/monitoringorder/nota/tabel/{id}', 'Penjualan\MonitoringOrderController@nota');
//Laporan Retail
    Route::get('/penjualan/laporanRetail/index', 'Penjualan\LaporanRetailController@index');
    Route::get('/penjualan/laporanRetail/index', 'Penjualan\LaporanRetailController@index');
    Route::get('/penjualan/laporanRetail/get-data-laporan/{tgl1}/{tgl2}', 'Penjualan\LaporanRetailController@getDataLaporan');
//Laporan Grosir
    Route::get('/penjualan/laporanGrosir/index', 'Penjualan\LaporanGrosirController@index');
    Route::get('/penjualan/laporanGrosir/index', 'Penjualan\LaporanGrosirController@index');
    Route::get('/penjualan/laporanGrosir/get-data-laporan/{tgl1}/{tgl2}', 'Penjualan\LaporanGrosirController@getDataLaporan');
// Ari
    Route::get('/penjualan/retail/print_laporan_penjualan/{tgl1}/{tgl2}', 'Penjualan\LaporanRetailController@print_laporan_penjualan');
    Route::get('/penjualan/grosir/print_laporan_penjualan/{tgl1}/{tgl2}', 'Penjualan\LaporanGrosirController@print_laporan_penjualan');
    Route::get('/penjualan/semua/print_laporan_penjualan/{tgl1}/{tgl2}', 'Penjualan\LaporanPenjualanController@print_laporan_penjualan');

    Route::get('/penjualan/laporan_penjualan/get-data-laporan/{tgl1}/{tgl2}', 'Penjualan\LaporanPenjualanController@get_data');
    Route::get('/penjualan/laporan_penjualan/laporan_penjualan', 'Penjualan\LaporanPenjualanController@laporan_penjualan');

    Route::get('/penjualan/laporan_retail/get_data_laporan_draft/{tgl1}/{tgl2}', 'Penjualan\LaporanRetailController@getDataLaporanDraft');
    Route::get('/penjualan/laporan_grosir/get_data_laporan_draft/{tgl1}/{tgl2}', 'Penjualan\LaporanGrosirController@getDataLaporanDraft');

// End irA
//Return Penjualan Mahmud
    Route::get('/penjualan/returnpenjualan/tabel', 'Penjualan\ManajemenReturnPenjualanController@tabel');
    Route::get('/penjualan/returnpenjualan/tambahreturn', 'Penjualan\ManajemenReturnPenjualanController@newreturn');
    Route::get('/penjualan/returnpenjualan/carinota', 'Penjualan\ManajemenReturnPenjualanController@cariNotaSales');
    Route::get('/penjualan/returnpenjualan/get-data/{id}', 'Penjualan\ManajemenReturnPenjualanController@getNota');
    Route::get('/penjualan/returnpenjualan/tabelpnota/{id}', 'Penjualan\ManajemenReturnPenjualanController@tabelPotNota');
//End
/*HRD*/
    Route::get('/hrd/manajemenkpipegawai/kpi', 'HrdController@kpi');
    Route::get('/hrd/payroll/table', 'HrdController@table');
    Route::get('/hrd/datajabatan/edit_jabatan', 'HrdController@edit_jabatan');
    Route::get('/hrd/dataadministrasi/admin', 'HrdController@admin');
    Route::get('/hrd/datalembur/lembur', 'HrdController@lembur');
    Route::get('/hrd/scoreboard/score', 'HrdController@score');
    Route::get('/hrd/training/training', 'HrdController@training');
/*Recruitment*/
    Route::get('/hrd/recruitment/rekrut', 'HrdController@rekrut')->name('rekrut');
    Route::get('/hrd/recruitment/get-data-hrd', 'RecruitmentController@getDataHrd');
    Route::get('/hrd/recruitment/process_rekrut/{id}', 'RecruitmentController@process_rekrut');
    Route::get('/hrd/recruitment/preview_rekrut/{id}', 'RecruitmentController@preview_rekrut');
    Route::post('/hrd/recruitment/approval_1', 'RecruitmentController@approval_1');
    Route::post('/hrd/recruitment/update_approval_1', 'RecruitmentController@update_approval_1');
    Route::post('/hrd/recruitment/approval_2', 'RecruitmentController@approval_2');
    Route::post('/hrd/recruitment/update_approval_2', 'RecruitmentController@update_approval_2');
    Route::post('/hrd/recruitment/approval_3', 'RecruitmentController@approval_3');
//Master Data Lowongan
    Route::get('/master/datalowongan/index', 'Master\LowonganController@index');
    Route::get('/master/datalowongan/datatable-index', 'Master\LowonganController@get_datatable_index');
    Route::get('/master/datalowongan/tambah_lowongan', 'master\LowonganController@tambah_data');
    Route::post('/master/datalowongan/simpan_lowongan', 'master\LowonganController@simpan_data');
    Route::post('/master/datalowongan/ubah_status', 'master\LowonganController@ubah_status');
    Route::get('/master/datalowongan/edit_lowongan', 'master\LowonganController@edit_data');
    Route::post('/master/datalowongan/update_lowongan', 'master\LowonganController@update_data');

    /*Keuangan*/
        // Transaksi Kas

            Route::get('/keuangan/p_inputtransaksi/transaksi_kas', 'Keuangan\Transaksi\transaksi_kas_controller@index');
            Route::get('/keuangan/p_inputtransaksi/transaksi_kas/form-resource', [
                'uses'   => 'Keuangan\Transaksi\transaksi_kas_controller@form_resource',
                'as'    => 'transaksi_kas.form_resource'
            ]);
            Route::get('/keuangan/p_inputtransaksi/transaksi_kas/list_transaksi', [
                'uses'   => 'Keuangan\Transaksi\transaksi_kas_controller@list_transaksi',
                'as'    => 'transaksi_kas.list_transaksi'
            ]);
            Route::post('/keuangan/p_inputtransaksi/transaksi_kas/save', [
                'uses'   => 'Keuangan\Transaksi\transaksi_kas_controller@save',
                'as'    => 'transaksi_kas.save'
            ]);
            Route::post('/keuangan/p_inputtransaksi/transaksi_kas/update', [
                'uses'   => 'Keuangan\Transaksi\transaksi_kas_controller@update',
                'as'    => 'transaksi_kas.update'
            ]);
            Route::post('/keuangan/p_inputtransaksi/transaksi_kas/delete', [
                'uses'   => 'Keuangan\Transaksi\transaksi_kas_controller@delete',
                'as'    => 'transaksi_kas.delete'
            ]);


        // End Transaksi Kas


    Route::get('/keuangan/l_hutangpiutang/hutang', 'Keuangan\KeuanganController@hutang');
    Route::get('/keuangan/l_jurnal/jurnal', 'Keuangan\KeuanganController@jurnal');
    Route::get('/keuangan/analisaprogress/analisa', 'Keuangan\KeuanganController@analisa');
    Route::get('/keuangan/analisaocf/analisa2', 'Keuangan\KeuanganController@analisa2');
    Route::get('/keuangan/analisaaset/analisa3', 'Keuangan\KeuanganController@analisa3');
    Route::get('/keuangan/analisacashflow/analisa4', 'Keuangan\KeuanganController@analisa4');
    Route::get('/keuangan/analisaindex/analisa5', 'Keuangan\KeuanganController@analisa5');
    Route::get('/keuangan/analisarasio/analisa6', 'Keuangan\KeuanganController@analisa6');
    Route::get('/keuangan/analisabottom/analisa7', 'Keuangan\KeuanganController@analisa7');
    Route::get('/keuangan/analisaroe/analisa8', 'Keuangan\KeuanganController@analisa8');
    Route::get('/keuangan/spk/create-id', 'Keuangan\spkFinancialController@spkCreateId');
    Route::get('/keuangan/spk/data-produc-plan', 'Keuangan\spkFinancialController@productplan');
    Route::get('/produksi/spk/final/simpan-spk', 'Keuangan\spkFinancialController@simpanSpk');
    Route::get('/produksi/spk/draft/simpan-spk', 'Keuangan\spkFinancialController@simpanDraftSpk');
    Route::get('/produksi/spk/edit/{id}', 'Keuangan\spkFinancialController@editSpk');
    Route::get('/keuangan/spk/lihat-detail', 'Keuangan\spkFinancialController@detailSpk');
    Route::get('/keuangan/spk/update-status/{id}', 'Keuangan\spkFinancialController@updateStatus');
// rizky
    Route::get('/keuangan/p_hasilproduksi/pembatalanPenerimaan', 'Keuangan\KeuanganController@pembatalanPenerimaan');
    Route::get('/keuangan/p_hasilproduksi/ubah_status_transaksi/{id}/{id2}', 'Keuangan\KeuanganController@ubahStatusTransaksi');
    Route::get('/keuangan/p_hasilproduksi/get_penerimaan_by_tgl/{tgl1}/{tgl2}', 'Keuangan\KeuanganController@getPenerimaanByTgl');
    Route::get('/keuangan/spk/spk', 'Keuangan\spkFinancialController@spk');
    Route::get('/keuangan/spk/get-data-tabel-index', 'Keuangan\spkFinancialController@getDataTabelIndex');
    Route::get('/keuangan/spk/get-data-tabel-spk/{tgl1}/{tgl2}/{tampil}', 'Keuangan\spkFinancialController@getDataTabelSpk');
    Route::get('/keuangan/spk/ubah-status-spk/{id}', 'Keuangan\spkFinancialController@ubahStatusSpk');
    Route::get('/keuangan/spk/get-data-spk-byid/{id}', 'Keuangan\spkFinancialController@getDataSpkById');
//konfirmasi pembelian
    Route::get('/keuangan/konfirmasipembelian/konfirmasi-purchase', 'Keuangan\ConfrimBeliController@confirmPurchasePlanIndex');
    Route::get('/keuangan/konfirmasipembelian/get-data-tabel-daftar', 'Keuangan\ConfrimBeliController@getDataRencanaPembelian');
    Route::get('/keuangan/konfirmasipembelian/confirm-plan/{id}/{type}', 'Keuangan\ConfrimBeliController@confirmRencanaPembelian');
    Route::post('/keuangan/konfirmasipembelian/confirm-plan-submit', 'Keuangan\ConfrimBeliController@submitRencanaPembelian');
    Route::get('/keuangan/konfirmasipembelian/get-data-tabel-order', 'Keuangan\ConfrimBeliController@getDataOrderPembelian');
    Route::get('/keuangan/konfirmasipembelian/confirm-order/{id}/{type}', 'Keuangan\ConfrimBeliController@confirmOrderPembelian');
    Route::post('/keuangan/konfirmasipembelian/confirm-order-submit', 'Keuangan\ConfrimBeliController@submitOrderPembelian');
    Route::get('/keuangan/konfirmasipembelian/get-data-tabel-return', 'Keuangan\ConfrimBeliController@getDataReturnPembelian');
    Route::get('/keuangan/konfirmasipembelian/confirm-return/{id}/{type}', 'Keuangan\ConfrimBeliController@confirmReturnPembelian');
    Route::post('/keuangan/konfirmasipembelian/confirm-return-submit', 'Keuangan\ConfrimBeliController@submitReturnPembelian');
//10-07-18
    Route::get('/keuangan/konfirmasipembelian/get-data-tabel-belanjaharian', 'Keuangan\ConfrimBeliController@getDataBelanjaHarian');
    Route::get('/keuangan/konfirmasipembelian/confirm-belanjaharian/{id}/{type}', 'Keuangan\ConfrimBeliController@confirmBelanjaHarian');
    Route::post('/keuangan/konfirmasipembelian/confirm-belanjaharian-submit', 'Keuangan\ConfrimBeliController@submitBelanjaHarian');
//hutang piutang
    Route::get('/keuangan/l_hutangpiutang/hutang', 'Keuangan\HutangController@hutang');
    Route::get('/keuangan/l_hutangpiutang/get_hutang_by_tgl/{tgl1}/{tgl2}', 'Keuangan\HutangController@getHutangByTgl');
    Route::get('/keuangan/l_hutangpiutang/get_detail_hutangbeli/{id}', 'Keuangan\HutangController@getDetailHutangBeli');
// end rizky
//mahmud
    Route::get('/produksi/lihatadonan/tabel/{id}/{qty}', 'Keuangan\spkFinancialController@tabelFormula');
//endmahmud
//thoriq
    /*System*/
    Route::get('/system/hakuser/user', 'ManUser\aksesUserController@indexAksesUser');
    Route::get('/system/hakuser/tambah_user', 'ManUser\aksesUserController@tambah_user');
    Route::get('/system/hakuser/tambah_user/simpan-user', 'ManUser\aksesUserController@simpanUser');
    Route::get('/system/hakakses/edit-user-akses/{id}/edit', 'ManUser\aksesUserController@editUserAkses');
    Route::get('/system/hakuser/perbarui-user/perbarui-user/{id}', 'ManUser\aksesUserController@perbaruiUser');
    Route::get('/system/hakakses/simpan-user-akses', 'ManUser\aksesUserController@simpanUserAkses');
// hak akses group
    Route::get('/system/hakakses/akses', 'ManAkses\groupAksesController@indexHakAkses');
    Route::get('system/hakakses/hapus-akses-group/edit-Akses-Group/{id}/edit', 'ManAkses\groupAksesController@editAksesGroup');
    Route::get('system/hakakses/perbarui_akses-group/perbarui-group/{id}', 'ManAkses\groupAksesController@perbaruiGroup');
    Route::get('system/hakakses/hapus-akses-group/hapus-group/{id}', 'ManAkses\groupAksesController@hapusHakAkses');
    Route::get('/system/hakakses/tambah-akses-group', 'ManAkses\groupAksesController@tambah_akses');
    Route::get('/system/hakakses/tambah_akses-group/simpan-group', 'ManAkses\groupAksesController@simpanGroup');
    Route::get('/system/hakakses/tambah_akses-group/simpan-group-detail', 'ManAkses\groupAksesController@simpanGroupDetail');
//nota Transfer
    Route::get('transfer/no-nota', 'transferItemController@noNota');
//transfer retail
    Route::get('transfer/lihat-penerimaan/datatable', 'transferItemController@transferDatatables');
    Route::get('transfer/list-penerimaan/datatable', 'transferItemController@listDatatables');
    Route::get('transfer/data-transfer/{id}/lihat', 'transferItemController@lihatTransfer');
    Route::get('transfer/data-transfer/hapus/{id}', 'transferItemController@HapusTransfer');
    Route::get('transfer/lihat-penerimaan/{id}', 'transferItemController@lihatPenerimaan');
    Route::get('transfer/lihat-transfer/{id}', 'transferItemController@lihatPenerimaanRc');
    Route::get('transfer/penerimaan/simpa-penerimaan', 'transferItemController@simpaPenerimaan');
    Route::get('/transfer/penerimaan/table_transfer/{tgl1}/{tgl2}/{tampil}', 'transferItemController@dataTransfer');
    Route::get('transfer/penerimaan/terima_transfer/{tgl3}/{tgl4}/{tampil1}', 'transferItemController@dataPenerimaanTransfer');
    Route::get('transfer/data-transfer/{id}/edit', 'transferItemController@editTransfer');
    Route::get('penjualan/POSretail/update-transfer-grosir/{id}', 'transferItemController@updateTransferGrosir');
//transfer selesai
//transfer grosir
    Route::get('transfer/grosir/table_transfer/{tgl1}/{tgl2}/{tampil}', 'transferItemGrosirController@dataTransferAppr');
    Route::get('penjualan/POSgrosir/approve-transfer/{id}/edit', 'transferItemGrosirController@approveTransfer');
    Route::get('penjualan/transfer/grosir/transfer-item', 'Penjualan\stockController@transferItemGrosir');
    Route::get('penjualan/POSgrosir/approve-transfer/simpan-approve', 'transferItemGrosirController@simpanApprove');
    Route::get('transfer/grosir/transfer_retail/{tgl3}/{tgl4}/{tampil1}', 'transferItemGrosirController@dataTransferGrosir');
    Route::get('penjualan/transfer/grosir/simpan-transfer-grosir', 'transferItemGrosirController@simpanTransferGrosir');
    Route::get('penjualan/POSgrosir/edit-transfer-grosir/{id}/edit', 'transferItemGrosirController@EditTransferGrosir');
    Route::get('penjualan/POSgrosir/update-transfer-grosir/{id}', 'transferItemGrosirController@updateTransferGrosir');
    Route::get('penjualan/POSgrosir/hapus-transfer-grosir/hapus/{id}', 'transferItemGrosirController@HapusTransferGrosir');
    Route::get('coba', 'transferItemController@data');
//transfer selesai
// Create spk Production
    Route::get('/produksi/spk/spk', 'Produksi\spkProductionController@spk');
    Route::get('/produksi/spk/tabelspk', 'Produksi\spkProductionController@tabelSpk');
    Route::get('/produksi/spk/spk', 'Produksi\spkProductionController@spk');
    Route::get('/produksi/spk/create-id/{x}', 'Produksi\spkProductionController@spkCreateId');
    Route::get('/produksi/spk/data-produc-plan', 'Produksi\spkProductionController@productplan');
    Route::get('/produksi/spk/cari-data-plan', 'Produksi\spkProductionController@cariDataSpk');
// spk Production Selesai
//Master Data Suplier
    Route::post('master/datasuplier/suplier_proses', 'Master\SuplierController@suplier_proses');
    Route::get('/master/datasuplier/tambah_suplier', 'Master\SuplierController@tambah_suplier');
    Route::get('master/datasuplier/datatable_suplier', 'Master\SuplierController@datatable_suplier')->name('datatable_suplier');
    Route::get('master/datasuplier/suplier_edit/{s_id}', 'Master\SuplierController@suplier_edit');
    Route::post('master/datasuplier/suplier_edit_proses/{s_id}', 'Master\SuplierController@suplier_edit_proses');
    Route::get('master/datasuplier/suplier_hapus', 'Master\SuplierController@suplier_hapus');
//-deny
//customer
    Route::get('/master/datacust/cust', 'master\custController@cust')->name('cust');
    Route::get('/master/datacust/tambah_cust', 'master\custController@tambah_cust')->name('tambah_cust');
    Route::get('/master/datacust/simpan_cust', 'master\custController@simpan_cust')->name('simpan_cust');
    Route::get('/master/datacust/hapus_cust', 'master\custController@hapus_cust')->name('hapus_cust');
    Route::get('/master/datacust/edit_cust', 'master\custController@edit_cust')->name('edit_cust');
    Route::get('/master/datacust/update_cust', 'master\custController@update_cust')->name('update_cust');
    Route::get('/master/datacust/datatable_cust', 'master\custController@datatable_cust')->name('datatable_cust');
//barang
    Route::get('/master/databarang/barang', 'master\barangController@barang')->name('barang');
    Route::get('/master/databarang/tambah_barang', 'master\barangController@tambah_barang');
    Route::post('/master/databarang/simpan_barang', 'master\barangController@simpan_barang')->name('simpan_barang');
    Route::post('/master/databarang/ubah_status_barang', 'master\barangController@ubah_status')->name('ubah_status');
    Route::get('/master/databarang/edit_barang', 'master\barangController@edit_barang')->name('edit_barang');
    Route::post('/master/databarang/update_barang', 'master\barangController@update_barang')->name('update_barang');
    Route::get('/master/databarang/datatable_barang', 'master\barangController@datatable_barang')->name('datatable_barang');
    Route::get('/master/databarang/kode_barang', 'master\barangController@kode_barang')->name('kode_barang');
    Route::get('/master/databarang/cari_group_barang', 'master\barangController@cari_group_barang')->name('cari_group_barang');
//itemproduksi mahmud
    Route::get('/master/itemproduksi/index', 'Master\itemProduksiController@index');
    Route::get('/master/tableproduksi/table', 'Master\itemProduksiController@tableProduksi');
    Route::get('/master/itemproduksi/tambah_item', 'Master\itemProduksiController@tambahItem');
    Route::post('/master/itemproduksi/simpan_item', 'Master\itemProduksiController@simpanItem');
    Route::get('/master/itemproduksi/ubah_status/{a}', 'Master\itemProduksiController@ubahStatus');
    Route::get('/master/itemproduksi/edit_item/{a}', 'Master\itemProduksiController@editBarang');
    Route::get('/master/itemproduksi/update_item/{a}', 'Master\itemProduksiController@updateItem');
//bahan baku
    Route::get('/master/databaku/baku', 'master\bahan_bakuController@baku')->name('baku');
    Route::get('/master/databaku/tambah_baku', 'master\bahan_bakuController@tambah_baku')->name('tambah_baku');
    Route::get('/master/databaku/simpan_baku', 'master\bahan_bakuController@simpan_baku')->name('simpan_baku');
    Route::get('/master/databaku/hapus_baku', 'master\bahan_bakuController@hapus_baku')->name('hapus_baku');
    Route::get('/master/databaku/edit_baku', 'master\bahan_bakuController@edit_baku')->name('edit_baku');
    Route::get('/master/databaku/update_baku', 'master\bahan_bakuController@update_baku')->name('update_baku');
    Route::get('/master/databaku/datatable_baku', 'master\bahan_bakuController@datatable_baku')->name('datatable_baku');
//jenis produksi
    Route::get('/master/datajenis/jenis', 'Master\jenis_produksiController@jenis')->name('jenis');
    Route::get('/master/datajenis/tambah_jenis', 'Master\jenis_produksiController@tambah_jenis')->name('tambah_jenis');
    Route::get('/master/datajenis/simpan_jenis', 'Master\jenis_produksiController@simpan_jenis')->name('simpan_jenis');
    Route::get('/master/datajenis/hapus_jenis', 'Master\jenis_produksiController@hapus_jenis')->name('hapus_jenis');
    Route::get('/master/datajenis/edit_jenis', 'Master\jenis_produksiController@edit_jenis')->name('edit_jenis');
    Route::get('/master/datajenis/update_jenis', 'Master\jenis_produksiController@update_jenis')->name('update_jenis');
    Route::get('/master/datajenis/datatable_jenis', 'Master\jenis_produksiController@datatable_jenis')->name('datatable_jenis');
//satuan
    Route::get('/master/datasatuan/satuan', 'master\satuanController@satuan')->name('satuan');
    Route::get('/master/datasatuan/tambah_satuan', 'master\satuanController@tambah_satuan')->name('tambah_satuan');
    Route::get('/master/datasatuan/simpan_satuan', 'master\satuanController@simpan_satuan')->name('simpan_satuan');
    Route::get('/master/datasatuan/hapus_satuan', 'master\satuanController@hapus_satuan')->name('hapus_satuan');
    Route::get('/master/datasatuan/edit_satuan', 'master\satuanController@edit_satuan')->name('edit_satuan');
    Route::get('/master/datasatuan/update_satuan', 'master\satuanController@update_satuan')->name('update_satuan');
    Route::get('/master/datasatuan/datatable_satuan', 'master\satuanController@datatable_satuan')->name('datatable_satuan');
//group
    Route::get('/master/datagroup/group', 'master\groupController@group')->name('group');
    Route::get('/master/datagroup/tambah_group', 'master\groupController@tambah_group')->name('tambah_group');
    Route::get('/master/datagroup/simpan_group', 'master\groupController@simpan_group')->name('simpan_group');
    Route::get('/master/datagroup/hapus_group', 'master\groupController@hapus_group')->name('hapus_group');
    Route::get('/master/datagroup/edit_group', 'master\groupController@edit_group')->name('edit_group');
    Route::get('/master/datagroup/update_group', 'master\groupController@update_group')->name('update_group');
    Route::get('/master/datagroup/datatable_group', 'master\groupController@datatable_group')->name('datatable_group');
//-[]-belum-[]-//
// route Keuangan (Dirga)
// akun keuangan route
    Route::get('/master/datakeuangan/keuangan', 'Keuangan\akunController@index');
    Route::get('/master/datakeuangan/datatable_akun', 'Keuangan\akunController@datatable_akun')->name('datatable_akun');
    Route::get('/master/datakeuangan/tambah_akun', 'Keuangan\akunController@tambah_akun')->name('tambah_akun');
    Route::post('/master/datakeuangan/simpan', 'Keuangan\akunController@save_akun')->name('simpan_akun');
    Route::get('/master/datakeuangan/edit_akun', 'keuangan\akunController@edit_akun')->name('edit_akun');
    Route::post('/master/datakeuangan/update', 'Keuangan\akunController@update_akun')->name('update_akun');
    Route::get('/master/datakeuangan/hapus_akun', 'keuangan\akunController@hapus_akun')->name('hapus_akun');
// akun keuangan route end

// transaksi keuangan
    Route::get('/master/datatransaksi/transaksi', 'Keuangan\transaksiController@index');
    Route::get('/master/datatransaksi/tambah_transaksi', 'Keuangan\transaksiController@tambah_transaksi');
    Route::post('/master/datatransaksi/simpan', 'Keuangan\transaksiController@simpan_transaksi');
    Route::get('/master/datatransaksi/edit', 'Keuangan\transaksiController@edit');
// transaksi keuangan end
// Route Keuangan End

// Ari
    Route::get('/purchasing/orderpembelian/print/{id}', 'Pembelian\OrderPembelianController@print');
    Route::get('/inventory/p_suplier/print/{id}', 'Inventory\PenerimaanBrgSupController@print');
    Route::get('/produksi/spk/print/{spk_id}', 'Produksi\spkProductionController@print')->name('spk_print');
// irA
}); // End Route Groub middleware auth
