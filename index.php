<?php
	require "db.php"
	// после подключения к БД я проверил что страница не выдает ошибку, а это значит, что подключение прошло успешно
?>

<?php if( isset($_SESSION['logged_user'])) : ?>
Авторизован!<br>
Привет, <?php echo $_SESSION[logged_user]->login; ?>!<hr>
<a href="/logout.php">Выйти</a>
<?php else : ?>
Вы не авторизованы!</br>
<a href="/login.php">Авторизоваться</a></br>
<a href="/signup.php">Регистрация</a>
<?php endif; ?>