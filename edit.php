<?php
$message = '';
$message_class = '';

$stmt = $pdo->query("SELECT id, surname, name, patronymic FROM contacts ORDER BY surname ASC, name ASC");
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$selected_id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($contacts[0]['id']) ? $contacts[0]['id'] : null);

// Обработка редактирования записи
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    try {
        $stmt = $pdo->prepare("UPDATE contacts SET 
                              surname = :surname, 
                              name = :name, 
                              patronymic = :patronymic, 
                              gender = :gender, 
                              date_of_birth = :date_of_birth, 
                              phone = :phone, 
                              address = :address, 
                              email = :email, 
                              comment = :comment 
                              WHERE id = :id");
        
        $stmt->execute([
            ':id' => $_POST['id'],
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
        
        $message = 'Запись обновлена';
        $message_class = 'success';
        $selected_id = $_POST['id'];
    } catch (PDOException $e) {
        $message = 'Ошибка: запись не обновлена';
        $message_class = 'error';
    }
}

$current_contact = null;
if ($selected_id) {
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = :id");
    $stmt->execute([':id' => $selected_id]);
    $current_contact = $stmt->fetch(PDO::FETCH_ASSOC);
}

$values = [
    'surname' => $current_contact['surname'] ?? '',
    'name' => $current_contact['name'] ?? '',
    'patronymic' => $current_contact['patronymic'] ?? '',
    'gender' => $current_contact['gender'] ?? '',
    'date_of_birth' => $current_contact['date_of_birth'] ?? '',
    'phone' => $current_contact['phone'] ?? '',
    'address' => $current_contact['address'] ?? '',
    'email' => $current_contact['email'] ?? '',
    'comment' => $current_contact['comment'] ?? ''
];
?>

<?php if ($message): ?>
    <div class="<?php echo $message_class; ?>" style="padding: 10px; margin: 20px auto; width: 50%; text-align: center; border-radius: 5px;">
        <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>

<div style="display: flex; justify-content: center; margin-top: 20px;">
    <div class="div-edit">
        <?php if (!empty($contacts)): ?>
            <?php foreach ($contacts as $contact): ?>
                <?php
                $is_current = ($contact['id'] == $selected_id);
                $class = $is_current ? 'currentRow' : '';
                $url = 'index.php?page=edit&id=' . $contact['id'];
                $style = $is_current ? 'display: block; padding: 5px; border: 2px solid blue;' : 'display: block; padding: 5px;';
                ?>
                <div style="padding: 5px; margin: 5px 0;">
                    <a href="<?php echo $url; ?>" class="<?php echo $class; ?>" style="<?php echo $style; ?>">
                        <?php echo htmlspecialchars($contact['surname'] . ' ' . $contact['name']); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Нет записей для редактирования</p>
        <?php endif; ?>
    </div>

<?php if ($current_contact): ?>
    <form name="form_edit" method="post">
        <input type="hidden" name="id" value="<?php echo $selected_id; ?>">
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
            
            <button type="submit" name="edit" value="1" class="form-btn">Сохранить изменения</button>
        </div>
    </form>
    </div>
<?php endif; ?>

