<?php
// ЛР А-6: Формы. Тест математических знаний.

$result     = null;
$out_text   = '';
$show_form  = true;

if (isset($_POST['A'])) {
    $A    = str_replace(',', '.', $_POST['A']);
    $B    = str_replace(',', '.', $_POST['B']);
    $C    = str_replace(',', '.', $_POST['C']);
    $task = $_POST['task'] ?? 'mean';

    // Вычисление правильного ответа
    switch ($task) {
        case 'mean':
            $result = round(((float)$A + (float)$B + (float)$C) / 3, 2);
            $task_name = 'Среднее арифметическое';
            break;
        case 'perimeter':
            $result = round((float)$A + (float)$B + (float)$C, 2);
            $task_name = 'Периметр треугольника';
            break;
        case 'volume':
            $result = round((float)$A * (float)$B * (float)$C, 2);
            $task_name = 'Объём параллелепипеда';
            break;
        case 'hypotenuse':
            $result = round(sqrt((float)$A ** 2 + (float)$B ** 2), 2);
            $task_name = 'Гипотенуза прямоугольного треугольника';
            break;
        case 'area_triangle':
            $s = ((float)$A + (float)$B + (float)$C) / 2;
            $area_sq = $s * ($s - (float)$A) * ($s - (float)$B) * ($s - (float)$C);
            $result = $area_sq >= 0 ? round(sqrt($area_sq), 2) : 'error';
            $task_name = 'Площадь треугольника (формула Герона)';
            break;
        case 'quadratic':
            // ax² + bx + c = 0 → D = b²-4ac
            $D = (float)$B ** 2 - 4 * (float)$A * (float)$C;
            $result = round($D, 2);
            $task_name = 'Дискриминант квадратного уравнения';
            break;
        default:
            $result = 0; $task_name = 'Неизвестная задача';
    }

    $user_answer = trim($_POST['answer'] ?? '');
    $passed = ($user_answer !== '' && (string)$result === $user_answer);

    // Формирование отчёта
    $out_text  = "<p><strong>ФИО:</strong> " . htmlspecialchars($_POST['fio'] ?? '') . "</p>";
    $out_text .= "<p><strong>Группа:</strong> " . htmlspecialchars($_POST['group'] ?? '') . "</p>";
    if (!empty($_POST['about']))
        $out_text .= "<p><em>" . nl2br(htmlspecialchars($_POST['about'])) . "</em></p>";
    $out_text .= "<p><strong>Задача:</strong> $task_name</p>";
    $out_text .= "<p><strong>Входные данные:</strong> A = $A, B = $B, C = $C</p>";
    $out_text .= "<p><strong>Правильный ответ:</strong> $result</p>";
    $out_text .= "<p><strong>Ваш ответ:</strong> " . htmlspecialchars($user_answer) . "</p>";
    if ($user_answer === '') {
        $out_text .= '<p style="color:orange;"><strong>Задача самостоятельно решена не была.</strong></p>';
    } elseif ($passed) {
        $out_text .= '<p style="color:green;font-size:18px;"><strong>✓ ТЕСТ ПРОЙДЕН</strong></p>';
    } else {
        $out_text .= '<p style="color:red;font-size:18px;"><strong>✗ ОШИБКА: ТЕСТ НЕ ПРОЙДЕН</strong></p>';
    }

    // Отправка на email
    if (!empty($_POST['send_mail']) && !empty($_POST['email'])) {
        $plain = strip_tags(str_replace(['<br>', '<p>', '</p>'], ["\n", "\n", ""], $out_text));
        @mail(
            $_POST['email'],
            'Результат теста',
            $plain,
            "From: test@example.com\r\nContent-Type: text/plain; charset=utf-8"
        );
        $out_text .= '<p>Результаты теста автоматически отправлены на e-mail: '
                   . htmlspecialchars($_POST['email']) . '</p>';
    }

    $show_form = false;
}

// При повторном тесте — сохраняем ФИО/группу
$saved_fio   = htmlspecialchars($_GET['fio']   ?? '');
$saved_group = htmlspecialchars($_GET['group'] ?? '');
$view_mode   = $_POST['view_mode'] ?? 'browser';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Иванов И.И., ВЕБ-11 — ЛР А-6</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
        h1   { color: #1a5c2a; }
        label { display: inline-block; width: 220px; vertical-align: top; }
        input[type=text], textarea, select {
            width: 280px; padding: 6px 8px; border: 1px solid #999; border-radius: 4px;
        }
        .row    { margin-bottom: 10px; }
        button, .btn-link {
            padding: 8px 20px; background: #1a5c2a; color: #fff; border: none;
            border-radius: 4px; cursor: pointer; font-size: 15px; text-decoration: none;
        }
        button:hover, .btn-link:hover { background: #145020; }
        #email-row { display: none; }
        .report { background: #fff; border: 1px solid #ccc; border-radius: 6px; padding: 20px; max-width: 600px; }
        @media print { .no-print { display: none; } }
    </style>
    <script>
        function toggleEmail(cb) {
            document.getElementById('email-row').style.display = cb.checked ? 'block' : 'none';
        }
    </script>
</head>
<body>
<h1>ЛР А-6 — Тест математических знаний</h1>

<?php if ($show_form): ?>
<form method="post" action="/">
    <div class="row">
        <label>ФИО:</label>
        <input type="text" name="fio" value="<?php echo $saved_fio; ?>" placeholder="Иванов И.И.">
    </div>
    <div class="row">
        <label>Группа:</label>
        <input type="text" name="group" value="<?php echo $saved_group; ?>" placeholder="ВЕБ-11">
    </div>
    <div class="row">
        <label>О себе:</label>
        <textarea name="about" rows="3" placeholder="Немного о себе..."></textarea>
    </div>
    <div class="row">
        <label>Задача:</label>
        <select name="task">
            <option value="mean">Среднее арифметическое</option>
            <option value="perimeter">Периметр треугольника</option>
            <option value="volume">Объём параллелепипеда</option>
            <option value="hypotenuse">Гипотенуза прямоугольного треугольника</option>
            <option value="area_triangle">Площадь треугольника (формула Герона)</option>
            <option value="quadratic">Дискриминант квадратного уравнения</option>
        </select>
    </div>
    <div class="row">
        <label>A:</label>
        <input type="text" name="A" value="<?php echo mt_rand(1,99); ?>">
    </div>
    <div class="row">
        <label>B:</label>
        <input type="text" name="B" value="<?php echo mt_rand(1,99); ?>">
    </div>
    <div class="row">
        <label>C:</label>
        <input type="text" name="C" value="<?php echo mt_rand(1,99); ?>">
    </div>
    <div class="row">
        <label>Ваш ответ:</label>
        <input type="text" name="answer" placeholder="Введите результат">
    </div>
    <div class="row">
        <label>Вид страницы:</label>
        <select name="view_mode">
            <option value="browser">Для браузера</option>
            <option value="print">Для печати</option>
        </select>
    </div>
    <div class="row">
        <label></label>
        <input type="checkbox" name="send_mail" onchange="toggleEmail(this)"> Отправить на e-mail
    </div>
    <div id="email-row" class="row">
        <label>E-mail:</label>
        <input type="text" name="email" placeholder="user@example.com">
    </div>
    <div class="row">
        <label></label>
        <button type="submit">Проверить</button>
    </div>
</form>

<?php else: ?>

<div class="report">
    <?php echo $out_text; ?>
</div>

<?php if ($view_mode === 'browser'): ?>
<br>
<a class="btn-link no-print"
   href="?fio=<?php echo urlencode($_POST['fio'] ?? ''); ?>&group=<?php echo urlencode($_POST['group'] ?? ''); ?>">
    Повторить тест
</a>
<?php endif; ?>

<?php endif; ?>

</body>
</html>
