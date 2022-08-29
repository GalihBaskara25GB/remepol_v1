<div class="container-fluid py-4">
  
  <!-- Table -->
  <div class="row my-4" id="tableContainer">
    <div class="col-sm-12 mb-md-0 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-sm-12 col-md-7">
              <h6>Mata Pelajaran</h6>
              <p class="text-sm mb-0 d-none d-md-block">
                <i class="fa fa-check text-info" aria-hidden="true"></i>
                <span class="font-weight-bold ms-1">Showing</span> data stored in database
              </p>
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
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Guru</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Keterangan</th>
                </tr>
              </thead>
              <tbody  id="tbodyMatapelajaran">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Table -->
  