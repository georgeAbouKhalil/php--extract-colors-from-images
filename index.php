<?php
	$amount_of_colors = 5;
	$colorQuantization = 24;

	include_once("Colors.php");
	$ex = new GetMostCommonColors();
	$colors=$ex->Get_Color("./images/pizza.jpg", $amount_of_colors, $colorQuantization);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Image Color</title>
  <style type="text/css">
		* {margin: 0; padding: 0}
		body,h3 {text-align: center;}
		form, div#wrap {margin: 10px auto; text-align: left; position: relative; width: 500px;}
		fieldset {padding: 20px; border: solid #999 2px;}
		img {width: 200px;}
		table {border: solid #000 1px; border-collapse: collapse;}
		td {border: solid #000 1px; padding: 2px 5px; white-space: nowrap; text-align:center;}
		br {width: 100%; height: 1px; clear: both; }
		.button{ background-color: white; padding: 7px; margin-top:10px; border-radius:5px; color: black; border: 2px solid #008CBA; }
		.button:hover{ background-color: #008CBA; color: white; }
	</style>
</head>
<body>
<div id="wrap">
	<h3>Extract color from image</h3>
	<form action="#" method="post" enctype="multipart/form-data">
		<fieldset>
			<div>
				<label>File: <input type="file" name="imgFile" /></label>
			</div>

			<div>
				<input class="button" type="submit" name="action" value="submit" />
			</div>
		</fieldset>
	</form>
<?php

if ( isset( $_FILES['imgFile']['tmp_name'] ) && strlen( $_FILES['imgFile']['tmp_name'] ) > 0 ) {
	
	$colors=$ex->Get_Color( 'images/'.$_FILES['imgFile']['name'], $amount_of_colors, $colorQuantization);
?>
<table>
	<tr>
		<td>Color</td>
		<td>Color Code</td>
		<td rowspan="<?php echo (($amount_of_colors > 0)?($amount_of_colors+1):22500);?>"> 
			<img src="<?='images/'.$_FILES['imgFile']['name']?>" alt="test image" />
		</td>
	</tr>
<?php
	foreach ( $colors as $hex => $count ) {
		if ( $count > 0 ) {
			echo "<tr><td style=\"text-align:center;color:white;background-color:#".$hex.";font-weight: bold;\">".(sprintf('%.2f', $count*100))." %</td><td style=\"text-align:center;\">".$hex."</td></tr>";
		}
	}
?>
	</table>
<?php
}
?>
  
</body>
</html>