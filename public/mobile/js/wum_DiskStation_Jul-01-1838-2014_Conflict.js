//*******************************************
//******** Start Root DOcument **************
//*******************************************

/* Der gerade angemeldete Benutzer*/
var user;

/* Beschreibt ob die Werte local gespeichert werden müssen */
var saveLocal = false;

/* Die ID der gerade sichtbare Page*/

var currentPageID;

/* Der QR-Code Generator */
var qrcode;

var projects;

/**
 * Händler für die Anzeige jedes View
 */
$(document).on( "pagecontainershow", function()
{
	initPages()
});

/**
 * Initialisiert die Views 
 */
function initPages()
{
	//Generiert der Panel was auf die rechte Seite der App angezeigt wird
	//siehe http://demos.jquerymobile.com/1.4.2/panel-external/
	$( "body>[data-role='panel']" ).panel();
	currentPageID =	$.mobile.activePage.attr('id');
	switch (currentPageID)
	{
		case "loginPage":
			initLoginPage();	
		break;
		
		case "homePage":
			initHomePage();
		break;
		
		case "membercardPage":
			initMemberPage();
		break;
		
		case "profilePage":
			initProfilePage();
		break;
		
		case "projectsPage":
			initProjectsPage();
		break;
		
		
	}
}

/**
 * Startet die App neu 
 */
function resetAll()
{
	qrcode = user = null;
}

//--------- End Root DOcument ---------------


//*******************************************
//*********** Start Login Page **************
//*******************************************

/**
 * Initialisiert die Login Page
 */
function initLoginPage()
{
	//Event händler für die Schaltfläche wird zugeordnet
	$( "#loginBtn" ).click(onLogin);
}

/**
 * Händler für die Login-Schaltfläche
 */
function onLogin()
{
	//liest die Benutzername und Password
	var currentUsername = $( "#login-name-input" ).val();
	var currentPassword = $( "#login-password-input" ).val();
	if(currentUsername.length==0 || currentPassword.length==0)
	{
		alert("Bitte geben Sie einem Benutzername und Password");
	}
	else
	{
		//Generiert die Adresse für die Json DIenst
		var url = '/mobile/service/index.php?action=getUser&login=' + currentUsername + '&password=' +currentPassword;
		//ruft die Json Dienst, onUserLogin wird als callback eingegeben
		$.getJSON(url, onUserLogin);
	}
}
/**
 * Callback für die getUser Abfrage
 */
function onUserLogin(data)
{
	//Testet ob einen Benutzer gefunden wurde
	if(data.login!=null)
	{
		//Testet ob der Benutzer local gespeichert werden muss oder nicht		
		saveLocal = $('#login-rememberme-input').is(":checked");
		if (saveLocal)
		{
			//alert("rememberme = YES");
		}
		else
		{
			//alert("rememberme = NO");	
		}
		user = data;
		openHome();
	}
	else
	{
		alert("Benutzer wurde nicht gefunden");
	}
}

//----------- End Login Page ----------------

//*******************************************
//************ Start Home Page *************
//*******************************************

/**
 * Initialisiert die Home Page
 */
function initHomePage()
{
	//Generiert der Slider
	//Siehe http://jquery.malsup.com/cycle/begin.html
	$('.slideshow').cycle({
		fx: 'fade'
	});
}


/**
 * Öffnet die Home Page
 */
function openHome()
{
	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#homePage", { } );
}

//------------ End Home Page ----------------

//*******************************************
//*********** Start Member Page *************
//*******************************************

/**
 * Initialisiert die Member Page
 */
function initMemberPage()
{
	//Initialisiert der QR-Code
	if(!qrcode)
	{
		qrcode = new QRCode("memberQrCode");	
	}
	
	//Setzt die Werte der Benutzer in der GUI ein.
	if(user && user.login)
	{
		$( "#textinput-qrcode-login" ).val(user.login);	
	}
	if(user && user.password)
	{
		$( "#textinput-qrcode-password" ).val(user.password);
	}
	//Setzt die Event händler für die Live generierung der QR-Code
	$( "#textinput-qrcode-login" ).keyup(generateQRCode);
	$( "#textinput-qrcode-password" ).keyup(generateQRCode);
	generateQRCode();
}

function generateQRCode()
{
	var memberLogin = $( "#textinput-qrcode-login" ).val();
	var memberPassword = $( "#textinput-qrcode-password" ).val();
	qrcode.clear();
	qrcode.makeCode("{login=" + memberLogin + ",password=" + memberPassword + "}");
}

//----------- End Member Page ----------------

//*******************************************
//*********** Start Profil Page *************
//*******************************************

/**
 * Initialisiert die Profile Page
 */
function initProfilePage()
{
	if(user && user.login)
	{
		$( "#textinput-profil-login" ).val(user.login);	
	}
	if(user && user.firstname)
	{
		$( "#textinput-profil-firstname" ).val(user.firstname);	
	}
	if(user && user.lastname)
	{
		$( "#textinput-profil-lastname" ).val(user.lastname);	
	}
	if(user && user.email)
	{
		$( "#textinput-profil-email" ).val(user.email);	
	}

}

//----------- End Profil Page ----------------



//*******************************************
//*********** Start Project Page *************
//*******************************************

/**
 * Initialisiert die Projects Page
 */
function initProjectsPage()
{
	$("#select-project-list").bind( "change", onProjectSelected);
	var url = '/mobile/service/index.php?action=getProjects';
	$.getJSON(url, onProjectsLoaded);
}

/**
 * Callback für die getProjects Abfrage
 */
function onProjectsLoaded(data)
{
	projects = data;
	for(var i=0;i<projects.length;i++)
	{
		var currentProjectPageID = "page-project-id-" + projects[i].projectId;
		var currentProjectImageURL = ".." + projects[i].imageUrl;
		var currentProjectTitle = projects[i].title;
		var currentProjectItem =  '<a href="#'+ currentProjectPageID + '"><img src="' + currentProjectImageURL + '" /><h3>' + currentProjectTitle + '</h3></a>';
		$('#select-project-list').append($('<li/>', {}).append(currentProjectItem));
	} 
	$('#select-project-list').listview('refresh');
}

function onProjectSelected(event, ui)
{
	var selectedProjectID = $("#select-project-list option:selected").val();
	var selectedProject;
	for(var i=0;i<projects.length;i++)
	{
		if(projects[i].projectId==selectedProjectID)
		{
			selectedProject = projects[i];
			selectedProjectID = projects[i].projectId;
			break;
		}
	}
	var pageID = 'project-id-'+selectedProjectID;
	alert("create Page pageID="+pageID);
	/*
	//Create the new Page
	$('#page_body').append('<div data-role="page" id="' + pageID+ '"><div data-role="content">New Page</div></div>');
	
	//initialize the new page 
    $.mobile.initializePage();
	
	//navigate to the new page
 //   $.mobile.changePage("#" + pageID, "pop", false, true);
	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#"+pageID, { } );
	//*/
}

//----------- End Project Page ----------------











