<?php
	$pageTitle = "WebLab 2015 Project - Add/Edit Observation";
	require_once 'common/header.php';
	require_once 'common/RadioList.php';
?>

<article class="fluid textContainer">
<h2 class="fluid showAreaH2 headingStyle">Flora Registry</h2>

	<?php //include('menu.php') ?>
	<div><?php if (isset($error)) print $error; ?></div>

	<form name="login" action="index.php" method="get" class="fluid reg-form">        
		<input type="hidden" name="action" value="login_check" required>

		<p><label for="email">Email</label></p>
		<input type="text" name="email" placeholder="email" value="" required>

		<p><label for="pass">Password</label></p>
		<input type="password" name="pass" placeholder="pass" value="" pattern=".{3,10}" title="3 to 10 characters" >

		<p><input type="submit" value="Login" class="button"></p>

	</form>

<?php require_once "../views/common/footer.php"; ?>

</article>