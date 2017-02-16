<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<!-- 
/*********************************************************************************
 * OpenACH is an ACH payment processing platform
 * Copyright (C) 2011 Steven Brendtro, ALL RIGHTS RESERVED
 * 
 * Refer to /legal/license.txt for license information, or view the full license
 * online at http://openach.com/community/license.txt
 ********************************************************************************/
-->
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/" lang="en" xml:lang="en"> 
<head>
    <title>OpenACH - Open Source ACH Processing</title> 
    <meta name="title" content="OpenACH" /> 
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" /> 
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" /> 
    <meta property="og:title"  name="title" content="OpenACH" /> 
    <meta property="og:url" content="http://openach.com/" /> 
    <meta property="og:image" content="http://www.openach.com/images/logo/OpenACH_Logo_Vertical.png" /> 
    <meta property="og:site_name" content="OpenACH" /> 

    <link rel="stylesheet" href="css/reset.css?S" type="text/css" />
    <link rel="stylesheet" href="css/typography.css?S" type="text/css" />
    <link rel="stylesheet" href="css/application.css?S" type="text/css" />
    <link rel="stylesheet" href="css/form.css?S" type="text/css" />
    <link rel="stylesheet" href="css/local.css?S" type="text/css" />
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css" type="text/css" />
    
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>

    <script type="text/javascript" src="assets/js/jquery.form.js"></script>
    <script type="text/javascript" src="assets/js/jquery-ui-local-mods.js"></script>
    <script type="text/javascript" src="assets/js/jquery-simple-spinner.js"></script>
    <script type="text/javascript">
	$(document).ready(function(){
            $("#testform").ajaxSubmit();
        });
    </script>

    <script type="text/javascript" src="assets/js/application.js"></script>
</head>
<body>
	<div id="altContent">
		<h1></h1>
		<h2></h2>
		<noscript>
			This application requires Javascript
		</noscript>
	</div>
	<div id="mainContainer">
		<div id="capital"></div>
		<div id="application">
			<div id="loading"></div>
			<div id="main">
				<div id="header">
					<h1><a href="#"><span>OpenACH</span></a></h1>
					<ul id="nav"></ul>
					<ul id="userOptions"></ul>
				</div>
				<div id="content">
					<div id="sidebar">
						<div id="sidebarContent"></div>
						<div id="sidebarFooter" class="containerFooter"></div>
					</div>
					<div id="pageWrapper">
						<div id="pageContent"></div>
						<div id="pageFooter" class="containerFooter"></div>
					</div>
				</div>
				<div id="footer">
				</div>
				<div id="notifications"></div>
			</div>
		</div>
	</div>
</body>
</html>
