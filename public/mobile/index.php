<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Transportal</title>
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">
    
    <link rel="stylesheet" type="text/css"  media="screen" href="styles/wum.css"/>
    
    <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
    <script type="text/javascript" src="http://malsup.github.com/jquery.cycle.all.js"></script>
    
    <script src="js/qrcode.min.js" type="text/javascript"></script>
    <script src="js/wum.js" type="text/javascript"></script>
</head>
<body id="page_body">
    
	<!-- Start Login Page -->
    <div data-role="page" id="loginPage" >
        <div data-role="content">
	        <?php include("login.php");?>
        </div>
    </div>
    <!-- End Login Page -->
    
    <!-- Start Main Panel -->
    <?php include("panel.php");?>
    <!-- Start Main Panel -->
    
        
    <!-- Start Home Page -->
    <div data-role="page" id="homePage">
         <?php include("header.php");?>
        <div data-role="content">
	        <?php include("home.php");?>
        </div>
    </div>
    <!-- End Home Page -->
    
    <!-- Start Projects Page -->
    <div data-role="page" id="projectsPage">
        <?php include("header.php");?>
        <div data-role="content">
			<?php include("projects.php");?>
        </div>
    </div>
    <!-- End Projects Page -->
    
    <!-- Start Fablabs Page -->
    <div data-role="page" id="fablabsPage">
        <?php include("header.php");?>
        <div data-role="content">
	        <?php include("fablabs.php");?>
        </div>
    </div>
    <!-- End Fablabs Page -->
    
    <!-- Start Membercard Page -->
    <div data-role="page" id="membercardPage">
        <?php include("header.php");?>
        <div data-role="content">
	        <?php include("membercard.php");?>
        </div>
    </div>
    <!-- End Membercard Page -->
    
    <!-- Start Planner Page -->
    <div data-role="page" id="planner">
        <?php include("header.php");?>
        <div data-role="content">
			<?php include("planner.php");?>
        </div>
    </div>
    <!-- End Planner Page -->
	
	<!-- Start Profile Page -->
    <div data-role="page" id="profilePage">
        <?php include("header.php");?>
        <div data-role="content">
	        <?php include("profile.php");?>
        </div>
    </div>
    <!-- End Profile Page -->
	
	<!-- Start Doc Page -->
    <div data-role="page" id="docPage">
        <?php include("header.php");?>
        <div data-role="content">
			<?php include("documentation.php");?>
        </div>
    </div>
    <!-- End Doc Page -->
	
	<!-- Start Forum Page -->
    <div data-role="page" id="forumPage">
        <?php include("header.php");?>
        <div data-role="content">
			<?php include("forum.php");?>
        </div>
	</div>
    <!-- End Forum Page -->
	
	<!-- Start Help Page -->
    <div data-role="page" id="helpPage">
        <?php include("header.php");?>
        <div data-role="content">
	        <?php include("help.php");?>
        </div>
    </div>
    <!-- End Help Page -->
	
	<!-- Start Kontakt Page -->
    <div data-role="page" id="contactPage">
        <?php include("header.php");?>
        <div data-role="content">
	        <?php include("contact.php");?>
        </div>
    </div>
    <!-- End Kontakt Page -->
    
</body>
</html>