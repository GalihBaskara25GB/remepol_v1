const toggleModal = (modalTitle, modalSubtitle, modalMessage, modalColor, titleColor, subtitleColor, modalCallback = false, callbackParam = false) => {
  let modalComponent = $('#modal');

  $('#modalHeader').removeClass('bg-primary bg-danger bg-default bg-dark').addClass(modalColor);
  $('#modalTitle').removeClass('text-dark text-white').addClass(titleColor);
  $('#modalSubtitle').removeClass('text-dark text-white text-danger text-primary').addClass(subtitleColor);
  $('#modalTitle').html(modalTitle);
  $('#modalSubtitle').html(modalSubtitle);
  $('#modalMessage').html(modalMessage);

  modalComponent.modal('toggle');
  modalComponent.off('hidden.bs.modal');

  if(modalCallback != false) {
    modalComponent.on('hidden.bs.modal', function () {    
      if(callbackParam != false) 
        modalCallback(callbackParam);
      else
        modalCallback();
    });

  }
  
};

const showErrorModal = (message, modalCallback = false, callbackParam = false, subtitle = 'Internal Server Error') => {
  toggleModal('Something Wrong', subtitle, message, 'bg-danger', 'text-white', 'text-danger', modalCallback, callbackParam); 
};

const showSuccessModal = (message, modalCallback = false, callbackParam = false, subtitle = 'Success') => {
  toggleModal('Information', subtitle, message, 'bg-primary', 'text-white', 'text-success', modalCallback, callbackParam); 
};

const showConfirmModal = (message, confirmCallback, cancelCallback = false) => {
  if(confirmCallback < 1) return false;

  let modalComponent = $('#modalConfirmation');

  $('#modalConfirmationMessage').html(message);

  modalComponent.modal('toggle');  
  
  modalComponent.off('hidden.bs.modal');
  modalComponent.off('click');

  if(confirmCallback) {
    $('#modalConfirmButton').on('click', function () {
      confirmCallback();
    });
  }
  if(cancelCallback) {
    modalComponent.on('hidden.bs.modal', function () {
      cancelCallback();
    });
  }
};