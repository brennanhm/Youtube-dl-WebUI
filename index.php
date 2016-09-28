<?php
	require_once 'class/Session.php';
	require_once 'class/Downloader.php';
	require_once 'class/FileHandler.php';

	$session = Session::getInstance();
	$file = new FileHandler;

	require 'views/header.php';

	if(!$session->is_logged_in())
	{
		header("Location: login.php");
	}
	else
	{
		if(isset($_GET['kill']) && !empty($_GET['kill']) && $_GET['kill'] === "all")
		{
			Downloader::kill_them_all();
		}

		if(isset($_POST['urls']) && !empty($_POST['urls']))
		{
			$audio_only = false;

			if(isset($_POST['audio']) && !empty($_POST['audio']))
			{
				$audio_only = true;
			}

			$downloader = new Downloader($_POST['urls'], $audio_only);
			
			if(!isset($_SESSION['errors']))
			{
				header("Location: index.php");
			}
		}
	}
?>
		<div class="container">
			<h1>Download</h1>
			<?php

				if(isset($_SESSION['errors']) && $_SESSION['errors'] > 0)
				{
					foreach ($_SESSION['errors'] as $e)
					{
						echo "<div class=\"alert alert-warning\" role=\"alert\">$e</div>";
					}
				}

			?>
			<form id="download-form" class="form-horizontal" action="index.php" method="post">					
				<div class="form-group">
					<div class="col-md-10">
						<input class="form-control" id="url" name="urls" placeholder="Link to video" type="text">
					</div>
					<div class="col-md-2">
						<div class="checkbox" id="checkboxdiv" style="display: none;">
							<label>
								<input type="checkbox" id="checkbx" name="audio"> Audio Only
							</label>
						</div>
					</div>
				</div>
				<h3 id="vidtitle" style="display: none;">Video title</h3>
				<div id="vidthumb" style="display: none; padding: 15px;">
					<img src="" id="vidimg" alt="Invalid link. Try again!" style="max-width: 360px; max-height: 300px; padding: 0px; border: 1px solid #1c1c1c;">
				</div>
				<h4 id="invalidurl" style="display: none; padding: 2px;">Invalid URL. Try again!</h4>
				<a href="" id="vidlink" target="_blank" class="btn btn-primary" style="display: none;" download>Save!</a>
				<button id="vidrestart" type="submit" name="restartbtn" class="btn btn-primary" style="display: none;">Restart</button>
				<h4 id="downloadready" style="display: none; padding: 2px;">Download ready!</h4>
				<button id="viddown" type="submit" name="downloadbtn" class="btn btn-primary" style="display: none;">Download</button>
				<button id="vidcanc" type="submit" name="cancelbtn" class="btn btn-danger" style="display: none;">Cancel</button>
				<img src="img/download-bar.gif" id="downloadbar" style="padding: 10px; display: none;">
				<button id="vidcont" type="submit" name="continuebtn" class="btn btn-primary">Continue</button>
				<img src="img/ajax-loader.gif" id="spinner1" style="padding: 10px; display: none;">
			</form>
			<br>
		</div>
<?php
	unset($_SESSION['errors']);
	require 'views/footer.php';
?>

