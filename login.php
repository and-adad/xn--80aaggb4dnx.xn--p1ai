<?php
 	require "db.php";
 	//Почему я решил прибегнуть к помощи red bean PHP вместо MySQL connect? На это меня сподвигло то, что этот метод предоставляет современную защиту от sql инъекций и удобство работы с БД. По видео с Youtube канала 'Хауди''

 	$data = $_POST;
	if( isset($data['do_login']))
	{
		$errors = array();
		$user = R::findOne('allusers', 'login = ?' , array($data['login']));
	if ( $user )
	{
		//логин существует
		if ( password_verify($data['password'], $user->password)) {
			// всё хорошо, логиним пользователя
		$_SESSION['logged_user'] = $user;
		// можно вместо сессий использовать cookie но так проще. Для этого мы в db.php добавим функцию session start
			echo '<div style="color: green;">Вы авторизованы!<br/>Можете перейти на <a href="/">главную</a> страницу!</div><hr>';
		} else
		{
			$errors[] = 'Неверно введен пароль';
		}
	} else
{
	$errors[] = 'Пользователь с таким логином не найден!';
}

if ( ! empty($errors))
 {
 	echo '<div style="color: red;">'.array_shift($errors).'</div><hr>';
}
	 	# code...
	 } 

  ?>

 <form action="login.php" method= "POST">
 	
	<p>
		<p><strong>Логин</strong>:</p>
		<input type="text" name="login" value="<?php echo @$data['
		login']; ?>">
	</p>

	<p>
		<p><strong>Пароль</strong>:</p>
		<input type="password" name="password" value="<?php echo @$data['
		password']; ?>">
	</p>

<p><button type="submit" name="do_login">Войти
	</button>
</p>

 </form>