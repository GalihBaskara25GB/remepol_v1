let formLogin = $('#formLogin');
let apiUrlLogin = `${apiUrl}login`;

formLogin.on('submit', function(e) {
  e.preventDefault();
  showLoader();

  let formData = JSON.stringify(formLogin.serializeObject());

  $.ajax({
    type: "POST",  
    url: apiUrlLogin,
    contentType: "application/json",
    data: formData, 
    dataType: defaultDataType,
    success: function(res){  
      hideLoader();

      if(!res.user || !res.token) 
        return showErrorModal('Something went wrong, please contact Administrator'); 
      
      if( saveLocalStorage('remepolUser', JSON.stringify(res)) ) {
          let redirectUrl = `${webUrl}dashboard`;
          if(res.user.role != 'administrator') redirectUrl = `${webUrl}user/dashboard`;
          return showSuccessModal(`Login Success<br>Welcome ${res.user.name}`, redirect, redirectUrl);
      } else {
        return showErrorModal('Failed to save local storage, please grant permission for local storage'); 
      }

    },
    error: function(err) { 
      hideLoader();

      let message = 'Something Went Wrong :(';
      if(err.responseJSON.message!== undefined) message = err.responseJSON.message;
      
      return showErrorModal(message, err.statusText); 
    }       
  });

});