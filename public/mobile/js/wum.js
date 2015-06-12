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
		$( "#profil-avatar" ).attr('src','../uploads/users/' + user.login + '/avatar.jpg');
		
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
	if(user && user.company)
	{
		$( "#textinput-profil-company" ).val(user.company);	
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
	var url = '/mobile/service/index.php?action=getProjects';
	$.getJSON(url, onProjectsLoaded);
}

/**
 * Callback für die getProjects Abfrage
 */
function onProjectsLoaded(data)
{
	$('#select-project-list').empty()
	projects = data;
	for(var i=0;i<projects.length;i++)
	{
		var currentProjectPageID = "page-project-id-" + projects[i].projectId;
		var currentProjectImageURL = ".." + projects[i].imageUrl;
		var currentProjectTitle = projects[i].title;
		var currentProjectItem = '<li><a data-transition="flip" href="#'+ currentProjectPageID + '"><img src="' + currentProjectImageURL + '" /><h3>' + currentProjectTitle + '</h3></a></li>';
		$('#select-project-list').append(currentProjectItem);
		createProjectPage(projects[i],currentProjectPageID);
	} 
	$('#select-project-list').listview('refresh');
	$('.project-title-back').click(openProjectsPageFromProject);
}
/**
 * öffnet die Projects Page
 */
function openProjectsPageFromProject()
{
	$( ":mobile-pagecontainer" ).pagecontainer( "change", "#projectsPage", { transition:'flip', reload:true} );	
}

function createProjectPage(project, projectPageId)
{
	if( $('#'+projectPageId).length==0 )
	{
		//Anfang der Page
		var pageContent = '<div data-role="page" id="' + projectPageId + '">';
		//Header
		pageContent += ' <div data-role="header"><a href="#mainPanel" class="header-options-btn"  style="width:1em"> &nbsp;</a><h6 class="header-logo"></h6><a href="#loginPage" class="header-exit-btn"  style="width:1em"> &nbsp;</a></div>';
		//Content
		pageContent += '<div data-role="content"><button class="ui-btn project-title-back ui-shadow ui-corner-all ui-btn-icon-left ui-icon-back">' + project.title + '</button>'; 
		pageContent += '<div style="text-align:center"><img src="' + project.imageUrl + '" /></div>';
		pageContent += project.content + '</div></div>';
		//Create the new Page
		$('#page_body').append(pageContent);	
	}
}

//----------- End Project Page ----------------











