<?php
	include 'includes/session.php';
	if (isset($_POST['search'])) {
		header('Location: search.php?q=' . $_POST["search"]);
	}
	if (isset($_POST['search'])) {
		header('Location: search.php?q=' . $_POST["search"]);
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include 'includes/links.php'; ?>
		<script src="build/three.min.js"></script>
		<script src="js/controls/OrbitControls.js"></script>
		<script src="js/loaders/TGALoader.js"></script>
		
		<style>
			body {
			font-family: Helvetica, Arial, sans-serif;
			font-size: 12px;
			background-image: url("../img/custombg.png");
			margin: 0px;
			overflow-x: hidden;
			}
			#edit {
			position: absolute;
			bottom: 20px;
			right: 20px;
			padding: 8px;
			text-decoration: none;
			background-color: #fff;
			color: #555;
			opacity: 0.5;
			}
			#edit:hover {
			opacity: 1;
			}
			#texturepanel{
			overflow-y: scroll;
			overflow-x: hidden;
			}
			.modal {
			display: none; 
			position: fixed; 
			z-index: 1; 
			padding-top: 100px;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%; 
			overflow: auto;
			}
			.modal-content {
			background-color: #fefefe;
			margin: auto;
			margin-left:50px;
			padding: 20px;
			border: 1px solid #888;
			width: 360px;
			height: 93%;
			margin-top:10px;
			}
			.close {
			color: #aaaaaa;
			float: right;
			font-size: 28px;
			font-weight: bold;
			}
			.close:hover, .close:focus {
			color: #000;
			text-decoration: none;
			cursor: pointer;
			}
			#myBtn{
			letter-spacing: 2px;
			font-family: badaboom;  outline: 0;
			border: none;
			background: transparent;
			width: 150px;
			padding-top: 10px;
			font-size: 16px;
			height: 40px;
			border-radius: 3px;
			box-shadow: 0px 3px #a3a3a3;
			width: 100%;
			text-align-last:center;  
			color:#7a7a7a;
			background: linear-gradient(to bottom,  #ececec 0%,#d9d9d9 100%);
			}
			#myBtn:hover {
			cursor: pointer;
			background-color:#2598d7; }
			#title{
			height: 5px;
			}
			#artist{
			height: 5px;
			}
			.form{
			height:100%;	
			}
			p{
			margin:0px;
			}
			.thumb-capture-overlay{
			width: 50vw;
			height: 50vw;
			max-height: 50vh;
			max-width: 50vh;
			margin: auto;
			border: 2px solid rgba(0,0,0,0.3);
			pointer-events: none;
			position: absolute;
			top: -40%;
			bottom: 0;
			left: 0;
			right: 0;
			opacity:0.6;
			}
			.thumb-capture-overlay span{
			position: absolute;
			bottom: 0;
			font-size:1em;
			bottom:0;
			left:0;
			text-align:left;
			}
			
		</style>
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		
		<?php
			require_once('includes/config.php');
			
			$uploadpoints = 0;
			if (!isset($_SESSION['Username'])) {
				$posterror = "You need to be logged in to upload a texture.";
			}
			if (isset($_POST['submit'])) {
				if (isset($_SESSION['Username'])) {
					if (validatefile("inputimage") || validatefile("groin") || validatefile("r_thigh") || validatefile("r_leg") || validatefile("r_foot") || validatefile("l_foot") || validatefile("l_leg") || validatefile("l_thigh") || validatefile("r_triceps") || validatefile("r_hand") || validatefile("r_biceps") || validatefile("stomach") || validatefile("chest") || validatefile("breast") || validatefile("r_pecs") || validatefile("l_hand") || validatefile("l_triceps") || validatefile("l_biceps") || validatefile("l_pecs") || validatefile("l_knee") || validatefile("l_glute") || validatefile("l_hip") || validatefile("r_hip") || validatefile("r_knee") || validatefile("r_glute") || validatefile("l_ankle") || validatefile("r_ankle") || validatefile("l_wrist") || validatefile("r_wrist") || validatefile("l_elbow") || validatefile("l_shoulder") || validatefile("l_pecs") || validatefile("r_elbow") || validatefile("r_shoulder") || validatefile("l_pecs") || validatefile("r_elbow") || validatefile("r_shoulder") || validatefile("r_pec") || validatefile("abs") || validatefile("lumbar") || validatefile("chestJoint") || validatefile("neck")) {
						$posterror = "One of your selected Images is too big. The maximum image size is 2mb";
						$uploadpoints++;
					}
					if (($_POST['title']) == "") {
						$posterror = "Please title your texture.";
						$uploadpoints++;
					}
					if ($uploadpoints == 0) {
						$postsuccess = "Upload was successful. Upload another texture?";
						posttexture();
					}
					} else {
					$posterror = "You need to be logged in to upload a texture.";
				}
			}
			function validatefile($inputname) {
				$maxfilesize = 10485760;
				if ($_FILES[$inputname]["size"] != 0) {
					if ($_FILES[$inputname]['size'] > $maxfilesize) {
						return true;
					}
					$FileType = pathinfo(basename($_FILES[$inputname]["name"]), PATHINFO_EXTENSION);
					if ($FileType != "jpg" && $FileType != "png" && $FileType != "jpeg" && $FileType != "gif" && $FileType != "tga") {
						$posterror = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
						return true;
					}
					return false;
				}
				return false;
			}
		?>
		<div class="thumb-capture-overlay">
			<span> Thumbnail Preview <span>
			</div>
			<div id="leftcolumn">
				<div class="login-page">
					<div class="form">
						<form class="login-form" method ="post" enctype = "multipart/form-data" >
							<h2> <span class="yellowtxt">TEXTURE</span> <br/><span class="greytxt"> EDITOR</span></h2>
							<?php echo "<p class='error message' style='color:red;'>" . $posterror . "</p>"; ?>
							<?php echo "<p class='error message' style='color:#04e00e;'>" . $postsuccess . "</p>"; ?>
							<br/>
							<p class="message">Title: <span class="requiredfield">*Required</span></p>
							<input type ="text" id="title" maxlength="20" name="title"/>
							<p class="message">Artist:</p>
							<input type ="text" id="artist" maxlength="20" name="artist"/>
							<div id="myBtn">Open Texture Panel</div>
							<div id="myModal" class="modal">
								<div id="texturepanel" class="modal-content">
									<span class="close">&times;</span>
									<p class="message">Body Textures</p>
									head
									<input type ="file" name="inputimage"  onchange="previewFile(getElementById('textureimg'),getElementById('file') ); updatemodel(getElementById('textureimg'),getElementById('file'),'Head');" style="color: #C0C0C0;" id="file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="textureimg" >
									</br>r_hand
									<input type ="file" name="r_hand"  onchange="previewFile(getElementById('r_hand_img'),getElementById('r_hand_file') ); updatemodel(getElementById('r_hand_img'),getElementById('r_hand_file'),'R_Hand' );" style="color: #C0C0C0;" id="r_hand_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga,"/>
									<img src="" height="128" width="128" alt="Image preview..." id="r_hand_img" >
									</br>chest
									<input type ="file" name="chest"  onchange="previewFile(getElementById('chest_img'),getElementById('chest_file') ); updatemodel(getElementById('chest_img'),getElementById('chest_file'),'Chest' );" style="color: #C0C0C0;" id="chest_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="chest_img" >
									</br>breast
									<input type ="file" name="breast"  onchange="previewFile(getElementById('breast_img'),getElementById('breast_file') ); updatemodel(getElementById('breast_img'),getElementById('breast_file'),'Breast' );" style="color: #C0C0C0;" id="breast_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="breast_img" >
									</br>stomach
									<input type ="file" name="stomach"  onchange="previewFile(getElementById('stomach_img'),getElementById('stomach_file') ); updatemodel(getElementById('stomach_img'),getElementById('stomach_file'),'Stomach' );" style="color: #C0C0C0;" id="stomach_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="stomach_img" >
									</br>groin
									<input type ="file" name="groin"  onchange="previewFile(getElementById('groin_img'),getElementById('groin_file') ); updatemodel(getElementById('groin_img'),getElementById('groin_file'),'Groin' );" style="color: #C0C0C0;" id="groin_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="groin_img" >
									</br>r_pecs
									<input type ="file" name="r_pecs"  onchange="previewFile(getElementById('r_pecs_img'),getElementById('r_pecs_file') ); updatemodel(getElementById('r_pecs_img'),getElementById('r_pecs_file'),'R_Pecs' );" style="color: #C0C0C0;" id="r_pecs_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="r_pecs_img" >
									</br>l_pecs
									<input type ="file" name="l_pecs"  onchange="previewFile(getElementById('l_pecs_img'),getElementById('l_pecs_file') ); updatemodel(getElementById('l_pecs_img'),getElementById('l_pecs_file'),'L_Pecs' );" style="color: #C0C0C0;" id="l_pecs_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="l_pecs_img" >
									</br>r_biceps
									<input type ="file" name="r_biceps"  onchange="previewFile(getElementById('r_biceps_img'),getElementById('r_biceps_file') ); updatemodel(getElementById('r_biceps_img'),getElementById('r_biceps_file'),'R_Biceps' );" style="color: #C0C0C0;" id="r_biceps_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="r_biceps_img" >
									</br>r_triceps
									<input type ="file" name="r_triceps"  onchange="previewFile(getElementById('r_triceps_img'),getElementById('r_triceps_file') ); updatemodel(getElementById('r_triceps_img'),getElementById('r_triceps_file'),'R_Triceps' );" style="color: #C0C0C0;" id="r_triceps_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="r_triceps_img" >
									</br>l_biceps
									<input type ="file" name="l_biceps"  onchange="previewFile(getElementById('l_biceps_img'),getElementById('l_biceps_file') ); updatemodel(getElementById('l_biceps_img'),getElementById('l_biceps_file'),'L_Biceps' );" style="color: #C0C0C0;" id="l_biceps_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="l_biceps_img" >
									</br>l_triceps
									<input type ="file" name="l_triceps"  onchange="previewFile(getElementById('l_triceps_img'),getElementById('l_triceps_file') ); updatemodel(getElementById('l_triceps_img'),getElementById('l_triceps_file'),'L_Triceps' );" style="color: #C0C0C0;" id="l_triceps_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="l_triceps_img" >
									</br>l_hand
									<input type ="file" name="l_hand"  onchange="previewFile(getElementById('l_hand_img'),getElementById('l_hand_file') ); updatemodel(getElementById('l_hand_img'),getElementById('l_hand_file'),'L_Hand' );" style="color: #C0C0C0;" id="l_hand_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="l_hand_img" >
									</br>r_thigh
									<input type ="file" name="r_thigh"  onchange="previewFile(getElementById('r_thigh_img'),getElementById('r_thigh_file') ); updatemodel(getElementById('r_thigh_img'),getElementById('r_thigh_file'),'R_Thigh' );" style="color: #C0C0C0;" id="r_thigh_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="r_thigh_img" >
									</br>l_thigh
									<input type ="file" name="l_thigh"  onchange="previewFile(getElementById('l_thigh_img'),getElementById('l_thigh_file') ); updatemodel(getElementById('l_thigh_img'),getElementById('l_thigh_file'),'L_Thigh' );" style="color: #C0C0C0;" id="l_thigh_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="l_thigh_img" >
									</br>l_leg
									<input type ="file" name="l_leg"  onchange="previewFile(getElementById('l_leg_img'),getElementById('l_leg_file') ); updatemodel(getElementById('l_leg_img'),getElementById('l_leg_file'),'L_Leg' );" style="color: #C0C0C0;" id="l_leg_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="l_leg_img" >
									</br>r_leg
									<input type ="file" name="r_leg"  onchange="previewFile(getElementById('r_leg_img'),getElementById('r_leg_file') ); updatemodel(getElementById('r_leg_img'),getElementById('r_leg_file'),'R_Leg' );" style="color: #C0C0C0;" id="r_leg_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="r_leg_img" >
									</br>r_foot
									<input type ="file" name="r_foot"  onchange="previewFile(getElementById('r_foot_img'),getElementById('r_foot_file') ); updatemodel(getElementById('r_foot_img'),getElementById('r_foot_file'),'R_Foot' );" style="color: #C0C0C0;" id="r_foot_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="r_foot_img" >
									</br>l_foot
									<input type ="file" name="l_foot"  onchange="previewFile(getElementById('l_foot_img'),getElementById('l_foot_file') ); updatemodel(getElementById('l_foot_img'),getElementById('l_foot_file'),'L_Foot' );" style="color: #C0C0C0;" id="l_foot_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="l_foot_img" >
									</br>
									
									<p class="message">Joint Textures</p>
									abs
									<input type ="file" name="abs"  onchange="previewFile(getElementById('abs_img'),getElementById('abs_file') ); updatemodel(getElementById('abs_img'),getElementById('abs_file'),'Abs' );" style="color: #C0C0C0;" id="abs_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="abs_img" >
									</br>
									j_chest 
									<input type ="file" name="chestJoint"  onchange="previewFile(getElementById('chestJoint_img'),getElementById('chestJoint_file') ); updatemodel(getElementById('chestJoint_img'),getElementById('chestJoint_file'),'JointChest' );" style="color: #C0C0C0;" id="chestJoint_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="chestJoint_img" >
									</br>
									
									j_l_ankle
									<input type ="file" name="l_ankle"  onchange="previewFile(getElementById('l_ankle_img'),getElementById('l_ankle_file') ); updatemodel(getElementById('l_ankle_img'),getElementById('l_ankle_file'),'L_Ankle' );" style="color: #C0C0C0;" id="l_ankle_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="l_ankle_img" >
									</br>
									j_l_knee
									<input type ="file" name="l_knee"  onchange="previewFile(getElementById('l_knee_img'),getElementById('l_knee_file') ); updatemodel(getElementById('l_knee_img'),getElementById('l_knee_file'),'L_Knee' );" style="color: #C0C0C0;" id="l_knee_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="l_knee_img" >
									</br>
									j_l_glute
									<input type ="file" name="l_glute"  onchange="previewFile(getElementById('l_glute_img'),getElementById('l_glute_file') ); updatemodel(getElementById('l_glute_img'),getElementById('l_glute_file'),'L_Glute' );" style="color: #C0C0C0;" id="l_glute_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="l_glute_img" >
									</br>
									j_l_hip
									<input type ="file" name="l_hip"  onchange="previewFile(getElementById('l_hip_img'),getElementById('l_hip_file') ); updatemodel(getElementById('l_hip_img'),getElementById('l_hip_file'),'L_Hip' );" style="color: #C0C0C0;" id="l_hip_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="l_hip_img" >
									</br>
									j_r_hip
									<input type ="file" name="r_hip"  onchange="previewFile(getElementById('r_hip_img'),getElementById('r_hip_file') ); updatemodel(getElementById('r_hip_img'),getElementById('r_hip_file'),'R_Hip' );" style="color: #C0C0C0;" id="r_hip_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="r_hip_img" >
									</br>
									j_r_knee
									<input type ="file" name="r_knee"  onchange="previewFile(getElementById('r_knee_img'),getElementById('r_knee_file') ); updatemodel(getElementById('r_knee_img'),getElementById('r_knee_file'),'R_Knee' );" style="color: #C0C0C0;" id="r_knee_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="r_knee_img" >
									</br>
									j_r_glute
									<input type ="file" name="r_glute"  onchange="previewFile(getElementById('r_glute_img'),getElementById('r_glute_file') ); updatemodel(getElementById('r_glute_img'),getElementById('r_glute_file'),'R_Glute' );" style="color: #C0C0C0;" id="r_glute_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="r_glute_img" >
									</br>
									j_r_ankle
									<input type ="file" name="r_ankle"  onchange="previewFile(getElementById('r_ankle_img'),getElementById('r_ankle_file') ); updatemodel(getElementById('r_ankle_img'),getElementById('r_ankle_file'),'R_Ankle' );" style="color: #C0C0C0;" id="r_ankle_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="r_ankle_img" >
									</br>
									j_l_wrist
									<input type ="file" name="l_wrist"  onchange="previewFile(getElementById('l_wrist_img'),getElementById('l_wrist_file') ); updatemodel(getElementById('l_wrist_img'),getElementById('l_wrist_file'),'L_Wrist' );" style="color: #C0C0C0;" id="l_wrist_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="l_wrist_img" >
									</br>
									j_r_wrist
									<input type ="file" name="r_wrist"  onchange="previewFile(getElementById('r_wrist_img'),getElementById('r_wrist_file') ); updatemodel(getElementById('r_wrist_img'),getElementById('r_wrist_file'),'R_Wrist' );" style="color: #C0C0C0;" id="r_wrist_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="r_wrist_img" >
									</br>
									j_l_elbow
									<input type ="file" name="l_elbow"  onchange="previewFile(getElementById('l_elbow_img'),getElementById('l_elbow_file') ); updatemodel(getElementById('l_elbow_img'),getElementById('l_elbow_file'),'L_Elbow' );" style="color: #C0C0C0;" id="l_elbow_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="l_elbow_img" >
									</br>
									j_l_shoulder
									<input type ="file" name="l_shoulder"  onchange="previewFile(getElementById('l_shoulder_img'),getElementById('l_shoulder_file') ); updatemodel(getElementById('l_shoulder_img'),getElementById('l_shoulder_file'),'L_Shoulder' );" style="color: #C0C0C0;" id="l_shoulder_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="l_shoulder_img" >
									</br>
									j_l_pec
									<input type ="file" name="l_pec"  onchange="previewFile(getElementById('l_pec_img'),getElementById('l_pec_file') ); updatemodel(getElementById('l_pec_img'),getElementById('l_pec_file'),'L_Pec' );" style="color: #C0C0C0;" id="l_pec_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="l_pec_img" >
									</br>
									j_r_elbow
									<input type ="file" name="r_elbow"  onchange="previewFile(getElementById('r_elbow_img'),getElementById('r_elbow_file') ); updatemodel(getElementById('r_elbow_img'),getElementById('r_elbow_file'),'R_Elbow' );" style="color: #C0C0C0;" id="r_elbow_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="r_elbow_img" >
									</br>
									j_r_shoulder
									<input type ="file" name="r_shoulder"  onchange="previewFile(getElementById('r_shoulder_img'),getElementById('r_shoulder_file') ); updatemodel(getElementById('r_shoulder_img'),getElementById('r_shoulder_file'),'R_Shoulder' );" style="color: #C0C0C0;" id="r_shoulder_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="r_shoulder_img" >
									</br>
									j_r_pec
									<input type ="file" name="r_pec"  onchange="previewFile(getElementById('r_pec_img'),getElementById('r_pec_file') ); updatemodel(getElementById('r_pec_img'),getElementById('r_pec_file'),'R_Pec' );" style="color: #C0C0C0;" id="r_pec_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="r_pec_img" >
									</br>
									j_lumbar
									<input type ="file" name="lumbar"  onchange="previewFile(getElementById('lumbar_img'),getElementById('lumbar_file') ); updatemodel(getElementById('lumbar_img'),getElementById('lumbar_file'),'Lumbar' );" style="color: #C0C0C0;" id="lumbar_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="lumbar_img" >
									</br>
									j_neck
									<input type ="file" name="neck"  onchange="previewFile(getElementById('neck_img'),getElementById('neck_file') ); updatemodel(getElementById('neck_img'),getElementById('neck_file'),'Neck' );" style="color: #C0C0C0;" id="neck_file"  onfocus="this.value=''; this.style.color='#C0C0C0'" accept="image/*,.tga"/>
									<img src="" height="128" width="128" alt="Image preview..." id="neck_img" >
									</br>	
									
									
								</div>											
							</div>
							<script>
								
							</script>
							</br>
							
							<select id="colorselect">
								<option value="jointselect">
									<p class="message" >Joint color</p>
								</option>
								<option value="bodyselect">
									<p class="message">Body color</p>
								</option>
							</select>
							
							<p class="sub-message" id="colorname">Acid</p>
							<div class="scrollbar" id="style-2">
								<div class="section group">
									<div class="col span_1_of_5" style="background:#B2FF1A;" onClick="getColor(this)" title="Acid">
										Acid
									</div>
									<div class="col span_1_of_5" style="background:#2E94BA;" onClick="getColor(this)">
										Adamantium
									</div>
									<div class="col span_1_of_5" style="background:#191970;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#FF7517;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#FF33F2;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#0080FF;" onClick="getColor(this)">
										Acid
									</div>
									<div class="col span_1_of_5" style="background:#F5E3F7;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#1F364C;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#7F3A00;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#CC6633;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#556B2F;" onClick="getColor(this)">
										Acid
									</div>
									<div class="col span_1_of_5" style="background:#FFCCCC;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#940000;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#FFBA26;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#C7003D;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#551A8B;" onClick="getColor(this)">ffefe
										Acid
									</div>
									<div class="col span_1_of_5" style="background:#333333;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#FF33E6;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#33FF99;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#9900E6;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#8C73A6;" onClick="getColor(this)">
										Acid
									</div>
									<div class="col span_1_of_5" style="background:#BFA680;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#FFFF4C;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#98FB98;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#CD1076;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#001700;" onClick="getColor(this)">
										Acid
									</div>
									<div class="col span_1_of_5" style="background:#B24C4C;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#001784;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#EEDFCC;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#EDBFA6;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#8B8970;" onClick="getColor(this)">
										Acid
									</div>
									<div class="col span_1_of_5" style="background:#8B5F65;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#2D000E;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#483D8B;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#3333E6;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#9AC0CD;" onClick="getColor(this)">
										Acid
									</div>
									<div class="col span_1_of_5" style="background:#CD2626;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#3399FF;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#FFCC4C;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#8B6508;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#8e8e38;" onClick="getColor(this)">
										Acid
									</div>
									<div class="col span_1_of_5" style="background:#00801a;" onClick="getColor(this)">
										Acid
									</div>
									<div class="col span_1_of_5" style="background:#7a378b;" onClick="getColor(this)">
										Acid
									</div>
									<div class="col span_1_of_5" style="background:#E6FFFF;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#7069FF;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#808080;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#FFFFFF;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#CCCCCC;" onClick="getColor(this)">
										Acid
									</div>
									<div class="col span_1_of_5" style="background:#4CFFFF;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#104e8b;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#FF0D8F;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#99E6FF;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#630000;" onClick="getColor(this)">
										Acid
									</div>
									<div class="col span_1_of_5" style="background:#FFFF80;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#FFFF00;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#8B7355;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#FF0000;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#4c00c4;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#80B28C;" onClick="getColor(this)">
										Acid
									</div>
									<div class="col span_1_of_5" style="background:#4CFF4C;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#A6FFFF;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#8B3A62;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#FF0000;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#FF00FF;" onClick="getColor(this)">
										Acid
									</div>
									<div class="col span_1_of_5" style="background:#29A19C;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#000000;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#0000FF;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#2F4F4F;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#8968cd;" onClick="getColor(this)">
										1 of 5
									</div>
									<div class="col span_1_of_5" style="background:#ff3300;" onClick="getColor(this)">
										Acid
									</div>
								</div>
								<div class="force-overflow"></div>
							</div>
							<input type ="submit" name = "submit" value ="Upload" class="enviar" id="upload"  onclick="canvasCapture();"/>
							<input id="imgurl" name="imgurl" type="hidden">
							<br>
							<input id="jointcolor" name="jointcolor" type="hidden">
							<input id="bodycolor" name="bodycolor" type="hidden">
						</form>
					</div>
				</div>
				<script>
					// Get the modal
					var modal = document.getElementById('myModal');
					
					// Get the button that opens the modal
					var btn = document.getElementById("myBtn");
					
					// Get the <span> element that closes the modal
					var span = document.getElementsByClassName("close")[0];
					
					// When the user clicks the button, open the modal 
					btn.onclick = function() {
						modal.style.display = "block";
					}
					
					// When the user clicks on <span> (x), close the modal
					span.onclick = function() {
						modal.style.display = "none";
					}
					
					// When the user clicks anywhere outside of the modal, close it
					window.onclick = function(event) {
						if (event.target == modal) {
							modal.style.display = "none";
						}
					}
					
					var jointselectedcolor;
					var bodyselectedcolor;
					var selectedcolor;
					$(".col").on("click", function() {
						var colorselect = document.getElementById("colorselect");
						var selectedpart = colorselect.options[colorselect.selectedIndex].value;
						if(selectedpart == "jointselect"){
							jointselectedcolor = $(this).css("background-color");
							var jointselectedhex =  colorstring(jointselectedcolor);
							document.getElementById('jointcolor').value = jointselectedhex;
							selectedcolor =jointselectedhex;
						}
						if(selectedpart == "bodyselect"){
							bodyselectedcolor = $(this).css("background-color");
							var   bodyselectedhex =  colorstring(  bodyselectedcolor);
							document.getElementById('bodycolor').value =  bodyselectedhex;
							selectedcolor = bodyselectedhex;
						}
						if(selectedcolor == '#b2ff1a'){
							document.getElementById("colorname").innerHTML= "Acid";
						}
						if(selectedcolor == '#2e94ba'){
							document.getElementById("colorname").innerHTML= "Adamantium";
						}
						if(selectedcolor == '#191970'){
							document.getElementById("colorname").innerHTML= "Alpha Imperial";
						}
						if(selectedcolor == '#ff7517'){
							document.getElementById("colorname").innerHTML= "Amber";
						}
						if(selectedcolor == '#ff33f2'){
							document.getElementById("colorname").innerHTML= "Amethyst";
						}
						if(selectedcolor == '#0080ff'){
							document.getElementById("colorname").innerHTML= "Aqua";
						}
						if(selectedcolor == '#f5e3f7'){
							document.getElementById("colorname").innerHTML= "Aurora";
						}
						if(selectedcolor == '#1f364c'){
							document.getElementById("colorname").innerHTML= "Azurite";
						}
						if(selectedcolor == '#7f3a00'){
							document.getElementById("colorname").innerHTML= "Beetle";
						}
						if(selectedcolor == '#fc95f'){
							document.getElementById("colorname").innerHTML= "Blossom";
						}
						if(selectedcolor == '#cc6633'){
							document.getElementById("colorname").innerHTML= "Bronze";
						}
						if(selectedcolor == '#556b2f'){
							document.getElementById("colorname").innerHTML= "Camo";
						}
						if(selectedcolor == '#ffcccc'){
							document.getElementById("colorname").innerHTML= "Chronos";
						}
						if(selectedcolor == '#940000'){
							document.getElementById("colorname").innerHTML= "Cobra";
						}
						if(selectedcolor == '#ffba26'){
							document.getElementById("colorname").innerHTML= "Copper";
						}
						if(selectedcolor == '#c7003d'){
							document.getElementById("colorname").innerHTML= "Crimson";
						}
						if(selectedcolor == '#551a8b'){
							document.getElementById("colorname").innerHTML= "Demolition";
						}
						if(selectedcolor == '#333333'){
							document.getElementById("colorname").innerHTML= "Demon";
						}
						if(selectedcolor == '#ff33e6'){
							document.getElementById("colorname").innerHTML= "Dragon";
						}
						if(selectedcolor == '#33ff99'){
							document.getElementById("colorname").innerHTML= "Ecto";
						}
						if(selectedcolor == '#9900e6'){
							document.getElementById("colorname").innerHTML= "Elf";
						}
						if(selectedcolor == '#8c73a6'){
							document.getElementById("colorname").innerHTML= "Gaia";
						}
						if(selectedcolor == '#bfa680'){
							document.getElementById("colorname").innerHTML= "Gladiator";
						} 
						if(selectedcolor == '#ffff4c'){
							document.getElementById("colorname").innerHTML= "Gold";
						} 
						if(selectedcolor == '#4f6378'){
							document.getElementById("colorname").innerHTML= "Hawk";
						}
						if(selectedcolor == '#98fb98'){
							document.getElementById("colorname").innerHTML= "Helios";
						} 
						if(selectedcolor == '#cd1076'){
							document.getElementById("colorname").innerHTML= "Hot Pink";
						}  
						if(selectedcolor == '#001700'){
							document.getElementById("colorname").innerHTML= "Hunter	";
						} 
						if(selectedcolor == '#b24c4c'){
							document.getElementById("colorname").innerHTML= "Hydra";
						} 
						if(selectedcolor == '#001784'){
							document.getElementById("colorname").innerHTML= "Imperial";
						} 
						if(selectedcolor == '#eedfcc'){
							document.getElementById("colorname").innerHTML= "Ivory";
						}  
						if(selectedcolor == '#edbfa6'){
							document.getElementById("colorname").innerHTML= "Juryo";
						} 
						if(selectedcolor == '#8b8970'){
							document.getElementById("colorname").innerHTML= "Kevlar";
						} 
						if(selectedcolor == '#8b5f65'){
							document.getElementById("colorname").innerHTML= "Knox";
						}  
						if(selectedcolor == '#2d000e'){
							document.getElementById("colorname").innerHTML= "Magma";
						} 
						if(selectedcolor == '#483d8b'){
							document.getElementById("colorname").innerHTML= "Magnetite";
						}  
						if(selectedcolor == '#3333e6'){
							document.getElementById("colorname").innerHTML= "Marine";
						}  
						if(selectedcolor == '#9ac0cd'){
							document.getElementById("colorname").innerHTML= "Maya";
						} 
						if(selectedcolor == '#cd2626'){
							document.getElementById("colorname").innerHTML= "Mysterio";
						} 
						if(selectedcolor == '#3399ff'){
							document.getElementById("colorname").innerHTML= "Neptune";
						}
						if(selectedcolor == '#ffcc4c'){
							document.getElementById("colorname").innerHTML= "Noxious";
						}
						if(selectedcolor == '#8b6508'){
							document.getElementById("colorname").innerHTML= "OldGold";
						}
						if(selectedcolor == '#8e8e38'){
							document.getElementById("colorname").innerHTML= "Olive";
						}
						if(selectedcolor == '#00801a'){
							document.getElementById("colorname").innerHTML= "Orc";
						}
						if(selectedcolor == '#7a378b'){
							document.getElementById("colorname").innerHTML= "Persia";
						}
						if(selectedcolor == '#e6ffff'){
							document.getElementById("colorname").innerHTML= "Pharos";
						}
						if(selectedcolor == '#7069ff'){
							document.getElementById("colorname").innerHTML= "Plasma";
						}
						if(selectedcolor == '#808080'){
							document.getElementById("colorname").innerHTML= "Platinum";
						}
						if(selectedcolor == '#ffffff'){
							document.getElementById("colorname").innerHTML= "Pure";
						}
						if(selectedcolor == '#cccccc'){
							document.getElementById("colorname").innerHTML= "Quicksilver";
						}
						if(selectedcolor == '#4cffff'){
							document.getElementById("colorname").innerHTML= "Radioactive";
						}
						if(selectedcolor == '#104e8b'){
							document.getElementById("colorname").innerHTML= "Raider";
						}
						if(selectedcolor == '#99e6ff'){
							document.getElementById("colorname").innerHTML= "Sapphire";
						}
						if(selectedcolor == '#630000'){
							document.getElementById("colorname").innerHTML= "Shaman";
						}
						if(selectedcolor == '#ffff80'){
							document.getElementById("colorname").innerHTML= "Sphinx";
						}
						if(selectedcolor == '#ffff00'){
							document.getElementById("colorname").innerHTML= "Static";
						}
						if(selectedcolor == '#8b7355'){
							document.getElementById("colorname").innerHTML= "Superfly";
						}
						if(selectedcolor == '#ff0000'){
							document.getElementById("colorname").innerHTML= "Supernova";
						}
						if(selectedcolor == '#4c00c4'){
							document.getElementById("colorname").innerHTML= "Tesla";
						}
						if(selectedcolor == '#80b28c'){
							document.getElementById("colorname").innerHTML= "Titan";
						}
						if(selectedcolor == '#4cff4c'){
							document.getElementById("colorname").innerHTML= "Toxic";
						}
						if(selectedcolor == '#a6ffff'){
							document.getElementById("colorname").innerHTML= "Typhon";
						}
						if(selectedcolor == '#8b3a62'){
							document.getElementById("colorname").innerHTML= "Tyrian";
						}
						if(selectedcolor == '#ff0000'){
							document.getElementById("colorname").innerHTML= "Vampire";
						}
						if(selectedcolor == '#ff00ff'){
							document.getElementById("colorname").innerHTML= "Velvet";
						}
						if(selectedcolor == '#29a19c'){
							document.getElementById("colorname").innerHTML= "Viridian";
						}
						if(selectedcolor == '#000000'){
							document.getElementById("colorname").innerHTML= "Void";
						}
						if(selectedcolor == '#0000ff'){
							document.getElementById("colorname").innerHTML= "Vortex";
						}
						if(selectedcolor == '#2f4f4f'){
							document.getElementById("colorname").innerHTML= "Vulcan";
						}
						if(selectedcolor == '#8968cd'){
							document.getElementById("colorname").innerHTML= "Warrior";
						}
						if(selectedcolor == '#ff3300'){
							document.getElementById("colorname").innerHTML= "Wildfire";
						}
						updatecolor(jointselectedhex,bodyselectedhex)
						
					});
					
					document.forms[0].addEventListener('submit', function( evt ) {
						
						var file = document.getElementById('file').files[0];
						
						var title = document.getElementById('title').value;
						if(file && file.size > 2097152) { // 2 MB (this size is in bytes)
							alert("Image filesize too big.");
							evt.preventDefault();
						}
						if ($('[inputimage]').val() == "") {
							console.log("No files selected.");
						}
						if(title.length==0){
							alert("Please title your texture.");
							evt.preventDefault();
						}
					}, false);
					
					
					function componentToHex(c) {
						var hex = c.toString(16);
						return hex.length == 1 ? "0" + hex : hex;
					}
					
					function rgbToHex(r, g, b) {
						return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
					}
					
					function colorstring(color){
						var colorString = color,
						colorsOnly = colorString.substring(colorString.indexOf('(') + 1, colorString.lastIndexOf(')')).split(/,\s*/),
						red = colorsOnly[0],
						green = colorsOnly[1],
						blue = colorsOnly[2];
						
						var r = parseInt(red)		
						var g  = parseInt(green)		
						var b  = parseInt(blue)
						
						return ( rgbToHex(r,g,b) ); 
					}
					
					function canvasCapture(){
						var dataURL = document.body.lastChild.firstElementChild.toDataURL();
						document.getElementById('imgurl').value = dataURL;
					}
				</script>
				
				<?php
					$type = '';
					$size = '';
					$error = '';
					function compress_image($source_url, $destination_url, $quality) {
						$info = getimagesize($source_url);
						if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
						elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
						elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
						imagejpeg($image, $destination_url, $quality);
						return $destination_url;
					}
					
					if ($_POST) {
						} else {
						$error = "Uploaded image should be jpg or gif or png";
					}
					
					function posttexture() {
						$artist = $_SESSION['Username'];
						$title = $_POST['title'];
						$textureArtist = $_POST['artist'];
						$image = $_POST['imgurl'];
						$user_id = $_SESSION['user_id'];
						$jointcolor = $_POST['jointcolor'];
						$bodycolor = $_POST['bodycolor'];
						// Body
						$headtexture = $_FILES['inputimage']['name'];
						if (pathinfo($headtexture, PATHINFO_EXTENSION) == "tga") {
							$headtexture = "tga";
							} else {
							$headtexture = "jpg";
						}
						$breasttexture = $_FILES['breast']['name'];
						if (pathinfo($breasttexture, PATHINFO_EXTENSION) == "tga") {
							$breasttexture = "tga";
							} else {
							$breasttexture = "jpg";
						}
						$chesttexture = $_FILES['chest']['name'];
						if (pathinfo($chesttexture, PATHINFO_EXTENSION) == "tga") {
							$chesttexture = "tga";
							} else {
							$chesttexture = "jpg";
						}
						$stomachtexture = $_FILES['stomach']['name'];
						if (pathinfo($stomachtexture, PATHINFO_EXTENSION) == "tga") {
							$stomachtexture = "tga";
							} else {
							$stomachtexture = "jpg";
						}
						$grointexture = $_FILES['groin']['name'];
						if (pathinfo($grointexture, PATHINFO_EXTENSION) == "tga") {
							$grointexture = "tga";
							} else {
							$grointexture = "jpg";
						}
						$r_pecstexture = $_FILES['r_pecs']['name'];
						if (pathinfo($r_pecstexture, PATHINFO_EXTENSION) == "tga") {
							$r_pecstexture = "tga";
							} else {
							$r_pecstexture = "jpg";
						}
						$r_bicepstexture = $_FILES['r_biceps']['name'];
						if (pathinfo($r_bicepstexture, PATHINFO_EXTENSION) == "tga") {
							$r_bicepstexture = "tga";
							} else {
							$r_bicepstexture = "jpg";
						}
						$r_tricepstexture = $_FILES['r_triceps']['name'];
						if (pathinfo($r_tricepstexture, PATHINFO_EXTENSION) == "tga") {
							$r_tricepstexture = "tga";
							} else {
							$r_tricepstexture = "jpg";
						}
						$l_pecstexture = $_FILES['l_pecs']['name'];
						if (pathinfo($l_pecstexture, PATHINFO_EXTENSION) == "tga") {
							$l_pecstexture = "tga";
							} else {
							$l_pecstexture = "jpg";
						}
						$l_bicepstexture = $_FILES['l_biceps']['name'];
						if (pathinfo($l_bicepstexture, PATHINFO_EXTENSION) == "tga") {
							$l_bicepstexture = "tga";
							} else {
							$l_bicepstexture = "jpg";
						}
						$l_tricepstexture = $_FILES['l_triceps']['name'];
						if (pathinfo($l_tricepstexture, PATHINFO_EXTENSION) == "tga") {
							$l_tricepstexture = "tga";
							} else {
							$l_tricepstexture = "jpg";
						}
						$r_handtexture = $_FILES['r_hand']['name'];
						if (pathinfo($r_handtexture, PATHINFO_EXTENSION) == "tga") {
							$r_handtexture = "tga";
							} else {
							$r_handtexture = "jpg";
						}
						// Joints
						$r_shouldertexture = $_FILES['r_shoulder']['name'];
						if (pathinfo($r_shouldertexture, PATHINFO_EXTENSION) == "tga") {
							$r_shouldertexture = "tga";
							} else {
							$r_shouldertexture = "jpg";
						}
						$l_handtexture = $_FILES['l_hand']['name'];
						if (pathinfo($l_handtexture, PATHINFO_EXTENSION) == "tga") {
							$l_handtexture = "tga";
							} else {
							$l_handtexture = "jpg";
						}
						$r_thightexture = $_FILES['r_thigh']['name'];
						if (pathinfo($r_thightexture, PATHINFO_EXTENSION) == "tga") {
							$r_thightexture = "tga";
							} else {
							$r_thightexture = "jpg";
						}
						$l_thightexture = $_FILES['l_thigh']['name'];
						if (pathinfo($l_thightexture, PATHINFO_EXTENSION) == "tga") {
							$l_thightexture = "tga";
							} else {
							$l_thightexture = "jpg";
						}
						$l_legtexture = $_FILES['l_leg']['name'];
						if (pathinfo($l_legtexture, PATHINFO_EXTENSION) == "tga") {
							$l_legtexture = "tga";
							} else {
							$l_legtexture = "jpg";
						}
						$r_legtexture = $_FILES['r_leg']['name'];
						if (pathinfo($r_legtexture, PATHINFO_EXTENSION) == "tga") {
							$r_legtexture = "tga";
							} else {
							$r_legtexture = "jpg";
						}
						$l_foottexture = $_FILES['l_foot']['name'];
						if (pathinfo($l_foottexture, PATHINFO_EXTENSION) == "tga") {
							$l_foottexture = "tga";
							} else {
							$l_foottexture = "jpg";
						}
						$r_foottexture = $_FILES['r_foot']['name'];
						if (pathinfo($r_foottexture, PATHINFO_EXTENSION) == "tga") {
							$r_foottexture = "tga";
							} else {
							$r_foottexture = "jpg";
						}
						$l_kneetexture = $_FILES['l_knee']['name'];
						if (pathinfo($l_kneetexture, PATHINFO_EXTENSION) == "tga") {
							$l_kneetexture = "tga";
							} else {
							$l_kneetexture = "jpg";
						}
						$l_glutetexture = $_FILES['l_glute']['name'];
						if (pathinfo($l_glutetexture, PATHINFO_EXTENSION) == "tga") {
							$l_glutetexture = "tga";
							} else {
							$l_glutetexture = "jpg";
						}
						$l_hiptexture = $_FILES['l_hip']['name'];
						if (pathinfo($l_hiptexture, PATHINFO_EXTENSION) == "tga") {
							$l_hiptexture = "tga";
							} else {
							$l_hiptexture = "jpg";
						}
						$r_hiptexture = $_FILES['r_hip']['name'];
						if (pathinfo($r_hiptexture, PATHINFO_EXTENSION) == "tga") {
							$r_hiptexture = "tga";
							} else {
							$r_hiptexture = "jpg";
						}
						$r_kneetexture = $_FILES['r_knee']['name'];
						if (pathinfo($r_kneetexture, PATHINFO_EXTENSION) == "tga") {
							$r_kneetexture = "tga";
							} else {
							$r_kneetexture = "jpg";
						}
						$r_glutetexture = $_FILES['r_glute']['name'];
						if (pathinfo($r_glutetexture, PATHINFO_EXTENSION) == "tga") {
							$r_glutetexture = "tga";
							} else {
							$r_glutetexture = "jpg";
						}
						$l_ankletexture = $_FILES['l_ankle']['name'];
						if (pathinfo($l_ankletexture, PATHINFO_EXTENSION) == "tga") {
							$l_ankletexture = "tga";
							} else {
							$l_ankletexture = "jpg";
						}
						$r_ankletexture = $_FILES['r_ankle']['name'];
						if (pathinfo($r_ankletexture, PATHINFO_EXTENSION) == "tga") {
							$r_ankletexture = "tga";
							} else {
							$r_ankletexture = "jpg";
						}
						$l_wristtexture = $_FILES['l_wrist']['name'];
						if (pathinfo($l_wristtexture, PATHINFO_EXTENSION) == "tga") {
							$l_wristtexture = "tga";
							} else {
							$l_wristtexture = "jpg";
						}
						$r_wristtexture = $_FILES['r_wrist']['name'];
						if (pathinfo($r_wristtexture, PATHINFO_EXTENSION) == "tga") {
							$r_wristtexture = "tga";
							} else {
							$r_wristtexture = "jpg";
						}
						$l_elbowtexture = $_FILES['l_elbow']['name'];
						if (pathinfo($l_elbowtexture, PATHINFO_EXTENSION) == "tga") {
							$l_elbowtexture = "tga";
							} else {
							$l_elbowtexture = "jpg";
						}
						$l_shouldertexture = $_FILES['l_shoulder']['name'];
						if (pathinfo($l_shouldertexture, PATHINFO_EXTENSION) == "tga") {
							$l_shouldertexture = "tga";
							} else {
							$l_shouldertexture = "jpg";
						}
						$l_pectexture = $_FILES['l_pec']['name'];
						if (pathinfo($l_pectexture, PATHINFO_EXTENSION) == "tga") {
							$l_pectexture = "tga";
							} else {
							$l_pectexture = "jpg";
						}
						$r_elbowtexture = $_FILES['r_elbow']['name'];
						if (pathinfo($r_elbowtexture, PATHINFO_EXTENSION) == "tga") {
							$r_elbowtexture = "tga";
							} else {
							$r_elbowtexture = "jpg";
						}
						$r_shouldertexture = $_FILES['r_shoulder']['name'];
						if (pathinfo($r_shouldertexture, PATHINFO_EXTENSION) == "tga") {
							$r_shouldertexture = "tga";
							} else {
							$r_shouldertexture = "jpg";
						}
						$r_pectexture = $_FILES['r_pec']['name'];
						if (pathinfo($r_pectexture, PATHINFO_EXTENSION) == "tga") {
							$r_pectexture = "tga";
							} else {
							$r_pectexture = "jpg";
						}
						$abstexture = $_FILES['abs']['name'];
						if (pathinfo($abstexture, PATHINFO_EXTENSION) == "tga") {
							$abstexture = "tga";
							} else {
							$abstexture = "jpg";
						}
						$lumbartexture = $_FILES['lumbar']['name'];
						if (pathinfo($lumbartexture, PATHINFO_EXTENSION) == "tga") {
							$lumbartexture = "tga";
							} else {
							$lumbartexture = "jpg";
						}
						$chestjointtexture = $_FILES['chestJoint']['name'];
						if (pathinfo($chestjointtexture, PATHINFO_EXTENSION) == "tga") {
							$chestjointtexture = "tga";
							} else {
							$chestjointtexture = "jpg";
						}
						$necktexture = $_FILES['neck']['name'];
						if (pathinfo($necktexture, PATHINFO_EXTENSION) == "tga") {
							$necktexture = "tga";
							} else {
							$necktexture = "jpg";
						}
						move_uploaded_file($head_tmp, $filepath);
						saveimage($user_id, $image, $artist, $title, $textureArtist, $jointcolor, $bodycolor, $headtexture, $breasttexture, $chesttexture, $stomachtexture, $grointexture, $r_pecstexture, $r_bicepstexture, $r_tricepstexture, $l_pecstexture, $l_bicepstexture, $l_tricepstexture, $r_handtexture, $l_handtexture, $r_thightexture, $l_thightexture, $l_legtexture, $r_legtexture, $l_foottexture, $r_foottexture, $l_kneetexture, $l_glutetexture, $l_hiptexture, $r_hiptexture, $r_kneetexture, $r_glutetexture, $l_ankletexture, $r_ankletexture, $l_wristtexture, $r_wristtexture, $l_elbowtexture, $l_shouldertexture, $l_pectexture, $r_elbowtexture, $r_shouldertexture, $r_pectexture, $abstexture, $lumbartexture, $chestjointtexture, $necktexture);
					}
					function saveimage($user_id, $image, $artist, $title, $textureArtist, $jointcolor, $bodycolor, $headtexture, $breasttexture, $chesttexture, $stomachtexture, $grointexture, $r_pecstexture, $r_bicepstexture, $r_tricepstexture, $l_pecstexture, $l_bicepstexture, $l_tricepstexture, $r_handtexture, $l_handtexture, $r_thightexture, $l_thightexture, $l_legtexture, $r_legtexture, $l_foottexture, $r_foottexture, $l_kneetexture, $l_glutetexture, $l_hiptexture, $r_hiptexture, $r_kneetexture, $r_glutetexture, $l_ankletexture, $r_ankletexture, $l_wristtexture, $r_wristtexture, $l_elbowtexture, $l_shouldertexture, $l_pectexture, $r_elbowtexture, $r_shouldertexture, $r_pectexture, $abstexture, $lumbartexture, $chestjointtexture, $necktexture) {
						$con = new PDO("mysql:host=toribashtexturescom.ipagemysql.com;dbname=tbshowcase", 'hagan', 'abc1234');
						$status = $con->getAttribute(PDO::ATTR_CONNECTION_STATUS);
						if ($con->getAttribute(PDO::ATTR_SERVER_INFO) == 'MySQL server has gone away') {
							die("Can't connect to the database: " . mysqli_error($con));
						}
						$qry = "insert into images (user_id, image,artist, title,textureArtist, jointcolor,bodycolor, headtexture, UploadDate,UploadTime,breasttexture,chesttexture,stomachtexture,
						grointexture,r_pecstexture,r_bicepstexture,r_tricepstexture,l_pecstexture, l_bicepstexture,l_tricepstexture,r_handtexture,l_handtexture,r_thightexture,l_thightexture,
						l_legtexture,r_legtexture,l_foottexture,r_foottexture,l_kneetexture,l_glutetexture,l_hiptexture,r_hiptexture,r_kneetexture,r_glutetexture,l_ankletexture,r_ankletexture,
						l_wristtexture,r_wristtexture,l_elbowtexture,l_shouldertexture,l_pectexture,r_elbowtexture,r_shouldertexture,r_pectexture,abstexture,lumbartexture,chestjointtexture,necktexture)
						
						values (:user_id,:image,:artist, :title,:textureArtist,:jointcolor,:bodycolor,:headtexture,CURDATE(),CURTIME(),:breasttexture,:chesttexture,:stomachtexture,
						:grointexture,:r_pecstexture,:r_bicepstexture,:r_tricepstexture,:l_pecstexture,:l_bicepstexture,:l_tricepstexture,:r_handtexture,:l_handtexture,:r_thightexture,:l_thightexture,
						:l_legtexture,:r_legtexture,:l_foottexture,:r_foottexture,:l_kneetexture,:l_glutetexture,:l_hiptexture,:r_hiptexture,:r_kneetexture,:r_glutetexture,:l_ankletexture,:r_ankletexture,
						:l_wristtexture,:r_wristtexture,:l_elbowtexture,:l_shouldertexture,:l_pectexture,:r_elbowtexture,:r_shouldertexture,:r_pectexture,:abstexture,:lumbartexture,:chestjointtexture,:necktexture)";
						$qry = $con->prepare($qry);
						$qry->bindValue(':user_id', $user_id);
						$qry->bindValue(':image', $image);
						$qry->bindValue(':artist', $artist);
						$qry->bindValue(':title', $title);
						$qry->bindValue(':textureArtist', $textureArtist);
						$qry->bindValue(':jointcolor', $jointcolor);
						$qry->bindValue(':bodycolor', $bodycolor);
						$qry->bindValue(':headtexture', $headtexture);
						$qry->bindValue(':breasttexture', $breasttexture);
						$qry->bindValue(':chesttexture', $chesttexture);
						$qry->bindValue(':stomachtexture', $stomachtexture);
						$qry->bindValue(':grointexture', $grointexture);
						$qry->bindValue(':r_pecstexture', $r_pecstexture);
						$qry->bindValue(':r_bicepstexture', $r_bicepstexture);
						$qry->bindValue(':r_tricepstexture', $r_tricepstexture);
						$qry->bindValue(':l_pecstexture', $l_pecstexture);
						$qry->bindValue(':l_bicepstexture', $l_bicepstexture);
						$qry->bindValue(':l_tricepstexture', $l_tricepstexture);
						$qry->bindValue(':r_handtexture', $r_handtexture);
						$qry->bindValue(':l_handtexture', $l_handtexture);
						$qry->bindValue(':r_thightexture', $r_thightexture);
						$qry->bindValue(':l_thightexture', $l_thightexture);
						$qry->bindValue(':l_legtexture', $l_legtexture);
						$qry->bindValue(':r_legtexture', $r_legtexture);
						$qry->bindValue(':l_foottexture', $l_foottexture);
						$qry->bindValue(':r_foottexture', $r_foottexture);
						$qry->bindValue(':l_kneetexture', $l_kneetexture);
						$qry->bindValue(':l_glutetexture', $l_glutetexture);
						$qry->bindValue(':l_hiptexture', $l_hiptexture);
						$qry->bindValue(':r_hiptexture', $r_hiptexture);
						$qry->bindValue(':r_kneetexture', $r_kneetexture);
						$qry->bindValue(':r_glutetexture', $r_glutetexture);
						$qry->bindValue(':l_ankletexture', $l_ankletexture);
						$qry->bindValue(':r_ankletexture', $r_ankletexture);
						$qry->bindValue(':l_wristtexture', $l_wristtexture);
						$qry->bindValue(':r_wristtexture', $r_wristtexture);
						$qry->bindValue(':l_elbowtexture', $l_elbowtexture);
						$qry->bindValue(':l_shouldertexture', $l_shouldertexture);
						$qry->bindValue(':l_pectexture', $l_pectexture);
						$qry->bindValue(':r_elbowtexture', $r_elbowtexture);
						$qry->bindValue(':r_shouldertexture', $r_shouldertexture);
						$qry->bindValue(':r_pectexture', $r_pectexture);
						$qry->bindValue(':abstexture', $abstexture);
						$qry->bindValue(':lumbartexture', $lumbartexture);
						$qry->bindValue(':chestjointtexture', $chestjointtexture);
						$qry->bindValue(':necktexture', $necktexture);
						$qry->execute();
						$lastid = $con->lastInsertId();
						$userid = $_SESSION['user_id'];
						if (!file_exists('uploads/' . $userid)) {
							mkdir('uploads/' . $userid, 0777, true);
						}
						if (!file_exists('uploads/' . $userid . '/' . $lastid)) {
							mkdir('uploads/' . $userid . '/' . $lastid, 0777, true);
						}
						$target_path = 'uploads/' . $userid . '/' . $lastid . "/";
						//Body
						if (pathinfo($_FILES['inputimage']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['inputimage']['tmp_name'], $target_path . "head.tga");
							} else {
							move_uploaded_file($_FILES['inputimage']['tmp_name'], $target_path . "head.jpg");
						}
						if (pathinfo($_FILES['groin']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['groin']['tmp_name'], $target_path . "groin.tga");
							} else {
							move_uploaded_file($_FILES['groin']['tmp_name'], $target_path . "groin.jpg");
						}
						if (pathinfo($_FILES['r_thigh']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['r_thigh']['tmp_name'], $target_path . "r_thigh.tga");
							} else {
							move_uploaded_file($_FILES['r_thigh']['tmp_name'], $target_path . "r_thigh.jpg");
						}
						if (pathinfo($_FILES['r_leg']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['r_leg']['tmp_name'], $target_path . "r_leg.tga");
							} else {
							move_uploaded_file($_FILES['r_leg']['tmp_name'], $target_path . "r_leg.jpg");
						}
						if (pathinfo($_FILES['r_foot']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['r_foot']['tmp_name'], $target_path . "r_foot.tga");
							} else {
							move_uploaded_file($_FILES['r_foot']['tmp_name'], $target_path . "r_foot.jpg");
						}
						if (pathinfo($_FILES['l_foot']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['l_foot']['tmp_name'], $target_path . "l_foot.tga");
							} else {
							move_uploaded_file($_FILES['l_foot']['tmp_name'], $target_path . "l_foot.jpg");
						}
						if (pathinfo($_FILES['l_leg']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['l_leg']['tmp_name'], $target_path . "l_leg.tga");
							} else {
							move_uploaded_file($_FILES['l_leg']['tmp_name'], $target_path . "l_leg.jpg");
						}
						if (pathinfo($_FILES['l_thigh']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['l_thigh']['tmp_name'], $target_path . "l_thigh.tga");
							} else {
							move_uploaded_file($_FILES['l_thigh']['tmp_name'], $target_path . "l_thigh.jpg");
						}
						if (pathinfo($_FILES['r_hand']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['r_hand']['tmp_name'], $target_path . "r_hand.tga");
							} else {
							move_uploaded_file($_FILES['r_hand']['tmp_name'], $target_path . "r_hand.jpg");
						}
						if (pathinfo($_FILES['r_triceps']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['r_triceps']['tmp_name'], $target_path . "r_triceps.tga");
							} else {
							move_uploaded_file($_FILES['r_triceps']['tmp_name'], $target_path . "r_triceps.jpg");
						}
						if (pathinfo($_FILES['r_biceps']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['r_biceps']['tmp_name'], $target_path . "r_biceps.tga");
							} else {
							move_uploaded_file($_FILES['r_biceps']['tmp_name'], $target_path . "r_biceps.jpg");
						}
						if (pathinfo($_FILES['stomach']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['stomach']['tmp_name'], $target_path . "stomach.tga");
							} else {
							move_uploaded_file($_FILES['stomach']['tmp_name'], $target_path . "stomach.jpg");
						}
						if (pathinfo($_FILES['chest']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['chest']['tmp_name'], $target_path . "chest.tga");
							} else {
							move_uploaded_file($_FILES['chest']['tmp_name'], $target_path . "chest.jpg");
						}
						if (pathinfo($_FILES['breast']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['breast']['tmp_name'], $target_path . "breast.tga");
							} else {
							move_uploaded_file($_FILES['breast']['tmp_name'], $target_path . "breast.jpg");
						}
						if (pathinfo($_FILES['r_pecs']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['r_pecs']['tmp_name'], $target_path . "r_pecs.tga");
							} else {
							move_uploaded_file($_FILES['r_pecs']['tmp_name'], $target_path . "r_pecs.jpg");
						}
						if (pathinfo($_FILES['l_hand']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['l_hand']['tmp_name'], $target_path . "l_hand.tga");
							} else {
							move_uploaded_file($_FILES['l_hand']['tmp_name'], $target_path . "l_hand.jpg");
						}
						if (pathinfo($_FILES['l_triceps']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['l_triceps']['tmp_name'], $target_path . "l_triceps.tga");
							} else {
							move_uploaded_file($_FILES['l_triceps']['tmp_name'], $target_path . "l_triceps.jpg");
						}
						if (pathinfo($_FILES['l_biceps']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['l_biceps']['tmp_name'], $target_path . "l_biceps.tga");
							} else {
							move_uploaded_file($_FILES['l_biceps']['tmp_name'], $target_path . "l_biceps.jpg");
						}
						if (pathinfo($_FILES['l_pecs']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['l_pecs']['tmp_name'], $target_path . "l_pecs.tga");
							} else {
							move_uploaded_file($_FILES['l_pecs']['tmp_name'], $target_path . "l_pecs.jpg");
						}
						//Joints
						if (pathinfo($_FILES['l_knee']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['l_knee']['tmp_name'], $target_path . "l_knee.tga");
							} else {
							move_uploaded_file($_FILES['l_knee']['tmp_name'], $target_path . "l_knee.jpg");
						}
						if (pathinfo($_FILES['l_glute']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['l_glute']['tmp_name'], $target_path . "l_glute.tga");
							} else {
							move_uploaded_file($_FILES['l_glute']['tmp_name'], $target_path . "l_glute.jpg");
						}
						if (pathinfo($_FILES['l_hip']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['l_hip']['tmp_name'], $target_path . "l_hip.tga");
							} else {
							move_uploaded_file($_FILES['l_hip']['tmp_name'], $target_path . "l_hip.jpg");
						}
						if (pathinfo($_FILES['r_hip']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['r_hip']['tmp_name'], $target_path . "r_hip.tga");
							} else {
							move_uploaded_file($_FILES['r_hip']['tmp_name'], $target_path . "r_hip.jpg");
						}
						if (pathinfo($_FILES['r_knee']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['r_knee']['tmp_name'], $target_path . "r_knee.tga");
							} else {
							move_uploaded_file($_FILES['r_knee']['tmp_name'], $target_path . "r_knee.jpg");
						}
						if (pathinfo($_FILES['r_glute']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['r_glute']['tmp_name'], $target_path . "r_glute.tga");
							} else {
							move_uploaded_file($_FILES['r_glute']['tmp_name'], $target_path . "r_glute.jpg");
						}
						if (pathinfo($_FILES['l_ankle']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['l_ankle']['tmp_name'], $target_path . "l_ankle.tga");
							} else {
							move_uploaded_file($_FILES['l_ankle']['tmp_name'], $target_path . "l_ankle.jpg");
						}
						if (pathinfo($_FILES['r_ankle']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['r_ankle']['tmp_name'], $target_path . "r_ankle.tga");
							} else {
							move_uploaded_file($_FILES['r_ankle']['tmp_name'], $target_path . "r_ankle.jpg");
						}
						if (pathinfo($_FILES['l_wrist']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['l_wrist']['tmp_name'], $target_path . "l_wrist.tga");
							} else {
							move_uploaded_file($_FILES['l_wrist']['tmp_name'], $target_path . "l_wrist.jpg");
						}
						if (pathinfo($_FILES['r_wrist']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['r_wrist']['tmp_name'], $target_path . "r_wrist.tga");
							} else {
							move_uploaded_file($_FILES['r_wrist']['tmp_name'], $target_path . "r_wrist.jpg");
						}
						if (pathinfo($_FILES['l_elbow']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['l_elbow']['tmp_name'], $target_path . "l_elbow.tga");
							} else {
							move_uploaded_file($_FILES['l_elbow']['tmp_name'], $target_path . "l_elbow.jpg");
						}
						if (pathinfo($_FILES['l_shoulder']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['l_shoulder']['tmp_name'], $target_path . "l_shoulder.tga");
							} else {
							move_uploaded_file($_FILES['l_shoulder']['tmp_name'], $target_path . "l_shoulder.jpg");
						}
						if (pathinfo($_FILES['l_pec']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['l_pec']['tmp_name'], $target_path . "l_pec.tga");
							} else {
							move_uploaded_file($_FILES['l_pec']['tmp_name'], $target_path . "l_pec.jpg");
						}
						if (pathinfo($_FILES['r_elbow']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['r_elbow']['tmp_name'], $target_path . "r_elbow.tga");
							} else {
							move_uploaded_file($_FILES['r_elbow']['tmp_name'], $target_path . "r_elbow.jpg");
						}
						if (pathinfo($_FILES['r_shoulder']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['r_shoulder']['tmp_name'], $target_path . "r_shoulder.tga");
							} else {
							move_uploaded_file($_FILES['r_shoulder']['tmp_name'], $target_path . "r_shoulder.jpg");
						}
						if (pathinfo($_FILES['r_pec']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['r_pec']['tmp_name'], $target_path . "r_pec.tga");
							} else {
							move_uploaded_file($_FILES['r_pec']['tmp_name'], $target_path . "r_pec.jpg");
						}
						if (pathinfo($_FILES['abs']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['abs']['tmp_name'], $target_path . "abs.tga");
							} else {
							move_uploaded_file($_FILES['abs']['tmp_name'], $target_path . "abs.jpg");
						}
						if (pathinfo($_FILES['lumbar']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['lumbar']['tmp_name'], $target_path . "lumbar.tga");
							} else {
							move_uploaded_file($_FILES['lumbar']['tmp_name'], $target_path . "lumbar.jpg");
						}
						if (pathinfo($_FILES['chestJoint']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['chestJoint']['tmp_name'], $target_path . "chestJoint.tga");
							} else {
							move_uploaded_file($_FILES['chestJoint']['tmp_name'], $target_path . "chestJoint.jpg");
						}
						if (pathinfo($_FILES['neck']['name'], PATHINFO_EXTENSION) == "tga") {
							move_uploaded_file($_FILES['neck']['tmp_name'], $target_path . "neck.tga");
							} else {
							move_uploaded_file($_FILES['neck']['tmp_name'], $target_path . "neck.jpg");
						}
						$Imagetemp = $image;
						list($type, $Imagetemp) = explode(';', $Imagetemp);
						list(, $Imagetemp) = explode(',', $Imagetemp);
						/** decode the base 64 image **/
						$Imagetemp = base64_decode($Imagetemp);
						/* move image to temp folder */
						$TempPath = $target_path . Time() . ".jpg";
						file_put_contents($TempPath, $Imagetemp);
						$ImageSize = filesize($TempPath); /* get the image size */
						if ($ImageSize < 83889000) { /* limit size to 10 mb */
							/** move the uploaded image **/
							$path = $target_path . "capture.jpg";
							file_put_contents($path, $Imagetemp);
							$Imagetemp = $path;
							/** get the image path and store in database **/
							unlink($TempPath); /* delete the temporay file */
							} else {
							unlink($TempPath); /* delete the temporay file */
							/** image size limit exceded **/
						}
						$imgSrc = $path;
						//Your Image
						//getting the image dimensions
						list($width, $height) = getimagesize($imgSrc);
						$dif = $width - $height;
						//saving the image into memory (for manipulation with GD Library)
						$myImage =  imagecreatefrompng($imgSrc);
						imageAlphaBlending($myImage, true);
						$thumbSize = 381;
						
						$ratio_original= $width/ $height;
						
						$ratio_thumb= $thumbSize /$thumbSize;
						if ($ratio_original>=$ratio_thumb) {
							$yo=$height /2;
							$xo=ceil(($yo*$thumbSize)/$thumbSize);
							$xo_ini=ceil(($width-$xo)/2);
							$xy_ini=0;
							} else {
							$xo=$width; 
							$yo=ceil(($xo*$thumbSize)/$thumbSize);
							$xy_ini=ceil(($height-$yo)/2);
							$xo_ini=0;
						}
						
						// copying the part into thumbnail
						$thumb = imagecreatetruecolor($thumbSize, $thumbSize);
						imagefill($thumb, 0, 0, 0x7fff0000);
						imagecopyresampled($thumb, $myImage, 0, 0, $xo_ini, $xy_ini, $thumbSize, $thumbSize, $xo, $yo);
						imagealphablending($thumb, false);
						imagesavealpha($thumb, true);
						//final output
						ob_start();
						imagepng($thumb);
						$image_data = ob_get_contents();
						ob_end_clean();
						$image_data_base64 = base64_encode($image_data);
						$Imagetemp = base64_decode($image_data_base64);
						$TempPath = $target_path . Time() . ".jpg";
						file_put_contents($TempPath, $Imagetemp);
						$ImageSize = filesize($TempPath); /* get the image size */
						if ($ImageSize < 83889000) { /* limit size to 10 mb */
							/** move the uploaded image **/
							$path = $target_path . "thumb.jpg";
							file_put_contents($path, $Imagetemp);
							$Imagetemp = $path;
							/** get the image path and store in database **/
							unlink($TempPath); /* delete the temporay file */
							} else {
							unlink($TempPath); /* delete the temporay file */
							/** image size limit exceded **/
						}
						header('Location: index.php');
					}
				?>
				<script>
					var rawinput;
					
					function previewFile(textureimg, inputid) {
						rawpreview = textureimg;
						var preview = textureimg;
						
						var file    =  inputid.files[0];
						rawinput =inputid.files[0] 
						var reader  = new FileReader();
						
						reader.addEventListener("load", function () {
							preview.src = reader.result;
							
						}, false);
						if (file) {
							reader.readAsDataURL(file);
						}
					}
					
					var jscolorvalue;
					var x ;
					var y ;
					
					function updatecolor(jointcolor,bodycolor){
						x = jointcolor;
						y = bodycolor;  
						
						if (x!=null){
							while(x.charAt(0) === '#'){
								x = x.substr(1);
								x="0x"+x;
							}
						}
						if (y!=null){
							while(y.charAt(0) === '#'){
								y = y.substr(1);
								y="0x"+y;	
							}
						}
						init();
					}
					
					var imageData;
					var bodytype;
					
					function updatemodel(textureimg, inputid,body){
						var preview = textureimg;
						var file    = inputid.files[0];
						bodytype = body;
						var reader  = new FileReader();
						
						reader.addEventListener("load", function () {
							preview.src = reader.result;
							imageData = preview.src;
							init();
						}, false);
						
						if (file) {
							reader.readAsDataURL(file);
						}
					}
					
					init();
					var camera, scene, renderer;
					
					this.dom = document.createElement( 'div' );
					var loader = new THREE.ObjectLoader();
					
					this.load = function ( json ) {
						
						renderer = new THREE.WebGLRenderer( {  alpha: true,antialias: true ,
						preserveDrawingBuffer   : true  } );
						renderer.setClearColor( 0x000000, 0 );
						
						renderer.setPixelRatio( window.devicePixelRatio );
						this.dom.appendChild( renderer.domElement );
						
						this.setScene( loader.parse( json.scene ) );
						this.setCamera( loader.parse( json.camera ) );
						
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
					
					var prevTime, request;
					
					this.play = function () {
						request = requestAnimationFrame( animate );
						prevTime = performance.now();
					};
					
					
					
					function init() {
						
						if(scene==null){
							var loader = new THREE.FileLoader();
							
							loader.load( 'js/tori_model.json', function ( text ) {
								load( JSON.parse( text ) );
								setSize( window.innerWidth, window.innerHeight - 50 );
								play();
								
								document.body.appendChild(dom );
								document.body.lastChild.firstElementChild.id = "scene";
								this.dom = document.createElement( 'div' );
								
								var controls = new THREE.OrbitControls( camera, renderer.domElement );
								controls.maxPolarAngle = Math.PI * 0.52;
								controls.minPolarAngle = Math.PI * 0.15;
								
								controls.minDistance = 1;
								controls.maxDistance = 20;
								
								window.addEventListener( 'resize', function () {
									setSize( window.innerWidth, window.innerHeight - 50 );
								} );
								
								light = new THREE.HemisphereLight(0xffffff, 0xffffff, .35)
								
								shadowLight = new THREE.DirectionalLight(0xffffff, .3);
								shadowLight.position.set(100,70, -200);
								shadowLight.castShadow = true;
								shadowLight.shadowDarkness = .2;
								
								backLight = new THREE.DirectionalLight(0xffffff, .4);
								backLight.position.set(-100, 150, -50);
								backLight.shadowDarkness = .1;
								backLight.castShadow = true;
								
								scene.add(backLight);
								scene.add(light);
								scene.add(shadowLight);
								
								var ambientlight = new THREE.AmbientLight( 0x404040 ); // soft white light
								scene.add( ambientlight );
								
								scene.background = null;
								
								var neck =  scene.getObjectByName("Neck");
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
								var head =  scene.getObjectByName("Head");
								var l_pecs =  scene.getObjectByName("L_Pecs");
								
								var joints = [neck, r_hip, r_knee,r_ankle,l_ankle,l_knee,l_hip,r_wrist,r_elbow,abs,lumbar,l_wrist,l_elbow,
								l_glute,r_glute,l_shoulder,l_pec,r_pec,r_shoulder,chestJoint];
								
								var body = [groin,r_thigh,r_leg,r_foot,l_foot,l_leg,l_thigh,r_hand,r_triceps,r_biceps,stomach,chest,breast,r_pecs,l_hand,l_triceps,l_biceps,
								head,l_pecs];
								
								var jointmat =  new THREE.MeshPhongMaterial( {
									specular: 0,
									reflectivity: 0,
									shininess: 0,
									shading: THREE.SmoothShading,
									
								} );
								
								var bodymat =  new THREE.MeshPhongMaterial( {
									specular: 0,
									reflectivity: 0,
									shininess: 0,
									shading: THREE.SmoothShading,
									
								} );
								
								camera.translateZ( - 0.8 );
								
								
								for(var i = 0 ; i< joints.length+1; i++){
									joints[i].material.specular = jointmat.specular;
									joints[i].material.reflectivity = jointmat.reflectivity;
									joints[i].material.shininess = jointmat.shininess;
									joints[i].position.z+=0.8;
									joints[i].position.y-=0.15;
									joints[i].position.x+=0.139;

									body[i].material.specular = jointmat.specular;
									body[i].material.reflectivity = jointmat.reflectivity;
									body[i].material.shininess = jointmat.shininess;
									body[i].material.map = null;
									body[i].position.z+=0.8;	
									body[i].position.y-=0.15;				
									body[i].position.x+=0.139;

								}
							} );
							
							}else{
							var neck =  scene.getObjectByName("Neck");
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
							var head =  scene.getObjectByName("Head");
							var l_pecs =  scene.getObjectByName("L_Pecs");
							
							var joints = [neck, r_hip, r_knee,r_ankle,l_ankle,l_knee,l_hip,r_wrist,r_elbow,abs,lumbar,l_wrist,l_elbow,
							l_glute,r_glute,l_shoulder,l_pec,r_pec,r_shoulder,chestJoint];
							
							var body = [groin,r_thigh,r_leg,r_foot,l_foot,l_leg,l_thigh,r_hand,r_triceps,r_biceps,stomach,chest,breast,r_pecs,l_hand,l_triceps,l_biceps,
							head,l_pecs];
							
							var headobj = scene.getObjectByName(bodytype);
							
							if(headobj!=null){
								
								var tgaloader = new THREE.TGALoader();
								var texture;
								if(rawinput.name.split('.').pop()=='tga'){
									texture = tgaloader.load(imageData)
									}else{
									texture = THREE.ImageUtils.loadTexture( imageData );
								}
								
								texture.magFilter = THREE.NearestFilter;
								texture.minFilter = THREE.NearestFilter;
								
								headobj.material.map = texture;
								headobj.material.needsUpdate = true;
							}
							
							for(var i = 0 ; i< joints.length; i++){
								if(x!=undefined){
									joints[i].material.color.setHex(x);
									joints[i].material.needsUpdate = true;
								}
							}
							for(var i = 0 ; i< body.length; i++){
								if(y!=undefined && body[i].material.map == null ){
									body[i].material.color.setHex(y);
									body[i].material.needsUpdate = true;
								}
								if(body[i].material.map != null){
									body[i].material.color.setHex(0xffffff);
									
								}
							}
							
							
							
						}
					}
					function animate() {
						
						requestAnimationFrame(animate);
						renderer.render(scene, camera);
						
						var dataUrl = renderer.domElement.toDataURL("image/png");
					}
					
					function saveAsImage() {
						
						var imgData, imgNode;
						
						try {
							var strMime = "image/png";
							imgData = renderer.domElement.toDataURL(strMime);
							
							saveFile(imgData.replace(strMime, strDownloadMime), "test.png");
							
							} catch (e) {
							console.log(e);
							return;
						}
						
						dosaveimage = 0;
						document.getElementById('imgurl').value = "dwdwdw";
						alert("imgData");
					}
					
					var saveFile = function (strData, filename) {
						var link = document.createElement('a');
						if (typeof link.download === 'string') {
							
							} else {
						}
						
					}
					
				</script>
			</body>
			</html>
				