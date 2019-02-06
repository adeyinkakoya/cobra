<?php
add_action('wp_ajax_nopriv_plugin_check', 'plugin_check');
add_action('wp_ajax_plugin_check', 'plugin_check');
if (!function_exists('plugin_check')) {
    function plugin_check()
    {        
        $pluginName      = isset( $_POST['plugin_name'] ) ? $_POST['plugin_name'] : null; 
        
        $current_plugins = get_plugins();
        $plugin_status = 'not-installed';
        foreach ($current_plugins as $plugin_path => $current_plugin) {
            if($current_plugin['Name'] != $pluginName) continue;
            if (is_plugin_active( $plugin_path)) {
                $plugin_status = 'plugin-active';
                $required_label = 'plugin-active';
            }elseif (isset($current_plugins[$plugin_path])) {
                $plugin_status = 'plugin-inactive';
            }
            break;
        }
        die(json_encode($plugin_status));
    }
}
