<?php
/**
 * Plugin Name: Elementor Cache & Sync One-Click
 * Description: Adds a one-click button in the admin bar to clear Elementor cache and sync the library automatically.
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Add button to admin bar
add_action('admin_bar_menu', function ($wp_admin_bar) {
    if (!current_user_can('manage_options')) {
        return;
    }

    $wp_admin_bar->add_node([
        'id'    => 'elementor_cache_sync',
        'title' => 'Clear Elementor Cache & Sync',
        'href'  => '#',
        'meta'  => [
            'onclick' => 'triggerElementorActions(); return false;',
        ],
    ]);
}, 100);

// Enqueue JavaScript
add_action('admin_enqueue_scripts', function () {
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <script>
        function triggerElementorActions() {
            fetch("<?php echo admin_url('admin-ajax.php?action=clear_elementor_cache'); ?>")
                .then(() => setTimeout(() => {
                    fetch("<?php echo admin_url('admin-ajax.php?action=sync_elementor_library'); ?>");
                }, 2000));
        }
    </script>
    <?php
});

// AJAX action to clear Elementor cache
add_action('wp_ajax_clear_elementor_cache', function () {
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Unauthorized', 403);
    }
    
    if (class_exists('\Elementor\Plugin')) {
        \Elementor\Plugin::$instance->files_manager->clear_cache();
        wp_send_json_success('Elementor cache cleared.');
    }
    
    wp_send_json_error('Elementor not found.', 404);
});

// AJAX action to sync Elementor library
add_action('wp_ajax_sync_elementor_library', function () {
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Unauthorized', 403);
    }
    
    if (class_exists('\Elementor\Plugin')) {
        \Elementor\Plugin::$instance->library->request_library_data();
        wp_send_json_success('Elementor library synced.');
    }
    
    wp_send_json_error('Elementor not found.', 404);
});
