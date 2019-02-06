<?php
if (!class_exists('tnm_widget')) {
    class tnm_widget {
        static function bk_widget_query($widget_opts){
            $widget_opts = shortcode_atts (
    		         array(
    			         'category_ids'   => '',
    			         'category_id'    => '',
    			         'author_id'      => '',
    			         'tags'           => '',
    			         'entries'        => '',
    			         'offset'         => '',
    			         'orderby'        => '',
    			         'post_types'     => '',
    			         'meta_key'       => '',
    			         'post__not_in'    => '',
                         'widget_type'    => '',
    		         ), $widget_opts
    	         );
            //get Query Args
			$query_args  = array(
                'post_status'           => 'publish',
                'ignore_sticky_posts'   => 1,
                'post_type'             => 'post',
                'orderby'               => 'date',
                'posts_per_page'        => $widget_opts['entries'],
            );
            
            $widget_type = $widget_opts['widget_type'];
            if($widget_type == 'review') {
                $query_args['meta_query'] = array(
    				array(
    					'key' => 'bk_review_checkbox',
    					'value' => '1',
    				)
                 );
            }else if($widget_type == 'comment') {
                
            }
            
			if ($widget_opts['post__not_in'] != '') {
				$query_args['post__not_in'] = array_map('intval', explode(',',$widget_opts['post__not_in']));
			}

			//post per page
			if ( $widget_opts['entries'] != '' ) {
                $query_args['posts_per_page'] = $widget_opts['entries'];
			} else {
				$query_args['posts_per_page'] = 4;
			}

			//categories query
			if ( $widget_opts['category_ids'] != '') {
				$query_args['category__in'] = array_map('intval', explode(',',$widget_opts['category_ids']));
			} else {
				if ( ! empty( $widget_opts['category_id'] ) ) {
					$query_args['cat'] = $widget_opts['category_id'];
				}
			}

			//tag in query
			if ( $widget_opts['tags'] != '' ) {
				//$query_args['tag__in'] = $widget_opts['tags'];
                $query_args['tag__in'] = array_map('intval', explode(',',$widget_opts['tags']));
			}

			//offset query
			if ( $widget_opts['offset'] ) {
				$query_args['offset'] = intval( $widget_opts['offset'] );
			}

			switch ( $widget_opts['orderby'] ) {

				//Date post
				case 'date' :
					$query_args['orderby'] = 'date';
					break;

				//Popular comment
				case 'comment_count' :
					$query_args['orderby'] = 'comment_count';
					break;
                
                //Popular Views
				case 'view_count' :
                    $query_args['meta_key'] = 'post_views_count';
					$query_args['orderby']  = 'meta_value_num';
					$query_args['order']    = 'DESC';
					break;

				//Modified
				case 'modified' :
					$query_args['orderby'] = 'modified';
					break;
                    
                // Review
				case 'top_review' :
					$query_args['meta_key'] = 'bk_review_score';
					$query_args['orderby']  = 'meta_value_num';
					$query_args['order']    = 'DESC';
					break;
                //Speed Reads
                case 'speed_reads' :
                    $query_args['meta_key'] = 'bk_post_content__word_count';
					$query_args['orderby']  = 'meta_value_num';
					$query_args['order']    = 'DESC';
                    break;
				//Random
				case 'rand':
					$query_args['orderby'] = 'rand';
					break;

				//Alphabet decs
				case 'alphabetical_decs':
					$query_args['orderby'] = 'title';
					$query_args['order']   = 'DECS';
					break;

				//Alphabet asc
				case 'alphabetical_asc':
					$query_args['orderby'] = 'title';
					$query_args['order']   = 'ASC';
					break;
                
                // Default
                default:
                    $query_args['orderby'] = 'date';
					break;
			}
            $the_query = new WP_Query( $query_args );
            return $the_query;
        }
        static function bk_get_widget_heading($bk_heading, $headingClass = ''){
            $block_heading = '';
            if($bk_heading != null) {
                $heading_allow_html = array(
                    'span' => array(),
                );
                $block_heading .= '<div class="widget__title block-heading '.$headingClass.'">';
    			$block_heading .= '<h4 class="widget__title-text">'.wp_kses($bk_heading, $heading_allow_html).'</h4>';
    			$block_heading .= '</div>';
            }
            return $block_heading;
        }
        static function bk_get_widget_module_class($widgetModule = ''){
            $widgetClass = '';
            switch ( $widgetModule ) {
				case 'indexed-posts-a' :
					$widgetClass = 'mnmd-widget-indexed-posts-a';
					break;
                
                case 'indexed-posts-b':
                    $widgetClass = 'mnmd-widget-indexed-posts-b';
                    break;
                
                case 'indexed-posts-c':
                    $widgetClass = 'mnmd-widget-indexed-posts-c';
                    break;
                
                case 'posts-listing-a':
                    $widgetClass = '';
                    break;
                
                case 'posts-listing-b':
                    $widgetClass = 'mnmd-widget-posts-list';
                    break;
                    
                case 'posts-listing-c':
                    $widgetClass = '';
                    break;
                    
                case 'posts-listing-d':
                    $widgetClass = 'mnmd-widget-posts-list';
                    break;
                
                case 'posts-listing-e':
                    $widgetClass = 'mnmd-widget-posts-list';
                    break;
                    
                default:
                    $widgetClass = 'mnmd-widget-indexed-posts-a';
                    break;
            }
            
            return $widgetClass;
        }
        static function bk_widget_meta($orderby){
            $widgetMeta = array();
            switch($orderby) {
                case 'view_count':
                    $widgetMeta = array('date', 'view');
                    break;
                case 'comment_count':
                    $widgetMeta = array('date', 'comment');
                    break;
                default:
                    $widgetMeta = array('date');
                    break;
            }
            return $widgetMeta;
        }
        static function bk_listing_posts_a_render($the_query, $widgetMeta){
            $render_widget = '';
            $postHorizontalHTML = new tnm_horizontal_1;
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-xxs',
                'thumbSize'         => 'tnm-xxs-1_1',
                'meta'              => $widgetMeta,
                'typescale'         => 'typescale-0',
            );
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postHorizontalAttr['postID'] = get_the_ID();
                $render_widget .= '<li>';
                $render_widget .= $postHorizontalHTML->render($postHorizontalAttr);
                $render_widget .= '</li>';
            endwhile;
            
            return $render_widget;
        }
        static function bk_listing_posts_b_render($the_query, $widgetMeta){
            $render_widget = '';
            $postVerticalHTML = new tnm_vertical_1;
                                        
            $postVerticalAttr = array (
                'cat'           => 3,
                'catClass'      => 'post__cat cat-theme',
                'thumbSize'     => 'tnm-xs-16_9 400x225',
                'typescale'     => 'typescale-1',
                'meta'          => $widgetMeta,
            );

            while ( $the_query->have_posts() ): $the_query->the_post();
                $postVerticalAttr['postID'] = get_the_ID();
                $render_widget .= '<li>';
                $render_widget .= $postVerticalHTML->render($postVerticalAttr);
                $render_widget .= '</li>';
            endwhile;
            
            return $render_widget;
        }
        static function bk_indexed_posts_c_render($the_query, $widgetMeta){
            $render_widget = '';
            $render_widget .= '<ol class="posts-list list-space-md list-seperated-exclude-first list-unstyled">';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postID = get_the_ID();
                $postIndex = $the_query->current_post + 1;
                if($the_query->current_post == 0) :
                    $thumbAttr = array (
                        'postID'        => $postID,
                        'thumbSize'     => 'tnm-xs-16_9 400x225',                                
                    );
                    $theBGLink = tnm_core::bk_get_post_thumbnail_bg_link($thumbAttr);
                    $theBGLinkInline = "background-image: url('".$theBGLink."')";
                    
                    $postIndexSideAttr = array (
                        'cat'               => 1,
                        'catClass'          => 'post__cat post__cat--bg cat-theme-bg',
                        'postID'            => $postID,
                        'mediaLeft'         => '<span class="list-index">'.$postIndex.'</span>',
                        'typescale'         => 'typescale-2',
                        'meta'              => $widgetMeta,
                    );
                          
                    $render_widget .= '<li>';
                    $render_widget .= '<article class="post post--overlay post--overlay-bottom">';
                    $render_widget .= '<div class="background-img background-img--darkened" style="'.$theBGLinkInline.'"></div>';
                    $render_widget .= '<div class="post__text inverse-text">';
					$render_widget .= '<div class="post__text-inner">';
                    $render_widget .= self::bk_indexed_side_content($postIndexSideAttr);
                    $render_widget .= '</div>';
                    $render_widget .= '</div>';
                    $render_widget .= '</article>';
                    $render_widget .= '</li>';
                else:
                    $postIndexSideAttr = array (
                        'cat'               => 1,
                        'catClass'          => 'post__cat post__cat--bg cat-theme-bg',
                        'postID'            => $postID,
                        'mediaLeft'         => '<span class="list-index">'.$postIndex.'</span>',
                        'typescale'         => 'typescale-0',
                        'meta'              => $widgetMeta,
                    );
                    $render_widget .= '<li>';
                    $render_widget .= '<article class="post">';
                    $render_widget .= self::bk_indexed_side_content($postIndexSideAttr);
                    $render_widget .= '</article>';
                    $render_widget .= '</li>';
                endif;
            endwhile;
            $render_widget .= '</ol>';
            
            return $render_widget;
        }
        static function bk_listing_posts_c_render($the_query, $widgetMeta){
            $render_widget = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postID = get_the_ID();
                
                $postOverlayHTML = new tnm_overlay_1;
                $postHorizontalHTML = new tnm_horizontal_1;
                                        
                $postOverlayAttr = array (
                    'thumbSize'         => 'tnm-xs-4_3',
                    'typescale'         => 'typescale-1',
                    'cat'               => 4,
                    'catClass'          => 'post__cat post__cat--bg cat-theme-bg',
                    'meta'              => $widgetMeta,
                    'additionalClass'   => 'post--overlay-bottom post--overlay-floorfade post--overlay-xs',
                );
                
                $postHorizontalAttr = array (
                    'additionalClass'   => 'post--horizontal-xxs',
                    'thumbSize'         => 'tnm-xxs-1_1',
                    'meta'              => array('date'),
                    'typescale'         => 'typescale-0',
                );

                if($the_query->current_post == 0) :
                    $postOverlayAttr['postID'] = get_the_ID();
                    $render_widget .= '<li>';
                    $render_widget .= $postOverlayHTML->render($postOverlayAttr);
                    $render_widget .= '</li>';
                else:
                    $postHorizontalAttr['postID'] = get_the_ID();
                    $render_widget .= '<li>';
                    $render_widget .= $postHorizontalHTML->render($postHorizontalAttr);
                    $render_widget .= '</li>';
                endif;
            endwhile;
            
            return $render_widget;
        }
        static function bk_listing_posts_d_render($the_query, $widgetMeta){
            $render_widget = '';
            $postHorizontalHTML = new tnm_horizontal_1;
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal-reverse post--horizontal-xxs',
                'thumbSize'         => 'tnm-xxs-1_1',
                'meta'              => $widgetMeta,
                'typescale'         => 'typescale-0',
            );
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postHorizontalAttr['postID'] = get_the_ID();
                $render_widget .= '<li>';
                $render_widget .= $postHorizontalHTML->render($postHorizontalAttr);
                $render_widget .= '</li>';
            endwhile;
            
            return $render_widget;
        }
        static function bk_listing_posts_e_render($the_query, $widgetMeta){
            $render_widget = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postID = get_the_ID();
                
                $postOverlayHTML = new tnm_overlay_1;
                                        
                $postOverlayAttr = array (
                    'thumbSize'         => 'tnm-xs-16_9 400x225',
                    'typescale'         => 'typescale-1',
                    'cat'               => 4,
                    'meta'              => $widgetMeta,
                    'catClass'          => 'post__cat post__cat--bg cat-theme-bg',
                    'additionalClass'   => 'post--overlay-bottom post--overlay-floorfade',
                    'additionalIMGClass' => 'background-img--darkened',
                );

                $postOverlayAttr['postID'] = get_the_ID();
                $render_widget .= '<li>';
                $render_widget .= $postOverlayHTML->render($postOverlayAttr);
                $render_widget .= '</li>';
                
            endwhile;
            
            return $render_widget;
        }
        static function bk_most_commented($the_query){
            $render_widget = '';
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postID = get_the_ID();
                $postIndex = $the_query->current_post + 1;
                
                $postIndexSideAttr = array (
                    'cat'               => 1,
                    'catClass'          => 'post__cat post__cat--bg cat-theme-bg',
                    'postID'            => $postID,
                    'mediaLeft'         => '<a href="'.get_permalink($postID).'" title="'.tnm_core::bk_get_comment_number_and_text($postID).'" class="comments-count-box">'.get_comments_number($postID).'</a>',
                    'typescale'         => 'typescale-0',
                    'meta'              => array('comment_text'),
                );
                $render_widget .= '<li>';
                $render_widget .= '<article class="post">';
                $render_widget .= self::bk_indexed_side_content($postIndexSideAttr);
                $render_widget .= '</article>';
                $render_widget .= '</li>';
            endwhile;
            
            return $render_widget;
        }
        
        //Review A
        static function bk_review_posts_a($the_query){
            $render_widget = '';
            $postHorizontalHTML = new tnm_horizontal_1;
            $postHorizontalAttr = array (
                'additionalClass'   => 'post--horizontal post--horizontal-xxs',
                'thumbSize'         => 'tnm-xxs-1_1',
                'typescale'         => 'typescale-0',
            );
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postHorizontalAttr['postID'] = get_the_ID();
                $reviewScore = get_post_meta($postHorizontalAttr['postID'] ,'bk_review_score',true);
                $postHorizontalAttr['scoreStar'] = $reviewScore;
                
                $render_widget .= '<li>';
                $render_widget .= $postHorizontalHTML->render($postHorizontalAttr);
                $render_widget .= '</li>';
            endwhile;
            
            return $render_widget;
        }
        //Review B
        static function bk_review_posts_b($the_query){
            $render_widget = '';
            $postVerticalHTML = new tnm_vertical_icon_side_right_ratio_2by1;
            $postIconAttr = array (
                'iconType'      => 'review',
                'postIconClass' => 'post-type-icon--sm',
            );
            $postVerticalAttr = array (
                'thumbSize'         => 'tnm-xs-16_9 400x225',
                'typescale'         => 'typescale-0',
                'postIcon'          => $postIconAttr,
            );
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postVerticalAttr['postID'] = get_the_ID();
                $reviewScore = get_post_meta($postVerticalAttr['postID'] ,'bk_review_score',true);
                
                $render_widget .= '<li>';
                $render_widget .= $postVerticalHTML->render($postVerticalAttr);
                $render_widget .= '</li>';
            endwhile;
            
            return $render_widget;
        }
        //Review C
        static function bk_review_posts_c($the_query){
            $render_widget = '';
            $postVerticalHTML = new tnm_vertical_1_ratio_2by1;
            $postIconAttr = array (
                'iconType'      => 'review',
                'postIconClass' => 'post-type-icon--sm overlay-item--center-xy post-type-icon',
            );
            $postVerticalAttr = array (
                'thumbSize'         => 'tnm-xs-16_9 400x225',
                'typescale'         => 'typescale-0',
                'postIcon'          => $postIconAttr,
                'additionalClass'   => 'text-center',        
            );
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postVerticalAttr['postID'] = get_the_ID();
                $reviewScore = get_post_meta($postVerticalAttr['postID'] ,'bk_review_score',true);
                
                $render_widget .= '<li>';
                $render_widget .= $postVerticalHTML->render($postVerticalAttr);
                $render_widget .= '</li>';
            endwhile;
            
            return $render_widget;
        }
        //Review D
        static function bk_review_posts_d($the_query){
            $render_widget = '';
            $postOverlayHTML = new tnm_overlay_icon_side_right;
            $postIconAttr = array (
                'iconType'      => 'review',
                'postIconClass' => 'post-type-icon--sm',
            );
                                        
            $postOverlayAttr = array (
                'thumbSize'         => 'tnm-xs-16_9 400x225',
                'typescale'         => 'typescale-1',
                'postIcon'          => $postIconAttr,
                'additionalClass'   => 'post--overlay-bottom post--overlay-floorfade',
            );
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postOverlayAttr['postID'] = get_the_ID();
                
                $render_widget .= '<li>';
                $render_widget .= $postOverlayHTML->render($postOverlayAttr);
                $render_widget .= '</li>';
            endwhile;
            
            return $render_widget;
        }
        static function bk_indexed_side_content($postIndexSideAttr){
            $renderPostContent = '';
            $renderPostContent .= '<div class="media">';
            
            $renderPostContent .= '<div class="media-left media-middle">';
            $renderPostContent .= $postIndexSideAttr['mediaLeft'];
            $renderPostContent .= '</div>';
            
            $renderPostContent .= '<div class="media-body media-middle">';
            $renderPostContent .= '<h3 class="post__title '.$postIndexSideAttr['typescale'].'">'. tnm_core::bk_get_post_title_link($postIndexSideAttr['postID']) .'</h3>';
            if (isset($postIndexSideAttr['meta']) && ($postIndexSideAttr['meta'] != '')) :
                $renderPostContent .= '<div class="post__meta">';
                if(isset($postIndexSideAttr['cat']) && ($postIndexSideAttr['cat'] == '1')) :
                    $renderPostContent .= tnm_core::bk_get_post_cat_link($postIndexSideAttr['postID'], $postIndexSideAttr['catClass']);
                endif;
                $renderPostContent .= tnm_core::bk_get_post_meta($postIndexSideAttr['meta']);
                $renderPostContent .= '</div>';         
            endif;
            
            $renderPostContent .= '</div><!--End media-body-->';
            $renderPostContent .= '</div><!--End media-->';
            
            return $renderPostContent;
        }
        static function bk_update_social_json($socialItems){
            $hours = 2;
            foreach ($socialItems as $socialType => $socialVal) :
                $transient__name = 'tnm_social_json_transient_' . $socialType;
                $cache           = get_transient( $transient__name );
                if ( $cache === false || $cache == '' ) {
                    if($socialType == 'facebook') {
                        $followers = self::bk_read_count_social(esc_url($socialVal['url']), 'facebook');
            			if ( ! empty( $followers ) ) {
            				update_option('bk_facebook_followers', $followers);
        					update_option('bk_facebook_link', esc_url($socialVal['url']));                     
            			}
                        set_transient( $transient__name, $followers, 60 * 60 * $hours );
                    }else if($socialType == 'twitter') {
            			$followers = self::bk_read_count_social($socialVal['url'], 'twitter');
            			if ( ! empty( $followers ) ) {
            				update_option('bk_twitter_followers', $followers);
                            update_option('bk_twitter_link', esc_url($socialVal['url']));            
            			}
                        set_transient( $transient__name, $followers, 60 * 60 * $hours );
            		}else if($socialType == 'youtube') {
                        $followers = self::bk_read_count_social(esc_url($socialVal['url']), 'youtube');
                        if ( ! empty( $followers ) ) {
                            update_option('bk_youtube_followers', $followers);
                            update_option('bk_youtube_link', esc_url($socialVal['url']));            
            			}
                        set_transient( $transient__name, $followers, 60 * 60 * $hours );
            		}else if($socialType == 'gplus') {
                        $followers = self::bk_read_count_social(esc_url($socialVal['url']), 'gplus');
                        if ( ! empty( $followers ) ) {
                            update_option('bk_gplus_followers', $followers);
                            update_option('bk_gplus_link', esc_url($socialVal['url']));            
            			}
                        set_transient( $transient__name, $followers, 60 * 60 * $hours );
            		}else if($socialType == 'instagram') {
                        $instagramArgs = self::bk_read_count_social($socialVal['accesstoken'], 'instagram');
                        if ( ! empty( $instagramArgs ) ) {
                            update_option('bk_instagram_followers', $instagramArgs['followers']);
                            update_option('bk_instagram_link', 'http://instagram.com/'.esc_attr($instagramArgs['username']));            
                        }
                        set_transient( $transient__name, $instagramArgs['followers'], 60 * 60 * $hours );
            		}else if($socialType == 'dribbble') {
                        $followers = self::bk_read_count_social(esc_url($socialVal['url']), 'dribbble');
                        if ( ! empty( $followers ) ) {
                            update_option('bk_dribbble_followers', $followers);
                            update_option('bk_dribbble_link', esc_url($socialVal['url']));            
            			}
                        set_transient( $transient__name, $followers, 60 * 60 * $hours );
            		}else if($socialType == 'pinterest') {
                        $followers = self::bk_read_count_social(esc_url($socialVal['url']), 'pinterest');
                        if ( ! empty( $followers ) ) {
                            update_option('bk_pinterest_followers', $followers);
                            update_option('bk_pinterest_link', esc_url($socialVal['url']));            
            			}
                        set_transient( $transient__name, $followers, 60 * 60 * $hours );
            		}   
                }
            endforeach;
        }
        
        static function bk_socialItem__counters_render($socialItem){
            $socialHTML = '';
            switch ($socialItem) {
                case 'facebook':
                    $followers = self::number_format_short(get_option('bk_facebook_followers'));
                    $socialHTML .= '<li>';
                    $socialHTML .= '<a href="'.get_option('bk_facebook_link').'" class="social-tile social-facebook facebook-theme-bg">';
                    $socialHTML .= '<div class="social-tile__icon"><i class="mdicon mdicon-facebook"></i></div>';
                    $socialHTML .= '<div class="social-tile__inner flexbox">';
                    $socialHTML .= '<div class="social-tile__left flexbox__item">';
                    $socialHTML .= '<h5 class="social-tile__title meta-font">'.esc_html__('Facebook', 'the-next-mag').'</h5>';
                    $socialHTML .= '<span class="social-tile__count">'.$followers.esc_html__(' likes', 'the-next-mag').'</span>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '<div class="social-tile__right">';
                    $socialHTML .= '<i class="mdicon mdicon-arrow_forward"></i>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</a>';
                    $socialHTML .= '</li>';
                    break;
                case 'twitter':
                    $followers = self::number_format_short(get_option('bk_twitter_followers'));
                    $socialHTML .= '<li>';
                    $socialHTML .= '<a href="'.get_option('bk_twitter_link').'" class="social-tile social-twitter twitter-theme-bg">';
                    $socialHTML .= '<div class="social-tile__icon"><i class="mdicon mdicon-twitter"></i></div>';
                    $socialHTML .= '<div class="social-tile__inner flexbox">';
                    $socialHTML .= '<div class="social-tile__left flexbox__item">';
                    $socialHTML .= '<h5 class="social-tile__title meta-font">'.esc_html__('Twitter', 'the-next-mag').'</h5>';
                    $socialHTML .= '<span class="social-tile__count">'.$followers.esc_html__(' followers', 'the-next-mag').'</span>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '<div class="social-tile__right">';
                    $socialHTML .= '<i class="mdicon mdicon-arrow_forward"></i>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</a>';
                    $socialHTML .= '</li>';
                    break;
                case 'youtube':
                    $followers = self::number_format_short(get_option('bk_youtube_followers'));
                    $socialHTML .= '<li>';
                    $socialHTML .= '<a href="'.get_option('bk_youtube_link').'" class="social-tile social-youtube youtube-theme-bg">';
                    $socialHTML .= '<div class="social-tile__icon"><i class="mdicon mdicon-youtube"></i></div>';
                    $socialHTML .= '<div class="social-tile__inner flexbox">';
                    $socialHTML .= '<div class="social-tile__left flexbox__item">';
                    $socialHTML .= '<h5 class="social-tile__title meta-font">'.esc_html__('Youtube', 'the-next-mag').'</h5>';
                    $socialHTML .= '<span class="social-tile__count">'.$followers.esc_html__(' subscribers', 'the-next-mag').'</span>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '<div class="social-tile__right">';
                    $socialHTML .= '<i class="mdicon mdicon-arrow_forward"></i>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</a>';
                    $socialHTML .= '</li>';
                    break;
                case 'gplus':
                    $followers = self::number_format_short(get_option('bk_gplus_followers'));
                    $socialHTML .= '<li>';
                    $socialHTML .= '<a href="'.get_option('bk_gplus_link').'" class="social-tile social-googleplus googleplus-theme-bg">';
                    $socialHTML .= '<div class="social-tile__icon"><i class="mdicon mdicon-google-plus"></i></div>';
                    $socialHTML .= '<div class="social-tile__inner flexbox">';
                    $socialHTML .= '<div class="social-tile__left flexbox__item">';
                    $socialHTML .= '<h5 class="social-tile__title meta-font">'.esc_html__('Google +', 'the-next-mag').'</h5>';
                    $socialHTML .= '<span class="social-tile__count">'.$followers.esc_html__(' followers ', 'the-next-mag').'</span>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '<div class="social-tile__right">';
                    $socialHTML .= '<i class="mdicon mdicon-arrow_forward"></i>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</a>';
                    $socialHTML .= '</li>';
                    break;
                case 'instagram':
                    $followers = self::number_format_short(get_option('bk_instagram_followers'));
                    $socialHTML .= '<li>';
                    $socialHTML .= '<a href="'.get_option('bk_instagram_link').'" class="social-tile social-instagram instagram-theme-bg">';
                    $socialHTML .= '<div class="social-tile__icon"><i class="mdicon mdicon-instagram"></i></div>';
                    $socialHTML .= '<div class="social-tile__inner flexbox">';
                    $socialHTML .= '<div class="social-tile__left flexbox__item">';
                    $socialHTML .= '<h5 class="social-tile__title meta-font">'.esc_html__('Instagram', 'the-next-mag').'</h5>';
                    $socialHTML .= '<span class="social-tile__count">'.$followers.esc_html__(' followers ', 'the-next-mag').'</span>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '<div class="social-tile__right">';
                    $socialHTML .= '<i class="mdicon mdicon-arrow_forward"></i>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</a>';
                    $socialHTML .= '</li>';
                    break;
                case 'dribbble':
                    $followers = self::number_format_short(get_option('bk_dribbble_followers'));
                    $socialHTML .= '<li>';
                    $socialHTML .= '<a href="'.get_option('bk_dribbble_link').'" class="social-tile social-dribbble dribbble-theme-bg">';
                    $socialHTML .= '<div class="social-tile__icon"><i class="mdicon mdicon-dribbble"></i></div>';
                    $socialHTML .= '<div class="social-tile__inner flexbox">';
                    $socialHTML .= '<div class="social-tile__left flexbox__item">';
                    $socialHTML .= '<h5 class="social-tile__title meta-font">'.esc_html__('Dribbble', 'the-next-mag').'</h5>';
                    $socialHTML .= '<span class="social-tile__count">'.$followers.esc_html__(' followers ', 'the-next-mag').'</span>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '<div class="social-tile__right">';
                    $socialHTML .= '<i class="mdicon mdicon-arrow_forward"></i>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</a>';
                    $socialHTML .= '</li>';
                    break;
                case 'pinterest':
                    $followers = self::number_format_short(get_option('bk_pinterest_followers'));
                    $socialHTML .= '<li>';
                    $socialHTML .= '<a href="'.get_option('bk_pinterest_link').'" class="social-tile social-pinterest pinterest-theme-bg">';
                    $socialHTML .= '<div class="social-tile__icon"><i class="mdicon mdicon-pinterest-p"></i></div>';
                    $socialHTML .= '<div class="social-tile__inner flexbox">';
                    $socialHTML .= '<div class="social-tile__left flexbox__item">';
                    $socialHTML .= '<h5 class="social-tile__title meta-font">'.esc_html__('Pinterest', 'the-next-mag').'</h5>';
                    $socialHTML .= '<span class="social-tile__count">'.$followers.esc_html__(' followers ', 'the-next-mag').'</span>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '<div class="social-tile__right">';
                    $socialHTML .= '<i class="mdicon mdicon-arrow_forward"></i>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</div>';
                    $socialHTML .= '</a>';
                    $socialHTML .= '</li>';
                    break;
                default:
                    return '';
            }
            return $socialHTML;
        }
        
        static function bk_fetch_social_count($response, $filter){
            $response = wp_remote_retrieve_body( $response );
            //print_r($response);
    		if ( ! empty( $response ) && $response !== false ) {
    			foreach ( $filter as $key => $value ) {
    
    				$key = explode( '_', $key );
    				$key = $key[0];
    
    				if ( $key == 'start' ) {
    					$key = false;
    				} else if ( $key == 'end' ) {
    					$key = true;
    				}
                    
    				$key = (bool) $key;
    
    				$index = strpos( $response, $value );
    				if ( $index === false ) {
    					return false;
    				}
                    
    				if ( $key ) {
    					$response = substr( $response, 0, $index );
    				} else {
    					$response = substr( $response, $index + strlen( $value ) );
    				}
    			}
                
    			if ( strlen( $response ) > 100 ) {
    				return false;
    			}
    
    			$count = self::bk_extract_one_number( $response );
    
    			if ( ! is_numeric( $count ) || strlen( number_format( $count ) ) > 15 ) {
    				return false;
    			}
    
    			$count = intval( $count );
    
    			return $count;
    		} else {
    			return false;
    		}
        }
        static function bk_read_count_social( $data, $social_type ) {
    		//check options
    		if ( empty( $data ) ) {
    			return false;
    		}
    		$params = array(
    			'timeout'   => 120,
    			'sslverify' => false
    		);
            if($social_type == 'facebook') {
                $filter1   = array(
        			'start_1' => 'PagesLikesCountDOMID',
        			'start_2' => '<span',
					'start_3' => '>',
					'end_4'   => '<span',
        		);
                $filter2   = array(
        			'start_1' => 'PagesLikesCountDOMID',
        			'start_2' => '</span',
					'start_3' => '>',
					'end_4'   => '</span',
        		);
        		$response = wp_remote_get( $data, $params );
                //print_r($response);
                $filter = $filter1;
                $count = self::bk_fetch_social_count($response, $filter);
                if($count == false) {
                    $filter = $filter2;
                }
            }else if($social_type == 'twitter') {
        		$filter   = array(
        			'start_1' => 'ProfileNav-item--followers',
        			'start_2' => 'ProfileNav-value',
                    'start_3' => 'data-count',
        			'end'     => '>'
        		);
        		$response = wp_remote_get( $data, $params );
            }else if($social_type == 'youtube') {
                $filter   = array(
        			'start_1' => 'yt-subscription-button-subscriber-count-branded-horizontal',
        			'start_2' => '>',
                    'end'     => '</span>'
        		);
                
        		$response = wp_remote_get( $data, $params );  
            }else if($social_type == 'gplus') {
                $filter   = array(
        			'start_1' => '"IGqcid"',
        			'start_2' => 'GseqId',
                    'start_3' => '>',
                    'end'     => '<div'
        		);
                
        		$response = wp_remote_get( $data, $params );  
            }else if($social_type == 'instagram') {
                $url = 'https://api.instagram.com/v1/users/self/?access_token='.$data;
                $api = wp_remote_get( $url ) ;
                if (!is_wp_error($api)) {
                    $request = json_decode(wp_remote_retrieve_body ($api), true);
                    $instagramArgs['followers'] = $request['data']['counts']['followed_by'];   
                    $instagramArgs['username']  =  $request['data']['username'];
                }else {
                    $instagramArgs['followers'] = '';
                    $instagramArgs['username']  =  '';
                }
                return $instagramArgs;
            }else if($social_type == 'dribbble') {
                $filter   = array(
        			'start_1' => 'full-tabs-links',
        			'start_2' => 'followers',
                    'start_3' => 'count',
        			'end'     => '</span>'
        		);
        		$response = wp_remote_get( $data, $params );   
            }else if($social_type == 'pinterest') {
                $filter   = array(
        			'start_1' => 'pinterestapp:followers',
        			'start_2' => 'content',
                    'end' => '>',
        		);
        		$response = wp_remote_get( $data, $params );
            }
    		//check & return
    		if ( is_wp_error( $response ) || empty( $response['response']['code'] ) || '200' != $response['response']['code'] ) {
    			return false;
    		}
    		//get content
    		$count = self::bk_fetch_social_count($response, $filter);
            return $count;
    	}
        static function bk_extract_one_number( $str ) {
        	return intval( preg_replace( '/[^0-9]+/', '', $str ), 10 );
        }
        
        static function number_format_short( $n ) {
        	if ($n > 0 && $n < 1000) {
        		// 1 - 999
        		$n_format = floor($n);
        		$suffix = '';
        	} else if ($n >= 1000 && $n < 1000000) {
        		// 1k-999k
        		$n_format = floor($n / 1000).'.'.round(($n % 1000)/100);
        		$suffix = 'K+';
        	} else if ($n >= 1000000 && $n < 1000000000) {
        		// 1m-999m
        		$n_format = floor($n / 1000000).'.'.round(($n % 1000000)/100000);
        		$suffix = 'M+';
        	} else if ($n >= 1000000000 && $n < 1000000000000) {
        		// 1b-999b
        		$n_format = floor($n / 1000000000).'.'.round(($n % 1000000000)/100000000);
        		$suffix = 'B+';
        	} else if ($n >= 1000000000000) {
        		// 1t+
        		$n_format = floor($n / 1000000000000).'.'.round(($n % 1000000000000)/1000000000000);
        		$suffix = 'T+';
        	}else {
        	   $n_format = '';
               $suffix = '';
        	}
            $fn = $n_format . $suffix;
            
        	return !empty($fn) ? $fn : '';
        }
        static function get_category_tiles($category_ids, $catDescription = 'disable'){
            $categoryTiles = '';
            $moduleHTML = new tnm_category_tile;
    		foreach ($category_ids as $catID ) {
                $categoryAttr = array(
                    'additionalClass' => 'category-tile--sm',
                    'thumbSize'     => 'tnm-xs-2_1',
                    'catID'         => $catID,
                    'description'   => '',
                );
                if($catDescription == 'description') {
                    $categoryAttr['description'] = category_description( $catID ); 
                }else if($catDescription == 'post-count') {
                    $categoryInfo = get_category($catID); 
                    $categoryAttr['description'] = $categoryInfo->category_count . esc_html__(' Articles', 'the-next-mag');
                }else {
                    $categoryAttr['description'] = '';
                }
                $categoryTiles .= '<li>';
                $categoryTiles .= $moduleHTML->render($categoryAttr);
                $categoryTiles .= '</li>';
            }
            return $categoryTiles;
        }
        static function tnm_get_instagram( $search_for, $cache_hours, $nr_images, $attachment ) {
        	if ( isset( $search_for['username'] ) && !empty( $search_for['username'] ) ) {
        		$search = 'user';
        		$search_string = $search_for['username'];
        	} else {
        		return esc_html__( 'Nothing to search for', 'the-next-mag');
        	}
        	
        	
        	$opt_name  = 'jr_insta_' . md5( $search . '_' . $search_string );
        	$instaData = get_transient( $opt_name );
        	$user_opt  = (array) get_option( $opt_name );
        
        	if ( false === $instaData || $user_opt['search_string'] != $search_string || $user_opt['search'] != $search || $user_opt['cache_hours'] != $cache_hours || $user_opt['nr_images'] != $nr_images || $user_opt['attachment'] != $attachment ) {
        		
        		$instaData = array();
        		$user_opt['search']        = $search;
        		$user_opt['search_string'] = $search_string;
        		$user_opt['cache_hours']   = $cache_hours;
        		$user_opt['nr_images']     = $nr_images;
        		$user_opt['attachment']    = $attachment;
        
        		if ( 'user' == $search ) {
        			$response = wp_remote_get( 'https://www.instagram.com/' . trim( $search_string ), array( 'sslverify' => false, 'timeout' => 60 ) );
        		} 
        		if ( is_wp_error( $response ) ) {
                    return '';
        			//return $response->get_error_message();
        		}
        		if ( $response['response']['code'] == 200 ) {
        			
        			$json = str_replace( 'window._sharedData = ', '', strstr( $response['body'], 'window._sharedData = ' ) );
        			
        			// Compatibility for version of php where strstr() doesnt accept third parameter
        			if ( version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {
        				$json = strstr( $json, '</script>', true );
        			} else {
        				$json = substr( $json, 0, strpos( $json, '</script>' ) );
        			}
        			
        			$json = rtrim( $json, ';' );
        			// Function json_last_error() is not available before PHP * 5.3.0 version
        			if ( function_exists( 'json_last_error' ) ) {
        				
        				( $results = json_decode( $json, true ) ) && json_last_error() == JSON_ERROR_NONE;
        				
        			} else {
        				
        				$results = json_decode( $json, true );
        			}
        			
        			if ( $results && is_array( $results ) ) {
                        
                        if ( isset( $results['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
            				$entry_data = $results['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
            			} elseif ( isset( $results['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
            				$entry_data = $results['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
            			}
        				if ( empty( $entry_data ) ) {
        					return esc_html__( 'No images found', 'the-next-mag');
        				}
        
        				foreach ( $entry_data as $current => $result ) {
        				            				    
                            if ( true === $result['node']['is_video'] ) {
                                $nr_images ++;
            					$type = 'video';
                                continue;
            				}else {
            					$type = 'image';
            				}
        
        					if ( $current >= $nr_images ) {
        						break;
        					}
                            
                            $caption = esc_html__( 'Instagram Image', 'the-next-mag' );
            				if ( ! empty( $result['node']['edge_media_to_caption']['edges'][0]['node']['text'] ) ) {
            					$caption = wp_kses( $result['node']['edge_media_to_caption']['edges'][0]['node']['text'], array() );
            				}
            
            				$image_data = array(
            					'description' => $caption,
            					'link'        => trailingslashit( '//instagram.com/p/' . $result['node']['shortcode'] ),
            					'time'        => $result['node']['taken_at_timestamp'],
            					'comments'    => $result['node']['edge_media_to_comment']['count'],
            					'likes'       => $result['node']['edge_liked_by']['count'],
            					'thumbnail'   => preg_replace( '/^https?\:/i', '', $result['node']['thumbnail_resources'][0]['src'] ),
            					'small'       => preg_replace( '/^https?\:/i', '', $result['node']['thumbnail_resources'][2]['src'] ),
            					'large'       => preg_replace( '/^https?\:/i', '', $result['node']['thumbnail_resources'][4]['src'] ),
            					'original'    => preg_replace( '/^https?\:/i', '', $result['node']['display_url'] ),
            					'type'        => $type,
            				);
        						
        					$instaData[] = $image_data;
        
        					
        				} // end -> foreach
        				
        			} // end -> ( $results ) && is_array( $results ) )
        			
        		} else { 
        
        			return $response['response']['message'];
        
        		} // end -> $response['response']['code'] === 200 )
        		update_option( $opt_name, $user_opt );
        		
        	} // end -> false === $instaData
        
        	return $instaData;
        }
    } // Close tnm_widget class
    
}
