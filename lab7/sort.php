<?php
// ЛР А-7: Алгоритмы сортировки массивов

// ---- Валидация и сборка массива ----
if (!isset($_POST['element0'])) {
    die('<p style="color:red;">Массив не задан, сортировка невозможна.</p>');
}

$len = (int)($_POST['arrLen'] ?? 1);
$arr = [];

for ($i = 0; $i < $len; $i++) {
    $val = trim($_POST['element' . $i] ?? '');
    if ($val === '') continue;
    if (!is_numeric($val)) {
        die("<p style='color:red;'>Элемент «$val» не является числом.</p>");
    }
    $arr[] = (float)$val;
}

if (empty($arr)) {
    die('<p style="color:orange;">Нет числовых элементов для сортировки.</p>');
}

$algo = $_POST['algorithm'] ?? 'selection';
$algo_names = [
    'selection' => 'Сортировка выбором',
    'bubble'    => 'Пузырьковая сортировка',
    'insertion' => 'Сортировка вставками',
    'gnome'     => 'Алгоритм садового гнома',
    'shell'     => 'Алгоритм Шелла',
    'builtin'   => 'Встроенная функция PHP (sort)',
];

// ---- Алгоритмы сортировки ----

function sortSelection(array $a): array {
    $n = count($a); $iters = 0; $log = [];
    for ($i = 0; $i < $n - 1; $i++) {
        $min = $i;
        for ($j = $i + 1; $j < $n; $j++) {
            $iters++;
            if ($a[$j] < $a[$min]) $min = $j;
        }
        if ($min !== $i) { [$a[$i], $a[$min]] = [$a[$min], $a[$i]]; }
        $log[] = ['iter' => $iters, 'state' => $a];
    }
    return ['arr' => $a, 'iters' => $iters, 'log' => $log];
}

function sortBubble(array $a): array {
    $n = count($a); $iters = 0; $log = [];
    for ($j = 0; $j < $n - 1; $j++) {
        for ($i = 0; $i < $n - 1 - $j; $i++) {
            $iters++;
            if ($a[$i] > $a[$i + 1]) { [$a[$i], $a[$i + 1]] = [$a[$i + 1], $a[$i]]; }
        }
        $log[] = ['iter' => $iters, 'state' => $a];
    }
    return ['arr' => $a, 'iters' => $iters, 'log' => $log];
}

function sortInsertion(array $a): array {
    $n = count($a); $iters = 0; $log = [];
    for ($i = 1; $i < $n; $i++) {
        $val = $a[$i]; $j = $i - 1;
        while ($j >= 0 && $a[$j] > $val) { $a[$j + 1] = $a[$j]; $j--; $iters++; }
        $a[$j + 1] = $val;
        $log[] = ['iter' => ++$iters, 'state' => $a];
    }
    return ['arr' => $a, 'iters' => $iters, 'log' => $log];
}

function sortGnome(array $a): array {
    $n = count($a); $i = 1; $j = 2; $iters = 0; $log = [];
    while ($i < $n) {
        $iters++;
        if (!$i || $a[$i - 1] <= $a[$i]) { $i = $j++; }
        else { [$a[$i], $a[$i - 1]] = [$a[$i - 1], $a[$i]]; $i--; }
        $log[] = ['iter' => $iters, 'state' => $a];
    }
    return ['arr' => $a, 'iters' => $iters, 'log' => $log];
}

function sortShell(array $a): array {
    $n = count($a); $iters = 0; $log = [];
    for ($k = (int)ceil($n / 2); $k >= 1; $k = (int)ceil($k / 2)) {
        for ($i = $k; $i < $n; $i++) {
            $val = $a[$i]; $j = $i - $k;
            while ($j >= 0 && $a[$j] > $val) {
                $a[$j + $k] = $a[$j]; $j -= $k; $iters++;
            }
            $a[$j + $k] = $val;
            $log[] = ['iter' => ++$iters, 'state' => $a];
        }
        if ($k === 1) break;
    }
    return ['arr' => $a, 'iters' => $iters, 'log' => $log];
}

// ---- Запуск ----
$start = microtime(true);

if ($algo === 'builtin') {
    $sorted = $arr;
    sort($sorted);
    $res = ['arr' => $sorted, 'iters' => 0, 'log' => []];
} else {
    $fn = ['selection'=>'sortSelection','bubble'=>'sortBubble',
           'insertion'=>'sortInsertion','gnome'=>'sortGnome','shell'=>'sortShell'];
    $res = $fn[$algo]($arr);
}

$elapsed = round(microtime(true) - $start, 6);

function arrStr(array $a): string {
    return '[' . implode(', ', $a) . ']';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>ЛР А-7 — Сортировка</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 20px; }
        h1   { color: #1a5c2a; }
        .arr-el { display:inline-block; border:1px solid #1a5c2a; padding:3px 8px; margin:2px; border-radius:4px; background:#fff; }
        .iter-row { margin:4px 0; font-size:14px; }
        hr { margin:16px 0; }
    </style>
</head>
<body>
<h1>ЛР А-7 — <?php echo $algo_names[$algo]; ?></h1>

<p><strong>Исходный массив:</strong><br>
<?php foreach ($arr as $v) echo "<span class='arr-el'>$v</span>"; ?>
</p>
<p style="color:green;">✓ Все элементы — числа. Сортировка возможна.</p>
<hr>

<?php if (!empty($res['log'])): ?>
<h2>Ход сортировки</h2>
<?php foreach ($res['log'] as $step): ?>
    <div class="iter-row">
        <strong>Итерация <?php echo $step['iter']; ?>:</strong>
        <?php foreach ($step['state'] as $v) echo "<span class='arr-el'>$v</span>"; ?>
    </div>
<?php endforeach; ?>
<hr>
<?php endif; ?>

<p><strong>Отсортированный массив:</strong><br>
<?php foreach ($res['arr'] as $v) echo "<span class='arr-el'>$v</span>"; ?>
</p>
<p>Сортировка завершена, проведено <strong><?php echo $res['iters']; ?></strong> итераций.
   Сортировка заняла <strong><?php echo $elapsed; ?></strong> с.</p>
</body>
</html>
