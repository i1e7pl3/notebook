<?php
function displayContacts($sort_type = 'default', $page = 1) {
    global $pdo;
    
    $records_per_page = 10;
    $offset = ($page - 1) * $records_per_page;
    
    $order_by = '';
    switch ($sort_type) {
        case 'surname':
            $order_by = 'ORDER BY surname ASC, name ASC';
            break;
        case 'date':
            $order_by = 'ORDER BY date_of_birth ASC';
            break;
        default:
            $order_by = 'ORDER BY created_at ASC';
            break;
    }
    
    $count_stmt = $pdo->query("SELECT COUNT(*) FROM contacts");
    $total_records = $count_stmt->fetchColumn();
    $total_pages = ceil($total_records / $records_per_page);
    
    $stmt = $pdo->prepare("SELECT * FROM contacts $order_by LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $records_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $html = '<table>';
    $html .= '<tr>';
    $html .= '<th>Фамилия</th>';
    $html .= '<th>Имя</th>';
    $html .= '<th>Отчество</th>';
    $html .= '<th>Пол</th>';
    $html .= '<th>Дата рождения</th>';
    $html .= '<th>Телефон</th>';
    $html .= '<th>Адрес</th>';
    $html .= '<th>Email</th>';
    $html .= '<th>Комментарий</th>';
    $html .= '</tr>';
    
    if (empty($contacts)) {
        $html .= '<tr><td colspan="9" style="text-align: center;">Нет записей в базе данных</td></tr>';
    } else {
        foreach ($contacts as $contact) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($contact['surname']) . '</td>';
            $html .= '<td>' . htmlspecialchars($contact['name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($contact['patronymic'] ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($contact['gender'] ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($contact['date_of_birth'] ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($contact['phone'] ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($contact['address'] ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($contact['email'] ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($contact['comment'] ?? '') . '</td>';
            $html .= '</tr>';
        }
    }
    
    $html .= '</table>';
    
    if ($total_pages > 1) {
        $html .= '<div class="pagination" style="margin-top: 20px; text-align: center;">';
        for ($i = 1; $i <= $total_pages; $i++) {
            $url = 'index.php?page=view&sort=' . $sort_type . '&p=' . $i;
            $html .= '<a href="' . $url . '">' . $i . '</a>';
        }
        $html .= '</div>';
    }
    
    return $html;
}
?>

