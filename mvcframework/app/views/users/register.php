 <?php
	require APPROOT . '/views/includes/head.php';
?>
<div class="navbar">
	 <?php
		require APPROOT . '/views/includes/navigation.php';
	?>

</div>

<div class="container-login">
	<div class="wrapper-login">
	<h2>Register</h2>
	<form action="<?php echo URLROOT; ?>/users/register" method ="POST">
		<input type="text" placeholder= "Username *" name="username">
		<span>
			<?php echo $data['usernameError']; ?>	
		</span>	
		<input type="email" placeholder= "E-mail *" name="email"> 
		<span>
			<?php echo $data['emailError']; ?>	
		</span>	
		<input type="Password" placeholder= " Confirm password *" name="confirmPassword">
		<span>
			<?php echo $data['confirmPasswordError']; ?>	
		</span>	
		<input type="Password" placeholder= "Password *" name="password">
		<span>
			<?php echo $data['passwordError']; ?>	
		</span>	
		<button id = "submit" type="submit" value="submit">Submit</button>
		<p class = "options">Not registered yet?<a href="<?php echo URLROOT; ?>/users/register">Create an new account!</a></p>
	</form>
	</div>
</div>