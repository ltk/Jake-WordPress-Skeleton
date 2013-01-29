<ul class="footer-links menu">
    <li class="menu-column">
        <?php
        // Auto Products List Goes Here
        $product_line_params = array(
            'numberposts' => -1,
            'post_type' => 'product-lines',
            'orderby' => 'title',
            'order' => 'ASC'
        );

        $product_lines = new J_PostList( $product_line_params, array('post_format' => 'li', 'list_class' => 'menu') );

        $class_array = array('linked-title' => 'post-title primary-accent-color');
        $product_lines->set_post_classes( $class_array );
        ?>
        <ul class="menu">
            <li class="menu-header"><a href="/product-lines/" title="View All Product Lines">Our Products</a></li>
            <?php echo $product_lines->to_html( false ); ?>
        </ul>
    </li>
    <li class="menu-column">
        <?php
        // First Half of Menu Goes Here
        $menu = wp_get_nav_menu_items( 'Primary Footer Navigation' );
        $column_parent_ID = 33;
        $nav_item_list = null;
        foreach ($menu as $item) {
            if ($column_parent_ID == $item->object_id) { $menu_parent = $item->ID; }
            if (isset($menu_parent) && $item->menu_item_parent == $menu_parent) {
                 $nav_item_list .= "<li><a href='" . $item->url . "'>". $item->title . "</a></li>";
             }
         }
        ?>
        <ul class="menu">
            <li class="menu-header"><a href="<?php echo get_permalink( $column_parent_ID ); ?>">Design Resources</a></li>
            <?php echo $nav_item_list; ?>
        </ul>
    </li>
    <li class="menu-column">
        <?php
        // First Half of Menu Goes Here
        $menu = wp_get_nav_menu_items( 'Primary Footer Navigation' );
        $column_parent_ID = 71;
        $nav_item_list = null;
        foreach ($menu as $item) {
            if ($column_parent_ID == $item->object_id) { $menu_parent = $item->ID; }
            if (isset($menu_parent) && $item->menu_item_parent == $menu_parent) {
                 $nav_item_list .= "<li><a href='" . $item->url . "'>". $item->title . "</a></li>";
             }
         }
        ?>
        <ul class="menu">
            <li class="menu-header"><a href="<?php echo get_permalink( $column_parent_ID ); ?>">About Our Company</a></li>
            <?php echo $nav_item_list; ?>
        </ul>
    </li>
</ul>