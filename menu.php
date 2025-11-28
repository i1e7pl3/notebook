<?php
function generateMenu() {
    $current_page = isset($_GET['page']) ? $_GET['page'] : 'view';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';
    
    $menu_items = [
        'view' => 'Просмотр',
        'add' => 'Добавление записи',
        'edit' => 'Редактирование записи',
        'delete' => 'Удаление записи'
    ];
    
    $html = '<header>';
    
    foreach ($menu_items as $key => $label) {
        $class = ($current_page == $key) ? 'select' : '';
        $color = ($current_page == $key) ? 'color: red;' : 'color: blue;';
        $url = 'index.php?page=' . $key;
        
        $html .= '<a href="' . $url . '" style="' . $color . '" class="' . $class . '">' . $label . '</a>';
    }
    
    $html .= '</header>';
    
    if ($current_page == 'view') {
        $submenu_items = [
            'default' => 'По порядку добавления',
            'surname' => 'По фамилии',
            'date' => 'По дате рождения'
        ];
        
        $html .= '<div class="submenu">';
        foreach ($submenu_items as $key => $label) {
            $class = ($sort == $key) ? 'select' : '';
            $color = ($sort == $key) ? 'color: red;' : 'color: blue;';
            $url = 'index.php?page=view&sort=' . $key;
            
            $html .= '<a href="' . $url . '" style="' . $color . '; font-size: 0.9em;" class="' . $class . '">' . $label . '</a>';
        }
        $html .= '</div>';
    }
    
    return $html;
}
?>

