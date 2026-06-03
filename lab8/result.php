<?php
// ЛР А-8: Анализ текста (UTF-8 + mb_ функции)

function analyzeText(string $text): array {
    $len      = mb_strlen($text);
    $letters  = 0;
    $upper    = 0;
    $lower    = 0;
    $digits   = 0;
    $punct    = 0;
    $symCounts = [];
    $wordCounts = [];
    $currentWord = '';

    $punctSet = ['.','!','?',',',';',':','—','-','(',')','"',"'", '«','»'];

    for ($i = 0; $i < $len; $i++) {
        $ch = mb_substr($text, $i, 1);
        $chLow = mb_strtolower($ch);

        // Счётчик символов (без пробелов и переносов)
        if ($ch !== ' ' && $ch !== "\n" && $ch !== "\r" && $ch !== "\t") {
            $symCounts[$chLow] = ($symCounts[$chLow] ?? 0) + 1;
        }

        // Буква?
        if (preg_match('/\p{L}/u', $ch)) {
            $letters++;
            if ($ch === mb_strtoupper($ch)) $upper++;
            else                            $lower++;
            $currentWord .= $chLow;
        } elseif (is_numeric($ch)) {
            $digits++;
            $currentWord = ''; // цифра разрывает слово
        } elseif (in_array($ch, $punctSet)) {
            $punct++;
            // Знак препинания = граница слова
            if ($currentWord !== '') {
                $wordCounts[$currentWord] = ($wordCounts[$currentWord] ?? 0) + 1;
                $currentWord = '';
            }
        } else {
            // Пробел или другой разделитель
            if ($currentWord !== '') {
                $wordCounts[$currentWord] = ($wordCounts[$currentWord] ?? 0) + 1;
                $currentWord = '';
            }
        }
    }
    // Последнее слово
    if ($currentWord !== '') {
        $wordCounts[$currentWord] = ($wordCounts[$currentWord] ?? 0) + 1;
    }

    ksort($wordCounts);
    ksort($symCounts);

    return [
        'len'       => $len,
        'letters'   => $letters,
        'upper'     => $upper,
        'lower'     => $lower,
        'digits'    => $digits,
        'punct'     => $punct,
        'words'     => array_sum(array_values($wordCounts)),
        'wordCounts'=> $wordCounts,
        'symCounts' => $symCounts,
    ];
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>ЛР А-8 — Результат анализа</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 20px; }
        h1   { color: #1a5c2a; }
        .src { color: #004080; font-style: italic; background: #e8f0ff; padding: 12px; border-radius: 6px; margin: 16px 0; white-space: pre-wrap; }
        table { border-collapse: collapse; margin: 16px 0; }
        td, th { border: 1px solid #999; padding: 7px 14px; }
        th { background: #1a5c2a; color: #fff; }
        a.back { display: inline-block; margin-top: 20px; padding: 8px 18px; background: #1a5c2a; color: #fff; border-radius: 4px; text-decoration: none; }
    </style>
</head>
<body>
<h1>ЛР А-8 — Результат анализа текста</h1>

<?php
if (!isset($_POST['data']) || $_POST['data'] === '') {
    echo '<p style="color:red;">Нет текста для анализа.</p>';
} else {
    $text = $_POST['data'];
    echo '<p><strong>Исходный текст:</strong></p>';
    echo '<div class="src">' . htmlspecialchars($text) . '</div>';

    $r = analyzeText($text);

    echo '<h2>Общая информация</h2>';
    echo '<table>';
    echo '<tr><th>Параметр</th><th>Значение</th></tr>';
    echo '<tr><td>Символов всего (включая пробелы)</td><td>' . $r['len']     . '</td></tr>';
    echo '<tr><td>Букв</td><td>'                               . $r['letters'] . '</td></tr>';
    echo '<tr><td>Строчных букв</td><td>'                      . $r['lower']   . '</td></tr>';
    echo '<tr><td>Заглавных букв</td><td>'                     . $r['upper']   . '</td></tr>';
    echo '<tr><td>Знаков препинания</td><td>'                  . $r['punct']   . '</td></tr>';
    echo '<tr><td>Цифр</td><td>'                               . $r['digits']  . '</td></tr>';
    echo '<tr><td>Слов</td><td>'                               . $r['words']   . '</td></tr>';
    echo '</table>';

    echo '<h2>Количество вхождений каждого символа</h2>';
    echo '<table><tr><th>Символ</th><th>Вхождений</th></tr>';
    foreach ($r['symCounts'] as $sym => $cnt) {
        echo '<tr><td>' . htmlspecialchars($sym) . '</td><td>' . $cnt . '</td></tr>';
    }
    echo '</table>';

    echo '<h2>Слова и их вхождения (по алфавиту)</h2>';
    echo '<table><tr><th>Слово</th><th>Вхождений</th></tr>';
    foreach ($r['wordCounts'] as $word => $cnt) {
        echo '<tr><td>' . htmlspecialchars($word) . '</td><td>' . $cnt . '</td></tr>';
    }
    echo '</table>';
}
?>

<a class="back" href="index.html">← Другой анализ</a>
</body>
</html>
