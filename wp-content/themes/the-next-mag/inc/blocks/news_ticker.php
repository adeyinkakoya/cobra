<?php
if (!class_exists('tnm_news_ticker')) {
    class tnm_news_ticker {
        
        public function render( $page_info ) {
            $block_str = '';
            $moduleID = uniqid('tnm_news_ticker-');
            $moduleConfigs = array();
            $moduleData = array();
            
            //get config
            $newsticker_fw = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_newsticker_fw', true ); 
            $newstickerFWClass = '';
            if ($newsticker_fw == 'yes') {
                $newstickerFWClass = 'mnmd-news-ticker--fw';
            }else {
                $newstickerFWClass = '';
            }
            $contiguousClass = 'mnmd-block--contiguous';
            $moduleConfigs['title']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_title', true );   
            $moduleConfigs['orderby']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_orderby', true );
            $moduleConfigs['tags']      = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_tags', true ); 
            $moduleConfigs['limit']     = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_limit', true );
            $moduleConfigs['offset']    = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_offset', true );
            $moduleConfigs['feature']   = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_feature', true );
            $moduleConfigs['category_id'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_category', true );
            $moduleConfigs['editor_pick'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_pick', true );
            $moduleConfigs['editor_exclude'] = get_post_meta( $page_info['page_id'], $page_info['block_prefix'].'_editor_exclude', true );
            
            $the_query = bk_get_query::query($moduleConfigs);              //get query
            
            if ( $the_query->have_posts() ) :
           	$block_str .= '<div id="'.$moduleID.'" class="mnmd-block mnmd-block--fullwidth mnmd-news-ticker '.$contiguousClass.' '.$newstickerFWClass.'">';
            $block_str .= '<div class="container">';
            $block_str .= '<div class="mnmd-news-ticker__inner">';
            
            if($moduleConfigs['title'] != null) {
                $block_str .= '<div class="mnmd-news-ticker__heading hidden-xs">';
                $block_str .= '<span>'.$moduleConfigs['title'].'</span>';
                $block_str .= '</div>';
            }
            
            $block_str .= '<div class="mnmd-news-ticker__content js-mnmd-news-ticker">';
            $block_str .= '<ul>';
            $block_str .= $this->render_modules($the_query); 
            $block_str .= '</ul>';
            $block_str .= '</div><!-- End .mnmd-news-ticker__content -->';
            $block_str .= $this->newsticker_nav();
            
            $block_str .= '</div>';
            $block_str .= '</div><!-- End Container -->';
            $block_str .= '</div><!-- End Block -->';
            
            endif;
            
            unset($moduleConfigs); unset($the_query);     //free
            wp_reset_postdata();
            return $block_str;            
    	}
        public function newsticker_nav(){
            $newsticker_nav = '';
            $newsticker_nav .= '<div class="mnmd-news-ticker__control">';
			$newsticker_nav .= '<button class="mnmd-news-ticker__prev"><i class="mdicon mdicon-expand_less"></i></button>';
			$newsticker_nav .= '<button class="mnmd-news-ticker__next"><i class="mdicon mdicon-expand_more"></i></button>';
			$newsticker_nav .= '</div>';
            return $newsticker_nav;
        }   
        public function ticker_post($postID){
            $catClass = 'post__cat post__cat--bg cat-theme-bg hidden-xs';
            $bk_permalink = get_permalink($postID);
            $bk_post_title = get_the_title($postID);
            $tickerPost = '';
            $tickerPost .= '<div class="post">';
            $tickerPost .= tnm_core::bk_get_post_cat_link($postID, $catClass);
			$tickerPost .= '<h3 class="post__title typescale-1"><a href="'.$bk_permalink.'">'.$bk_post_title.'</a></h3>';
			$tickerPost .= '</div>';
            return $tickerPost;
        }
        public function render_modules ($the_query){
            $render_modules = '';
            
            while ( $the_query->have_posts() ): $the_query->the_post();
                $postID = get_the_ID();
                $render_modules .= '<li>';
                $render_modules .= $this->ticker_post($postID);
                $render_modules .= '</li> <!-- end small item -->';
            endwhile;
            
            return $render_modules;
        }
        
    }
}