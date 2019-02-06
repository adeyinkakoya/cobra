<?php
// Declare Folder Name
define( 'BK_DEMO_1', 'demo_1' );
define( 'BK_DEMO_2', 'demo_2' );
define( 'BK_DEMO_3', 'demo_3' );
define( 'BK_DEMO_4', 'demo_4' );
define( 'BK_DEMO_5', 'demo_5' );
define( 'BK_DEMO_6', 'demo_6' );
define( 'BK_DEMO_7', 'demo_7' );
define( 'BK_DEMO_8', 'demo_8' );
define( 'BK_DEMO_9', 'demo_9' );
define( 'BK_DEMO_10', 'demo_10' );
define( 'BK_DEMO_11', 'demo_11' );
define( 'BK_DEMO_12', 'demo_12' );
define( 'BK_DEMO_13', 'demo_13' );
define( 'BK_DEMO_14', 'demo_14' );
define( 'BK_DEMO_15', 'demo_15' );
define( 'BK_DEMO_16', 'demo_16' );
define( 'BK_DEMO_17', 'demo_17' );
define( 'BK_DEMO_18', 'demo_18' );

if (!function_exists('bk_demo_config_options')) {
    function bk_theme_demo_html() {
        $bk_theme_demos = bk_demo_config_options();       
         
    ?>
    <div class="page-wrap" style="margin: 20px 30px 0 2px;">
        <div class="nav-tab-wrapper">
            <a href="admin.php?page=bk-theme-welcome" class="nav-tab">Welcome</a>
            <a href="admin.php?page=bk-theme-plugins" class="nav-tab">Plugins</a>
            <a href="admin.php?page=bk-theme-demos" class="nav-tab nav-tab-active">Install demos</a>
            <a href="admin.php?page=bk-system-status" class="nav-tab">System status</a>
            <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) {?>
            <a href="admin.php?page=_options" class="nav-tab">Theme Options</a>
            <?php }?>
        </div>  
        <div class="postbox bkpostbox">
        	<div class="hndle" style="padding: 15px 30px;">
                <h1><?php esc_html_e('Install demo with 1 CLICK', 'bkninja'); ?></h1>
                <p class="bk-admin-notice">
        			Please do not navigate this browser while the tool is running.
        		</p>
            </div>
        	<div class="inside" style="margin: 30px -15px 30px -15px;">
        		<div class="main">
                    <div class="bk-demo-wrapper clearfix">
                        <?php foreach ($bk_theme_demos as $demoKey => $theme_demo) {
                            switch($demoKey) {
                                case BK_DEMO_1:
                                    $demoStatus = get_option('bk_demo_1_status' );
                                    break;
                                case BK_DEMO_2:
                                    $demoStatus = get_option('bk_demo_2_status' );
                                    break;
                                case BK_DEMO_3:
                                    $demoStatus = get_option('bk_demo_3_status' );
                                    break;
                                case BK_DEMO_4:
                                    $demoStatus = get_option('bk_demo_4_status' );
                                    break;
                                case BK_DEMO_5:
                                    $demoStatus = get_option('bk_demo_5_status' );
                                    break;
                                case BK_DEMO_6:
                                    $demoStatus = get_option('bk_demo_6_status' );
                                    break;
                                case BK_DEMO_7:
                                    $demoStatus = get_option('bk_demo_7_status' );
                                    break;
                                case BK_DEMO_8:
                                    $demoStatus = get_option('bk_demo_8_status' );
                                    break;
                                case BK_DEMO_9:
                                    $demoStatus = get_option('bk_demo_9_status' );
                                    break;
                                case BK_DEMO_10:
                                    $demoStatus = get_option('bk_demo_10_status' );
                                    break;
                                case BK_DEMO_11:
                                    $demoStatus = get_option('bk_demo_11_status' );
                                    break;
                                case BK_DEMO_12:
                                    $demoStatus = get_option('bk_demo_12_status' );
                                    break;
                                case BK_DEMO_13:
                                    $demoStatus = get_option('bk_demo_13_status' );
                                    break;
                                case BK_DEMO_14:
                                    $demoStatus = get_option('bk_demo_14_status' );
                                    break;
                                case BK_DEMO_15:
                                    $demoStatus = get_option('bk_demo_15_status' );
                                    break;
                                case BK_DEMO_16:
                                    $demoStatus = get_option('bk_demo_16_status' );
                                    break;
                                case BK_DEMO_17:
                                    $demoStatus = get_option('bk_demo_17_status' );
                                    break;
                                case BK_DEMO_18:
                                    $demoStatus = get_option('bk_demo_18_status' );
                                    break;
                            }
                            ?>
                            <div class="bk-demo-item <?php echo $theme_demo['class'];?>">
                                <div class="bk-demo-item-inner <?php if($demoStatus == 'imported') echo 'demo-done'; else echo 'demo-waiting';?>">
                                    <img src="<?php echo $theme_demo['img'];?>" alt="Default" style=" width: 100%; ">
                        			<div class="bk-demo-header"><?php echo $theme_demo['title'];?></div>
                                    <div class="bk-import-action">
                                        <a class="bk_importer_start"><?php esc_html_e( 'Import Demo','bkninja')?></a>
                                        <div class="demo-installing"></div>
                                        <div class="demo-install-message"><?php esc_html_e( 'Imported','bkninja')?></div>
                                    </div>
                                    <div class="attachment-setting-switch">
                                        <label class="switch">
                                            <input type="checkbox" checked>
                                            <span class="slider round"></span>
                                        </label>
                                        <span><?php esc_html_e('Import attachments');?></span>
                                    </div>
                                </div>
                                <div class="bk-import-process-bar"></div>
                            </div>
                        <?php }?>
                    </div>
        		</div>
        	</div>
        </div>
    	
    	<br class="clear"/>
    
    </div>
    
    <?php }
}
    