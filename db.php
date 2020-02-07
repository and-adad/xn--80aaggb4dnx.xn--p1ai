<?php

require "libs/rb.php";
// этот файл подключает библиотеку rb.php.
R::setup( 'mysql:host=localhost;dbname=nn.ru','root','');
// Соединяем rb.php с БД. Предварительно я через PHPmyAdmin создал новую базу данных utf general ci
R::freeze(TRUE);
//этой командой я заморозил возможности red bean чтобы повысить производительность кода в продакшене
session_start();
