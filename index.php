<?php
$page_title = "Главная страница"; 
$current_file = "index.php";      

$student_fio = "Крамской И.С.";
$student_group = "241-351";
$lab_number = "4";
$variant = "1";

$target_cols = 2;

$structures_array = array(
    'C1*C2*C3#C4*C5*C6',                                // 1. Обычная таблица
    'C7*C8*C9#C10*C11*C12',                             // 2. Обычная таблица
    'C13*C14*C15#C16*C17*C18',                          // 3. Обычная таблица
    'Шифрование*Хэширование*VPN#Троян*Червь*Руткит',    // 4. Таблица по ИБ
    'A1*A2#B1*B2*B3*B4*B5',                             // 5. Недостаток и избыток колонок
    'Только одна ячейка',                               // 6. Нет спецсимволов
    '',                                                 // 7. Пустая структура
    '#',                                                // 8. Только разделитель строк
    'Один*Два*Три#Четыре*Пять#Шесть*Семь*Восемь*Девять',// 9. Три строки
    'Данные 1*Данные 2'                                 // 10. Недостаток колонок
);

// Функция формирования содержимого отдельной строки таблицы
function getTR($data, $cols) {
    if (trim($data) === '') {
        return '';
    }

    $arr = explode('*', $data);
    $ret = '<tr>';
    
    for ($i = 0; $i < $cols; $i++) {
        $cell_value = isset($arr[$i]) ? $arr[$i] : ''; 
        $ret .= '<td>' . htmlspecialchars($cell_value) . '</td>';
    }
    
    return $ret . '</tr>';
}

// Функция вывода HTML-кода таблицы
function outTable($structure, $table_num, $cols) {

    echo "<h2>Таблица №" . $table_num . "</h2>\n";

    if ($cols <= 0) {
        echo "<p>Неправильное число колонок</p>\n";
        return;
    }

    if ($structure === '') {
        echo "<p>В таблице нет строк</p>\n";
        return;
    }

    $strings = explode('#', $structure);
    $datas = '';                         
    
    for ($i = 0; $i < count($strings); $i++) { 
        $datas .= getTR($strings[$i], $cols); 
    }

    if ($datas) { 
        echo "<table>\n" . $datas . "</table>\n"; 
    } else { 
        echo "<p>В таблице нет строк с ячейками</p>\n"; 
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo $student_fio . ' - ЛР' . $lab_number . ' - ' . $page_title; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div style="position: absolute; left: 20px; font-weight: bold;">
        <img src="fotos/3.jpg" alt="Логотип университета" style="height: 40px; vertical-align: middle;">
    </div>
    <nav>
        <a href="<?php $name='Главная'; $link='index.php'; echo $link; ?>" 
           <?php if($current_file == $link) echo 'class="selected_menu"'; ?>><?php echo $name; ?></a>

        <a href="<?php $name='Вторая страница'; $link='page2.php'; echo $link; ?>" 
           <?php if($current_file == $link) echo 'class="selected_menu"'; ?>><?php echo $name; ?></a>

        <a href="<?php $name='Третья страница'; $link='page3.php'; echo $link; ?>" 
           <?php if($current_file == $link) echo 'class="selected_menu"'; ?>><?php echo $name; ?></a>
    </nav>
    <div style="position: absolute; right: 20px; font-size: 0.8em; text-align: right; line-height: 1.2;">
        ФИО: <?php echo $student_fio; ?><br>
        Группа: <?php echo $student_group; ?> | ЛР №<?php echo $lab_number; ?> | Вар. <?php echo $variant; ?>
    </div>
</header>

<main class="content">
    <h1><?php echo $page_title; ?></h1>
    
    <div style="text-align: center; margin: 20px;">
        <?php
        $name_img = (date('s') % 2) + 1;
        echo '<img src="fotos/' . $name_img . '.jpg" alt="Сменяющееся фото" width="300">';
        ?>
    </div>

    <section>
        <h2>Основы информационной безопасности</h2>
        <p>
            Информационная безопасность (ИБ) — это область знаний и практических методов, направленных на защиту данных от несанкционированного доступа, использования, раскрытия, искажения или уничтожения. В современном мире, где цифровые технологии пронизывают все сферы жизни, защита информации становится критически важной задачей как для государственных структур, так и для частных компаний.
        </p>
    </section>

    <section>
        <h2>Результат выполнения ЛР №4</h2>
        <p>Количество колонок в таблицах: <b><?php echo $target_cols; ?></b></p>
        
        <?php
        // Вывод всех таблиц из массива в цикле
        for ($i = 0; $i < count($structures_array); $i++) {
            outTable($structures_array[$i], $i + 1, $target_cols);
        }
        
        // Демонстрация работы при $target_cols = 0
        echo "<h3>Демонстрация ошибки (0 колонок):</h3>";
        outTable('Тест*Тест#Тест*Тест', 11, 0);
        ?>
    </section>
</main>

<footer>
    Сформировано: <span id="local-time"></span>
</footer>

<script>
    function updateTime() {
        const now = new Date();
        document.getElementById('local-time').innerText = now.toLocaleString('ru-RU');
    }
    setInterval(updateTime, 1000);
    updateTime();
</script>

</body>
</html>