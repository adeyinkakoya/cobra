<?php
if (!function_exists('bk_plugins_template')) {
    function bk_plugins_template() {
        if (current_user_can( 'activate_plugins' )) {
            // deactivate a plugin from tgm
            if (isset($_GET['deactivate_plugin_slug'])) {
                $bk_deactivate_plugin_slug = $_GET['deactivate_plugin_slug'];
                if (!empty($bk_deactivate_plugin_slug)) {
                    $plugins = TGM_Plugin_Activation::$instance->plugins;
                    foreach ($plugins as $plugin) {
                        if ($plugin['slug'] == $bk_deactivate_plugin_slug) {
                            deactivate_plugins($plugin['file_path']);
                            ?>
                            <script type="text/javascript">
                                window.location = "admin.php?page=bk-theme-plugins";
                            </script>
                            <?php
                            break;
                        }
                    }
                }
            }
        
            // Activate a plugin
            if (isset($_GET['activate_plugin_slug'])) {
                $bk_activate_plugin_slug = $_GET['activate_plugin_slug'];
                if (!empty($bk_activate_plugin_slug)) {
                    $plugins = TGM_Plugin_Activation::$instance->plugins;
        
                    foreach ($plugins as $plugin) {
                        if ($plugin['slug'] == $bk_activate_plugin_slug) {
                            activate_plugins($plugin['file_path']);
                            ?>
                            <script type="text/javascript">
                                window.location = "admin.php?page=bk-theme-plugins";
                            </script>
                            <?php
                            break;
                        }
                    }
                }
            }
        }
    
        $theme_plugins = TGM_Plugin_Activation::$instance->plugins;
        // Arrange The Plugins, Required Plugins will be first.
        $requiredPlugins = array();
        $optionalPlugins = array();
        
        foreach ($theme_plugins as $theme_plugin) {
            if($theme_plugin['required'] == 1) {
                array_push($requiredPlugins, $theme_plugin);
            }else {
                array_push($optionalPlugins, $theme_plugin);
            }
        }
        $theme_plugins = array_merge($requiredPlugins, $optionalPlugins);
        $bk_plugin_list = get_plugins();
        $allRequiredPluginsActivate = 0;
        foreach ($requiredPlugins as $theme_plugin) {
            if (is_plugin_active( $theme_plugin['file_path'])) {
                $allRequiredPluginsActivate = 1;
            }else {
                $allRequiredPluginsActivate = 0;
                break;
            }
        }
    ?>
    <br />
    <div class="page-wrap" style="margin: 20px 30px 0 2px;">
        <div class="nav-tab-wrapper">
            <a href="admin.php?page=bk-theme-welcome" class="nav-tab">Welcome</a>
            <a href="admin.php?page=bk-theme-plugins" class="nav-tab nav-tab-active">Plugins</a>
            <?php if ( $allRequiredPluginsActivate ) {?>
                <a href="admin.php?page=bk-theme-demos" class="nav-tab">Install demos</a>
                <a href="admin.php?page=bk-system-status" class="nav-tab">System status</a>
                <a href="admin.php?page=_options" class="nav-tab">Theme Options</a>
            <?php }?>
        </div>   
        <div class="postbox bkpostbox">
        	<div class="hndle" style="padding: 15px 30px;">
                <h1><?php esc_html_e('Plugins Installation', 'bkninja'); ?></h1>
                <p class="bk-admin-notice">
        			You should install all required plugins and activate them to have Full Options of The Next Mag.
        		</p>
            </div>
        	<div class="inside" style="margin: 30px -15px 30px -15px;">
        		<div class="main">
                    <div class="bk-plugins-wrapper bk-demo-wrapper clearfix">
                    <?php 
                        foreach ($theme_plugins as $theme_plugin) {
                            if($theme_plugin['required'] == 1) {
                                $requiredPluginClass = "a-required-plugin";
                            }else {
                                $requiredPluginClass = '';
                            }
                    ?>
                        <?php if($theme_plugin['name'] != 'TNM Admin Panel') {?>
                            <?php
                                $plugin_status = 'not-installed';
                        
                                if (is_plugin_active( $theme_plugin['file_path'])) {
                                    $plugin_status = 'plugin-active';
                                    $required_label = 'plugin-active';
                                }elseif (isset($bk_plugin_list[$theme_plugin['file_path']])) {
                                    $plugin_status = 'plugin-inactive';
                                }
                                
                            ?>
                            <div class="bk-demo-item <?php echo ($plugin_status);?>">
                                <div class="bk-demo-item-inner <?php echo $requiredPluginClass;?>">
                                    <div class="plugin-screenshot">
                                        <img src="<?php echo $theme_plugin['img'];?>" alt="Default" style=" width: 100%; "/>
                                    </div>
                                    <div class="bk-demo-header"><?php echo tnm_name_limit_by_word(esc_attr($theme_plugin['name']), 4);?></div>
                                    <div class="plugin-actions">
                                        <a class="bk-install-plugin" href="<?php
                                        echo esc_url( wp_nonce_url(
                                            add_query_arg(
                                                array(
                                                    'page'		  	=> urlencode(TGM_Plugin_Activation::$instance->menu),
                                                    'plugin'		=> urlencode($theme_plugin['slug']),
                                                    'tgmpa-install' => 'install-plugin',
                                                    'return_url' => 'bk-theme-plugins'
                                                ),
                                                admin_url('themes.php?page=install-required-plugins')
                                            ),
                                            'tgmpa-install',
                                            'tgmpa-nonce'
                                        ));
                                        ?>" title="<?php echo esc_attr($theme_plugin['name']);?>">Install</a>
                                        <a class="bk-deactivate-plugin" href="<?php
                                        echo esc_url(
                                            add_query_arg(
                                                array(
                                                    'page'		  	            => urlencode('bk-theme-plugins'),
                                                    'deactivate_plugin_slug'	=> urlencode($theme_plugin['slug']),
                                                ),
                                                admin_url('admin.php')
                                            ));
                                        ?>" title="<?php echo esc_attr($theme_plugin['name']);?>">Deactivate</a>
                        
                                        <a class="bk-activate-plugin" href="<?php
                                        echo esc_url(
                                            add_query_arg(
                                                array(
                                                    'page'		  	            => urlencode('bk-theme-plugins'),
                                                    'activate_plugin_slug'	    => urlencode($theme_plugin['slug']),
                                                ),
                                                admin_url('admin.php')
                                            ));
                                        ?>" title="<?php echo esc_attr($theme_plugin['name']);?>">Activate</a>
                                        <div class="plugin-installing-pending">Pending</div>
                                        <div class="plugin-installing"></div>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    <?php }?>
                    </div>
        		</div>
        	</div>
        </div>
    	
    	
    	<br class="clear"/>
    
    </div>
    
    <?php
    }
}