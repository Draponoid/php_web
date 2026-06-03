<?php
function getMenu(string $page, string $sort): string {
    $items = [
        'viewer' => 'Просмотр',
        'add'    => 'Добавить запись',
        'edit'   => 'Редактировать',
        'delete' => 'Удалить запись',
    ];

    $html = '<header>';
    foreach ($items as $key => $label) {
        $class = ($page === $key) ? ' class="sel"' : '';
        $html .= "<a href=\"?p=$key\"$class>$label</a>";
    }
    $html .= '</header>';

    // Подменю сортировки — только для «Просмотр»
    if ($page === 'viewer') {
        $sorts = ['byid' => 'По умолчанию', 'fam' => 'По фамилии', 'birth' => 'По дате рождения'];
        $html .= '<div class="submenu">';
        foreach ($sorts as $val => $label) {
            $class = ($sort === $val) ? ' class="sel"' : '';
            $html .= "<a href=\"?p=viewer&sort=$val\"$class>$label</a>";
        }
        $html .= '</div>';
    }

    return $html;
}
