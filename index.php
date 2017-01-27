<?php
require_once 'lib/bootstrap.php';
?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Royl - Share Password</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h1><a href="/">Share Password</a></h1>
					<p class="lead">Generate a one-time use link to share sensitive information with a friend or colleague.</p>
				</div>
			</div>
		</div>
		<hr>

		<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-center">
					<h2>Here's your link!</h2>
					<div class="alert alert-success" role="alert">
						Your unique link has been created! 
					</div>
					<div class="well well-lg">
						<p style="font-size: 2rem;"><?=generateLink()?></p>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<?php endif; ?>
		
		<?php if (isset($_GET['key']) && $_SERVER['REQUEST_METHOD'] === 'GET'): ?>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h2>Here is your Data</h2>
					<div class="alert alert-warning"><p>The link data has been deleted. You will not be able to use this link again.</p></div>
					<form action="./" method="POST">
						<fieldset>
							<div class="form-group">
								<pre><?=processLink()?></pre>
							</div>
							<a href="./" class="btn btn-default">Create a new Link</a>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		<hr>
		<?php else: ?>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">		
					<h2>Encrypt Data and Generate Link</h2>
					<p>Enter the data you want to share. This can be a password, or other sensitive information. You can enter up to 255 characters. The data is encrypted at rest and during transit. Once the link is used the data is deleted forever.</p>
					<form action="./" method="POST">
						<fieldset>
							<div class="form-group">
								<textarea maxlength="255" placeholder="Enter data to share here..." class="form-control" rows="10" name="mydata"></textarea>
							</div>
							<input type="submit" name="submit" value="Generate Link" class="btn btn-primary">
						</fieldset>
					</form>
				</div>
			</div>
		</div>
		<?php endif; ?>
		
		<div class="container" style="margin-top: 3rem; margin-bottom: 3rem;">
			<div class="row">
				<div class="col-sm-12">
					<p>
					&copy; <a href="https://www.roylindauer.com">Roy Lindauer</a> - <?=date('Y')?>
					</p>
				</div>
			</div>
		</div>
		
    	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</body>
</html>