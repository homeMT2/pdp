<?php 
    require_once( dirname(dirname(__FILE__)) . '/wp-load.php' );
    
    $id_user = intval( filter_input( INPUT_POST, 'c' ) );
    $amount = intval( filter_input( INPUT_POST, 'a' ) );
    
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
            'Amount to Deposit - '. $amount,
            'publish',
            'paypal-incoming',
            'paypal-transaction'
        ) );
    $post_id = $wpdb->insert_id;
    
    update_post_meta($post_id, 'incoming', $amount);
    
    $wallet = your_wallet($id_user);
    
    $response = array('w'=>$wallet);
    echo json_encode($response); 
?>