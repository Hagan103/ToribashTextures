<?php 
	if (isset($_SESSION['Username'])){
		require('config.php');
		$username = $_SESSION['Username'];
		$username= htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
		$qry =  $con->prepare("SELECT * from users WHERE Username = :username AND Status = 'banned' ");
		$qry->bindValue(':username',$username);
		$qry->execute();
		$result = $qry->fetchAll();
		if ($qry->rowCount() == 1) {
			session_destroy();
		}
	}	
?>
<nav class="navbar navbar-default topnav navbar-inverse">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php"><span><img id='logo' src="img/logosmall2.png" alt="TBT Logo" height='115'></span></a>
			<a class="navbar-brand" href="index.php"><span>ToribashTextures</span></a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li ><a href="upload.php"><span class="navtxt"><i class="fa fa-upload" aria-hidden="true"></i> Upload</span></a></li>        	
				<li>   
					<?php
						if (isset($_SESSION['Username']))
						{
							$username = $_SESSION['Username'];
							$username= htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
						    $email = $_SESSION['Email'];
							$email= htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
							if($_SESSION['account_type']==2){
								echo"<li><a href=\"ban_user.php\"><span class='navtxt'>Ban User</span> </a> </li>";
							}
							echo"<li class=\"loggedintab\"><a  href='myaccount.php'><span class='navtxt loggedintab'>".$username."</span> </a> </li>";
							echo"<li><a href=\"logout.php\"><span class='navtxt'> Logout</span></a></li>";
						}
						else
						{
						?>
						<li><a href="myaccount.php"><span class="navtxt"> Sign in</span></a></li>
						<li><a href="myaccount.php"><span class="navtxt">Register</span></a></li>
						<li><a href="https://www.paypal.me/ToribashTexturescom/" target="_blank"><span class="navtxt">Donate</span></a></li>
						<?php			        
						}
					?>
				</li>
			</ul>
</div>
</div>
</nav>
