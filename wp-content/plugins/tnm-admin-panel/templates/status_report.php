<?php
function let_to_num( $size ) {
    $l   = substr( $size, - 1 );
    $ret = substr( $size, 0, - 1 );

    switch ( strtoupper( $l ) ) {
        case 'P':
            $ret *= 1024;
        case 'T':
            $ret *= 1024;
        case 'G':
            $ret *= 1024;
        case 'M':
            $ret *= 1024;
        case 'K':
            $ret *= 1024;
    }

    return $ret;
}
function bk_system_status_template() {
?>
<br />
<div class="page-wrap" style="margin: 20px 30px 0 2px;">
    <div class="nav-tab-wrapper">
        <a href="admin.php?page=bk-theme-welcome" class="nav-tab">Welcome</a>
        <a href="admin.php?page=bk-theme-plugins" class="nav-tab">Plugins</a>
        <?php if ( class_exists( 'ReduxFrameworkPlugin' ) ) {?>
            <a href="admin.php?page=bk-theme-demos" class="nav-tab">Install demos</a>
            <a href="admin.php?page=bk-system-status" class="nav-tab nav-tab-active">System status</a>
            <a href="admin.php?page=_options" class="nav-tab">Theme Options</a>
        <?php }?>
    </div>    
    <div class="postbox bkpostbox">
        <?php 
            if ( ! class_exists( 'ReduxFrameworkPlugin' ) ) {
        ?>
            <div class="hndle" style="padding: 15px 30px;">
                <p class="bk-admin-notice"><?php esc_html_e('Please install all required plugins before using The Next Mag. Click below button to go to the plugin tab', 'bkninja'); ?></p>
        		<div class="bk-admin-button bk-button"><a href="admin.php?page=bk-theme-plugins" class="">Plugin Tab</a></div>
                <br />
            </div>
        <?php
    		}else {
        ?>   
    	<div class="hndle" style="padding: 15px 30px;">
            <h1><?php esc_html_e('The Next Mag - System Status', 'bkninja'); ?></h1>
            <div class="status-message-wrap">
    			<p class="bk-admin-notice">We recommend you to contact your web hosting service provider to make sure that your server PHP configuration limits are as follows:</p>
                <ul>
                    <li>max_execution_time  - 600</li>
                    <li>memory_limit        - 256M or 512M</li>
                    <li>post_max_size       - 32M</li>
                    <li>upload_max_filesize - 32M</li>
                </ul>
    		</div>
        </div>
    	<div class="inside" style="margin: 30px -15px 30px -15px;">
    		<div class="main">
                <div class="wrap about-wrap redux-status">
                
                    <table class="redux_status_table widefat" cellspacing="0" id="status">
                        <thead>
                        <tr>
                            <th colspan="3"
                                data-export-label="Server Environment"><?php esc_html_e( 'Server & WordPress Environment', 'redux-framework' ); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td data-export-label="WP Memory Limit"><?php esc_html_e( 'WP Memory Limit', 'redux-framework' ); ?>:</td>
                            <td class="help"><?php echo '<a href="#" class="bk-tipper-bottom bk-help" data-title="' . esc_attr__( 'The maximum amount of memory (RAM) that your site can use at one time.', 'redux-framework' ) . '"><span>i</span></a>'; ?></td>
                            <td><?php
                                    $memory = let_to_num(WP_MEMORY_LIMIT);
                
                                    if ( $memory < 40000000 ) {
                                        echo '<mark class="error">' . sprintf( esc_html__( '%s - We recommend setting memory to at least 40MB. See: <a href="%s" target="_blank">Increasing memory allocated to PHP</a>', 'redux-framework' ), $sysinfo['wp_mem_limit']['size'], 'http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP' ) . '</mark>';
                                    } else {
                                        echo '<mark class="yes">' . size_format($memory) . '</mark>';
                                    }
                                ?></td>
                        </tr>
                        <tr>
                            <td data-export-label="PHP Version"><?php esc_html_e( 'PHP Version', 'redux-framework' ); ?>:</td>
                            <td class="help"><?php echo '<a href="#" class="bk-tipper-bottom bk-help" data-title="' . esc_attr__( 'The version of PHP installed on your hosting server.', 'redux-framework' ) . '"><span>i</span></a>'; ?></td>
                            <td><?php echo PHP_VERSION; ?></td>
                        </tr>
                        
                        <?php if ( function_exists( 'ini_get' ) ) { ?>
                            <tr>
                                <td data-export-label="PHP Memory Limit"><?php esc_html_e( 'PHP Memory Limit', 'redux-framework' ); ?>:</td>
                                <td class="help"><?php echo '<a href="#" class="bk-tipper-bottom bk-help" data-title="' . esc_attr__( 'The largest filesize that can be contained in one post.', 'redux-framework' ) . '"><span>i</span></a>'; ?></td>
                                <td><?php echo size_format( let_to_num( ini_get( 'memory_limit' ) ) ); ?></td>
                            </tr>
                            <tr>
                                <td data-export-label="PHP Post Max Size"><?php esc_html_e( 'PHP Post Max Size', 'redux-framework' ); ?>:</td>
                                <td class="help"><?php echo '<a href="#" class="bk-tipper-bottom bk-help" data-title="' . esc_attr__( 'The largest filesize that can be contained in one post.', 'redux-framework' ) . '"><span>i</span></a>'; ?></td>
                                <td><?php echo size_format( let_to_num( ini_get( 'post_max_size' ) ) ); ?></td>
                            </tr>
                            <tr>
                                <td data-export-label="PHP Max Execution Time"><?php esc_html_e( 'PHP Max Execution Time', 'redux-framework' ); ?>:</td>
                                <td class="help"><?php echo '<a href="#" class="bk-tipper-bottom bk-help" data-title="' . esc_attr__( 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)', 'redux-framework' ) . '"><span>i</span></a>'; ?></td>
                                <td><?php echo ini_get( 'max_execution_time' ); ?></td>
                            </tr>
                            <tr>
                                <td data-export-label="PHP Max Input Vars"><?php esc_html_e( 'PHP Max Input Vars', 'redux-framework' ); ?>:</td>
                                <td class="help"><?php echo '<a href="#" class="bk-tipper-bottom bk-help" data-title="' . esc_attr__( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'redux-framework' ) . '"><span>i</span></a>'; ?></td>
                                <td><?php echo ini_get( 'max_input_vars' ); ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td data-export-label="Max Upload Size"><?php esc_html_e( 'Max Upload Size', 'redux-framework' ); ?>:</td>
                            <td class="help"><?php echo '<a href="#" class="bk-tipper-bottom bk-help" data-title="' . esc_attr__( 'The largest filesize that can be uploaded to your WordPress installation.', 'redux-framework' ) . '"><span>i</span></a>'; ?></td>
                            <td><?php echo size_format( wp_max_upload_size() ); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
    		</div>
    	</div>
        <?php }?>
    </div>

</div>

<?php
}