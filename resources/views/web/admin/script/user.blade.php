//check if token is valid before continue action 
isTokenValid();
let apiUrlUser = `${apiUrl}user`;

let userForm = $(`#userForm`);
let formTitle = $(`#cardFormTitle`);
let containerForm = $(`#formContainer`);
let containerTable = $(`#tableContainer`);
let isUpdate = false;
let updateId = undefined;

let nextPageUrl = apiUrlUser;
let prevPageUrl = apiUrlUser;
let firstPageUrl = apiUrlUser;
let lastPageUrl = apiUrlUser;

// search
$(document).on('keyup', '#searchInput', function (e) {
  var apiSearchUrl = `${apiUrlUser}?filterBy=name&filterValue=${$(e.target).val()}`
  
  initUser(apiSearchUrl, false);
});

const initUser = (url, withLoader = true) => {
  if (withLoader)
    showLoader();
  hideForm(true);
  showTable();

  let failedRedirectUrl = `${webUrl}user`;

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
        $(`#tbodyUser`).html('');
        
        $.each(res.data, function (index, value) {
          $(`#tbodyUser`).append(`
            <tr>
              <td>
                <div class="d-flex px-2 py-1">
                  <a href="javascript:;" class="" data-bs-toggle="tooltip" data-bs-placement="bottom" title="see detail">
                    ${value.name}
                  </a>
                </div>
              </td>
              <td>
                ${value.email}
              </td>
              <td class="text-sm text-uppercase">
                ${value.role}
              </td>
              <td class="align-middle">
                <button type="button" value="${value.id}" class="btn bg-default btn-sm w-50 btnUpdate" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit" ${userData.user.id == value.id ? 'disabled' : ''}>
                  Edit
                </button>
                <button type="button" value="${value.id}" class="btn bg-danger btn-sm text-white w-50 btnDelete" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete" ${userData.user.id == value.id ? 'disabled' : ''}>
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
      if(err.status == 401) {
        return showErrorModal(`Unauthorized action, please log in`, redirect, unauthorizedRedirectUrl, 'Unauthorized');
      }
      return showErrorModal(`Something went wrong, please contact Adminsitrator`, redirect, failedRedirectUrl, 'Error');
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
    url: `${apiUrlUser}/${id}`,
    beforeSend: function (xhr) {
      xhr.setRequestHeader('Authorization', `Bearer ${userData.token}`);
    },
    contentType: "application/json",
    dataType: defaultDataType,
    success: function(res){  
      hideLoader();

      if(!res.message) 
        return showErrorModal('Something went wrong, please contact Administrator'); 
      
      return showSuccessModal(res.message, initUser, apiUrlUser);

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
    url: `${apiUrlUser}/${updateId}`,
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
  formTitle.html('Add Users');
  updateId = undefined;
  containerForm.hide();
  resetForm(reset);
};

const showForm = (reset = false) => {
  if(isUpdate == true) formTitle.html('Edit User');
  containerForm.show();
  resetForm(reset);
};

const resetForm = (reset = true) => {
  if(reset == true) {
    userForm[0].reset();
  }
};

const hideTable = () => {
  containerTable.hide();
};

const showTable = () => {
  containerTable.show();
};


initUser(apiUrlUser);

//Pagination init
$('#paginationPrev').on('click', function(e) {
  e.preventDefault();

  initUser(prevPageUrl);
});

$('#paginationNext').on('click', function(e) {
  e.preventDefault();

  initUser(nextPageUrl);
});

$('#paginationFirst').on('click', function(e) {
  e.preventDefault();

  initUser(firstPageUrl);
});

$('#paginationLast').on('click', function(e) {
  e.preventDefault();

  initUser(lastPageUrl);
});


//form Behaviour
$('#btnAddData').on('click', function(e) {
  e.preventDefault();

  hideTable();
  showForm(true);
}); 

const fillForm = (data) => {
  $('#name').val(data.name);
  $('#email').val(data.email);
  $('#role').val(data.role).trigger('change');
  $('#password').val('');
  $('#password_confirmation').val('');
};

userForm.on('submit', function(e) {
  e.preventDefault();
  showLoader();

  let formData = JSON.stringify(userForm.serializeObject());

  if(isUpdate == false) {
    $.ajax({
      type: "POST",  
      url: apiUrlUser,
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
        
        return showSuccessModal(`Data saved successfully`, initUser, apiUrlUser);

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
      url: `${apiUrlUser}/${updateId}`,
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
        
        return showSuccessModal(`Data saved successfully`, initUser, apiUrlUser);

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

