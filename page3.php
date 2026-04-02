<?php
// Запускаем сессию для создания нашей "собственной истории" кликов
session_start();

// Отлавливаем жесткую перезагрузку (Ctrl + F5)
if (isset($_SERVER['HTTP_CACHE_CONTROL']) && strpos(strtolower($_SERVER['HTTP_CACHE_CONTROL']), 'no-cache') !== false) {
    unset($_SESSION['my_visited_links']); // Стираем нашу историю ссылок
}

// Если истории еще нет, создаем пустой массив
if (!isset($_SESSION['my_visited_links'])) {
    $_SESSION['my_visited_links'] = [];
}

// === БЛОК НАСТРОЕК ===
$page_title = "Таблица умножения";
$student_fio = "Крамской И.С.";
$student_group = "241-351";
$lab_number = "5"; 
$current_file = basename($_SERVER['PHP_SELF']); 

// Извлекаем параметры для таблицы
$html_type = isset($_GET['html_type']) ? $_GET['html_type'] : 'TABLE';
$content = isset($_GET['content']) ? $_GET['content'] : 'all';

// 1. Запоминаем саму таблицу (для бокового меню и цифр)
$current_state_id = $html_type . '_' . $content;
$_SESSION['my_visited_links'][$current_state_id] = true;

// 2. Запоминаем тип верстки (для верхнего меню)
$_SESSION['my_visited_links']['layout_' . $html_type] = true;

// Функция, которая решает, какого цвета должна быть ссылка таблицы/цифры
function getLinkColorClass($target_type, $target_content) {
    $state_id = $target_type . '_' . $target_content;
    return isset($_SESSION['my_visited_links'][$state_id]) ? 'link-purple' : 'link-blue';
}

// === БЛОК ФУНКЦИЙ ===
function outNumAsLink($x) {
    global $html_type; 
    if ($x <= 9) {
        $class = getLinkColorClass($html_type, $x);
        return '<a href="?html_type=' . $html_type . '&content=' . $x . '" class="' . $class . '">' . $x . '</a>';
    }
    return $x; 
}

function outRow($n) {
    for ($i = 2; $i <= 9; $i++) {
        echo '<div style="border-bottom: 1px solid #ddd; padding: 5px 0;">';
        echo outNumAsLink($n) . ' x ' . outNumAsLink($i) . ' = ' . outNumAsLink($i * $n);
        echo '</div>';
    }
}

// 1. СТРОГАЯ ТАБЛИЧНАЯ ВЕРСТКА
function outTableForm($content) {
    echo '<table border="1" style="border-collapse: collapse; margin: auto; background: #fff; border: 2px solid #000;"><tr>';
    if ($content == 'all') {
        for ($i = 2; $i <= 9; $i++) {
            echo '<td style="padding: 10px; vertical-align: top; border: 1px solid #000;">';
            outRow($i);
            echo '</td>';
        }
    } else {
        echo '<td style="padding: 20px; font-size: 1.2em; border: 1px solid #000;">';
        outRow($content);
        echo '</td>';
    }
    echo '</tr></table>';
}

// 2. ОТЛИЧАЮЩАЯСЯ БЛОЧНАЯ ВЕРСТКА
function outDivForm($content) {
    echo '<div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px;">';
    if ($content == 'all') {
        for ($i = 2; $i <= 9; $i++) {
            echo '<div style="border: 2px dashed #004d00; border-radius: 12px; padding: 15px; background: #e8f5e9;">';
            outRow($i);
            echo '</div>';
        }
    } else {
        echo '<div style="border: 3px dashed #004d00; border-radius: 15px; padding: 30px; font-size: 1.4em; background: #e8f5e9;">';
        outRow($content);
        echo '</div>';
    }
    echo '</div>';
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo $student_fio . ' - ЛР' . $lab_number; ?></title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 0; display: flex; flex-direction: column; min-height: 100vh; background-color: #f9f9f9; }
        
        header { background-color: #004d00; color: white; padding: 10px 30px; display: flex; justify-content: space-between; align-items: center; }
        .header-left { display: flex; align-items: center; gap: 15px; font-size: 14px; text-align: left; line-height: 1.4; }
        .logo-placeholder { width: 50px; height: 50px; background: conic-gradient(from 90deg, #111, #555, #ccc, #fff, #111); border-radius: 50%; position: relative; }
        .logo-placeholder::after { content: ''; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 22px; height: 22px; background: #004d00; border-radius: 50%; }
        
        .header-nav { display: flex; gap: 40px; font-size: 18px; font-weight: bold; }
        .header-nav a { color: white !important; text-decoration: none; }
        .header-nav a.active { color: #ff3300 !important; text-decoration: none; } 

        .sub-menu { background: #e9ecef; padding: 10px; text-align: center; border-bottom: 1px solid #ccc; }
        .sub-menu a { text-decoration: none; margin: 0 10px; font-weight: bold; padding: 5px; }
        
        .container { display: flex; flex: 1; }
        #product_menu { width: 220px; background: #fff; border-right: 1px solid #ccc; padding: 20px; }
        
        #product_menu a { display: block; padding: 8px; text-decoration: none; }
        #product_menu a:hover { background-color: #f0f0f0; }
        
        /* === НАШИ ПРИНУДИТЕЛЬНЫЕ ЦВЕТА ССЫЛОК === */
        a.link-blue { color: blue !important; text-decoration: none; }
        a.link-purple { color: purple !important; text-decoration: none; }
        a.link-blue:hover, a.link-purple:hover { text-decoration: underline; }
        
        #main_content { flex: 1; padding: 30px; text-align: center; }
        footer { background: #e9ecef; padding: 15px; text-align: center; border-top: 1px solid #ccc; }
    </style>
</head>
<body>

<header>
    <div class="header-left">
        <div class="logo-placeholder"></div>
        <div>
            ФИО: <?php echo $student_fio; ?><br>
            Группа: <?php echo $student_group; ?> | ЛР №<?php echo $lab_number; ?>
        </div>
    </div>
    
    <nav class="header-nav">
        <a href="index.php" <?php if ($current_file == 'index.php') echo 'class="active"'; ?>>Главная</a>
        <a href="page2.php" <?php if ($current_file == 'page2.php') echo 'class="active"'; ?>>Вторая страница</a>
        <a href="page3.php" <?php if ($current_file == 'page3.php') echo 'class="active"'; ?>>Третья страница</a> 
    </nav>
</header>

<div class="sub-menu">
    <?php 
    $c_param = ($content != 'all') ? "&content=" . $content : ""; 
    
    // Проверяем, нажимали ли мы на эти типы верстки в текущей сессии
    $class_table = isset($_SESSION['my_visited_links']['layout_TABLE']) ? 'link-purple' : 'link-blue';
    $class_div = isset($_SESSION['my_visited_links']['layout_DIV']) ? 'link-purple' : 'link-blue';
    ?>
    <a href="?html_type=TABLE<?php echo $c_param; ?>" class="<?php echo $class_table; ?>">Табличная верстка</a> | 
    <a href="?html_type=DIV<?php echo $c_param; ?>" class="<?php echo $class_div; ?>">Блочная верстка</a>
</div>

<div class="container">
    <aside id="product_menu">
        <?php $class_all = getLinkColorClass($html_type, 'all'); ?>
        <a href="?html_type=<?php echo $html_type; ?>" class="<?php echo $class_all; ?>">Всё</a>

        <?php for ($i = 2; $i <= 9; $i++): ?>
            <?php $class_num = getLinkColorClass($html_type, $i); ?>
            <a href="?html_type=<?php echo $html_type; ?>&content=<?php echo $i; ?>" class="<?php echo $class_num; ?>">Таблица на <?php echo $i; ?></a>
        <?php endfor; ?>
    </aside>

    <main id="main_content">
        <?php
        if ($html_type == 'DIV') {
            outDivForm($content);
        } else {
            outTableForm($content);
        }
        ?>
    </main>
</div>

<footer>
    <?php
    $t_info = ($html_type == 'TABLE') ? "Табличная верстка. " : "Блочная верстка. ";
    $c_info = ($content == 'all') ? "Вся таблица умножения. " : "Столбец на $content. ";
    echo $t_info . $c_info . "Дата: " . date('d.m.Y H:i:s');
    ?>
</footer>

</body>
</html>