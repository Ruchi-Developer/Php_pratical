<?php
require '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['menu_id']) && isset($_POST['fields'])) {
        $menuId = $_POST['menu_id'];
        $fields = $_POST['fields'];

        // Delete existing layout for the menu
        $deleteQuery = "DELETE FROM menu_fields WHERE menu_id = $menuId";
        if (mysqli_query($conn, $deleteQuery)) {
            // Check if the fields array is not empty
            if (!empty($fields)) {
                $position = 1;
                foreach ($fields as $fieldName => $fieldData) {
                    $fieldType = $fieldData['type'];
                    $fieldLabel = $fieldData['label'];

                    // Insert new layout into the database
                    $insertQuery = "INSERT INTO menu_fields (menu_id, field_type, field_label, field_options, position) 
                                    VALUES ('$menuId', '$fieldType', '$fieldLabel', '$fieldName', '$position')";
                    if (!mysqli_query($conn, $insertQuery)) {
                        echo "Error saving field: " . mysqli_error($conn);
                        exit;
                    }
                    $position++;
                }
                echo "Field layout saved successfully.";
            } else {
                echo "No fields were added to the layout.";
            }
        } else {
            echo "Error deleting existing layout: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid form data.";
    }
}
?>
