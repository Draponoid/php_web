<?php
// ЛР В-1: Удаление записи
$db  = getDB();
$msg = '';

if (isset($_GET['del_id'])) {
    $id = (int)$_GET['del_id'];
    // Получаем фамилию перед удалением
    $row = $db->query("SELECT lastname FROM contacts WHERE id=$id LIMIT 1")->fetch_row();
    if ($row) {
        $db->query("DELETE FROM contacts WHERE id=$id");
        $msg = '<p class="msg-ok">✓ Запись с фамилией «' . htmlspecialchars($row[0]) . '» удалена.</p>';
    }
}

$list = $db->query('SELECT id, lastname, firstname, patronym FROM contacts ORDER BY lastname, firstname');
?>
<h2>Удалить запись</h2>
<?php echo $msg; ?>

<?php if ($list->num_rows === 0): ?>
    <p>Нет записей для удаления.</p>
<?php else: ?>
<ul style="list-style:none; padding:0;">
    <?php while ($row = $list->fetch_assoc()):
        // Показываем фамилию и инициалы
        $initials = mb_substr($row['firstname'], 0, 1) . '.'
                  . mb_substr($row['patronym'],  0, 1) . '.';
        $name = htmlspecialchars($row['lastname'] . ' ' . $initials);
    ?>
    <li style="margin-bottom:8px;">
        <a class="btn btn-del"
           href="?p=delete&del_id=<?php echo $row['id']; ?>"
           onclick="return confirm('Удалить «<?php echo $name; ?>»?')">
            Удалить
        </a>
        &nbsp; <?php echo $name; ?>
    </li>
    <?php endwhile; ?>
</ul>
<?php endif; ?>
