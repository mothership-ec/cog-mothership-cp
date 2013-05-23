<h1>Hello <?php echo $forename; ?></h1>
<p>You are logged in</p>
<p>Your email address is: <?php echo $email; ?>
<form action="/logout" method="post">
	<button name="logout" id="logout" type="submit">Logout</button>
</form>