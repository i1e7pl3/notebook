<?php
$message = '';
$message_class = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    try {
        $stmt = $pdo->prepare("INSERT INTO contacts (surname, name, patronymic, gender, date_of_birth, phone, address, email, comment) 
                              VALUES (:surname, :name, :patronymic, :gender, :date_of_birth, :phone, :address, :email, :comment)");
        
        $stmt->execute([
            ':surname' => $_POST['surname'] ?? '',
            ':name' => $_POST['name'] ?? '',
            ':patronymic' => $_POST['patronymic'] ?? '',
            ':gender' => $_POST['gender'] ?? '',
            ':date_of_birth' => $_POST['date_of_birth'] ?? '',
            ':phone' => $_POST['phone'] ?? '',
            ':address' => $_POST['address'] ?? '',
            ':email' => $_POST['email'] ?? '',
            ':comment' => $_POST['comment'] ?? ''
        ]);
        
        $message = 'Запись добавлена';
        $message_class = 'success';
        
        $_POST = [];
    } catch (PDOException $e) {
        $message = 'Ошибка: запись не добавлена';
        $message_class = 'error';
    }
}

$values = [
    'surname' => $_POST['surname'] ?? '',
    'name' => $_POST['name'] ?? '',
    'patronymic' => $_POST['patronymic'] ?? '',
    'gender' => $_POST['gender'] ?? '',
    'date_of_birth' => $_POST['date_of_birth'] ?? '',
    'phone' => $_POST['phone'] ?? '',
    'address' => $_POST['address'] ?? '',
    'email' => $_POST['email'] ?? '',
    'comment' => $_POST['comment'] ?? ''
];
?>

<?php if ($message): ?>
    <div class="<?php echo $message_class; ?>" style="padding: 10px; margin: 20px auto; width: 50%; text-align: center; border-radius: 5px;">
        <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>

<form name="form_add" method="post">
    <div class="column">
        <div class="add">
            <label>Фамилия</label>
            <input type="text" name="surname" placeholder="Фамилия" value="<?php echo htmlspecialchars($values['surname']); ?>" required>
        </div>
        <div class="add">
            <label>Имя</label>
            <input type="text" name="name" placeholder="Имя" value="<?php echo htmlspecialchars($values['name']); ?>" required>
        </div>
        <div class="add">
            <label>Отчество</label>
            <input type="text" name="patronymic" placeholder="Отчество" value="<?php echo htmlspecialchars($values['patronymic']); ?>">
        </div>
        <div class="add">
            <label>Пол</label>
            <select name="gender">
                <option value="">Выберите пол</option>
                <option value="мужской" <?php echo ($values['gender'] == 'мужской') ? 'selected' : ''; ?>>мужской</option>
                <option value="женский" <?php echo ($values['gender'] == 'женский') ? 'selected' : ''; ?>>женский</option>
            </select>
        </div>
        <div class="add">
            <label>Дата рождения</label>
            <input type="date" name="date_of_birth" value="<?php echo htmlspecialchars($values['date_of_birth']); ?>">
        </div>
        <div class="add">
            <label>Телефон</label>
            <input type="text" name="phone" placeholder="Телефон" value="<?php echo htmlspecialchars($values['phone']); ?>">
        </div>
        <div class="add">
            <label>Адрес</label>
            <input type="text" name="address" placeholder="Адрес" value="<?php echo htmlspecialchars($values['address']); ?>">
        </div>
        <div class="add">
            <label>Email</label>
            <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($values['email']); ?>">
        </div>
        <div class="add">
            <label>Комментарий</label>
            <textarea name="comment" placeholder="Краткий комментарий"><?php echo htmlspecialchars($values['comment']); ?></textarea>
        </div>
        
        <button type="submit" name="add" value="1" class="form-btn">Добавить запись</button>
    </div>
</form>

