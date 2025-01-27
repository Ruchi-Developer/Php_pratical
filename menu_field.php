<?php
require 'includes/config.php';

if (isset($_GET['menu_id'])) {
    $menuId = $_GET['menu_id'];
} else {
    echo "menu_id is missing.";
    exit; // Stop script execution if menu_id is missing
}$layoutQuery = "SELECT * FROM menu_fields WHERE menu_id = $menuId ORDER BY position";
$layoutResult = mysqli_query($conn, $layoutQuery);

echo '<form>';
while ($field = mysqli_fetch_assoc($layoutResult)) {
    switch ($field['field_type']) {
        case 'textbox':
            echo "<label>{$field['field_label']}</label>";
            echo "<input type='text' name='{$field['field_name']}'><br>";
            break;

        case 'dropdown':
            echo "<label>{$field['field_label']}</label>";
            echo "<select name='{$field['field_name']}'></select><br>";
            break;

        case 'textarea':
            echo "<label>{$field['field_label']}</label>";
            echo "<textarea name='{$field['field_name']}'></textarea><br>";
            break;

        case 'number':
            echo "<label>{$field['field_label']}</label>";
            echo "<input type='number' name='{$field['field_name']}'><br>";
            break;
    }
}
echo '<button type="submit">Submit</button>';
echo '</form>';
?>
