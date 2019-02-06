<?php
if (!class_exists('tnm_ajax_search')) {
    class tnm_ajax_search {
        //Search Query
        static function tnm_query($searchTerm) {
            $args = array(
                's' => esc_sql($searchTerm),
                'post_type' => array('post'),
                'post_status' => 'publish',
                'posts_per_page' => 3,
            );
    
            $the_query = new WP_Query($args);
            return $the_query;
        }
        static function tnm_ajax_content( $the_query, $users_found ) {
            $searchTerm      = isset( $_POST['searchTerm'] ) ? $_POST['searchTerm'] : null;    
            
            $postHTML = new tnm_horizontal_1;
            $postAttr = array (
                'additionalClass'  => 'post--horizontal-xxs',
                'thumbSize'     => 'tnm-xxs-1_1',
                'catClass'      => 'post__cat cat-theme',
                'meta'          => array('date'),
                'typescale'     => 'typescale-1',
            );
            
            $search_data = '';
            $search_data .= '<div class="row row--space-between">';
            $search_data .= '<div class="search-results__section col-md-6"> <!-- Post Column Start -->';
            $search_data .= '<div class="search-results__section-heading">';
            $search_data .= '<h4 class="search-results__section-heading-title">Posts</h4>';
            $search_data .= '</div> <!-- End Heading -->';
            if($the_query->have_posts()):
                $search_data .= '<ul class="search-results__list list-space-sm list-unstyled">';
                while ( $the_query->have_posts() ): $the_query->the_post();
                    $search_data .= '<li class="search-results__item">';
                    $search_data .= $postHTML->render($postAttr);
                    $search_data .= '</li>';
                endwhile;
                $search_data .= '</ul> <!-- End Post Results -->';
            else:
                $search_data .= esc_html__('There is no post result.', 'the-next-mag');
            endif;
            $search_data .= '</div> <!-- End Post Column -->';
            $search_data .= '<div class="search-results__section col-md-6"><!-- Start Author Column -->';
            $search_data .= '<div class="search-results__section-heading">';
            $search_data .= '<h4 class="search-results__section-heading-title">Authors</h4>';
            $search_data .= '</div> <!-- End Heading -->';
            if(count($users_found) > 0):
                $search_data .= '<ul class="search-results__list list-space-sm list-unstyled">';
                foreach($users_found as $user) :
                    $search_data .= '<li class="search-results__item">';
                    $search_data .= '<div class="entry-author entry-author--with-ava">';
                    $search_data .= get_avatar( $user->data->ID, $size = '34', '', $user->data->user_nicename, array('class' => 'entry-author__avatar') );
                    $search_data .= '<a class="entry-author__name" rel="author" href="'.get_author_posts_url($user->data->ID).'">'.$user->data->user_nicename.'</a>';
                    $search_data .= '</div>';
                    $search_data .= '</li>';
                endforeach;
                $search_data .= '</ul> <!-- End Author Results -->';
            else:
                $search_data .= esc_html__('There is no author result.', 'the-next-mag');
            endif;
            $search_data .= '</div> <!-- End Author Column -->';
            $search_data .= '</div><!-- End Row -->';
            $search_data .= '<div class="search-results__view-all">';
            $search_data .= '<a href="' . get_search_link($searchTerm) . '" class="link link--underlined"><span>View all results</span><i class="mdicon mdicon-arrow_forward icon--last"></i></a>';
            $search_data .= '</div>';
            
            return $search_data;
        }
    }
}
add_action('wp_ajax_nopriv_tnm_ajax_search', 'tnm_ajax_search');
add_action('wp_ajax_tnm_ajax_search', 'tnm_ajax_search');
if (!function_exists('tnm_ajax_search')) {
    function tnm_ajax_search()
    {        
        check_ajax_referer( 'tnm_ajax_security', 'securityCheck' );
        
        $searchTerm      = isset( $_POST['searchTerm'] ) ? $_POST['searchTerm'] : null;    
        
        $dataReturn = esc_html__('No result', 'the-next-mag');
    
        $the_query = tnm_ajax_search::tnm_query($searchTerm);
        
        $users = new WP_User_Query( array(
            'search'         => '*'.esc_attr( $searchTerm ).'*',
            'search_columns' => array(
                'user_login',
                'user_nicename',
                'user_email',
                'user_url',
            ),
        ) );
        
        $users_found = $users->get_results();
        
        if (( $the_query->have_posts() ) || count($users_found)) {
            $dataReturn = tnm_ajax_search::tnm_ajax_content($the_query, $users_found);
        }else {
            $dataReturn = esc_html__('No result', 'the-next-mag');
        }
        die(json_encode($dataReturn));
    }
}