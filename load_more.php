<?php
	require_once('includes/config.php');
	
	$last_id = $_POST['last_id'];
	$limit = $_POST['limit'];
	$last_views = $_POST['last_views'];
	$last_date = $_POST['last_date'];
	$getorder = $_POST['getorder'];
	$getsearch = $_POST['getsearch'];
	$qrygetsearch = "%".$getsearch ."%";
	
	$shown = json_decode(stripslashes($_POST['shown']));
	foreach($shown as $d){}
	
	$limit = 1; 
	if (isset($_POST['limit'])) {
		$limit = intval($_POST['limit']);
	}
	
	try {
		$query = "";
		if($getorder == 3){
			if($getsearch != ""){
				$query = "select * from images  WHERE artist LIKE '".$qrygetsearch."' OR title LIKE '".$qrygetsearch."' AND views <= ".$last_views."  ORDER BY views DESC ";
				}else{
				$query = "select * from images  WHERE views <= ".$last_views."  ORDER BY views DESC LIMIT 0, ".$limit ."" ;
			}
		}
		
		if($getorder == 2){
			if($getsearch != ""){
				$query = "select * from images  WHERE  artist LIKE '".$qrygetsearch."' OR title LIKE '".$qrygetsearch."' AND views <= ".$last_views." AND DATEDIFF(CURDATE(), UploadDate) <= 7 ORDER BY views DESC LIMIT 0, ".$limit ."" ;
				}else{
				$query = "select * from images  WHERE views <= ".$last_views." AND DATEDIFF(CURDATE(), UploadDate) <= 7 ORDER BY views DESC LIMIT 0, ".$limit ."" ;
			}
		}
		
		if($getorder == 1){
			if($getsearch != ""){
				$query = "select * from images  WHERE artist LIKE '".$qrygetsearch."' OR title LIKE '".$qrygetsearch."' AND id <= ".$last_id." ORDER BY UploadDate DESC,UploadTime DESC" ;
				}else{
				$query = "select * from images  WHERE id <= ".$last_id." ORDER BY UploadDate DESC,UploadTime DESC LIMIT 0, ".$limit ."" ;
			}
		}
		
		if($getorder == 0){
			if($getsearch != ""){
				}else{
				$query = "select * from images  WHERE id <= ".$last_id." ORDER BY UploadDate DESC,UploadTime DESC LIMIT 0, ".$limit ."" ;
			}
		}
		
		$query = $conn->prepare($query);
		$query->bindValue(':last_views', $last_views);
		$query->bindValue(':limit', $limit);
		$query->bindValue(':qrygetsearch', $qrygetsearch);
		$query->execute();
		$list = $query->fetchAll();
		} catch (PDOException $e) {
		echo 'PDOException : '.  $e->getMessage();
	}
	
	$last_id = 0;
	$last_views = 0;
	$last_date = 0;
	
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
		//// RBG to Hex
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
		
		if (!in_array($rs["id"], $shown)) {
			array_push($shown,$rs["id"]);
			
			$complimentarybodycolor = color_inverse($rs["jointcolor"]);
			$brightenomplimentary= colourBrightness($complimentarybodycolor ,0.3);
			$brightenomplimentary8= colourBrightness($complimentarybodycolor ,0.8);
			
			echo" <li style= 'background: -webkit-radial-gradient(center, ellipse cover, ".$brightenomplimentary." 0%,".$brightenomplimentary8." 100%); /* Chrome10-25,Safari5.1-6 *' >\n";
			echo"<a class=\"rig-cell\" href='texture.php?id=".$rs["id"]."'   >\n";
			echo"<span class=\"rig-overlay\" style= \"background-image: url(".'uploads/'.$rs["user_id"].'/'.$rs["id"].'/thumb.jpg'."); \"></span>\n";
			echo"<span class=\"rig-bg\" > </span>\n";
			echo"<span class=\"rig-text\"> ".$rs["title"]."</span>\n";
			echo"br/>";
			echo"<span class=\"rig-subtext\">".$rs["artist"]."<br/> Views:".$rs["views"]." </span>\n";
			echo" </a>\n";
			echo"</li>\n";
			
		}
		
	}
	if ($last_id != 0) {
		echo '<script type="text/javascript">
		var last_id = '.$last_id.';
		var getorder ='.$getorder.';
		var last_views = '.$last_views.';
		var last_date = '.$last_date.';
		
		var shown = new Array();'; foreach($shown as $key => $val){ echo'
			shown.push('.$val.');';
		}
		echo '</script>';
	}
	
	// sleep for 1 second to see loader, it must be deleted in prodection
	sleep(1);
?>


