<?php
include 'includes/session.php';
 require_once('includes/config.php');


	if (isset($_GET['type'], $_GET['id'])){
		$type = $_GET['type'];
		$textureid = (int)$_GET['id'];
		$userid = $_SESSION['user_id'];
		
		
		
		switch($type){
			case 'texture':
			$checkfields =  $conn->prepare("SELECT * 
FROM texture_favs
WHERE user =:userid
AND texture =:textureid");
$checkfields->bindValue(':userid', $userid);
$checkfields->bindValue(':textureid', $textureid);
			$checkfields->execute();
			$count = $checkfields->rowCount();
			
  if ($checkfields->rowCount() == 0) {
				$qry =  $conn->prepare("
    INSERT INTO texture_favs (user, texture) values(:userid, :textureid)");

$qry->bindValue(':userid', $userid);
$qry->bindValue(':textureid', $textureid);
$qry->execute();

  }
   if ($checkfields->rowCount() == 1) {
				$qry =  $conn->prepare("
    DELETE FROM texture_favs
WHERE user =:userid
AND texture =:textureid");

$qry->bindValue(':userid', $userid);
$qry->bindValue(':textureid', $textureid);
$qry->execute();
  }
			break;
		}
	}
header('Location: texture.php?id='.$textureid);

?>