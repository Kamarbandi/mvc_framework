<h2>Login page</h2>
<form method="post">
	
	<input value="<?=getOldValue('email')?>" name="email" placeHolder="Email"><br>
	<div><?=$user->getError('email')?></div><br>
	<input value="<?=getOldValue('password')?>" name="password" placeHolder="Password"><br>
	<div><?=$user->getError('password')?></div><br>
	<button>Login</button>
</form>