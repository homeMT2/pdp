<?php 
    require_once( dirname(dirname(__FILE__)) . '/wp-load.php' );
    
    $id_contest = intval( filter_input( INPUT_POST, 'sc' ) );
    $id_user = intval( filter_input( INPUT_POST, 'ui' ) );
    $contest_fee = intval( filter_input( INPUT_POST, 'f' ) );
    
    if($contest_fee > 0 ) {
        /*Trebuie sa i luam din cont banii*/
        $sql = "SELECT post_title FROM " . $wpdb->prefix . "posts WHERE ID = {$id_contest}";
        $contest_name = $wpdb->get_var($sql);
        
        $wpdb->query( $wpdb->prepare( 
            "
                INSERT INTO " . $wpdb->prefix . "posts
                ( post_author, 
                    post_date, 
                    post_date_gmt, 
                    post_content, 
                    post_title, 
                    post_status, 
                    post_name, 
                    post_type 
                )
                VALUES ( %d, 
                            %s, 
                            %s, 
                            %s, 
                            %s, 
                            %s,
                            %s, 
                            %s
                )
            ", 
            $id_user, 
            date('Y-m-d H:i:s', time()),
            date('Y-m-d H:i:s', time()),
            'Paypal Transaction', 
            'Paid for contest - '. $contest_name,
            'publish',
            'paypal-outgoing',
            'paypal-transaction'
        ) );
        $post_id = $wpdb->insert_id;
    
        update_post_meta($post_id, 'outgoing', $contest_fee);
    }
    
    $wallet = your_wallet($user_id);
    
    $id_player_gbf = intval( filter_input( INPUT_POST, 'sfq' ) );
    //$id_player_gbs = intval( filter_input( INPUT_POST, 'ssq' ) );
    $id_player_rbf = intval( filter_input( INPUT_POST, 'sfr' ) );
    //$id_player_rbs = intval( filter_input( INPUT_POST, 'ssr' ) );
    $id_player_wrf = intval( filter_input( INPUT_POST, 'sfw' ) );
    //$id_player_wrs = intval( filter_input( INPUT_POST, 'ssw' ) );
        
    $wpdb->query( $wpdb->prepare( 
            "
                    INSERT INTO " . $wpdb->prefix . "participants
                    ( id_contest, id_user, 
                        id_player_qbf, id_player_qbs, 
                        id_player_rbf, id_player_rbs, 
                        id_player_wrf, id_player_wrs 
                    )
                    VALUES ( %d, %d, 
                                %d, %d,
                                %d, %d,
                                %d, %d
                    )
            ", 
            $id_contest, 
            $id_user, 
            $id_player_gbf,
            0,
            $id_player_rbf,
            0,
            $id_player_wrf,
            0
        ) );
    
    
    $html="";
                
    $response = array('html'=>$html);
    echo json_encode($response); 
?>