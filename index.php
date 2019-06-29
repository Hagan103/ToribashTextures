<?php
	include 'includes/session.php';
	
	if(isset($_POST["searchsubmit"])){
		header('Location: order.php?sorting=1&q='.($_POST["inputsearch"]));
		echo($_POST['inputsearch']);
		function _e($string){
			echo htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
		}
	}
	
	require('includes/config.php');
	
	$getorder = 1; 
	$getsearch = ""; 
	
	$last_id = 0;
	$limit = 0;
	$last_views = 0;
	$last_date =0;
	$shown =array();
	
	$getorder = $_POST['last_views'];
	$sql = 'SELECT * FROM images ORDER BY UploadDate DESC,UploadTime DESC  LIMIT 0, 30';
	$query = $conn->prepare($sql);
	$query->execute();
	$list = $query->fetchAll();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'includes/links.php'; ?>
		<style>
			#freeicon{
			width:50px;
			height:48px;
			position:absolute;
			background-color: rgba(0, 0, 0, 0.2);
			}
			
			#freeicon img{
			padding:10px;
			}
		</style>
	</head>
	<body>
		<?php include 'includes/header.php'; ?>
		<?php include 'includes/showcasenav.php'; ?>
        <div class="content">
			<?php
				echo"<ul id=\"items\" class=\"rig\" style= 'background: -webkit-radial-gradient(center, ellipse cover, ".$brightenomplimentary." 0%,".$brightenomplimentary8." 100%);'>\n";
	
				$getorder = 0; 
				$last_id = 0;
				$limit = 0;
				$last_views = 0;
				$last_date =0;
				
				function colourBrightness($hex, $percent) {
					// Work out if hash given
					$hash = '';
					if (stristr($hex,'#')) {
						$hex = str_replace('#','',$hex);
						$hash = '#';
					}
					/// HEX TO RGB
					$rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
					//// CALCULATE 
					for ($i=0; $i<3; $i++) {
						// See if brighter or darker
						if ($percent > 0) {
							// Lighter
							$rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
							} else {
							// Darker
							$positivePercent = $percent - ($percent*2);
							$rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
						}
						// In case rounding up causes us to go to 256
						if ($rgb[$i] > 255) {
							$rgb[$i] = 255;
						}
					}
					// RBG to Hex
					$hex = '';
					for($i=0; $i < 3; $i++) {
						// Convert the decimal digit to hex
						$hexDigit = dechex($rgb[$i]);
						// Add a leading zero if necessary
						if(strlen($hexDigit) == 1) {
							$hexDigit = "0" . $hexDigit;
						}
						// Append to the hex string
						$hex .= $hexDigit;
					}
					return $hash.$hex;
				}
				
				function color_inverse($color){
					if($color != null){
						$color = str_replace('#', '', $color);
						if (strlen($color) != 6){ return '000000'; }
						$rgb = '';
						for ($x=0;$x<3;$x++){
							$c = 255 - hexdec(substr($color,(2*$x),2));
							$c = ($c < 0) ? 0 : dechex($c);
							$rgb .= (strlen($c) < 2) ? '0'.$c : $c;
						}
						return '#'.$rgb;
					}
					else{
						return $color;
					}
				}
				
				foreach ($list as $rs) {
					$last_id = $rs['id']; // keep the last id for the paging
					$last_views = $rs['views'];
					$last_date = $rs['UploadDate'];
					array_push($shown,$rs["id"]);
					
					$complimentarybodycolor = color_inverse($rs["jointcolor"]);
					$brightenomplimentary= colourBrightness($complimentarybodycolor ,0.3);
					$brightenomplimentary8= colourBrightness($complimentarybodycolor ,0.8);
					$last_id = $rs['id']; // keep the last id for the paging
					
					echo" <li style= 'background: -webkit-radial-gradient(center, ellipse cover, ".$brightenomplimentary." 0%,".$brightenomplimentary8." 100%);' >\n";
					
					$title= htmlspecialchars($rs["title"], ENT_QUOTES, 'UTF-8');
					$artist= htmlspecialchars($rs["artist"], ENT_QUOTES, 'UTF-8');
					$textureArtist = htmlspecialchars($rs["textureArtist"], ENT_QUOTES, 'UTF-8');
					
					echo"<a class=\"rig-cell\" href='texture.php?id=".$rs["id"]."'   >\n";
					echo"<span class=\"rig-overlay\" style= \"background-image: url(".'uploads/'.$rs["user_id"].'/'.$rs["id"].'/thumb.jpg'."); \"></span>\n";
					echo"<div style='background-color:red;'> </div>";
					echo"<span class=\"rig-bg\" > </span>\n";
					echo"<span class=\"rig-text\"> ".$title."</span>\n";
					echo"br/>";
					echo"<span class=\"rig-subtext\">".$textureArtist."<br/> Views:".$rs["views"]." </span>\n";
					echo" </a>\n";
					echo"</li>\n";	
				}
				
				echo"</ul>\n";
			?>
			<p id="loader"><img src="img/ajax-loader.gif" alt="loader"></p>
		</div> 
		<script type="text/javascript">
			var last_id = <?php echo $last_id; ?>;
			var getorder = <?php echo $getorder; ?>;
			var getsearch ='<?php echo $getsearch; ?>';
			
			var last_views = <?php echo $last_views; ?>;
			var last_date = <?php echo $last_date; ?>;
			var shown = new Array();
			<?php foreach($shown as $key => $val){ ?>
				shown.push('<?php echo $val; ?>');
			<?php } ?>
			
		</script>
	</body>
</html>
