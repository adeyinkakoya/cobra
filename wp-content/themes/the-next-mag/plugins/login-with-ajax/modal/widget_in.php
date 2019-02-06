<?php 
/*
 * This is the page users will see logged in. 
 * You can edit this, but for upgrade safety you should copy and modify this file into your template folder.
 * The location from within your template folder is plugins/login-with-ajax/ (create these directories if they don't exist)
*/
?>
<?php 
	global $current_user;
	wp_get_current_user();
?>
<div class="bk-lwa navigation-bar-btn">
	<table>
		<tr>
			<td class="avatar lwa-avatar bk-avatar">
				<a href="#"><?php echo get_avatar( $current_user->ID, $size = '27' );  ?></a>
                <div class="bk-username visible-xs visible-sm">
                    <a href="<?php echo get_edit_user_link($current_user->ID); ?>"><?php echo  esc_attr($current_user->display_name);  ?></a>
                </div>
                <div class="bk-canvas-logout visible-xs visible-sm">
                    <i class="mdicon mdicon-log-out"></i>
                    <a class="wp-logout" href="<?php echo wp_logout_url() ?>"><?php esc_html_e( 'Log Out' ,'the-next-mag') ?></a>
                </div>
			</td>
		</tr>
	</table>
    <div class="bk-account-info hidden-xs hidden-sm">
        <?php if ( class_exists('bbpress') ) { ?>
                <div class="bk-lwa-profile">
                    <div class="bk-avatar">
                        <?php echo get_avatar( $current_user->ID, $size = '70' );  ?>
                    </div>
            
                    <div class="bk-user-data clearfix">
                        <div class="bk-username">
                            <i class="mdicon mdicon-person"></i>
                            <a href="<?php echo get_edit_user_link($current_user->ID); ?>"><?php echo  esc_attr($current_user->display_name);  ?></a>
                        </div>
                        <div class="cb-block">
                            <i class="mdicon mdicon-comment"></i>
                            <a href="<?php bbp_user_topics_created_url($current_user->ID); ?>"><?php esc_html_e( 'Topics Started', 'the-next-mag' ); ?></a>
                        </div>
        
                        <div class="cb-block">
                            <i class="mdicon mdicon-comment"></i>
                            <a href="<?php bbp_user_replies_created_url($current_user->ID); ?>"><?php esc_html_e( 'Replies Created', 'the-next-mag' ); ?></a>
                        </div>
        
                        <div class="cb-block">
                            <i class="fa fa-heart-o"></i>
                            <a href="<?php bbp_favorites_permalink($current_user->ID); ?>"><?php esc_html_e( 'Favorites', 'the-next-mag' ); ?></a>
                        </div>
        
                        <div class="cb-block">
                            <i class="fa fa-bookmark-o"></i>
                            <a href="<?php bbp_subscriptions_permalink($current_user->ID); ?>"><?php esc_html_e( 'Subscriptions', 'the-next-mag' ); ?></a>
                        </div>
                        
                        <div class="bk-block">
                            <i class="mdicon mdicon-log-out"></i>
                            <a class="wp-logout" href="<?php echo wp_logout_url() ?>"><?php esc_html_e( 'Log Out' ,'the-next-mag') ?></a>
                        </div>
                        
                    </div>  
                </div>
        <?php }else {?>
                <div class="bk-lwa-profile">
                    <div class="bk-avatar">
                        <?php echo get_avatar( $current_user->ID, $size = '80' );  ?>
                    </div>
            
                    <div class="bk-user-data clearfix">
                        <div class="bk-username">
                            <i class="mdicon mdicon-person"></i>
                            <a href="<?php echo get_edit_user_link($current_user->ID); ?>"><?php echo  esc_attr($current_user->display_name);  ?></a>
                        </div>
                        <div class="bk-block">
                            <i class="mdicon mdicon-person_pin"></i>
                            <a href="<?php echo get_edit_user_link($current_user->ID); ?>"><?php esc_html_e("Edit Profile", 'the-next-mag'); ?></a>
                        </div>  
                        
                        <div class="bk-block">
                            <i class="mdicon mdicon-sign-out"></i>
                            <a class="wp-logout" href="<?php echo wp_logout_url() ?>"><?php esc_html_e( 'Log Out' ,'the-next-mag') ?></a>
                        </div>
                        
                    </div>  
                </div>
        <?php }?>
    </div>
</div>