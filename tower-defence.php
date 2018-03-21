<?php

$this_title = 'Peep Defence | Eclectic App Development';
$this_desc = 'Making random bits and bots since a while ago';

$this_type = "website";
$this_locale = "en_us";
$this_url = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI'];

$partials_folder = '../templates/partials/';

/* STRUCTURE */

// _declare.php		(doctype)
// _meta.php		(meta properties and the site icon)
// _social.php		(social app_id - FB/Twitter)
// _styles.php		(stylesheets and fonts)
// _scripts.php		(scripts which have to be loaded into the head)
	// echo BODY opening tag
// _navbar.php		(the nav menu, potentially highlight the current page $this_page / $this_directory)
	// echo MAIN and CONTENT
// _footer.php		(footer)

include $partials_folder . '_declare.php';
include $partials_folder . '_meta.php';
include $partials_folder . '_social.php';

echo "<style type='text/css'>

	#gui_health_container {
		position: relative;
		height: 25px;
		z-index: 0;
	}
	
	#gui_health_text {
		position: relative;
		width: 100%;
		height: 25px;
		z-index: 10;
		text-align: center;
	}
	
	#gui_health {
		position: absolute;
		top: 0px;
		z-index: 1;
		height: 25px;
	}
	
	#main-modal {
		z-index: 1000;
	}
</style>";

include $partials_folder . '_styles.php';
include $partials_folder . '_structured.php';


$include_folder_files = [

	// These hold the default values and definitions
	[ "./tower-defence/defaults", "defaults" ],
	[ "./tower-defence/defaults", "enemies" ],
	[ "./tower-defence/defaults", "levels" ],
	[ "./tower-defence/defaults", "waves" ],
	[ "./tower-defence/defaults", "modals" ],

	// These hold the objects and methods
	[ "./tower-defence/objects", "bullets" ],
	[ "./tower-defence/objects", "enemies" ],
	[ "./tower-defence/objects", "towers" ],
	[ "./tower-defence/objects", "modals" ],
	[ "./tower-defence/objects", "canvas" ],
	[ "./tower-defence/objects", "paths" ],

	// This is the main JS file (mainLoop, init, reset)
	[ "./tower-defence", "tower-defence" ],

	// Generic libraries required for this game
	[ "../libraries/javascript", "window" ],
	[ "../libraries/javascript", "canvas_events" ],
	[ "../libraries/javascript", "pathfinding-browser" ],
	[ "../libraries/javascript", "grid" ]
	
];

for ($i = 0; $i < count($include_folder_files); $i++){
	$this_folder = $include_folder_files[$i][0];
	$this_file = $include_folder_files[$i][1];
	echo "<script defer src='" . $this_folder . "/" . $this_file . ".js'></script>";
}
	
/*
echo "
	<script src='../libraries/javascript/window.js'></script>
	<script src='../libraries/javascript/pathfinding-browser.js'></script>
	<script src='../libraries/javascript/grid.js'></script>
	<script src='../libraries/javascript/canvas_events.js'></script>

	<script src='./tower-defence/tower-defence.js'></script>
 	<script src='./tower-defence/tower-defaults.js'></script>
";
*/

include $partials_folder . '_scripts.php';	// NOTE, ALSO CLOSES THE HEAD

echo "<body class='w3-dark-grey' onload='init()' onresize='resizeCanvas()'>";

include $partials_folder . '_navbar.php';

?>

<main id='main'>
	
	<!-- Top Box -->
	<div class='w3-card-10 w3-container w3-medium w3-center w3-padding-large w3-theme-d3'>
		
		<div class='w3-row'>
		
			<div class='w3-col s12 m6'>
				<canvas id='canvas' width='100%' height='100%'>
					Sorry, your browser does not support the canvas element
				</canvas>
			</div>
			
			<div class='w3-col s12 m6 w3-large'>
				
				<div class='w3-row'>
					<div class='w3-col s12'>
						<h2>Peep Defence</h2>
						<button id='waveBtn' class='w3-btn w3-green'></button>
					</div>
				</div>
				<br><br>
				<div class='w3-row'>
					<div class='w3-col s3'>
						Health:
					</div>
					<div class='w3-col s9'>
						<div id='gui_health_container' class='w3-red'>
							<div id='gui_health_text'></div>
							<div id='gui_health' class='w3-container w3-green' style='width:100%'></div>
						</div>
					</div>
				</div>
				
				<div class='w3-row'>
					<div class='w3-col s3'>
						Wave:
					</div>
					<div class='w3-col s9'>
						<span id='gui_wave'></span>
					</div>
				</div>
				
				<div class='w3-row'>
					<div class='w3-col s3'>
						Cash:
					</div>
					<div class='w3-col s9'>
						£ <span id='gui_cash'></span>
					</div>
				</div>
				
				<div class='w3-row'>
					<div class='w3-col s3'>
						Enemies:
					</div>
					<div class='w3-col s9'>
						<span id='gui_enemies'></span>
					</div>
				</div>
				
				<div class='w3-row'>
					<div class='w3-col s3'>
						Score:
					</div>
					<div class='w3-col s9'>
						<span id='gui_score'></span>
					</div>
				</div>
			
			</div>
			
		</div>
		
		<div id='main-modal' class='w3-modal'>
		  <div class='w3-modal-content'>
			    <header class='w3-container w3-purple'> 
				  <span onclick='closeModal()' style='cursor: pointer;'
					class='w3-button w3-xlarge w3-badge w3-red w3-display-topright'>&times;</span>
				  <h2 id='main-modal-header'>Modal Header</h2>
				</header>

				<div class='w3-container w3-text-purple'>
					<br>
					<span id='main-modal-content'></span>
					<br><br>
				</div>

				<footer class='w3-container w3-purple w3-center w3-row-padding'>
					<div class='w3-small'>
						&nbsp;
					</div>
					<div class='w3-col s6 w3-center'>
						<button id='main-modal-footer-left' class='w3-btn w3-green w3-padding'></button>
						&nbsp;
					</div>
					<div class='w3-col s6 w3-center'>
						<button id='main-modal-footer-right' class='w3-btn w3-green w3-padding'></button>
						&nbsp;
					</div>
					<div class='w3-small'>
						&nbsp;
					</div>
				</footer>
			</div>
		</div>
		
	</div>

<?php
		
include $partials_folder . '_footer.php';

?>
