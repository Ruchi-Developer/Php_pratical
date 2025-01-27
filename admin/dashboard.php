<?php
require '../includes/auth.php';
requireAdmin(); // Only admin can access this page
include "../header.php";
?>


<body>
    <p><a href="../logout.php">Logout</a></p>
    <div class="w3-sidebar w3-light-grey w3-bar-block" style="width:25%">
        <h3 class="w3-bar-item">Menu</h3>
        <a href="#" id="menuDrawer" class="w3-bar-item w3-button">Menu Drawer</a>
        <a href="#" id="assignFieldBtn" class="w3-bar-item w3-button">Assign Field</a>

    </div>

    <!-- Page Content -->
    <div style="margin-left:25%">
        <div class="w3-container w3-teal">
            <h1>Welcome, Admin!</h1>
        </div>

        <div class="w3-container" id="dynamicContent"></div> <!-- Container to load menu add form dynamically -->
    </div>

    <script>
   $(document).ready(function() {
    // Handle click on "Menu Drawer"
    $("#menuDrawer").click(function(e) {
        e.preventDefault();
        
        // Use AJAX to load the menuadd.php content
        $("#dynamicContent").load("menuadd.php");
    });
   $("#assignFieldBtn").click(function(e) {
        e.preventDefault();
        
        // Use AJAX to load the assign.php content
        $("#dynamicContent").load("assign_field.php");  // Load assign.php into the dynamicContent container
    });
    // Handle form submission for adding menu
    $("#menuAddForm").submit(function(e) {
        e.preventDefault();

        var formData = $(this).serialize(); // Serialize the form data

        $.ajax({
            url: "menuadd.php", // URL to send the request
            method: "POST",
            data: formData + "&action=save", // Include the action parameter
            success: function(response) {
                var data = JSON.parse(response);

                if (data.status === 'success') {
                    // Display success message in the dynamic content area
                    $("#dynamicContent").html('<div class="w3-container w3-green">' + data.message + '</div>');
                } else {
                    // Handle error if any
                    $("#dynamicContent").html('<div class="w3-container w3-red">Error occurred!</div>');
                }
            }
        });
    });


    $("#menuDrawer").click(function(e) {
        e.preventDefault();
        
        // Use AJAX to load the menuadd.php content
        $("#dynamicContent").load("menuadd.php");
    });

    // Handle form submission for adding menu
    $("#menuAddForm").submit(function(e) {
        e.preventDefault();

        var formData = $(this).serialize(); // Serialize the form data

        $.ajax({
            url: "assign_field.php", // Changed to the correct file for processing
            method: "POST",
            data: formData + "&action=save", // Include the action parameter
            success: function(response) {
                var data = JSON.parse(response);

                if (data.status === 'success') {
                    // Display success message in the dynamic content area
                    $("#dynamicContent").html('<div class="w3-container w3-green">' + data.message + '</div>');
                    // Optionally, you can reload part of the page or handle further UI updates here
                } else {
                    // Handle error if any
                    $("#dynamicContent").html('<div class="w3-container w3-red">Error occurred!</div>');
                }
            }
        });
    });
});
    </script>

</body>

