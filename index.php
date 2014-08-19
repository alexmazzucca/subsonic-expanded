<?php

//GET ALBUM INFORMATION

//Data Loading
$albumurl = 'http://96.227.54.100:4040/rest/getAlbumList.view?u=xml&p=tun3s&v=1.1.0&c=myapp&type=newest&size=20';
$albumdata = file_get_contents($albumurl);

//Data Check
if (!$albumdata){
 	echo 'Error retrieving: ' . $albumurl;
 	exit;
}

//Data Preparation
$albumxml = simplexml_load_string($albumdata);
if ($albumxml === FALSE){
 	echo 'Unable to parse XML';
 	exit;
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name = "viewport" content = "user-scalable=no, width=device-width">
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<title>New Tunes</title>
		<link rel="apple-touch-icon" href="touch-icon-iphone.png">
		<link rel="apple-touch-icon" sizes="76x76" href="touch-icon-ipad.png">
		<link rel="apple-touch-icon" sizes="120x120" href="touch-icon-iphone-retina.png">
		<link rel="apple-touch-icon" sizes="152x152" href="touch-icon-ipad-retina.png">
		<link href='http://fonts.googleapis.com/css?family=Gloria+Hallelujah' rel='stylesheet' type='text/css'>
		<script type="text/javascript" src="js/iscroll.js"></script>
		<script type="text/javascript" src="js/vendor/jquery-1.10.2.min.js"></script>
		<script type="text/javascript">
			var myScroll;
			function loaded () {
				myScroll = new IScroll('#wrapper', {
					mouseWheel: true,
					indicators: [{
						el: document.getElementById('background-1'),
						resize: false,
						ignoreBoundaries: true,
						speedRatioY: .5
					}]
				});
			}
			document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);

			/*-------------*/

			$(document).ready(function($) {
				function reposition(){
					var $h = $(window).height(),
						$w = $(window).width();
				}
				
				$(window).bind("load resize onorientationchange", function() {
					reposition();
				});
			});

		</script>

		<style type="text/css">
			* {
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
			}

			html {
				-ms-touch-action: none;
			}
			body {
				overflow: hidden;
				margin:20px;
			}
			.album{
				max-width:500px;
				margin:25px auto;
				width:80%;
				padding:20px;
				background-color:rgba(255,255,255,.1);
				border-radius: 5px;
				-webkit-box-shadow: 0px 0px 10px 1px rgba(0,0,0,0.2);
				-moz-box-shadow: 0px 0px 10px 1px rgba(0,0,0,0.2);
				box-shadow: 0px 0px 10px 1px rgba(0,0,0,0.2);
			}
			.album .art {
				display:block;
				width:100%;
				margin-bottom:10px;
			}
			.album .art img {
				width:100%;
				height:auto !important;
				-ms-interpolation-mode: bicubic; 
			}
			.album h1,
			.album h2 {
				margin: 0 0 5px 0;
				color:#fff;
				text-align:center;
				font-family: 'Gloria Hallelujah', cursive;
				font-size:18px;
				font-weight: normal;
				line-height:22px;
			}
			.album h2 {
				margin:0;
				font-size:12px;
				font-weight:normal;
				color:#fff;
				opacity:.5;
			}

			.album h1 a {
				text-decoration: none;
				color:#fff;
			}

			/*iScroll*/

			#wrapper {
				position: absolute;
				z-index: 3;
				width: 100%;
				top: 0;
				bottom: 0;
				left: 0;
				overflow: hidden;
			}

			#scroller {
				position: absolute;
				z-index: 3;
				width: 100%;
				overflow: hidden;
				-webkit-tap-highlight-color: rgba(0,0,0,0);
				-webkit-transform: translateZ(0);
				-moz-transform: translateZ(0);
				-ms-transform: translateZ(0);
				-o-transform: translateZ(0);
				transform: translateZ(0);
				-webkit-touch-callout: none;
				-webkit-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none;
				user-select: none;
				-webkit-text-size-adjust: none;
				-moz-text-size-adjust: none;
				-ms-text-size-adjust: none;
				-o-text-size-adjust: none;
				text-size-adjust: none;
			}
			#background-1 {
				z-index:2;
				position: absolute;
				width: 100%;
				top: 0;
				left: 0;
				bottom: 0;
				overflow: hidden;
				
			}
			#background-1 div {
				width: 100%;
				height:9000px;
				-webkit-transform: translateZ(0);
				-moz-transform: translateZ(0);
				-ms-transform: translateZ(0);
				-o-transform: translateZ(0);
				transform: translateZ(0);
				background-image: url('img/bg.png');
				background-size:800px 250px;
			}
		</style>
	</head>
	<body onload="loaded();">
		<div id="wrapper">
			<div id="scroller">
				<?php
					$albums = $albumxml->albumList->album;
					foreach ($albums as $album){
						$time = explode('T',$album['created'],-1);
						echo
						'<div class="album">' .
						'<div class="art"><a href="http://www.allmusic.com/search/albums/'.$album['title'].'" target="_blank" title="'.$album['title'].'"><img src="' . 'http://96.227.54.100:4040/rest/getCoverArt.view?u=xml&p=tun3s&v=1.1.0&c=myapp&type=newest&id=' . $album['id'] . '&size=500" /></a></div>' . 
						'<h1><a href="http://www.allmusic.com/search/albums/'.$album['title'].'" target="_blank">' . $album['title'] . '</a></h1>' .
						'<h2>Added ' . date("M d Y", strtotime($time[0])) . '</h2>' . 
						'</div>';
					}
				?>
			</div>
		</div>
		<div id="background-1">
			<div></div>
		</div>
	</body>
</html>