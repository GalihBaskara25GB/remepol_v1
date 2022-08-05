var apiUrl   = `${window.location.origin}/api/`;
var webUrl = `${window.location.origin}/`;
var defaultDataType = "json";

//function for localStorage
const saveLocalStorage = (key, value) => {
    localStorage.setItem(key, value);
    if(localStorage.getItem(key)) return true;
    return false;
};

const getLocalStorage = (key) => {
    let localStorageData = localStorage.getItem(key);
    if(localStorageData) return JSON.parse(localStorageData);
    return false;
};

const removeLocalStorage = (key = []) => {
    if(!key.length || key.length == 0) localStorage.clear();
    else {
        if(!Array.isArray(key)) return localStorage.removeItem(key);
        $.each(key, function( index, value ) {
            localStorage.removeItem(value);
        });
        return true;
    }
}

//redirect function
const redirect = (url) => {
    window.location.replace(url);
};

//format date function
const dateDMY = (dateObject) => {
    const months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    var d = new Date(dateObject);
    var day = d.getDate();
    var month = d.getMonth();
    var year = d.getFullYear();
    if (day < 10) {
        day = "0" + day;
    }
    var date = day + " " + months[month] + " " + year;

    return date;
};

// add function to serialize form data
$.fn.serializeObject = function()
{
   var o = {};
   var a = this.serializeArray();
   $.each(a, function() {
       if (o[this.name]) {
           if (!o[this.name].push) {
               o[this.name] = [o[this.name]];
           }
           o[this.name].push(this.value || '');
       } else {
           o[this.name] = this.value || '';
       }
   });
   return o;
};

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.fn.serializeControls = function() {
  var data = {};

  function buildInputObject(arr, val) {
    if (arr.length < 1)
      return val;  
    var objkey = arr[0];
    if (objkey.slice(-1) == "]") {
      objkey = objkey.slice(0,-1);
    }  
    var result = {};
    if (arr.length == 1){
      result[objkey] = val;
    } else {
      arr.shift();
      var nestedVal = buildInputObject(arr,val);
      result[objkey] = nestedVal;
    }
    return result;
  }

  $.each(this.serializeArray(), function() {
    var val = this.value;
    var c = this.name.split("[");
    var a = buildInputObject(c, val);
    $.extend(true, data, a);
  });
  
  return data;
}

//load utility script
@include($pageProperties['scriptUtilityDir'].'.auth')
@include($pageProperties['scriptUtilityDir'].'.menu')
@include($pageProperties['scriptUtilityDir'].'.modal')
@include($pageProperties['scriptUtilityDir'].'.loader')

//load current page script
@include($pageProperties['scriptDir'].'.'.$pageProperties['currentPage'])

initMenu();

$('.logout').on('click', function(e) {
    e.preventDefault();

    return showConfirmModal(`You will be logged out from this app`, logout);
});