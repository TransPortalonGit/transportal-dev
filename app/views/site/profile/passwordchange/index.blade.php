@extends('layouts.master')

@section('head')

<script type="text/javascript">

$(document).ready(function(){
//For company editing
  $("#item-company").click(function(){
    $("#item-company").hide();
    $("#setting-company").show();
  });  
  $("#clickdone4").click(function(){
    $("#item-company").show();
    $("#setting-company").hide();
  });
  //For username editing
  $("#item-username").click(function(){
    $("#item-username").hide();
    $("#setting-username").show();
  });  
  $("#clickdone1").click(function(){
    $("#item-username").show();
    $("#setting-username").hide();
  });
  //For email editing
  $("#item-email").click(function(){
    $("#item-email").hide();
    $("#setting-email").show();
  });  
  $("#clickdone2").click(function(){
    $("#item-email").show();
    $("#setting-email").hide();
  });
  //For address editing
  $("#item-address").click(function(){
    $("#item-address").hide();
    $("#setting-address").show();
  });  
  $("#clickdone3").click(function(){
    $("#item-address").show();
    $("#setting-address").hide();
  });
  //For homepage editing
  $("#item-homepage").click(function(){
    $("#item-homepage").hide();
    $("#setting-homepage").show();
  });  
  $("#clickdone5").click(function(){
    $("#item-homepage").show();
    $("#setting-homepage").hide();
  });
  //For facebook editing
  $("#item-facebook").click(function(){
    $("#item-facebook").hide();
    $("#setting-facebook").show();
  });  
  $("#clickdone6").click(function(){
    $("#item-facebook").show();
    $("#setting-facebook").hide();
  });
  //For googleplus editing
  $("#item-googleplus").click(function(){
    $("#item-googleplus").hide();
    $("#setting-googleplus").show();
  });  
  $("#clickdone7").click(function(){
    $("#item-googleplus").show();
    $("#setting-googleplus").hide();
  });
  //For github editing
  $("#item-github").click(function(){
    $("#item-github").hide();
    $("#setting-github").show();
  });  
  $("#clickdone8").click(function(){
    $("#item-github").show();
    $("#setting-github").hide();
  });
  //For academia editing
  $("#item-academia").click(function(){
    $("#item-academia").hide();
    $("#setting-academia").show();
  });  
  $("#clickdone9").click(function(){
    $("#item-academia").show();
    $("#setting-academia").hide();
  });
  //For xing editing
  $("#item-xing").click(function(){
    $("#item-xing").hide();
    $("#setting-xing").show();
  });  
  $("#clickdone10").click(function(){
    $("#item-xing").show();
    $("#setting-xing").hide();
  });
  //For linkedin editing
  $("#item-linkedin").click(function(){
    $("#item-linkedin").hide();
    $("#setting-linkedin").show();
  });  
  $("#clickdone11").click(function(){
    $("#item-linkedin").show();
    $("#setting-linkedin").hide();
  });
  //For threedplatform editing
  $("#item-threedplatform").click(function(){
    $("#item-threedplatform").hide();
    $("#setting-threedplatform").show();
  });  
  $("#clickdone12").click(function(){
    $("#item-threedplatform").show();
    $("#setting-threedplatform").hide();
  });
  //For twitter editing
  $("#item-twitter").click(function(){
    $("#item-twitter").hide();
    $("#setting-twitter").show();
  });  
  $("#clickdone13").click(function(){
    $("#item-twitter").show();
    $("#setting-twitter").hide();
  });
});

function limitText(limitField, limitCount, limitNum) {
  if(limitField.value.length > limitNum) {
    limitField.value = limitField.value.substring(0, limitNum);
  } else {
    limitCount.value = limitNum - limitField.value.length;
  }
}

function storeUsername() {

  var inputOldusername = document.getElementById("userusernamevalue").value;
  localStorage.setItem("userusernamevalue", inputOldusername);

  var inputUsername = document.getElementById("username").value;
  localStorage.setItem("username", inputUsername);

  if(inputUsername) {
    if(inputUsername != inputOldusername) {
    document.getElementById("oldUsername").innerHTML = "<strike>{{$user->username}}</strike>" + " " + "<font color='red'>" + inputUsername + "</font>";
    document.querySelector('#stored_username').value = inputUsername;
      } 
    } else {
    document.getElementById("oldUsername").innerHTML = "{{$user->username}}";
  }
}

function storeEmail() {
  
  var inputOldmail = document.getElementById("usermailvalue").value;
  localStorage.setItem("usermailvalue", inputOldmail);

  var inputFirstmail = document.getElementById("first_mail").value;
  var inputSecondmail = document.getElementById("second_mail").value;
  localStorage.setItem("first_mail", inputFirstmail);
  localStorage.setItem("second_mail", inputSecondmail);
  
  if(inputFirstmail != inputOldmail && inputFirstmail == inputSecondmail) {
   document.getElementById("oldEmail").innerHTML = "<strike>{{$user->email}}</strike>" + " " + "<font color='red'>" + inputFirstmail + "</font>";
   document.querySelector('#stored_email').value = inputFirstmail; 
  } else if(inputFirstmail == inputOldmail && inputFirstmail == inputSecondmail) {
   document.getElementById("oldEmail").innerHTML = "{{$user->email}}";
  }

  if(!inputFirstmail && !inputSecondmail) {
   document.getElementById("oldEmail").innerHTML = "{{$user->email}}"; 
  }

  if(inputFirstmail != inputSecondmail) {
    alert('The e-mails you entered do not match');
  }
}

function storeAddress() {

  var inputOldstreet = document.getElementById("userstreetvalue").value;
  var inputOldzipcode = document.getElementById("userzipcodevalue").value;
  var inputOldcity = document.getElementById("usercityvalue").value;   
  localStorage.setItem("userstreetvalue", inputOldstreet);
  localStorage.setItem("userzipcodevalue", inputOldzipcode);
  localStorage.setItem("usercityvalue", inputOldcity);

  var inputStreet = document.getElementById("street").value;
  var inputZipcode = document.getElementById("zipcode").value;
  var inputCity = document.getElementById("city").value;
  localStorage.setItem("street", inputStreet);
  localStorage.setItem("zipcode", inputZipcode);
  localStorage.setItem("city", inputCity);

  if(inputStreet || inputZipcode || inputCity) {
    // 1: [NEW] STREET, [NO] ZIPCODE, [NO] CITY
    if(inputStreet != inputOldstreet && !inputZipcode && !inputCity) {
      document.getElementById("oldAddress").innerHTML = "<strike>{{$user->street}}" + ", " + " {{$user->zipcode}}" + " " + "{{$user->city}}</strike>" + " " + "<font color='red'>" + inputStreet + "</font>" + " " + "{{$user->zipcode}}" + " " + "{{$user->city}}";
      document.querySelector('#stored_street').value = inputStreet;
    } 
    // 2: [NO] STREET, [NEW] ZIPCODE, [NO] CITY
    else if(inputZipcode != inputOldzipcode && !inputStreet && !inputCity) {
      document.getElementById("oldAddress").innerHTML = "<strike>{{$user->street}}" + ", " + " {{$user->zipcode}}" + " " + "{{$user->city}}</strike>" + " " + "{{$user->street}}" + ", " + "<font color='red'>" + inputZipcode + "</font>" + " " + "{{$user->city}}";
      document.querySelector('#stored_zipcode').value = inputZipcode;
    } 
    // 3: [NO] STREET, [NO] ZIPCODE, [NEW] CITY
    else if(inputCity != inputOldcity && !inputStreet && !inputZipcode) {
      document.getElementById("oldAddress").innerHTML = "<strike>{{$user->street}}" + ", " + " {{$user->zipcode}}" + " " + "{{$user->city}}</strike>" + " " + "{{$user->street}}" + ", " + "{{$user->zipcode}}" + " " + "<font color='red'>" + inputCity + "</font>";
      document.querySelector('#stored_city').value = inputCity;
    } 
    // 4: [NEW] STREET, [NEW] ZIPCODE, [NO] CITY
    else if(inputStreet != inputOldstreet && inputZipcode != inputOldzipcode && !inputCity) {
      document.getElementById("oldAddress").innerHTML = "<strike>{{$user->street}}" + ", " + " {{$user->zipcode}}" + " " + "{{$user->city}}</strike>" + " " + "<font color='red'>" + inputStreet + ", " + inputZipcode + "</font>" + " " + "{{$user->city}}";
      document.querySelector('#stored_street').value = inputStreet;
      document.querySelector('#stored_zipcode').value = inputZipcode;
    } 
    // 5: [NEW] STREET, [NO] ZIPCODE, [NEW] CITY
    else if(inputStreet != inputOldstreet && !inputZipcode && inputCity != inputOldcity) {
      document.getElementById("oldAddress").innerHTML = "<strike>{{$user->street}}" + ", " + " {{$user->zipcode}}" + " " + "{{$user->city}}</strike>" + " " + "<font color='red'>" + inputStreet + ", " + "{{$user->zipcode}}" + " " + "<font color='red'>" + inputCity + "</font>";
      document.querySelector('#stored_street').value = inputStreet;
      document.querySelector('#stored_city').value = inputCity;
    } 
    // 6: [NO] STREET, [NEW] ZIPCODE, [NEW] CITY
    else if(!inputStreet && inputZipcode != inputOldzipcode && inputCity != inputOldcity) {
      document.getElementById("oldAddress").innerHTML = "<strike>{{$user->street}}" + ", " + " {{$user->zipcode}}" + " " + "{{$user->city}}</strike>" + " " + "{{$user->street}}" + ", " + "<font color='red'>" + inputZipcode + " " + inputCity + "</font>";
      document.querySelector('#stored_zipcode').value = inputZipcode;
      document.querySelector('#stored_city').value = inputCity;
    } 
    // 7: [NEW] STREET, [NEW] ZIPCODE, [NEW] CITY
    else if(inputStreet != inputOldstreet && inputZipcode != inputOldzipcode && inputCity != inputOldcity) {
      document.getElementById("oldAddress").innerHTML = "<strike>{{$user->street}}" + ", " + " {{$user->zipcode}}" + " " + "{{$user->city}}</strike>" + " " + "<font color='red'>" + inputStreet + ", " + inputZipcode + " " + inputCity + "</font>";
      document.querySelector('#stored_street').value = inputStreet;
      document.querySelector('#stored_zipcode').value = inputZipcode;
      document.querySelector('#stored_city').value = inputCity;
    }
    // 8: [SAME] STREET, [SAME] ZIPCODE, [SAME] CITY
    else if(inputStreet == inputOldstreet && inputZipcode == inputOldzipcode && inputCity == inputOldcity) {
      document.getElementById("oldAddress").innerHTML = "{{$user->street}}" + ", " + " {{$user->zipcode}}" + " " + "{{$user->city}}";
    }
    // 9: [SAME] STREET, [NEW] ZIPCODE, [NEW] CITY
    else if(inputStreet == inputOldstreet && inputZipcode != inputOldzipcode && inputCity != inputOldcity) {
      document.getElementById("oldAddress").innerHTML = "<strike>{{$user->street}}" + ", " + " {{$user->zipcode}}" + " " + "{{$user->city}}</strike>" + " " + "{{$user->street}}" + ", " + "<font color='red'>" + inputZipcode + " " + inputCity + "</font>";
      document.querySelector('#stored_zipcode').value = inputZipcode;
      document.querySelector('#stored_city').value = inputCity;
    } 
    // 10: [NEW] STREET, [SAME] ZIPCODE, [NEW] CITY
    else if(inputStreet != inputOldstreet && inputZipcode == inputOldzipcode && inputCity != inputOldcity) {
      document.getElementById("oldAddress").innerHTML = "<strike>{{$user->street}}" + ", " + " {{$user->zipcode}}" + " " + "{{$user->city}}</strike>" + " " + "<font color='red'>" + inputStreet + ", " + "{{$user->zipcode}}" + " " + "<font color='red'>" + inputCity + "</font>";
      document.querySelector('#stored_street').value = inputStreet;
      document.querySelector('#stored_city').value = inputCity;
    }
    // 11: [NEW] STREET, [NEW] ZIPCODE, [SAME] CITY
    else if(inputStreet != inputOldstreet && inputZipcode != inputOldzipcode && inputCity == inputOldcity) {
      document.getElementById("oldAddress").innerHTML = "<strike>{{$user->street}}" + ", " + " {{$user->zipcode}}" + " " + "{{$user->city}}</strike>" + " " + "<font color='red'>" + inputStreet + ", " + inputZipcode + "</font>" + " " + "{{$user->city}}";
      document.querySelector('#stored_street').value = inputStreet;
      document.querySelector('#stored_zipcode').value = inputZipcode;
    }
    // 12: [SAME] STREET, [SAME] ZIPCODE, [NEW] CITY
     else if(inputCity != inputOldcity && inputStreet == inputOldstreet && inputZipcode == inputOldzipcode) {
      document.getElementById("oldAddress").innerHTML = "<strike>{{$user->street}}" + ", " + " {{$user->zipcode}}" + " " + "{{$user->city}}</strike>" + " " + "{{$user->street}}" + ", " + "{{$user->zipcode}}" + " " + "<font color='red'>" + inputCity + "</font>";
      document.querySelector('#stored_city').value = inputCity;
    }
    // 13: [NEW] STREET, [SAME] ZIPCODE, [SAME] CITY
    if(inputStreet != inputOldstreet && inputZipcode == inputOldzipcode && inputCity == inputOldcity) {
      document.getElementById("oldAddress").innerHTML = "<strike>{{$user->street}}" + ", " + " {{$user->zipcode}}" + " " + "{{$user->city}}</strike>" + " " + "<font color='red'>" + inputStreet + "</font>" + " " + "{{$user->zipcode}}" + " " + "{{$user->city}}";
      document.querySelector('#stored_street').value = inputStreet;
    }
    // 14: [SAME] STREET, [NEW] ZIPCODE, [SAME] CITY
    else if(inputZipcode != inputOldzipcode && inputStreet == inputOldstreet && inputCity == inputOldcity) {
      document.getElementById("oldAddress").innerHTML = "<strike>{{$user->street}}" + ", " + " {{$user->zipcode}}" + " " + "{{$user->city}}</strike>" + " " + "{{$user->street}}" + ", " + "<font color='red'>" + inputZipcode + "</font>" + " " + "{{$user->city}}";
      document.querySelector('#stored_zipcode').value = inputZipcode;
    } 
  } else {
      document.getElementById("oldAddress").innerHTML = "{{$user->street}}" + ", " + " {{$user->zipcode}}" + " " + "{{$user->city}}";
  }
}

function storeCompany() {

  var inputOldcompany = document.getElementById("usercompanyvalue").value;
  localStorage.setItem("usercompanyvalue", inputOldcompany);

  var inputCompany = document.getElementById("company").value;
  localStorage.setItem("company", inputCompany);

  if(inputCompany) {
    if(inputCompany != inputOldcompany) {
    document.getElementById("oldCompany").innerHTML = "<strike>{{$user->company}}</strike>" + " " + "<font color='red'>" + inputCompany + "</font>";
    document.querySelector('#stored_company').value = inputCompany;
    } else {
    document.getElementById("oldCompany").innerHTML = "{{$user->company}}";
    }
  }
}

function storeHomepage() {

  var inputOldhomepage = document.getElementById("userhomepagevalue").value;
  localStorage.setItem("userhomepagevalue", inputOldhomepage);

  var inputHomepage = document.getElementById("homepage").value;
  localStorage.setItem("homepage", inputHomepage);

  if(inputHomepage) {
    if(inputHomepage != inputOldhomepage) {
    document.getElementById("oldHomepage").innerHTML = "<strike>{{$user->homepage}}</strike>" + " " + "<font color='red'>" + inputHomepage + "</font>";
    document.querySelector('#stored_homepage').value = inputHomepage;
    } else {
    document.getElementById("oldHomepage").innerHTML = "{{$user->homepage}}";
    }
  }
}

function storeFacebook() {

  var inputOldfacebook = document.getElementById("userfacebookvalue").value;
  localStorage.setItem("userfacebookvalue", inputOldfacebook);

  var inputFacebook = document.getElementById("facebook").value;
  localStorage.setItem("facebook", inputFacebook);

  if(inputFacebook) {
    if(inputFacebook != inputOldfacebook) {
    document.getElementById("oldFacebook").innerHTML = "<strike>{{$user->facebook}}</strike>" + " " + "<font color='red'>" + inputFacebook + "</font>";
    document.querySelector('#stored_facebook').value = inputFacebook;
    } else {
    document.getElementById("oldFacebook").innerHTML = "{{$user->facebook}}";
    }
  }
}

function storeGoogleplus() {

  var inputOldgoogleplus = document.getElementById("usergoogleplusvalue").value;
  localStorage.setItem("usergoogleplusvalue", inputOldgoogleplus);

  var inputGoogleplus = document.getElementById("googleplus").value;
  localStorage.setItem("googleplus", inputGoogleplus);

  if(inputGoogleplus) {
    if(inputGoogleplus != inputOldgoogleplus) {
    document.getElementById("oldGoogleplus").innerHTML = "<strike>{{$user->googleplus}}</strike>" + " " + "<font color='red'>" + inputGoogleplus + "</font>";
    document.querySelector('#stored_googleplus').value = inputGoogleplus;
    } else {
    document.getElementById("oldGoogleplus").innerHTML = "{{$user->googleplus}}";
    }
  }
}

function storeGithub() {

  var inputOldgithub = document.getElementById("usergithubvalue").value;
  localStorage.setItem("usergithubvalue", inputOldgithub);

  var inputGithub = document.getElementById("github").value;
  localStorage.setItem("github", inputGithub);

  if(inputGithub) {
    if(inputGithub != inputOldgithub) {
    document.getElementById("oldGithub").innerHTML = "<strike>{{$user->github}}</strike>" + " " + "<font color='red'>" + inputGithub + "</font>";
    document.querySelector('#stored_github').value = inputGithub;
    } else {
    document.getElementById("oldGithub").innerHTML = "{{$user->github}}";
    }
  }
}

function storeAcademia() {

  var inputOldacademia = document.getElementById("useracademiavalue").value;
  localStorage.setItem("useracademiavalue", inputOldacademia);

  var inputAcademia = document.getElementById("academia").value;
  localStorage.setItem("academia", inputAcademia);

  if(inputAcademia) {
    if(inputAcademia != inputOldacademia) {
    document.getElementById("oldAcademia").innerHTML = "<strike>{{$user->academia}}</strike>" + " " + "<font color='red'>" + inputAcademia + "</font>";
    document.querySelector('#stored_academia').value = inputAcademia;
    } else {
    document.getElementById("oldAcademia").innerHTML = "{{$user->academia}}";
    }
  }
}

function storeXing() {

  var inputOldxing = document.getElementById("userxingvalue").value;
  localStorage.setItem("userxingvalue", inputOldxing);

  var inputXing = document.getElementById("xing").value;
  localStorage.setItem("xing", inputXing);

  if(inputXing) {
    if(inputXing != inputOldxing) {
    document.getElementById("oldXing").innerHTML = "<strike>{{$user->xing}}</strike>" + " " + "<font color='red'>" + inputXing + "</font>";
    document.querySelector('#stored_xing').value = inputXing;
    } else {
    document.getElementById("oldXing").innerHTML = "{{$user->xing}}";
    }
  }
}

function storeLinkedin() {

  var inputOldlinkedin = document.getElementById("userlinkedinvalue").value;
  localStorage.setItem("userlinkedinvalue", inputOldlinkedin);

  var inputLinkedin = document.getElementById("linkedin").value;
  localStorage.setItem("linkedin", inputLinkedin);

  if(inputLinkedin) {
    if(inputLinkedin != inputOldlinkedin) {
    document.getElementById("oldLinkedin").innerHTML = "<strike>{{$user->linkedin}}</strike>" + " " + "<font color='red'>" + inputLinkedin + "</font>";
    document.querySelector('#stored_linkedin').value = inputLinkedin;
    } else {
    document.getElementById("oldLinkedin").innerHTML = "{{$user->linkedin}}";
    }
  }
}

function storeThreedplatform() {

  var inputOldthreedplatform = document.getElementById("userthreedplatformvalue").value;
  localStorage.setItem("userthreedplatformvalue", inputOldthreedplatform);

  var inputThreedplatform = document.getElementById("threedplatform").value;
  localStorage.setItem("threedplatform", inputThreedplatform);

  if(inputThreedplatform) {
    if(inputThreedplatform != inputOldthreedplatform) {
    document.getElementById("oldThreedplatform").innerHTML = "<strike>{{$user->threedplatform}}</strike>" + " " + "<font color='red'>" + inputThreedplatform + "</font>";
    document.querySelector('#stored_threedplatform').value = inputThreedplatform;
    } else {
    document.getElementById("oldThreedplatform").innerHTML = "{{$user->threedplatform}}";
    }
  }
}

function storeTwitter() {

  var inputOldtwitter = document.getElementById("usertwittervalue").value;
  localStorage.setItem("usertwittervalue", inputOldtwitter);

  var inputTwitter = document.getElementById("twitter").value;
  localStorage.setItem("twitter", inputTwitter);

  if(inputTwitter) {
    if(inputTwitter != inputOldtwitter) {
    document.getElementById("oldTwitter").innerHTML = "<strike>{{$user->twitter}}</strike>" + " " + "<font color='red'>" + inputTwitter + "</font>";
    document.querySelector('#stored_twitter').value = inputTwitter;
    } else {
    document.getElementById("oldTwitter").innerHTML = "{{$user->twitter}}";
    }
  }
}

</script>

@endsection

@section('content')

<div class="setting-wrapper"> 
  <div class="create_title">
    <p>Account Management</p> 
  </div>  
  <div class="general-setting">
    <h3>General Settings</h3>
    <ul style="list-style: none; margin:0; padding:0; display: inline-block; width: 100%;">
      <li id="item-username">     
        <div id="item-label"><strong class="col-sm-2">Username:</strong></div>
        <div id="item-data"><p id="oldUsername">{{$user->username}}</p></div>
        <a href="#" style="float:right">Edit</a>     
      </li>
      <form id="setting-username"role="form">
         <input type="hidden" name="userusernamevalue" id="userusernamevalue" value="{{$user->username}}">
        <strong>Edit username</strong>
        <div><p>Type new username</p></div>
        <div class="form-group">
          <input type="text" name="username" id="username" class="form-control" >
        </div>     
        <button style="width:80px; border-radius: 0;" type="button" id="clickdone1" onclick="storeUsername()" class="btn btn-success">Done</button>
      </form>
      <li id="item-email">     
        <div id="item-label"><strong class="col-sm-2">Email:</strong></div>
        <div id="item-data"><p id="oldEmail">{{$user->email}}</p></div>
        <a href="#" style="float:right">Edit</a>     
      </li>
      <form role="form" id="setting-email">
        <input type="hidden" name="usermailvalue" id="usermailvalue" value="{{$user->email}}">
        <strong>Edit email</strong>
        <div><p>Type new email</p></div>
        <div class="form-group">
          <input type="email" name="first_mail" id="first_mail" class="form-control" >
        </div>     
        <div><p>Retype new email</p></div>
        <div class="form-group">
          <input type="email" name="second_mail" id="second_mail" class="form-control" >
        </div> 
        <button style="width:80px; border-radius: 0;" type="button" id="clickdone2" class="btn btn-success" onclick="storeEmail()">Done</button>
      </form>
      <li id="item-address">     
        <div id="item-label"><strong class="col-sm-2">Address:</strong></div>
        <div id="item-data"><p id="oldAddress">{{$user->street}}, {{$user->zipcode}} {{$user->city}}</p></div>
        <a href="#" style="float:right">Edit</a>     
      </li>
      <form role="form" id="setting-address">
        <input type="hidden" name="userstreetvalue" id="userstreetvalue" value="{{$user->street}}">
        <input type="hidden" name="userzipcodevalue" id="userzipcodevalue" value="{{$user->zipcode}}">
        <input type="hidden" name="usercityvalue" id="usercityvalue" value="{{$user->city}}">
        <strong>Edit address</strong>
        <div><p>Type new street</p></div>
        <div class="form-group">
          <input type="text" name="street" id="street" placeholder="{{$user->street}}"class="form-control" >
        </div>     
        <div><p>Type new zipcode</p></div>
        <div class="form-group">
          <input type="text" name="zipcode" id="zipcode" placeholder="{{$user->zipcode}}" class="form-control" >
        </div>
        <div><p>Type new city</p></div>
        <div class="form-group">
          <input type="text" name="city" id="city" placeholder="{{$user->city}}" class="form-control" >
        </div> 
        <button style="width:80px; border-radius: 0;" type="button" id="clickdone3" class="btn btn-success" onclick="storeAddress()">Done</button>
      </form>
       <li id="item-company">     
        <div id="item-label"><strong class="col-sm-2">Company:</strong></div>
        <div id="item-data"><p id="oldCompany">{{$user->company}}</p></div>
        <a href="#" style="float:right">Edit</a>     
      </li>
      <form id="setting-company"role="form">
        <strong>Edit company</strong>
        <div><p>Type company</p></div>
        <div class="form-group">
          <input type="hidden" name="usercompanyvalue" id="usercompanyvalue" value="{{$user->company}}">
          <input type="text" name="company" id="company" class="form-control" >
        </div>     
        <button style="width:80px; border-radius: 0;" type="button" id="clickdone4" onclick="storeCompany()" class="btn btn-success">Done</button>
      </form>
      <li id="item-homepage">     
        <div id="item-label"><strong class="col-sm-2">Homepage:</strong></div>
        <div id="item-data"><p id="oldHomepage">{{$user->homepage}}</p></div>
        <a href="#" style="float:right">Edit</a>     
      </li>
      <form id="setting-homepage"role="form">
        <strong>Edit homepage</strong>
        <div><p>Type homepage</p></div>
        <div class="form-group">
          <input type="hidden" name="userhomepagevalue" id="userhomepagevalue" value="{{$user->homepage}}">
          <input type="text" name="homepage" id="homepage" class="form-control" >
        </div>     
        <button style="width:80px; border-radius: 0;" type="button" id="clickdone5" onclick="storeHomepage()" class="btn btn-success">Done</button>
      </form>
      <li id="item-facebook">     
        <div id="item-label"><strong class="col-sm-2">Facebook:</strong></div>
        <div id="item-data"><p id="oldFacebook">{{$user->facebook}}</p></div>
        <a href="#" style="float:right">Edit</a>     
      </li>
      <form id="setting-facebook"role="form">
        <strong>Edit facebook</strong>
        <div><p>Type facebook</p></div>
        <div class="form-group">
          <input type="hidden" name="userfacebookvalue" id="userfacebookvalue" value="{{$user->facebook}}">
          <input type="text" name="facebook" id="facebook" class="form-control" >
        </div>     
        <button style="width:80px; border-radius: 0;" type="button" id="clickdone6" onclick="storeFacebook()" class="btn btn-success">Done</button>
      </form>
      <li id="item-twitter">     
        <div id="item-label"><strong class="col-sm-2">Twitter:</strong></div>
        <div id="item-data"><p id="oldTwitter">{{$user->twitter}}</p></div>
        <a href="#" style="float:right">Edit</a>     
      </li>
      <form id="setting-twitter"role="form">
        <strong>Edit twitter</strong>
        <div><p>Type twitter</p></div>
        <div class="form-group">
          <input type="hidden" name="usertwittervalue" id="usertwittervalue" value="{{$user->twitter}}">
          <input type="text" name="twitter" id="twitter" class="form-control" >
        </div>     
        <button style="width:80px; border-radius: 0;" type="button" id="clickdone13" onclick="storeTwitter()" class="btn btn-success">Done</button>
      </form>
      <li id="item-googleplus">     
        <div id="item-label"><strong class="col-sm-2">Google Plus:</strong></div>
        <div id="item-data"><p id="oldGoogleplus">{{$user->googleplus}}</p></div>
        <a href="#" style="float:right">Edit</a>     
      </li>
      <form id="setting-googleplus"role="form">
        <strong>Edit googleplus</strong>
        <div><p>Type googleplus</p></div>
        <div class="form-group">
          <input type="hidden" name="usergoogleplusvalue" id="usergoogleplusvalue" value="{{$user->googleplus}}">
          <input type="text" name="googleplus" id="googleplus" class="form-control" >
        </div>     
        <button style="width:80px; border-radius: 0;" type="button" id="clickdone7" onclick="storeGoogleplus()" class="btn btn-success">Done</button>
      </form>
      <li id="item-github">     
        <div id="item-label"><strong class="col-sm-2">Github:</strong></div>
        <div id="item-data"><p id="oldGithub">{{$user->github}}</p></div>
        <a href="#" style="float:right">Edit</a>     
      </li>
      <form id="setting-github"role="form">
        <strong>Edit github</strong>
        <div><p>Type github</p></div>
        <div class="form-group">
          <input type="hidden" name="usergithubvalue" id="usergithubvalue" value="{{$user->github}}">
          <input type="text" name="github" id="github" class="form-control" >
        </div>     
        <button style="width:80px; border-radius: 0;" type="button" id="clickdone8" onclick="storeGithub()" class="btn btn-success">Done</button>
      </form>
      <li id="item-academia">     
        <div id="item-label"><strong class="col-sm-2">Academia.edu:</strong></div>
        <div id="item-data"><p id="oldAcademia">{{$user->academia}}</p></div>
        <a href="#" style="float:right">Edit</a>     
      </li>
      <form id="setting-academia"role="form">
        <strong>Edit academia.edu</strong>
        <div><p>Type academia.edu</p></div>
        <div class="form-group">
          <input type="hidden" name="useracademiavalue" id="useracademiavalue" value="{{$user->academia}}">
          <input type="text" name="academia" id="academia" class="form-control" >
        </div>     
        <button style="width:80px; border-radius: 0;" type="button" id="clickdone9" onclick="storeAcademia()" class="btn btn-success">Done</button>
      </form>
      <li id="item-xing">     
        <div id="item-label"><strong class="col-sm-2">Xing:</strong></div>
        <div id="item-data"><p id="oldXing">{{$user->xing}}</p></div>
        <a href="#" style="float:right">Edit</a>     
      </li>
      <form id="setting-xing"role="form">
        <strong>Edit xing</strong>
        <div><p>Type xing</p></div>
        <div class="form-group">
          <input type="hidden" name="userxingvalue" id="userxingvalue" value="{{$user->xing}}">
          <input type="text" name="xing" id="xing" class="form-control" >
        </div>     
        <button style="width:80px; border-radius: 0;" type="button" id="clickdone10" onclick="storeXing()" class="btn btn-success">Done</button>
      </form>
      <li id="item-linkedin">     
        <div id="item-label"><strong class="col-sm-2">LinkedIn:</strong></div>
        <div id="item-data"><p id="oldLinkedin">{{$user->linkedin}}</p></div>
        <a href="#" style="float:right">Edit</a>     
      </li>
      <form id="setting-linkedin"role="form">
        <strong>Edit linkedin</strong>
        <div><p>Type linkedin</p></div>
        <div class="form-group">
          <input type="hidden" name="userlinkedinvalue" id="userlinkedinvalue" value="{{$user->linkedin}}">
          <input type="text" name="linkedin" id="linkedin" class="form-control" >
        </div>     
        <button style="width:80px; border-radius: 0;" type="button" id="clickdone11" onclick="storeLinkedin()" class="btn btn-success">Done</button>
      </form>
      <li id="item-threedplatform">     
        <div id="item-label"><strong class="col-sm-2">3D-Platform:</strong></div>
        <div id="item-data"><p id="oldThreedplatform">{{$user->threedplatform}}</p></div>
        <a href="#" style="float:right">Edit</a>     
      </li>
      <form id="setting-threedplatform"role="form">
        <strong>Edit 3D-Platform</strong>
        <div><p>Type 3D-Platform</p></div>
        <div class="form-group">
          <input type="hidden" name="userthreedplatformvalue" id="userthreedplatformvalue" value="{{$user->threedplatform}}">
          <input type="text" name="threedplatform" id="threedplatform" class="form-control" >
        </div>     
        <button style="width:80px; border-radius: 0;" type="button" id="clickdone12" onclick="storeThreedplatform()" class="btn btn-success">Done</button>
      </form>
    </ul>            
  </div>

  <form method="post" action="passwordchange/update" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="_id" value="{{ $user->id }}" />

  <div class="user-description">
    <h3>Your description</h3>  
    <textarea placeholder="{{$user->description}}" name="limitedtextarea" id="limitedtextarea" onKeyDown="limitText(this.form.limitedtextarea,this.form.countdown,120);" onKeyUp="limitText(this.form.limitedtextarea,this.form.countdown,120);" class="form-control" rows="3"></textarea>
    <i>You have <input style="border:0; width:25px" readonly type="text" name="countdown" size="3" value="120"> characters left.</i>
  </div> 
 
  <div class="password"> 
    <h3>Password</h3>
      <div><p>Type current password</p></div>       
      <div class="form-group">
        <input name="current_password" id="current_password" type="password" class="form-control" >
      </div>    
      <div><p>Type new password</p></div>
      <div class="form-group">
        <input name="password" id="password" type="password" class="form-control" >
      </div>     
      <div><p>Retype new password</p></div>
      <div class="form-group">
        <input name="password_confirmation" id="password_confirmation" type="password" class="form-control" >
      </div>
  </div>  
 
 </div>
 
  <input type="hidden" name="stored_username" id="stored_username" value="{{$user->username}}" placeholder="{{$user->username}}" class="form-control" >
  <input type="hidden" name="stored_email" id="stored_email" value="{{$user->email}}"  placeholder="{{$user->email}}" class="form-control" >
  <input type="hidden" name="stored_street" id="stored_street" value="{{$user->street}}"  placeholder="{{$user->street}}" class="form-control" >
  <input type="hidden" name="stored_zipcode" id="stored_zipcode" value="{{$user->zipcode}}"  placeholder="{{$user->zipcode}}" class="form-control" >
  <input type="hidden" name="stored_city" id="stored_city" value="{{$user->city}}"  placeholder="{{$user->city}}" class="form-control" >
  <input type="hidden" name="stored_company" id="stored_company" value="{{$user->company}}"  placeholder="{{$user->company}}" class="form-control" >
  <input type="hidden" name="stored_homepage" id="stored_homepage" value="{{$user->homepage}}"  placeholder="{{$user->homepage}}" class="form-control" >
  <input type="hidden" name="stored_facebook" id="stored_facebook" value="{{$user->facebook}}"  placeholder="{{$user->facebook}}" class="form-control" >
  <input type="hidden" name="stored_googleplus" id="stored_googleplus" value="{{$user->googleplus}}"  placeholder="{{$user->googleplus}}" class="form-control" >
  <input type="hidden" name="stored_github" id="stored_github" value="{{$user->github}}"  placeholder="{{$user->github}}" class="form-control" >
  <input type="hidden" name="stored_academia" id="stored_academia" value="{{$user->academia}}"  placeholder="{{$user->academia}}" class="form-control" >
  <input type="hidden" name="stored_xing" id="stored_xing" value="{{$user->xing}}"  placeholder="{{$user->xing}}" class="form-control" >
  <input type="hidden" name="stored_linkedin" id="stored_linkedin" value="{{$user->linkedin}}"  placeholder="{{$user->linkedin}}" class="form-control" >
  <input type="hidden" name="stored_threedplatform" id="stored_threedplatform" value="{{$user->threedplatform}}"  placeholder="{{$user->threedplatform}}" class="form-control" >
  <input type="hidden" name="stored_twitter" id="stored_twitter" value="{{$user->twitter}}"  placeholder="{{$user->twitter}}" class="form-control" >
  
  <div style="margin-top: 20px; display: inline; float: right;">
    <a href="/profile/setting"><button style="width:80px; border-radius: 0;" type="button" class="btn btn-warning">Cancel</button></a>
    <button style="width:80px; border-radius: 0;" type="submit" onclick="{{$user->id}}" class="btn btn-success">Save</button>      
  </form>
  </div>
 

@stop