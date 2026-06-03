<?php
$page_title = "Иванов И.И., гр. ВЕБ-11 — ЛР А-1: Контакты";

$menu = [
    ['page1.php', 'Главная',     false],
    ['page2.php', 'О проекте',   false],
    ['page3.php', 'Контакты',    true],
];

$photo_num = date('s') % 2 + 1;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <?php foreach ($menu as $item): ?>
        <a href="<?php echo $item[0]; ?>"
           <?php if ($item[2]) echo 'class="active"'; ?>>
           <?php echo $item[1]; ?>
        </a>
    <?php endforeach; ?>
</header>

<main>
    <h1>Контакты</h1>

    <h2>Фото</h2>
    <img class="photo" src="fotos/foto<?php echo $photo_num; ?>.jpg" alt="Контакт">

    <h2>Контактная информация</h2>
    <table>
        <?php echo '<tr><th>Поле</th><th>Значение</th><th>Примечание</th></tr>'; ?>
        <tr>
            <td><?php echo 'ФИО'; ?></td>
            <td><?php echo 'Иванов Иван Иванович'; ?></td>
            <td><?php echo 'студент'; ?></td>
        </tr>
        <tr>
            <td><?php echo 'Группа'; ?></td>
            <td><?php echo 'ВЕБ-11'; ?></td>
            <td><?php echo '2024/2025'; ?></td>
        </tr>
    </table>

    <h2>О себе</h2>
    <p>Студент кафедры информационных технологий. Изучает серверное программирование на PHP,
       работу с базами данных MySQL и создание динамических веб-приложений.</p>
    <p>Данная лабораторная работа посвящена освоению основ PHP: встраиванию PHP-кода в HTML,
       работе с переменными, функцией date(), условными операторами и формированию
       динамического меню.</p>
</main>

<footer>
    Сформировано <?php echo date('d.m.Y в H:i:s'); ?>
</footer>

</body>
</html>
