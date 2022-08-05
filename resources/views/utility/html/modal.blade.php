<style>
  .modal {
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: rgba(0,0,0,0.5);
  }
</style>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
  <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
    <div class="modal-content">
      <div class="modal-header" id="modalHeader">
        <h6 class="modal-title" id="modalTitle"></h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="py-3 text-center">
          <i class="ni ni-bell-55 ni-3x"></i>
          <h4 class="text-gradient mt-4" id="modalSubtitle"></h4>
          <p id="modalMessage"></p>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalConfirmation" tabindex="-1" role="dialog" aria-labelledby="modalConfirmation" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-" role="document">
    <div class="modal-content">
      <div class="modal-header text-dark">
        <h6 class="modal-title text-dark">Confirmation</h6>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modalConfirmation" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="py-3 text-center">
          <i class="ni ni-bell-55 ni-3x text-primary"></i>
          <h4 class="text-dark mt-4">Are you sure?</h4>
          <p id="modalConfirmationMessage"></p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-gradient-primary text-white" id="modalConfirmButton" data-bs-dismiss="modal">Ok, Got it</button>
        <button type="button" class="btn btn-link text-dark ml-auto" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
