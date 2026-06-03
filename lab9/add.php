<?php
// ЛР В-1: Добавление записи
$msg = '';

if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $db = getDB();
    $stmt = $db->prepare(
        'INSERT INTO contacts (lastname,firstname,patronym,gender,birthdate,phone,address,email,comment)
         VALUES (?,?,?,?,?,?,?,?,?)'
    );
    $stmt->bind_param('sssssssss',
        $_POST['lastname'], $_POST['firstname'], $_POST['patronym'],
        $_POST['gender'],   $_POST['birthdate'],
        $_POST['phone'],    $_POST['address'],
        $_POST['email'],    $_POST['comment']
    );
    $msg = $stmt->execute()
        ? '<p class="msg-ok">✓ Запись добавлена.</p>'
        : '<p class="msg-err">✗ Ошибка: запись не добавлена.</p>';
}
?>
<h2>Добавить запись</h2>
<?php echo $msg; ?>
<form method="post" action="?p=add">
    <input type="hidden" name="action" value="add">
    <?php
    $fields = [
        'lastname'  => 'Фамилия',
        'firstname' => 'Имя',
        'patronym'  => 'Отчество',
        'phone'     => 'Телефон',
        'address'   => 'Адрес',
        'email'     => 'E-mail',
        'comment'   => 'Комментарий',
    ];
    foreach ($fields as $name => $label):
    ?>
    <div class="form-row">
        <label><?php echo $label; ?>:</label>
        <input type="text" name="<?php echo $name; ?>">
    </div>
    <?php endforeach; ?>
    <div class="form-row">
        <label>Пол:</label>
        <select name="gender">
            <option value="М">Мужской</option>
            <option value="Ж">Женский</option>
        </select>
    </div>
    <div class="form-row">
        <label>Дата рождения:</label>
        <input type="date" name="birthdate">
    </div>
    <div class="form-row">
        <label></label>
        <button class="btn" type="submit">Добавить</button>
    </div>
</form>
