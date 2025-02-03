<h2>Registration page</h2>
<form method="post">
	
	<input value="<?=getOldValue('username')?>" name="username" placeHolder="Username"><br>
	<div><?=$user->getError('username')?></div><br>
	<input value="<?=getOldValue('email')?>" name="email" placeHolder="Email"><br>
	<div><?=$user->getError('email')?></div><br>
	<input value="<?=getOldValue('password')?>" name="password" placeHolder="Password"><br>
	<div><?=$user->getError('password')?></div><br>
	<button>Registration</button>
</form>