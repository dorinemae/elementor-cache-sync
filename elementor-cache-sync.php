<?php
/**
 * Plugin Name: Elementor Cache & Sync One-Click
 * Description: Adds a one-click button in the admin bar to clear Elementor cache and sync the library automatically.
 * Version: 3.8
 * Author: dorinemae.com
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
        'title' => 'CleanUp Elementor',
        'href'  => '/wp-admin/admin.php?page=elementor-tools&cache_sync_trigger=true',
    ]);    
}, 100);

// Enqueue JavaScript
add_action('admin_enqueue_scripts', function () {
    if (!current_user_can('manage_options')) {
        return;
    }
    wp_enqueue_script('elementor-cache-sync', plugin_dir_url(__FILE__) . 'js/elementor-cache-sync.js', [], '2.2', true);
});

?>
