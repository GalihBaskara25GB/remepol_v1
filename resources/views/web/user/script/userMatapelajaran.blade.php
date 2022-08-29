//check if token is valid before continue action 
isTokenValid('user');
let apiUrlMatapelajaran = `${apiUrl}matapelajaran`;

let nextPageUrl = apiUrlMatapelajaran;
let prevPageUrl = apiUrlMatapelajaran;
let firstPageUrl = apiUrlMatapelajaran;
let lastPageUrl = apiUrlMatapelajaran;

const initMatapelajaran = (url) => {
  showLoader();

  let failedRedirectUrl = `${webUrl}matapelajaran`;

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
        $(`#tbodyMatapelajaran`).html('');
        
        $.each(res.data, function (index, value) {
          $(`#tbodyMatapelajaran`).append(`
            <tr>
              <td>
                <div class="d-flex px-2 py-1">
                  <a href="javascript:;" class="" data-bs-toggle="tooltip" data-bs-placement="bottom" title="see detail">
                    ${value.nama}
                  </a>
                </div>
              </td>
              <td class="text-sm">
                ${value.semester}
              </td>
              <td class="text-sm">
                ${value.guru}
              </td>
              <td class="text-sm">
                ${value.keterangan}
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


initMatapelajaran(apiUrlMatapelajaran);

//Pagination init
$('#paginationPrev').on('click', function(e) {
  e.preventDefault();

  initMatapelajaran(prevPageUrl);
});

$('#paginationNext').on('click', function(e) {
  e.preventDefault();

  initMatapelajaran(nextPageUrl);
});

$('#paginationFirst').on('click', function(e) {
  e.preventDefault();

  initMatapelajaran(firstPageUrl);
});

$('#paginationLast').on('click', function(e) {
  e.preventDefault();

  initMatapelajaran(lastPageUrl);
});

