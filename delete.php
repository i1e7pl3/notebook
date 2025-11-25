<?php
$message = '';

if (isset($_GET['delete_id'])) {
    try {
        $delete_id = (int)$_GET['delete_id'];
        
        $stmt = $pdo->prepare("SELECT surname FROM contacts WHERE id = :id");
        $stmt->execute([':id' => $delete_id]);
        $contact = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($contact) {
            $surname = $contact['surname'];
            
            $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = :id");
            $stmt->execute([':id' => $delete_id]);
            
            $message = 'Запись с фамилией ' . htmlspecialchars($surname) . ' удалена';
        }
    } catch (PDOException $e) {
        $message = 'Ошибка при удалении записи';
    }
}

$stmt = $pdo->query("SELECT id, surname, name, patronymic FROM contacts ORDER BY surname ASC, name ASC");
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if ($message): ?>
    <div style="padding: 10px; margin: 20px auto; width: 50%; text-align: center; border-radius: 5px; background-color: #d1e7dd; color: #0f5132;">
        <?php echo $message; ?>
    </div>
<?php endif; ?>

<div style="display: flex; justify-content: center; margin-top: 20px;">
    <div class="div-edit">
        <?php if (!empty($contacts)): ?>
            <?php foreach ($contacts as $contact): ?>
                <?php
                $initials = '';
                if (!empty($contact['name'])) {
                    $initials .= mb_substr($contact['name'], 0, 1) . '.';
                }
                if (!empty($contact['patronymic'])) {
                    $initials .= mb_substr($contact['patronymic'], 0, 1) . '.';
                }
                $display_text = htmlspecialchars($contact['surname'] . ' ' . $initials);
                $url = 'index.php?page=delete&delete_id=' . $contact['id'];
                ?>
                <div style="padding: 5px; margin: 5px 0;">
                    <a href="<?php echo $url; ?>" style="display: block; padding: 5px; color: blue;">
                        <?php echo $display_text; ?>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Нет записей для удаления</p>
        <?php endif; ?>
    </div>
</div>

