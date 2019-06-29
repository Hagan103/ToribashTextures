<?php
	include 'include/session.php';
		
	require_once('includes/config.php');

	$iserror = false;
	
	if(isset($_POST['Submit'])){
		
		$username=$_POST['username'];
		$email=$_POST['email'];
		$password=$_POST['password'];
		$repassword=$_POST['repassword'];
		$toribashusername=$_POST['toribashusername'];
		
		$qry =  $conn->prepare("select * from users WHERE Email = :email");
		$qry->bindValue(':email', $email);
		$qry->execute();
		$result = $qry->fetchAll();
		
		if ($qry->rowCount() > 0) {
			$iserror = true;
			$errormsg ="An account has already been registered with this email adress.";
		}
		else{
			$qry =  $conn->prepare("select * from users WHERE Username = :username");
			$qry->bindValue(':username', $username);
			$qry->execute();
			$result = $qry->fetchAll();
			
			if ($qry->rowCount() > 0) {
				$iserror = true;
				$errormsg ="Username already exists";
			}
			elseif (($username == "") or ($email == "")or ($password == ""))
			{
				$iserror = true;
				$errormsg ="Required Field(s) missing";
			}
			elseif  (!(strstr($email, "@")) or !(strstr($email, ".")))
			{
				$iserror = true;
				$errormsg ="Invalid Email";
			}
			elseif ($password != $repassword)
			{
				$iserror = true;
				
				$errormsg ="Password Miss Match...!!!! Go back and Try again...!!!!.";
			}
			else
			{
				$salt =  mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
				$password=$_POST['password'].$salt;
				$password = sha1($password);
				
				$qry =  $conn->prepare("insert into users (Username, Email,ToribashUsername, Password, JoinDate, Salt,Status,Type) values (:username,:email,:toribashusername,:password,CURDATE(),:salt,:status,:type)");
				$qry->bindValue(':username', $username);
				$qry->bindValue(':email', $email);
				$qry->bindValue(':toribashusername', $toribashusername);
				$qry->bindValue(':password', $password);
				$qry->bindValue(':salt', $salt);
				$qry->bindValue(':status', "safe");
				$qry->bindValue(':type', "1");
				
				$qry->execute();
				$qry->fetchAll();
				
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
					
					$regisuccess = true;
					
					$_SESSION['Username'] = $username;
					$_SESSION['Email'] = $email;
					$_SESSION['user_id'] = $user_id;
					$_SESSION['account_type'] = $account_type;
				}
			}
		}
	}
?>

<!DOCTYPE html PUBLIC >
<html>
	<head>
		<title>Toribash Textures</title>
		<?php include 'includes/links.php'; ?>
		<style>
			div.scroll {
			height:250px;
			overflow: scroll;
			margin: 0 auto; 
			overflow-x: hidden;
			background:#f2f2f2;
			text-align: left;
			margin-bottom:30px;
			margin-top:20px;
			width:80%;
			}
			
			.formcol{
			width:100%;
			text-align: center;
			padding:25px;;
			box-shadow: 0px 0px 14px 2px rgba(0,0,0,0.35);
			}
			
			.formcol form{
			margin: 0 auto; 
			display: inline-block;
			width:100%;
			}	
			
			.formcol form label{
			text-align: right;
			}
			
			.formcol form input[type=submit]{
			padding: 12px 30px;
			}
			
			.btn{
			border-radius:0;
			font-family: badaboom;
			margin-bottom:15px;
			letter-spacing: 2px;
			}
			
			.primary-bg{
			background-color:#F34336;
			color:#fff;
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
		</style>
	</head>
	
	<body>
		<?php include 'includes/header.php'; ?>
		<?php if (isset($_SESSION['Username']) && $regisuccess == false){?>
			<div class="container topmargin">
				<div class="alert alert-danger">
					<strong></strong> Please logout from your account if you wish to create another.
				</div>
			</div>
			<?php }elseif($regisuccess == true){
			?>
			<div class="container topmargin">
				<div class="alert alert-success">
					<?php
						echo "<p> <b>User registration successfull. </p>";
						echo "<p> <b>Thank you for registrating with ToribashTextures.com.</p>";
						echo"<p> Click <a href=upload.php>here</a> to upload your texture now </b></p>";
					?>
				</div>
			</div>
			<?php
			}else{ ?>
			<div class="container topmargin">
				<h2> <span class="greytxt pageheading2"> Toribash Textures Registration </span></h2>
				<?php if ($iserror == true){ ?>
					<div class="alert alert-danger">
						<?php echo $errormsg; ?>
					</div>
				<?php } ?>
				<div class="col-md-6 formcol">
					<form name="form1" method="post">
						<div class="form-group row">
							<label for="username" class="col-md-4 col-form-label text-md-right">Username</label>
							<div class="col-md-6">
								<input type="text" id="username" class="form-control" name="username" required autofocus>
							</div>
						</div>
						<div class="form-group row">
							<label for="toribashusername" class="col-md-4 col-form-label text-md-right">Toribash Username (Optional)</label>
							<div class="col-md-6">
								<input type="text" id="toribashusername" class="form-control" name="toribashusername">
							</div>
						</div>
						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
							<div class="col-md-6">
								<input type="text" id="email" class="form-control" name="email" required autofocus>
							</div>
						</div>
						<div class="form-group row">
							<label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
							<div class="col-md-6">
								<input type="password" id="password" class="form-control" name="password" required autofocus>
							</div>
						</div>
						<div class="form-group row">
							<label for="repassword" class="col-md-4 col-form-label text-md-right">Re-type Password </label>
							<div class="col-md-6">
								<input type="password" id="repassword" class="form-control" name="repassword" required autofocus>
							</div>
						</div>
						<div class="scroll">
							<p><span style="font-size: 14pt;">Toribash Textures Terms of Service</span></p>
							<p><strong>1. Acceptance Of Terms</strong></p>
							<p>Toribash Textures provides this free service to you, subject to the following Terms of Service, which may be updated by staff at any time without obligation to notify the users. The TOS (Terms of Service) will always be viewable from the registration page.&nbsp;</p>
							<p><br /><strong>2. Account Security</strong></p>
							<p>You are responsible for maintaining the confidentiality and security of the password and account, and assume all responsibility for all actions that occur under your password or account. You agree to never make your password available to any other user.</p>
							<p>&nbsp;</p>
							<p><strong>3. Member Conduct</strong></p>
							<p>All information, data, text, sound, photographs or other materials posted by other users are the sole responsibility of the person from whom that content originated. You understand that by using this service, you may be exposed to content that is offensive, indecent or objectionable. Toribash Textures cannot take any responsibility for the content that users post. Racism, illegal pornography, snuff material, warez, pirated software, and anything that is widely regarded as illegal is NOT allowed anywhere on any of our services. Failure to abide by these simple rules will result in termination of your account(s).&nbsp;</p>
							<p>You agree to not</p>
							<ul style="list-style-type: circle;">
								<li style="padding-left: 30px;">Post any content that is unlawful, threatening, abusive, harassing, vulgar, hateful, or racially, ethnically or otherwise objectionable.</li>
								<li style="padding-left: 30px;">Post, distribute, or otherwise make available or transmit any software or other computer files that contain a virus or other harmful component.</li>
							</ul>
							<p>&nbsp;</p>
						</div>
						<input type="submit" name="Submit" value="Register"  class="btn btn-primary btn-lg">	
					</form>
				</div>
			</div>
		<?php } ?>
	</body>
</html>
