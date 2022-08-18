<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мой блог</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

<table class="layout">
    <tr>
        <td colspan="2" class="header">
            Мой блог
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right">
            <?= !empty($user) ? 'Привет, ' . $user->getNickname() : '<a href="/users/login">Войти на сайт</a>' ?>
            <?php if(!empty($user)) echo '<a href="/users/logout">Выйти</a>'; ?>
            &nbsp;
        <?php if(empty($user)) echo '<a href="/users/register">Регистрация</a>'; ?>
            
        </td>

    </tr>
    <tr>
        <td>
