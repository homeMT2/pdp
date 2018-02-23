<?php 
    require_once( dirname(dirname(__FILE__)) . '/wp-load.php' );
    
    $week = intval( filter_input( INPUT_POST, 'week' ) );
    
    $players = $wpdb->get_results(
        "
            SELECT T1.ID, T1.post_title AS name, T2.* FROM " . $wpdb->prefix . "posts AS T1
                LEFT JOIN " . $wpdb->prefix . "players_score AS T2 ON T1.ID = T2.id_wp_player
                    WHERE T1.post_type = 'players'
                        AND T2.week = {$week}
                    ORDER BY T2.score DESC
                    
        ");
    
    $html="

        <thead>
            <tr>
                <th rowspan=\"2\">PLAYERS NAME</th>
                <th rowspan=\"2\">WEEK</th>
                <th colspan=\"3\">PASSING</th>
                <th colspan=\"2\">RUSHING</th>
                <th colspan=\"3\">RECEIVING</th>
                <th colspan=\"2\">MISC</th>
                <th rowspan=\"2\">TOTAL POINTS</th>
            </tr>
            <tr>
                <th>YDS</th>
                <th>TD</th>
                <th>INT</th>

                <th>YDS</th>
                <th>TD</th>

                <th>REC</th>
                <th>YDS</th>
                <th>TD</th>

                <th>2PC</th>
                <th>FUML</th>
            </tr>
        </thead>
        <tbody>";
                foreach($players as $p) {
        $html .= "<tr>
                    <td style=\"text-align: left;\">{$p->name}</td>
                    <td>{$p->week}</td>

                    <td>{$p->passing_yards}</td>
                    <td>{$p->passing_touchdowns}</td>
                    <td>{$p->passing_interceptions}</td>

                    <td>{$p->rushing_yards}</td>
                    <td>{$p->rushing_touchdowns}</td>

                    <td>{$p->receiving_receptions}</td>
                    <td>{$p->receiving_yards}</td>
                    <td>{$p->receiving_touchdowns}</td>

                    <td>0</td>
                    <td>{$p->fumbles_lost}</td>

                    <td>{$p->score}</td>

                </tr>";
                }
        $html .= "</tbody>
        <tfoot>
            <tr>
                <th rowspan=\"2\">PLAYERS NAME</th>
                <th rowspan=\"2\">WEEK</th>
                
                <th>YDS</th>
                <th>TD</th>
                <th>INT</th>

                <th>YDS</th>
                <th>TD</th>

                <th>REC</th>
                <th>YDS</th>
                <th>TD</th>

                <th>2PC</th>
                <th>FUML</th>
                
                <th rowspan=\"2\">TOTAL POINTS</th>
            </tr>
            <tr>
                <th colspan=\"3\">PASSING</th>
                <th colspan=\"2\">RUSHING</th>
                <th colspan=\"3\">RECEIVING</th>
                <th colspan=\"2\">MISC</th>
            </tr>
            
        </tfoot>

        ";
                
    $response = array('html'=>$html);
    echo json_encode($response); 
?>