let localStorageAuthKey = 'remepolUser';
let apiUrlCheck = `${apiUrl}check`;
let apiUrlLogout = `${apiUrl}logout`;
let userData = getLocalStorage(localStorageAuthKey);
let unauthorizedRedirectUrl = `${webUrl}login`;

const isTokenValid = (role = 'administrator') => {
  
  if(!userData) {
    removeLocalStorage(localStorageAuthKey);

    return showErrorModal(`Unauthorized action, please log in`, redirect, unauthorizedRedirectUrl, 'Unauthorized');
  }

  $.ajax({
    type: "GET",  
    url: apiUrlCheck,
    beforeSend: function (xhr) {
      xhr.setRequestHeader('Authorization', `Bearer ${userData.token}`);
    },
    contentType: "application/json",
    success: function(res){ 
      if(!res.user) 
        return showErrorModal(`Unauthorized action, please log in`, redirect, unauthorizedRedirectUrl, 'Unauthorized');
        
      if(res.user.role != role) 
        return showErrorModal(`Unauthorized action, please log in`, redirect, unauthorizedRedirectUrl, 'Unauthorized');
    
    },
    error: function(err) { 
      return showErrorModal(`Unauthorized action, please log in`, redirect, unauthorizedRedirectUrl, 'Unauthorized');
    }       
  });

};

const logout = () => {
  showLoader();

  let redirectUrl = `${webUrl}login`;
  
  if(!userData) {
    removeLocalStorage(localStorageAuthKey);
    return showErrorModal(`Unauthorized action, please log in`, redirect, unauthorizedRedirectUrl, 'Unauthorized');
  }

  $.ajax({
    type: "POST",  
    url: apiUrlLogout,
    beforeSend: function (xhr) {
      xhr.setRequestHeader('Authorization', `Bearer ${userData.token}`);
    },
    contentType: "application/json",
    success: function(res){
      removeLocalStorage(); 
      redirect(redirectUrl);
    },
    error: function(err) { 
      removeLocalStorage();
      redirect(redirectUrl);
    }       
  });
};