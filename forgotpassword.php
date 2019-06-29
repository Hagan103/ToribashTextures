<!DOCTYPE html>
<html>
	<head>
		<?php include 'includes/links.php'; ?>
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<div class="container topmargin">
			<?php
				require('includes/config.php');
				
				if (isset($_POST["forgotPass"])) {
					$email = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
					
					$query ="SELECT user_id FROM users WHERE Email=:email";
					$query = $conn->prepare($query);
					$query->bindValue(':email', $email);
					$query->execute();
					
					if ($query->rowCount() > 0) {
						$str = "0123456789qwertzuioplkjhgfdsayxcvbnm";
						$str = str_shuffle($str);
						$str = substr($str, 0, 10);
						$url = "http://toribashtextures.com/resetPassword.php?token=$str&email=$email";
						
						$query ="UPDATE users SET token=:str ,tokenExpire=DATE_ADD(NOW(), INTERVAL 5 MINUTE) WHERE Email=:email";
						$query = $conn->prepare($query);
						$query->bindValue(':str', $str);
						$query->bindValue(':email', $email);
						$query->execute();
						
						$to = $email;
						$subject = 'Reset Password';
						$message = "
						Hi
						
						In order to reset your password, please click on the link below:
						http://www.toribashtextures.com/resetPassword.php?token=$str&email=$email

						
						thanks,
						ToribashTextures.com
						";
						$headers = 'From: noreply@toribashtextures.com' . "\r\n" .
						'Reply-To: noreply@toribashtextures.com' . "\r\n" .
						'X-Mailer: PHP/' . phpversion();
						mail($to, $subject, $message, $headers);
						echo "Please check your email!";
						} else {
						echo "Please check your inputs!";
					}
				}
				?>
				<form action="forgotPassword.php" method="post">
				<input type="text" name="email" placeholder="Email"><br>
				<input type="submit" name="forgotPass" value="Request Password Reset">
				</form>
				</div>
				</body>
				</html>				