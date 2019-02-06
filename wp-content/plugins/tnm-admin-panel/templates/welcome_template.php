<?php
if (!function_exists('bk_welcome_template')) {
    function bk_welcome_template() {
        $theme_plugins = TGM_Plugin_Activation::$instance->plugins;
        // Arrange The Plugins, Required Plugins will be first.
        $requiredPlugins = array();
        
        foreach ($theme_plugins as $theme_plugin) {
            if($theme_plugin['required'] == 1) {
                array_push($requiredPlugins, $theme_plugin);
            }
        }
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
            <a href="admin.php?page=bk-theme-welcome" class="nav-tab nav-tab-active">Welcome</a>
            <a href="admin.php?page=bk-theme-plugins" class="nav-tab">Plugins</a>
            <?php if ( $allRequiredPluginsActivate ) {?>
                <a href="admin.php?page=bk-theme-demos" class="nav-tab">Install demos</a>
                <a href="admin.php?page=bk-system-status" class="nav-tab">System status</a>
                <a href="admin.php?page=_options" class="nav-tab">Theme Options</a>
            <?php }?>
        </div>   
        <div class="postbox bkpostbox">
        	<div class="hndle" style="padding: 15px 30px;">
                <h1><?php esc_html_e('Welcome to The Next Mag', 'bkninja'); ?></h1>
                <p class="bk-admin-notice">
        			Thank you for using our theme, The Next Mag is now installed and ready to use!
        		</p>
                <?php if (! $allRequiredPluginsActivate ) {?>
                <p class="bk-admin-notice">
        			Note: You should install all required plugins and activate them to have Full Options of The Next Mag.
        		</p>
                <?php }?>
            </div>
        	<div class="inside" style="margin: 30px -15px 30px -15px;">
        		<div class="main bk-welcome-main">
                    <div class="introduce clearfix">
                        <div class="bk-screenshot">
                            <img src="<?php echo (BK_AD_PLUGIN_URL . 'assets/images/item-preview.png');?>"/>
                        </div>
                        <div class="bk-welcome-content">
                            <p>The Next Mag supports one click demo importer, quickly get your site to look like our demo page and get started easily. You should make sure you have installed all required plugins and activate them to have Full Options of The Next Mag.</p>
                        </div>
                    </div>
                    <div class="bk-welcome-footer clearfix">
                        <div class="bk-welcome-footer-inner">
                            <h2>Technical Support and Documentation</h2>
                            <p>
                                Technical Support is free for all customers purchasing The Next Mag. For any questions or any bugs related to the setup of The Next Mag that are not covered by the theme documentation, please contact us via bkninja.team@gmail.com. Our support team is always ready to help you.
                                Our online documentation is an incredible resource for learning the ins and outs of using The Next Mag. Here you will find key points to manuals, tutorials and references that will come in handy easily.
                            </p>
                            <div class="bk-button"><a target="_blank" href="http://thenextmag.bk-ninja.com/documentation/">Open Documentation</a></div>
                        </div>
                    </div>
        		</div>
        	</div>
        </div>
    	
    	
    	<br class="clear"/>
    
    </div>
    
    <?php
    }
}