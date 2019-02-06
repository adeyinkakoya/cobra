<?php
    /*
    Plugin Name: TNM Shortcode
    Plugin URI: http://bk-ninja.com
    Description: 
    Author: BKNinja
    Version: 1.2
    Author URI: http://bk-ninja.com
    */
?>
<?php
define( 'BKSC_URL', plugin_dir_url( __FILE__ ) );
define( 'BKSC_CSS_URL', trailingslashit( BKSC_URL . 'css' ) );
define( 'BKSC_JS_URL', trailingslashit( BKSC_URL . 'js' ) );

add_action('admin_head', 'bk_insert_shortcode_button');

function bk_insert_shortcode_button() {
    global $typenow;
    // sprawdzamy czy user ma uprawnienia do edycji postów/podstron
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
   	return;
    }
    // weryfikujemy typ wpisu
    if( ! in_array( $typenow, array( 'post', 'page' ) ) )
        return;
	// sprawdzamy czy user ma wlaczony edytor WYSIWYG
	if ( get_user_option('rich_editing') == 'true') {
		add_filter('mce_external_plugins', 'bk_add_tinymce_script');
		add_filter('mce_buttons', 'bk_register_shortcode_button');
	}
}

function bk_add_tinymce_script($plugin_array) {
   	$plugin_array['bk_shortcode_button'] = BKSC_JS_URL.'panel.js';
   	return $plugin_array;
}

function bk_register_shortcode_button($buttons) {
   array_push($buttons, "bk_shortcode_button");
   return $buttons;
}


if ( ! function_exists( 'bksc_scripts_method' ) ) {
    function bksc_scripts_method() {
        wp_enqueue_style( 'bkswcss', BKSC_CSS_URL . 'shortcode.css', array(), '' );
        wp_enqueue_script( 'bkswjs', BKSC_JS_URL . 'shortcode.js', array( 'jquery' ), false, true );
    }
}
add_action('wp_enqueue_scripts', 'bksc_scripts_method');

/**
 * Image ShortCode
 */
function register_image_shortcode($atts, $content = null) {
    $ret = '';
    $atts = shortcode_atts (
        array (
            'caption'       => '',
            'lightbox'      => 0,
        ), $atts );
        
    $attachmentID = attachment_url_to_postid(do_shortcode($content));
    
    $image_caption = $atts['caption'];
    if($image_caption != '') {
        $render_imageCaption = '<figcaption class="wp-caption-text">'.esc_attr($image_caption).'</figcaption>';
    }else {
        $render_imageCaption = '';
    }
    if($atts['lightbox']) {
        $ret = '
        <figure data-shortcode="caption" id="attachment_'.$attachmentID.'" class="wp-caption alignnone mnmd-post-media-wide">
        	<a href="'.do_shortcode($content).'" class="js-mnmd-lightbox-image" title="'.esc_attr($image_caption).'">
                <img class="wp-image-'.$attachmentID.' size-full" src="'.do_shortcode($content).'" alt="post image">
            </a>
            '.$render_imageCaption.'
        </figure>
        ';   
    }else {
        $ret = '
        <figure data-shortcode="caption" id="attachment_'.$attachmentID.'" class="wp-caption alignnone mnmd-post-media-wide">
        	<img class="wp-image-'.$attachmentID.' size-full" src="'.do_shortcode($content).'" alt="post image">
        	'.$render_imageCaption.'
        </figure>
        ';   
    }
    return $ret;
}
add_shortcode('image', 'register_image_shortcode');

/**
 * Blockquote ShortCode
 */
function register_blockquote_shortcode($atts, $content) {
    $ret = '';
    $atts = shortcode_atts (
        array (
            'footer'       => '',
        ), $atts );
    
    $ret = '<blockquote>';
    $ret .= '<p>'.do_shortcode($content).'</p>';
    $ret .= '<footer>';
    $ret .= $atts['footer'];
    $ret .= '</footer>';
    $ret .= '</blockquote>'; 
    return $ret; 
}
add_shortcode('blockquote', 'register_blockquote_shortcode');

/**
 * Button ShortCode
 */
function register_button_shortcode($atts, $content) {
    $ret = '';
    $atts = shortcode_atts (
        array (
            'href'       => '',
            'type'       => '',
            'size'       => '',
        ), $atts );
    
    $ret = '<a href="'.$atts['href'].'" type="button" class="btn '.$atts['type'].' '.$atts['size'].'">'.do_shortcode($content).'</a>';
    return $ret; 
}
add_shortcode('button', 'register_button_shortcode');

/**
 * OneHalf ShortCode
 */
function register_onehalfs_shortcode($atts, $content = null) {
    $ret = '';
    $ret = '<div class="row">';
    if (!preg_match_all("/(.?)\[(one_half)\b(.*?)(?:(\/))?\](?:(.+?)\[\/one_half\])?(.?)/s", $content, $matches)) {
		// if content has no accordion
		return do_shortcode($content);
	}else {
		for($i = 0; $i < count($matches[0]); $i++) {
		  $ret .= '<div class="col-xs-12 col-sm-6">             
                    '.do_shortcode(trim($matches[5][$i])).'
                </div>';
		}
	}
    $ret .= '</div>';
    return $ret;
}
add_shortcode('one_halfs', 'register_onehalfs_shortcode');

/**
 * 1/3 col ShortCode
 */
function register_onethirds_shortcode($atts, $content = null) {
    $ret = '';
    $ret = '<div class="row">';
    if (!preg_match_all("/(.?)\[(one_third)\b(.*?)(?:(\/))?\](?:(.+?)\[\/one_third\])?(.?)/s", $content, $matches)) {
		// if content has no accordion
		return do_shortcode($content);
	}else {
		for($i = 0; $i < count($matches[0]); $i++) {
		  $ret .= '<div class="col-xs-12 col-sm-4">             
            '.do_shortcode(trim($matches[5][$i])).'
        </div>';
		}
	}
    $ret .= '</div>';
    return $ret;    
}
add_shortcode('one_thirds', 'register_onethirds_shortcode');

/**
 * 1/3 2/3 col ShortCode
 */
function register_twothird_onethird_shortcode($atts, $content = null) {
    $ret = '';
    $ret = '<div class="row">';
    if (!preg_match_all("/(.?)\[(two_third)\b(.*?)(?:(\/))?\](?:(.+?)\[\/two_third\])?(.?)/s", $content, $twothird)) {
		// if content has no accordion
		return do_shortcode($content);
	}else {
		  $ret .= '<div class="col-xs-12 col-sm-8">             
            '.do_shortcode(trim($twothird[5][0])).'
        </div>';
	}
    if (!preg_match_all("/(.?)\[(one_third)\b(.*?)(?:(\/))?\](?:(.+?)\[\/one_third\])?(.?)/s", $content, $onethird)) {
		// if content has no accordion
		return do_shortcode($content);
	}else {
		  $ret .= '<div class="col-xs-12 col-sm-4">             
            '.do_shortcode(trim($onethird[5][0])).'
        </div>';
	}
    $ret .= '</div>';
    return $ret;
}
add_shortcode('twothird_onethird', 'register_twothird_onethird_shortcode');

/**
 * Tabs ShortCode
 */
function register_tabs_shortcode($atts, $content) {
	$ret = '';
	if (!preg_match_all("/(.?)\[(tab)\b(.*?)(?:(\/))?\](?:(.+?)\[\/tab\])?(.?)/s", $content, $matches)) {
		// if content has no tab
		return do_shortcode($content);
	} else {
		// content has tabs, get title and content
		for($i = 0; $i < count($matches[0]); $i++) {
			$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
		}
        
        $ret .= '<div class="mnmd-shortcode-wrap">';
		$ret .= '<ul class="nav nav-tabs" role="tablist">';
        
        $i=0;
        
        $bk_tab_title = implode(' ',$matches[3][$i]);
        $ret .= '<li role="presentation" class="active"><a href="#tab-'.$i.'" aria-controls="'.$bk_tab_title.'" role="tab" data-toggle="tab" aria-expanded="true">'.$bk_tab_title.'</a></li>';
            
        for($i = 1; $i < count($matches[0]); $i++) {
            $bk_tab_title = implode(' ',$matches[3][$i]);
            $ret .= '<li role="presentation"><a href="#tab-'.$i.'" aria-controls="'.$bk_tab_title.'" role="tab" data-toggle="tab" aria-expanded="true">'.$bk_tab_title.'</a></li>';
		}
        $ret .= '</ul>';
        
		$ret .= '<div class="tab-content">';
        $i=0;
        $ret .= '<div role="tabpanel" class="tab-pane active" id="tab-'.$i.'">' . do_shortcode(trim($matches[5][$i])) . '</div>';
        for($i = 1; $i < count($matches[0]); $i++) {
            $ret .= '<div role="tabpanel" class="tab-pane" id="tab-'.$i.'">' . do_shortcode(trim($matches[5][$i])) . '</div>';
		}
		$ret .= '</div>';
		$ret .= '</div>';
 
	}		
	return $ret;
}
add_shortcode('tabs', 'register_tabs_shortcode');

/**
 * Gallery
 */
function register_tnm_gallery_1_shortcode($atts, $content = null) {
    $atts = shortcode_atts (
        array (
            'layout'       => 'mnmd-post-media',
        ), $atts );
        
    $galleryID = uniqid('gallery-');
    $ret = '';
    $galleryIDs = do_shortcode($content);
    $galleryArray = explode(',',$galleryIDs);
    
    $ret .= '<div class="mnmd-shortcode-wrap mnmd-gallery-wrap">';
    $ret .= '<div class="fotorama mnmd-gallery-slider '.$atts['layout'].' itemscope itemtype="http://schema.org/ImageGallery" data-width="100%" data-allowfullscreen="true" data-click="false" data-nav="false">';
    foreach ($galleryArray as $imageID) {
        $attachment = wp_get_attachment_image_src($imageID, 'tnm-l-16_9');
        $caption = wp_get_attachment_caption($imageID);
        $ret .= '<a href="'.$attachment[0].'" itemprop="contentUrl" data-size="1200x675" data-caption="'.$caption.'"></a>';
    }
	$ret .= '</div>';
    $ret .= '</div>';
    return $ret;    
}
add_shortcode('tnm_gallery_1', 'register_tnm_gallery_1_shortcode');

function register_tnm_gallery_2_shortcode($atts, $content = null) {
    $atts = shortcode_atts (
        array (
            'layout'       => 'mnmd-post-media',
        ), $atts );
        
    $galleryID = uniqid('gallery-');
    $ret = '';
    $galleryIDs = do_shortcode($content);
    $galleryArray = explode(',',$galleryIDs);
    
    $ret .= '<div class="mnmd-shortcode-wrap mnmd-gallery-wrap">';
    $ret .= '<div class="fotorama mnmd-gallery-slider '.$atts['layout'].'" itemscope itemtype="http://schema.org/ImageGallery" data-width="100%" data-allowfullscreen="true" data-click="false">';
    foreach ($galleryArray as $imageID) {
        $attachment = wp_get_attachment_image_src($imageID, 'tnm-l-16_9');
        $caption = wp_get_attachment_caption($imageID);
        $ret .= '<a href="'.$attachment[0].'" itemprop="contentUrl" data-size="1200x675" data-caption="'.$caption.'"></a>';
    }
	$ret .= '</div>';
    $ret .= '</div>';
    return $ret;    
}
add_shortcode('tnm_gallery_2', 'register_tnm_gallery_2_shortcode');

function register_tnm_gallery_3_shortcode($atts, $content = null) {
    $atts = shortcode_atts (
        array (
            'layout'       => 'mnmd-post-media',
        ), $atts );
        
    $galleryID = uniqid('gallery-');
    $ret = '';
    $galleryIDs = do_shortcode($content);
    $galleryArray = explode(',',$galleryIDs);
    
    $ret .= '<div class="mnmd-shortcode-wrap mnmd-gallery-wrap">';
    $ret .= '<div class="fotorama mnmd-gallery-slider '.$atts['layout'].'" itemscope itemtype="http://schema.org/ImageGallery" data-width="100%" data-nav="thumbs" data-allowfullscreen="true" data-click="false">';
    foreach ($galleryArray as $imageID) {
        $attachment = wp_get_attachment_image_src($imageID, 'tnm-l-16_9');
        $attachmentThumb = wp_get_attachment_image_src($imageID, 'tnm-xxs-4_3');
        $caption = wp_get_attachment_caption($imageID);
        $ret .= '<a href="'.$attachment[0].'" itemprop="contentUrl" data-size="1200x675" data-caption="'.$caption.'">';
        $ret .= '<img src="'.$attachmentThumb[0].'" itemprop="thumbnail" alt="Image alt" width="180" height="135" />';
        $ret .= '</a>';
    }
	$ret .= '</div>';
    $ret .= '</div>';
    return $ret;    
}
add_shortcode('tnm_gallery_3', 'register_tnm_gallery_3_shortcode');

function register_tnm_gallery_4_shortcode($atts, $content = null) {
    $atts = shortcode_atts (
        array (
            'layout'       => 'mnmd-post-media',
            'columns'      => 'gallery-columns-4',
        ), $atts );
        
    $galleryID = uniqid('gallery-');
    $ret = '';
    $galleryIDs = do_shortcode($content);
    $galleryArray = explode(',',$galleryIDs);
    
    $ret .= '<div class="mnmd-shortcode-wrap '.$atts['layout'].'">';
    $ret .= '<div id="'.$galleryID.'" class="gallery '.$galleryID.' '.$atts['columns'].' gallery-size-thumbnail js-mnmd-lightbox-gallery">';
    foreach ($galleryArray as $imageID) {
        $image = get_post(intval($imageID));
        $imageCaption = $image->post_excerpt;
        $imageURL = $image->guid;
        $thumbnail = wp_get_attachment_image($imageID,'tnm-xs-16_9');
        $ret .= '<figure class="gallery-item '.$imageID.'">';
    	$ret .= '<div class="gallery-icon landscape">';
    	$ret .= '<a href="'.$imageURL.'" title="Image caption">'.$thumbnail.'</a>';
    	$ret .= '</div>';
    	$ret .= '<figcaption class="wp-caption-text gallery-caption">';
    	$ret .= $imageCaption;
    	$ret .= '</figcaption>';
    	$ret .= '</figure>';
    }
	$ret .= '</div>';
    $ret .= '</div>';
    return $ret;    
}
add_shortcode('tnm_gallery_4', 'register_tnm_gallery_4_shortcode');

/**
 * Accordion ShortCode
 */
function register_accordions_shortcode($atts, $content = null) {
    $accordion_id = uniqid('accordion-');
	$ret = '';
    if (!preg_match_all("/(.?)\[(accordion)\b(.*?)(?:(\/))?\](?:(.+?)\[\/accordion\])?(.?)/s", $content, $matches)) {
		// if content has no accordion
		return do_shortcode($content);
	} else {
		// content has accordions, get title and content
		for($i = 0; $i < count($matches[0]); $i++) {
			$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
		}
		
        $ret .= '<div class="mnmd-shortcode-wrap panel-group" id="'.$accordion_id.'" role="tablist" aria-multiselectable="true">';

        for($i = 0; $i < count($matches[0]); $i++) {
            $bkPanelTitle = implode(' ',$matches[3][$i]);
			$ret .= '<div class="panel panel-default">';
    		$ret .= '<div class="panel-heading" role="tab" id="accordion-heading-'.$i.$accordion_id.'">';
    		$ret .= '<h4 class="panel-title">';
    		$ret .= '<a role="button" data-toggle="collapse" data-parent="#'.$accordion_id.'" href="#collapse-'.$i.$accordion_id.'" aria-expanded="false" aria-controls="collapse-'.$i.$accordion_id.'" class="collapsed">';
    		$ret .= $bkPanelTitle;
    		$ret .= '</a>';
    		$ret .= '</h4>';
    		$ret .= '</div>';
    		$ret .= '<div id="collapse-'.$i.$accordion_id.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="accordion-heading-'.$i.$accordion_id.'" aria-expanded="false" style="height: 0px;">';
    		$ret .= '<div class="panel-body">';
    		$ret .= do_shortcode(trim($matches[5][$i]));
    		$ret .= '</div>';
    		$ret .= '</div>';
    		$ret .= '</div><!--end panel-->';
		}
        
    	$ret .= '</div><!-- End Panel Group -->';
	}		
	return $ret;
}
add_shortcode('accordions', 'register_accordions_shortcode');

/**
 * Author box ShortCode
 */
function register_authorbox_shortcode($atts, $content = null) {
    $uid = uniqid();
    $ret = '';

    $authorID = do_shortcode($content);
    
    $ret .= '<div class="mnmd-shortcode-wrap author-box-sc">';
    $ret .= tnm_single::bk_author_box($authorID);
    $ret .= '</div>';
    
    return $ret;
}
add_shortcode('authorbox', 'register_authorbox_shortcode');


/**
 * Video ShortCode
 */
function register_tnm_video_shortcode($atts, $content = null) {
    $ret = '';
    $atts = shortcode_atts (
        array (
            'layout'       => 'mnmd-post-media',
        ), $atts );
                
    if (class_exists('tnm_core')) {
        $ret .= '<div class="mnmd-shortcode-wrap '.$atts['layout'].'">';
        $ret .= tnm_core::bk_get_video_media(do_shortcode($content));
        $ret .= '</div>'; 
    }else {
        $ret = '';
    }
    
    return $ret;
}
add_shortcode('tnm_video', 'register_tnm_video_shortcode');
/**
 * Dropcap ShortCode
 */
function register_dropcap_shortcode($atts, $content) {
    $ret = '';
    $atts = shortcode_atts (
        array (
            'style'       => 'dropcap_style1',
            'background'  => '#fff',
            'textcolor'   => '#222',
            'fontweight' => '',
        ), $atts );
    if ($atts['style'] !== '') {
        $dropcapStyle = $atts['style'];
    }else {
        $dropcapStyle = 'dropcap_style1';
    }
    
    if ($atts['background'] !== '') {
        $dropcapBG = $atts['background'];
    }else {
        $dropcapBG = '#fff';
    }
    
    if ($atts['textcolor'] !== '') {
        $textcolor = $atts['textcolor'];
    }else {
        $textcolor = '#222';
    }
    
    if ($atts['fontweight'] !== '') {
        $fontweight = $atts['fontweight'];
    }else {
        $fontweight = '';
    }
    
    $ret = '<span class="dropcap '.$dropcapStyle.'" style="color: '.$textcolor.'; background-color: '.$dropcapBG.'; font-weight: '.$fontweight.';">';
    $ret .= do_shortcode($content);
    $ret .= '</span>'; 
    return $ret; 
}
add_shortcode('dropcap', 'register_dropcap_shortcode');