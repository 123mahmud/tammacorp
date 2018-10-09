<div id="header-topbar-option-demo" class="page-header-topbar">
    <nav id="topbar" role="navigation" style="margin-bottom: 0;" data-step="3"
         class="navbar navbar-default navbar-static-top">
        <div class="navbar-header">
            <button type="button" data-toggle="collapse" data-target=".sidebar-collapse" class="navbar-toggle"><span
                        class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span
                        class="icon-bar"></span><span class="icon-bar"></span></button>
            <a id="logo" href="{{ url('/home') }}" class="navbar-brand"><span class="fa fa-rocket"></span><span
                        class="logo-text">TammaFood</span><span style="display: none;"
                                                                class="logo-text-icon">µ</span></a></div>
        <div class="topbar-main"><a id="menu-toggle" href="#" class="hidden-xs"><i class="fa fa-bars"></i></a>

            <form id="topbar-search" action="" method="" class="hidden-sm hidden-xs">
                <div class="input-icon right text-white">
                    <a href="#" class="hidden" id="btn-reset" onclick="btnReset()"><i class="fa fa-times"></i></a>
                    <input type="text" placeholder="Search Menu.." id="filterInput" onfocus="myFunction()"
                           onchange="myFunction()" onkeyup="myFunction()" class="form-control text-white"/>
                </div>
            </form>
            <div class="news-update-box hidden-xs"><span class="text-uppercase mrm pull-left text-white">News:</span>
            </div>
            <ul class="nav navbar navbar-top-links navbar-right mbn">
                <li class="dropdown"><a data-hover="dropdown" href="#" class="dropdown-toggle"><i
                                class="fa fa-bell fa-fw"></i><span class="badge badge-green">!</span></a>
                    <ul class="dropdown-menu dropdown-user pull-right">
                        <li style="padding-left: 10px;"><h4>Notifikasi</h4></li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="fa fa-warning"></i>Ini Pemberitahuan yang sangat panjang sekali</a>
                        </li>
                        <li><a href="#"><i class="fa fa-check"></i>Ini Pemberitahuan</a></li>
                        <li><a href="#"><i class="fa fa-times"></i>Ini Pemberitahuan</a></li>
                        <li class="divider"></li>
                        <li><a style="font-weight: bold;" href="#">4 Pemberitahuan Baru</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a data-hover="dropdown" href="#" class="dropdown-toggle"><i
                                class="fa fa-envelope fa-fw"></i><span class="badge badge-orange">!</span></a>
                    <ul class="dropdown-menu dropdown-user pull-right">
                        <li style="padding-left: 10px;"><h4>Pesan</h4></li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="fa fa-warning"></i>Ini Pemberitahuan</a></li>
                        <li><a href="#"><i class="fa fa-check"></i>Ini Pemberitahuan</a></li>
                        <li><a href="#"><i class="fa fa-times"></i>Ini Pemberitahuan</a></li>
                        <li class="divider"></li>
                        <li><a style="font-weight: bold;" href="#">5 Pesan Baru</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a data-hover="dropdown" href="#" class="dropdown-toggle"><i
                                class="fa fa-tasks fa-fw"></i><span class="badge badge-blue">!</span></a>
                    <ul class="dropdown-menu dropdown-user pull-right">
                        <li style="padding-left: 10px;"><h4>Tugas</h4></li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="fa fa-warning"></i>Ini Pemberitahuan</a></li>
                        <li><a href="#"><i class="fa fa-check"></i>Ini Pemberitahuan</a></li>
                        <li><a href="#"><i class="fa fa-times"></i>Ini Pemberitahuan</a></li>
                        <li class="divider"></li>
                        <li><a style="font-weight: bold;" href="#">5 Tugas Baru</a></li>
                    </ul>
                </li>
                <li class="dropdown topbar-user"><a data-hover="dropdown" href="#" class="dropdown-toggle"><img
                                src="{{ asset('assets/images/avatar/48.jpg')}}" alt=""
                                class="img-responsive img-circle">&nbsp;<span
                                class="hidden-xs">{{ Auth::user()->m_name }}</span>&nbsp;<span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-user pull-right">
                        <li><a href="#"><i class="fa fa-user"></i>My Profile</a></li>
                        <li><a href="#"><i class="fa fa-calendar"></i>My Calendar</a></li>
                        <li><a href="#"><i class="fa fa-envelope"></i>My Inbox<span class="badge badge-danger">3</span></a>
                        </li>
                        <li><a href="#"><i class="fa fa-tasks"></i>My Tasks<span
                                        class="badge badge-success">7</span></a></li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="fa fa-lock"></i>Lock Screen</a></li>
                        <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i>Log Out</a></li>
                    </ul>
                </li>
                <li id="topbar-chat" class="hidden-xs"><a href="javascript:void(0)" data-step="4"
                                                          data-intro="&lt;b&gt;Form chat&lt;/b&gt; keep you connecting with other coworker"
                                                          data-position="left" class="btn-chat"><i
                                class="fa fa-comments"></i><span class="badge badge-info">3</span></a></li>
            </ul>
        </div>
    </nav>
    <!-- BEGIN CONFIG MODAL PORTLET -->
    <div id="modal-config" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close">
                        &times;
                    </button>
                    <h4 class="modal-title">
                        Modal title</h4>
                </div>
                <div class="modal-body">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eleifend et nisl eget
                        porta. Curabitur elementum sem molestie nisl varius, eget tempus odio molestie.
                        Nunc vehicula sem arcu, eu pulvinar neque cursus ac. Aliquam ultricies lobortis
                        magna et aliquam. Vestibulum egestas eu urna sed ultricies. Nullam pulvinar dolor
                        vitae quam dictum condimentum. Integer a sodales elit, eu pulvinar leo. Nunc nec
                        aliquam nisi, a mollis neque. Ut vel felis quis tellus hendrerit placerat. Vivamus
                        vel nisl non magna feugiat dignissim sed ut nibh. Nulla elementum, est a pretium
                        hendrerit, arcu risus luctus augue, mattis aliquet orci ligula eget massa. Sed ut
                        ultricies felis.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="common-modal modal fade" id="common-Modal1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content">
            <ul class="list-inline item-details">
                <li><a href="http://themifycloud.com">Admin templates</a></li>
                <li><a href="http://themescloud.org">Bootstrap themes</a></li>
            </ul>
        </div>
    </div>
    <!-- END MODAL CONFIG PORTLET -->
</div>
<!-- END TOPBAR -->
<div id="wrapper">
    <!--BEGIN SIDEBAR MENU-->
    <nav id="sidebar" role="navigation" data-step="2"
         data-intro="Template has &lt;b&gt;many navigation styles&lt;/b&gt;"
         data-position="right" class="navbar-default navbar-static-side">
        <div class="sidebar-collapse menu-scroll">
            <div id='cssmenu'>
                <ul id="side-menu" class="nav">
                    @if(Auth::user()->punyaAkses('Master','ma_read'))
                        <div class="clearfix"></div>
                        <li class="{{Request::is('master') ? 'active' : '' || Request::is('master/*') ? 'active' : '' }}">
                            <a href="#"><i class="fa fa-tachometer fa-fw">
                                    <div class="icon-bg bg-orange"></div>
                                </i>
                                <span class="menu-title">Master</span><span class="fa arrow"></span>

                                <!-- Filter Menu Submenu -->
                                <span class="hidden">
                                    @if(Auth::user()->punyaAkses('Data Supplier','ma_read'))
                                        Data Suplier
                                    @endif

                                    @if(Auth::user()->punyaAkses('Data Customer','ma_read'))
                                        Data Customer
                                    @endif

                                    @if(Auth::user()->punyaAkses('Data Satuan','ma_read'))
                                        Data Satuan
                                    @endif

                                    @if(Auth::user()->punyaAkses('Data Group','ma_read'))
                                        Data Group
                                    @endif

                                    @if(Auth::user()->punyaAkses('Data Jabatan','ma_read'))
                                        Data Jabatan
                                    @endif

                                    @if(Auth::user()->punyaAkses('Data Pegawai','ma_read'))
                                        Data Pegawai
                                    @endif

                                    @if(Auth::user()->punyaAkses('Data Lowongan','ma_read'))
                                        Data Lowongan
                                    @endif

                                    @if(Auth::user()->punyaAkses('Data Scoreboard','ma_read'))
                                        Data Scoreboard
                                    @endif

                                    @if(Auth::user()->punyaAkses('Data KPI','ma_read'))
                                        Data KPI
                                    @endif

                                    @if(Auth::user()->punyaAkses('Data Akun Keuangan','ma_read'))
                                        Data Akun Keuangan
                                    @endif

                                    @if(Auth::user()->punyaAkses('Data Transaksi Keuangan','ma_read'))
                                        Data Transaksi Keuangan
                                    @endif

                                    @if(Auth::user()->punyaAkses('Data Barang','ma_read'))
                                        Data Barang
                                    @endif

                                    @if(Auth::user()->punyaAkses('Data Item Produksi','ma_read'))
                                        Data Item Produksi
                                    @endif

                                    @if(Auth::user()->punyaAkses('Master Formula','ma_read'))
                                        Master Formula
                                    @endif

                            </span>
                                <!-- End Filter Menu Submenu -->
                            </a>
                            <ul class="nav nav-second-level">
                                @if(Auth::user()->punyaAkses('Data Supplier','ma_read'))
                                    <li class="{{ Request::is('master/datasuplier/suplier') ? 'active' : '' || Request::is('master/datasuplier/*') ? 'active' : '' }}">
                                        <a href="{{ url('/master/datasuplier/suplier') }}"><span class="submenu-title">Data Suplier</span><span
                                                    class="hidden">Master</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Data Customer','ma_read'))
                                    <li class="{{ Request::is('master/datacust/cust') ? 'active' : '' || Request::is('master/datacust/*') ? 'active' : '' }}">
                                        <a href="{{ url('/master/datacust/cust') }}"><span class="submenu-title">Data Customer</span><span
                                                    class="hidden">Master</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Data Satuan','ma_read'))
                                    <li class="{{ Request::is('master/datasatuan/satuan') ? 'active' : '' || Request::is('master/datasatuan/*') ? 'active' : '' }}">
                                        <a href="{{ url('/master/datasatuan/satuan') }}"><span class="submenu-title">Data Satuan</span><span
                                                    class="hidden">Master</span></a>
                                @endif

                                @if(Auth::user()->punyaAkses('Data Group','ma_read'))
                                    <li class="{{ Request::is('master/datagroup/group') ? 'active' : '' || Request::is('master/datagroup/*') ? 'active' : '' }}">
                                        <a href="{{ url('/master/datagroup/group') }}"><span class="submenu-title">Data Group</span><span
                                                    class="hidden">Master</span></a>
                                @endif

                                @if(Auth::user()->punyaAkses('Data Jabatan','ma_read'))
                                    <li class="{{ Request::is('master/datajabatan') ? 'active' : '' || Request::is('master/datajabatan/*') ? 'active' : '' }}">
                                        <a href="{{ url('/master/datajabatan')}}">
                                            <span class="submenu-title">Data Jabatan</span>
                                        </a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Data Pegawai','ma_read'))
                                    <li class="{{ Request::is('master/datapegawai/pegawai') ? 'active' : '' || Request::is('master/datapegawai/*') ? 'active' : '' }}">
                                        <a href="{{ url('/master/datapegawai/pegawai') }}"><span class="submenu-title">Data Pegawai</span><span
                                                    class="hidden">Master</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Data Lowongan','ma_read'))
                                    <li class="{{ Request::is('master/datalowongan/index') ? 'active' : '' || Request::is('master/datalowongan/*') ? 'active' : '' }}">
                                        <a href="{{ url('/master/datalowongan/index') }}"><span class="submenu-title">Data Lowongan</span><span
                                                    class="hidden">Master</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Data Scoreboard','ma_read'))
                                    <li class="{{ Request::is('master/datascore/index') ? 'active' : '' || Request::is('master/datascore/*') ? 'active' : '' }}">
                                        <a href="{{ url('/master/datascore/index') }}"><span class="submenu-title">Data Scoreboard</span><span
                                                    class="hidden">Master</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Data KPI','ma_read'))
                                    <li class="{{ Request::is('master/datakpi/index') ? 'active' : '' || Request::is('master/datakpi/*') ? 'active' : '' }}">
                                        <a href="{{ url('/master/datakpi/index') }}"><span class="submenu-title">Data KPI</span><span
                                                    class="hidden">Master</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Data Akun Keuangan','ma_read'))
                                    <li class="{{ Request::is('master/datakeuangan/keuangan') ? 'active' : '' || Request::is('master/datakeuangan/*') ? 'active' : '' }}">
                                        <a href="{{ url('/master/datakeuangan/keuangan') }}"><span
                                                    class="submenu-title">Data Akun Keuangan</span><span class="hidden">Master</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Data Transaksi Keuangan','ma_read'))
                                    <li class="{{ Request::is('master/keuangan/master_transaksi') ? 'active' : '' || Request::is('master/keuangan/master_transaksi/*') ? 'active' : '' }}">
                                        <a href="{{ url('/master/keuangan/master_transaksi') }}"><span
                                                    class="submenu-title">Data Transaksi Keuangan</span><span
                                                    class="hidden">Master</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Data Barang','ma_read'))
                                    <li class="{{ Request::is('master/databarang/barang') ? 'active' : '' || Request::is('master/databarang/*') ? 'active' : '' }}">
                                        <a href="{{ url('/master/databarang/barang') }}"><span class="submenu-title">Data Barang </span><span
                                                    class="hidden">Master</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Data Item Produksi','ma_read'))
                                    <li class="{{ Request::is('master/itemproduksi/index') ? 'active' : '' || Request::is('master/itemproduksi/*') ? 'active' : '' }}">
                                        <a href="{{ url('/master/itemproduksi/index') }}"><span
                                                    class="submenu-title">Data Item Produksi </span><span
                                                    class="hidden">Master</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Master Formula','ma_read'))
                                    <li class="{{ Request::is('master/masterproduksi/index') ? 'active' : '' || Request::is('master/masterproduksi/*') ? 'active' : '' }}">
                                        <a href="{{ url('master/masterproduksi/index') }}"><span
                                                    class="submenu-title">Master Formula</span><span
                                                    class="hidden">Master</span></a>
                                    </li>
                                @endif


                            </ul>
                        </li>
                    @endif
                    @if(Auth::user()->punyaAkses('Purchasing','ma_read'))
                        <div class="clearfix"></div>
                        <li class="{{Request::is('purchasing') ? 'active' : '' || Request::is('purchasing/*') ? 'active' : '' }}">
                            <a href="#"><i class="fa fa-credit-card fa-fw">
                                    <div class="icon-bg bg-green"></div>
                                </i><span class="menu-title">Purchasing</span><span class="fa arrow"></span>
                                <!-- FIlter Menu SUbmenu -->
                                <span class="hidden">

                                @if(Auth::user()->punyaAkses('Rencana Bahan Baku Produksi','ma_read'))
                                        Rencana Bahan Baku Produksi
                                    @endif

                                    @if(Auth::user()->punyaAkses('Rencana Pembelian','ma_read'))
                                        Rencana Pembelian
                                    @endif

                                    @if(Auth::user()->punyaAkses('Order Pembelian','ma_read'))
                                        Order Pembelian
                                    @endif

                                    @if(Auth::user()->punyaAkses('Belanja Harian','ma_read'))
                                        Belanja Harian
                                    @endif

                                    @if(Auth::user()->punyaAkses('Return Pembelian','ma_read'))
                                        Return Pembelian
                                    @endif

                                    @if(Auth::user()->punyaAkses('Pembayaran Hutang','ma_read'))
                                        Pembayaran Hutang
                                    @endif

                            </span>
                                <!-- End Filter Menu Submenu -->
                            </a>
                            <ul class="nav nav-second-level">
                                @if(Auth::user()->punyaAkses('Rencana Bahan Baku Produksi','ma_read'))
                                    <li class="{{ Request::is('purchasing/rencanabahanbaku/bahan') ? 'active' : '' || Request::is('purchasing/rencanabahanbaku/*') ? 'active' : '' }}">
                                        <a href="{{ url('/purchasing/rencanabahanbaku/bahan') }}"><span
                                                    class="submenu-title">Rencana Bahan Baku Produksi</span><span
                                                    class="hidden">Purchasing</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Rencana Pembelian','ma_read'))
                                    <li class="{{ Request::is('purchasing/rencanapembelian/rencana') ? 'active' : '' || Request::is('purchasing/rencanapembelian/*') ? 'active' : '' }}">
                                        <a href="{{ url('/purchasing/rencanapembelian/rencana') }}"><span
                                                    class="submenu-title">Rencana Pembelian</span><span class="hidden">Purchasing</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Order Pembelian','ma_read'))
                                    <li class="{{ Request::is('purchasing/orderpembelian/order') ? 'active' : '' || Request::is('purchasing/orderpembelian/*') ? 'active' : '' }}">
                                        <a href="{{ url('/purchasing/orderpembelian/order') }}"><span
                                                    class="submenu-title">Order Pembelian</span><span class="hidden">Purchasing</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Belanja Harian','ma_read'))
                                    <li class="{{ Request::is('purchasing/belanjaharian/belanja') ? 'active' : '' || Request::is('purchasing/belanjaharian/*') ? 'active' : '' }}">
                                        <a href="{{ url('/purchasing/belanjaharian/belanja') }}"><span
                                                    class="submenu-title">Belanja Harian</span><span class="hidden">Purchasing</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Return Pembelian','ma_read'))
                                    <li class="{{ Request::is('purchasing/returnpembelian/pembelian') ? 'active' : '' || Request::is('purchasing/returnpembelian/*') ? 'active' : '' }}">
                                        <a href="{{ url('/purchasing/returnpembelian/pembelian') }}"><span
                                                    class="submenu-title">Return Pembelian</span><span class="hidden">Purchasing</span></a>
                                    </li>
                                @endif

                                {{-- @if(Auth::user()->punyaAkses('Return Pembelian','ma_read')) --}}
                                    <li class="{{ Request::is('purchasing/pembayaran_hutang') ? 'active' : '' || Request::is('purchasing/pembayaran_hutang/*') ? 'active' : '' }}">
                                        <a href="{{ url('/purchasing/pembayaran_hutang') }}"><span
                                                    class="submenu-title">Pembayaran Hutang</span><span class="hidden">Purchasing</span></a>
                                    </li>
                            </ul>
                        </li>
                    @endif
                    @if(Auth::user()->punyaAkses('Inventory','ma_read'))
                        <div class="clearfix"></div>
                        <li class="{{Request::is('inventory') ? 'active' : '' || Request::is('inventory/*') ? 'active' : '' }}">
                            <a href="#"><i class="fa fa-desktop fa-fw">
                                    <div class="icon-bg bg-green"></div>
                                </i><span class="menu-title">Inventory</span><span class="fa arrow"></span>
                                <span class="hidden">

                                    @if(Auth::user()->punyaAkses('Penerimaan Barang Suplier','ma_read'))
                                        Penerimaan Barang Suplier
                                    @endif

                                    @if(Auth::user()->punyaAkses('Penerimaan Barang Hasil Produksi','ma_read'))
                                        Penerimaan Barang Hasil Produksi
                                    @endif

                                    @if(Auth::user()->punyaAkses('Penerimaan Barang Return Suplier','ma_read'))
                                        Penerimaan Barang Return Suplier
                                    @endif

                                    @if(Auth::user()->punyaAkses('Barang Digunakan','ma_read'))
                                        Barang Digunakan
                                    @endif

                                    @if(Auth::user()->punyaAkses('Barang Rusak','ma_read'))
                                        Barang Rusak
                                    @endif

                                    @if(Auth::user()->punyaAkses('Stock Opname','ma_read'))
                                        Stock Opname
                                    @endif

                                    @if(Auth::user()->punyaAkses('Stock Gudang','ma_read'))
                                        Stock Gudang
                                    @endif

                                    @if(Auth::user()->punyaAkses('Retail Request','ma_read'))
                                        Retail Request
                                    @endif

                                    @if(Auth::user()->punyaAkses('Grosir Transfer','ma_read'))
                                        Grosir Transfer
                                    @endif

                            </span>
                            </a>
                            <ul class="nav nav-second-level">

                                @if(Auth::user()->punyaAkses('Penerimaan Barang Suplier','ma_read'))
                                    <li class="{{ Request::is('inventory/p_suplier/suplier') ? 'active' : '' || Request::is('inventory/p_suplier/*') ? 'active' : '' }}">
                                        <a href="{{ url('/inventory/p_suplier/suplier') }}"><span
                                                    class="submenu-title">Penerimaan Barang Suplier</span><span
                                                    class="hidden">Inventory</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Penerimaan Barang Hasil Produksi','ma_read'))
                                    <li class="{{ Request::is('inventory/p_hasilproduksi/produksi') ? 'active' : '' || Request::is('inventory/p_hasilproduksi/*') ? 'active' : '' }}">
                                        <a href="{{ url('/inventory/p_hasilproduksi/produksi') }}"><span
                                                    class="submenu-title">Penerimaan Barang Hasil Produksi</span><span
                                                    class="hidden">Inventory</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Penerimaan Barang Return Supplier','ma_read'))
                                    <li class="{{ Request::is('inventory/p_returnsupplier/index') ? 'active' : '' || Request::is('inventory/p_returnsupplier/*') ? 'active' : '' }}">
                                        <a href="{{ url('/inventory/p_returnsupplier/index') }}"><span
                                                    class="submenu-title">Penerimaan Barang Return Supplier</span><span
                                                    class="hidden">Inventory</span></a>
                                    </li>
                                @endif


                                @if(Auth::user()->punyaAkses('Barang Digunakan','ma_read'))
                                    <li class="{{ Request::is('inventory/b_digunakan/barang') ? 'active' : '' || Request::is('inventory/b_digunakan/*') ? 'active' : '' }}">
                                        <a href="{{ url('/inventory/b_digunakan/barang') }}"><span
                                                    class="submenu-title">Barang Digunakan</span><span
                                                    class="hidden">Inventory</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Barang Rusak','ma_read'))
                                    <li class="{{ Request::is('inventory/b_rusak/index') ? 'active' : '' || Request::is('inventory/b_rusak/*') ? 'active' : '' }}">
                                        <a href="{{ url('/inventory/b_rusak/index') }}"><span
                                                    class="submenu-title">Barang Rusak</span><span
                                                    class="hidden">Inventory</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Stock Opname','ma_read'))
                                    <li class="{{ Request::is('inventory/stockopname/opname') ? 'active' : '' || Request::is('inventory/stockopname/*') ? 'active' : '' }}">
                                        <a href="{{ url('/inventory/stockopname/opname') }}"><span
                                                    class="submenu-title">Stock Opname</span><span class="hidden">Inventory</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Stock Gudang','ma_read'))
                                    <li class="{{ Request::is('inventory/datagudang/gudang') ? 'active' : '' || Request::is('inventory/datagudang/*') ? 'active' : '' }}">
                                        <a href="{{ url('/inventory/datagudang/gudang') }}"><span
                                                    class="submenu-title">Stock Gudang</span><span
                                                    class="hidden">Inventory</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Retail Request','ma_read'))
                                    <li class="{{ Request::is('inventory/POSretail/transfer') ? 'active' : '' || Request::is('inventory/POSretail/transfer/*') ? 'active' : '' }}">
                                        <a href="{{ url('inventory/POSretail/transfer') }}"><span
                                                    class="submenu-title">Retail Request</span><span
                                                    class="hidden">Inventory</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Grosir Transfer','ma_read'))
                                    <li class="{{ Request::is('inventory/POSgrosir/transfer') ? 'active' : '' || Request::is('inventory/POSgrosir/transfer/*') ? 'active' : '' }}">
                                        <a href="{{ url('inventory/POSgrosir/transfer') }}"><span class="submenu-title">Grosir Transfer</span><span
                                                    class="hidden">Inventory</span></a>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif

                    @if(Auth::user()->punyaAkses('Produksi','ma_read'))
                        <div class="clearfix"></div>
                        <li class="{{Request::is('produksi') ? 'active' : '' || Request::is('produksi/*') ? 'active' : '' }}">
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw">
                                    <div class="icon-bg bg-green"></div>
                                </i><span class="menu-title">Produksi</span><span class="fa arrow"></span>
                                <span class="hidden">

                                @if(Auth::user()->punyaAkses('Monitoring Order & Stock','ma_read'))
                                        Monitoring Order & Stock
                                    @endif

                                    @if(Auth::user()->punyaAkses('Rencana Produksi','ma_read'))
                                        Rencana Produksi
                                    @endif

                                    @if(Auth::user()->punyaAkses('Manajemen SPK','ma_read'))
                                        Manajemen SPK
                                    @endif

                                    @if(Auth::user()->punyaAkses('Manajemen Output Produksi','ma_read'))
                                        Manajemen Output Produksi
                                    @endif

                                    @if(Auth::user()->punyaAkses('Pembuatan Pengambilan Item ','ma_read'))
                                        Pembuatan Pengambilan Item
                                    @endif


                                    @if(Auth::user()->punyaAkses('Data Actual SPK','ma_read'))
                                        Data Actual SPK
                                    @endif

                                    @if(Auth::user()->punyaAkses('Data Garapan Produksi','ma_read'))
                                        Data Garapan Produksi
                                    @endif

                            </span>
                            </a>
                            <ul class="nav nav-second-level">

                                @if(Auth::user()->punyaAkses('Monitoring Order & Stock','ma_read'))
                                    <li class="{{ Request::is('produksi/monitoringprogress/monitoring') ? 'active' : '' || Request::is('produksi/monitoringprogress/*') ? 'active' : '' }}">
                                        <a href="{{ url('/produksi/monitoringprogress/monitoring') }}"><span
                                                    class="submenu-title">Monitoring Order & Stock</span><span
                                                    class="hidden">Produksi</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Rencana Produksi','ma_read'))
                                    <li class="{{ Request::is('produksi/rencanaproduksi/produksi') ? 'active' : '' || Request::is('produksi/rencanaproduksi/*') ? 'active' : '' }}">
                                        <a href="{{ url('/produksi/rencanaproduksi/produksi') }}"><span
                                                    class="submenu-title">Rencana Produksi</span><span
                                                    class="hidden">Produksi</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Manajemen SPK','ma_read'))
                                    <li class="{{ Request::is('produksi/spk/spk') ? 'active' : '' || Request::is('produksi/spk/*') ? 'active' : '' }}">
                                        <a href="{{ url('/produksi/spk/spk') }}"><span
                                                    class="submenu-title">Manajemen SPK</span><span
                                                    class="hidden">Produksi</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Manajemen Output Produksi','ma_read'))
                                    <li class="{{ Request::is('produksi/o_produksi/index') ? 'active' : '' || Request::is('produksi/o_produksi/*') ? 'active' : '' }}">
                                        <a href="{{ url('/produksi/o_produksi/index') }}"><span
                                                    class="submenu-title">Manajemen Output Produksi</span><span
                                                    class="hidden">Produksi</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Pembuatan Pengambilan Item','ma_read'))
                                    <li class="{{ Request::is('produksi/suratjalan/index') ? 'active' : '' || Request::is('produksi/suratjalan/*') ? 'active' : '' }}">
                                        <a href="{{ url('/produksi/suratjalan/index') }}"><span
                                                    class="submenu-title">Pembuatan Pengambilan Item</span><span
                                                    class="hidden">Produksi</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Data Actual SPK','ma_read'))
                                    <li class="{{ Request::is('produksi/waste/waste') ? 'active' : '' || Request::is('produksi/waste/*') ? 'active' : '' }}">
                                        <a href="{{ url('/produksi/waste/waste') }}"><span
                                                    class="submenu-title">Data Actual SPK</span><span
                                                    class="hidden">Produksi</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Data Actual SPK','ma_read'))
                                    <li class="{{ Request::is('produksi/garapan/index') ? 'active' : '' || Request::is('produksi/garapan/*') ? 'active' : '' }}">
                                        <a href="{{ url('/produksi/garapan/index') }}"><span
                                                    class="submenu-title">Data Garapan Produksi</span><span
                                                    class="hidden">Produksi</span></a>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif

                    @if(Auth::user()->punyaAkses('Penjualan','ma_read'))
                        <div class="clearfix"></div>
                        <li class="{{Request::is('penjualan') ? 'active' : '' || Request::is('penjualan/*') ? 'active' : '' }}">
                            <a href="#"><i class="fa fa-truck fa-fw">
                                    <div class="icon-bg bg-green"></div>
                                </i><span class="menu-title">Penjualan</span><span class="fa arrow"></span>
                                <span class="hidden">

                                    @if(Auth::user()->punyaAkses('Manajemen Harga','ma_read'))
                                        Manajemen Harga
                                    @endif

                                    @if(Auth::user()->punyaAkses('POS Penjualan Retail','ma_read'))
                                        POS Penjualan Retail
                                    @endif

                                    @if(Auth::user()->punyaAkses('POS Penjualan Grosir / Online','ma_read'))
                                        POS Penjualan Grosir / Online
                                    @endif

                                    @if(Auth::user()->punyaAkses('Laporan Penjualan Retail','ma_read'))
                                        Laporan Penjualan Retail
                                    @endif

                                    @if(Auth::user()->punyaAkses('Laporan Penjualan Grosir / Online','ma_read'))
                                        Laporan Penjualan Grosir / Online
                                    @endif

                                    @if(Auth::user()->punyaAkses('Laporan Penjualan Retail / Grosir','ma_read'))
                                        Laporan Penjualan Retail / Grosir
                                    @endif

                                    @if(Auth::user()->punyaAkses('Monitoring Order & Stock','ma_read'))
                                        Monitoring Order & Stock
                                    @endif

                                    @if(Auth::user()->punyaAkses('Manajemen Return Penjualan','ma_read'))
                                        Manajemen Return Penjualan
                                    @endif

                                    @if(Auth::user()->punyaAkses('Mutasi Stock & Retail','ma_read'))
                                        Mutasi Stock & Retail
                                    @endif

                            </span>

                            </a>
                            <ul class="nav nav-second-level">

                                @if(Auth::user()->punyaAkses('Manajemen Harga','ma_read'))
                                    <li class="{{ Request::is('penjualan/manajemenharga/harga') ? 'active' : '' || Request::is('penjualan/manajemenharga/*') ? 'active' : '' }}">
                                        <a href="{{ url('/penjualan/manajemenharga/harga') }}"><span
                                                    class="submenu-title">Manajemen Harga</span><span class="hidden">Penjualan</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('POS Penjualan Retail','ma_read'))
                                    <li class="{{ Request::is('penjualan/POSretail/*') ? 'active' : ''}}"><a
                                                href="{{ url('/penjualan/POSretail/index') }}"><span
                                                    class="submenu-title">POS Penjualan Retail</span><span
                                                    class="hidden">Penjualan</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('POS Penjualan Grosir / Online','ma_read'))
                                    <li class="{{ Request::is('penjualan/POSgrosir/*') ? 'active' : ''}}"><a
                                                href="{{ url('/penjualan/POSgrosir/index') }}"><span
                                                    class="submenu-title">POS Penjualan Grosir / Online</span><span
                                                    class="hidden">Penjualan</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Laporan POS Penjualan Retail','ma_read'))
                                    <li class="{{ Request::is('penjualan/laporanRetail/*') ? 'active' : ''}}"><a
                                                href="{{ url('/penjualan/laporanRetail/index') }}"><span
                                                    class="submenu-title">Laporan Penjualan Retail</span><span
                                                    class="hidden">Penjualan</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Laporan POS Penjualan Grosir / Online','ma_read'))
                                    <li class="{{ Request::is('penjualan/laporanGrosir/*') ? 'active' : ''}}"><a
                                                href="{{ url('/penjualan/laporanGrosir/index') }}"><span
                                                    class="submenu-title">Laporan Penjualan Grosir / Online</span><span
                                                    class="hidden">Penjualan</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Laporan POS Penjualan Retail / Grosir','ma_read'))
                                    <li class="{{ Request::is('penjualan/laporan_penjualan/*') ? 'active' : ''}}"><a
                                                href="{{ url('/penjualan/laporan_penjualan/laporan_penjualan') }}"><span
                                                    class="submenu-title">Laporan POS Penjualan Retail / Grosir</span><span
                                                    class="hidden">Penjualan</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Monitoring Order & Stock','ma_read'))
                                    <li class="{{ Request::is('penjualan/monitoringorder/monitoring') ? 'active' : '' || Request::is('penjualan/monitoringorder/*') ? 'active' : '' }}">
                                        <a href="{{ url('/penjualan/monitoringorder/monitoring') }}"><span
                                                    class="submenu-title">Monitoring Order & Stock</span><span
                                                    class="hidden">Penjualan</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Manajemen Return Penjualan','ma_read'))
                                    <li class="{{ Request::is('penjualan/manajemenreturn/r_penjualan') ? 'active' : '' || Request::is('penjualan/manajemenreturn/*') ? 'active' : '' }}">
                                        <a href="{{ url('/penjualan/manajemenreturn/r_penjualan') }}"><span
                                                    class="submenu-title">Manajemen Return Penjualan</span><span
                                                    class="hidden">Penjualan</span></a>
                                    </li>
                                @endif

                                @if(Auth::user()->punyaAkses('Mutasi Stock & Retail','ma_read'))
                                    <li class="{{ Request::is('penjualan/mutasistok/mutasi') ? 'active' : '' || Request::is('penjualan/mutasistok/*') ? 'active' : '' }}">
                                        <a href="{{ url('/penjualan/mutasistok/mutasi') }}"><span
                                                    class="submenu-title">Mutasi Stock & Retail</span><span
                                                    class="hidden">Penjualan</span></a>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif
                    @if(Auth::user()->punyaAkses('HRD','ma_read'))
                        <div class="clearfix"></div>
                        <li class="{{Request::is('hrd') ? 'active' : '' || Request::is('hrd/*') ? 'active' : '' }}"><a
                                    href="#"><i class="fa fa-users fa-fw">
                                    <div class="icon-bg bg-green"></div>
                                </i><span class="menu-title">HRD</span><span class="fa arrow"></span>
                                <span class="hidden">

                                    @if(Auth::user()->punyaAkses('Absensi','ma_read'))
                                        Absensi
                                    @endif

                                    @if(Auth::user()->punyaAkses('Data Lembur Pegawai','ma_read'))
                                        Data Lembur Pegawai
                                    @endif

                                    @if(Auth::user()->punyaAkses('Scoreboard Pegawai Per Hari','ma_read'))
                                        Scoreboard Pegawai Per Hari
                                    @endif

                                    @if(Auth::user()->punyaAkses('Input Data KPI','ma_read'))
                                        Input Data KPI
                                    @endif

                                    @if(Auth::user()->punyaAkses('Payroll','ma_read'))
                                        Payroll
                                    @endif

                                    @if(Auth::user()->punyaAkses('Payroll Pegawai Produksi','ma_read'))
                                        Payroll Pegawai Produksi
                                    @endif

                                    @if(Auth::user()->punyaAkses('Payroll Pegawai Manajemen','ma_read'))
                                        Payroll Pegawai Manajemen
                                    @endif

                                    @if(Auth::user()->punyaAkses('Manajemen Scoreboard','ma_read'))
                                        Manajemen Scoreboard
                                    @endif

                                    @if(Auth::user()->punyaAkses('Manajemen Scoreboard & KPI','ma_read'))
                                        Manajemen Scoreboard & KPI
                                    @endif

                                    @if(Auth::user()->punyaAkses('Training Pegawai','ma_read'))
                                        Training Pegawai
                                    @endif

                                    @if(Auth::user()->punyaAkses('Recruitment','ma_read'))
                                        Recruitment
                                    @endif
                                    @if(Auth::user()->punyaAkses('Manajemen Surat','ma_read'))
                                        Manajemen Surat
                                    @endif

                            </span>
                            </a>
                            <ul class="nav nav-second-level">

                                @if(Auth::user()->punyaAkses('Absensi','ma_read'))
                                    <li class="{{ Request::is('hrd/absensi/index') ? 'active' : '' || Request::is('hrd/absensi/*') ? 'active' : '' }}">
                                        <a href="{{ url('/hrd/absensi/index')}}"><span
                                                    class="submenu-title">Absensi</span><span
                                                    class="hidden">HRD</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Data Lembur Pegawai','ma_read'))
                                    <li class="{{ Request::is('hrd/datalembur/index') ? 'active' : '' || Request::is('hrd/datalembur/*') ? 'active' : '' }}">
                                        <a href="{{ url('/hrd/datalembur/index')}}"><span class="submenu-title">Data Lembur Pegawai</span><span
                                                    class="hidden">HRD</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Payroll','ma_read'))
                                    <li class="{{ Request::is('hrd/payroll/setting-gaji') ? 'active' : '' || Request::is('hrd/payroll/*') ? 'active' : '' }}">
                                        <a href="{{ url('/hrd/payroll/setting-gaji') }}"><span
                                                    class="submenu-title">Payroll</span><span class="hidden">HRD</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Payroll Pegawai Produksi','ma_read'))
                                    <li class="{{ Request::is('hrd/produksi/payroll') ? 'active' : '' || Request::is('hrd/produksi/*') ? 'active' : '' }}">
                                        <a href="{{ url('/hrd/produksi/payroll') }}"><span
                                                    class="submenu-title">Payroll Pegawai Produksi</span>
                                                    <span class="hidden">HRD</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Payroll Pegawai Manajemen','ma_read'))
                                    <li class="{{ Request::is('hrd/payrollman/index') ? 'active' : '' || Request::is('hrd/payrollman/*') ? 'active' : '' }}">
                                        <a href="{{ url('/hrd/payrollman/index') }}"><span
                                                    class="submenu-title">Payroll Pegawai Manajemen</span>
                                                    <span class="hidden">HRD</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Scoreboard Pegawai Per Hari','ma_read'))
                                    <li class="{{ Request::is('hrd/inputkpi/index') ? 'active' : '' || Request::is('hrd/inputkpi/*') ? 'active' : '' }}">
                                        <a href="{{ url('/hrd/inputkpi/index') }}"><span class="submenu-title">Scoreboard Pegawai Per Hari</span><span
                                                    class="hidden">HRD</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Input data KPI','ma_read'))
                                    <li class="{{ Request::is('hrd/inputkpix/index') ? 'active' : '' || Request::is('hrd/inputkpix/*') ? 'active' : '' }}">
                                        <a href="{{ url('/hrd/inputkpix/index') }}"><span class="submenu-title">Input Data KPI</span><span
                                                    class="hidden">HRD</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Manajemen Scoreboard','ma_read'))
                                    <li class="{{ Request::is('hrd/manajemenkpipegawai/index') ? 'active' : '' || Request::is('hrd/manajemenkpipegawai/*') ? 'active' : '' }}">
                                        <a href="{{ url('/hrd/manajemenkpipegawai/index') }}"><span class="submenu-title">Manajemen Scoreboard</span><span
                                                    class="hidden">HRD</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Manajemen Scoreboard & KPI','ma_read'))
                                    <li class="{{ Request::is('hrd/manscorekpi/index') ? 'active' : '' || Request::is('hrd/manscorekpi/*') ? 'active' : '' }}">
                                        <a href="{{ url('/hrd/manscorekpi/index') }}"><span class="submenu-title">Manajemen Scoreboard & KPI</span><span
                                                    class="hidden">HRD</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Training Pegawai','ma_read'))
                                    <li class="{{ Request::is('hrd/training/training') ? 'active' : '' || Request::is('hrd/training/*') ? 'active' : '' }}">
                                        <a href="{{ url('/hrd/training/training')}}"><span class="submenu-title">Training Pegawai</span><span
                                                    class="hidden">HRD</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Recruitment','ma_read'))
                                    <li class="{{ Request::is('hrd/recruitment/rekrut') ? 'active' : '' || Request::is('hrd/recruitment/*') ? 'active' : '' }}">
                                        <a href="{{ url('/hrd/recruitment/rekrut') }}"><span class="submenu-title">Recruitment</span><span
                                                    class="hidden">HRD</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Manajemen Surat','ma_read'))
                                    <li class="{{ Request::is('hrd/manajemensurat') ? 'active' : '' || Request::is('hrd/manajemensurat/*') ? 'active' : '' }}">
                                        <a href="{{ url('/hrd/manajemensurat') }}"><span class="submenu-title">Manajemen surat</span><span
                                                    class="hidden">HRD</span></a>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif
                    @if(Auth::user()->punyaAkses('Keuangan','ma_read'))
                        <div class="clearfix"></div>
                        <li class="{{Request::is('keuangan') ? 'active' : '' || Request::is('keuangan/*') ? 'active' : '' }}">
                            <a href="#"><i class="fa fa-money fa-fw">
                                    <div class="icon-bg bg-green"></div>
                                </i><span class="menu-title">Keuangan</span><span class="fa arrow"></span>
                                <span class="hidden">

                                    @if(Auth::user()->punyaAkses('Manajemen SPK','ma_read'))
                                        Manajemen SPK
                                    @endif

                                    @if(Auth::user()->punyaAkses('Proses Input Produksi','ma_read'))
                                        Proses Input Produksi
                                    @endif

                                    @if(Auth::user()->punyaAkses('Laporan Hutang Piutang','ma_read'))
                                        Laporan Hutang Piutang
                                    @endif

                                    @if(Auth::user()->punyaAkses('Laporan(Jurnal,Buku Besar,Neraca,DLL)','ma_read'))
                                        Laporan(Jurnal,Buku Besar,Neraca,DLL)
                                    @endif

                                    @if(Auth::user()->punyaAkses('Analisa Progress Terhadap Perencanaan','ma_read'))
                                        Analisa Progress Terhadap Perencanaan
                                    @endif

                                    @if(Auth::user()->punyaAkses('Analisa Net Profit Terhadap OCF','ma_read'))
                                        Analisa Net Profit Terhadap OCF
                                    @endif

                                    @if(Auth::user()->punyaAkses('Analisa Pertumbuhan Aset','ma_read'))
                                        Analisa Pertumbuhan Aset
                                    @endif

                                    @if(Auth::user()->punyaAkses('Analisa Cashflow','ma_read'))
                                        Analisa Cashflow
                                    @endif

                                    @if(Auth::user()->punyaAkses('Analisa Common Size dan Index','ma_read'))
                                        Analisa Common Size dan Index
                                    @endif

                                    @if(Auth::user()->punyaAkses('Analisa Rasio Keuangan','ma_read'))
                                        Analisa Rasio Keuangan
                                    @endif

                                    @if(Auth::user()->punyaAkses('Analisa Three Bottom Line','ma_read'))
                                        Analisa Three Bottom Line
                                    @endif

                                    @if(Auth::user()->punyaAkses('Analisa ROE','ma_read'))
                                        Analisa ROE
                                    @endif

                                    @if(Auth::user()->punyaAkses('Konfirmasi Data Pembelian','ma_read'))
                                        Konfirmasi Data Pembelian
                                    @endif

                                    @if(Auth::user()->punyaAkses('Penerimaan Barang Hasil Produksi','ma_read'))
                                        Penerimaan Barang Hasil Produksi
                                    @endif

                            </span>
                            </a>
                            <ul class="nav nav-second-level">
                                @if(Auth::user()->punyaAkses('Manajemen SPK','ma_read'))
                                    <li class="{{ Request::is('keuangan/spk/spk') ? 'active' : '' || Request::is('keuangan/spk/spk/*') ? 'active' : '' }}">
                                        <a href="{{ url('keuangan/spk/spk') }}"><span class="submenu-title">Manajemen SPK</span><span
                                                    class="hidden">Keuangan</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Proses Input Transaksi','ma_read'))
                                    <li class="{{ Request::is('keuangan/p_inputtransaksi/transaksi') ? 'active' : '' || Request::is('keuangan/p_inputtransaksi/*') ? 'active' : '' }}">
                                        <a href="{{ url('/keuangan/p_inputtransaksi/index') }}"><span
                                                    class="submenu-title">Proses Input Transaksi</span><span
                                                    class="hidden">Keuangan</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Laporan Hutang Piutang','ma_read'))
                                    <li class="{{ Request::is('keuangan/l_hutangpiutang/hutang') ? 'active' : '' || Request::is('keuangan/l_hutangpiutang/*') ? 'active' : '' }}">
                                        <a href="{{ url('/keuangan/l_hutangpiutang/hutang') }}"><span
                                                    class="submenu-title">Laporan Hutang Piutang</span><span
                                                    class="hidden">Keuangan</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Laporan (Jurnal,Buku Besar,Neraca,DLL)','ma_read'))
                                    <li class="{{ Request::is('keuangan/laporan_keuangan') ? 'active' : '' || Request::is('keuangan/laporan_keuangan/*') ? 'active' : '' }}">
                                        <a href="{{ url('/keuangan/laporan_keuangan') }}"><span class="submenu-title">Laporan Keuangan    </span><span
                                                    class="hidden">Keuangan</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Analisa Progress Terhadap Perencanaan','ma_read'))
                                    <li class="{{ Request::is('keuangan/analisaprogress/analisa') ? 'active' : '' || Request::is('keuangan/analisaprogress/*') ? 'active' : '' }}">
                                        <a href="{{ url('/keuangan/analisaprogress/analisa') }}"><span
                                                    class="submenu-title">Analisa Progress Terhadap Perencanaan</span><span
                                                    class="hidden">Keuangan</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Analisa Net Profit Terhadap OCF','ma_read'))
                                    <li class="{{ Request::is('keuangan/analisaocf/analisa2') ? 'active' : '' || Request::is('keuangan/analisaocf/*') ? 'active' : '' }}">
                                        <a href="{{ url('/keuangan/analisaocf/analisa2') }}"><span
                                                    class="submenu-title">Analisa Net Profit Terhadap OCF</span><span
                                                    class="hidden">Keuangan</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Analisa Pertumbuhan Aset','ma_read'))
                                    <li class="{{ Request::is('keuangan/analisaaset/analisa3') ? 'active' : '' || Request::is('keuangan/analisaaset/*') ? 'active' : '' }}">
                                        <a href="{{ url('/keuangan/analisaaset/analisa3') }}"><span
                                                    class="submenu-title">Analisa Pertumbuhan Aset</span><span
                                                    class="hidden">Keuangan</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Analisa Cashflow','ma_read'))
                                    <li class="{{ Request::is('keuangan/analisacashflow/analisa4') ? 'active' : '' || Request::is('keuangan/analisacashflow/*') ? 'active' : '' }}">
                                        <a href="{{ url('/keuangan/analisacashflow/analisa4') }}"><span
                                                    class="submenu-title">Analisa Cashflow</span><span class="hidden">Keuangan</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Analisa Common Size dan Index','ma_read'))
                                    <li class="{{ Request::is('keuangan/analisaindex/analisa5') ? 'active' : '' || Request::is('keuangan/analisaindex/*') ? 'active' : '' }}">
                                        <a href="{{ url('/keuangan/analisaindex/analisa5') }}"><span
                                                    class="submenu-title">Analisa Common Size dan Index</span><span
                                                    class="hidden">Keuangan</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Analisa Rasio Keuangan','ma_read'))
                                    <li class="{{ Request::is('keuangan/analisarasio/analisa6') ? 'active' : '' || Request::is('keuangan/analisarasio/*') ? 'active' : '' }}">
                                        <a href="{{ url('/keuangan/analisarasio/analisa6') }}"><span
                                                    class="submenu-title">Analisa Rasio Keuangan</span><span
                                                    class="hidden">Keuangan</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Analisa Three Bottom Line','ma_read'))
                                    <li class="{{ Request::is('keuangan/analisabottom/analisa7') ? 'active' : '' || Request::is('keuangan/analisabottom/*') ? 'active' : '' }}">
                                        <a href="{{ url('/keuangan/analisabottom/analisa7') }}"><span
                                                    class="submenu-title">Analisa Three Bottom Line</span><span
                                                    class="hidden">Keuangan</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Analisa ROE','ma_read'))
                                    <li class="{{ Request::is('keuangan/analisaroe/analisa8') ? 'active' : '' || Request::is('keuangan/analisaroe/*') ? 'active' : '' }}">
                                        <a href="{{ url('/keuangan/analisaroe/analisa8') }}"><span
                                                    class="submenu-title">Analisa ROE</span><span class="hidden">Keuangan</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Konfirmasi Data Pembelian','ma_read'))
                                    <li class="{{ Request::is('keuangan/konfirmasipembelian/konfirmasi-purchase') ? 'active' : '' || Request::is('keuangan/konfirmasipembelian/*') ? 'active' : '' }}">
                                        <a href="{{ url('/keuangan/konfirmasipembelian/konfirmasi-purchase') }}"><span
                                                    class="submenu-title">Konfirmasi Data Pembelian</span><span
                                                    class="hidden">Keuangan</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Penerimaan Barang Hasil Produksi','ma_read'))
                                    <li class="{{ Request::is('keuangan/p_hasilproduksi/pembatalanPenerimaan') ? 'active' : '' || Request::is('keuangan/p_hasilproduksi/*') ? 'active' : '' }}">
                                        <a href="{{ url('/keuangan/p_hasilproduksi/pembatalanPenerimaan') }}"><span
                                                    class="submenu-title">Penerimaan Barang Hasil Produksi</span><span
                                                    class="hidden">Keuangan</span></a>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif
                    @if(Auth::user()->punyaAkses('System','ma_read'))
                        <div class="clearfix"></div>
                        <li class="{{Request::is('system') ? 'active' : '' || Request::is('system/*') ? 'active' : '' }}">
                            <a href="#"><i class="fa fa-cog fa-fw fa-spin">
                                    <div class="icon-bg bg-green"></div>
                                </i><span class="menu-title">System</span><span class="fa arrow"></span>
                                <span class="hidden">

                                    @if(Auth::user()->punyaAkses('Manajemen User','ma_read'))
                                        Manajemen User
                                    @endif

                                    @if(Auth::user()->punyaAkses('Manajemen Hak Akses','ma_read'))
                                        Manajemen Hak Akses
                                    @endif

                                    @if(Auth::user()->punyaAkses('Profil Perusahaan','ma_read'))
                                        Profil Perusahaan
                                    @endif

                                    @if(Auth::user()->punyaAkses('Tahun Finansial','ma_read'))
                                        Tahun Finansial
                                    @endif

                            </span>
                            </a>


                            <ul class="nav nav-second-level">

                                @if(Auth::user()->punyaAkses('Manajemen User','ma_read'))
                                    <li class="{{ Request::is('system/hakuser/user') ? 'active' : '' || Request::is('system/hakuser/*') ? 'active' : '' }}">
                                        <a href="{{ url('/system/hakuser/user') }}"><span class="submenu-title">Manajemen User</span><span
                                                    class="hidden">System</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Manajemen Hak Akses','ma_read'))
                                    <li class="{{ Request::is('system/hakakses/akses') ? 'active' : '' || Request::is('system/hakakses/*') ? 'active' : '' }}">
                                        <a href="{{ url('/system/hakakses/akses') }}"><span class="submenu-title">Manajemen Hak Akses</span><span
                                                    class="hidden">System</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Profil Perusahaan','ma_read'))
                                    <li class="{{ Request::is('system/profilperusahaan/profil') ? 'active' : '' || Request::is('system/profilperusahaan/*') ? 'active' : '' }}">
                                        <a href="{{ url('/system/profilperusahaan/profil') }}"><span
                                                    class="submenu-title">Profil Perusahaan</span><span class="hidden">System</span></a>
                                    </li>
                                @endif
                                @if(Auth::user()->punyaAkses('Tahun Finansial','ma_read'))
                                    <li class="{{ Request::is('system/thnfinansial/finansial') ? 'active' : '' || Request::is('system/thnfinansial/*') ? 'active' : '' }}">
                                        <a href="{{ url('/system/thnfinansial/finansial') }}"><span
                                                    class="submenu-title">Tahun Finansial</span><span class="hidden">System</span></a>
                                    </li>
                                @endif

                            </ul>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </nav>

    <div>
        <!--BEGIN BACK TO TOP-->
        <a id="totop" href="#"><i class="fa fa-angle-up"></i></a>
        <!--END BACK TO TOP-->
        <!--BEGIN CHAT FORM-->
        <div id="chat-form" class="fixed">
            <div class="chat-inner">
                <h2 class="chat-header">
                    <a href="javascript:;" class="chat-form-close pull-right"><i class="glyphicon glyphicon-remove">
                        </i></a><i class="fa fa-users"></i>&nbsp; Message &nbsp;<span class="badge badge-info">3</span>
                </h2>
                <div id="group-1" class="chat-group">
                    <strong>Favorites</strong><a href="#"><span class="user-status is-online"></span>
                        <small>
                            Verna Morton
                        </small>
                        <span class="badge badge-info">2</span></a><a href="#"><span
                                class="user-status is-online"></span>
                        <small>Delores Blake</small>
                        <span class="badge badge-info is-hidden">
                                    0</span></a><a href="#"><span class="user-status is-busy"></span>
                        <small>Nathaniel Morris</small>
                        <span class="badge badge-info is-hidden">0</span></a><a href="#"><span
                                class="user-status is-idle"></span>
                        <small>Boyd Bridges</small>
                        <span class="badge badge-info is-hidden">0</span></a><a
                            href="#"><span class="user-status is-offline"></span>
                        <small>Meredith Houston</small>
                        <span class="badge badge-info is-hidden">0</span></a></div>
                <div id="group-2" class="chat-group">
                    <strong>Office</strong><a href="#"><span class="user-status is-busy"></span>
                        <small>
                            Ann Scott
                        </small>
                        <span class="badge badge-info is-hidden">0</span></a><a href="#"><span
                                class="user-status is-offline"></span>
                        <small>Sherman Stokes</small>
                        <span class="badge badge-info is-hidden">
                                    0</span></a><a href="#"><span class="user-status is-offline"></span>
                        <small>Florence
                            Pierce
                        </small>
                        <span class="badge badge-info">1</span></a></div>
                <div id="group-3" class="chat-group">
                    <strong>Friends</strong><a href="#"><span class="user-status is-online"></span>
                        <small>
                            Willard Mckenzie
                        </small>
                        <span class="badge badge-info is-hidden">0</span></a><a
                            href="#"><span class="user-status is-busy"></span>
                        <small>Jenny Frazier</small>
                        <span class="badge badge-info is-hidden">0</span></a><a href="#"><span
                                class="user-status is-offline"></span>
                        <small>Chris Stewart</small>
                        <span class="badge badge-info is-hidden">0</span></a><a
                            href="#"><span class="user-status is-offline"></span>
                        <small>Olivia Green</small>
                        <span class="badge badge-info is-hidden">0</span></a></div>
            </div>
            <div id="chat-box" style="top: 400px">
                <div class="chat-box-header">
                    <a href="#" class="chat-box-close pull-right"><i class="glyphicon glyphicon-remove">
                        </i></a><span class="user-status is-online"></span><span class="display-name">Willard
                            Mckenzie</span>
                    <small>Online</small>
                </div>
                <div class="chat-content">
                    <ul class="chat-box-body">
                        <li>
                            <p>
                                <img src="{{asset('assets/images/avatar/128.jpg')}}" class="avt"/><span class="user">John Doe</span><span
                                        class="time">09:33</span></p>
                            <p>
                                Hi Swlabs, we have some comments for you.</p>
                        </li>
                        <li class="odd">
                            <p>
                                <img src="{{asset('assets/images/avatar/48.jpg')}}" class="avt"/><span class="user">Swlabs</span><span
                                        class="time">09:33</span></p>
                            <p>
                                Hi, we're listening you...</p>
                        </li>
                    </ul>
                </div>
                <div class="chat-textarea">
                    <input placeholder="Type your message" class="form-control"/></div>
            </div>
        </div>
        <!--END CHAT FORM-->
