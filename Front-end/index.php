<?php require_once('header.php') ?>
<div id="login">
	<h1>Authentication Service</h1>
	<p>Please enter your UCID to proceed.</p>
	<div id="status"></div>
	<form method="POST">
		<label for="ucid">UCID</label>
		<input id="ucid" type="text" maxlength="6" placeholder="mma93" />
		<div class="split"></div>
		<label for="pass">Password</label>
		<input id="pass" type="password" maxlength="20" placeholder="required" />
	</form>
	<button id="submit" type="button">Submit</button>
</div>
<?php require_once('footer.php') ?>