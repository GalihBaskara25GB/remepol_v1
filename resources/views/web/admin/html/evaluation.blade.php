<div class="container-fluid py-4">
  
  <!-- Table -->
  <div class="row my-4" id="tableContainer">
    <div class="col-sm-12 mb-md-0 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-sm-12 col-md-7">
              <h6>Evaluation</h6>
              <p class="text-sm mb-0 d-none d-md-block">
                <i class="fa fa-check text-info" aria-hidden="true"></i>
                <span class="font-weight-bold ms-1">Showing</span> data stored in database
              </p>
            </div>
            <div class="col-lg-6 col-sm-12 col-md-5 my-auto">
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label for="matakuliah_id" class="form-control-label">Mata Kuliah</label>
                    <select class="form-control" id="matakuliah_id" name="matakuliah_id" required>
                      <option value="">Choose Option</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body px-3 pb-2">
          <form id="evaluationForm">
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <button type="submit" class="btn btn-block btn-sm btn-primary bg-gradient-primary w-100 btnSave" disabled="true">Save</button>
              </div>
              <div class="col-md-6 col-sm-6">
                <button type="button" class="btn btn-block btn-sm btn-default w-100 btnShowResult" disabled="true">Show Result</button>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
                <thead id="theadEvaluation">
                </thead>
                <tbody id="tbodyEvaluation">
                </tbody>
              </table>
            </div>
            <div class="row pt-2">
              <div class="col-md-6 col-sm-6">
                <button type="submit" class="btn btn-block btn-sm btn-primary bg-gradient-primary w-100 btnSave" disabled="true">Save</button>
              </div>
              <div class="col-md-6 col-sm-6">
                <button type="button" class="btn btn-block btn-sm btn-default w-100 btnShowResult" disabled="true">Show Result</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End Table -->

  <!-- Form -->
  <div class="row my-4" id="resultContainer">
    <div class="col-sm-12 mb-md-0 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-sm-12 col-md-7">
              <h6 id="cardResultTitle">SAW Result of Mata Kuliah</h6>
              <p class="text-sm mb-0 d-none d-md-block">
                <i class="fa fa-check text-info" aria-hidden="true"></i>
                <span class="font-weight-bold ms-1">Showing</span> process result
              </p>
            </div>
            <div class="col-lg-6 col-sm-12 col-md-5 my-auto text-end">
              <div class="row">
                <div class="col-6">
                </div>
                <div class="col-6">
                  <a class="btn bg-gradient-primary btn-sm btnCloseResult" href="">Close</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body pb-2">
          <div class="table-responsive">
            <table class="table align-items-center mb-0">
              <thead id="theadResult">
              </thead>
              <tbody id="tbodyResult">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Form -->