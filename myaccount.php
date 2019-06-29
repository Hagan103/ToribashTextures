<?php 
	include 'includes/session.php';
	
	if(isset($_POST['Submit'])){
		$username = $_POST['username'];
		$password=$_POST['password'];
		
		
		if (($username=="") || ($password=="")) {
			$loginerror = "fields are blank.";	
		}
		else
		{
			require_once('includes/config.php');
			
			$query =  $conn->prepare("SELECT * from users WHERE (Username = :username)");
			$query->bindValue(':username', $username);
			$query->execute();
			$result = $query->fetchAll();
			
			foreach ($result as $row) {    
				$salt = $row['Salt'];
				$password=$_POST['password'].$salt;
				$password = sha1($password);
			}
			
			$query =  $conn->prepare("SELECT * from users WHERE (Username = :username) AND (Password = :password)");
			$query->bindValue(':username', $username);
			$query->bindValue(':password', $password);
			$query->execute();
			$result = $query->fetchAll();
			
			foreach ($result as $row) 
			{    
				$username = $row['Username'];
				$email = $row['Email'];
				$user_id = $row['user_id'];
				$account_type= $row['Type'];
				$account_status= $row['Status'];
			}
			
			if ($query->rowCount() == 1) {
				if($account_status == "banned"){
					$loginerror = "That account is banned.";	
				}
				else{
					$_SESSION['Username'] = $username;
					$_SESSION['Email'] = $email;
					$_SESSION['user_id'] = $user_id;
					$_SESSION['account_type'] = $account_type;
				}
				} else {
				$loginerror = "username or password incorrect";	
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include 'links.php'; ?>
		<style>
			
			@import url(https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,400,700);
			html, body{
			}
			
			h1, h2, h3, h4, h5, h6{
			font-family: 'Open Sans Condensed', sans-serif, sans-serif;
			}
			
			.btn{
			margin-top:5px;
			border-radius:0;
			font-family: badaboom;
			margin-bottom:15px;
			letter-spacing: 2px;
			
			}
			
			.primary-bg{
			background-color:#F34336;
			color:#fff;
			}
			
			h3{
			margin-bottom:30px;
			}
			
			.primary-bg:hover, .primary-bg:focus{
			background-color:#F22C1E;
			color:#fff;
			}
			.secondary-bg{
			background-color:#20BFA9;
			color:#fff;
			}
			
			.secondary-bg:hover, secondary-bg:focus{
			background-color:#1CA996;
			color:#fff;
			}
			/* About
			============================================== */
			
			.about {
			background: url(http://rolyart.ro/wp-content/uploads/2016/07/bg.png) no-repeat top center;
			background-size: cover;
			background-color: rgba(255, 255, 255, 0.2);
			text-align: center;
			padding: 100px 0;
			border-top:1px solid #ddd;
			border-bottom:1px solid #ddd;
			}
			.about .fig-profile {
			max-width: 200px;
			margin: 0 auto 0;
			position: relative;
			overflow: hidden !important;
			margin-bottom: 30px;
			}
			.about .fig-profile:hover figcaption {
			opacity: 1;
			webkit-transition: all 0.3s ease-out;
			-moz-transition: all 0.3s ease-out;
			-o-transition: all 0.3s ease-out;
			transition: all 0.3s ease-out;
			background-color: #20BFA9;
			}
			.about .fig-profile figcaption {
			position: absolute;
			top: 0;
			width: 100%;
			border-radius: 50%;
			text-align: center;
			vertical-align: center;
			line-height: 180px;
			opacity: 0;
			font-family: 'Open Sans Condensed', sans-serif;
			transition: all 0.3s ease-out;
			color: #fff;
			font-size: 24px;
			}
			.about .name {
			font-size: 48px;
			text-transform: uppercase;
			margin: 20px 0 0 0;
			}
			
			.about .caption{
			font-size:16px;
			}
			.about .position {
			margin: 0;
			}
			.about .location {
			margin: 5px 0 20px 0;
			}
			.about .slogan {
			margin-bottom: 40px;
			margin-top: 40px;
			font-weight: 700;
			}
			.about p {
			font-size: 16px;
			}
			.flag {
			width: 39px;
			margin: 0 auto;
			}
			.flag .blue {
			background-color: #002B7F;
			width: 13px;
			height: 26px;
			float: right;
			}
			.flag .yellow {
			background-color: #FCD116;
			width: 13px;
			height: 26px;
			float: right;
			}
			.flag .red {
			background-color: #CE1126;
			width: 13px;
			height: 26px;
			float: right;
			}
			
			/* Title Divider
			============================================ */
			.title-divider {
			margin: 0 auto;
			max-width: 400px;
			margin-bottom: 20px;
			overflow: hidden;
			padding: 10px 0;
			}
			.hr-divider {
			border-bottom: 1px solid #ddd;
			position: relative;
			float: left;
			bottom: -4px;
			}
			.icon-separator {
			float: left;
			text-align: center;
			margin-top: -7px;
			font-size: 18px;
			color: #F34336;
			padding: 0;
			}
			.heading-divider {
			display: flex;
			}
			
			.heading-divider .title {
			flex-grow: 0;
			-webkit-flex-grow: 0;
			margin: 0 5px 0 0;
			line-height: 1px;
			}
			.heading-divider .line-separator {
			border-bottom: 1px solid #ddd;
			border-top: 1px solid #ddd;
			flex-grow: 1;
			-webkit-flex-grow: 1;
			height: 6px;
			position: relative;
			}
			
			.wrapper {
			width:100%;
			height:450px;
			overflow: hidden;
			background-color:#17191b;
			
			margin-top: 0px;
			margin-right: auto;
			margin-bottom: 0px;
			margin-left: auto;
			}
			
			#profilevid {
			object-fit: cover;
			width:80%;
			height:100%;
			margin: 0 auto;
			margin-left:9.5%;
			transform: translateY(100px);
			z-index: 997;
			}
			
			.wrapper h2 {
			font-family: badaboom;
			color:white;
			margin: 0;
			position: absolute;
			z-index: 2;
			font-size: 5vmin;
			top:20%;
			transform:translateY(-50%);
			width: 100%;
			text-align: center;
			text-transform: uppercase;
			letter-spacing: 3px;
			}
			
			.wrapper h4 {
			font-family: badaboom;
			color:white;
			margin: 0;
			position: absolute;
			z-index: 2;
			font-size: 3vmin;
			top:26%;
			transform:translateY(-50%);
			width: 100%;
			text-align: center;
			text-transform: uppercase;
			letter-spacing: 3px;
			}
			
			video::-webkit-media-controls {
			display:none !important;
			}
		</style>
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<?php
			if (!isset($_SESSION['Username']))
			{
			?>
			<div class="container topmargin">
				<h2> <span class="greytxt pageheading2 "> LOGIN OR CREATE AN ACCOUNT</span></h2>
				<div class="row">
				</div>
				<div class="col-md-6 formcol">
					<form class="form2">
						<h3> <span class="greytxt pageheading3"> Create an account</span></h3> 
						<hr>
						<a href="user_registration.php" class="btn btn-primary" role="button">Create an account</a>
					</form>
				</div>
				<div class="col-md-6 formcol">
					<form class="form2 form-horizontal"  method="post" name="form1">
						<h3> <span class="greytxt pageheading3">Login to an existing account </span></h3> 
						<div></div>
						<div class="form-group">
							<label for="username" class="col-sm-3 col-form-label">Username: </label>
							<div class="col-sm-9">
								<input type="text" id="email" class="form-control" name="username">
							</div>
						</div>	
						<div class="form-group">
							<label for="password" class="col-sm-3 col-form-label text-md-right">Password: </label>
							<div class="col-sm-9">
								<input name="password" type="password" id="password" size="20" maxlength="20" class="form-control">
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-4"><input class="btn btn-primary" type="submit" name="Submit" value="Login" ></div>
							<div class="col-sm-8 text-right"><a href="http://www.toribashtextures.com/forgotPassword.php">Forgot Password?</a></div>
						</div>	
					</form>
				</div>
			</div>
		</div>
		<?php 
		}
		else{
		?>
		<div class="wrapper">
			<?php 
				$query =  $con->prepare("SELECT * from users WHERE (Username = :username)");
				$query->bindValue(':username', $_SESSION['Username']);
				$query->execute();
				$result = $query->fetchAll();
				
				foreach ($result as $row) 
				{    
					$usernameSpecChar = htmlspecialchars($row["Username"], ENT_QUOTES, 'UTF-8');
					$toribashUsernameSpecChar = htmlspecialchars($row["ToribashUsername"], ENT_QUOTES, 'UTF-8');
				?>
				<h2 class="name"><?php echo $usernameSpecChar; ?></</h2> 
				<h4 class="text-center location"><?php if($toribashUsernameSpecChar!=""){ echo "Known as ". $toribashUsernameSpecChar." on Toribash"; }?></h4>
			<?php } ?>
		</div>
		<ul class="nav nav-tabs navbar-inverse"  id="myNavbar">
			<li class="active"><a href="#home">My Textures</a></li>
			<li><a href="#menu1">Favourites</a></li>
		</ul>
		<div class="tab-content">
			<div id="home" class="tab-pane fade in active">
				<?php 
					$user = $_SESSION['Username'];
					$pdo= new PDO("mysql:host=toribashtexturescom.ipagemysql.com;dbname=tbshowcase", 'hagan', 'abc1234');
					$query = 'SELECT * FROM images WHERE artist = :user ORDER BY UploadDate DESC, id LIMIT 0, 15';
					$query = $pdo->prepare($query);
					$query->bindValue(':user', $user);
					$query->execute();
					$list = $query->fetchAll();
					
					echo"<ul class=\"rig\" style= 'background: -webkit-radial-gradient(center, ellipse cover, ".$brightenomplimentary." 0%,".$brightenomplimentary8." 100%); /* Chrome10-25,Safari5.1-6 *'>\n";
					
					foreach ($list as $rs) {
						echo" <li>\n";
						echo"<a class=\"rig-cell\" href='texture.php?id=".$rs["id"]."'   >\n";
						echo"<span class=\"rig-overlay\" style= \"background-image: url(".'uploads/'.$rs["user_id"].'/'.$rs["id"].'/thumb.jpg'."); \"></span>\n";
						echo"<div id='cellbgcolor' style='background-color:red;'> </div>";
						echo"<span class=\"rig-bg\" > </span>\n";
						echo"<span class=\"rig-text\"> ".$rs["title"]."</span>\n";
						echo"br/>";
						echo"<span class=\"rig-subtext\">".$rs["artist"]."<br/> Views:".$rs["views"]." </span>\n";
						echo" </a>\n";
						echo"</li>\n";
					}
					
					echo"</ul>\n";
				?>
			</div>
			<div id="menu1" class="tab-pane fade">
				<?php
					$userid = $_SESSION['user_id'];
					$query = 'select * from texture_favs f
					inner join images i
					on f.texture = i.id where f.user = :userid';
					$query = $pdo->prepare($query);
					$query->bindValue(':userid', $userid);
					$query->execute();
					$list = $query->fetchAll();
					
					echo"<ul class=\"rig\" style= 'background: -webkit-radial-gradient(center, ellipse cover, ".$brightenomplimentary." 0%,".$brightenomplimentary8." 100%); /* Chrome10-25,Safari5.1-6 *'>\n";
					
					foreach ($list as $rs) {
						echo" <li>\n";
						echo"<a class=\"rig-cell\" href='texture.php?id=".$rs["id"]."'   >\n";
						echo"<span class=\"rig-overlay\" style= \"background-image: url(".'uploads/'.$rs["user_id"].'/'.$rs["id"].'/thumb.jpg'."); \"></span>\n";
						echo"<div id='cellbgcolor' style='background-color:red;'> </div>";
						echo"<span class=\"rig-bg\" > </span>\n";
						echo"<span class=\"rig-text\"> ".$rs["title"]."</span>\n";
						echo"br/>";
						echo"<span class=\"rig-subtext\">".$rs["artist"]."<br/> Views:".$rs["views"]." </span>\n";
						echo" </a>\n";
						echo"</li>\n";
					}
					
					echo"</ul>\n";
				?>
				
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			$(".nav-tabs a").click(function(){
				$(this).tab('show');
			});
		});
	</script>
	<?php	
	}
?>
</body>
</html>
