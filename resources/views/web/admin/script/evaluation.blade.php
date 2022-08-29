//check if token is valid before continue action 
isTokenValid();
let apiUrlEvaluation = `${apiUrl}evaluation`;
let apiUrlMatapelajaran = `${apiUrl}matapelajaran`;
let currentApiUrlEvaluation = apiUrlEvaluation;

let evaluationForm = $(`#evaluationForm`);
let selectMatapelajaran = $(`#matapelajaran_id`);
let resultContainer = $('#resultContainer');
let tableContainer = $('#tableContainer');

const initEvaluation = (url) => {
  showLoader();

  let failedRedirectUrl = `${webUrl}evaluation`;

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
        $(`#tbodyEvaluation`).html('');
        $(`#theadEvaluation`).html('');
        let evaluationsData = {};
        let headElement = '';
        let bodyElement = '';

        headElement += `<tr><th></th>`;
        $.each(res.data.kriterias, function (indexKriteria, valueKriteria) { 
          headElement += `<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">${valueKriteria.nama}</th>`;
        });
        headElement += `</tr>`;

        if((res.data.evaluations).length > 0) {
          $('.btnSave').prop('disabled', false);
          $('.btnShowResult').prop('disabled', false);
        } else {
          $('.btnSave').prop('disabled', true);
          $('.btnShowResult').prop('disabled', true);
        }
        
        $.each(res.data.evaluations, function (indexEvaluation, valueEvaluation) {
          if(!evaluationsData[valueEvaluation.alternatif_id]) evaluationsData[valueEvaluation.alternatif_id] = [];
          if(!evaluationsData[valueEvaluation.alternatif_id]['kriteria']) evaluationsData[valueEvaluation.alternatif_id]['kriteria'] = [];
          
          evaluationsData[valueEvaluation.alternatif_id]['nama'] = valueEvaluation.alternatif_nama;
          evaluationsData[valueEvaluation.alternatif_id]['kriteria'][valueEvaluation.kriteria_id] = valueEvaluation.value;
        });

        $.each(evaluationsData, function (index, value) {
          
          bodyElement += `
            <tr>
              <td>${evaluationsData[index]['nama']}</td>
          `;

          $.each(res.data.kriterias, function (indexKriteria, valueKriteria) { 
            $.each(value['kriteria'], function (indexEval, valueEval) {
              if(evaluationsData[index]['kriteria'][valueKriteria.id]) {
                bodyElement += `
                  <td>
                    <input 
                      class="form-control w-100"
                      type="number" 
                      max="100" 
                      min="0" 
                      id="value[${index}][${valueKriteria.id}]" 
                      name="value[${index}][${valueKriteria.id}]" 
                      value="${evaluationsData[index]['kriteria'][valueKriteria.id]}" />
                  </td>
                `;
                return false;

              } else {
                bodyElement += `
                  <td>
                    <input 
                      class="form-control w-100"
                      type="number" 
                      max="100" 
                      min="0" 
                      id="value[${index}][${valueKriteria.id}]" 
                      name="value[${index}][${valueKriteria.id}]" 
                      value="0" />
                  </td>
                `;
                return false;

              }
            });
          });

          bodyElement += `</tr>`;
        });        

        $(`#theadEvaluation`).append(headElement);
        $(`#tbodyEvaluation`).append(bodyElement);
      }

      currentApiUrlEvaluation = url;
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

const initSelectMatapelajaran = () => {

  $.ajax({
    type: "GET",  
    url: apiUrlMatapelajaran,
    beforeSend: function (xhr) {
      xhr.setRequestHeader('Authorization', `Bearer ${userData.token}`);
    },
    contentType: "application/json",
    success: function(res){ 
      if(res.data) {
        selectMatapelajaran.html(`
         <option value="">Choose Option</option>
        `);
        
        $.each(res.data, function (index, value) {
          selectMatapelajaran.append(`
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

//reload data based on matapelajaran
$(document).on('change', '#matapelajaran_id', function (e) {
  e.preventDefault();
  let apiUrlReloadEvaluation = `${apiUrlEvaluation}?filterBy=matapelajaran_id&filterValue=${selectMatapelajaran.val()}`;
  initEvaluation(apiUrlReloadEvaluation);
});

$(document).on('click', '.btnShowResult', function (e) {
  e.preventDefault();
  showResult();
});

$(document).on('click', '.btnCloseResult', function (e) {
  e.preventDefault();
  closeResult();
});

initEvaluation(apiUrlEvaluation);
initSelectMatapelajaran();

resultContainer.hide();
tableContainer.show();

evaluationForm.on('submit', function(e) {
  e.preventDefault();
  showLoader();

  let key = [];
  let formData = evaluationForm.serializeArray();
  let newFormData = [];

  $.each(formData, function(i, v) {
    key = (((v['name']).slice(0, -1)).replace('value[', '')).split('][');
    if(!newFormData[key[0]])  newFormData[key[0]] = {};
    newFormData[key[0]][key[1]] = v['value'];
  });
  
  newFormData = Object.assign({}, newFormData);
  formData = JSON.stringify(newFormData);

  $.ajax({
    type: "POST",  
    url: apiUrlEvaluation,
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
      
      return showSuccessModal(`Data saved successfully`, initEvaluation, currentApiUrlEvaluation);

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
  
});

const closeResult = () => {
  tableContainer.show();
  resultContainer.hide();
}

const showResult = () => {
  tableContainer.hide();
  resultContainer.show();
  $('#cardResultTitle').html(`SAW Result of Mata Pelajaran ${selectMatapelajaran.children("option").filter(":selected").text()}`);
  showLoader();

  let failedRedirectUrl = `${webUrl}evaluation`;

  if(!userData) {
    removeLocalStorage(localStorageAuthKey);

    return showErrorModal(`Unauthorized action, please log in`, redirect, unauthorizedRedirectUrl, 'Unauthorized');
  }
  
  $.ajax({
    type: "GET",  
    url: `${apiUrlEvaluation}/${selectMatapelajaran.val()}`,
    beforeSend: function (xhr) {
      xhr.setRequestHeader('Authorization', `Bearer ${userData.token}`);
    },
    contentType: "application/json",
    success: function(res){ 
      if(res.data) {
        $(`#tbodyResult`).html('');
        $(`#theadResult`).html('');
        
        let headElement = '';
        let bodyElement = '';

        headElement += `
          <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Alternatif</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SAW Value</th>
          </tr>
        `;
        
        $.each(res.data, function (indexResult, valueResult) {
          bodyElement += `
            <tr>
              <td>${valueResult.alternatif_nama}</td>
              <td>${valueResult.saw_value}</td>
            </tr>
          `;
        });       

        $(`#theadResult`).append(headElement);
        $(`#tbodyResult`).append(bodyElement);
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
}

