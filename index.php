

<?php
/* 
         *small description: This is the index page, or the homepage.
         *The primary functions are to link up all of the elements included in the app.
         *
		 *@package 
		 *@copyright 2012 Amanda Marochko
		 *@author Amanda Marochko <amanda.marochko@gmail.com>
		 *@link http://github.com/amandamarochko/open-data-app
		 *@license New BSD Licence 
		 *@version 1.0.0
*/

require_once 'includes/db.php';

$results = $db->query('
	SELECT id, name, address, longitude, latitude, rate_count, rate_total
	FROM locations
	ORDER BY address DESC
');

?><!DOCTYPE HTML>
<html lang=en-ca>
<head>
	<meta charset=utf-8>
	<title>Ottawa's ODR App</title>
	<link href="css/public.css" rel="stylesheet">
	<script src="js/modernizr.dev.js"></script>
</head>
<body>
<div id="side">
	<header>	
		<h1><img src="images/title.png" height="150" width="300"></h1>
		<nav>
			<h2>Navigation</h2>
			<ul>
				<li><a href="index.php"><img src="images/home.png" height="60" width="300"></a></li>
				<li><a href="admin/index.php"><img src="images/admin.png" height="60" width="300"></a></li>
				<li><a href="http://imm.edumedia.ca/maro0030/mtm1526/open-data-app"><img src="images/brief.png" height="60" width="300"></a>
			</ul>
		</nav>
	</header>
	<article>
	
		<h2>Locations</h2>
<button id="geo">Find Me</button>
<form id="geo-form">
    <label for="adr">Address</label>
    <input id="adr">
</form>

<div id="dataset">
<ol class="locations">
<?php foreach ($results as $odr) : ?>

	<?php
		if ($odr['rate_count'] > 0) {
			$rating = round($odr['rate_total'] / $odr['rate_count']);
		} else {
			$rating = 0;
		}
	?>

	<li itemscope itemtype="http://schema.org/TouristAttraction" data-id="<?php echo $odr['id']; ?>">
		<strong class="distance"></strong>
		<a href="single.php?id=<?php echo $odr['id']; ?>" itemprop="name"><?php echo $odr['name']; ?></a>
		<span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
			<meta itemprop="latitude" content="<?php echo $odr['latitude']; ?>">
			<meta itemprop="longitude" content="<?php echo $odr['longitude']; ?>">
		</span>
		
		<ol class="rater">
		<?php for ($i = 1; $i <= 5; $i++) : ?>
			<?php $class = ($i <= $rating) ? 'is-rated' : ''; ?>
			<li class="rater-level <?php echo $class; ?>">★</li>
		<?php endfor; ?>
		</ol>
	</li>
<?php endforeach; ?>
</ol>
</div>
</div>
<div id="map" "position: absolute; right: 0px; top: 0px; overflow: hidden; width: 90%; height: 100%; z-index: 0;"></div>

		
		
	</article>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCOSF6EUJHi28FLeCSkKsQsG1gtn4vRkN4&sensor=false"></script>
<script src="js/latlng.min.js"></script>
<script src="js/odr.js"></script>
</body>
</html>
