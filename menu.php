<?php
// Include the config file to establish a connection
require "includes/config.php";

// Fetch parent menus (menus with visibility=1 and no parent_id)
$query = "SELECT * FROM menus WHERE visibility=1 AND parent_id IS NULL";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo "<ul>";
    while ($menu = mysqli_fetch_assoc($result)) {
        echo "<li>{$menu['menu_name']}";

        // Fetch submenus (menus where parent_id matches the current menu's id)
        $subMenuQuery = "SELECT * FROM menus WHERE parent_id={$menu['id']}";
        $subResult = mysqli_query($conn, $subMenuQuery);

        if (mysqli_num_rows($subResult) > 0) {
            echo "<ul>";
            while ($subMenu = mysqli_fetch_assoc($subResult)) {
                echo "<li>{$subMenu['menu_name']}</li>";
            }
            echo "</ul>";
        }
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "No menus found.";
}

// Close the connection
mysqli_close($conn);
?>
