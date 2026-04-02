<?php
$page_title = "Вторая страница"; 
$current_file = "page2.php";      


$student_fio = "Крамской И.С.";
$student_group = "241-351";
$lab_number = "3";
$variant = "1";


// 1. Читаем предыдущее состояние из URL (если оно есть)
$store = isset($_GET['store']) ? $_GET['store'] : '';
$clicks = isset($_GET['clicks']) ? (int)$_GET['clicks'] : 0;

// 2. Обрабатываем нажатие кнопки (параметр 'key')
if (isset($_GET['key'])) {
    $clicks++; 
    
    if ($_GET['key'] === 'reset') {
        $store = '';
    } else {
        $store .= $_GET['key']; 
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo $student_fio . ' - ЛР' . $lab_number . ' - ' . $page_title; ?></title>
    <link rel="stylesheet" href="style.css"> 
    
    <style>
        .keyboard-container {
            width: 350px;
            margin: 40px auto;
            background-color: #f0f0f0;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        .result-window {
            height: 50px;
            line-height: 50px;
            background-color: #fff;
            border: 1px solid #999;
            text-align: center;
            font-size: 24px;
            font-family: monospace;
            letter-spacing: 2px;
            margin-bottom: 20px;
            border-radius: 5px;
            overflow: hidden;
        }
        .keys-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .key-btn {
            display: block;
            width: 55px;
            height: 55px;
            line-height: 55px;
            text-align: center;
            background-color: #e6e6e6;
            border: 1px solid #aaa;
            border-radius: 8px;
            text-decoration: none;
            color: #000;
            font-size: 26px;
            transition: background 0.2s, transform 0.1s;
        }
        .key-btn:hover { background-color: #d4d4d4; }
        .key-btn:active { transform: scale(0.95); }
        
        .key-reset {
            display: block;
            width: 100%;
            height: 55px;
            line-height: 55px;
            text-align: center;
            background-color: #e6e6e6;
            border: 1px solid #aaa;
            border-radius: 8px;
            text-decoration: none;
            color: #000;
            font-size: 22px;
            transition: background 0.2s, transform 0.1s;
        }
        .key-reset:hover { background-color: #d4d4d4; }
        .key-reset:active { transform: scale(0.98); }
    </style>
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
        Группа: <?php echo $student_group; ?> | ЛР №<?php echo $lab_number; ?>
    </div>
</header>

<main class="content">
    <h1 style="text-align: center;">Лабораторная работа №3</h1>
    <p style="text-align: center; color: #555;">Виртуальная клавиатура на основе GET-параметров</p>
    
    <section>
        <div class="keyboard-container">
            <div class="result-window">
                <?php echo htmlspecialchars($store); ?>
            </div>
            
            <div class="keys-row">
                <?php
                for ($i = 1; $i <= 5; $i++) {
                    echo '<a href="?key='.$i.'&store='.$store.'&clicks='.$clicks.'" class="key-btn">'.$i.'</a>';
                }
                ?>
            </div>
            
            <div class="keys-row">
                <?php
                for ($i = 6; $i <= 9; $i++) {
                    echo '<a href="?key='.$i.'&store='.$store.'&clicks='.$clicks.'" class="key-btn">'.$i.'</a>';
                }
                echo '<a href="?key=0&store='.$store.'&clicks='.$clicks.'" class="key-btn">0</a>';
                ?>
            </div>
            
            <a href="?key=reset&store=&clicks=<?php echo $clicks; ?>" class="key-reset">СБРОС</a>
        </div>
    </section>
</main>

<footer>
    <span style="position: absolute; left: 20px;">Нажатий кнопок: <?php echo $clicks; ?></span>
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