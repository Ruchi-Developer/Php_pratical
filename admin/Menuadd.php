<?php
// Include your config file here
require '../includes/config.php';
include "../header.php";
?>

<body>

<div class="container col-md-6">
    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
    <p style="color: green;">Menu added successfully!</p>
    <?php endif; ?>
    <h3>Menu Drawer</h3>
    <form action="Menu_handler.php" method="POST" id="menuAddForm">
        <input type="hidden" name="menu_id" value="<?= isset($menu['id']) ? $menu['id'] : '' ?>">
        <div class="form-group">
            <label for="menu_name">Menu Name:</label>
            <input type="text" name="menu_name" id="menu_name" class="form-control" required value="<?= isset($menu['menu_name']) ? $menu['menu_name'] : '' ?>">
        </div>
        <div class="form-group">
            <label for="menu_url">Menu URL:</label>
            <input type="text" name="menu_url" class="form-control" id="menu_url" required value="<?= isset($menu['menu_url']) ? $menu['menu_url'] : '' ?>">
        </div>
        <div class="form-group">
            <label for="visibility">Visibility:</label>
            <select name="visibility" id="visibility" class="form-control">
                <option value="1" <?= isset($menu['visibility']) && $menu['visibility'] == 1 ? 'selected' : '' ?>>Visible</option>
                <option value="0" <?= isset($menu['visibility']) && $menu['visibility'] == 0 ? 'selected' : '' ?>>Hidden</option>
            </select>
        </div>
        <div class="form-group">
            <label for="parent_id">Parent Menu:</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">No Parent</option>
                <?php 
                // Fetch menus for parent menu dropdown
                $query = "SELECT id, menu_name FROM menus"; // Replace 'menus' with your actual table name
                $menus = mysqli_query($conn, $query);

                if (!$menus) {
                    die("Error fetching menus: " . mysqli_error($conn));
                }
                while ($parent = mysqli_fetch_assoc($menus)): ?>
                    <option value="<?= $parent['id'] ?>" <?= isset($menu['parent_id']) && $menu['parent_id'] == $parent['id'] ? 'selected' : '' ?>>
                        <?= $parent['menu_name'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="action" value="save">Save Menu</button>
    </form>
</div>
</body>

