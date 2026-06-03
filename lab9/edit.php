<?php
// ЛР В-1: Редактирование записи
$db  = getDB();
$msg = '';

// Обработка формы редактирования
if (isset($_POST['action']) && $_POST['action'] === 'edit' && isset($_GET['id'])) {
    $stmt = $db->prepare(
        'UPDATE contacts SET lastname=?,firstname=?,patronym=?,gender=?,
         birthdate=?,phone=?,address=?,email=?,comment=? WHERE id=?'
    );
    $id = (int)$_GET['id'];
    $stmt->bind_param('sssssssssi',
        $_POST['lastname'], $_POST['firstname'], $_POST['patronym'],
        $_POST['gender'],   $_POST['birthdate'],
        $_POST['phone'],    $_POST['address'],
        $_POST['email'],    $_POST['comment'], $id
    );
    $msg = $stmt->execute()
        ? '<p class="msg-ok">✓ Данные изменены.</p>'
        : '<p class="msg-err">✗ Ошибка при изменении.</p>';
}

// Определяем текущую запись
$currentId = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Получаем список всех записей (только нужные поля)
$list = $db->query('SELECT id, lastname, firstname FROM contacts ORDER BY lastname, firstname');

// Если id не задан — берём первую запись
if ($currentId === null) {
    $first = $db->query('SELECT id FROM contacts ORDER BY id LIMIT 1')->fetch_row();
    $currentId = $first ? (int)$first[0] : null;
}

// Данные текущей записи
$current = null;
if ($currentId !== null) {
    $current = $db->query("SELECT * FROM contacts WHERE id=$currentId LIMIT 1")->fetch_assoc();
}
?>
<h2>Редактировать запись</h2>
<?php echo $msg; ?>

<?php if ($list->num_rows === 0): ?>
    <p>Записей пока нет.</p>
<?php else: ?>
<div class="edit-links">
    <?php while ($row = $list->fetch_assoc()):
        $class = ($row['id'] == $currentId) ? ' class="cur"' : '';
        $name  = htmlspecialchars($row['lastname'] . ' ' . $row['firstname']);
    ?>
        <a href="?p=edit&id=<?php echo $row['id']; ?>"<?php echo $class; ?>><?php echo $name; ?></a>
    <?php endwhile; ?>
</div>

<?php if ($current): ?>
<form method="post" action="?p=edit&id=<?php echo $currentId; ?>" style="margin-top:16px;">
    <input type="hidden" name="action" value="edit">
    <?php
    $fields = ['lastname'=>'Фамилия','firstname'=>'Имя','patronym'=>'Отчество',
               'phone'=>'Телефон','address'=>'Адрес','email'=>'E-mail','comment'=>'Комментарий'];
    foreach ($fields as $f => $lbl):
    ?>
    <div class="form-row">
        <label><?php echo $lbl; ?>:</label>
        <input type="text" name="<?php echo $f; ?>"
               value="<?php echo htmlspecialchars($current[$f] ?? ''); ?>">
    </div>
    <?php endforeach; ?>
    <div class="form-row">
        <label>Пол:</label>
        <select name="gender">
            <option value="М" <?php echo $current['gender']==='М'?'selected':''; ?>>Мужской</option>
            <option value="Ж" <?php echo $current['gender']==='Ж'?'selected':''; ?>>Женский</option>
        </select>
    </div>
    <div class="form-row">
        <label>Дата рождения:</label>
        <input type="date" name="birthdate" value="<?php echo $current['birthdate'] ?? ''; ?>">
    </div>
    <div class="form-row">
        <label></label>
        <button class="btn" type="submit">Сохранить изменения</button>
    </div>
</form>
<?php endif; ?>
<?php endif; ?>
