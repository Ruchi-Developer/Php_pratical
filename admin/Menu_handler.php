<?php
require '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menu_name = $_POST['menu_name'];
    $menu_url = $_POST['menu_url'];
    $visibility = $_POST['visibility'];
    $parent_id = empty($_POST['parent_id']) ? null : $_POST['parent_id'];
    $menu_id = empty($_POST['menu_id']) ? null : $_POST['menu_id'];

    if ($_POST['action'] === 'save') {
        if ($menu_id) {
            // Update existing menu
            $stmt = $conn->prepare("UPDATE menus SET menu_name = ?, menu_url = ?, visibility = ?, parent_id = ? WHERE id = ?");
            $stmt->bind_param("ssiii", $menu_name, $menu_url, $visibility, $parent_id, $menu_id);
        } else {
            // Insert new menu
            $stmt = $conn->prepare("INSERT INTO menus (menu_name, menu_url, visibility, parent_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssii", $menu_name, $menu_url, $visibility, $parent_id);
        }
        $stmt->execute();
        $stmt->close();

        // Return success message as a JSON response
        echo json_encode(['status' => 'success', 'message' => 'Menu added successfully!']);
        exit;
    } 
}

?>
