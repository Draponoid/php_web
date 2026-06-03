<?php
// ЛР А-4: Пользовательские функции. Вывод таблиц.
// Формат структуры: "C1*C2*C3#C4*C5*C6"  (* — разделитель колонок, # — разделитель строк)

$cols = 3; // число колонок (0 — не выводить таблицы)

// Массив структур таблиц (не менее 10 элементов)
$tables = [
    'Яблоко*Красное*Сладкое#Банан*Жёлтый*Сладкий#Лимон*Жёлтый*Кислый',
    'PHP*Серверный*Веб#Python*Серверный*Универсальный#JavaScript*Клиентский*Веб',
    'HTML*Разметка*Статика#CSS*Стили*Визуал#PHP*Логика*Динамика',
    'Москва*Россия*14млн#Лондон*Великобритания*9млн#Париж*Франция*2млн',
    'Сложение*+*a+b#Вычитание*-*a-b#Умножение***a*b',
    'GET*URL-параметры*Небезопасный#POST*Тело запроса*Безопасный',
    'MySQL*Реляционная*SQL#MongoDB*Документная*NoSQL#Redis*Ключ-значение*NoSQL',
    'for*Цикл со счётчиком*i++#while*Цикл с предусловием*условие#do-while*Цикл с постусловием*условие',
    'isset()*Существует ли*переменная#empty()*Пустая ли*переменная#is_null()*Равна ли*null',
    'echo*Вывод строки*нет возврата#print*Вывод строки*возвращает 1#printf*Форматирование*нет возврата',
];

// ---- Функции ----

/**
 * Формирует HTML одной строки таблицы из строки "C1*C2*...*Cn".
 * Если ячеек меньше $cols — добавляет пустые; если больше — обрезает.
 */
function getTR(string $data, int $cols): string {
    $cells = explode('*', $data);
    if (count($cells) === 0) return '';

    $ret = '<tr>';
    for ($i = 0; $i < $cols; $i++) {
        $ret .= '<td>' . htmlspecialchars($cells[$i] ?? '') . '</td>';
    }
    $ret .= '</tr>';
    return $ret;
}

/**
 * Выводит таблицу по структуре. Возвращает HTML-код или сообщение об ошибке.
 */
function buildTable(string $structure, int $cols, int $num): string {
    if ($cols === 0) {
        return '<p style="color:red;">Неправильное число колонок</p>';
    }

    $rows = explode('#', $structure);

    if (count($rows) === 0 || $structure === '') {
        return '<p style="color:red;">В таблице нет строк</p>';
    }

    $html = '';
    foreach ($rows as $row) {
        if ($row === '') continue;
        $html .= getTR($row, $cols);
    }

    if ($html === '') {
        return '<p style="color:red;">В таблице нет строк с ячейками</p>';
    }

    return "<h2>Таблица №$num</h2><table>$html</table>";
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Иванов И.И., ВЕБ-11 — ЛР А-4</title>
    <style>
        body  { font-family: Arial, sans-serif; background: #f0f0f0; padding: 20px; }
        h1    { color: #1a5c2a; }
        h2    { margin-top: 24px; color: #333; }
        table { border-collapse: collapse; margin: 8px 0 20px; }
        td, th { border: 1px solid #000; padding: 7px 14px; }
    </style>
</head>
<body>
<h1>ЛР А-4 — Пользовательские функции. Вывод таблиц.</h1>
<p>Число колонок: <strong><?php echo $cols; ?></strong></p>

<?php
foreach ($tables as $i => $structure) {
    echo buildTable($structure, $cols, $i + 1);
}
?>
</body>
</html>
