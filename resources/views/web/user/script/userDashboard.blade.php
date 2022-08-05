//check if token is valid before continue action 
isTokenValid('user');
let apiUrlCount = `${apiUrl}utility/count`;

const initDashboard = () => {
  let unauthenticatedRedirectUrl = `${webUrl}login`;

  if(!userData) {
    removeLocalStorage(localStorageAuthKey);

    return showErrorModal(`Unauthorized action, please log in`, redirect, unauthenticatedRedirectUrl, 'Unauthorized');
  }
  
  $.ajax({
    type: "GET",  
    url: apiUrlCount,
    beforeSend: function (xhr) {
      xhr.setRequestHeader('Authorization', `Bearer ${userData.token}`);
    },
    contentType: "application/json",
    success: function(res){ 
      if(res.data) {
        $.each(res.data, function (index, value) {
          $(`#num\\[${index}\\]`).html(`
            ${value}
            <span class="text-success text-sm font-weight-bolder">active</span>
          `);
        });
      }
    },
    error: function(err) { 
      console.log(err);
    }       
  });
};

initDashboard();