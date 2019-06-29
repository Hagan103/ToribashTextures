<?php
	function _e($string){
		echo htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
	}
	
	if(isset($_POST["searchsubmit"])){
		header('Location: order.php?sorting=1&q='.($_POST["inputsearch"]));
		
		echo($_POST['inputsearch']);
		
	}
	$getsearch = $_GET['q'];
	$getsearch = htmlspecialchars($getsearch, ENT_QUOTES, 'UTF-8')
?>
<nav class="navbar navbar-default showcasenav">
			<div class="container">

	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>                        
		</button>
	</div>
	<div class="showcasenav-tabs collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav navbar-right" >
				<?php 
					if(basename($_SERVER['PHP_SELF']) == "order.php"){
						$getpopularity = $_GET['sorting'];
					?>
					<li  <?php 
						if($getpopularity == 1){
							echo"class='active'"; 
						}
					?>
					><a href="<?php if($getsearch == ""){?>order.php?sorting=1<?php ;}else{ ?>order.php?sorting=1&q=<?php echo $getsearch; }?>"><span class='showcasenavtxt'>Recent</span><span class="sr-only">(current)</span></a></li>
					<li <?php 
						if($getpopularity == 2){
							echo"class='active'"; 
						}
					?>><a href="<?php if($getsearch == ""){?>order.php?sorting=2<?php ;}else{ ?>order.php?sorting=2&q=<?php echo $getsearch; }?>"><span class='showcasenavtxt'>Popular 1 week</span></a></li>
					<li <?php 
						if($getpopularity == 3){
							echo"class='active'"; 
						}
					?>><a href="<?php if($getsearch == ""){?>order.php?sorting=3<?php ;}else{ ?>order.php?sorting=3&q=<?php echo $getsearch; }?>"><span class='showcasenavtxt'>Popular All Time</span></a></li>
					<?php }else{ ?>
					<li class="active "><a href="<?php if($getsearch == ""){?>order.php?sorting=1<?php ;}else{ ?>order.php?sorting=1&q=<?php echo $getsearch; }?>"><span class='showcasenavtxt'>Recent</span> <span class="sr-only">(current)</span></a></li>
					<li><a href=" order.php?sorting=2"><span class='showcasenavtxt'>Popular 1 week<span></a></li>
						<li><a href=" order.php?sorting=3"><span class='showcasenavtxt'>Popular All Time<span></a></li>
						<?php } ?>
						<li>
							<form method ="post" enctype = "multipart/form-data"  class="navbar-form navbar-left showcase-nav-form" >
								<div class="form-group">
									<input type ="text" name="inputsearch" class="texture-search form-control" placeholder="Search" size="15" <?php if ($getsearch != ""){echo 'value ='.$getsearch; } 
										else{ echo 'value =""';}?>> 
									<button type ="submit" name = "searchsubmit"  class="btn btn-default"><i class="fas fa-search fa-lg"></i></button>
										</div>
									</form>
								</li>
							</ul>
						</div>
					</div>
				</nav>									