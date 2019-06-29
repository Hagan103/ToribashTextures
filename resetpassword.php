<?php
	if (isset($_POST["Submit"])) {
		
		$email=$_POST['email'];
		$token=$_POST['token'];
		
		$salt =  mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
		$password=$_POST['password'].$salt;
		$password = sha1($password);
		
		require('includes/config.php');
		
		$query ="SELECT user_id FROM users WHERE email=:email AND token=:token AND token<>'' AND tokenExpire > NOW()";
		$query = $conn->prepare($query);
		$query->bindValue(':token', $token);
		$query->bindValue(':email', $email);
		$query->execute();
		if ($query->rowCount() > 0) {
			
			$query ="UPDATE users SET token='', Password=:password WHERE Email=:email";
			$query = $conn->prepare($query);
			$query->bindValue(':password', $password);
			$query->bindValue(':email', $email);
			$query->execute();
			
			$query ="UPDATE users SET Salt=:salt WHERE Email=:email";
			$query = $conn->prepare($query);
			$query->bindValue(':salt', $salt);
			$query->bindValue(':email', $email);
			$query->execute();
			
			echo "password updated. ";
			echo "</br>";
			echo " <a href='http://www.toribashtextures.com/myaccount.php'>Click here to login.</a>";
			
			if (isset($_GET["token"]) && isset($_GET["email"])) {
				$email = htmlspecialchars($_GET["email"], ENT_QUOTES, 'UTF-8');
				$token = htmlspecialchars($_GET["token"], ENT_QUOTES, 'UTF-8');
				
				$query ="SELECT user_id FROM users WHERE email=:email AND token=:token";
				$query = $conn->prepare($query);
				$query->bindValue(':token', $token);
				$query->bindValue(':email', $email);
				$query->execute();
			?>
			<html>
				<head>
					<title>Toribash Textures</title>
					<?php include 'links.php'; ?>
				</head>
				<body>
					<?php include 'header.php'; ?>
					<div class="container topmargin">
						<form name="form1" action="resetPassword.php" method="post">
							input new Password
							<input type="hidden" id="token" name="token" value="<?php echo $token?>">
							<input type="hidden" id="email" name="email" value="<?php echo $email?>">
							<input name="password" type="password" id="password" size="15" maxlength="40">
							<input type="submit" name="Submit" value="Register">
						</tr>
					</table>
				</form>
			</div>
		</body>
	</html>	