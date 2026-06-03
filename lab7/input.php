<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Иванов И.И., ВЕБ-11 — ЛР А-7: Ввод массива</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f0f0; padding: 20px; }
        h1   { color: #1a5c2a; }
        .row { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; }
        .row span { width: 30px; text-align: right; color: #555; }
        input[type=text] { width: 120px; padding: 6px; border: 1px solid #999; border-radius: 4px; }
        button { padding: 8px 16px; background: #1a5c2a; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #145020; }
        select { padding: 6px; border-radius: 4px; }
        #arr-table { margin-bottom: 12px; }
    </style>
    <script>
        function addRow() {
            var t = document.getElementById('arr-table');
            var idx = t.rows.length;
            var row = t.insertRow(idx);
            var cell = row.insertCell(0);
            cell.innerHTML = '<div class="row"><span>' + idx + ':</span>'
                + '<input type="text" name="element' + idx + '" placeholder="Число"></div>';
            document.getElementById('arrLen').value = t.rows.length;
        }
    </script>
</head>
<body>
<h1>ЛР А-7 — Ввод массива и сортировка</h1>

<form method="post" action="sort.php" target="_blank">
    <p><strong>Алгоритм сортировки:</strong></p>
    <select name="algorithm">
        <option value="selection">Сортировка выбором</option>
        <option value="bubble">Пузырьковая сортировка</option>
        <option value="insertion">Сортировка вставками</option>
        <option value="gnome">Алгоритм садового гнома</option>
        <option value="shell">Алгоритм Шелла</option>
        <option value="builtin">Встроенная функция PHP (sort)</option>
    </select>

    <p style="margin-top: 16px;"><strong>Элементы массива:</strong></p>
    <table id="arr-table">
        <tr><td>
            <div class="row"><span>0:</span>
                <input type="text" name="element0" placeholder="Число">
            </div>
        </td></tr>
    </table>
    <input type="hidden" name="arrLen" id="arrLen" value="1">

    <div style="display:flex; gap:12px; margin-top:8px;">
        <button type="button" onclick="addRow()">+ Добавить элемент</button>
        <button type="submit">Сортировать массив</button>
    </div>
</form>
</body>
</html>
