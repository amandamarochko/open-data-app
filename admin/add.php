

<?php
/**
		 *small description: allows you to add an additional dataset
		 *
		 *@package 
		 *@copyright 2012 Amanda Marochko
		 *@author Amanda Marochko <amanda.marochko@gmail.com>
		 *@link http://github.com/amandamarochko/open-data-app
		 *@license New BSD Licence 
		 *@version 1.0.0
*/

$errors = array();

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$longitude = filter_input(INPUT_POST, 'longitude', FILTER_SANITIZE_STRING);
$latitude = filter_input(INPUT_POST, 'latitude', FILTER_SANITIZE_STRING);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (empty($name)) {
$errors['name'] = true;
}

if (empty($longitude)) {
$errors['longitude'] = true;
}

if (empty($address)) {
$errors['address'] = true;
}

if (empty($errors)) {
require_once '../includes/db.php';

$sql = $db->prepare('
INSERT INTO locations (name, address, longitude, latitude)
VALUES (:name, :address, :longitude, :latitude)
');
$sql->bindValue(':name', $name, PDO::PARAM_STR);
$sql->bindValue(':address', $address, PDO::PARAM_STR);
$sql->bindValue(':longitude', $longitude, PDO::PARAM_STR);
$sql->bindValue(':latitude', $latitude, PDO::PARAM_STR);
$sql->execute();

header('Location: index.php');
exit;
}
}

?><!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
	<title>Add an ODR to the Outdoor Rinks in Ottawa App</title>
</head>
<body>
	<header>	
		<h1>Ottawa's ODR App</h1>
		<nav>
			<h2>Navigation</h2>
			<ul>
				<li><a href="../index.php">Home</a></li>
				<li><a href="index.php">Administration</a></li>
				<li><a href="http://imm.edumedia.ca/maro0030/open-data-app">Project Brief</a>
			</ul>
		</nav>
	</header>
	
<h2>Add a Rink</h2>
<div class="delete">
<form method="post" action="add.php">
<div>
<label for="name">Location Name<?php if (isset($errors['name'])) : ?> <strong>is required</strong><?php endif; ?></label>
<input id="name" name="name" value="<?php echo $name; ?>" required>
</div>
<div>
<label for="address">Street Address<?php if (isset($errors['address'])) : ?> <strong>is required</strong><?php endif; ?></label>
<input id="address" name="address" value="<?php echo $address; ?>" required>
</div>
<div>
<label for="longitude">Longitude<?php if (isset($errors['longitude'])) : ?> <strong>is required</strong><?php endif; ?></label>
<input id="longitude" name="longitude" value="<?php echo $longitude; ?>" required>
</div>
<div>
<label for="latitude">Latitude<?php if (isset($errors['latitude'])) : ?> <strong>is required</strong><?php endif; ?></label>
<input id="latitude" name="latitude" value="<?php echo $latitude; ?>" required>
</div>
<button type="submit">Add</button>
</form>
</div>

    <div class="back"> <a href="index.php">Back</a> </div>
</body>
</html>