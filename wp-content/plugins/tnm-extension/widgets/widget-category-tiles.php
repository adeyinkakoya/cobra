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
add_action( 'widgets_init', 'bk_register_widget_category_titles' );

function bk_register_widget_category_titles() {
	register_widget( 'bk_widget_category_titles' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class bk_widget_category_titles extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'mnmd-widget', 'description' => esc_html__('Displays Category Titles.', 'the-next-mag') );

		/* Create the widget. */
		parent::__construct( 'bk_widget_category_titles', esc_html__('[TNM] Widget Category Tiles', 'the-next-mag'), $widget_ops);
	}
    
	/**
	 *display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
        
        $widget_opts = array();
        $title       = $instance['title'];
        $headingStyle = strip_tags($instance['heading_style']);
        $instance['tile_description'] = strip_tags($instance['tile_description']);
        $category_ids =  explode( ',', $instance['category_ids'] );
        
        echo ($before_widget);
        
        if($headingStyle) {
            $headingClass = tnm_core::bk_get_widget_heading_class($headingStyle);
        }else {
            $headingClass = '';
        }             
		if ( $title ) { echo tnm_widget::bk_get_widget_heading($title, $headingClass); }
        ?>
        <div class="mnmd-widget-categories mnmd-widget widget">
            <ul class="list-unstyled list-space-sm">
                <?php
                    echo tnm_widget::get_category_tiles($category_ids, $instance['tile_description']);
                ?>
            </ul>
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
        $instance['tile_description']  = strip_tags($new_instance['tile_description']);
        $instance['category_ids']   = $new_instance['category_ids'];
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {
		$defaults = array('title' => 'Categories', 'heading_style' => 'default', 'tile_description' => '', 'category_ids' => '');
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
		    <label for="<?php echo esc_attr($this->get_field_id( 'tile_description' )); ?>"><?php esc_attr_e('Tile Description :', 'the-next-mag'); ?></label>
		    <select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tile_description' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tile_description' )); ?>" >
			    <option value="description" <?php if( !empty($instance['tile_description']) && $instance['tile_description'] == 'description' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Category description', 'the-next-mag'); ?></option>
			    <option value="post-count" <?php if( !empty($instance['tile_description']) && $instance['tile_description'] == 'post-count' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Post Count', 'the-next-mag'); ?></option>
			    <option value="disable" <?php if( !empty($instance['tile_description']) && $instance['tile_description'] == 'disable' ) echo 'selected="selected"'; else echo ""; ?>><?php esc_attr_e('Disable', 'the-next-mag'); ?></option>
			 </select>
	    </p>
        
        <p>
		    <label for="<?php echo esc_attr($this->get_field_id( 'category_ids' )); ?>"><?php esc_attr_e('Categories: (Separate category ids by the comma. e.g. 1,2):','the-next-mag') ?></label>
		    <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'category_ids' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'category_ids' )); ?>" value="<?php if( !empty($instance['category_ids']) ) echo esc_attr($instance['category_ids']); ?>" />
	    </p>
<?php
	}
}
?>
