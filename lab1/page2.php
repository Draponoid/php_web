<?php
$page_title = "Иванов И.И., гр. ВЕБ-11 — ЛР А-1: О проекте";

$menu = [
    ['page1.php', 'Главная',     false],
    ['page2.php', 'О проекте',   true],
    ['page3.php', 'Контакты',    false],
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
    <h1>О проекте</h1>

    <h2>Динамическая фотография</h2>
    <img class="photo" src="fotos/foto<?php echo $photo_num; ?>.jpg" alt="Фото проекта">

    <h2>Технологии</h2>
    <table>
        <?php echo '<tr><th>Технология</th><th>Назначение</th><th>Версия</th></tr>'; ?>
        <tr>
            <td><?php echo 'HTML5'; ?></td>
            <td><?php echo 'Разметка страницы'; ?></td>
            <td><?php echo '5'; ?></td>
        </tr>
        <tr>
            <td><?php echo 'CSS3'; ?></td>
            <td><?php echo 'Стилизация'; ?></td>
            <td><?php echo '3'; ?></td>
        </tr>
    </table>

    <h2>Описание</h2>
    <p>Данный проект создан в рамках лабораторной работы по изучению PHP. Сайт демонстрирует
       возможности динамического формирования HTML-кода средствами PHP.</p>
    <p>Каждая страница сайта содержит элементы, которые формируются сервером в момент запроса:
       текущее время в подвале, изображения, чередующиеся по секундам, и пункты меню,
       выделяющие активную страницу.</p>
</main>

<footer>
    Сформировано <?php echo date('d.m.Y в H:i:s'); ?>
</footer>

</body>
</html>
