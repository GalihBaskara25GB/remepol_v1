<div class="container-fluid py-4">
  
  <!-- Table -->
  <div class="row my-4">
    <div class="col-sm-12 mb-md-0 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-sm-12 col-md-7">
              <h6>Users</h6>
              <p class="text-sm mb-0 d-none d-md-block">
                <i class="fa fa-check text-info" aria-hidden="true"></i>
                <span class="font-weight-bold ms-1">30</span> data stored in database
              </p>
            </div>
            <div class="col-lg-6 col-sm-12 col-md-5 my-auto text-end">
              <div class="row">
                <div class="col-6">
                </div>
                <div class="col-6">
                  <a class="btn bg-gradient-primary btn-sm w-100" href="">Add Data</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body px-3 pb-2">
          <div class="table-responsive">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Terakhir Diupdate</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Opsi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <div class="d-flex px-2 py-1">
                      <a href="javascript:;" class="" data-bs-toggle="tooltip" data-bs-placement="bottom" title="see detail">
                        James Moriah
                      </a>
                    </div>
                  </td>
                  <td>
                    James@mail.com
                  </td>
                  <td class="text-sm">
                    14 January 2022
                  </td>
                  <td class="align-middle">
                    <a href="javascript:;" class="btn bg-default btn-sm w-50" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
                      Edit
                    </a>
                    <a href="javascript:;" class="btn bg-danger btn-sm text-white w-50" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
                      Delete
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Table -->

  <!-- Form -->
  <div class="row my-4">
    <div class="col-sm-12 mb-md-0 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-sm-12 col-md-7">
              <h6 id="cardFormTitle">Add Users</h6>
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
                  <a class="btn bg-gradient-primary btn-sm" href="">Close</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body pb-2">
          <div class="table-responsive">
            <form id="userForm">
              <div class="row mx-0">
                <div class="col-md-6 col-sm-12">
                  <div class="form-group">
                      <label for="name" class="form-control-label">Name</label>
                      <input class="form-control" type="text" value="" id="name" name="name" placeholder="Name" required />
                  </div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="form-group">
                      <label for="email" class="form-control-label">Email</label>
                      <input class="form-control" type="email" value="" id="email" name="email" placeholder="Email" required />
                  </div>
                </div>
              </div>
              
              <div class="row mx-0">
                <div class="col-md-6 col-sm-12">
                  <div class="form-group">
                      <label for="password" class="form-control-label">Password</label>
                      <input class="form-control" type="password" value="" id="password" name="password" placeholder="Password" required />
                  </div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="form-group">
                    <label for="c_password" class="form-control-label">Confirm Password</label>
                    <input class="form-control" type="password" value="" id="c_password" name="c_password" placeholder="Confirm Password" required />
                  </div>
                </div>
              </div>
              <div class="form-group">
                <button type="button" class="btn bg-gradient-primary btn-sm">Save</button>
                <button type="button" class="btn bg-gradient-default btn-sm">Reset</button>
              </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Form -->
