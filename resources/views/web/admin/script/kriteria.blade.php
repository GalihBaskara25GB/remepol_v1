//check if token is valid before continue action 
isTokenValid();
let apiUrlKriteria = `${apiUrl}kriteria`;

let kriteriaForm = $(`#kriteriaForm`);
let formTitle = $(`#cardFormTitle`);
let containerForm = $(`#formContainer`);
let containerTable = $(`#tableContainer`);
let isUpdate = false;
let updateId = undefined;

let nextPageUrl = apiUrlKriteria;
let prevPageUrl = apiUrlKriteria;
let firstPageUrl = apiUrlKriteria;
let lastPageUrl = apiUrlKriteria;

const initKriteria = (url) => {
  showLoader();
  hideForm(true);
  showTable();

  let failedRedirectUrl = `${webUrl}kriteria`;

  if(!userData) {
    removeLocalStorage(localStorageAuthKey);

    return showErrorModal(`Unauthorized action, please log in`, redirect, unauthorizedRedirectUrl, 'Unauthorized');
  }
  
  $.ajax({
    type: "GET",  
    url: url,
    beforeSend: function (xhr) {
      xhr.setRequestHeader('Authorization', `Bearer ${userData.token}`);
    },
    contentType: "application/json",
    success: function(res){ 

      if(res.data) {
        $(`#tbodyKriteria`).html('');
        
        $.each(res.data, function (index, value) {
          $(`#tbodyKriteria`).append(`
            <tr>
              <td>
                <div class="d-flex px-2 py-1">
                  <a href="javascript:;" class="" data-bs-toggle="tooltip" data-bs-placement="bottom" title="see detail">
                    ${value.nama}
                  </a>
                </div>
              </td>
              <td class="text-sm">
                ${value.atribut}
              </td>
              <td class="text-sm">
                ${value.bobot}
              </td>
              <td class="text-sm">
                ${value.keterangan}
              </td>
              <td class="align-middle">
                <button type="button" value="${value.id}" class="btn bg-default btn-sm w-50 btnUpdate" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
                  Edit
                </button>
                <button type="button" value="${value.id}" class="btn bg-danger btn-sm text-white w-50 btnDelete" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
                  Delete
                </button>
              </td>
            </tr>
          `);
        });

        initPagination(res.pagination, res.data.length);
      }

      hideLoader();
    },
    error: function(err) { 
      hideLoader();
      if(err.status == 401) {
        return showErrorModal(`Unauthorized action, please log in`, redirect, unauthorizedRedirectUrl, 'Unauthorized');
      }
      return showErrorModal(`Something went wrong, please contact Administrator`, redirect, failedRedirectUrl, 'Error');
    }       
  });
};

const initPagination = (paginationData, numCurrentData) => {
  $('#paginationText').html(`
    Showing ${numCurrentData} of ${paginationData.total} Entries
  `);

  nextPageUrl = paginationData.next_page_url;
  prevPageUrl = paginationData.prev_page_url;
  firstPageUrl = paginationData.first_page_url;
  lastPageUrl = paginationData.last_page_url;

  if(paginationData.current_page == 1) {
    $('#paginationFirst').hide();

  } else {
    $('#paginationFirst').show();
  }

  if(paginationData.current_page == Math.ceil(paginationData.total / paginationData.per_page)) {
    $('#paginationLast').hide();

  } else {
    $('#paginationLast').show();
  }

  if(paginationData.next_page_url == null) {
    $('#paginationNext').hide();

  } else {
    $('#paginationNext').show();
  }

  if(paginationData.prev_page_url == null) {
    $('#paginationPrev').hide();

  } else {
    $('#paginationPrev').show();
  }

  $('#paginationCurrent').html(paginationData.current_page);
  $('#paginationCurrent').on('click', function(e) {
      e.preventDefault();
  });

};

//delete
$(document).on('click', '.btnDelete', function (e) {
  e.preventDefault();

  showLoader();
  let id = $(this).val();
  
  $.ajax({
    type: "DELETE",  
    url: `${apiUrlKriteria}/${id}`,
    beforeSend: function (xhr) {
      xhr.setRequestHeader('Authorization', `Bearer ${userData.token}`);
    },
    contentType: "application/json",
    dataType: defaultDataType,
    success: function(res){  
      hideLoader();

      if(!res.message) 
        return showErrorModal('Something went wrong, please contact Administrator'); 
      
      return showSuccessModal(res.message, initKriteria, apiUrlKriteria);

    },
    error: function(err) { 
      hideLoader();

      let message = 'Something Went Wrong :(';
      if(err.responseJSON.message!== undefined) message = err.responseJSON.message;
      
      if(err.status == 401) {
        removeLocalStorage();
        return showErrorModal(`Unauthorized action, please log in`, redirect, unauthorizedRedirectUrl, 'Unauthorized');
      }
      return showErrorModal(message, err.statusText); 
    }       
  });
});

//update
$(document).on('click', '.btnUpdate', function (e) {
  e.preventDefault();
  isUpdate = true;
  updateId = $(this).val();
  
  showLoader();
  
  $.ajax({
    type: "GET",  
    url: `${apiUrlKriteria}/${updateId}`,
    beforeSend: function (xhr) {
      xhr.setRequestHeader('Authorization', `Bearer ${userData.token}`);
    },
    contentType: "application/json",
    dataType: defaultDataType,
    success: function(res){
      hideLoader();

      if(!res.data) 
        return showErrorModal('Something went wrong, please contact Administrator'); 
      
      hideTable();
      fillForm(res.data);
      showForm();  

    },
    error: function(err) { 
      hideLoader();

      let message = 'Something Went Wrong :(';
      if(err.responseJSON.message!== undefined) message = err.responseJSON.message;
      
      if(err.status == 401) {
        removeLocalStorage();
        return showErrorModal(`Unauthorized action, please log in`, redirect, unauthorizedRedirectUrl, 'Unauthorized');
      }
      return showErrorModal(message, err.statusText); 
    }       
  });
});

//Form & Table Behaviour
const hideForm = (reset = false) => {
  isUpdate = false;
  formTitle.html('Add Kriteria');
  updateId = undefined;
  containerForm.hide();
  resetForm(reset);
};

const showForm = (reset = false) => {
  if(isUpdate == true) formTitle.html('Edit Kriteria');
  containerForm.show();
  resetForm(reset);
};

const resetForm = (reset = true) => {
  if(reset == true) {
    kriteriaForm[0].reset();
  }
};

const hideTable = () => {
  containerTable.hide();
};

const showTable = () => {
  containerTable.show();
};


initKriteria(apiUrlKriteria);

//Pagination init
$('#paginationPrev').on('click', function(e) {
  e.preventDefault();

  initKriteria(prevPageUrl);
});

$('#paginationNext').on('click', function(e) {
  e.preventDefault();

  initKriteria(nextPageUrl);
});

$('#paginationFirst').on('click', function(e) {
  e.preventDefault();

  initKriteria(firstPageUrl);
});

$('#paginationLast').on('click', function(e) {
  e.preventDefault();

  initKriteria(lastPageUrl);
});


//form Behaviour
$('#btnAddData').on('click', function(e) {
  e.preventDefault();

  hideTable();
  showForm(true);
}); 

const fillForm = (data) => {
  $('#nama').val(data.nama);
  $('#atribut').val(data.atribut).trigger('change');
  $('#bobot').val(data.bobot);
  $('#keterangan').val(data.keterangan);
};

kriteriaForm.on('submit', function(e) {
  e.preventDefault();
  showLoader();

  let formData = JSON.stringify(kriteriaForm.serializeObject());
  if(isUpdate == false) {
    $.ajax({
      type: "POST",  
      url: apiUrlKriteria,
      beforeSend: function (xhr) {
        xhr.setRequestHeader('Authorization', `Bearer ${userData.token}`);
      },
      contentType: "application/json",
      data: formData, 
      dataType: defaultDataType,
      success: function(res){  
        hideLoader();

        if(!res.data) 
          return showErrorModal('Something went wrong, please contact Administrator'); 
        
        return showSuccessModal(`Data saved successfully`, initKriteria, apiUrlKriteria);

      },
      error: function(err) { 
        hideLoader();

        let message = 'Something Went Wrong :(';
        if(err.responseJSON.message!== undefined) message = err.responseJSON.message;
        
        if(err.status == 401) {
          removeLocalStorage();
          return showErrorModal(`Unauthorized action, please log in`, redirect, unauthorizedRedirectUrl, 'Unauthorized');
        }
        return showErrorModal(message, false, false, err.statusText); 
      }       
    });
  
  } else {
    $.ajax({
      type: "PUT",  
      url: `${apiUrlKriteria}/${updateId}`,
      beforeSend: function (xhr) {
        xhr.setRequestHeader('Authorization', `Bearer ${userData.token}`);
      },
      contentType: "application/json",
      data: formData, 
      dataType: defaultDataType,
      success: function(res){  

        hideLoader();

        if(!res.data) 
          return showErrorModal('Something went wrong, please contact Administrator'); 
        
        return showSuccessModal(`Data saved successfully`, initKriteria, apiUrlKriteria);
        //initKriteria(apiUrlKriteria);

      },
      error: function(err) { 
        hideLoader();
        
        let message = 'Something Went Wrong :(';
        if(err.responseJSON.message!== undefined) message = err.responseJSON.message;
        
        if(err.status == 401) {
          removeLocalStorage();
          return showErrorModal(`Unauthorized action, please log in`, redirect, unauthorizedRedirectUrl, 'Unauthorized');
        }
        return showErrorModal(message, false, false, err.statusText); 
      }       
    });
  }
});

$('#btnCloseForm').on('click', function(e) {
  e.preventDefault();
  
  hideForm();
  showTable();
});

