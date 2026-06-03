<?php
// ЛР А-5: Динамическое формирование контента. Таблица умножения.

// Параметры: html_type (TABLE|DIV), content (2..9 или отсутствует = вся таблица)
$html_type = isset($_GET['html_type']) ? $_GET['html_type'] : null;
$content   = isset($_GET['content'])   ? (int)$_GET['content'] : null;

// Если тип не задан или задан некорректно — табличная по умолчанию
if (!in_array($html_type, ['TABLE', 'DIV'])) $html_type = null;
if ($content !== null && ($content < 2 || $content > 9)) $content = null;

// ---- Вспомогательные функции ----

/** Превращает число в ссылку на таблицу умножения (только 2..9) */
function numLink(int $n): string {
    if ($n >= 2 && $n <= 9) {
        return '<a href="?content=' . $n . '">' . $n . '</a>';
    }
    return (string)$n;
}

/** Выводит один столбец таблицы умножения */
function outRow(int $n): void {
    for ($i = 2; $i <= 9; $i++) {
        echo numLink($n) . ' × ' . numLink($i) . ' = ' . numLink($i * $n) . '<br>';
    }
}

// ---- Меню: сохраняем оба параметра при переключении ----
function mainMenuLink(string $type, ?string $curType, ?int $curContent): string {
    $href = '?html_type=' . $type;
    if ($curContent !== null) $href .= '&content=' . $curContent;
    $class = ($curType === $type) ? ' class="sel"' : '';
    $label = ($type === 'TABLE') ? 'Табличная верстка' : 'Блочная верстка';
    return "<a href=\"$href\"$class>$label</a>";
}

function sideMenuLink(int $n, ?string $curType, ?int $curContent): string {
    $href = ($curType !== null) ? '?html_type=' . $curType . '&content=' . $n : '?content=' . $n;
    $class = ($curContent === $n) ? ' class="sel"' : '';
    return "<a href=\"$href\"$class>$n</a>";
}

function allLink(?string $curType): string {
    $href = ($curType !== null) ? '?html_type=' . $curType : '/';
    return $href;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Иванов И.И., ВЕБ-11 — ЛР А-5</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; margin: 0; background: #f0f0f0; }
        header { background: #1a5c2a; color: #fff; padding: 12px 20px; display: flex; gap: 12px; align-items: center; }
        header a { color: #fff; text-decoration: none; padding: 6px 14px; border-radius: 4px; background: rgba(255,255,255,.15); }
        header a:hover, header a.sel { background: rgba(255,255,255,.4); font-weight: bold; }
        .wrap { display: flex; min-height: calc(100vh - 95px); }
        aside { width: 160px; background: #e8e8e8; padding: 16px 10px; display: flex; flex-direction: column; gap: 6px; }
        aside a { display: block; padding: 7px 12px; border-radius: 4px; text-decoration: none; color: #333; background: #fff; border: 1px solid #ccc; }
        aside a:hover, aside a.sel { background: #1a5c2a; color: #fff; }
        main { flex: 1; padding: 20px; }
        footer { background: #333; color: #aaa; text-align: center; padding: 10px; font-size: 13px; }
        /* Табличная верстка */
        .tt-table { display: flex; gap: 12px; flex-wrap: wrap; }
        .tt-col { border: 1px solid #999; background: #fff; padding: 10px 16px; border-radius: 4px; min-width: 100px; }
        .tt-single { max-width: 200px; font-size: 18px; border: 2px solid #1a5c2a; padding: 16px; border-radius: 6px; background: #fff; }
        /* Блочная верстка */
        .div-table { display: flex; gap: 12px; flex-wrap: wrap; }
        .div-col { border: 2px solid #1a5c2a; background: #fff; padding: 10px 16px; border-radius: 8px; }
        .div-single { display: inline-block; border: 2px solid #1a5c2a; padding: 16px; border-radius: 8px; background: #fff; font-size: 18px; }
        a { color: #1a5c2a; }
    </style>
</head>
<body>

<header>
    <?php echo mainMenuLink('TABLE', $html_type, $content); ?>
    <?php echo mainMenuLink('DIV',   $html_type, $content); ?>
</header>

<div class="wrap">
    <aside>
        <a href="<?php echo allLink($html_type); ?>"
           <?php if ($content === null) echo 'class="sel"'; ?>>Всё</a>
        <?php for ($n = 2; $n <= 9; $n++): ?>
            <?php echo sideMenuLink($n, $html_type, $content); ?>
        <?php endfor; ?>
    </aside>

    <main>
        <?php
        $useDiv = ($html_type === 'DIV');

        if ($content === null) {
            // Вся таблица
            if ($useDiv) {
                echo '<div class="div-table">';
                for ($i = 2; $i <= 9; $i++) {
                    echo '<div class="div-col">'; outRow($i); echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<div class="tt-table">';
                for ($i = 2; $i <= 9; $i++) {
                    echo '<div class="tt-col">'; outRow($i); echo '</div>';
                }
                echo '</div>';
            }
        } else {
            // Один столбец
            $cls = $useDiv ? 'div-single' : 'tt-single';
            echo "<div class=\"$cls\">";
            outRow($content);
            echo '</div>';
        }
        ?>
    </main>
</div>

<footer>
    <?php
    $typeLabel    = $html_type === 'DIV' ? 'Блочная верстка' : 'Табличная верстка';
    $contentLabel = $content ? "Таблица умножения на $content" : 'Полная таблица умножения';
    echo "$typeLabel | $contentLabel | " . date('d.m.Y H:i:s');
    ?>
</footer>

</body>
</html>
