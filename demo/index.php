<?
	require_once("./../vendor/autoload.php");
	require_once("./../tools/src/functions.php");

	$composer = json_decode(file_get_contents("./../composer.json"));

	// remove anything after the question mark in example?variable
	$request = trim(preg_replace("/\?.*$/","",value($_SERVER,"REQUEST_URI")),"/");
	$request = $request ? $request : "index";
	$view_file = "./views/".$request.".php";
	$view = is_file($view_file);

	$content = "404 Page Not Found";

	if(is_file($view_file)) {
		ob_start();
		require_once($view_file);
		$content = ob_get_contents();
		ob_end_clean();
	}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
	<nav class="navbar navbar-light" style="background-color: #e3f2fd;">
	  <a class="navbar-brand" href="#">
	    Firestitch Package: <?=value($composer,"name")?>
	  </a>
	</nav>
	<div class="content" style="padding: 25px">
   		<form method="post">
   			<?=$content?>
   		</form>
	</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>

