<?php 
	include 'includes/session.php';
	
	if(isset($_POST['search'])){
		
		header('Location: search.php?q='.$_POST["search"]);
		
	}
	if(isset($_POST['search'])){
		
		header('Location: search.php?q='.$_POST["search"]);
		
	}
	require('includes/config.php');
	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Toribash Textures</title>
		<meta charset="utf-8">
		<meta name="generator" content="Three.js Editor">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
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
			
			.close:hover,
			.close:focus {
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
			background: #ececec; 
			background: linear-gradient(to bottom,  #ececec 0%,#d9d9d9 100%); 
			}
			
			#myBtn:hover {
			cursor: pointer;
			background-color:#2598d7; 
			}
			
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
		<?php include 'includes/links.php'; ?>
		
	</head>
	<body>
		<div class="thumb-capture-overlay">
			<span> Thumbnail Preview <span>
			</div>
			
			<?php include 'includes/header.php'; ?>
			<?php
				
				$getid = $_GET['id'];
				$stmt =  $conn->prepare("select * from images WHERE id= :getid");
				$stmt->bindValue(':getid', $getid);
				$stmt->execute();
				$result = $stmt->fetchAll();
			
				
				foreach ($result as $row)  {
					$current_counts = $row['views'];
					$new_count = $current_counts +1;
				}
				
				if(!isset($_SESSION['user_id'])){ 
					header('Location: index.php');
				}
				if($_SESSION['user_id'] != $row["user_id"]){
					header('Location: index.php');
				}
				
				$title = htmlspecialchars($row["title"], ENT_QUOTES, 'UTF-8');
				$artist = htmlspecialchars($row["artist"], ENT_QUOTES, 'UTF-8');
				$textureArtist = htmlspecialchars($row["textureArtist"], ENT_QUOTES, 'UTF-8');
				
				$userid =$row["user_id"];
				$postid = $row["id"];
				
				$uploadpoints=0;						
				if (!isset($_SESSION['Username'])){
					$posterror = "You need to be logged in to upload a texture.";
				}
				
				if(isset($_POST['submit'])){
					if (isset($_SESSION['Username'])){
						if(validatefile("inputimage")
						|| validatefile("groin")
						||validatefile("r_thigh")
						||validatefile("r_leg")
						||validatefile("r_foot")
						||validatefile("l_foot")
						||validatefile("l_leg")
						||validatefile("l_thigh")
						||validatefile("r_triceps")
						||validatefile("r_hand")
						||validatefile("r_biceps")
						||validatefile("stomach")
						||validatefile("chest")
						||validatefile("breast")
						||validatefile("r_pecs")
						||validatefile("l_hand")
						||validatefile("l_triceps")
						||validatefile("l_biceps")
						||validatefile("l_pecs")
						||validatefile("l_knee")
						||validatefile("l_glute")
						||validatefile("l_hip")
						||validatefile("r_hip")
						||validatefile("r_knee")
						||validatefile("r_glute")
						||validatefile("l_ankle")
						||validatefile("r_ankle")
						||validatefile("l_wrist")
						||validatefile("r_wrist")
						||validatefile("l_elbow")
						||validatefile("l_shoulder")
						||validatefile("l_pecs")
						||validatefile("r_elbow")
						||validatefile("r_shoulder")
						||validatefile("l_pecs")
						||validatefile("r_elbow")
						||validatefile("r_shoulder")
						||validatefile("r_pec")
						||validatefile("abs")
						||validatefile("lumbar")
						||validatefile("chestJoint")
						||validatefile("neck")){
							$posterror = "One of your selected Images is too big. The maximum image size is 2mb";	
							$uploadpoints ++;	
						}
						
						if(($_POST['title'])== ""  ){
							$posterror = "Please title your texture.";
							$uploadpoints ++;
						}
						
						if($uploadpoints == 0){
							$postsuccess = "Upload was successful. Upload another texture?";
							posttexture();
						}
						}else{
						$posterror = "You need to be logged in to upload a texture.";
					}
				}
				
				function validatefile($inputname){
					$maxfilesize =  10485760 ;
					if($_FILES[$inputname]["size"]!= 0){
						if($_FILES[$inputname]['size'] > $maxfilesize) {
							return true;
						}
						
						$FileType = pathinfo(basename($_FILES[$inputname]["name"]),PATHINFO_EXTENSION);
						
						if($FileType != "jpg" && $FileType != "png" && $FileType != "jpeg" && $FileType != "gif" && $FileType != "tga"){
							$posterror = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
							return	true;
						}
					return false;}
				return false;}
				
			?>
			<div id="leftcolumn">
				<div class="login-page">
					<div class="form">
						<form class="login-form" method ="post" enctype = "multipart/form-data" >
							<h2> <span class="yellowtxt">TEXTURE</span> <br/><span class="greytxt"> EDITOR</span></h2>
							<?php echo"<p class='error message' style='color:red;'>".$posterror."</p>"; ?>
							<?php echo"<p class='error message' style='color:#04e00e;'>".$postsuccess."</p>"; ?>
							<br/>
							<p class="message">Title: <span class="requiredfield">*Required</span></p>
							<input type ="text" id="title" maxlength="20" name="title" value="<?php echo $title;?>"/>
							<p class="message">Artist:</p>
							<input type ="text" id="artist" maxlength="20" name="artist" value="<?php echo $textureArtist;?>"/>
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
							<input type ="submit" name = "submit" value ="Save Edit" class="enviar" id="upload"  onclick="canvasCapture();"/>
							<input id="imgurl" name="imgurl" type="hidden">
							<br>
							
							<?php echo"<input type='hidden' name='jointcolor' id='jointcolor' value=".$row['jointcolor'].">";
								echo"<input type='hidden' name='bodycolor' id='bodycolor' value=".$row['bodycolor'].">";
							echo"<input type='hidden' name='textureid' id='textureid' value=".$_GET['id'].">"; ?>
						</form>
					</div>
				</div>
			</div>
			
			<script>
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
			</script>
			
			<script src="build/three.min.js"></script>
			<script src="js/app.js"></script>
			<script src="js/controls/OrbitControls.js"></script>
			<script src="js/loaders/TGALoader.js"></script>
			
			<script>
				function canvasCapture(){
					var dataURL = document.body.lastChild.firstElementChild.toDataURL();
					document.getElementById('imgurl').value = dataURL;
				}
				
			</script>
			<?php
				$type = ''; 
				$size = ''; 
				$error = ''; 
				function compress_image($source_url, $destination_url, $quality) 
				{ 
					$info = getimagesize($source_url); 
					if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url); 
					elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url); 
					elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url); 
					imagejpeg($image, $destination_url, $quality); 
					return $destination_url; 
				} 
				if ($_POST) 
				{ 						
				}else 
				{ 
					$error = "Uploaded image should be jpg or gif or png"; 
				} 
				
				function posttexture(){
					saveimage();
				}		
				
				function saveimage(){
						require('includes/config.php');

					
					$getid = $_GET['id'];
					$stmt =  $conn->prepare("select * from images WHERE id= :getid");
					$stmt->bindValue(':getid', $getid);
					$stmt->execute();
					$result = $stmt->fetchAll();
					foreach ($result as $row){}
					
					$artist = $_SESSION['Username'];
					$textureArtist = $_POST['artist'];
					$image = $_POST['imgurl'];
					$title = $_POST['title'];
					$getid = $_GET['id'];
					
					$jointcolor = "";
					if($_POST['jointcolor']!= ""){$jointcolor = $_POST['jointcolor'];}else{$jointcolor == $row["jointcolor"]; }
					
					$bodycolor = "";
					if($_POST['bodycolor']!= ""){$bodycolor = $_POST['bodycolor'];}else{$bodycolor == $row["bodycolor"]; }
					
					$user_id = $_SESSION['user_id'];
					
					$headtexture = $_FILES['inputimage']['name'];
					if($_FILES['inputimage']['name']){
						$headtexture = $_FILES['inputimage']['name'];
						if(pathinfo($headtexture, PATHINFO_EXTENSION)=="tga"){$headtexture = "tga";}
					else{$headtexture = "jpg";}}
					else{$headtexture = $row["headtexture"];}
					
					$breasttexture = $_FILES['breast']['name'];
					if($_FILES['breast']['name']){
						$breasttexture = $_FILES['breast']['name'];
						if(pathinfo($breasttexture, PATHINFO_EXTENSION)=="tga"){$breasttexture = "tga";}
					else{$breasttexture = "jpg";}}
					else{$breasttexture = $row["breasttexture"];}
					
					$grointexture = $_FILES['groin']['name'];
					if($_FILES['groin']['name']){
						$grointexture = $_FILES['groin']['name'];
						if(pathinfo($grointexture, PATHINFO_EXTENSION)=="tga"){$grointexture = "tga";}
					else{$grointexture = "jpg";}}
					else{$grointexture = $row["grointexture"];}
					
					$r_thightexture = $_FILES['r_thigh']['name'];
					if($_FILES['r_thigh']['name']){
						$r_thightexture = $_FILES['r_thigh']['name'];
						if(pathinfo($r_thightexture, PATHINFO_EXTENSION)=="tga"){$r_thightexture = "tga";}
					else{$r_thightexture = "jpg";}}
					else{$r_thightexture = $row["r_thightexture"];}
					
					$r_legtexture = $_FILES['r_leg']['name'];
					if($_FILES['r_leg']['name']){
						$r_legtexture = $_FILES['r_leg']['name'];
						if(pathinfo($r_legtexture, PATHINFO_EXTENSION)=="tga"){$r_legtexture = "tga";}
					else{$r_legtexture = "jpg";}}
					else{$r_legtexture = $row["r_legtexture"];}
					
					$r_foottexture = $_FILES['r_foot']['name'];
					if($_FILES['r_foot']['name']){
						$r_foottexture = $_FILES['r_foot']['name'];
						if(pathinfo($r_foottexture, PATHINFO_EXTENSION)=="tga"){$r_foottexture = "tga";}
					else{$r_foottexture = "jpg";}}
					else{$r_foottexture = $row["r_foottexture"];}
					
					$l_foottexture = $_FILES['l_foot']['name'];
					if($_FILES['l_foot']['name']){
						$l_foottexture = $_FILES['l_foot']['name'];
						if(pathinfo($l_foottexture, PATHINFO_EXTENSION)=="tga"){$l_foottexture = "tga";}
					else{$l_foottexture = "jpg";}}
					else{$l_foottexture = $row["l_foottexture"];}
					
					$l_legtexture = $_FILES['l_leg']['name'];
					if($_FILES['l_leg']['name']){
						$l_legtexture = $_FILES['l_leg']['name'];
						if(pathinfo($l_legtexture, PATHINFO_EXTENSION)=="tga"){$l_legtexture = "tga";}
					else{$l_legtexture = "jpg";}}
					else{$l_legtexture = $row["l_legtexture"];}
					
					$l_thightexture = $_FILES['l_thigh']['name'];
					if($_FILES['l_thigh']['name']){
						$l_thightexture = $_FILES['l_thigh']['name'];
						if(pathinfo($l_thightexture, PATHINFO_EXTENSION)=="tga"){$l_thightexture = "tga";}
					else{$l_thightexture = "jpg";}}
					else{$l_thightexture = $row["l_thightexture"];}
					
					$r_handtexture = $_FILES['r_hand']['name'];
					if($_FILES['r_hand']['name']){
						$r_handtexture = $_FILES['r_hand']['name'];
						if(pathinfo($r_handtexture, PATHINFO_EXTENSION)=="tga"){$r_handtexture = "tga";}
					else{$r_handtexture = "jpg";}}
					else{$r_handtexture = $row["r_handtexture"];}
					
					$r_tricepstexture = $_FILES['r_triceps']['name'];
					if($_FILES['r_triceps']['name']){
						$r_tricepstexture = $_FILES['r_triceps']['name'];
						if(pathinfo($r_tricepstexture, PATHINFO_EXTENSION)=="tga"){$r_tricepstexture = "tga";}
					else{$r_tricepstexture = "jpg";}}
					else{$r_tricepstexture = $row["r_tricepstexture"];}
					
					$r_bicepstexture = $_FILES['r_biceps']['name'];
					if($_FILES['r_biceps']['name']){
						$r_bicepstexture = $_FILES['r_biceps']['name'];
						if(pathinfo($r_bicepstexture, PATHINFO_EXTENSION)=="tga"){$r_bicepstexture = "tga";}
					else{$r_bicepstexture = "jpg";}}
					else{$r_bicepstexture = $row["r_bicepstexture"];}
					
					$stomachtexture = $_FILES['stomach']['name'];
					if($_FILES['stomach']['name']){
						$stomachtexture = $_FILES['stomach']['name'];
						if(pathinfo($stomachtexture, PATHINFO_EXTENSION)=="tga"){$stomachtexture = "tga";}
					else{$stomachtexture = "jpg";}}
					else{$stomachtexture = $row["stomachtexture"];}
					
					$chesttexture = $_FILES['chest']['name'];
					if($_FILES['chest']['name']){
						$chesttexture = $_FILES['chest']['name'];
						if(pathinfo($chesttexture, PATHINFO_EXTENSION)=="tga"){$chesttexture = "tga";}
					else{$chesttexture = "jpg";}}
					else{$chesttexture = $row["chesttexture"];}
					
					$r_pecstexture = $_FILES['r_pecs']['name'];
					if($_FILES['r_pecs']['name']){
						$r_pecstexture = $_FILES['r_pecs']['name'];
						if(pathinfo($r_pecstexture, PATHINFO_EXTENSION)=="tga"){$r_pecstexture = "tga";}
					else{$r_pecstexture = "jpg";}}
					else{$r_pecstexture = $row["r_pecstexture"];}
					
					$l_handtexture = $_FILES['l_hand']['name'];
					if($_FILES['l_hand']['name']){
						$l_handtexture = $_FILES['l_hand']['name'];
						if(pathinfo($l_handtexture, PATHINFO_EXTENSION)=="tga"){$l_handtexture = "tga";}
					else{$l_handtexture = "jpg";}}
					else{$l_handtexture = $row["l_handtexture"];}
					
					$l_tricepstexture = $_FILES['l_triceps']['name'];
					if($_FILES['l_triceps']['name']){
						$l_tricepstexture = $_FILES['l_triceps']['name'];
						if(pathinfo($l_tricepstexture, PATHINFO_EXTENSION)=="tga"){$l_tricepstexture = "tga";}
					else{$l_tricepstexture = "jpg";}}
					else{$l_tricepstexture = $row["l_tricepstexture"];}
					
					$l_bicepstexture = $_FILES['l_biceps']['name'];
					if($_FILES['l_biceps']['name']){
						$l_bicepstexture = $_FILES['l_biceps']['name'];
						if(pathinfo($l_bicepstexture, PATHINFO_EXTENSION)=="tga"){$l_bicepstexture = "tga";}
					else{$l_bicepstexture = "jpg";}}
					else{$l_bicepstexture = $row["l_bicepstexture"];}
					
					$l_pecstexture = $_FILES['l_pecs']['name'];
					if($_FILES['l_pecs']['name']){
						$l_pecstexture = $_FILES['l_pecs']['name'];
						if(pathinfo($l_pecstexture, PATHINFO_EXTENSION)=="tga"){$l_pecstexture = "tga";}
					else{$l_pecstexture = "jpg";}}
					else{$l_pecstexture = $row["l_pecstexture"];}
					
					$l_kneetexture = $_FILES['l_knee']['name'];
					if($_FILES['l_knee']['name']){
						$l_kneetexture = $_FILES['l_knee']['name'];
						if(pathinfo($l_kneetexture, PATHINFO_EXTENSION)=="tga"){$l_kneetexture = "tga";}
					else{$l_kneetexture = "jpg";}}
					else{$l_kneetexture = $row["l_kneetexture"];}
					
					$l_glutetexture = $_FILES['l_glute']['name'];
					if($_FILES['l_glute']['name']){
						$l_glutetexture = $_FILES['l_glute']['name'];
						if(pathinfo($l_glutetexture, PATHINFO_EXTENSION)=="tga"){$l_glutetexture = "tga";}
					else{$l_glutetexture = "jpg";}}
					else{$l_glutetexture = $row["l_glutetexture"];}
					
					$l_hiptexture = $_FILES['l_hip']['name'];
					if($_FILES['l_hip']['name']){
						$l_hiptexture = $_FILES['l_hip']['name'];
						if(pathinfo($l_hiptexture, PATHINFO_EXTENSION)=="tga"){$l_hiptexture = "tga";}
					else{$l_hiptexture = "jpg";}}
					else{$l_hiptexture = $row["l_hiptexture"];}
					
					$r_hiptexture = $_FILES['r_hip']['name'];
					if($_FILES['r_hip']['name']){
						$r_hiptexture = $_FILES['r_hip']['name'];
						if(pathinfo($r_hiptexture, PATHINFO_EXTENSION)=="tga"){$r_hiptexture = "tga";}
					else{$r_hiptexture = "jpg";}}
					else{$r_hiptexture = $row["r_hiptexture"];}
					
					$r_kneetexture = $_FILES['r_knee']['name'];
					if($_FILES['r_knee']['name']){
						$r_kneetexture = $_FILES['r_knee']['name'];
						if(pathinfo($r_kneetexture, PATHINFO_EXTENSION)=="tga"){$r_kneetexture = "tga";}
					else{$r_kneetexture = "jpg";}}
					else{$r_kneetexture = $row["r_kneetexture"];}
					
					$r_glutetexture = $_FILES['r_glute']['name'];
					if($_FILES['r_glute']['name']){
						$r_glutetexture = $_FILES['r_glute']['name'];
						if(pathinfo($r_glutetexture, PATHINFO_EXTENSION)=="tga"){$r_glutetexture = "tga";}
					else{$r_glutetexture = "jpg";}}
					else{$r_glutetexture = $row["r_glutetexture"];}
					
					$l_ankletexture = $_FILES['l_ankle']['name'];
					if($_FILES['l_ankle']['name']){
						$l_ankletexture = $_FILES['l_ankle']['name'];
						if(pathinfo($l_ankletexture, PATHINFO_EXTENSION)=="tga"){$l_ankletexture = "tga";}
					else{$l_ankletexture = "jpg";}}
					else{$l_ankletexture = $row["l_ankletexture"];}
					
					$r_ankletexture = $_FILES['r_ankle']['name'];
					if($_FILES['r_ankle']['name']){
						$r_ankletexture = $_FILES['r_ankle']['name'];
						if(pathinfo($r_ankletexture, PATHINFO_EXTENSION)=="tga"){$r_ankletexture = "tga";}
					else{$r_ankletexture = "jpg";}}
					else{$r_ankletexture = $row["r_ankletexture"];}
					
					$l_wristtexture = $_FILES['l_wrist']['name'];
					if($_FILES['l_wrist']['name']){
						$l_wristtexture = $_FILES['l_wrist']['name'];
						if(pathinfo($l_wristtexture, PATHINFO_EXTENSION)=="tga"){$l_wristtexture = "tga";}
					else{$l_wristtexture = "jpg";}}
					else{$l_wristtexture = $row["l_wristtexture"];}
					
					$r_wristtexture = $_FILES['r_wrist']['name'];
					if($_FILES['r_wrist']['name']){
						$r_wristtexture = $_FILES['r_wrist']['name'];
						if(pathinfo($r_wristtexture, PATHINFO_EXTENSION)=="tga"){$r_wristtexture = "tga";}
					else{$r_wristtexture = "jpg";}}
					else{$r_wristtexture = $row["r_wristtexture"];}
					
					$l_elbowtexture = $_FILES['l_elbow']['name'];
					if($_FILES['l_elbow']['name']){
						$l_elbowtexture = $_FILES['l_elbow']['name'];
						if(pathinfo($l_elbowtexture, PATHINFO_EXTENSION)=="tga"){$l_elbowtexture = "tga";}
					else{$l_elbowtexture = "jpg";}}
					else{$l_elbowtexture = $row["l_elbowtexture"];}
					
					$l_shouldertexture = $_FILES['l_shoulder']['name'];
					if($_FILES['l_shoulder']['name']){
						$l_shouldertexture = $_FILES['l_shoulder']['name'];
						if(pathinfo($l_shouldertexture, PATHINFO_EXTENSION)=="tga"){$l_shouldertexture = "tga";}
					else{$l_shouldertexture = "jpg";}}
					else{$l_shouldertexture = $row["l_shouldertexture"];}
					
					$l_pectexture = $_FILES['l_pec']['name'];
					if($_FILES['l_pec']['name']){
						$l_pectexture = $_FILES['l_pec']['name'];
						if(pathinfo($l_pectexture, PATHINFO_EXTENSION)=="tga"){$l_pectexture = "tga";}
					else{$l_pectexture = "jpg";}}
					else{$l_pectexture = $row["l_pectexture"];}
					
					$r_elbowtexture = $_FILES['r_elbow']['name'];
					if($_FILES['r_elbow']['name']){
						$r_elbowtexture = $_FILES['r_elbow']['name'];
						if(pathinfo($r_elbowtexture, PATHINFO_EXTENSION)=="tga"){$r_elbowtexture = "tga";}
					else{$r_elbowtexture = "jpg";}}
					else{$r_elbowtexture = $row["r_elbowtexture"];}
					
					$r_shouldertexture = $_FILES['r_shoulder']['name'];
					if($_FILES['r_shoulder']['name']){
						$r_shouldertexture = $_FILES['r_shoulder']['name'];
						if(pathinfo($r_shouldertexture, PATHINFO_EXTENSION)=="tga"){$r_shouldertexture = "tga";}
					else{$r_shouldertexture = "jpg";}}
					else{$r_shouldertexture = $row["r_shouldertexture"];}
					
					$r_pectexture = $_FILES['r_pec']['name'];
					if($_FILES['r_pec']['name']){
						$r_pectexture = $_FILES['r_pec']['name'];
						if(pathinfo($r_pectexture, PATHINFO_EXTENSION)=="tga"){$r_pectexture = "tga";}
					else{$r_pectexture = "jpg";}}
					else{$r_pectexture = $row["r_pectexture"];}
					
					$abstexture = $_FILES['abs']['name'];
					if($_FILES['abs']['name']){
						$abstexture = $_FILES['abs']['name'];
						if(pathinfo($abstexture, PATHINFO_EXTENSION)=="tga"){$abstexture = "tga";}
					else{$abstexture = "jpg";}}
					else{$abstexture = $row["abstexture"];}
					
					$lumbartexture = $_FILES['lumbar']['name'];
					if($_FILES['lumbar']['name']){
						$lumbartexture = $_FILES['lumbar']['name'];
						if(pathinfo($lumbartexture, PATHINFO_EXTENSION)=="tga"){$lumbartexture = "tga";}
					else{$lumbartexture = "jpg";}}
					else{$lumbartexture = $row["lumbartexture"];}
					
					$chestjointtexture = $_FILES['chestJoint']['name'];
					if($_FILES['chestJoint']['name']){
						$chestjointtexture = $_FILES['chestJoint']['name'];
						if(pathinfo($chestjointtexture, PATHINFO_EXTENSION)=="tga"){$chestjointtexture = "tga";}
					else{$chestjointtexture = "jpg";}}
					else{$chestjointtexture = $row["chestjointtexture"];}
					
					$necktexture = $_FILES['neck']['name'];
					if($_FILES['neck']['name']){
						$necktexture = $_FILES['neck']['name'];
						if(pathinfo($necktexture, PATHINFO_EXTENSION)=="tga"){$necktexture = "tga";}
					else{$necktexture = "jpg";}}
					else{$necktexture = $row["necktexture"];}
					
					$qry ="UPDATE images SET title = :title,textureArtist = :textureArtist, headtexture = :headtexture,breasttexture = :breasttexture,chesttexture = :chesttexture,
					stomachtexture = :stomachtexture,grointexture = :grointexture,r_pecstexture = :r_pecstexture,r_bicepstexture = :r_bicepstexture,r_tricepstexture = :r_tricepstexture,l_pecstexture = :l_pecstexture,
					l_bicepstexture = :l_bicepstexture,l_tricepstexture = :l_tricepstexture,r_handtexture = :r_handtexture,l_handtexture = :l_handtexture,r_thightexture = :r_thightexture,l_thightexture = :l_thightexture,
					l_legtexture = :l_legtexture,r_legtexture = :r_legtexture,l_foottexture = :l_foottexture,r_foottexture = :r_foottexture,l_kneetexture = :l_kneetexture,l_glutetexture = :l_glutetexture,
					l_hiptexture = :l_hiptexture,r_hiptexture = :r_hiptexture,r_kneetexture = :r_kneetexture,r_glutetexture = :r_glutetexture,l_ankletexture = :l_ankletexture,r_ankletexture = :r_ankletexture,
					l_wristtexture = :l_wristtexture,r_wristtexture = :r_wristtexture,l_elbowtexture = :l_elbowtexture,l_shouldertexture = :l_shouldertexture,l_pectexture = :l_pectexture,r_elbowtexture = :r_elbowtexture,
					r_shouldertexture = :r_shouldertexture,r_pectexture = :r_pectexture,abstexture = :abstexture,lumbartexture = :lumbartexture,chestjointtexture = :chestjointtexture,necktexture = :necktexture,
					jointcolor = :jointcolor, bodycolor = :bodycolor WHERE id = :id";
					
					$qry = $conn->prepare($qry);
					$qry->bindValue(':title', $title);
					$qry->bindValue(':textureArtist', $textureArtist);
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
					$qry->bindValue(':jointcolor', $jointcolor);
					$qry->bindValue(':bodycolor', $bodycolor);
					$qry->bindValue(':id', $getid);
					
					$qry->execute();
					$lastid = $getid;
					$userid = $_SESSION['user_id'];
					
					if (!file_exists('uploads/'.$userid)) {
						mkdir('uploads/'.$userid, 0777, true);
					}
					if (!file_exists('uploads/'.$userid.'/'.$lastid)) {
						mkdir('uploads/'.$userid.'/'.$lastid, 0777, true);
					}
					$target_path = 'uploads/'.$userid.'/'.$lastid."/";
					
					if($_FILES['inputimage']['size'] != 0){
						if(pathinfo($_FILES['inputimage']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."head.tga");
							move_uploaded_file($_FILES['inputimage']['tmp_name'], $target_path."head.tga");
							}else{
							unlink($target_path."head.jpg");
							move_uploaded_file($_FILES['inputimage']['tmp_name'], $target_path."head.jpg");
						}
					}
					
					if($_FILES['breast']['size'] != 0){
						if(pathinfo($_FILES['breast']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."breast.tga");
							move_uploaded_file($_FILES['breast']['tmp_name'], $target_path."breast.tga");
							}else{
							unlink($target_path."breast.jpg");
							move_uploaded_file($_FILES['breast']['tmp_name'], $target_path."breast.jpg");
						}
					}
					
					if($_FILES['chest']['size'] != 0){
						if(pathinfo($_FILES['chest']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."chest.tga");
							move_uploaded_file($_FILES['chest']['tmp_name'], $target_path."chest.tga");
							}else{
							unlink($target_path."chest.jpg");
							move_uploaded_file($_FILES['chest']['tmp_name'], $target_path."chest.jpg");
						}
					}
					
					if($_FILES['stomach']['size'] != 0){
						if(pathinfo($_FILES['stomach']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."stomach.tga");
							move_uploaded_file($_FILES['stomach']['tmp_name'], $target_path."stomach.tga");
							}else{
							unlink($target_path."stomach.jpg");
							move_uploaded_file($_FILES['stomach']['tmp_name'], $target_path."stomach.jpg");
						}
					}
					
					if($_FILES['groin']['size'] != 0){
						if(pathinfo($_FILES['groin']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."groin.tga");
							move_uploaded_file($_FILES['groin']['tmp_name'], $target_path."groin.tga");
							}else{
							unlink($target_path."groin.jpg");
							move_uploaded_file($_FILES['groin']['tmp_name'], $target_path."groin.jpg");
						}
					}
					
					if($_FILES['r_pecs']['size'] != 0){
						if(pathinfo($_FILES['r_pecs']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."r_pecs.tga");
							move_uploaded_file($_FILES['r_pecs']['tmp_name'], $target_path."r_pecs.tga");
							}else{
							unlink($target_path."r_pecs.jpg");
							move_uploaded_file($_FILES['r_pecs']['tmp_name'], $target_path."r_pecs.jpg");
						}
					}
					
					if($_FILES['r_biceps']['size'] != 0){
						if(pathinfo($_FILES['r_biceps']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."r_biceps.tga");
							move_uploaded_file($_FILES['r_biceps']['tmp_name'], $target_path."r_biceps.tga");
							}else{
							unlink($target_path."r_biceps.jpg");
							move_uploaded_file($_FILES['r_biceps']['tmp_name'], $target_path."r_biceps.jpg");
						}
					}
					
					if($_FILES['r_triceps']['size'] != 0){
						if(pathinfo($_FILES['r_triceps']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."r_triceps.tga");
							move_uploaded_file($_FILES['r_triceps']['tmp_name'], $target_path."r_triceps.tga");
							}else{
							unlink($target_path."r_triceps.jpg");
							move_uploaded_file($_FILES['r_triceps']['tmp_name'], $target_path."r_triceps.jpg");
						}
					}
					
					if($_FILES['l_pecs']['size'] != 0){
						if(pathinfo($_FILES['l_pecs']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."l_pecs.tga");
							move_uploaded_file($_FILES['l_pecs']['tmp_name'], $target_path."l_pecs.tga");
							}else{
							unlink($target_path."l_pecs.jpg");
							move_uploaded_file($_FILES['l_pecs']['tmp_name'], $target_path."l_pecs.jpg");
						}
					}
					
					if($_FILES['l_biceps']['size'] != 0){
						if(pathinfo($_FILES['l_biceps']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."l_biceps.tga");
							move_uploaded_file($_FILES['l_biceps']['tmp_name'], $target_path."l_biceps.tga");
							}else{
							unlink($target_path."l_biceps.jpg");
							move_uploaded_file($_FILES['l_biceps']['tmp_name'], $target_path."l_biceps.jpg");
						}
					}
					
					if($_FILES['l_triceps']['size'] != 0){
						if(pathinfo($_FILES['l_triceps']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."l_triceps.tga");
							move_uploaded_file($_FILES['l_triceps']['tmp_name'], $target_path."l_triceps.tga");
							}else{
							unlink($target_path."l_triceps.jpg");
							move_uploaded_file($_FILES['l_triceps']['tmp_name'], $target_path."l_triceps.jpg");
						}
					}
					
					if($_FILES['r_hand']['size'] != 0){
						if(pathinfo($_FILES['r_hand']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."r_hand.tga");
							move_uploaded_file($_FILES['r_hand']['tmp_name'], $target_path."r_hand.tga");
							}else{
							unlink($target_path."r_hand.jpg");
							move_uploaded_file($_FILES['r_hand']['tmp_name'], $target_path."r_hand.jpg");
						}
					}
					
					if($_FILES['r_shoulder']['size'] != 0){
						if(pathinfo($_FILES['r_shoulder']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."r_shoulder.tga");
							move_uploaded_file($_FILES['r_shoulder']['tmp_name'], $target_path."r_shoulder.tga");
							}else{
							unlink($target_path."r_shoulder.jpg");
							move_uploaded_file($_FILES['r_shoulder']['tmp_name'], $target_path."r_shoulder.jpg");
						}
					}
					
					if($_FILES['l_hand']['size'] != 0){
						if(pathinfo($_FILES['l_hand']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."l_hand.tga");
							move_uploaded_file($_FILES['l_hand']['tmp_name'], $target_path."l_hand.tga");
							}else{
							unlink($target_path."l_hand.jpg");
							move_uploaded_file($_FILES['l_hand']['tmp_name'], $target_path."l_hand.jpg");
						}
					}
					
					if($_FILES['r_thigh']['size'] != 0){
						if(pathinfo($_FILES['r_thigh']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."r_thigh.tga");
							move_uploaded_file($_FILES['r_thigh']['tmp_name'], $target_path."r_thigh.tga");
							}else{
							unlink($target_path."r_thigh.jpg");
							move_uploaded_file($_FILES['r_thigh']['tmp_name'], $target_path."r_thigh.jpg");
						}
					}
					
					if($_FILES['l_thigh']['size'] != 0){
						if(pathinfo($_FILES['l_thigh']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."l_thigh.tga");
							move_uploaded_file($_FILES['l_thigh']['tmp_name'], $target_path."l_thigh.tga");
							}else{
							unlink($target_path."l_thigh.jpg");
							move_uploaded_file($_FILES['l_thigh']['tmp_name'], $target_path."l_thigh.jpg");
						}
					}
					
					if($_FILES['l_leg']['size'] != 0){
						if(pathinfo($_FILES['l_leg']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."l_leg.tga");
							move_uploaded_file($_FILES['l_leg']['tmp_name'], $target_path."l_leg.tga");
							}else{
							unlink($target_path."l_leg.jpg");
							move_uploaded_file($_FILES['l_leg']['tmp_name'], $target_path."l_leg.jpg");
						}
					}
					
					if($_FILES['r_leg']['size'] != 0){
						if(pathinfo($_FILES['r_leg']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."r_leg.tga");
							move_uploaded_file($_FILES['r_leg']['tmp_name'], $target_path."r_leg.tga");
							}else{
							unlink($target_path."r_leg.jpg");
							move_uploaded_file($_FILES['r_leg']['tmp_name'], $target_path."r_leg.jpg");
						}
					}
					
					if($_FILES['l_foot']['size'] != 0){
						if(pathinfo($_FILES['l_foot']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."l_foot.tga");
							move_uploaded_file($_FILES['l_foot']['tmp_name'], $target_path."l_foot.tga");
							}else{
							unlink($target_path."l_foot.jpg");
							move_uploaded_file($_FILES['l_foot']['tmp_name'], $target_path."l_foot.jpg");
						}
					}
					
					if($_FILES['r_foot']['size'] != 0){
						if(pathinfo($_FILES['r_foot']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."r_foot.tga");
							move_uploaded_file($_FILES['r_foot']['tmp_name'], $target_path."r_foot.tga");
							}else{
							unlink($target_path."r_foot.jpg");
							move_uploaded_file($_FILES['r_foot']['tmp_name'], $target_path."r_foot.jpg");
						}
					}
					
					if($_FILES['l_knee']['size'] != 0){
						if(pathinfo($_FILES['l_knee']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."l_knee.tga");
							move_uploaded_file($_FILES['l_knee']['tmp_name'], $target_path."l_knee.tga");
							}else{
							unlink($target_path."l_knee.jpg");
							move_uploaded_file($_FILES['l_knee']['tmp_name'], $target_path."l_knee.jpg");
						}
					}
					
					if($_FILES['l_glute']['size'] != 0){
						if(pathinfo($_FILES['l_glute']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."l_glute.tga");
							move_uploaded_file($_FILES['l_glute']['tmp_name'], $target_path."l_glute.tga");
							}else{
							unlink($target_path."l_glute.jpg");
							move_uploaded_file($_FILES['l_glute']['tmp_name'], $target_path."l_glute.jpg");
						}
					}
					
					if($_FILES['l_hip']['size'] != 0){
						if(pathinfo($_FILES['l_hip']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."l_hip.tga");
							move_uploaded_file($_FILES['l_hip']['tmp_name'], $target_path."l_hip.tga");
							}else{
							unlink($target_path."l_hip.jpg");
							move_uploaded_file($_FILES['l_hip']['tmp_name'], $target_path."l_hip.jpg");
						}
					}
					
					if($_FILES['r_hip']['size'] != 0){
						if(pathinfo($_FILES['r_hip']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."r_hip.tga");
							move_uploaded_file($_FILES['r_hip']['tmp_name'], $target_path."r_hip.tga");
							}else{
							unlink($target_path."r_hip.jpg");
							move_uploaded_file($_FILES['r_hip']['tmp_name'], $target_path."r_hip.jpg");
						}
					}
					
					if($_FILES['r_knee']['size'] != 0){
						if(pathinfo($_FILES['r_knee']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."r_knee.tga");
							move_uploaded_file($_FILES['r_knee']['tmp_name'], $target_path."r_knee.tga");
							}else{
							unlink($target_path."r_knee.jpg");
							move_uploaded_file($_FILES['r_knee']['tmp_name'], $target_path."r_knee.jpg");
						}
					}
					
					if($_FILES['r_glute']['size'] != 0){
						if(pathinfo($_FILES['r_glute']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."r_glute.tga");
							move_uploaded_file($_FILES['r_glute']['tmp_name'], $target_path."r_glute.tga");
							}else{
							unlink($target_path."r_glute.jpg");
							move_uploaded_file($_FILES['r_glute']['tmp_name'], $target_path."r_glute.jpg");
						}
					}
					
					if($_FILES['l_ankle']['size'] != 0){
						if(pathinfo($_FILES['l_ankle']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."l_ankle.tga");
							move_uploaded_file($_FILES['l_ankle']['tmp_name'], $target_path."l_ankle.tga");
							}else{
							unlink($target_path."l_ankle.jpg");
							move_uploaded_file($_FILES['l_ankle']['tmp_name'], $target_path."l_ankle.jpg");
						}
					}
					
					if($_FILES['r_ankle']['size'] != 0){
						if(pathinfo($_FILES['r_ankle']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."r_ankle.tga");
							move_uploaded_file($_FILES['r_ankle']['tmp_name'], $target_path."r_ankle.tga");
							}else{
							unlink($target_path."r_ankle.jpg");
							move_uploaded_file($_FILES['r_ankle']['tmp_name'], $target_path."r_ankle.jpg");
						}
					}
					
					if($_FILES['l_wrist']['size'] != 0){
						if(pathinfo($_FILES['l_wrist']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."l_wrist.tga");
							move_uploaded_file($_FILES['l_wrist']['tmp_name'], $target_path."l_wrist.tga");
							}else{
							unlink($target_path."l_wrist.jpg");
							move_uploaded_file($_FILES['l_wrist']['tmp_name'], $target_path."l_wrist.jpg");
						}
					}
					
					if($_FILES['r_wrist']['size'] != 0){
						if(pathinfo($_FILES['r_wrist']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."r_wrist.tga");
							move_uploaded_file($_FILES['r_wrist']['tmp_name'], $target_path."r_wrist.tga");
							}else{
							unlink($target_path."r_wrist.jpg");
							move_uploaded_file($_FILES['r_wrist']['tmp_name'], $target_path."r_wrist.jpg");
						}
					}
					
					if($_FILES['l_elbow']['size'] != 0){
						if(pathinfo($_FILES['l_elbow']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."l_elbow.tga");
							move_uploaded_file($_FILES['l_elbow']['tmp_name'], $target_path."l_elbow.tga");
							}else{
							unlink($target_path."l_elbow.jpg");
							move_uploaded_file($_FILES['l_elbow']['tmp_name'], $target_path."l_elbow.jpg");
						}
					}
					
					if($_FILES['l_shoulder']['size'] != 0){
						if(pathinfo($_FILES['l_shoulder']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."l_shoulder.tga");
							move_uploaded_file($_FILES['l_shoulder']['tmp_name'], $target_path."l_shoulder.tga");
							}else{
							unlink($target_path."l_shoulder.jpg");
							move_uploaded_file($_FILES['l_shoulder']['tmp_name'], $target_path."l_shoulder.jpg");
						}
					}
					
					if($_FILES['l_pec']['size'] != 0){
						if(pathinfo($_FILES['l_pec']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."l_pec.tga");
							move_uploaded_file($_FILES['l_pec']['tmp_name'], $target_path."l_pec.tga");
							}else{
							unlink($target_path."l_pec.jpg");
							move_uploaded_file($_FILES['l_pec']['tmp_name'], $target_path."l_pec.jpg");
						}
					}
					
					if($_FILES['r_elbow']['size'] != 0){
						if(pathinfo($_FILES['r_elbow']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."r_elbow.tga");
							move_uploaded_file($_FILES['r_elbow']['tmp_name'], $target_path."r_elbow.tga");
							}else{
							unlink($target_path."r_elbow.jpg");
							move_uploaded_file($_FILES['r_elbow']['tmp_name'], $target_path."r_elbow.jpg");
						}
					}
					
					if($_FILES['r_pec']['size'] != 0){
						if(pathinfo($_FILES['r_pec']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."r_pec.tga");
							move_uploaded_file($_FILES['r_pec']['tmp_name'], $target_path."r_pec.tga");
							}else{
							unlink($target_path."r_pec.jpg");
							move_uploaded_file($_FILES['r_pec']['tmp_name'], $target_path."r_pec.jpg");
						}
					}
					
					if($_FILES['abs']['size'] != 0){
						if(pathinfo($_FILES['abs']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."abs.tga");
							move_uploaded_file($_FILES['abs']['tmp_name'], $target_path."abs.tga");
							}else{
							unlink($target_path."abs.jpg");
							move_uploaded_file($_FILES['abs']['tmp_name'], $target_path."abs.jpg");
						}
					}
					
					if($_FILES['lumbar']['size'] != 0){
						if(pathinfo($_FILES['lumbar']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."lumbar.tga");
							move_uploaded_file($_FILES['lumbar']['tmp_name'], $target_path."lumbar.tga");
							}else{
							unlink($target_path."lumbar.jpg");
							move_uploaded_file($_FILES['lumbar']['tmp_name'], $target_path."lumbar.jpg");
						}
					}
					
					if($_FILES['chestJoint']['size'] != 0){
						if(pathinfo($_FILES['chestJoint']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."chestJoint.tga");
							move_uploaded_file($_FILES['chestJoint']['tmp_name'], $target_path."chestJoint.tga");
							}else{
							unlink($target_path."chestJoint.jpg");
							move_uploaded_file($_FILES['chestJoint']['tmp_name'], $target_path."chestJoint.jpg");
						}
					}
					
					if($_FILES['neck']['size'] != 0){
						if(pathinfo($_FILES['neck']['name'], PATHINFO_EXTENSION)=="tga"){
							unlink($target_path."neck.tga");
							move_uploaded_file($_FILES['neck']['tmp_name'], $target_path."neck.tga");
							}else{
							unlink($target_path."neck.jpg");
							move_uploaded_file($_FILES['neck']['tmp_name'], $target_path."neck.jpg");
						}
					}
					
					$Imagetemp = $image;
					list($type, $Imagetemp) = explode(';', $Imagetemp);
					list(, $Imagetemp)      = explode(',', $Imagetemp);
					/** decode the base 64 image **/
					$Imagetemp = base64_decode($Imagetemp);
					/* move image to temp folder */
					$TempPath = $target_path.Time().".jpg";
					file_put_contents($TempPath, $Imagetemp);
					$ImageSize = filesize($TempPath);/* get the image size */
					if($ImageSize < 83889000){ /* limit size to 10 mb */
						/** move the uploaded image **/
						$path = $target_path."capture.jpg";
						file_put_contents($path, $Imagetemp);
						$Imagetemp = $path;
						/** get the image path and store in database **/
						unlink($TempPath);/* delete the temporay file */
						}else{
						unlink($TempPath);/* delete the temporay file */
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
						$yo=$height / 2;
						$xo=ceil(($yo*$thumbSize)/$thumbSize);
						$xo_ini=ceil(($width-$xo)/2);
						$xy_ini=0;
						} else {
						$xo=$width * 2; 
						$yo=ceil(($xo*$thumbSize)/$thumbSize) / 2;
						$xy_ini=ceil(($height-$yo)/2);
						$xo_ini=0;
					}
					
					// copying the part into thumbnail
					$thumb = imagecreatetruecolor($thumbSize, $thumbSize);
					imagefill($thumb,0,0,0x7fff0000);  
					//imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);
					imagecopyresampled($thumb, $myImage, 0, 0, $xo_ini, $xy_ini, $thumbSize, $thumbSize, $xo, $yo);
					imagealphablending( $thumb, false );
					imagesavealpha( $thumb, true );
					//final output
					ob_start (); 
					imagepng ($thumb);
					$image_data = ob_get_contents (); 
					ob_end_clean (); 
					$image_data_base64 = base64_encode ($image_data);
					$Imagetemp = base64_decode($image_data_base64);
					$TempPath = $target_path.Time().".jpg";
					unlink('uploads/'.$userid.'/'.$lastid."/"."thumb.jpg");
					file_put_contents($TempPath, $Imagetemp);
					$ImageSize = filesize($TempPath);/* get the image size */
					if($ImageSize < 83889000){ /* limit size to 10 mb */
						/** move the uploaded image **/
						$path = $target_path."thumb.jpg";
						file_put_contents($path, $Imagetemp);
						$Imagetemp = $path;
						/** get the image path and store in database **/
						unlink($TempPath);/* delete the temporay file */
						}else{
						unlink($TempPath);/* delete the temporay file */
						/** image size limit exceded **/
					}
					header('Location: texture.php?id='.$_GET['id']);
				}
				
			?>
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
				
				var player;
				
				init();
				var loader = new THREE.ObjectLoader();
				var camera, scene, renderer;
				
				var controls, effect, cameraVR, isVR;
				
				var events = {};
				
				function init() {
					if(scene==null){
						var loader = new THREE.FileLoader();
						loader.load( 'app5.json', function ( text ) {
							load( JSON.parse( text ) );
							setSize( window.innerWidth, window.innerHeight );
							
							play();
							
							document.body.appendChild(dom );
							document.body.lastChild.firstElementChild.id = "scene";
							
							this.dom = document.createElement( 'div' );
							
							this.width = 500;
							this.height = 500;
							
							this.load = function ( json ) {
								
								isVR = json.project.vr;
								
								renderer = new THREE.WebGLRenderer( {  alpha: true,antialias: true ,
								preserveDrawingBuffer   : true , canvas : document.getElementById('scene')} );
								renderer.setClearColor( 0x000000, 0 );
								
								renderer.setPixelRatio( window.devicePixelRatio );
								
								if ( json.project.gammaInput ) renderer.gammaInput = true;
								if ( json.project.gammaOutput ) renderer.gammaOutput = true;
								
								if ( json.project.shadows ) {
									
									renderer.shadowMap.enabled = true;
									
								}
								
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
								
								var scriptWrapParams = 'player,renderer,scene,camera';
								var scriptWrapResultObj = {};
								
								for ( var eventKey in events ) {
									
									scriptWrapParams += ',' + eventKey;
									scriptWrapResultObj[ eventKey ] = eventKey;
									
								}
								
								var scriptWrapResult = JSON.stringify( scriptWrapResultObj ).replace( /\"/g, '' );
								
								for ( var uuid in json.scripts ) {
									
									var object = scene.getObjectByProperty( 'uuid', uuid, true );
									
									if ( object === undefined ) {
										
										console.warn( 'APP.Player: Script without object.', uuid );
										continue;
										
									}
									
									var scripts = json.scripts[ uuid ];
									
									for ( var i = 0; i < scripts.length; i ++ ) {
										
										var script = scripts[ i ];
										
										var functions = ( new Function( scriptWrapParams, script.source + '\nreturn ' + scriptWrapResult + ';' ).bind( object ) )( this, renderer, scene, camera );
										
										for ( var name in functions ) {
											
											if ( functions[ name ] === undefined ) continue;
											
											if ( events[ name ] === undefined ) {
												
												console.warn( 'APP.Player: Event type not supported (', name, ')' );
												continue;
												
											}
											
											events[ name ].push( functions[ name ].bind( object ) );
											
										}
										
									}
									
								}
								
								dispatch( events.init, arguments );
								
							};
							
							this.setCamera = function ( value ) {
								camera = value;
								camera.aspect = this.width / this.height;
								camera.updateProjectionMatrix();
								
							};
							var controls = new THREE.OrbitControls( camera, renderer.domElement );
							controls.maxPolarAngle = Math.PI * 0.52;
							controls.minPolarAngle = Math.PI * 0.15;
							
							
							controls.minDistance = 1;
							controls.maxDistance = 20;
							
							this.setScene = function ( value ) {
								
								scene = value;
								
							};
							
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
							
							function dispatch( array, event ) {
								
								for ( var i = 0, l = array.length; i < l; i ++ ) {
									array[ i ]( event );
								}
							}
							
							var prevTime, request;
							
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
							
							this.dispose = function () {
								
								while ( this.dom.children.length ) {
									this.dom.removeChild( this.dom.firstChild );
								}
								
								renderer.dispose();
								camera = undefined;
								scene = undefined;
								renderer = undefined;
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
							
							window.addEventListener( 'resize', function () {
								setSize( window.innerWidth, window.innerHeight );
							} );
							
							if ( location.search === '?edit' ) {
								var button = document.createElement( 'a' );
								button.id = 'edit';
								button.href = 'https://threejs.org/editor/#file=' + location.href.split( '/' ).slice( 0, - 1 ).join( '/' ) + '/app.json';
								button.target = '_blank';
								button.textContent = 'EDIT';
								document.body.appendChild( button );
							}
							
							light = new THREE.HemisphereLight(0xffffff, 0xffffff, .5)
							
							shadowLight = new THREE.DirectionalLight(0xffffff, .7);
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
							var jointcolor= document.getElementById('jointcolor').value;
							if(jointcolor.length >= 1){
								
								while(jointcolor.charAt(0) === '#'){
									jointcolor = jointcolor.substr(1);
								}
								jointcolor = "0x"+jointcolor;
								
							}
							var bodycolor= document.getElementById('bodycolor').value;
							
							if(bodycolor.length >= 1){
								while(bodycolor.charAt(0) === '#'){
									bodycolor = bodycolor.substr(1);
								}
								bodycolor = "0x"+bodycolor;
							}
							
							camera.translateZ( - 0.8 );
							
							for(var i = 0 ; i< joints.length; i++){
								
								joints[i].material.specular = jointmat.specular;
								joints[i].position.z+=0.8;
								joints[i].position.y-=0.15;
								joints[i].position.x+=0.134;
								joints[i].material.shininess = jointmat.shininess;
								joints[i].material.map = null;	
								joints[i].material.reflectivity = jointmat.reflectivity;
								
								if(joints[i].material.map == null ){
									
									if(jointcolor !="" ){
										joints[i].material.color.setHex(jointcolor);
									}
									else{
										joints[i].material.color.setHex(0xffffff);
									}
								}
							}
							
							for(var i = 0 ; i< body.length; i++){
								body[i].position.z+=0.8;	
								body[i].position.y-=0.15;
								body[i].position.x+=0.134;
								
								body[i].material.color.setHex(0xffffff);
								body[i].material.specular = jointmat.specular;
								body[i].material.reflectivity = jointmat.reflectivity;
								body[i].material.shininess = jointmat.shininess;
								body[i].material.map = null;	
								body[i].material.reflectivity = jointmat.reflectivity;
							}
							
							<?php 	echo 'var userid = "'.$row["user_id"].'";'; ?>
							<?php 	echo 'var postid = "'.$row["id"].'";'; ?>	
							
							var filesrc = 'uploads/'+userid+'/'+postid+'/';
							
							var tgaloader = new THREE.TGALoader();
							var texturecounter = 0; 
							
							<?php 
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/head.'.$row["headtexture"]))
								{
									if($row["headtexture"]=="tga"){
										echo 'var headtexturesrc = filesrc+"head.tga";';
										echo 'var headtexture = tgaloader.load(headtexturesrc);';
										}else{
										echo 'var headtexturesrc = filesrc+"head.jpg";';
										echo 'var headtexture = new THREE.TextureLoader().load(headtexturesrc);';
									}
									echo 'headtexture.magFilter = THREE.NearestFilter;';
									echo 'headtexture.minFilter = THREE.NearestFilter;';
									echo 'head.material.map = headtexture;';
									
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/groin.'.$row["grointexture"]))
								{
									if($row["grointexture"]=="tga"){
										echo 'var grointexturesrc = filesrc+"groin.tga";';
										echo 'var grointexture = tgaloader.load(grointexturesrc);';
										}else{
										echo 'var grointexturesrc = filesrc+"groin.jpg";';
										echo 'var grointexture = new THREE.TextureLoader().load(grointexturesrc);';
									}
									echo 'grointexture.magFilter = THREE.NearestFilter;';
									echo 'grointexture.minFilter = THREE.NearestFilter;';
									echo 'groin.material.map = grointexture;';
									}else{
									echo'texturecounter++; ';
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/r_thigh.'.$row["r_thightexture"]))
								{
									if($row["r_thightexture"]=="tga"){
										echo 'var r_thightexturesrc = filesrc+"r_thigh.tga";';
										echo 'var r_thightexture = tgaloader.load(r_thightexturesrc);';
										}else{
										echo 'var r_thightexturesrc = filesrc+"r_thigh.jpg";';
										echo 'var r_thightexture = new THREE.TextureLoader().load(r_thightexturesrc);';
									}
									echo 'r_thightexture.magFilter = THREE.NearestFilter;';
									echo 'r_thightexture.minFilter = THREE.NearestFilter;';
									echo 'r_thigh.material.map = r_thightexture;';
									
									}else{
									echo'texturecounter++; ';
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/r_leg.'.$row["r_legtexture"]))
								{
									if($row["r_legtexture"]=="tga"){
										echo 'var r_legtexturesrc = filesrc+"r_leg.tga";';
										echo 'var r_legtexture = tgaloader.load(r_legtexturesrc);';
										}else{
										echo 'var r_legtexturesrc = filesrc+"r_leg.jpg";';
										echo 'var r_legtexture = new THREE.TextureLoader().load(r_legtexturesrc);';
									}
									echo 'r_legtexture.magFilter = THREE.NearestFilter;';
									echo 'r_legtexture.minFilter = THREE.NearestFilter;';
									echo 'r_leg.material.map = r_legtexture;';
									
									}else{
									echo'texturecounter++; ';
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/r_foot.'.$row["r_foottexture"]))
								{
									if($row["r_foottexture"]=="tga"){
										echo 'var r_foottexturesrc = filesrc+"r_foot.tga";';
										echo 'var r_foottexture = tgaloader.load(r_foottexturesrc);';
										}else{
										echo 'var r_foottexturesrc = filesrc+"r_foot.jpg";';
										echo 'var r_foottexture = new THREE.TextureLoader().load(r_foottexturesrc);';
									}
									echo 'r_foottexture.magFilter = THREE.NearestFilter;';
									echo 'r_foottexture.minFilter = THREE.NearestFilter;';
									echo 'r_foot.material.map = r_foottexture;';
									
									}else{
									echo'texturecounter++; ';
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/l_foot.'.$row["l_foottexture"]))
								{
									if($row["l_foottexture"]=="tga"){
										echo 'var l_foottexturesrc = filesrc+"l_foot.tga";';
										echo 'var l_foottexture = tgaloader.load(l_foottexturesrc);';
										}else{
										echo 'var l_foottexturesrc = filesrc+"l_foot.jpg";';
										echo 'var l_foottexture = new THREE.TextureLoader().load(l_foottexturesrc);';
									}
									echo 'l_foottexture.magFilter = THREE.NearestFilter;';
									echo 'l_foottexture.minFilter = THREE.NearestFilter;';
									echo 'l_foot.material.map = l_foottexture;';
									
									}else{
									echo'texturecounter++; ';
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/l_leg.'.$row["l_legtexture"]))
								{
									if($row["l_legtexture"]=="tga"){
										echo 'var l_legtexturesrc = filesrc+"l_leg.tga";';
										echo 'var l_legtexture = tgaloader.load(l_legtexturesrc);';
										}else{
										echo 'var l_legtexturesrc = filesrc+"l_leg.jpg";';
										echo 'var l_legtexture = new THREE.TextureLoader().load(l_legtexturesrc);';
									}
									echo 'l_legtexture.magFilter = THREE.NearestFilter;';
									echo 'l_legtexture.minFilter = THREE.NearestFilter;';
									echo 'l_leg.material.map = l_legtexture;';
									
									}else{
									echo'texturecounter++; ';
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/l_thigh.'.$row["l_thightexture"]))
								{
									if($row["l_thightexture"]=="tga"){
										echo 'var l_thightexturesrc = filesrc+"l_thigh.tga";';
										echo 'var l_thightexture = tgaloader.load(l_thightexturesrc);';
										}else{
										echo 'var l_thightexturesrc = filesrc+"l_thigh.jpg";';
										echo 'var l_thightexture = new THREE.TextureLoader().load(l_thightexturesrc);';
									}
									echo 'l_thightexture.magFilter = THREE.NearestFilter;';
									echo 'l_thightexture.minFilter = THREE.NearestFilter;';
									echo 'l_thigh.material.map = l_thightexture;';
									
									}else{
									echo'texturecounter++; ';
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/r_hand.'.$row["r_handtexture"]))
								{
									if($row["r_handtexture"]=="tga"){
										echo 'var r_handtexturesrc = filesrc+"r_hand.tga";';
										echo 'var r_handtexture = tgaloader.load(r_handtexturesrc);';
										}else{
										echo 'var r_handtexturesrc = filesrc+"r_hand.jpg";';
										echo 'var r_handtexture = new THREE.TextureLoader().load(r_handtexturesrc);';
									}
									echo 'r_handtexture.magFilter = THREE.NearestFilter;';
									echo 'r_handtexture.minFilter = THREE.NearestFilter;';
									echo 'r_hand.material.map = r_handtexture;';
									
									}else{
									echo'texturecounter++; ';
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/r_triceps.'.$row["r_tricepstexture"]))
								{
									if($row["r_tricepstexture"]=="tga"){
										echo 'var r_tricepstexturesrc = filesrc+"r_triceps.tga";';
										echo 'var r_tricepstexture = tgaloader.load(r_tricepstexturesrc);';
										}else{
										echo 'var r_tricepstexturesrc = filesrc+"r_triceps.jpg";';
										echo 'var r_tricepstexture = new THREE.TextureLoader().load(r_tricepstexturesrc);';
									}
									echo 'r_tricepstexture.magFilter = THREE.NearestFilter;';
									echo 'r_tricepstexture.minFilter = THREE.NearestFilter;';
									echo 'r_triceps.material.map = r_tricepstexture;';
									
									}else{
									echo'texturecounter++; ';
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/r_biceps.'.$row["r_bicepstexture"]))
								{
									if($row["r_bicepstexture"]=="tga"){
										echo 'var r_bicepstexturesrc = filesrc+"r_biceps.tga";';
										echo 'var r_bicepstexture = tgaloader.load(r_bicepstexturesrc);';
										}else{
										echo 'var r_bicepstexturesrc = filesrc+"r_biceps.jpg";';
										echo 'var r_bicepstexture = new THREE.TextureLoader().load(r_bicepstexturesrc);';
									}
									echo 'r_bicepstexture.magFilter = THREE.NearestFilter;';
									echo 'r_bicepstexture.minFilter = THREE.NearestFilter;';
									echo 'r_biceps.material.map = r_bicepstexture;';
									
									}else{
									echo'texturecounter++; ';
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/r_shoulder.'.$row["r_shouldertexture"]))
								{
									if($row["r_shouldertexture"]=="tga"){
										echo 'var r_shouldertexturesrc = filesrc+"r_shoulder.tga";';
										echo 'var r_shouldertexture = tgaloader.load(r_shouldertexturesrc);';
										}else{
										echo 'var r_shouldertexturesrc = filesrc+"r_shoulder.jpg";';
										echo 'var r_shouldertexture = new THREE.TextureLoader().load(r_shouldertexturesrc);';
									}
									echo 'r_shouldertexture.magFilter = THREE.NearestFilter;';
									echo 'r_shouldertexture.minFilter = THREE.NearestFilter;';
									echo 'r_shoulder.material.map = r_shouldertexture;';
									
									}else{
									echo'texturecounter++; ';
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/stomach.'.$row["stomachtexture"]))
								{
									if($row["stomachtexture"]=="tga"){
										echo 'var stomachtexturesrc = filesrc+"stomach.tga";';
										echo 'var stomachtexture = tgaloader.load(stomachtexturesrc);';
										}else{
										echo 'var stomachtexturesrc = filesrc+"stomach.jpg";';
										echo 'var stomachtexture = new THREE.TextureLoader().load(stomachtexturesrc);';
									}
									echo 'stomachtexture.magFilter = THREE.NearestFilter;';
									echo 'stomachtexture.minFilter = THREE.NearestFilter;';
									echo 'stomach.material.map = stomachtexture;';
									
									}else{
									echo'texturecounter++; ';
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/chest.'.$row["chesttexture"]))
								{
									if($row["chesttexture"]=="tga"){
										echo 'var chesttexturesrc = filesrc+"chest.tga";';
										echo 'var chesttexture = tgaloader.load(chesttexturesrc);';
										}else{
										echo 'var chesttexturesrc = filesrc+"chest.jpg";';
										echo 'var chesttexture = new THREE.TextureLoader().load(chesttexturesrc);';
									}
									echo 'chesttexture.magFilter = THREE.NearestFilter;';
									echo 'chesttexture.minFilter = THREE.NearestFilter;';
									echo 'chest.material.map = chesttexture;';
									
									}else{
									echo'texturecounter++; ';
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/breast.'.$row["breasttexture"]))
								{
									if($row["breasttexture"]=="tga"){
										echo 'var breasttexturesrc = filesrc+"breast.tga";';
										echo 'var breasttexture = tgaloader.load(breasttexturesrc);';
										}else{
										echo 'var breasttexturesrc = filesrc+"breast.jpg";';
										echo 'var breasttexture = new THREE.TextureLoader().load(breasttexturesrc);';
									}
									echo 'breasttexture.magFilter = THREE.NearestFilter;';
									echo 'breasttexture.minFilter = THREE.NearestFilter;';
									echo 'breast.material.map = breasttexture;';
									
									}else{
									echo'texturecounter++; ';
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/r_pecs.'.$row["r_pecstexture"]))
								{
									if($row["r_pecstexture"]=="tga"){
										echo 'var r_pecstexturesrc = filesrc+"r_pecs.tga";';
										echo 'var r_pecstexture = tgaloader.load(r_pecstexturesrc);';
										}else{
										echo 'var r_pecstexturesrc = filesrc+"r_pecs.jpg";';
										echo 'var r_pecstexture = new THREE.TextureLoader().load(r_pecstexturesrc);';
									}
									echo 'r_pecstexture.magFilter = THREE.NearestFilter;';
									echo 'r_pecstexture.minFilter = THREE.NearestFilter;';
									echo 'r_pecs.material.map = r_pecstexture;';
									
									}else{
									echo'texturecounter++; ';
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/l_hand.'.$row["l_handtexture"]))
								{
									if($row["l_handtexture"]=="tga"){
										echo 'var l_handtexturesrc = filesrc+"l_hand.tga";';
										echo 'var l_handtexture = tgaloader.load(l_handtexturesrc);';
										}else{
										echo 'var l_handtexturesrc = filesrc+"l_hand.jpg";';
										echo 'var l_handtexture = new THREE.TextureLoader().load(l_handtexturesrc);';
									}
									echo 'l_handtexture.magFilter = THREE.NearestFilter;';
									echo 'l_handtexture.minFilter = THREE.NearestFilter;';
									echo 'l_hand.material.map = l_handtexture;';
									
									}else{
									echo'texturecounter++; ';
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/l_triceps.'.$row["l_tricepstexture"]))
								{
									if($row["l_tricepstexture"]=="tga"){
										echo 'var l_tricepstexturesrc = filesrc+"l_triceps.tga";';
										echo 'var l_tricepstexture = tgaloader.load(l_tricepstexturesrc);';
										}else{
										echo 'var l_tricepstexturesrc = filesrc+"l_triceps.jpg";';
										echo 'var l_tricepstexture = new THREE.TextureLoader().load(l_tricepstexturesrc);';
									}
									echo 'l_tricepstexture.magFilter = THREE.NearestFilter;';
									echo 'l_tricepstexture.minFilter = THREE.NearestFilter;';
									echo 'l_triceps.material.map = l_tricepstexture;';
									
									}else{
									echo'texturecounter++; ';
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/l_biceps.'.$row["l_bicepstexture"]))
								{
									if($row["l_bicepstexture"]=="tga"){
										echo 'var l_bicepstexturesrc = filesrc+"l_biceps.tga";';
										echo 'var l_bicepstexture = tgaloader.load(l_bicepstexturesrc);';
										}else{
										echo 'var l_bicepstexturesrc = filesrc+"l_biceps.jpg";';
										echo 'var l_bicepstexture = new THREE.TextureLoader().load(l_bicepstexturesrc);';
									}
									echo 'l_bicepstexture.magFilter = THREE.NearestFilter;';
									echo 'l_bicepstexture.minFilter = THREE.NearestFilter;';
									echo 'l_biceps.material.map = l_bicepstexture;';
									
									}else{
									echo'texturecounter++; ';
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/l_shoulder.'.$row["l_shouldertexture"]))
								{
									if($row["l_shouldertexture"]=="tga"){
										echo 'var l_shouldertexturesrc = filesrc+"l_shoulder.tga";';
										echo 'var l_shouldertexture = tgaloader.load(l_shouldertexturesrc);';
										}else{
										echo 'var l_shouldertexturesrc = filesrc+"l_shoulder.jpg";';
										echo 'var l_shouldertexture = new THREE.TextureLoader().load(l_shouldertexturesrc);';
									}
									echo 'l_shouldertexture.magFilter = THREE.NearestFilter;';
									echo 'l_shouldertexture.minFilter = THREE.NearestFilter;';
									echo 'l_shoulder.material.map = l_shouldertexture;';
									
									}else{
									echo'texturecounter++; ';
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/l_pecs.'.$row["l_pecstexture"]))
								{
									if($row["l_pecstexture"]=="tga"){
										echo 'var l_pecstexturesrc = filesrc+"l_pecs.tga";';
										echo 'var l_pecstexture = tgaloader.load(l_pecstexturesrc);';
										}else{
										echo 'var l_pecstexturesrc = filesrc+"l_pecs.jpg";';
										echo 'var l_pecstexture = new THREE.TextureLoader().load(l_pecstexturesrc);';
									}
									echo 'l_pecstexture.magFilter = THREE.NearestFilter;';
									echo 'l_pecstexture.minFilter = THREE.NearestFilter;';
									echo 'l_pecs.material.map = l_pecstexture;';
									
									}else{
									echo'texturecounter++; ';
								}
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/r_knee.'.$row["r_kneetexture"]))
								{
									if($row["r_kneetexture"]=="tga"){
										echo 'var r_kneetexturesrc = filesrc+"r_knee.tga";';
										echo 'var r_kneetexture = tgaloader.load(r_kneetexturesrc);';
										}else{
										echo 'var r_kneetexturesrc = filesrc+"r_knee.jpg";';
										echo 'var r_kneetexture = new THREE.TextureLoader().load(r_kneetexturesrc);';
									}
									echo 'r_kneetexture.magFilter = THREE.NearestFilter;';
									echo 'r_kneetexture.minFilter = THREE.NearestFilter;';
									echo 'r_knee.material.map = r_kneetexture;';
									
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/l_knee.'.$row["l_kneetexture"]))
								{
									if($row["l_kneetexture"]=="tga"){
										echo 'var l_kneetexturesrc = filesrc+"l_knee.tga";';
										echo 'var l_kneetexture = tgaloader.load(l_kneetexturesrc);';
										}else{
										echo 'var l_kneetexturesrc = filesrc+"l_knee.jpg";';
										echo 'var l_kneetexture = new THREE.TextureLoader().load(l_kneetexturesrc);';
									}
									echo 'l_kneetexture.magFilter = THREE.NearestFilter;';
									echo 'l_kneetexture.minFilter = THREE.NearestFilter;';
									echo 'l_knee.material.map = l_kneetexture;';
									
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/l_glute.'.$row["l_glutetexture"]))
								{
									if($row["l_glutetexture"]=="tga"){
										echo 'var l_glutetexturesrc = filesrc+"l_glute.tga";';
										echo 'var l_glutetexture = tgaloader.load(l_glutetexturesrc);';
										}else{
										echo 'var l_glutetexturesrc = filesrc+"l_glute.jpg";';
										echo 'var l_glutetexture = new THREE.TextureLoader().load(l_glutetexturesrc);';
									}
									echo 'l_glutetexture.magFilter = THREE.NearestFilter;';
									echo 'l_glutetexture.minFilter = THREE.NearestFilter;';
									echo 'l_glute.material.map = l_glutetexture;';
									
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/l_hip.'.$row["l_hiptexture"]))
								{
									if($row["l_hiptexture"]=="tga"){
										echo 'var l_hiptexturesrc = filesrc+"l_hip.tga";';
										echo 'var l_hiptexture = tgaloader.load(l_hiptexturesrc);';
										}else{
										echo 'var l_hiptexturesrc = filesrc+"l_hip.jpg";';
										echo 'var l_hiptexture = new THREE.TextureLoader().load(l_hiptexturesrc);';
									}
									echo 'l_hiptexture.magFilter = THREE.NearestFilter;';
									echo 'l_hiptexture.minFilter = THREE.NearestFilter;';
									echo 'l_hip.material.map = l_hiptexture;';
									
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/r_hip.'.$row["r_hiptexture"]))
								{
									if($row["r_hiptexture"]=="tga"){
										echo 'var r_hiptexturesrc = filesrc+"r_hip.tga";';
										echo 'var r_hiptexture = tgaloader.load(r_hiptexturesrc);';
										}else{
										echo 'var r_hiptexturesrc = filesrc+"r_hip.jpg";';
										echo 'var r_hiptexture = new THREE.TextureLoader().load(r_hiptexturesrc);';
									}
									echo 'r_hiptexture.magFilter = THREE.NearestFilter;';
									echo 'r_hiptexture.minFilter = THREE.NearestFilter;';
									echo 'r_hip.material.map = r_hiptexture;';
									
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/r_glute.'.$row["r_glutetexture"]))
								{
									if($row["r_glutetexture"]=="tga"){
										echo 'var r_glutetexturesrc = filesrc+"r_glute.tga";';
										echo 'var r_glutetexture = tgaloader.load(r_glutetexturesrc);';
										}else{
										echo 'var r_glutetexturesrc = filesrc+"r_glute.jpg";';
										echo 'var r_glutetexture = new THREE.TextureLoader().load(r_glutetexturesrc);';
									}
									echo 'r_glutetexture.magFilter = THREE.NearestFilter;';
									echo 'r_glutetexture.minFilter = THREE.NearestFilter;';
									echo 'r_glute.material.map = r_glutetexture;';
									
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/l_wrist.'.$row["l_wristtexture"]))
								{
									if($row["l_wristtexture"]=="tga"){
										echo 'var l_wristtexturesrc = filesrc+"l_wrist.tga";';
										echo 'var l_wristtexture = tgaloader.load(l_wristtexturesrc);';
										}else{
										echo 'var l_wristtexturesrc = filesrc+"l_wrist.jpg";';
										echo 'var l_wristtexture = new THREE.TextureLoader().load(l_wristtexturesrc);';
									}
									echo 'l_wristtexture.magFilter = THREE.NearestFilter;';
									echo 'l_wristtexture.minFilter = THREE.NearestFilter;';
									echo 'l_wrist.material.map = l_wristtexture;';
									
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/r_wrist.'.$row["r_wristtexture"]))
								{
									if($row["r_wristtexture"]=="tga"){
										echo 'var r_wristtexturesrc = filesrc+"r_wrist.tga";';
										echo 'var r_wristtexture = tgaloader.load(r_wristtexturesrc);';
										}else{
										echo 'var r_wristtexturesrc = filesrc+"r_wrist.jpg";';
										echo 'var r_wristtexture = new THREE.TextureLoader().load(r_wristtexturesrc);';
									}
									echo 'r_wristtexture.magFilter = THREE.NearestFilter;';
									echo 'r_wristtexture.minFilter = THREE.NearestFilter;';
									echo 'r_wrist.material.map = r_wristtexture;';
									
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/l_elbow.'.$row["l_elbowtexture"]))
								{
									if($row["l_elbowtexture"]=="tga"){
										echo 'var l_elbowtexturesrc = filesrc+"l_elbow.tga";';
										echo 'var l_elbowtexture = tgaloader.load(l_elbowtexturesrc);';
										}else{
										echo 'var l_elbowtexturesrc = filesrc+"l_elbow.jpg";';
										echo 'var l_elbowtexture = new THREE.TextureLoader().load(l_elbowtexturesrc);';
									}
									echo 'l_elbowtexture.magFilter = THREE.NearestFilter;';
									echo 'l_elbowtexture.minFilter = THREE.NearestFilter;';
									echo 'l_elbow.material.map = l_elbowtexture;';
									
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/l_shoulder.'.$row["l_shouldertexture"]))
								{
									if($row["l_shouldertexture"]=="tga"){
										echo 'var l_shouldertexturesrc = filesrc+"l_shoulder.tga";';
										echo 'var l_shouldertexture = tgaloader.load(l_shouldertexturesrc);';
										}else{
										echo 'var l_shouldertexturesrc = filesrc+"l_shoulder.jpg";';
										echo 'var l_shouldertexture = new THREE.TextureLoader().load(l_shouldertexturesrc);';
									}
									echo 'l_shouldertexture.magFilter = THREE.NearestFilter;';
									echo 'l_shouldertexture.minFilter = THREE.NearestFilter;';
									echo 'l_shoulder.material.map = l_shouldertexture;';
									
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/l_pec.'.$row["l_pectexture"]))
								{
									if($row["l_pectexture"]=="tga"){
										echo 'var l_pectexturesrc = filesrc+"l_pec.tga";';
										echo 'var l_pectexture = tgaloader.load(l_pectexturesrc);';
										}else{
										echo 'var l_pectexturesrc = filesrc+"l_pec.jpg";';
										echo 'var l_pectexture = new THREE.TextureLoader().load(l_pectexturesrc);';
									}
									echo 'l_pectexture.magFilter = THREE.NearestFilter;';
									echo 'l_pectexture.minFilter = THREE.NearestFilter;';
									echo 'l_pec.material.map = l_pectexture;';
									
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/r_elbow.'.$row["r_elbowtexture"]))
								{
									if($row["r_elbowtexture"]=="tga"){
										echo 'var r_elbowtexturesrc = filesrc+"r_elbow.tga";';
										echo 'var r_elbowtexture = tgaloader.load(r_elbowtexturesrc);';
										}else{
										echo 'var r_elbowtexturesrc = filesrc+"r_elbow.jpg";';
										echo 'var r_elbowtexture = new THREE.TextureLoader().load(r_elbowtexturesrc);';
									}
									echo 'r_elbowtexture.magFilter = THREE.NearestFilter;';
									echo 'r_elbowtexture.minFilter = THREE.NearestFilter;';
									echo 'r_elbow.material.map = r_elbowtexture;';
									
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/r_shoulder.'.$row["r_shouldertexture"]))
								{
									if($row["r_shouldertexture"]=="tga"){
										echo 'var r_shouldertexturesrc = filesrc+"r_shoulder.tga";';
										echo 'var r_shouldertexture = tgaloader.load(r_shouldertexturesrc);';
										}else{
										echo 'var r_shouldertexturesrc = filesrc+"r_shoulder.jpg";';
										echo 'var r_shouldertexture = new THREE.TextureLoader().load(r_shouldertexturesrc);';
									}
									echo 'r_shouldertexture.magFilter = THREE.NearestFilter;';
									echo 'r_shouldertexture.minFilter = THREE.NearestFilter;';
									echo 'r_shoulder.material.map = r_shouldertexture;';
									
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/r_pec.'.$row["r_pectexture"]))
								{
									if($row["r_pectexture"]=="tga"){
										echo 'var r_pectexturesrc = filesrc+"r_pec.tga";';
										echo 'var r_pectexture = tgaloader.load(r_pectexturesrc);';
										}else{
										echo 'var r_pectexturesrc = filesrc+"r_pec.jpg";';
										echo 'var r_pectexture = new THREE.TextureLoader().load(r_pectexturesrc);';
									}
									echo 'r_pectexture.magFilter = THREE.NearestFilter;';
									echo 'r_pectexture.minFilter = THREE.NearestFilter;';
									echo 'r_pec.material.map = r_pectexture;';
									
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/abs.'.$row["abstexture"]))
								{
									if($row["abstexture"]=="tga"){
										echo 'var abstexturesrc = filesrc+"abs.tga";';
										echo 'var abstexture = tgaloader.load(abstexturesrc);';
										}else{
										echo 'var abstexturesrc = filesrc+"abs.jpg";';
										echo 'var abstexture = new THREE.TextureLoader().load(abstexturesrc);';
									}
									echo 'abstexture.magFilter = THREE.NearestFilter;';
									echo 'abstexture.minFilter = THREE.NearestFilter;';
									echo 'abs.material.map = abstexture;';
									
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/lumbar.'.$row["lumbartexture"]))
								{
									if($row["lumbartexture"]=="tga"){
										echo 'var lumbartexturesrc = filesrc+"lumbar.tga";';
										echo 'var lumbartexture = tgaloader.load(lumbartexturesrc);';
										}else{
										echo 'var lumbartexturesrc = filesrc+"lumbar.jpg";';
										echo 'var lumbartexture = new THREE.TextureLoader().load(lumbartexturesrc);';
									}
									echo 'lumbartexture.magFilter = THREE.NearestFilter;';
									echo 'lumbartexture.minFilter = THREE.NearestFilter;';
									echo 'lumbar.material.map = lumbartexture;';
									
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/chestJoint.'.$row["chestjointtexture"]))
								{
									
									if($row["chestjointtexture"]=="tga"){
										
										echo 'var chestJointtexturesrc = filesrc+"chestJoint.tga";';
										echo 'var chestJointtexture = tgaloader.load(chestJointtexturesrc);';
										}else{
										echo 'var chestJointtexturesrc = filesrc+"chestJoint.jpg";';
										echo 'var chestJointtexture = new THREE.TextureLoader().load(chestJointtexturesrc);';
									}
									echo 'chestJointtexture.magFilter = THREE.NearestFilter;';
									echo 'chestJointtexture.minFilter = THREE.NearestFilter;';
									echo 'chestJoint.material.map = chestJointtexture;';
									
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/neck.'.$row["necktexture"]))
								{
									if($row["necktexture"]=="tga"){
										echo 'var necktexturesrc = filesrc+"neck.tga";';
										echo 'var necktexture = tgaloader.load(necktexturesrc);';
										}else{
										echo 'var necktexturesrc = filesrc+"neck.jpg";';
										echo 'var necktexture = new THREE.TextureLoader().load(necktexturesrc);';
									}
									echo 'necktexture.magFilter = THREE.NearestFilter;';
									echo 'necktexture.minFilter = THREE.NearestFilter;';
									echo 'neck.material.map = necktexture;';
									
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/l_ankle.'.$row["l_ankletexture"]))
								{
									if($row["l_ankletexture"]=="tga"){
										echo 'var l_ankletexturesrc = filesrc+"l_ankle.tga";';
										echo 'var l_ankletexture = tgaloader.load(l_ankletexturesrc);';
										}else{
										echo 'var l_ankletexturesrc = filesrc+"l_ankle.jpg";';
										echo 'var l_ankletexture = new THREE.TextureLoader().load(l_ankletexturesrc);';
									}
									echo 'l_ankletexture.magFilter = THREE.NearestFilter;';
									echo 'l_ankletexture.minFilter = THREE.NearestFilter;';
									echo 'l_ankle.material.map = l_ankletexture;';
									
								}
								
								if(file_exists('uploads/'.$row["user_id"].'/'.$row["id"].'/r_ankle.'.$row["r_ankletexture"]))
								{
									if($row["r_ankletexture"]=="tga"){
										echo 'var r_ankletexturesrc = filesrc+"r_ankle.tga";';
										echo 'var r_ankletexture = tgaloader.load(r_ankletexturesrc);';
										}else{
										echo 'var r_ankletexturesrc = filesrc+"r_ankle.jpg";';
										echo 'var r_ankletexture = new THREE.TextureLoader().load(r_ankletexturesrc);';
									}
									echo 'r_ankletexture.magFilter = THREE.NearestFilter;';
									echo 'r_ankletexture.minFilter = THREE.NearestFilter;';
									echo 'r_ankle.material.map = r_ankletexture;';
									
								}?>
								
								for(var i = 0 ; i< body.length; i++){
									if(body[i].material.map == null){
										if(bodycolor !="" ){
											body[i].material.color.setHex(bodycolor);
											
										}
										else{
											body[i].material.color.setHex(0xffffff);
											
										}
									}
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
						}
						
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
							headobj.material.color.setHex(0xffffff);
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
		