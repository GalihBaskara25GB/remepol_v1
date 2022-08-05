//check if token is valid before continue action 
isTokenValid();
let apiUrlAlternatif = `${apiUrl}alternatif`;
let apiUrlMatakuliah = `${apiUrl}matakuliah`;

let alternatifForm = $(`#alternatifForm`);
let formTitle = $(`#cardFormTitle`);
let containerForm = $(`#formContainer`);
let containerTable = $(`#tableContainer`);
let isUpdate = false;
let updateId = undefined;
let selectMatakuliah = $(`#matakuliah_id`);

let nextPageUrl = apiUrlAlternatif;
let prevPageUrl = apiUrlAlternatif;
let firstPageUrl = apiUrlAlternatif;
let lastPageUrl = apiUrlAlternatif;

const initAlternatif = (url) => {
  showLoader();
  hideForm(true);
  showTable();

  let failedRedirectUrl = `${webUrl}alternatif`;

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
      console.log(res);

      if(res.data) {
        $(`#tbodyAlternatif`).html('');
        
        $.each(res.data, function (index, value) {
          $(`#tbodyAlternatif`).append(`
            <tr>
              <td>
                <div class="d-flex px-2 py-1">
                  <a href="javascript:;" class="" data-bs-toggle="tooltip" data-bs-placement="bottom" title="see detail">
                    ${value.nama}
                  </a>
                </div>
              </td>
              <td class="text-sm text-capitalize">
                ${value.matakuliah_nama}
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

const initSelectMatakuliah = () => {

  $.ajax({
    type: "GET",  
    url: apiUrlMatakuliah,
    beforeSend: function (xhr) {
      xhr.setRequestHeader('Authorization', `Bearer ${userData.token}`);
    },
    contentType: "application/json",
    success: function(res){ 
      if(res.data) {
        selectMatakuliah.html(`
         <option value="">Choose Option</option>
        `);
        
        $.each(res.data, function (index, value) {
          selectMatakuliah.append(`
            <option value="${value.id}" class="text-capitalize">${value.nama}</option>
          `);
        });
      }
    },
    error: function(err) { 
      if(err.status == 401) {
        return showErrorModal(`Unauthorized action, please log in`, redirect, unauthorizedRedirectUrl, 'Unauthorized');
      }
      return showErrorModal(`Something went wrong, please contact Administrator`, redirect, failedRedirectUrl, 'Error');
    }       
  });
}

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
    url: `${apiUrlAlternatif}/${id}`,
    beforeSend: function (xhr) {
      xhr.setRequestHeader('Authorization', `Bearer ${userData.token}`);
    },
    contentType: "application/json",
    dataType: defaultDataType,
    success: function(res){  
      hideLoader();

      if(!res.message) 
        return showErrorModal('Something went wrong, please contact Administrator'); 
      
      return showSuccessModal(res.message, initAlternatif, apiUrlAlternatif);

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
    url: `${apiUrlAlternatif}/${updateId}`,
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
  formTitle.html('Add Alternatif');
  updateId = undefined;
  containerForm.hide();
  resetForm(reset);
};

const showForm = (reset = false) => {
  if(isUpdate == true) formTitle.html('Edit Alternatif');
  containerForm.show();
  resetForm(reset);
};

const resetForm = (reset = true) => {
  if(reset == true) {
    alternatifForm[0].reset();
  }
};

const hideTable = () => {
  containerTable.hide();
};

const showTable = () => {
  containerTable.show();
};


initAlternatif(apiUrlAlternatif);
initSelectMatakuliah();

//Pagination init
$('#paginationPrev').on('click', function(e) {
  e.preventDefault();

  initAlternatif(prevPageUrl);
});

$('#paginationNext').on('click', function(e) {
  e.preventDefault();

  initAlternatif(nextPageUrl);
});

$('#paginationFirst').on('click', function(e) {
  e.preventDefault();

  initAlternatif(firstPageUrl);
});

$('#paginationLast').on('click', function(e) {
  e.preventDefault();

  initAlternatif(lastPageUrl);
});


//form Behaviour
$('#btnAddData').on('click', function(e) {
  e.preventDefault();

  hideTable();
  showForm(true);
}); 

const fillForm = (data) => {
  $('#nama').val(data.nama);
  $('#keterangan').val(data.keterangan);
  $('#matakuliah_id').val(data.matakuliah_id).trigger('change');
};

alternatifForm.on('submit', function(e) {
  e.preventDefault();
  showLoader();

  let formData = JSON.stringify(alternatifForm.serializeObject());
  console.log(formData);
  if(isUpdate == false) {
    $.ajax({
      type: "POST",  
      url: apiUrlAlternatif,
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
        
        return showSuccessModal(`Data saved successfully`, initAlternatif, apiUrlAlternatif);

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
      url: `${apiUrlAlternatif}/${updateId}`,
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
        
        return showSuccessModal(`Data saved successfully`, initAlternatif, apiUrlAlternatif);

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

