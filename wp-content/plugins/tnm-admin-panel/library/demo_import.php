<?php
add_action('wp_ajax_nopriv_bk_demo_import_start', 'bk_demo_import_start');
add_action('wp_ajax_bk_demo_import_start', 'bk_demo_import_start');
if (!function_exists('bk_demo_import_start')) {
    function bk_demo_import_start()
    {        
        //delete_option( 'bk_import_process_data');
        if ( function_exists( 'wordpress_importer_init' ) ) {
            deactivate_plugins( ABSPATH . 'wp-content/plugins/wordpress-importer/wordpress-importer.php' );
        }
        
        $import_source  = isset( $_POST['import_source'] ) ? $_POST['import_source'] : null; 
        $demoType  = isset( $_POST['demoType'] ) ? $_POST['demoType'] : null; 
        
        switch($demoType) {
            case(BK_DEMO_1):
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_2) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_3) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_4) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_5) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_6) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_7) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_8) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_9) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_10) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_11) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_12) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_13) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_14) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_15) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_16) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_17) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_18) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                break;
        }
        
        if($import_source == null)
            wp_die();
        if ( ! current_user_can( 'manage_options' ) )
    		wp_die();
    	if ( get_magic_quotes_gpc() )
    		$_POST = stripslashes_deep( $_POST );
        
        $data = array( 'error' => 0 );
        
        if ( ! file_exists( $import_source['content'] ) ) {
			$data['error'] = 1;
            $data['message'] = esc_attr('content.xml does not exist', 'bkninja');
            $data['url']    = $import_source['content'] ;
			wp_send_json( $data );
		}
        
		if ( ! class_exists( 'WXR_Parser' ) ) {
			require BK_AD_PLUGIN_DIR . 'includes/parsers.php';
		}
        
        $parser = new WXR_Parser();
        
		$import_data = $parser->parse( $import_source['content'] );
		unset( $parser );
                        
        if ( is_wp_error( $import_data ) ) {
			$data['error'] = 1;
			wp_send_json($data);
		}
		
		$data['common']=array(
			'base_url' => esc_url( $import_data['base_url'] ),
		);
		$data['attachments']=array();
		
		$author = (int) get_current_user_id();
        
        foreach ( $import_data['posts'] as $post ) {

			if( 'attachment' == $post['post_type'] ) {
				
				$post_parent = (int) $post['post_parent'];
				
				$postdata = array(
					'import_id' => $post['post_id'], 'post_author' => $author, 'post_date' => $post['post_date'],
					'post_date_gmt' => $post['post_date_gmt'], 'post_content' => $post['post_content'],
					'post_excerpt' => $post['post_excerpt'], 'post_title' => $post['post_title'],
					'post_status' => $post['status'], 'post_name' => $post['post_name'],
					'comment_status' => $post['comment_status'], 'ping_status' => $post['ping_status'],
					'guid' => $post['guid'], 'post_parent' => $post_parent, 'menu_order' => $post['menu_order'],
					'post_type' => $post['post_type'], 'post_password' => $post['post_password']
				);
				
				$remote_url = ! empty( $post['attachment_url'] ) ? $post['attachment_url'] : $post['guid'];
				
				$postdata['upload_date'] = $post['post_date'];
				if ( isset( $post['postmeta'] ) ) {
					foreach( $post['postmeta'] as $meta ) {
						if ( $meta['key'] == '_wp_attached_file' ) {
							if ( preg_match( '%^[0-9]{4}/[0-9]{2}%', $meta['value'], $matches ) )
								$postdata['upload_date'] = $matches[0];
							break;
						}
					}
				}
				
				$postdata['postmeta']=$post['postmeta'];
				
				$data['attachments'][]=array(
					'data' => $postdata,
					'remote_url' => $remote_url,
				);
				
			}
		}
		
		$data['last_attachment_index'] = -1;
        
        switch($demoType) {
            case(BK_DEMO_1):
                $variables_dump = get_option( 'bk_import_process_data_demo_1');
                break;
            case (BK_DEMO_2) :
                $variables_dump = get_option( 'bk_import_process_data_demo_2');
                break;
            case (BK_DEMO_3) :
                $variables_dump = get_option( 'bk_import_process_data_demo_3');
                break;
            case (BK_DEMO_4) :
                $variables_dump = get_option( 'bk_import_process_data_demo_4');
                break;
            case (BK_DEMO_5) :
                $variables_dump = get_option( 'bk_import_process_data_demo_5');
                break;
            case (BK_DEMO_6) :
                $variables_dump = get_option( 'bk_import_process_data_demo_6');
                break;
            case (BK_DEMO_7) :
                $variables_dump = get_option( 'bk_import_process_data_demo_7');
                break;
            case (BK_DEMO_8) :
                $variables_dump = get_option( 'bk_import_process_data_demo_8');
                break;
            case (BK_DEMO_9) :
                $variables_dump = get_option( 'bk_import_process_data_demo_9');
                break;
            case (BK_DEMO_10) :
                $variables_dump = get_option( 'bk_import_process_data_demo_10');
                break;
            case(BK_DEMO_11):
                $variables_dump = get_option( 'bk_import_process_data_demo_11');
                break;
            case (BK_DEMO_12) :
                $variables_dump = get_option( 'bk_import_process_data_demo_12');
                break;
            case (BK_DEMO_13) :
                $variables_dump = get_option( 'bk_import_process_data_demo_13');
                break;
            case (BK_DEMO_14) :
                $variables_dump = get_option( 'bk_import_process_data_demo_14');
                break;
            case (BK_DEMO_15) :
                $variables_dump = get_option( 'bk_import_process_data_demo_15');
                break;
            case (BK_DEMO_16) :
                $variables_dump = get_option( 'bk_import_process_data_demo_16');
                break;
            case (BK_DEMO_17) :
                $variables_dump = get_option( 'bk_import_process_data_demo_17');
                break;
            case (BK_DEMO_18) :
                $variables_dump = get_option( 'bk_import_process_data_demo_18');
                break;
        }
		
		if ( ! empty( $variables_dump ) && is_array( $variables_dump ) ) {
			if ( isset( $variables_dump['last_attachment_index'] ) ) {
				$data['last_attachment_index'] = $variables_dump['last_attachment_index'];
			}
		}
		
		wp_send_json($data);
    }
}
add_action('wp_ajax_nopriv_bk_demo_import_attachments', 'bk_demo_import_attachments');
add_action('wp_ajax_bk_demo_import_attachments', 'bk_demo_import_attachments');
if (!function_exists('bk_demo_import_attachments')) {
    function bk_demo_import_attachments() {  
        $import_source  = isset( $_POST['import_source'] )  ? $_POST['import_source'] : null; 
        $data           = isset( $_POST['data'] )           ? $_POST['data'] : null; 
        $demoType  = isset( $_POST['demoType'] ) ? $_POST['demoType'] : null;
        
        $DataRet = array('error' => 0);
        
    	if ( isset( $data['attachments'] ) ) {
    		
            if ( ! defined('WP_LOAD_IMPORTERS') ) {
    			define('WP_LOAD_IMPORTERS', true);
    		}
            
    		if ( ! class_exists('WP_Import') ) {
    			include(BK_AD_PLUGIN_DIR . 'includes/wordpress-importer.php');
    		}
            
    		if ( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) {
    
    			$importer = new WP_Import();
    			$importer->base_url = $data['common']['base_url'];
    			$importer->fetch_attachments = true;
    			
                switch($demoType) {
                    case (BK_DEMO_1):
                        $variables_dump = get_option( 'bk_import_process_data_demo_1');
                        break;
                    case (BK_DEMO_2) :
                        $variables_dump = get_option( 'bk_import_process_data_demo_2');
                        break;
                    case (BK_DEMO_3) :
                        $variables_dump = get_option( 'bk_import_process_data_demo_3');
                        break;
                    case (BK_DEMO_4) :
                        $variables_dump = get_option( 'bk_import_process_data_demo_4');
                        break;
                    case (BK_DEMO_5) :
                        $variables_dump = get_option( 'bk_import_process_data_demo_5');
                        break;
                    case (BK_DEMO_6) :
                        $variables_dump = get_option( 'bk_import_process_data_demo_6');
                        break;
                    case (BK_DEMO_7) :
                        $variables_dump = get_option( 'bk_import_process_data_demo_7');
                        break;
                    case (BK_DEMO_8) :
                        $variables_dump = get_option( 'bk_import_process_data_demo_8');
                        break;
                    case (BK_DEMO_9) :
                        $variables_dump = get_option( 'bk_import_process_data_demo_9');
                        break;
                    case (BK_DEMO_10) :
                        $variables_dump = get_option( 'bk_import_process_data_demo_10');
                        break;
                    case (BK_DEMO_11):
                        $variables_dump = get_option( 'bk_import_process_data_demo_11');
                        break;
                    case (BK_DEMO_12) :
                        $variables_dump = get_option( 'bk_import_process_data_demo_12');
                        break;
                    case (BK_DEMO_13) :
                        $variables_dump = get_option( 'bk_import_process_data_demo_13');
                        break;
                    case (BK_DEMO_14) :
                        $variables_dump = get_option( 'bk_import_process_data_demo_14');
                        break;
                    case (BK_DEMO_15) :
                        $variables_dump = get_option( 'bk_import_process_data_demo_15');
                        break;
                    case (BK_DEMO_16) :
                        $variables_dump = get_option( 'bk_import_process_data_demo_16');
                        break;
                    case (BK_DEMO_17) :
                        $variables_dump = get_option( 'bk_import_process_data_demo_17');
                        break;
                    case (BK_DEMO_18) :
                        $variables_dump = get_option( 'bk_import_process_data_demo_18');
                        break;
                }
                
    			if ( ! empty( $variables_dump ) && is_array( $variables_dump ) ) {
    				$importer->post_orphans = $variables_dump['post_orphans'];
    				$importer->processed_posts = $variables_dump['processed_posts'];
    				$importer->url_remap = $variables_dump['url_remap'];
    			}
    			
    			$last_attachment_index=$data['first_attachment_index'];
    
    			foreach ( $data['attachments'] as $attachment ) {
    				
    				$post = $attachment['data'];
    
    				$importer->post_orphans[ intval( $post['import_id'] ) ] = (int) $post['post_parent'];
    				$post['post_parent'] = 0;
    		          
    				$post_id = $importer->process_attachment( $post, $attachment['remote_url'] );
    				
    				if ( is_wp_error( $post_id ) ) {
    				    $DataRet['error'] ++;
    					continue;
    				}
    				
    				$importer->processed_posts[ intval( $post['import_id'] ) ] = (int) $post_id;
    
    				// add/update post meta
    				if ( ! empty( $post['postmeta'] ) ) {
    					foreach ( $post['postmeta'] as $meta ) {
    						$key = $meta['key'];
    						$value = false;
    	
    						if ( '_edit_last' == $key ) {
    							continue;
    						}
    	
    						if ( $key ) {
    							if ( ! $value ){
    								$value = maybe_unserialize( $meta['value'] );
    							}
    							add_post_meta( $post_id, $key, $value );
    						}
    					}
    				}
    										
    				$variables_dump['last_attachment_index'] = $last_attachment_index;
    				$last_attachment_index++;
    				
    			}
    
    			$variables_dump['post_orphans'] = $importer->post_orphans;
    			$variables_dump['processed_posts'] = $importer->processed_posts;
    			$variables_dump['url_remap'] = $importer->url_remap;
                
                switch($demoType) {
                    case(BK_DEMO_1):
                        update_option( 'bk_import_process_data_demo_1', $variables_dump );
                        break;
                    case (BK_DEMO_2) :
                        update_option( 'bk_import_process_data_demo_2', $variables_dump );
                        break;
                    case (BK_DEMO_3) :
                        update_option( 'bk_import_process_data_demo_3', $variables_dump );
                        break;
                    case (BK_DEMO_4) :
                        update_option( 'bk_import_process_data_demo_4', $variables_dump );
                        break;
                    case (BK_DEMO_5) :
                        update_option( 'bk_import_process_data_demo_5', $variables_dump );
                        break;
                    case (BK_DEMO_6) :
                        update_option( 'bk_import_process_data_demo_6', $variables_dump );
                        break;
                    case (BK_DEMO_7) :
                        update_option( 'bk_import_process_data_demo_7', $variables_dump );
                        break;
                    case (BK_DEMO_8) :
                        update_option( 'bk_import_process_data_demo_8', $variables_dump );
                        break;
                    case (BK_DEMO_9) :
                        update_option( 'bk_import_process_data_demo_9', $variables_dump );
                        break;
                    case (BK_DEMO_10) :
                        update_option( 'bk_import_process_data_demo_10', $variables_dump );
                        break;
                    case (BK_DEMO_11):
                        update_option( 'bk_import_process_data_demo_11', $variables_dump );
                        break;
                    case (BK_DEMO_12) :
                        update_option( 'bk_import_process_data_demo_12', $variables_dump );
                        break;
                    case (BK_DEMO_13) :
                        update_option( 'bk_import_process_data_demo_13', $variables_dump );
                        break;
                    case (BK_DEMO_14) :
                        update_option( 'bk_import_process_data_demo_14', $variables_dump );
                        break;
                    case (BK_DEMO_15) :
                        update_option( 'bk_import_process_data_demo_15', $variables_dump );
                        break;
                    case (BK_DEMO_16) :
                        update_option( 'bk_import_process_data_demo_16', $variables_dump );
                        break;
                    case (BK_DEMO_17) :
                        update_option( 'bk_import_process_data_demo_17', $variables_dump );
                        break;
                    case (BK_DEMO_18) :
                        update_option( 'bk_import_process_data_demo_18', $variables_dump );
                        break;
                }
    		}
    	}
    	
    	wp_send_json($DataRet);
    }
}
add_action('wp_ajax_nopriv_bk_demo_import_others', 'bk_demo_import_others');
add_action('wp_ajax_bk_demo_import_others', 'bk_demo_import_others');
if (!function_exists('bk_demo_import_others')) {
    function bk_demo_import_others() {  
        wp_delete_nav_menu('Main menu');
        wp_delete_nav_menu('Top Menu');
        wp_delete_nav_menu('Footer');
        wp_delete_nav_menu('Testing Menu');
        $import_source  = isset( $_POST['import_source'] )  ? $_POST['import_source'] : null; 
        $demoType  = isset( $_POST['demoType'] ) ? $_POST['demoType'] : null;
        
        $ret = array( 'error' => 0 );
		
        switch($demoType) {
            case(BK_DEMO_1):
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_2) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_3) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_4) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_5) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_6) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_7) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_8) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_9) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_10) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_11) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_12) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_13) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_14) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_15) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_16) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_17_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_17) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_18_status', false );
                break;
            case (BK_DEMO_18) :
                update_option('bk_demo_1_status', false );
                update_option('bk_demo_2_status', false );
                update_option('bk_demo_3_status', false );
                update_option('bk_demo_4_status', false );
                update_option('bk_demo_5_status', false );
                update_option('bk_demo_6_status', false );
                update_option('bk_demo_7_status', false );
                update_option('bk_demo_8_status', false );
                update_option('bk_demo_9_status', false );
                update_option('bk_demo_10_status', false );
                update_option('bk_demo_11_status', false );
                update_option('bk_demo_12_status', false );
                update_option('bk_demo_13_status', false );
                update_option('bk_demo_14_status', false );
                update_option('bk_demo_15_status', false );
                update_option('bk_demo_16_status', false );
                update_option('bk_demo_17_status', false );
                break;
        }
        	
		if ( ! file_exists( $import_source['content'] ) ) {
			$ret['error'] = 1;
			wp_send_json( $ret );
		}
		
		if ( ! defined('WP_LOAD_IMPORTERS') ) {
			define('WP_LOAD_IMPORTERS', true);
		}
		
		if ( ! class_exists( 'WP_Import' ) ) {
            include(BK_AD_PLUGIN_DIR . 'includes/wordpress-importer.php');
		}

  		if ( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) {

			$importer = new WP_Import();
			$importer->fetch_attachments = false;

            switch($demoType) {
                case (BK_DEMO_1):
                    $variables_dump = get_option( 'bk_import_process_data_demo_1');
                    break;
                case (BK_DEMO_2) :
                    $variables_dump = get_option( 'bk_import_process_data_demo_2');
                    break;
                case (BK_DEMO_3) :
                    $variables_dump = get_option( 'bk_import_process_data_demo_3');
                    break;
                case (BK_DEMO_4) :
                    $variables_dump = get_option( 'bk_import_process_data_demo_4');
                    break;
                case (BK_DEMO_5) :
                    $variables_dump = get_option( 'bk_import_process_data_demo_5');
                    break;
                case (BK_DEMO_6) :
                    $variables_dump = get_option( 'bk_import_process_data_demo_6');
                    break;
                case (BK_DEMO_7) :
                    $variables_dump = get_option( 'bk_import_process_data_demo_7');
                    break;
                case (BK_DEMO_8) :
                    $variables_dump = get_option( 'bk_import_process_data_demo_8');
                    break;
                case (BK_DEMO_9) :
                    $variables_dump = get_option( 'bk_import_process_data_demo_9');
                    break;
                case (BK_DEMO_10) :
                    $variables_dump = get_option( 'bk_import_process_data_demo_10');
                    break;
                case (BK_DEMO_11):
                    $variables_dump = get_option( 'bk_import_process_data_demo_11');
                    break;
                case (BK_DEMO_12) :
                    $variables_dump = get_option( 'bk_import_process_data_demo_12');
                    break;
                case (BK_DEMO_13) :
                    $variables_dump = get_option( 'bk_import_process_data_demo_13');
                    break;
                case (BK_DEMO_14) :
                    $variables_dump = get_option( 'bk_import_process_data_demo_14');
                    break;
                case (BK_DEMO_15) :
                    $variables_dump = get_option( 'bk_import_process_data_demo_15');
                    break;
                case (BK_DEMO_16) :
                    $variables_dump = get_option( 'bk_import_process_data_demo_16');
                    break;
                case (BK_DEMO_17) :
                    $variables_dump = get_option( 'bk_import_process_data_demo_17');
                    break;
                case (BK_DEMO_18) :
                    $variables_dump = get_option( 'bk_import_process_data_demo_18');
                    break;
            }
            
			if ( ! empty( $variables_dump ) && is_array( $variables_dump ) ) {

				$importer->post_orphans = $variables_dump['post_orphans'];
				$importer->processed_posts = $variables_dump['processed_posts'];
				$importer->url_remap = $variables_dump['url_remap'];

			}
			
							
			ob_start();

			$importer->import( $import_source['content'] );

			ob_end_clean();
			
            switch($demoType) {
                case(BK_DEMO_1):
                    update_option( 'bk_import_process_data_demo_1', false );
                    break;
                case (BK_DEMO_2) :
                    update_option( 'bk_import_process_data_demo_2', false );
                    break;
                case (BK_DEMO_3) :
                    update_option( 'bk_import_process_data_demo_3', false );
                    break;
                case (BK_DEMO_4) :
                    update_option( 'bk_import_process_data_demo_4', false );
                    break;
                case (BK_DEMO_5) :
                    update_option( 'bk_import_process_data_demo_5', false );
                    break;
                case (BK_DEMO_6) :
                    update_option( 'bk_import_process_data_demo_6', false );
                    break;
                case (BK_DEMO_7) :
                    update_option( 'bk_import_process_data_demo_7', false );
                    break;
                case (BK_DEMO_8) :
                    update_option( 'bk_import_process_data_demo_8', false );
                    break;
                case (BK_DEMO_9) :
                    update_option( 'bk_import_process_data_demo_9', false );
                    break;
                case (BK_DEMO_10) :
                    update_option( 'bk_import_process_data_demo_10', false );
                    break;
                case(BK_DEMO_11):
                    update_option( 'bk_import_process_data_demo_11', false );
                    break;
                case (BK_DEMO_12) :
                    update_option( 'bk_import_process_data_demo_12', false );
                    break;
                case (BK_DEMO_13) :
                    update_option( 'bk_import_process_data_demo_13', false );
                    break;
                case (BK_DEMO_14) :
                    update_option( 'bk_import_process_data_demo_14', false );
                    break;
                case (BK_DEMO_15) :
                    update_option( 'bk_import_process_data_demo_15', false );
                    break;
                case (BK_DEMO_16) :
                    update_option( 'bk_import_process_data_demo_16', false );
                    break;
                case (BK_DEMO_17) :
                    update_option( 'bk_import_process_data_demo_17', false );
                    break;
                case (BK_DEMO_18) :
                    update_option( 'bk_import_process_data_demo_18', false );
                    break;
            }
            
			$locations = get_theme_mod( 'nav_menu_locations' );
			$menus = wp_get_nav_menus();
			if ( $menus ) {
				$theme_menus = array(
					'Main menu'    => 'main-menu',
                    'Top Menu'     => 'top-menu',
					'Footer'       => 'footer-menu',
				);
				foreach ( $menus as $menu ) {
					if ( isset( $theme_menus[ $menu->name ] ) ) {
						$locations[ $theme_menus[ $menu->name ] ] = $menu->term_id;
					}
				}
			}
      		set_theme_mod( 'nav_menu_locations', $locations );
            
            update_menu_item_meta('main-menu', 'Features', '_menu_item_bkmegamenu', 1);
            update_menu_item_meta('main-menu', 'More', '_menu_item_bkmegamenu', 1);
            update_menu_item_meta('main-menu', 'Travel', '_menu_item_bkmegamenu', 1);
            update_menu_item_meta('main-menu', 'Review', '_menu_item_bkmegamenu', 1);
            update_menu_item_meta('main-menu', 'Tech', '_menu_item_bkmegamenu', 1);
            // Theme Options
            
            $optionData = file_get_contents( $import_source['theme_options'] );
            if ( ! empty ( $optionData ) ) {
                $import_options = json_decode( $optionData, true );
            }
            $redux_options = wp_parse_args( $import_options );
            
            update_option( 'tnm_option', $redux_options );
            
            remove_widgets_from_sidebar('home_sidebar');
            remove_widgets_from_sidebar('second_home_sidebar');
            // Widgets
			if ( file_exists( $import_source['widgets'] ) ) {
				
				if ( ! function_exists( 'wie_available_widgets') ) {
					require BK_AD_PLUGIN_DIR . 'includes/widgets-widgets.php';
				}
				if ( ! function_exists( 'wie_import_data' ) ) {
					require BK_AD_PLUGIN_DIR . 'includes/widgets-import.php';
				}
				
				$data = json_decode( file_get_contents( $import_source['widgets'] ) );
				wie_import_data( $data );
			}

			// Set reading options
        
            switch($demoType) {
                case(BK_DEMO_1):
                    $homepage = get_page_by_title( 'Home 1' );
                    update_category_meta_data();
                    break;
                case(BK_DEMO_2):
                    $homepage = get_page_by_title( 'Home 2' );
                    update_category_meta_data();
                    break;
                case(BK_DEMO_3):
                    $homepage = get_page_by_title( 'Home 3' );
                    update_category_meta_data();
                    break;
                case(BK_DEMO_4):
                    $homepage = get_page_by_title( 'Home 4' );
                    update_category_meta_data();
                    break;
                case(BK_DEMO_5):
                    $homepage = get_page_by_title( 'Home 5' );
                    update_category_meta_data();
                    break;
                case(BK_DEMO_6):
                    $homepage = get_page_by_title( 'Home 6' );
                    update_category_meta_data();
                    break;
                case(BK_DEMO_7):
                    $homepage = get_page_by_title( 'Home 7' );
                    update_category_meta_data();
                    break;
                case(BK_DEMO_8):
                    $homepage = get_page_by_title( 'Home 8' );
                    update_category_meta_data();
                    break;
                case(BK_DEMO_9):
                    $homepage = get_page_by_title( 'Home 9' );
                    break;
                case(BK_DEMO_10):
                    $homepage = get_page_by_title( 'Home 10' );
                    break;
                case(BK_DEMO_11):
                    $homepage = get_page_by_title( 'Home 11' );
                    break;
                case(BK_DEMO_12):
                    $homepage = get_page_by_title( 'Home 12' );
                    break;
                default:
                    $homepage = get_page_by_title( 'Home 1' );
                    update_category_meta_data();
                    break;
            }
			
			if ( $homepage ) {
				update_option( 'page_on_front', $homepage->ID );
				update_option( 'show_on_front', 'page' );
			}

			global $wp_rewrite;
			$wp_rewrite -> set_permalink_structure( '/%postname%/' );
			update_option( 'rewrite_rules', false );
			$wp_rewrite->flush_rules( true );
            
            switch($demoType) {
                case(BK_DEMO_1):
                    update_option('bk_demo_1_status', 'imported' );
                    break;
                case (BK_DEMO_2) :
                    update_option('bk_demo_2_status', 'imported' );
                    break;
                case (BK_DEMO_3) :
                    update_option('bk_demo_3_status', 'imported' );
                    break;
                case (BK_DEMO_4) :
                    update_option('bk_demo_4_status', 'imported' );
                    break;
                case (BK_DEMO_5) :
                    update_option('bk_demo_5_status', 'imported' );
                    break;
                case (BK_DEMO_6) :
                    update_option('bk_demo_6_status', 'imported' );
                    break;
                case (BK_DEMO_7) :
                    update_option('bk_demo_7_status', 'imported' );
                    break;
                case (BK_DEMO_8) :
                    update_option('bk_demo_8_status', 'imported' );
                    break;
                case (BK_DEMO_9) :
                    update_option('bk_demo_9_status', 'imported' );
                    break;
                case (BK_DEMO_10) :
                    update_option('bk_demo_10_status', 'imported' );
                    break;
                case(BK_DEMO_11):
                    update_option('bk_demo_11_status', 'imported' );
                    break;
                case (BK_DEMO_12) :
                    update_option('bk_demo_12_status', 'imported' );
                    break;
                case (BK_DEMO_13) :
                    update_option('bk_demo_13_status', 'imported' );
                    break;
                case (BK_DEMO_14) :
                    update_option('bk_demo_14_status', 'imported' );
                    break;
                case (BK_DEMO_15) :
                    update_option('bk_demo_15_status', 'imported' );
                    break;
                case (BK_DEMO_16) :
                    update_option('bk_demo_16_status', 'imported' );
                    break;
                case (BK_DEMO_17) :
                    update_option('bk_demo_17_status', 'imported' );
                    break;
                case (BK_DEMO_18) :
                    update_option('bk_demo_18_status', 'imported' );
                    break;
            }
		}
	
		wp_send_json($ret);
    }
}
if(!function_exists('tnm_remove_duplicate_menu_item')) {
    function tnm_remove_duplicate_menu_item($menu_name) {
		$items = wp_get_nav_menu_items( $menu_name );
		$prev_title = '';
		foreach ($items as $item) {
			if ($prev_title === '') {
				$prev_title = $item->title;
				continue;
			}
			if ($prev_title === $item->title) {
				wp_delete_post($item->ID, true);
			} else {
				$prev_title = $item->title;
			}
		}
	}
}
// remove all old widgets from target sidebar 
if(!function_exists('remove_widgets_from_sidebar')) {
	function remove_widgets_from_sidebar($sidebar_id) {
		$sidebars_widgets = get_option( 'sidebars_widgets' );
		
		if (isset($sidebars_widgets[$sidebar_id])) {
			//empty the default sidebar
			$sidebars_widgets[$sidebar_id] = array();
		} else {
			$sidebars_widgets = wp_parse_args($sidebars_widgets, array(
				$sidebar_id => array()
			));
		}
		update_option('sidebars_widgets', $sidebars_widgets);
	}
}
if(!function_exists('update_menu_item_meta')) {
    function update_menu_item_meta($menu_name, $menu_item_title, $meta_key, $meta_value) {
    	$items = wp_get_nav_menu_items( $menu_name );
    	foreach ( $items as $item ) {
    		if ( $item->title === $menu_item_title ) {
    			update_post_meta( $item->ID, $meta_key, sanitize_key($meta_value) );
    		}
    	}
    }
}
if(!function_exists('update_category_meta_data')) {
    function update_category_meta_data() {
        $categories = get_categories( );
        $catList = array();
        if(count($categories) > 0) {
            foreach($categories as $key => $category) { 
                $catList[$category->name] = $category->term_id;
            }
            update_term_meta($catList['Business'], 'bk_category__color', '#0c2461');
            update_term_meta($catList['Life'], 'bk_category__color', '#f6b93b');
            update_term_meta($catList['Health'], 'bk_category__color', '#f8c291');
            update_term_meta($catList['Music'], 'bk_category__color', '#70a1ff');
            update_term_meta($catList['Style'], 'bk_category__color', '#b53471');
            update_term_meta($catList['News'], 'bk_category__color', '#ea2027');
            update_term_meta($catList['Nation'], 'bk_category__color', '#3742fa');
            update_term_meta($catList['World'], 'bk_category__color', '#40739e');
            update_term_meta($catList['Tech'], 'bk_category__color', '#55efc4');
            update_term_meta($catList['Computer'], 'bk_category__color', '#74b9ff');
            update_term_meta($catList['Mobile'], 'bk_category__color', '#81ecec');
            update_term_meta($catList['Review'], 'bk_category__color', '#39d266');
            update_term_meta($catList['Science'], 'bk_category__color', '#a29bfe');
            update_term_meta($catList['Travel'], 'bk_category__color', '#9f85de');
        }
    }
}
if (!function_exists('tnm_name_limit_by_word')) {
    function tnm_name_limit_by_word($string, $word_limit){
        $words = explode(' ', $string, ($word_limit + 1));
        if(count($words) > $word_limit)
        array_pop($words);
        $strout = implode(' ', $words);
        if (strlen($strout) < strlen($string))
            $strout .=" ...";
        return $strout;
    }
}