
	<?php
	include 'session.php';

if (isset($_POST["searchsubmit"]))
	{
	$inputSearchToLower = strtolower($_POST["inputsearch"]);
	header('Location: /usertexture.php?username=' . $inputSearchToLower);
	}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Toribash Textures</title>
		<meta charset="utf-8">
		<style>
					body {
				-webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    background: #70bg32;
    background-repeat:no-repeat;
    
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#ffffff+50,d9e5e5+82 */
background: #ffffff; /* Old browsers */
background: -moz-linear-gradient(top,  #ffffff 50%, #d9e5e5 82%); /* FF3.6-15 */
background: -webkit-linear-gradient(top,  #ffffff 50%,#d9e5e5 82%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom,  #ffffff 50%,#d9e5e5 82%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#d9e5e5',GradientType=0 ); /* IE6-9 */


				margin: 0px;
				overflow: hidden;
			}
			
			#searchusertext {
			color:#ffffff;
	position: absolute;
	top: 88%;
	width: 100%;
	text-align: center;
	z-index: 100;
	display:block;
}

  div.ex3 {
    height: 500px;
    width:1200px;
    overflow: auto;
}
		</style>
		<?php
include 'links.php';
 ?>

	</head>
	<body>
				<?php
include 'header.php';
 ?>

	<?php
php
/*
$getUsername = $_GET['username'];

$url = "http://cache.toribash.com/cp/textures.php?username=".$getUsername;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec ($ch);
curl_close ($ch);

// echo $result;
// echo "</br></br></br></br></br></br></br>";

?>
<!-- <div class="ex3"> -->

<?php

/*
$split = explode(' ', $result); // Split up the whole string
$chunks = array_chunk($split, 2); // Make groups of 3 words
$urlString = array_map(function($chunk) { return implode(' ', $chunk); }, $chunks); // Put each group back together

for ($i = 0; $i < count($urlString); $i++) {
echo $urlString[$i];
echo "<br />";
echo extractRawURL($urlString[$i]);
echo "<br />";
echo "<br />";
}

function extractRawURL($String) {

$First = "http://";
$Second = ".zlib?md5=";
$sub = substr($String, strpos($String,$First)+strlen($First),strlen($String));
$url = substr($sub,0,strpos($sub,$Second));
$url = "http://".$url;
$url = str_replace('.tga', '.jpg', $url);
return $url;
}

*/
?>
<!--</div> -->
	<?php
$getid = $_GET['id']; ?>
<div id="searchusertext">
		<form method ="post" enctype = "multipart/form-data"  id="searchusertext"   >
							<div class="form-group">
								<input type ="text" name="inputsearch" placeholder="Search Toribash User"<?php

if ($getsearch != "")
	{
	echo 'value =' . $getsearch;
	}
  else
	{
	echo 'value =""';
	} ?>> 
								</input>
								<input type ="submit" name = "searchsubmit" value ="Search"/></input>
						<div></div></div>
						</form>
	
	
	</div>
<?php
require_once ('config.php');

?>
		<script src="build/three.min.js"></script>
		<script>
			/**
 * @author mrdoob / http://mrdoob.com/
 */


		var loader = new THREE.ObjectLoader();
		var camera, scene, renderer;

		var  effect, cameraVR, isVR;

		var events = {};

		this.dom = document.createElement( 'div' );

		this.width = 500;
		this.height = 500;

		this.load = function ( json ) {

			isVR = json.project.vr;

			renderer = new THREE.WebGLRenderer( {  alpha: true,antialias: true ,
			  preserveDrawingBuffer   : true  } );
			renderer.setClearColor( 0x000000, 0 );
			
			renderer.setPixelRatio( window.devicePixelRatio );
	

			this.dom.appendChild( renderer.domElement );

			this.setScene( loader.parse( json.scene ) );
			this.setCamera( loader.parse( json.camera ) );

			events = {
				init: [],
				start: [],
				stop: [],
				keydown: [],
				keyup: [],
				mousedown: [],
				mouseup: [],
				mousemove: [],
				touchstart: [],
				touchend: [],
				touchmove: [],
				update: []
			};

			

			dispatch( events.init, arguments );

		};

		this.setCamera = function ( value ) {
			camera = value;
			camera.aspect = this.width / this.height;
			camera.updateProjectionMatrix();

		};

		this.setScene = function ( value ) {
			scene = value;
		};

		this.setSize = function ( width, height ) {

			this.width = width;
			this.height = height;

			if ( camera ) {

				camera.aspect = this.width / this.height;
				camera.updateProjectionMatrix();

			}

			if ( renderer ) {

				renderer.setSize( width, height );

			}

		};
			
		function dispatch( array, event ) {

			for ( var i = 0, l = array.length; i < l; i ++ ) {

				array[ i ]( event );

			}

		}

		var prevTime, request;

		function animate( time ) {

			request = requestAnimationFrame( animate );

			try {

				dispatch( events.update, { time: time, delta: time - prevTime } );

			} catch ( e ) {

				console.error( ( e.message || e ), ( e.stack || "" ) );

			}

			if ( isVR === true ) {

				camera.updateMatrixWorld();

				
				effect.render( scene, cameraVR );

			} else {

				renderer.render( scene, camera );

			}

			prevTime = time;
		
		}

		this.play = function () {

			document.addEventListener( 'keydown', onDocumentKeyDown );
			document.addEventListener( 'keyup', onDocumentKeyUp );
			document.addEventListener( 'mousedown', onDocumentMouseDown );
			document.addEventListener( 'mouseup', onDocumentMouseUp );
			document.addEventListener( 'mousemove', onDocumentMouseMove );
			document.addEventListener( 'touchstart', onDocumentTouchStart );
			document.addEventListener( 'touchend', onDocumentTouchEnd );
			document.addEventListener( 'touchmove', onDocumentTouchMove );

			dispatch( events.start, arguments );

			request = requestAnimationFrame( animate );
			prevTime = performance.now();

		};

		this.stop = function () {

			document.removeEventListener( 'keydown', onDocumentKeyDown );
			document.removeEventListener( 'keyup', onDocumentKeyUp );
			document.removeEventListener( 'mousedown', onDocumentMouseDown );
			document.removeEventListener( 'mouseup', onDocumentMouseUp );
			document.removeEventListener( 'mousemove', onDocumentMouseMove );
			document.removeEventListener( 'touchstart', onDocumentTouchStart );
			document.removeEventListener( 'touchend', onDocumentTouchEnd );
			document.removeEventListener( 'touchmove', onDocumentTouchMove );

			dispatch( events.stop, arguments );

			cancelAnimationFrame( request );

		};

		

		function onDocumentKeyDown( event ) {

			dispatch( events.keydown, event );

		}

		function onDocumentKeyUp( event ) {

			dispatch( events.keyup, event );

		}

		function onDocumentMouseDown( event ) {

			dispatch( events.mousedown, event );

		}

		function onDocumentMouseUp( event ) {

			dispatch( events.mouseup, event );

		}

		function onDocumentMouseMove( event ) {

			dispatch( events.mousemove, event );

		}

		function onDocumentTouchStart( event ) {

			dispatch( events.touchstart, event );

		}

		function onDocumentTouchEnd( event ) {

			dispatch( events.touchend, event );

		}

		function onDocumentTouchMove( event ) {

			dispatch( events.touchmove, event );

		}

	



			</script>
		<script src="js/controls/OrbitControls.js"></script>
		<script src="js/loaders/TGALoader.js"></script>

		<script>

		var player;
		
			init();
			var loader = new THREE.ObjectLoader();
		var camera, scene, renderer;

		 controls, effect, cameraVR, isVR;
		var isMouseDown = false;

		var events = {};
		
	function init() {
	window.addEventListener('mousedown', onMouseDown);
    window.addEventListener('mouseup', onMouseUp);
	    function onMouseDown(){
    isMouseDown = true;
}

function onMouseUp(){
    isMouseDown = false;
}
			if(scene==null){
			
			var loader = new THREE.FileLoader();


			var appToUse;
			appToUse="app5.json"
			loader.load( appToUse, function ( text ) {
		
		
			load( JSON.parse( text ) );
			setSize( window.innerWidth, window.innerHeight );
			play();
			document.body.appendChild(dom );
				
						
	
		this.width = 500;
		this.height = 500;

	

		var controls = new THREE.OrbitControls( camera, renderer.domElement );
				controls.maxPolarAngle = Math.PI * 0.52;
				controls.minPolarAngle = Math.PI * 0.15;

				
				controls.minDistance = 1;
				controls.maxDistance = 20;

	
		var canvas = document.getElementById( "scene" );
			var windowHalfX = window.innerWidth / 2;
			var windowHalfY = window.innerHeight / 2;
						this.setSize = function ( width, height ) {
							
			windowHalfX = window.innerWidth / 2;
				windowHalfY = window.innerHeight / 2;
				camera.aspect = window.innerWidth / window.innerHeight;
				camera.updateProjectionMatrix();
				renderer.setSize( window.innerWidth, window.innerHeight );				
						};


window.addEventListener( 'resize', function () {
				setSize( window.innerWidth, window.innerHeight );
				} );
				
 light = new THREE.HemisphereLight(0xddeeff, 0x0f0e0d,0.6)
			  
			  shadowLight = new THREE.DirectionalLight(0xffffff, .6);
			  shadowLight.position.set(100,70, -200);
			  shadowLight.castShadow = true;
			  backLight = new THREE.DirectionalLight(0xffffff, .4);
			  backLight.position.set(-100, 150, -50);
			  backLight.castShadow = true;
				var hemilight = new THREE.HemisphereLight(0xffffff, 0xffffff,0.1)
			  scene.add(hemilight);
			  scene.add(backLight);
			  scene.add(light);
			  scene.add(shadowLight);
				scene.background = null;
				var head =  scene.getObjectByName("Head");
				var neck =  scene.getObjectByName("Neck");

			  if(appToUse=="app5.json"){

				var r_hip =  scene.getObjectByName("R_Hip");
				var r_knee =  scene.getObjectByName("R_Knee");
				var r_ankle =  scene.getObjectByName("R_Ankle");
				var l_ankle =  scene.getObjectByName("L_Ankle");
				var l_knee =  scene.getObjectByName("L_Knee");
				var l_hip =  scene.getObjectByName("L_Hip");
				var r_wrist =  scene.getObjectByName("R_Wrist");
				var r_elbow =  scene.getObjectByName("R_Elbow");
				var r_shoulder =  scene.getObjectByName("R_Shoulder");
				var abs =  scene.getObjectByName("Abs");
				var lumbar =  scene.getObjectByName("Lumbar");
				var chestJoint =  scene.getObjectByName("JointChest");
				var l_wrist =  scene.getObjectByName("L_Wrist");
				var l_elbow =  scene.getObjectByName("L_Elbow");
				var l_glute =  scene.getObjectByName("L_Glute");
				var r_glute =  scene.getObjectByName("R_Glute");
				var l_shoulder =  scene.getObjectByName("L_Shoulder");	
				var l_pec =  scene.getObjectByName("L_Pec");
				var r_pec =  scene.getObjectByName("R_Pec");
				
				var groin =  scene.getObjectByName("Groin");
				var r_thigh =  scene.getObjectByName("R_Thigh");
				var r_leg =  scene.getObjectByName("R_Leg");
				var r_foot =  scene.getObjectByName("R_Foot");
				var l_foot =  scene.getObjectByName("L_Foot");
				var l_leg =  scene.getObjectByName("L_Leg");
				var l_thigh =  scene.getObjectByName("L_Thigh");
				var r_hand =  scene.getObjectByName("R_Hand");
				var r_triceps =  scene.getObjectByName("R_Triceps");
				var r_biceps =  scene.getObjectByName("R_Biceps");
				var stomach =  scene.getObjectByName("Stomach");
				var chest =  scene.getObjectByName("Chest");
				var breast =  scene.getObjectByName("Breast");
				var r_pecs =  scene.getObjectByName("R_Pecs");
				var l_hand =  scene.getObjectByName("L_Hand");
				var l_triceps =  scene.getObjectByName("L_Triceps");
				var l_biceps =  scene.getObjectByName("L_Biceps");
				var l_pecs =  scene.getObjectByName("L_Pecs");
			 
				var joints = [neck, r_hip, r_knee,r_ankle,l_ankle,l_knee,l_hip,r_wrist,r_elbow,abs,lumbar,l_wrist,l_elbow,
				l_glute,r_glute,l_shoulder,l_pec,r_pec,r_shoulder,chestJoint];
				
				var body = [groin,r_thigh,r_leg,r_foot,l_foot,l_leg,l_thigh,r_hand,r_triceps,r_biceps,stomach,chest,breast,r_pecs,l_hand,l_triceps,l_biceps,
				head,l_pecs];
				/*
				var bodyDictionary = [];
				bodyDictionary.push({key: 'groin',value: groin});
				bodyDictionary.push({key: 'r_thigh',value: r_thigh});
				bodyDictionary.push({key: 'r_leg',value: r_leg});
				bodyDictionary.push({key: 'r_foot',value: r_foot});
				bodyDictionary.push({key: 'l_foot',value: l_foot});
				bodyDictionary.push({key: 'r_foot',value: r_foot});
				bodyDictionary.push({key: 'l_foot',value: l_foot});
				bodyDictionary.push({key: 'l_leg',value: l_leg});
				bodyDictionary.push({key: 'l_thigh',value: l_thigh});
				bodyDictionary.push({key: 'r_hand',value: r_hand});
				bodyDictionary.push({key: 'r_triceps',value: r_triceps});
				bodyDictionary.push({key: 'r_biceps',value: r_biceps});
				bodyDictionary.push({key: 'stomach',value: stomach});
				bodyDictionary.push({key: 'chest',value: chest});
				bodyDictionary.push({key: 'breast',value: breast});
				bodyDictionary.push({key: 'r_pecs',value: r_pecs});
				bodyDictionary.push({key: 'l_hand',value: l_hand});
				bodyDictionary.push({key: 'l_triceps',value: l_triceps});
				bodyDictionary.push({key: 'l_biceps',value: l_biceps});
				bodyDictionary.push({key: 'l_pecs',value: l_pecs});
				*/
				
					var jointmat =  new THREE.MeshPhongMaterial( {
								specular: 0,
								reflectivity: 0,
								shininess: 0,
								shading: THREE.SmoothShading,
								shininess: 0,
								reflectivity: 1,
								

								
								
							} );
					var bodymat =  new THREE.MeshPhongMaterial( {
								specular: 0,
								reflectivity: 0,
								shininess: 0,
								shading: THREE.SmoothShading,
								
							} );

							for(var i = 0 ; i< joints.length; i++){
									joints[i].position.y+=0.05;
									joints[i].position.z+=0.8;
									joints[i].position.x+=0.1;
									joints[i].material.map = null;	
									joints[i].material.specular = jointmat.specular;
									joints[i].material.shininess = jointmat.shininess;
									joints[i].material.reflectivity = jointmat.reflectivity;

								}
									for(var i = 0 ; i< body.length; i++){
									body[i].position.y+=0.05;
									body[i].position.z+=0.8;
									body[i].position.x+=0.1;
									body[i].material.color.setHex(0xffffff);
									body[i].material.map = null;
									body[i].material.specular = jointmat.specular;
									body[i].material.shininess = jointmat.shininess;
									body[i].material.reflectivity = jointmat.reflectivity;
								}
			  }else{
									head.position.y+=0.05;
									head.position.z+=0.05;
									head.position.x+=0.1;
									head.material.color.setHex(0xffffff);

									neck.position.y+=0.05;
									neck.position.z+=0.05;
									neck.position.x+=0.1;
									
								
			  }
				<?php
$getUsername = $_GET['username'];
$rawUserURL = "http://cache.toribash.com/cp/textures.php?username=" . $getUsername;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $rawUserURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
?>
				<?php
$split = explode(' ', $result); // Split up the whole string
$chunks = array_chunk($split, 2); // Make groups of 3 words
$urlString = array_map(
function ($chunk)
	{
	return implode(' ', $chunk);
	}

, $chunks); // Put each group back together


$userHeadURL;
$usergroin;
$userr_leg;
$userr_foot;
$userl_foot;
$userl_leg;
$userl_thigh;
$userr_thigh;
$userr_hand;
$userr_triceps;
$userr_biceps;
$userstomach;
$userchest;
$userbreast;
$userr_pecs;
$userl_hand;
$userl_triceps;
$userl_biceps;
$userl_pecs;

$userr_hip;
$userr_knee;
$userr_ankle;
$userl_ankle;
$userl_knee;
$userl_hip;
$userr_wrist;
$userr_elbow;
$userr_shoulder;
$userabs;
$userlumbar;
$userchestJoint;
$userl_wrist;
$userl_elbow;
$userl_glute;
$userr_glute;
$userl_shoulder;	
$userl_pec;
$userr_pec;

/*
$userbody = array(
$userHeadURL="head" => "head",
$usergroin="groin" => "groin",
$userr_leg="l_leg" => "r_leg",
$userr_foot="r_foot" => "r_foot",
$userl_foot="l_foot" => "l_foot",
$userl_leg="l_leg" => "l_Leg",
$userl_thigh="l_thigh" => "l_thigh",
$userr_thigh="r_thigh" => "r_thigh",
$userr_hand="r_hand" => "r_hand",
$userr_triceps="r_triceps"=> "r_triceps",
$userr_biceps="r_biceps" => "r_biceps",
$userstomach="stomach" => "stomach",
$userchest="chest" => "chest",
$userbreast="breast" => "brest",
$userr_pecs="r_pecs" => "r_pecs",
$userl_hand="l_hand" => "l_hand",
$userl_triceps="l_triceps" => "l_triceps",
$userl_biceps="l_biceps" => "l_biceps",
$userl_pecs="l_pecs" => "l_pecs"
);

*/
for ($i = 0; $i < count($urlString); $i++)
	{
//BODY
	if (stripos($urlString[$i], 'head.tga') !== false)
		{
		$userHeadURL = extractURL($urlString[$i]);
		}

	if (stripos($urlString[$i], 'groin.tga') !== false)
	{
		$usergroin = extractURL($urlString[$i]);
		}

	if (stripos($urlString[$i], $getUsername . '/r_leg.tga') !== false)
		{
		$userr_leg = extractURL($urlString[$i]);
		}

	if (stripos($urlString[$i], 'r_foot.tga') !== false)
		{
		$userr_foot = extractURL($urlString[$i]);
		}

	if (stripos($urlString[$i], 'l_foot.tga') !== false)
		{
		$userl_foot = extractURL($urlString[$i]);
		}

	if (stripos($urlString[$i], $getUsername . '/l_leg.tga') !== false)
		{
		$userl_leg = extractURL($urlString[$i]);
		}

	if (stripos($urlString[$i], 'l_thigh.tga') !== false)
		{
		$userl_thigh = extractURL($urlString[$i]);
		}

	if (stripos($urlString[$i], 'r_thigh.tga') !== false)
		{
		$userr_thigh = extractURL($urlString[$i]);
		}

	if (stripos($urlString[$i], $getUsername . '/r_hand.tga') !== false)
		{
		$userr_hand = extractURL($urlString[$i]);
		}

	if (stripos($urlString[$i], 'r_triceps.tga') !== false)
		{
		$userr_triceps = extractURL($urlString[$i]);
		}

	if (stripos($urlString[$i], 'r_biceps.tga') !== false)
		{
		$userr_biceps = extractURL($urlString[$i]);
		}

	if (stripos($urlString[$i], 'stomach.tga') !== false)
		{
		$userstomach = extractURL($urlString[$i]);
		}

	if (stripos($urlString[$i], 'chest.tga') !== false)
		{
		$userchest = extractURL($urlString[$i]);
		}

	if (stripos($urlString[$i], 'breast.tga') !== false)
		{
		$userbreast = extractURL($urlString[$i]);
		}

	if (stripos($urlString[$i], 'r_pecs.tga') !== false)
		{
		$userr_pecs = extractURL($urlString[$i]);
		}

	if (stripos($urlString[$i], $getUsername . '/l_hand.tga') !== false)
		{
		$userl_hand = extractURL($urlString[$i]);
		}

	if (stripos($urlString[$i], 'l_triceps.tga') !== false)
		{
		$userl_triceps = extractURL($urlString[$i]);
		}

	if (stripos($urlString[$i], 'l_biceps.tga') !== false)
		{
		$userl_biceps = extractURL($urlString[$i]);
		}

	if (stripos($urlString[$i], 'l_pecs.tga') !== false)
		{
		$userl_pecs = extractURL($urlString[$i]);
		}
		
//JOINTS
if (stripos($urlString[$i], 'r_hip.tga') !== false)
		{
		$userr_hip = extractURL($urlString[$i]);
		}
		
if (stripos($urlString[$i], 'r_knee.tga') !== false)
		{
		$userr_knee = extractURL($urlString[$i]);
		}
		
if (stripos($urlString[$i], 'r_ankle.tga') !== false)
		{
		$userr_ankle = extractURL($urlString[$i]);
		}
		
if (stripos($urlString[$i], 'l_ankle.tga') !== false)
		{
		$userl_ankle = extractURL($urlString[$i]);
		}
		
if (stripos($urlString[$i], 'l_knee.tga') !== false)
		{
		$userl_knee = extractURL($urlString[$i]);
		}
		
if (stripos($urlString[$i], 'l_hip.tga') !== false)
		{
		$userl_hip = extractURL($urlString[$i]);
		}
		
if (stripos($urlString[$i], 'r_wrist.tga') !== false)
		{
		$userr_wrist = extractURL($urlString[$i]);
		}
		
if (stripos($urlString[$i], 'r_elbow.tga') !== false)
		{
		$userr_elbow = extractURL($urlString[$i]);
		}
		
if (stripos($urlString[$i], 'r_shoulder.tga') !== false)
		{
		$userr_shoulder = extractURL($urlString[$i]);
		}
		
if (stripos($urlString[$i], 'abs.tga') !== false)
		{
		$userabs = extractURL($urlString[$i]);
		}
		
if (stripos($urlString[$i], 'lumbar.tga') !== false)
		{
		$userlumbar = extractURL($urlString[$i]);
		}
		
if (stripos($urlString[$i], '/j_chest.tga') !== false)
		{
		$userchestJoint = extractURL($urlString[$i]);
		}
		
if (stripos($urlString[$i], 'l_wrist.tga') !== false)
		{
		$userl_wrist = extractURL($urlString[$i]);
		}
		
if (stripos($urlString[$i], 'l_elbow.tga') !== false)
		{
		$userl_elbow = extractURL($urlString[$i]);
		}
		
if (stripos($urlString[$i], 'l_glute.tga') !== false)
		{
		$userl_glute = extractURL($urlString[$i]);
		}
		
if (stripos($urlString[$i], 'r_glute.tga') !== false)
		{
		$userr_glute = extractURL($urlString[$i]);
		}
		
if (stripos($urlString[$i], 'l_shoulder.tga') !== false)
		{
		$userl_shoulder = extractURL($urlString[$i]);
		}
		
if (stripos($urlString[$i], 'j_l_pecs.tga') !== false)
		{
		$userl_pec = extractURL($urlString[$i]);
		}
		
if (stripos($urlString[$i], 'j_r_pecs.tga') !== false)
		{
		$userr_pec = extractURL($urlString[$i]);
		}
		
	if (stripos($urlString[$i], 'neck.tga') !== false)
		{
		$userneck = extractURL($urlString[$i]);
		}
		
	}
	

		
	
	/*
$userr_hip;
$userr_knee;
$userr_ankle;
$userl_ankle;
$userl_knee;
$userl_hip;
$userr_wrist;
$userr_elbow;
$userr_shoulder;
$userabs;
$userlumbar;
$userchestJoint;
$userl_wrist;
$userl_elbow;
$userl_glute;
$userr_glute;
$userl_shoulder;	
$userl_pec;
$userr_pec;
*/
function extractURL($String)
	{
	$First = "http://";
	$Second = ".zlib?md5=";
	$sub = substr($String, strpos($String, $First) + strlen($First) , strlen($String));
	$url = substr($sub, 0, strpos($sub, $Second));
	$url = "http://" . $url;
	$url = str_replace('.tga', '.jpg', $url);
	return $url;
	}

// echo "alert('".$userHeadURL."');";

$target_path = 'texturetemp/';

function getimg($url)
	{
	$headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
	$headers[] = 'Connection: Keep-Alive';
	$headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
	$user_agent = 'php';
	$process = curl_init($url);
	curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($process, CURLOPT_HEADER, 0);
	curl_setopt($process, CURLOPT_USERAGENT, $user_agent); //check here
	curl_setopt($process, CURLOPT_TIMEOUT, 30);
	curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
	$return = curl_exec($process);
	curl_close($process);
	return $return;
	}

if (!file_exists('texturetemp/' . $getUsername))
	{
	mkdir('texturetemp/' . $getUsername, 0777, true);
	}

$imgurl = $userHeadURL;

// echo "alert('".$userHeadURL."');";
//BODY


$headname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $headname, $image);

$imgurl = $userstomach;
$stomachname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $stomachname, $image);
$imgurl = $usergroin;
$groinname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $groinname, $image);
$imgurl = $userr_thigh;
$r_thighname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $r_thighname, $image);
$imgurl = $userr_leg;
$r_legname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $r_legname, $image);
$imgurl = $userr_foot;
$r_footname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $r_footname, $image);
$imgurl = $userl_foot;
$l_footname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $l_footname, $image);
$imgurl = $userl_leg;
$l_legname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $l_legname, $image);
$imgurl = $userl_thigh;
$l_thighname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $l_thighname, $image);
$imgurl = $userr_hand;
$r_handname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $r_handname, $image);
$imgurl = $userr_triceps;
$r_tricepsname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $r_tricepsname, $image);
$imgurl = $userr_biceps;
$r_bicepsname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $r_bicepsname, $image);
$imgurl = $userstomach;
$stomachname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $stomachname, $image);
$imgurl = $userchest;
$chestname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $chestname, $image);
$imgurl = $userbreast;
$breastname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $breastname, $image);
$imgurl = $userr_pecs;
$r_pecsname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $r_pecsname, $image);
$imgurl = $userl_hand;
$l_handname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $l_handname, $image);
$imgurl = $userl_triceps;
$l_tricepsname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $l_tricepsname, $image);
$imgurl = $userl_biceps;
$l_bicepsname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $l_bicepsname, $image);
$imgurl = $userl_pecs;
$l_pecsname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $l_pecsname, $image);
//JOINTS
$imgurl = $userr_hip;;
$r_hipname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $r_hipname, $image);

$imgurl = $userr_knee;
$r_kneename = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $r_kneename, $image);

$imgurl = $userr_ankle;
$r_anklename = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $r_anklename, $image);
$imgurl = $userl_ankle;
$l_anklename = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $l_anklename, $image);

$imgurl = $userl_knee;
$l_kneename = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $l_kneename, $image);
$imgurl = $userl_hip;
$l_hipname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $l_hipname, $image);

$imgurl = $userr_wrist;
$r_wristname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $r_wristname, $image);

$imgurl = $userr_elbow;
$r_elbowname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $r_elbowname, $image);

$imgurl = $userr_shoulder;
$r_shouldername = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $r_shouldername, $image);

$imgurl = $userabs;
$absname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $absname, $image);

$imgurl = $userlumbar;
$lumbarname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $lumbarname, $image);

$imgurl = $userchestJoint;
$chestJointname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $chestJointname, $image);

$imgurl = $userl_wrist;
$l_wristname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $l_wristname, $image);

$imgurl = $userl_elbow;
$l_elbowname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $l_elbowname, $image);

$imgurl = $userl_glute;
$l_glutename = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $l_glutename, $image);

$imgurl = $userr_glute;
$r_glutename = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $r_glutename, $image);

$imgurl = $userl_shoulder;
$l_shouldername = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $l_shouldername, $image);

$imgurl = $userl_pec;
$l_pecname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $l_pecname, $image);

$imgurl = $userr_pec;
$r_pecname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $r_pecname, $image);

$imgurl = $userneck;
$neckname = basename($imgurl);
$image = getimg($imgurl);
file_put_contents('texturetemp/' . $getUsername . '/' . $neckname, $image);

?>



var loader = new THREE.TextureLoader();
loader.crossOrigin = '';
<?php 

	if($headname != ""){?>	

var headtexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $headname; ?>');
headtexturesrc.magFilter = THREE.NearestFilter;
headtexturesrc.minFilter = THREE.NearestFilter;
head.material.map = headtexturesrc;
<?php } ?>

<?php if($stomachname != ""){?>
var stomachtexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $stomachname; ?>');
stomachtexturesrc.magFilter = THREE.NearestFilter;
stomachtexturesrc.minFilter = THREE.NearestFilter;
stomach.material.map = stomachtexturesrc;
<?php } ?>

<?php if($groinname != ""){?>
var grointexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $groinname; ?>');
grointexturesrc.magFilter = THREE.NearestFilter;
grointexturesrc.minFilter = THREE.NearestFilter;
groin.material.map = grointexturesrc;
<?php } ?>

<?php if($r_thighname != ""){?>
var r_thightexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $r_thighname; ?>');
r_thightexturesrc.magFilter = THREE.NearestFilter;
r_thightexturesrc.minFilter = THREE.NearestFilter;
r_thigh.material.map = r_thightexturesrc;
<?php } ?>

<?php if($r_legname != ""){?>
var r_legtexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $r_legname; ?>');
r_legtexturesrc.magFilter = THREE.NearestFilter;
r_legtexturesrc.minFilter = THREE.NearestFilter;
r_leg.material.map = r_legtexturesrc;
<?php } ?>

<?php if($r_footname != ""){?>
var r_foottexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $r_footname; ?>');
r_foottexturesrc.magFilter = THREE.NearestFilter;
r_foottexturesrc.minFilter = THREE.NearestFilter;
r_foot.material.map = r_foottexturesrc;
<?php } ?>

<?php if($l_footname != ""){?>
var l_foottexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $l_footname; ?>');
l_foottexturesrc.magFilter = THREE.NearestFilter;
l_foottexturesrc.minFilter = THREE.NearestFilter;
l_foot.material.map = l_foottexturesrc;
<?php } ?>

<?php if($l_legname != ""){?>
var l_legtexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $l_legname; ?>');
l_legtexturesrc.magFilter = THREE.NearestFilter;
l_legtexturesrc.minFilter = THREE.NearestFilter;
l_leg.material.map = l_legtexturesrc;
<?php } ?>

<?php if($l_thighname != ""){?>
var l_thightexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $l_thighname; ?>');
l_thightexturesrc.magFilter = THREE.NearestFilter;
l_thightexturesrc.minFilter = THREE.NearestFilter;
l_thigh.material.map = l_thightexturesrc;
<?php } ?>

<?php if($r_handname != ""){?>
var r_handtexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $r_handname; ?>');
r_handtexturesrc.magFilter = THREE.NearestFilter;
r_handtexturesrc.minFilter = THREE.NearestFilter;
r_hand.material.map = r_handtexturesrc;
<?php } ?>

<?php if($r_tricepsname != ""){?>
var r_tricepstexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $r_tricepsname; ?>');
r_tricepstexturesrc.magFilter = THREE.NearestFilter;
r_tricepstexturesrc.minFilter = THREE.NearestFilter;
r_triceps.material.map = r_tricepstexturesrc;
<?php } ?>

<?php if($r_bicepsname != ""){?>
var r_bicepstexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $r_bicepsname; ?>');
r_bicepstexturesrc.magFilter = THREE.NearestFilter;
r_bicepstexturesrc.minFilter = THREE.NearestFilter;
r_biceps.material.map = r_bicepstexturesrc;
<?php } ?>

<?php if($chestname != ""){?>
var chesttexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $chestname; ?>');
chesttexturesrc.magFilter = THREE.NearestFilter;
chesttexturesrc.minFilter = THREE.NearestFilter;
chest.material.map = chesttexturesrc;
<?php } ?>

<?php if($breastname != ""){?>
var breasttexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $breastname; ?>');
breasttexturesrc.magFilter = THREE.NearestFilter;
breasttexturesrc.minFilter = THREE.NearestFilter;
breast.material.map = breasttexturesrc;
<?php } ?>

<?php if($r_pecsname != ""){?>
var r_pecstexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $r_pecsname; ?>');
r_pecstexturesrc.magFilter = THREE.NearestFilter;
r_pecstexturesrc.minFilter = THREE.NearestFilter;
r_pecs.material.map = r_pecstexturesrc;
<?php } ?>

<?php if($l_handname != ""){?>
var l_handtexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $l_handname; ?>');
l_handtexturesrc.magFilter = THREE.NearestFilter;
l_handtexturesrc.minFilter = THREE.NearestFilter;
l_hand.material.map = l_handtexturesrc;
<?php } ?>

<?php if($l_tricepsname != ""){?>
var l_tricepstexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $l_tricepsname; ?>');
l_tricepstexturesrc.magFilter = THREE.NearestFilter;
l_tricepstexturesrc.minFilter = THREE.NearestFilter;
l_triceps.material.map = l_tricepstexturesrc;
<?php } ?>

<?php if($l_bicepsname != ""){?>
var l_bicepstexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $l_bicepsname; ?>');
l_bicepstexturesrc.magFilter = THREE.NearestFilter;
l_bicepstexturesrc.minFilter = THREE.NearestFilter;
l_biceps.material.map = l_bicepstexturesrc;
<?php } ?>

<?php if($l_pecsname != ""){?>
var l_pecstexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $l_pecsname; ?>');
l_pecstexturesrc.magFilter = THREE.NearestFilter;
l_pecstexturesrc.minFilter = THREE.NearestFilter;
l_pecs.material.map = l_pecstexturesrc;
<?php } ?>	
//JOINTS
<?php if($r_hipname != ""){?>
var r_hiptexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $r_hipname; ?>');
r_hiptexturesrc.magFilter = THREE.NearestFilter;
r_hiptexturesrc.minFilter = THREE.NearestFilter;
r_hip.material.map = r_hiptexturesrc;
<?php } ?>

<?php if($r_kneename != ""){?>
var r_kneetexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $r_kneename; ?>');
r_kneetexturesrc.magFilter = THREE.NearestFilter;
r_kneetexturesrc.minFilter = THREE.NearestFilter;
r_knee.material.map = r_kneetexturesrc;
<?php } ?>	

<?php if($r_anklename != ""){?>
var r_ankletexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $r_anklename; ?>');
r_ankletexturesrc.magFilter = THREE.NearestFilter;
r_ankletexturesrc.minFilter = THREE.NearestFilter;
r_ankle.material.map = r_ankletexturesrc;
<?php } ?>	

<?php if($l_anklename != ""){?>
var l_ankletexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $l_anklename; ?>');
l_ankletexturesrc.magFilter = THREE.NearestFilter;
l_ankletexturesrc.minFilter = THREE.NearestFilter;
l_ankle.material.map = l_ankletexturesrc;
<?php } ?>	

<?php if($l_kneename != ""){?>
var l_kneetexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $l_kneename; ?>');
l_kneetexturesrc.magFilter = THREE.NearestFilter;
l_kneetexturesrc.minFilter = THREE.NearestFilter;
l_knee.material.map = l_kneetexturesrc;
<?php } ?>	

<?php if($l_hipname != ""){?>
var l_hiptexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $l_hipname; ?>');
l_hiptexturesrc.magFilter = THREE.NearestFilter;
l_hiptexturesrc.minFilter = THREE.NearestFilter;
l_hip.material.map = l_hiptexturesrc;
<?php } ?>	

<?php if($r_wristname != ""){?>
var r_wristtexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $r_wristname; ?>');
r_wristtexturesrc.magFilter = THREE.NearestFilter;
r_wristtexturesrc.minFilter = THREE.NearestFilter;
r_wrist.material.map = r_wristtexturesrc;
<?php } ?>	

<?php if($r_elbowname != ""){?>
var r_elbowtexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $r_elbowname; ?>');
r_elbowtexturesrc.magFilter = THREE.NearestFilter;
r_elbowtexturesrc.minFilter = THREE.NearestFilter;
r_elbow.material.map = r_elbowtexturesrc;
<?php } ?>	

<?php if($r_shouldername != ""){?>
var r_shouldertexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $r_shouldername; ?>');
r_shouldertexturesrc.magFilter = THREE.NearestFilter;
r_shouldertexturesrc.minFilter = THREE.NearestFilter;
r_shoulder.material.map = r_shouldertexturesrc;
<?php } ?>	

<?php if($absname != ""){?>
var abstexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $absname; ?>');
abstexturesrc.magFilter = THREE.NearestFilter;
abstexturesrc.minFilter = THREE.NearestFilter;
abs.material.map = abstexturesrc;
<?php } ?>	

<?php if($lumbarname != ""){?>
var lumbartexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $lumbarname; ?>');
lumbartexturesrc.magFilter = THREE.NearestFilter;
lumbartexturesrc.minFilter = THREE.NearestFilter;
lumbar.material.map = lumbartexturesrc;
<?php } ?>	

<?php if($chestJointname != ""){?>
var chestJointtexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $chestJointname; ?>');
chestJointtexturesrc.magFilter = THREE.NearestFilter;
chestJointtexturesrc.minFilter = THREE.NearestFilter;
chestJoint.material.map = chestJointtexturesrc;
<?php } ?>	

<?php if($l_wristname != ""){?>
var l_wristtexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $l_wristname; ?>');
l_wristtexturesrc.magFilter = THREE.NearestFilter;
l_wristtexturesrc.minFilter = THREE.NearestFilter;
l_wrist.material.map = l_wristtexturesrc;
<?php } ?>	

<?php if($l_elbowname != ""){?>
var l_elbowtexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $l_elbowname; ?>');
l_elbowtexturesrc.magFilter = THREE.NearestFilter;
l_elbowtexturesrc.minFilter = THREE.NearestFilter;
l_elbow.material.map = l_elbowtexturesrc;
<?php } ?>	

<?php if($l_glutename != ""){?>
var l_glutetexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $l_glutename; ?>');
l_glutetexturesrc.magFilter = THREE.NearestFilter;
l_glutetexturesrc.minFilter = THREE.NearestFilter;
l_glute.material.map = l_glutetexturesrc;
<?php } ?>	

<?php if($r_glutename != ""){?>
var r_glutetexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $r_glutename; ?>');
r_glutetexturesrc.magFilter = THREE.NearestFilter;
r_glutetexturesrc.minFilter = THREE.NearestFilter;
r_glute.material.map = r_glutetexturesrc;
<?php } ?>	

<?php if($l_shouldername != ""){?>
var l_shouldertexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $l_shouldername; ?>');
l_shouldertexturesrc.magFilter = THREE.NearestFilter;
l_shouldertexturesrc.minFilter = THREE.NearestFilter;
l_shoulder.material.map = l_shouldertexturesrc;
<?php } ?>	

<?php if($l_pecname != ""){?>
var l_pectexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $l_pecname; ?>');
l_pectexturesrc.magFilter = THREE.NearestFilter;
l_pectexturesrc.minFilter = THREE.NearestFilter;
l_pec.material.map = l_pectexturesrc;
<?php } ?>	

<?php if($r_pecname != ""){?>
var r_pectexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $r_pecname; ?>');
r_pectexturesrc.magFilter = THREE.NearestFilter;
r_pectexturesrc.minFilter = THREE.NearestFilter;
r_pec.material.map = r_pectexturesrc;
<?php } ?>	

<?php if($neckname != ""){?>
var necktexturesrc = loader.load('texturetemp/<?php
echo $getUsername . '/' . $neckname; ?>');
necktexturesrc.magFilter = THREE.NearestFilter;
necktexturesrc.minFilter = THREE.NearestFilter;
neck.material.map = necktexturesrc;
<?php } ?>	

			});
			}
			
	}	
		</script>
	</body>
</html>
