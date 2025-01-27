<?php 
require "../includes/config.php";
include "../header.php";
?>

<body>

    <div class="container col-md-6">
        <h2>Assign Field</h2>
        <form id="assignFieldsForm" method="POST" action="save_fields.php">
            <div class="form-group">
                <label for="menuSelect">Select Menu:</label>
                <select id="menuSelect" name="menu_id" class="form-control" required>
                    <?php
                    // Query to get menus from the database
                    $menus = mysqli_query($conn, "SELECT * FROM menus");
                    if ($menus) {
                        while ($menu = mysqli_fetch_assoc($menus)) {
                            echo "<option value='{$menu['id']}'>{$menu['menu_name']}</option>";
                        }
                    } else {
                        echo "<option value=''>No menus found</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Available Fields</label>
                <select id="availableFields" name="available_fields[]" multiple style="width: 100%; height: 150px;">
                    <?php
                    // Query to get available field types from the database
                    $fields = [
                        'textbox' => 'Textbox',
                        'dropdown' => 'Dropdown',
                        'textarea' => 'Textarea',
                        'number' => 'Number Input'
                    ];

                    // Loop through the fields and create an option for each field
                    foreach ($fields as $type => $label) {
                        echo "<option value='{$type}'>{$label}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Custom Layout</label>
                <div id="customLayout" class="field-list"></div>
            </div>

            <button type="submit" class="btn btn-primary">Save Field</button>
        </form>
    </div>

    <script>
        // When a field is selected, dynamically add it to the custom layout
        document.getElementById("availableFields").addEventListener("change", function(event) {
            const selectedFields = Array.from(event.target.selectedOptions).map(option => option.value);
            const customLayout = document.getElementById("customLayout");
            customLayout.innerHTML = ''; // Clear previous layout

            // Add the selected fields to the custom layout
            selectedFields.forEach(fieldType => {
                let fieldHTML = '';
                const fieldName = `field_${Date.now()}`;
                
                switch (fieldType) {
                    case 'textbox':
                        fieldHTML = `
                            <div class="field-item" data-type="textbox">
                                <input type="hidden" name="fields[${fieldName}][type]" value="textbox">
                                <input type="text" name="fields[${fieldName}][label]" placeholder="Label" required>
                                <input type="text" name="fields[${fieldName}][placeholder]" placeholder="Placeholder (optional)">
                            </div>
                        `;
                        break;
                    case 'dropdown':
                        fieldHTML = `
                            <div class="field-item" data-type="dropdown">
                                <input type="hidden" name="fields[${fieldName}][type]" value="dropdown">
                                <input type="text" name="fields[${fieldName}][label]" placeholder="Label" required>
                                <input type="text" name="fields[${fieldName}][options]" placeholder="Comma-separated options (e.g., Option 1, Option 2)">
                            </div>
                        `;
                        break;
                    case 'textarea':
                        fieldHTML = `
                            <div class="field-item" data-type="textarea">
                                <input type="hidden" name="fields[${fieldName}][type]" value="textarea">
                                <input type="text" name="fields[${fieldName}][label]" placeholder="Label" required>
                                <textarea name="fields[${fieldName}][placeholder]" placeholder="Placeholder (optional)"></textarea>
                            </div>
                        `;
                        break;
                    case 'number':
                        fieldHTML = `
                            <div class="field-item" data-type="number">
                                <input type="hidden" name="fields[${fieldName}][type]" value="number">
                                <input type="text" name="fields[${fieldName}][label]" placeholder="Label" required>
                                <input type="number" name="fields[${fieldName}][placeholder]" placeholder="Min/Max Value (optional)">
                            </div>
                        `;
                        break;
                    default:
                        break;
                }

                customLayout.innerHTML += fieldHTML;
            });
        });

        // Initialize Sortable for custom layout (dragging items into this list)
        new Sortable(document.getElementById("customLayout"), {
            group: { name: "fields", pull: true, put: true },
            animation: 150
        });

        // Handle form submission via AJAX
        $('#assignFieldsForm').submit(function(e) {
            e.preventDefault(); // Prevent default form submission
            
            var formData = $(this).serialize(); // Serialize form data
            
            $.ajax({
                url: "save_fields.php", // The PHP script to handle the save
                type: "POST",
                data: formData,
                success: function(response) {
                    // Assuming the response contains a success message
                    $("#dynamicContent").html('<div class="w3-container w3-green">' + response + '</div>');
                },
                error: function() {
                    $("#dynamicContent").html('<div class="w3-container w3-red">Error occurred while saving fields.</div>');
                }
            });
        });
    </script>
</body>


