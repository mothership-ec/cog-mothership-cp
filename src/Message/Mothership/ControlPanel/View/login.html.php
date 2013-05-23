<h1>Login</h1>
<p>Let's login into the admin area</p>

<form action="/login/action" method="post">
	
	<label for="email">Email</label>
	<input name="login[email]" type="text" />
	
	<label for="password">Password</label>
	<input type="password" name="login[password]" />
	
	<label for="remember-me">Remember Me</label>
	<input type="checkbox" name="login[remember]" value="1" />
	
	<button name="login[submit]" id="login" type="submit" value="login">Login</button>
</form>