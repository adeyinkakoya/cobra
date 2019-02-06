<?php
/**
 * Plugin Name: [TNM] Widget Most Commented
 * Plugin URI: http://bk-ninja.com/
 * Description: This widget displays the most commented posts with comment count on the left.
 * Version: 1.0
 * Author: BK-Ninja
 * Author URI: http://bk-ninja.com/
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'bk_register_widget_social_counters' );

function bk_register_widget_social_counters() {
	register_widget( 'bk_widget_social_counters' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class bk_widget_social_counters extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'mnmd-widget', 'description' => esc_html__('Displays Social Item Counters.', 'the-next-mag') );

		/* Create the widget. */
		parent::__construct( 'bk_widget_social_counters', esc_html__('[TNM] Widget Social Counters', 'the-next-mag'), $widget_ops);
	}
    
	/**
	 *display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
        
        $widget_opts = array();
        $title = $instance['title'];
        $headingStyle = $instance['heading_style'];
        
        if($instance['facebook_url'] != '') :      
            $socialItems['facebook']['url']     = $instance['facebook_url'];
        endif;
        if($instance['twitter_url'] != '') :      
            $socialItems['twitter']['url']     = $instance['twitter_url'];
        endif;
        if($instance['youtube_url'] != '') :      
            $socialItems['youtube']['url']     = $instance['youtube_url'];
        endif;
        if($instance['gplus_url'] != '') :      
            $socialItems['gplus']['url']     = $instance['gplus_url'];
        endif;
        if($instance['instagram_accesstoken'] != '') :      
            $socialItems['instagram']['accesstoken']     = $instance['instagram_accesstoken'];
        endif;
        if($instance['dribbble_url'] != '') :      
            $socialItems['dribbble']['url']     = $instance['dribbble_url'];
        endif;
        if($instance['pinterest_url'] != '') :      
            $socialItems['pinterest']['url']     = $instance['pinterest_url'];
        endif;
        
        if($headingStyle) {
            $headingClass = tnm_core::bk_get_widget_heading_class($headingStyle);
        }else {
            $headingClass = '';
        }
        
        // Update Database
        tnm_widget::bk_update_social_json($socialItems);
        
        echo ($before_widget);
        
        if ( $title ) { echo tnm_widget::bk_get_widget_heading($title, $headingClass); }
        
        ?>
        <div class="mnmd-widget-social-counter-counter mnmd-widget widget">
            <div class="mnmd-widget-social-counter__inner">
                <ul class="list-unstyled list-space-xs">
                    <?php 
                        foreach ($socialItems as $socialItem => $socialVal) :
                            echo tnm_widget::bk_socialItem__counters_render($socialItem);
                        endforeach;
                    ?>
                </ul>
            </div>
        </div>
        <?php
        
        /* After widget (defined by themes). */
		echo ($after_widget);
	}
	
	/**
	 * update widget settings
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
        $instance['title']          = $new_instance['title'];
        $instance['heading_style']  = strip_tags($new_instance['heading_style']);
        $instance['facebook_url']   = strip_tags($new_instance['facebook_url']);
        $instance['twitter_url']    = strip_tags($new_instance['twitter_url']);
        $instance['youtube_url']    = strip_tags($new_instance['youtube_url']);
        $instance['gplus_url']      = strip_tags($new_instance['gplus_url']);
        $instance['instagram_accesstoken']      = strip_tags($new_instance['instagram_accesstoken']);
        $instance['dribbble_url']   = strip_tags($new_instance['dribbble_url']);
        $instance['pinterest_url']  = strip_tags($new_instance['pinterest_url']);
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
		$defaults = array(
                        'title'             => 'Stay Connected', 
                        'heading_style'     => 'default', 
                        'facebook_url'      => '', 
                        'twitter_url'       => '',
                        'youtube_url'       => '',
                        'gplus_url'         => '',
                        'instagram_url'     => '',
                        'dribbble_url'      => '',
                        'pinterest_url'     => '',
                        );
		$instance = wp_parse_args((array) $instance, $defaults);
	?>
        <p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><strong><?php esc_html_e('[Optional] Title:', 'the-next-mag'); ?></strong></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php if( !empty($instance['title']) ) echo esc_attr($instance['title']); ?>" />
		</p>
        
        <p>
		    <label for="<?php echo esc_attr($this->get_field_id( 'heading_style' )); ?>"><?php esc_attr_e('Heading Style:', 'the-next-mag'); ?></label>
		    <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'heading_style' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'heading_style' )); ?>" >
			    <option value="default" <?php if( !empty($instance['heading_style']) && $instance['heading_style'] == 'default' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Default - From Theme Option', 'the-next-mag'); ?></option>
                <option value="line" <?php if( !empty($instance['heading_style']) && $instance['heading_style'] == 'line' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Heading Line', 'the-next-mag'); ?></option>
			    <option value="no-line" <?php if( !empty($instance['heading_style']) && $instance['heading_style'] == 'no-line' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Heading No Line', 'the-next-mag'); ?></option>
			    <option value="line-under" <?php if( !empty($instance['heading_style']) && $instance['heading_style'] == 'line-under' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Line Under', 'the-next-mag'); ?></option>
			    <option value="center" <?php if( !empty($instance['heading_style']) && $instance['heading_style'] == 'center' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Heading Center', 'the-next-mag'); ?></option>
			    <option value="line-around" <?php if( !empty($instance['heading_style']) && $instance['heading_style'] == 'line-around' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Heading Line Around', 'the-next-mag'); ?></option>
			</select>
	    </p>
        
        <p>
			<label for="<?php echo esc_attr($this->get_field_id( 'facebook_url' )); ?>"><strong><?php esc_html_e('Facebook URL:', 'the-next-mag'); ?></strong></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('facebook_url')); ?>" name="<?php echo esc_attr($this->get_field_name('facebook_url')); ?>" value="<?php if( !empty($instance['facebook_url']) ) echo esc_attr($instance['facebook_url']); ?>" />
            <i><?php esc_attr_e('eg. https://www.facebook.com/envato','the-next-mag') ?></i>
        </p>
        
        <p>
			<label for="<?php echo esc_attr($this->get_field_id( 'twitter_url' )); ?>"><strong><?php esc_html_e('Twitter URL:', 'the-next-mag'); ?></strong></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('twitter_url')); ?>" name="<?php echo esc_attr($this->get_field_name('twitter_url')); ?>" value="<?php if( !empty($instance['twitter_url']) ) echo esc_attr($instance['twitter_url']); ?>" />
            <i><?php esc_attr_e('eg. https://www.twitter.com/envato','the-next-mag') ?></i>
        </p>
        
        <p>
			<label for="<?php echo esc_attr($this->get_field_id( 'youtube_url' )); ?>"><strong><?php esc_html_e('Youtube URL (Full URL):', 'the-next-mag'); ?></strong></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('youtube_url')); ?>" name="<?php echo esc_attr($this->get_field_name('youtube_url')); ?>" value="<?php if( !empty($instance['youtube_url']) ) echo esc_attr($instance['youtube_url']); ?>" />
            <i><?php esc_attr_e('eg. https://www.youtube.com/user/envato','the-next-mag') ?></i>
        </p>
        
        <p>
			<label for="<?php echo esc_attr($this->get_field_id( 'gplus_url' )); ?>"><strong><?php esc_html_e('Google Plus URL (Full URL):', 'the-next-mag'); ?></strong></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('gplus_url')); ?>" name="<?php echo esc_attr($this->get_field_name('gplus_url')); ?>" value="<?php if( !empty($instance['gplus_url']) ) echo esc_attr($instance['gplus_url']); ?>" />
            <i><?php esc_attr_e('eg. https://plus.google.com/+envato','the-next-mag') ?></i>
        </p>
        
        <p>
			<label for="<?php echo esc_attr($this->get_field_id( 'instagram_accesstoken' )); ?>"><strong><?php esc_html_e('Instagram Access Token:', 'the-next-mag'); ?></strong></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('instagram_accesstoken')); ?>" name="<?php echo esc_attr($this->get_field_name('instagram_accesstoken')); ?>" value="<?php if( !empty($instance['instagram_accesstoken']) ) echo esc_attr($instance['instagram_accesstoken']); ?>" />
            <i><a href="http://instagram.pixelunion.net"><?php esc_attr_e('Generate the access token here','the-next-mag')?></a> </i>
        </p>
        
        <p>
			<label for="<?php echo esc_attr($this->get_field_id( 'dribbble_url' )); ?>"><strong><?php esc_html_e('Dribbble URL:', 'the-next-mag'); ?></strong></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('dribbble_url')); ?>" name="<?php echo esc_attr($this->get_field_name('dribbble_url')); ?>" value="<?php if( !empty($instance['dribbble_url']) ) echo esc_attr($instance['dribbble_url']); ?>" />
            <i><?php esc_attr_e('eg. https://dribbble.com/envato','the-next-mag') ?></i>
        </p>
        
        <p>
			<label for="<?php echo esc_attr($this->get_field_id( 'pinterest_url' )); ?>"><strong><?php esc_html_e('Pinterest URL:', 'the-next-mag'); ?></strong></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('pinterest_url')); ?>" name="<?php echo esc_attr($this->get_field_name('pinterest_url')); ?>" value="<?php if( !empty($instance['pinterest_url']) ) echo esc_attr($instance['pinterest_url']); ?>" />
            <i><?php esc_attr_e('eg. https://pinterest.com/envato','the-next-mag') ?></i>
        </p>
        
<?php
	}
}
?>
