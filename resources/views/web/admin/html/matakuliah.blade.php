<div class="container-fluid py-4">
  
  <!-- Table -->
  <div class="row my-4" id="tableContainer">
    <div class="col-sm-12 mb-md-0 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-sm-12 col-md-7">
              <h6>Mata Kuliah</h6>
              <p class="text-sm mb-0 d-none d-md-block">
                <i class="fa fa-check text-info" aria-hidden="true"></i>
                <span class="font-weight-bold ms-1">Showing</span> data stored in database
              </p>
            </div>
            <div class="col-lg-6 col-sm-12 col-md-5 my-auto text-end">
              <div class="row">
                <div class="col-6">
                </div>
                <div class="col-6">
                  <a class="btn bg-gradient-primary btn-sm w-100" href="" id="btnAddData">Add Data</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body px-3 pb-2">
          <div class="row">
            <!-- Search -->
            <div class="col-md-6 col-sm-12"></div>
            
            <!-- Pagination -->
            <div class="col-md-3 col-sm-12">
              <p id="paginationText" class="text-sm">Showing 0 of 0 entries</p>
            </div>
            <div class="col-md-3 col-sm-12">
              <nav aria-label="Page navigation example">
                <ul class="pagination pagination-primary">
                  <li class="page-item">
                    <a class="page-link" id="paginationFirst">First</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" aria-label="Previous" id="paginationPrev">
                      <span aria-hidden="true"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
                    </a>
                  </li>
                  <li class="page-item active">
                    <a class="page-link text-white" id="paginationCurrent">1</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" aria-label="Next" id="paginationNext">
                      <span aria-hidden="true"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                    </a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" id="paginationLast">Last</a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Semester</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Dosen</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Keterangan</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Opsi</th>
                </tr>
              </thead>
              <tbody  id="tbodyMatakuliah">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Table -->

  <!-- Form -->
  <div class="row my-4" id="formContainer">
    <div class="col-sm-12 mb-md-0 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-sm-12 col-md-7">
              <h6 id="cardFormTitle">Add Mata Kuliah</h6>
              <p class="text-sm mb-0 d-none d-md-block">
                <i class="fa fa-check text-info" aria-hidden="true"></i>
                <span class="font-weight-bold ms-1">Fill</span> data below
              </p>
            </div>
            <div class="col-lg-6 col-sm-12 col-md-5 my-auto text-end">
              <div class="row">
                <div class="col-6">
                </div>
                <div class="col-6">
                  <a class="btn bg-gradient-primary btn-sm" href="" id="btnCloseForm">Close</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body pb-2">
          <div class="table-responsive">
            <form id="matakuliahForm">
              <div class="row mx-0">
                <div class="col-md-6 col-sm-12">
                  <div class="form-group">
                    <label for="nama" class="form-control-label">Nama</label>
                    <input class="form-control" type="text" value="" id="nama" name="nama" placeholder="Nama Mata Kuliah" required />
                  </div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="form-group">
                    <label for="semester" class="form-control-label">Semester</label>
                    <select class="form-control" id="semester" name="semester" required>
                      <option value="">Choose Option</option>
                      <option value="1">Ganjil</option>
                      <option value="2">Genap</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row mx-0">
                <div class="col-md-6 col-sm-12">
                  <div class="form-group">
                    <label for="dosen" class="form-control-label">Dosen</label>
                    <input class="form-control" type="text" value="" id="dosen" name="dosen" placeholder="Nama Dosen" required />
                  </div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="form-group">
                    <label for="keterangan" class="form-control-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" required></textarea>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <button type="submit" class="btn bg-gradient-primary btn-sm">Save</button>
                <button type="reset" class="btn bg-gradient-default btn-sm">Reset</button>
              </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Form -->
  