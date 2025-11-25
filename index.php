<?php
require_once 'config.php';

require_once 'menu.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'view';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';
$pagination_page = isset($_GET['p']) ? (int)$_GET['p'] : 1;

$allowed_pages = ['view', 'add', 'edit', 'delete'];
if (!in_array($page, $allowed_pages)) {
    $page = 'view';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Записная книжка</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <?php echo generateMenu(); ?>
        
        <div style="margin-top: 20px;">
            <?php
            switch ($page) {
                case 'view':
                    require_once 'viewer.php';
                    echo displayContacts($sort, $pagination_page);
                    break;
                    
                case 'add':
                    require_once 'add.php';
                    break;
                    
                case 'edit':
                    require_once 'edit.php';
                    break;
                    
                case 'delete':
                    require_once 'delete.php';
                    break;
            }
            ?>
        </div>
    </main>
</body>
</html>

