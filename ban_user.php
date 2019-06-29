<?php
	include 'includes/session.php';
	
	include('includes/config.php');
	
	if (!isset($_SESSION['Username'])||($_SESSION['account_type']=='1')){
		header('Location: index.php');
		
	}
	if (isset($_SESSION['Username'])&&($_SESSION['account_type']=='2')){
		
		echo '<pre>';
		var_dump($_SESSION);
		echo '</pre>';
		
		
		if(isset($_POST['Submit'])){
			$username = $_POST['username'];
			$qry =  $conn->prepare("select * from users WHERE Username = :username");
			$qry->bindValue(':username', $username);
			$qry->execute();
			$result = $qry->fetchAll();
			if ($qry->rowCount() == 1) {
				echo "username exist";
				$qry =  $conn->prepare("UPDATE users SET Status='banned' WHERE Username = :username");
				$qry->bindValue(':username', $username);
				$qry->execute();
				$qry->fetchAll();
				echo "<br /> user ".$username." is now banned";
				
				if(isset($_POST['removeall'])){
					$qry =  $conn->prepare("DELETE FROM images WHERE artist = :username");
					$qry->bindValue(':username', $username);
					$qry->execute();
					$qry->fetchAll();
					echo "<br /> all posts from ".$username." have now been removed";
					
					
				}
				
			}
			elseif ($qry->rowCount() == 0) {
				echo "username does not exist";
			}
		}
	?>
	<!DOCTYPE html>
	<html lang="en">
		<head>
			<title>Toribash Textures</title>
			<?php include 'includes/links.php'; ?>
		</head>
		<body>
			
  			<?php include 'includes/header.php'; ?>
			
			<div class="container">
				
				<div class="row">
				</div>
				<div class="col-md-6 formcol">
					
					
					<form class="form2"  method="post" name="form1">
						<h3> <span class="greytxt pageheading3">Ban Account </span></h3> 
						<div><?php echo $banerror; ?></div>
						
						<table width="352" height="112" border="0">
							<tr>
								<td width="151"><strong>UserName: </strong></td>
								<td width="185"><input name="username" type="text" id="email" size="30" maxlength="30"></td>
							</tr>
							<tr>
								<td><strong>Remove all Posts</strong> <td>
									<td> <input type="checkbox" name="removeall" value="removeall"></td>
								</tr>
								<tr>
									<td><input class="btn btn-default" type="submit" name="Submit" value="BAN" ></td>
									<td>&nbsp;</td>
								</tr>
								</table>
							</form>
						</div>
					</div>
				</div>
			</body>
		</html>
	<?php } ?>	