<?php
// ЛР В-1: Записная книжка. Основной файл.
require_once 'db.php';
require_once 'menu.php';

// Параметр текущей страницы меню
if (!isset($_GET['p']) || !in_array($_GET['p'], ['viewer','add','edit','delete'])) {
    $_GET['p'] = 'viewer';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>ЛР В-1 — Записная книжка</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; margin: 0; background: #f5f5f5; }
        header { background: #1a5c2a; padding: 14px 20px; }
        header a {
            color: #fff; text-decoration: none; padding: 8px 16px;
            border-radius: 4px; background: rgba(255,255,255,.15); margin-right: 6px;
        }
        header a:hover { background: rgba(255,255,255,.3); }
        header a.sel { background: #c0392b; }
        .submenu { background: #e8f5e9; padding: 8px 20px; border-bottom: 1px solid #ccc; }
        .submenu a {
            color: #1a5c2a; text-decoration: none; padding: 4px 12px;
            border-radius: 4px; font-size: 14px; margin-right: 4px; border: 1px solid #1a5c2a;
        }
        .submenu a:hover { background: #1a5c2a; color: #fff; }
        .submenu a.sel  { background: #c0392b; color: #fff; border-color: #c0392b; }
        main { padding: 20px; max-width: 900px; }
        table { border-collapse: collapse; width: 100%; margin-top: 16px; }
        td, th { border: 1px solid #ccc; padding: 8px 12px; text-align: left; }
        th { background: #1a5c2a; color: #fff; }
        tr:nth-child(even) { background: #f0f8f0; }
        .btn { padding: 7px 16px; background: #1a5c2a; color: #fff; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 14px; }
        .btn:hover { background: #145020; }
        .btn-del { background: #c0392b; }
        .btn-del:hover { background: #962d22; }
        label { display: inline-block; width: 160px; }
        input[type=text], input[type=email], input[type=date], select, textarea {
            width: 280px; padding: 6px; border: 1px solid #999; border-radius: 4px;
        }
        .form-row { margin-bottom: 10px; }
        .msg-ok  { color: green; font-weight: bold; }
        .msg-err { color: red;   font-weight: bold; }
        .pages a, .pages span {
            display: inline-block; padding: 4px 10px; margin: 2px;
            border: 1px solid #1a5c2a; border-radius: 4px; text-decoration: none; color: #1a5c2a;
        }
        .pages span { background: #1a5c2a; color: #fff; }
        .pages a:hover { background: #d0eeda; }
        .edit-links a { display: inline-block; margin: 4px; padding: 5px 10px; border: 1px solid #ccc; border-radius: 4px; text-decoration: none; color: #333; }
        .edit-links a:hover { border-color: #1a5c2a; }
        .edit-links .cur { background: #e8f5e9; border-color: #1a5c2a; font-weight: bold; }
    </style>
</head>
<body>

<?php echo getMenu($_GET['p'], $_GET['sort'] ?? 'byid'); ?>

<main>
<?php
switch ($_GET['p']) {
    case 'viewer': include 'viewer.php'; break;
    case 'add':    include 'add.php';    break;
    case 'edit':   include 'edit.php';   break;
    case 'delete': include 'delete.php'; break;
}
?>
</main>

</body>
</html>
