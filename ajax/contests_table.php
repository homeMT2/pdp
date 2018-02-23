<?php 
    require_once( dirname(dirname(__FILE__)) . '/wp-load.php' );
    
    $sql = "SELECT ID, post_title FROM " . $wpdb->prefix . "posts
            WHERE post_type = 'contests'
                AND post_status = 'publish'";
    $query = $wpdb->get_results( $sql );
    
    $html = '<thead>
                <tr>
                    <th>ID</th>
                    <th>Enter</th>
                    <th>Contest</th>
                    <th>Prize</th>
                    <th>Entry Fee</th>
                    <th>Benefiting</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
            </thead>
            <tbody>';
    
    foreach($query as $q) {
        
        $entry_fee = get_field( "entry_fee", $q->ID );
        $prize = ( get_field( "prize", $q->ID ) != '' ) ? get_field( "prize", $q->ID ) : '$0';
        $benefiting = get_field( "benefiting", $q->ID );
        $start_date = get_field( "start_date", $q->ID );
        $start_hour = get_field( "start_hour", $q->ID );
        $end_date = get_field( "end_date", $q->ID );
        
        $unix_start_time = strtotime($start_date) + 60 * 60 * ($start_hour + 4);
        
        $unix_end_time = strtotime($end_date);
        
        $contest_id = $q->ID;

        if($unix_start_time < time()) {
            $contest_id = -1; /*s-a terminat timpul de inscriere in concurs*/
        } 
        if($unix_end_time < time()) {
            $contest_id = -2; /*s-a terminat concursul*/
        }

        $teams = get_field( "participants_teams", $q->ID );

        $teams_input = '';
        $i = 1;
        foreach( $teams as $team ) {
            $teams_input .= '<input type="hidden" class="team-' . $i . '" value="' . $team->ID . '">';
            $i++;
        }

        $contest_end = get_field('end', $contest_id);

        $button = '<td>
                        <div class="fl-callout-button" data-id="' . $contest_id . '">
                            <div class="fl-button-wrap fl-button-width-full">
                                <a href="javascript:;" target="_self" class="fl-button" role="button">
                                    <span class="fl-button-text">Enter</span>
                                    ' . $teams_input . '
                                </a>
                            </div>
                        </div>
                    </td>';

        $end = '<td>(Final)</td>';

        $show  = ( $contest_end == 1 ) ? $end : $button;
        $final = ( $contest_end == 1 ) ? 'final' : '';

        if( $contest_end != 1 ) {
            $html .= '<tr class="' . $final . '">
                    <td>' . $contest_id . '</td>
                    ' . $show . '
                    <td><div class="table_min_width">' . $q->post_title . '</div></td>
                    <td>' . $prize . '</td>
                    <td>' . $entry_fee . '</td>
                    <td>' . $benefiting . '</td>
                    <td>' . $start_date . '<br />' . $start_hour . ':00</td>
                    <td>' . $end_date . '</td>
                </tr>';
        }
    }
                    
$html .= '</tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Enter</th>
                    <th>Contest</th>
                    <th>Prize</th>
                    <th>Entry Fee</th>
                    <th>Benefiting</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
            </tfoot>';
                
    $response = array('html'=>$html);
    echo json_encode($response); 
?>