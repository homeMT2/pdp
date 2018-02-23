<?php 
    require_once( dirname(dirname(__FILE__)) . '/wp-load.php' );
    
    $contest_id = intval( filter_input( INPUT_POST, 'contest' ) );

    $user = ( isset( $_POST['user'] ) || $_POST['user'] == '' ) ? $_POST['user'] : FALSE;

    $contest_data_sql = "
            SELECT T1.post_title, T2.meta_value AS start_date, T3.meta_value AS end_date FROM " . $wpdb->prefix . "posts AS T1
                LEFT JOIN " . $wpdb->prefix . "postmeta AS T2 ON T1.ID = T2.post_id
                    LEFT JOIN " . $wpdb->prefix . "postmeta AS T3 ON T1.ID = T3.post_id
                        WHERE T1.ID = {$contest_id}
                            AND T2.meta_key = 'start_date'
                                AND T3.meta_key = 'end_date'
                                LIMIT 1
            ";
    $contest_data = $wpdb->get_results( $contest_data_sql );

    $contest_name = $contest_data[0]->post_title;
    
    $start_date = explode('-', $contest_data[0]->start_date);
    $start_date_year = $start_date[0];
    $start_date_month = $start_date[1];
    $start_date_day = $start_date[2];
    $unix_start_date = strtotime($contest_data[0]->start_date);

    $end_date = explode('-', $contest_data[0]->end_date);
    $end_date_year = $end_date[0];
    $end_date_month = $end_date[1];
    $end_date_day = $end_date[2];
    $unix_end_date = strtotime($contest_data[0]->end_date);

    $scorul_pe_o_perioada_sql = "
            SELECT id_wp_player, SUM(score) as all_score 
                FROM " . $wpdb->prefix . "players_score 
                WHERE 
                    unixtime >= {$unix_start_date} 
                        AND unixtime <= {$unix_end_date}
                    GROUP BY id_wp_player
            ";

    $scorul_pe_o_perioada = $wpdb->get_results( $scorul_pe_o_perioada_sql );
    $players_score_array = array();

    foreach($scorul_pe_o_perioada as $v) {
        $players_score_array[$v->id_wp_player] = round($v->all_score, 2);
    }

    $toti_participantii_pentru_un_contest_sql = "
                SELECT * FROM " . $wpdb->prefix . "participants WHERE id_contest= {$contest_id};
            ";
    $toti_participantii_pentru_un_contest = $wpdb->get_results( $toti_participantii_pentru_un_contest_sql );

    $participantii_array = array();

    foreach($toti_participantii_pentru_un_contest as $v) {
        $ar = array();
        $ar['id_user'] = $v->id_user;

        $ar['id_player_qbf'] = $v->id_player_qbf;
        //$ar['id_player_qbs'] = $v->id_player_qbs;
        $ar['id_player_rbf'] = $v->id_player_rbf;
        //$ar['id_player_rbs'] = $v->id_player_rbs;
        $ar['id_player_wrf'] = $v->id_player_wrf;
        //$ar['id_player_wrs'] = $v->id_player_wrs;
        $participantii_array[$v->id_participants] = $ar;
    }

    $participanti_score_array = array();

    foreach($toti_participantii_pentru_un_contest as $v) {
        $score = 0;
        $score =    $players_score_array[$v->id_player_qbf] +
                    $players_score_array[$v->id_player_qbs] +
                    $players_score_array[$v->id_player_rbf] +
                    $players_score_array[$v->id_player_rbs] +
                    $players_score_array[$v->id_player_wrf] +
                    $players_score_array[$v->id_player_wrs];

        $participanti_score_array[$v->id_participants] = $score;
    }
    
    asort($participanti_score_array);

    $all_users_sql = "SELECT * FROM " . $wpdb->prefix . "users";
    $all_users = $wpdb->get_results( $all_users_sql );
    $array_users = array();
    foreach($all_users as $au) {
        $array_users[$au->ID] = $au->user_nicename;
    }

    $all_players_sql = "
            SELECT T1.ID, T1.post_title AS player_name, T3.post_title AS position FROM " . $wpdb->prefix . "posts AS T1
                LEFT JOIN " . $wpdb->prefix . "postmeta AS T2 ON T1.ID = T2.post_id
                    LEFT JOIN  " . $wpdb->prefix . "posts AS T3 ON T2.meta_value = T3.ID
                WHERE T1.post_type = 'players'
                    AND T2.meta_key = 'position' ";

    $all_players = $wpdb->get_results( $all_players_sql );

    $array_players = array();
    foreach($all_players as $ap) {
        $arr = array();
        $arr['player_name'] = $ap->player_name;
        $arr['position'] = $ap->position;
        $array_players[$ap->ID] = $arr;
    }

    $html="

        <thead>
            <tr>
                <th>Rank</th>
                <th>Points</th>
                <th>Name</th>
                <th>Player #1</th>
                <th>Player #2</th>
                <th>Player #3</th>
                <th>Contest</th>
            </tr>
        </thead>
        <tbody>";

    $i = 1;
    $rank = 1;

    $best_total = 0;

    foreach($participanti_score_array as $k => $v) {

        $participantii_array[$k]['qbf_score'] = 0;
        $participantii_array[$k]['rbf_score'] = 0;
        $participantii_array[$k]['wrf_score'] = 0;

        if( have_rows('players', $contest_id) ):
            while ( have_rows('players', $contest_id) ) : the_row();

                $player = get_sub_field('player');

                if( $player->ID == $participantii_array[$k]['id_player_qbf'] ) {
                    $participantii_array[$k]['qbf_score'] = get_sub_field('points');
                }

                if( $player->ID == $participantii_array[$k]['id_player_rbf'] ) {
                    $participantii_array[$k]['rbf_score'] = get_sub_field('points');
                }

                if( $player->ID == $participantii_array[$k]['id_player_wrf'] ) {
                    $participantii_array[$k]['wrf_score'] = get_sub_field('points');
                }

            endwhile;
        endif;

        $participantii_array[$k]['total_score'] = $participantii_array[$k]['qbf_score'] + $participantii_array[$k]['rbf_score'] + $participantii_array[$k]['wrf_score'];

        if( $best_total < $participantii_array[$k]['total_score'] ) {
            $best_total = $participantii_array[$k]['total_score'];
        }

    }

    foreach($participanti_score_array as $k => $v) {

        $id_player_qbf = $participantii_array[$k]['id_player_qbf'];
        $id_player_rbf = $participantii_array[$k]['id_player_rbf'];
        $id_player_wrf = $participantii_array[$k]['id_player_wrf'];

        $user_name = $array_users[$participantii_array[$k]['id_user']];

        $end = get_field('end', $contest_id);
        $end_text = '';

        $this_best = ( $best_total == $participantii_array[$k]['total_score'] ) ? 'best-total' : '';

        if( $end == 1 ) {
            $end_text = '<br>(Final)';
        }

        //$contest_name = str_replace('vs ', 'vs<br>', $contest_name);

        if( $user == FALSE || $user_name == $user  ) {

            $html .= "
                <tr class='{$this_best}'>
                    <td>{$rank}{$end_text}</td>
                    <td>
                        <span style=\"color:orange;font - weight: bold;\">{$participantii_array[$k]['total_score']}</span>
                    </td>
                    <td style=\"text-align: left;\">{$user_name}</td>
                    <td>
                        {$array_players[$id_player_qbf]['player_name']}<span style=\"color:orange;\">({$participantii_array[$k]['qbf_score']})</span><br />
                    </td>
                    <td>
                        {$array_players[$id_player_rbf]['player_name']}<span style=\"color:orange;\">({$participantii_array[$k]['rbf_score']})</span><br />
                    </td>
                    <td>
                        {$array_players[$id_player_wrf]['player_name']}<span style=\"color:orange;\">({$participantii_array[$k]['wrf_score']})</span><br />
                    </td>
                    <td>{$contest_name}</td>
                </tr>
                ";

            $rank++;
        }

        $i++;
    }
    $html .="
        </tbody>
        <tfoot>
            <tr>
                <th>Rank</th>
                <th>Points</th>
                <th>Name</th>
                <th>Player #1</th>
                <th>Player #2</th>
                <th>Player #3</th>
                <th>Contest</th>
            </tr>
        </tfoot>

        ";
                
    $response = array('html'=>$html, 'start_date'=>$contest_data[0]->start_date, 'end_date'=>$contest_data[0]->end_date);
    echo json_encode($response); 
?>