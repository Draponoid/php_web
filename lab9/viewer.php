<?php
// ЛР В-1: Модуль просмотра записей

function getFriendsList(string $sort, int $page): string {
    $db = getDB();

    // Тип сортировки
    $orderMap = ['byid' => 'id ASC', 'fam' => 'lastname ASC, firstname ASC', 'birth' => 'birthdate ASC'];
    $order = $orderMap[$sort] ?? 'id ASC';

    // Число записей
    $total = (int)$db->query('SELECT COUNT(*) FROM contacts')->fetch_row()[0];
    if ($total === 0) return '<p>В записной книжке пока нет контактов.</p>';

    $perPage = 10;
    $pages = (int)ceil($total / $perPage);
    if ($page < 0) $page = 0;
    if ($page >= $pages) $page = $pages - 1;

    $offset = $page * $perPage;
    $res = $db->query("SELECT * FROM contacts ORDER BY $order LIMIT $offset, $perPage");

    $html = '<table>';
    $html .= '<tr><th>#</th><th>ФИО</th><th>Пол</th><th>Дата рожд.</th><th>Телефон</th><th>E-mail</th></tr>';
    while ($row = $res->fetch_assoc()) {
        $fio  = htmlspecialchars($row['lastname'] . ' ' . $row['firstname'] . ' ' . $row['patronym']);
        $html .= '<tr>';
        $html .= '<td>' . $row['id']       . '</td>';
        $html .= '<td>' . $fio             . '</td>';
        $html .= '<td>' . $row['gender']   . '</td>';
        $html .= '<td>' . ($row['birthdate'] ?? '—') . '</td>';
        $html .= '<td>' . htmlspecialchars($row['phone'] ?? '—') . '</td>';
        $html .= '<td>' . htmlspecialchars($row['email'] ?? '—') . '</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';

    // Пагинация
    if ($pages > 1) {
        $html .= '<div class="pages" style="margin-top:12px;">';
        for ($i = 0; $i < $pages; $i++) {
            if ($i === $page) {
                $html .= '<span>' . ($i + 1) . '</span>';
            } else {
                $html .= '<a href="?p=viewer&sort=' . $sort . '&pg=' . $i . '">' . ($i + 1) . '</a>';
            }
        }
        $html .= '</div>';
    }

    return $html;
}

$sort = in_array($_GET['sort'] ?? '', ['byid','fam','birth']) ? $_GET['sort'] : 'byid';
$pg   = max(0, (int)($_GET['pg'] ?? 0));

echo '<h2>Записная книжка</h2>';
echo getFriendsList($sort, $pg);
