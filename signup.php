<?php
  require "db.php";

  $data = $_POST;
  if(isset($data['do_signup']) )
  {
  	//здесь регистрируем
  
  $errors = array();
  if( trim($data['login']) == '' )
  	// затримал логин для того, чтобы он обрезал всякие лишние введенные пользователем пробелы
   {
  	$errors[] = 'Введите логин!';# code... если возникают ошибки, в массиве эррорз, отправляем в форму это сообщение "Введите логин!"
  }
    if( trim($data['email']) == '' )
   {
  	$errors[] = 'Введите Email!';# code...
  }
  
  if( trim($data['tel']) == '' )
{
  	$errors[] = 'Введите номер телефона!'; 
  }

    if( $data['password'] == '' )
   {
  	$errors[] = 'Введите пароль!';# code...
  }

    if( $data['password2'] != $data['password'] )# повторный пароль я не стал тримать, не вижу смысла
   {
  	$errors[] = 'Повторный пароль введён не верно!';# code...
  }

    if( R::count('allusers', "login = ?", array($data['login'])) > 0)
   {
  	$errors[] = 'Пользователь с таким именем уже существует!';# из документации CRUD RBPHP
  }

  if( R::count('allusers', "email = ?", array($data['email'])) > 0)
   {
  	$errors[] = 'Пользователь с таким email уже существует!';# code...
  }


if ( empty($errors))
 {
// всё хорошо, регистрируем. Тут хочется отметить про технологию подготовленных запросов PDO от RedBeanPHP, которая позволяет создавать в БД за нас столбцы таблиц, тип полей и сами таблицы целиком на лету. Защита от sql инъекций. А также нет необходимости беспокоиться об очистке данных, не нужно применять какие либо функции типа escape string	# code...
	$user = R::dispense('allusers');
	$user->a = $data['a'];
	$user->SNP = $data['SNP'];
	$user->login = $data['login'];
	$user->email = $data['email'];
	$user->tel = $data['tel'];
	$user->password = password_hash($data['password'],PASSWORD_DEFAULT);
	// пароль в БД сохрняем в шифрованном виде. Чтобы если кто то сольет нашу базу данных, злоумышленник не получил бы доступ к аккаунтам зарегистрированных пользователей. PASSWORD_DEFAULT - это второй не обязательный аргумент этой функции, Хауди говорит я его ввожу для ясности. А первым аргументом шел сам пароль в незашифрованном виде.
	R::store($user);
	echo '<div style="color: green;">Вы успешно зарегистрированы!</div><hr>';
} else
{
	echo '<div style="color: red;">' .array_shift($errors).'</div><hr>';
}

}

?>

<form action="/signup.php" method="POST">

	<p>
		<p><strong>Ваши ФИО</strong>:</p>
		<input type="text" name="SNP" value="<?php echo @$data['
		SNP']; ?>">
	</p>

	<select name="a" id="">
		<option>Частное лицо</option>
		<option>Индивидуальный предприниматель</option>
	</select>

	<p>
		<p><strong>Ваш логин</strong>:</p>
		<input type="text" name="login" value="<?php echo @$data['
		login']; ?>">
	</p>

	<p>
		<p><strong>Ваш Email</strong>:</p>
		<input type="email" name="email" value="<?php echo @$data['
		email']; ?>">
	</p>

	<p>
		<p><strong>Ваш номер телефона</strong>:</p>
		<input type="text" name="tel" value="<?php echo @$data['
		tel']; ?>">
	</p>

	<p>
		<p><strong>Ваш пароль</strong>:</p>
		<input type="password" name="password" value= "<?php echo @$data['
		password']; ?>">
	</p>

	<p>
		<p><strong>Введите ваш пароль ещё раз</strong>:</p>
		<input type="password" name="password2" value= "<?php echo @$data['
		password2']; ?>">
	</p>
	
	<p><button type="submit" name="do_signup">Зарегистрироваться
	</button>
</p>

	</form>