<?php
	require_once 'class/Downloader.php';
	require_once 'class/FileHandler.php';

	$file = new FileHandler;

	require 'views/header.php';

	if(isset($_GET['kill']) && !empty($_GET['kill']) && $_GET['kill'] === "all")
	{
		Downloader::kill_them_all();
	}

	if(isset($_POST['urls']) && !empty($_POST['urls']))
	{
		$format = "mp4"; // Set the default file format

		if(isset($_POST['format']) && !empty($_POST['format']))
		{
			$format = $_POST['format'];
		}

		$downloader = new Downloader($_POST['urls'], $format);
		
		if(!isset($_SESSION['errors']))
		{
			header("Location: index.php");
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
				<div id="formatbtns" class="radiobutton" style="display: none; padding: 5px;">
				<strong id="formatlbl" class="radiobutton" style="display: none; font-size: 16px">Format:</strong>
				<div id="mp4" class="radiobutton" style="display: none;"><input type="radio" name="format" value="mp4" checked> mp4 </div>
				<div id="3gp" class="radiobutton" style="display: none;"><input type="radio" name="format" value="3gp"> 3gp </div>
				<div id="aac" class="radiobutton" style="display: none;"><input type="radio" name="format" value="aac"> aac </div>
				<div id="flv" class="radiobutton" style="display: none;"><input type="radio" name="format" value="flv"> flv </div>
				<div id="m4a" class="radiobutton" style="display: none;"><input type="radio" name="format" value="m4a"> m4a </div>
				<div id="ogg" class="radiobutton" style="display: none;"><input type="radio" name="format" value="ogg"> ogg </div>
				<div id="wav" class="radiobutton" style="display: none;"><input type="radio" name="format" value="wav"> wav </div>
				<div id="webm" class="radiobutton" style="display: none;"><input type="radio" name="format" value="webm"> webm  </div>
				<div id="mp3" class="radiobutton" style="display: none;"><input type="radio" name="format" value="mp3"> mp3 </div>
				</div>

				<a href="" id="vidlink" target="_blank" class="btn btn-primary" style="display: none;" download>Save!</a>
				<button id="vidrestart" type="submit" name="restartbtn" class="btn btn-primary" style="display: none;">Done</button>
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

