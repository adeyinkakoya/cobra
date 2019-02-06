<?php
/**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init', 'tnm_register_instagram_widget');
function tnm_register_instagram_widget(){
	register_widget('tnm_instagram');
}
class tnm_instagram extends WP_Widget {
    
/**
 * Widget setup.
 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'mnmd-widget', 'description' => esc_html__('Displays Instagram Gallery.', 'the-next-mag') );

		/* Create the widget. */
		parent::__construct( 'tnm_instagram', esc_html__('[TNM]: Instagram', 'the-next-mag'), $widget_ops);
	}
    function widget( $args, $instance ) {
		extract($args);
        $title = $instance['title'];
        $headingStyle = $instance['heading_style'];
        $userid = apply_filters('userid', $instance['userid']);
    	$amount = apply_filters('instagram_image_amount', $instance['image_amount']);
        if($headingStyle) {
            $headingClass = tnm_core::bk_get_widget_heading_class($headingStyle);
        }else {
            $headingClass = '';
        }	
        echo $before_widget; 
        
        if ( $title ) { echo tnm_widget::bk_get_widget_heading($title, $headingClass); }
        
		// Pulls and parses data.
        
        $photos_arr = array();
            
		$search_for['username'] = $userid;
    	$photos_arr = tnm_widget::tnm_get_instagram( $search_for, $amount, $amount, false );
        
		?>
        <div class="tnm-instagram-widget-wrap">
        	<ul class="list-unstyled clearfix">
        		<?php
        			foreach($photos_arr as $photo)
        			{
        		?>
        			<li><a target="_blank" href="<?php echo esc_url($photo['link']); ?>"><img src="<?php echo esc_url($photo['large']); ?>" alt="<?php echo esc_attr($photo['description']); ?>" /></a></li>
        		<?php
        			}
        		?>
        	</ul>	
        </div>
        								
        <?php echo $after_widget; ?>
        			 
        <?php }	

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {	
        return $new_instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
      /* Set up some default widget settings. */
      $defaults = array( 'title' => '', 'heading_style' => 'default', 'userid' => '', 'image_amount' => '');
      $instance = wp_parse_args( (array) $instance, $defaults );	

      $title = esc_attr($instance['title']);
			$userid = esc_attr($instance['userid']);
			$amount = esc_attr($instance['image_amount']);	
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
    <p><label for="<?php echo $this->get_field_id('userid'); ?>"><?php esc_html_e( 'Instagram user ID:', 'the-next-mag'); ?> <input class="widefat" id="<?php echo $this->get_field_id('userid'); ?>" name="<?php echo $this->get_field_name('userid'); ?>" type="text" value="<?php echo $userid; ?>" /></label></p>
    <p><label for="<?php echo $this->get_field_id('image_amount'); ?>"><?php esc_html_e( 'Images count:', 'the-next-mag'); ?> <input class="widefat" id="<?php echo $this->get_field_id('image_amount'); ?>" name="<?php echo $this->get_field_name('image_amount'); ?>" type="text" value="<?php echo $amount; ?>" /></label></p>	

<?php }

}
?>