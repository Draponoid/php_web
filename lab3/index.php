<?php
// ЛР А-3: Виртуальная клавиатура с GET-параметрами

// Инициализация хранилища
if (!isset($_GET['store'])) {
    $_GET['store'] = '';
}

// Подсчёт нажатий
$clicks = isset($_GET['clicks']) ? (int)$_GET['clicks'] : 0;

// Обработка нажатия кнопки
if (isset($_GET['key'])) {
    if ($_GET['key'] === 'reset') {
        $_GET['store'] = '';
        $clicks = 0;
    } elseif ($_GET['key'] === 'backspace') {
        $_GET['store'] = mb_substr($_GET['store'], 0, -1);
        $clicks++;
    } else {
        $_GET['store'] .= htmlspecialchars($_GET['key'], ENT_QUOTES);
        $clicks++;
    }
}

$store = $_GET['store'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Иванов И.И., ВЕБ-11 — ЛР А-3</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 30px; }
        h1   { color: #1a5c2a; margin-bottom: 20px; }
        .result {
            width: 320px; min-height: 48px; border: 2px solid #1a5c2a;
            border-radius: 6px; background: #fff; text-align: center;
            font-size: 22px; font-weight: bold; padding: 10px; margin-bottom: 16px;
            word-break: break-all;
        }
        .keyboard { width: 320px; }
        .row { display: flex; gap: 8px; margin-bottom: 8px; }
        a.key {
            display: flex; align-items: center; justify-content: center;
            width: 56px; height: 56px; border: 2px solid #555; border-radius: 8px;
            background: #fff; font-size: 20px; text-decoration: none; color: #222;
            font-weight: bold; transition: background 0.15s;
        }
        a.key:hover  { background: #d0eeda; }
        a.key.wide   { width: 120px; font-size: 14px; }
        a.key.reset  { background: #ffe0e0; border-color: #c00; color: #c00; }
        a.key.reset:hover { background: #ffc0c0; }
        .info { margin-top: 12px; color: #555; font-size: 14px; }
    </style>
</head>
<body>
<h1>ЛР А-3 — Виртуальная клавиатура</h1>

<!-- Окно просмотра результата -->
<div class="result"><?php echo $store; ?></div>

<!-- Клавиатура из цифровых кнопок -->
<?php
// Формируем базовую часть ссылки с хранилищем и счётчиком
function key_href($key, $store, $clicks) {
    return '?key=' . urlencode($key) . '&store=' . urlencode($store) . '&clicks=' . $clicks;
}
?>

<div class="keyboard">
    <div class="row">
        <?php foreach ([1,2,3,4,5] as $n): ?>
            <a class="key" href="<?php echo key_href($n, $store, $clicks); ?>"><?php echo $n; ?></a>
        <?php endforeach; ?>
    </div>
    <div class="row">
        <?php foreach ([6,7,8,9,0] as $n): ?>
            <a class="key" href="<?php echo key_href($n, $store, $clicks); ?>"><?php echo $n; ?></a>
        <?php endforeach; ?>
    </div>
    <div class="row">
        <a class="key wide" href="<?php echo key_href('backspace', $store, $clicks); ?>">← DEL</a>
        <a class="key wide reset" href="/?store=&clicks=0">СБРОС</a>
    </div>
</div>

<p class="info">Нажатий с момента загрузки: <strong><?php echo $clicks; ?></strong></p>
</body>
</html>
