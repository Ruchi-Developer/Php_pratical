<?php
require '../includes/config.php';

// Fetch all visible menus
$menus = $conn->query("SELECT * FROM menus WHERE visibility = 1 ORDER BY parent_id, id");

$menu_tree = [];
while ($menu = $menus->fetch_assoc()) {
    if (empty($menu['parent_id'])) { // Check for null or 0 parent_id
        $menu_tree[$menu['id']] = $menu;
        $menu_tree[$menu['id']]['children'] = [];
    } else {
        $menu_tree[$menu['parent_id']]['children'][] = $menu;
    }
}
?>

<!-- Bootstrap Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
     
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php foreach ($menu_tree as $parent): ?>
                    <?php if (!isset($parent['menu_name']) || !isset($parent['menu_url'])) continue; ?>
                    <li class="nav-item">
                        <a class="nav-link parent-menu" href="<?= htmlspecialchars($parent['menu_url']) ?>"><?= htmlspecialchars($parent['menu_name']) ?></a>
                        <?php if (!empty($parent['children'])): ?>
                            <ul class="sub-menu">
                                <?php foreach ($parent['children'] as $child): ?>
                                    <?php if (!isset($child['menu_name']) || !isset($child['menu_url'])) continue; ?>
                                    <li><a class="dropdown-item" href="<?= htmlspecialchars($child['menu_url']) ?>"><?= htmlspecialchars($child['menu_name']) ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Include jQuery for toggle functionality -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Toggle sub-menu visibility on parent menu click
    $(document).ready(function () {
        $('.parent-menu').on('click', function (e) {
            e.preventDefault(); // Prevent the default action (navigation)
            var parentLi = $(this).closest('.nav-item');
            var subMenu = parentLi.find('.sub-menu');
            
            // Toggle the visibility of the submenu
            subMenu.slideToggle();
            
            // Optionally, add a class to indicate the active state of the parent menu
            parentLi.toggleClass('active');
        });
    });
</script>

<style>
    /* Initially hide all sub-menus */
    .navbar-nav .nav-item .parent-menu{
        color:#9494b8;
    }
    .nav-item .parent-menu{
        padding-right:20px;
    }
    .sub-menu {
        display: none;
        padding-left: 20px;
    }

    /* Style for active parent menu */
    .nav-item.active > .parent-menu {
        font-weight: bold; /* Optional: You can style the active parent menu differently */
    }
</style>
