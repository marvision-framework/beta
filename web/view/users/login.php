
<?php $title_for_layout = "Login"; ?>
	<form action="" method="post">
		<b><?= translater("login"); ?></b><br>
		<input type="email"  name="email" placeholder="<?= translater("email"); ?>"> 
		<input type="password" name="pass" placeholder="<?= translater("password"); ?>">
		<input type="submit" name="login" class="btn btn-default " value="<?= translater("login"); ?>">
	</form>