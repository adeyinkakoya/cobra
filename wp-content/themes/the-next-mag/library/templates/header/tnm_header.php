<?php
if (!class_exists('tnm_header')) {
    class tnm_header {
        static function tnm_get_header() { 
            $tnm_option = tnm_core::bk_get_global_var('tnm_option');
            $bkHeaderType = '';
            if ((isset($tnm_option['bk-header-type'])) && (($tnm_option['bk-header-type']) != NULL)){ 
                $bkHeaderType = $tnm_option['bk-header-type'];
            }else {
                $bkHeaderType = 'site-header-1';
            }
            if ($bkHeaderType == 'site-header-1') {
                get_template_part( 'library/templates/header/partials/header', '1' );
            }
            elseif ($bkHeaderType == 'site-header-2') {
                get_template_part( 'library/templates/header/partials/header', '2' );
            }
            elseif ($bkHeaderType == 'site-header-3') {
                get_template_part( 'library/templates/header/partials/header', '3' );
            }
            elseif ($bkHeaderType == 'site-header-4') {
                get_template_part( 'library/templates/header/partials/header', '4' );
            }
            elseif ($bkHeaderType == 'site-header-5') {
                get_template_part( 'library/templates/header/partials/header', '5' );
            }
            elseif ($bkHeaderType == 'site-header-6') {
                get_template_part( 'library/templates/header/partials/header', '6' );
            }
            elseif ($bkHeaderType == 'site-header-7') {
                get_template_part( 'library/templates/header/partials/header', '7' );
            }
            elseif ($bkHeaderType == 'site-header-8') {
                get_template_part( 'library/templates/header/partials/header', '8' );
            }
            elseif ($bkHeaderType == 'site-header-9') {
                get_template_part( 'library/templates/header/partials/header', '9' );
            }
        } 
        static function tnm_get_header_class() { 
            $tnm_option = tnm_core::bk_get_global_var('tnm_option');
            $headerClass = '';
            $bkHeaderType = '';
            if ((isset($tnm_option['bk-header-type'])) && (($tnm_option['bk-header-type']) != NULL)){ 
                $bkHeaderType = $tnm_option['bk-header-type'];
            }else {
                $bkHeaderType == 'site-header-1';
            }
            if ($bkHeaderType == 'site-header-1') {
                $headerClass = 'header-1';
            }
            elseif ($bkHeaderType == 'site-header-2') {
                $headerClass = 'header-2';
            }
            elseif ($bkHeaderType == 'site-header-3') {
                $headerClass = 'header-3';
            }
            elseif ($bkHeaderType == 'site-header-4') {
                $headerClass = 'header-4';
            }
            elseif ($bkHeaderType == 'site-header-5') {
                $headerClass = 'header-5';
            }
            elseif ($bkHeaderType == 'site-header-6') {
                $headerClass = 'header-6';
            }
            elseif ($bkHeaderType == 'site-header-7') {
                $headerClass = 'header-7';
            }
            elseif ($bkHeaderType == 'site-header-8') {
                $headerClass = 'header-8';
            }
            elseif ($bkHeaderType == 'site-header-9') {
                $headerClass = 'header-9';
            }
            return $headerClass;
        }
        static function bk_get_megamenu_large_post($postID){
            $bk_menuPostItem = '';
            
            $bkThumbId = get_post_thumbnail_id( $postID );
            $bkThumbUrl = wp_get_attachment_image_src( $bkThumbId, 'tnm-xs-4_3' );
            
            $bk_permalink = get_permalink($postID);
            $bk_post_title = get_the_title($postID);
            $date = get_the_date( '', $postID );
            $tnm_article_date_unix = get_the_time('U', $postID);
            
            $reviewScore = get_post_meta($postID, 'bk_review_score', true);
                
            $reviewScoreOutput = '';
            if(($reviewScore != '') && ($reviewScore > 0)) {
                $reviewScoreOutput .= '<div class="overlay-center-y text-center">';
		        $reviewScoreOutput .= '<div class="post-score-hexagon">';
    			$reviewScoreOutput .= '<svg class="hexagon-svg" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="-5 -5 184 210">';
    			$reviewScoreOutput .= '<g>';
    			$reviewScoreOutput .= '<path fill="#FC3C2D" stroke="#fff" stroke-width="10px" d="M81.40638795573723 2.9999999999999996Q86.60254037844386 0 91.7986928011505 2.9999999999999996L168.0089283341811 47Q173.20508075688772 50 173.20508075688772 56L173.20508075688772 144Q173.20508075688772 150 168.0089283341811 153L91.7986928011505 197Q86.60254037844386 200 81.40638795573723 197L5.196152422706632 153Q0 150 0 144L0 56Q0 50 5.196152422706632 47Z"></path>';
    			$reviewScoreOutput .= '</g>';
    			$reviewScoreOutput .= '</svg>';
    			$reviewScoreOutput .= '<span class="post-score-value">'.$reviewScore.'</span>';
    			$reviewScoreOutput .= '</div>';
    			$reviewScoreOutput .= '</div>';
            }
            $timestamp_lastweek  = strtotime("-1 week");
            $timestamp_post      = get_the_time('U', $postID);
            if($timestamp_post <= $timestamp_lastweek) {
                $bk_meta_str = '<time class="time published" datetime="'.date(DATE_W3C, $tnm_article_date_unix).'" title="'.get_the_time('F j, Y \a\t g:i a', $postID) .'"><i class="mdicon mdicon-schedule"></i>'.get_the_date('', $postID).'</time>';
            }else {
                $bk_meta_str = '<time class="time published" datetime="'.date(DATE_W3C, $tnm_article_date_unix).'" title="'.get_the_time('F j, Y \a\t g:i a', $postID) .'"><i class="mdicon mdicon-schedule"></i>'.human_time_diff( get_the_time('U'), current_time('timestamp') ) . esc_html__(' ago', 'the-next-mag') .'</time>';
            }
            $bk_menuPostItem .= '<li class="big-post">
                            <article class="post post--overlay post--overlay-bottom post--overlay-floorfade post--overlay-xs">
                                <div class="background-img" style="background-image: url('. "'" . $bkThumbUrl[0]. "'" .');"></div>
                                        
                                <div class="post__text inverse-text">
                                    <div class="post__text-wrap">
                                        <div class="post__text-inner">
                                            <h3 class="post__title typescale-2"><a href="'.$bk_permalink.'">'.$bk_post_title.'</a></h3>  
                                            <div class="post__meta">
                                                <span class="entry-author">'.esc_html__('By', 'the-next-mag').' <a href="'. get_author_posts_url(get_the_author_meta( 'ID' )).'">'. get_the_author() .'</a></span>
            									'.$bk_meta_str.'
            								</div>
                                        </div>
                                    </div>
                                </div>   
                                <a href="'.$bk_permalink.'" class="link-overlay"></a>
                            </article>       
                        </li>'; 
            return $bk_menuPostItem;
        }   
        static function bk_get_megamenu_normal_post($postID){
            $bk_menuPostItem = '';
            if(tnm_core::bk_check_has_post_thumbnail( $postID )) {
                $bk_img = get_the_post_thumbnail($postID, 'tnm-xs-2_1');
            }else {
                $bk_img = '';
            }

            $bk_permalink = get_permalink($postID);
            $bk_post_title = get_the_title($postID);
            $date = get_the_date( '', $postID );
            $tnm_article_date_unix = get_the_time('U', $postID);
            $reviewScore = get_post_meta($postID, 'bk_review_score', true);
                
            $reviewScoreOutput = '';
            if(($reviewScore != '') && ($reviewScore > 0)) {
                $reviewScoreOutput .= '<div class="overlay-center-y text-center">';
		        $reviewScoreOutput .= '<div class="post-score-hexagon">';
    			$reviewScoreOutput .= '<svg class="hexagon-svg" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="-5 -5 184 210">';
    			$reviewScoreOutput .= '<g>';
    			$reviewScoreOutput .= '<path fill="#FC3C2D" stroke="#fff" stroke-width="10px" d="M81.40638795573723 2.9999999999999996Q86.60254037844386 0 91.7986928011505 2.9999999999999996L168.0089283341811 47Q173.20508075688772 50 173.20508075688772 56L173.20508075688772 144Q173.20508075688772 150 168.0089283341811 153L91.7986928011505 197Q86.60254037844386 200 81.40638795573723 197L5.196152422706632 153Q0 150 0 144L0 56Q0 50 5.196152422706632 47Z"></path>';
    			$reviewScoreOutput .= '</g>';
    			$reviewScoreOutput .= '</svg>';
    			$reviewScoreOutput .= '<span class="post-score-value">'.$reviewScore.'</span>';
    			$reviewScoreOutput .= '</div>';
    			$reviewScoreOutput .= '</div>';
            }
            $timestamp_lastweek  = strtotime("-1 week");
            $timestamp_post      = get_the_time('U', $postID);
            if($timestamp_post <= $timestamp_lastweek) {
                $bk_meta_str = '<time class="time published" datetime="'.date(DATE_W3C, $tnm_article_date_unix).'" title="'.get_the_time('F j, Y \a\t g:i a', $postID) .'"><i class="mdicon mdicon-schedule"></i>'.get_the_date('', $postID).'</time>';
            }else {
                $bk_meta_str = '<time class="time published" datetime="'.date(DATE_W3C, $tnm_article_date_unix).'" title="'.get_the_time('F j, Y \a\t g:i a', $postID) .'"><i class="mdicon mdicon-schedule"></i>'.human_time_diff( get_the_time('U'), current_time('timestamp') ) . esc_html__(' ago', 'the-next-mag') .'</time>';
            }
            $bk_menuPostItem .= '<li>
                            <article class="post post--vertical">
                                <div class="post__thumb">
                                    <a href="'.$bk_permalink.'" class="thumb-link">'. $bk_img.'
                                        '.$reviewScoreOutput.'
                                    </a>
                                </div>
                                        
                                <div class="post__text">
                                    <h3 class="post__title typescale-0"><a href="'.$bk_permalink.'">'.$bk_post_title.'</a></h3>  
                                    <div class="post__meta">
   									'.$bk_meta_str.'
    								</div>
                                </div>   
                            </article>       
                        </li>'; 
            return $bk_menuPostItem;
        }
        static function bk_get_megamenu_posts($the_query){
            $bk_posts = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postID = get_the_ID();
                
                $bk_posts .= self::bk_get_megamenu_normal_post($postID);
                
            endwhile;
            
            return $bk_posts;
        }
        
        static function bk_get_megamenu_1stlarge_posts($the_query){
            $bk_posts = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postID = get_the_ID();
                
                if($the_query->current_post == 0) {
                    $bk_posts .= self::bk_get_megamenu_large_post($postID);
                }else {
                    $bk_posts .= self::bk_get_megamenu_normal_post($postID);
                }
                
            endwhile;
            
            return $bk_posts;
        }
    } // Close tnm_core class
}
