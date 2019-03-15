<div class="tab-pane" role="tabpanel" id="step2">
    <h1 class="text-md-center">Pendidikan Terakhir</h1>
    <div class="row">
      <div class="col-lg-10 mx-auto">
        <div class="form-group row">
          <label for="pendidikan" class="col-sm-2 col-form-label font-weight-bold">Nama Sekolah
            <span style="color: red">*</span>
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="pendidikan" name="pendidikan" placeholder="Nama Sekolah / Universitas" value="{{ old('pendidikan')}}">
          </div>
        </div>
      </div>

      <div class="col-lg-10 mx-auto">
        <div class="form-group row">
          <label for="tahun1" class="col-sm-2 col-form-label font-weight-bold">Tahun
            <span style="color: red">*</span>
          </label>
          <div class="col-sm-5">
            <select id="dob_pend_awal1" class="form-control" style="margin-right: 5px;" name="dob_pend_awal1"></select>
          </div>
          <div class="col-sm-5">
            <select id="dob_pend_akhir1" class="form-control" style="margin-right: 5px;" name="dob_pend_akhir1"></select>
          </div>
        </div>
      </div>

      <div class="col-lg-10 mx-auto">
        <div class="form-group row">
          <label for="jurusan" class="col-sm-2 col-form-label font-weight-bold">Jurusan
            <span style="color: red">*</span>
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="jurusan" name="jurusan" placeholder="Nama Jurusan" value="{{ old('jurusan')}}">
          </div>
        </div>
      </div>

      <div class="col-lg-10 mx-auto">
        <div class="form-group row">
          <label for="nilai" class="col-sm-2 col-form-label font-weight-bold">Nilai/IPK
            <span style="color: red">*</span>
          </label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="nilai" name="nilai" placeholder="misal : ( 3.80 untuk IPK )" value="{{ old('nilai')}}">
          </div>
        </div>
      </div>

      <div class="col-lg-10 mx-auto">
        <label class="tebal" style="color: red; float: left;">Keterangan : * Wajib diisi.</label>
      </div>

    </div>
    <hr>
    <h1 class="text-md-center">Daftar Riwayat Hidup</h1>
    <div class="row">
        <div class="col-lg-10 mx-auto">
          <div class="form-group row">
            <label for="perusahaan1" class="col-sm-2 col-form-label font-weight-bold">Nama Perusahaan</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="perusahaan1" name="perusahaan1" placeholder="Nama Perusahaan" value="{{ old('perusahaan1')}}">
            </div>
          </div>
        </div>

        <div class="col-lg-10 mx-auto">
          <div class="form-group row">
            <label for="tahun1" class="col-sm-2 col-form-label font-weight-bold">Tahun</label>
            <div class="col-sm-5">
              <select id="dob_cv_awal1" class="form-control" style="margin-right: 5px;" name="dob_cv_awal1"></select>
            </div>
            <div class="col-sm-5">
              <select id="dob_cv_akhir1" class="form-control" style="margin-right: 5px;" name="dob_cv_akhir1">
                <option value="">Tahun Keluar</option>
                <option value="Masih Bekerja">Masih Bekerja</option>
              </select>
            </div>
          </div>
        </div>

        <div class="col-lg-10 mx-auto">
          <div class="form-group row">
            <label for="jobdesc1" class="col-sm-2 col-form-label font-weight-bold">Job Desc</label>
            <div class="col-sm-10">
              <textarea name="jobdesc1" id="jobdesc1" maxlength="300" cols="30" rows="3" class="form-control" placeholder="Job Desc (Maks : 300 Karakter)">{{ old('jobdesc1')}}</textarea>
            </div>
          </div>
        </div>

        <div style="border-top:1px solid #e0e0e0;margin-bottom: 10px;width: 100%;"></div>

        <div class="col-lg-10 mx-auto">
          <div class="form-group row">
            <label for="perusahaan2" class="col-sm-2 col-form-label font-weight-bold">Nama Perusahaan</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="perusahaan2" name="perusahaan2" placeholder="Nama Perusahaan" value="{{ old('perusahaan2')}}">
            </div>
          </div>
        </div>

        <div class="col-lg-10 mx-auto">
          <div class="form-group row">
            <label for="tahun2" class="col-sm-2 col-form-label font-weight-bold">Tahun</label>
            <div class="col-sm-5">
              <select id="dob_cv_awal2" class="form-control" style="margin-right: 5px;" name="dob_cv_awal2"></select>
            </div>
            <div class="col-sm-5">
              <select id="dob_cv_akhir2" class="form-control" style="margin-right: 5px;" name="dob_cv_akhir2">
                <option value="">Tahun Keluar</option>
                <option value="Masih Bekerja">Masih Bekerja</option>
              </select>
            </div>                                      
          </div>
        </div>

        <div class="col-lg-10 mx-auto">
          <div class="form-group row">
            <label for="jobdesc2" class="col-sm-2 col-form-label font-weight-bold">Job Desc</label>
            <div class="col-sm-10">
              <textarea name="jobdesc2" id="jobdesc2" maxlength="300" cols="30" rows="3" class="form-control" placeholder="Job Desc (Maks : 300 Karakter)">{{ old('jobdesc2')}}</textarea>
            </div>
          </div>
        </div>

        <div class="col-lg-10 mx-auto">
          <div class="form-group row">
            <label class="tebal" style="color: black; float: left;">Abaikan inputan pengalaman kerja apabila anda Fresh Graduate.</label>
          </div>
        </div>
    </div>

    <ul class="list-inline text-md-center">
        <li><a class="btn btn-lg btn-primary next-step next-button js-scroll-trigger" href="#form_wizard">Next Step</a></li>
        <li><a href="#form_wizard" class="btn btn-lg btn-common prev-step next-button js-scroll-trigger">Back</a></li>
    </ul>
</div>