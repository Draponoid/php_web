<?php
// ЛР А-2: Циклические алгоритмы. Табулирование функций

// Вариант 1: f(x) = 10x-5 при x≤10; (x+3)*x² при 10<x<20; 3/(x-25)+2 при x≥20
$x          = -10;   // начальное значение аргумента
$count      = 30;    // количество вычисляемых значений
$step       = 2;     // шаг изменения аргумента
$min_val    = -200;  // минимальное значение, останавливающее вычисления
$max_val    = 2000;  // максимальное значение, останавливающее вычисления
$type       = 'D';   // тип верстки: A, B, C, D или E

// ---- функция вычисления ----
function calc_f($x) {
    if ($x <= 10) {
        return round(10 * $x - 5, 3);
    } elseif ($x < 20) {
        $denom = $x - 3;
        if ($denom == 0) return 'error';
        return round(($x + 3) * $x * $x, 3);
    } else {
        $denom = $x - 25;
        if ($denom == 0) return 'error';
        return round(3 / $denom + 2, 3);
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Иванов И.И., ВЕБ-11 — ЛР А-2, вариант 1</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 15px; background: #f0f0f0; padding: 20px; }
        h1 { color: #1a5c2a; }
        table { border-collapse: collapse; margin: 16px 0; }
        td, th { border: 1px solid #000; padding: 6px 12px; }
        th { background: #1a5c2a; color: #fff; }
        ul, ol { margin: 10px 20px; }
        .block-item {
            display: inline-block; border: 2px solid red;
            padding: 4px 8px; margin: 4px; background: #fff;
        }
        footer { margin-top: 20px; color: #555; font-size: 13px; }
    </style>
</head>
<body>
<h1>ЛР А-2 — Табулирование функции (вариант 1)</h1>
<p><strong>Тип верстки:</strong> <?php echo $type; ?></p>

<?php

$values = [];   // для статистики
$sum    = 0;
$iter   = 0;

// Открывающий тег для типов B/C/E
if ($type === 'B') echo '<ul>';
if ($type === 'C') echo '<ol>';
if ($type === 'D') {
    echo '<table>';
    echo '<tr><th>№</th><th>x</th><th>f(x)</th></tr>';
}
if ($type === 'E') echo '<div style="overflow:hidden;">';

for ($i = 0; $i < $count; $i++, $x += $step) {
    $f = calc_f($x);

    // Проверка ограничений
    if (is_numeric($f) && ($f >= $max_val || $f < $min_val)) break;

    $iter++;

    // Накапливаем для статистики только числовые значения
    if (is_numeric($f)) {
        $values[] = $f;
        $sum += $f;
    }

    $line = "f($x) = $f";

    switch ($type) {
        case 'A':
            echo $line . ($i < $count - 1 ? '<br>' : '');
            break;
        case 'B':
            echo "<li>$line</li>";
            break;
        case 'C':
            echo "<li>$line</li>";
            break;
        case 'D':
            echo "<tr><td>" . ($iter) . "</td><td>$x</td><td>$f</td></tr>";
            break;
        case 'E':
            echo "<div class=\"block-item\">$line</div>";
            break;
    }
}

// Закрывающий тег
if ($type === 'B') echo '</ul>';
if ($type === 'C') echo '</ol>';
if ($type === 'D') echo '</table>';
if ($type === 'E') echo '</div>';

// Статистика
if (count($values) > 0) {
    $max  = max($values);
    $min  = min($values);
    $avg  = round($sum / count($values), 3);
    echo "<hr><p><strong>Итого:</strong> итераций = $iter, ";
    echo "max = $max, min = $min, среднее = $avg, сумма = " . round($sum, 3) . "</p>";
}
?>

<footer>Тип верстки: <?php echo $type; ?> | Сформировано: <?php echo date('d.m.Y H:i:s'); ?></footer>
</body>
</html>
