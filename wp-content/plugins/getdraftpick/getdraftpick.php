<?php
/*
Plugin name: getdraftpick
Plugin URI: http://playdraftpick.com
Description: This plugin does everything for this site.
Author: adibr70
Version: 0.0.1
Author URI: http://www.freelancer.com/u/adibr70.html
 */

// Add PLAYERS post type for getdraftpick
function get_players_init() {
    $labels = array(
        'name' => _x('Players', 'post type general name'),
        'singular_name' => _x('Player', 'post type singular name'),
        'all_items' => __('All Players'),
        'add_new' => _x('Add new player', 'players'),
        'add_new_item' => __('Add new player'),
        'edit_item' => __('Edit player'),
        'new_item' => __('New player'),
        'view_item' => __('View player'),
        'search_items' => __('Search in players'),
        'not_found' =>  __('No player found'),
        'not_found_in_trash' => __('No player found in trash'), 
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true, 
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 10,
        'menu_icon' => '',
        'supports' => array('title', 'editor', 'comments'),
        'has_archive' => 'players'
    ); 
    register_post_type('players',$args);
}
add_action('init', 'get_players_init');


// Add new Custom Post Type icons
function get_players_icons() {
    /*http://melchoyce.github.io/dashicons/*/
    ?>
    <style>
    #adminmenu .menu-icon-players div.wp-menu-image:before {
    content: '\f338';
    }
    </style>
<?php } 
add_action( 'admin_head', 'get_players_icons' );

// Add TEAMS post type for getdraftpick
function get_teams_init() {
    $labels = array(
        'name' => _x('Teams', 'post type general name'),
        'singular_name' => _x('Team', 'post type singular name'),
        'all_items' => __('All Teams'),
        'add_new' => _x('Add new team', 'teams'),
        'add_new_item' => __('Add new team'),
        'edit_item' => __('Edit team'),
        'new_item' => __('New team'),
        'view_item' => __('View team'),
        'search_items' => __('Search in teams'),
        'not_found' =>  __('No team found'),
        'not_found_in_trash' => __('No team found in trash'), 
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true, 
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 9,
        'menu_icon' => '',
        'supports' => array('title', 'editor', 'comments'),
        'has_archive' => 'teams'
    ); 
    register_post_type('teams',$args);
}
add_action('init', 'get_teams_init');


// Add new Custom Post Type icons
function get_teams_icons() {
    /*http://melchoyce.github.io/dashicons/*/
    ?>
    <style>
    #adminmenu .menu-icon-teams div.wp-menu-image:before {
    content: '\f307';
    }
    </style>
<?php } 
add_action( 'admin_head', 'get_teams_icons' );

// Add POSITIONS post type for 34Fantasy
function get_positions_init() {
    $labels = array(
        'name' => _x('Positions', 'post type general name'),
        'singular_name' => _x('Position', 'post type singular name'),
        'all_items' => __('All Positions'),
        'add_new' => _x('Add new position', 'teams'),
        'add_new_item' => __('Add new position'),
        'edit_item' => __('Edit position'),
        'new_item' => __('New position'),
        'view_item' => __('View position'),
        'search_items' => __('Search in positions'),
        'not_found' =>  __('No position found'),
        'not_found_in_trash' => __('No position found in trash'), 
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true, 
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 11,
        'menu_icon' => '',
        'supports' => array('title', 'editor', 'comments'),
        'has_archive' => 'positions'
    ); 
    register_post_type('positions',$args);
}
add_action('init', 'get_positions_init');


// Add new Custom Post Type icons
function get_positions_icons() {
    /*http://melchoyce.github.io/dashicons/*/
    ?>
    <style>
    #adminmenu .menu-icon-positions div.wp-menu-image:before {
    content: '\f316';
    }
    </style>
<?php } 
add_action( 'admin_head', 'get_positions_icons' );


// Add CONTESTS post type for 34Fantasy
function get_contests_init() {
    $labels = array(
        'name' => _x('Contests', 'post type general name'),
        'singular_name' => _x('Contest', 'post type singular name'),
        'all_items' => __('All Contests'),
        'add_new' => _x('Add new contest', 'teams'),
        'add_new_item' => __('Add new contest'),
        'edit_item' => __('Edit contest'),
        'new_item' => __('New contest'),
        'view_item' => __('View contest'),
        'search_items' => __('Search in contests'),
        'not_found' =>  __('No contest found'),
        'not_found_in_trash' => __('No contest found in trash'), 
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true, 
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 12,
        'menu_icon' => '',
        'supports' => array('title', 'editor', 'comments'),
        'has_archive' => 'contests'
    ); 
    register_post_type('contests',$args);
}
add_action('init', 'get_contests_init');


// Add new Custom Post Type icons
function get_contests_icons() {
    /*http://melchoyce.github.io/dashicons/*/
    ?>
    <style>
    #adminmenu .menu-icon-contests div.wp-menu-image:before {
    content: '\f313';
    }
    </style>
<?php } 
add_action( 'admin_head', 'get_contests_icons' );

function wpc_create_tables() {
    global $wpdb;

    $table_name = $wpdb->prefix . "participants";
    if($wpdb->get_var('SHOW TABLES LIKE ' . $table_name ) != $table_name) {
        $sql = 'CREATE TABLE ' . $table_name . '( 
                        id_participants bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                        id_contest bigint(20) unsigned NOT NULL,
                        id_user bigint(20) unsigned NOT NULL,
                        id_player_qbf bigint(20) unsigned NOT NULL,
                        id_player_qbs bigint(20) unsigned NOT NULL,
                        id_player_rbf bigint(20) unsigned NOT NULL,
                        id_player_rbs bigint(20) unsigned NOT NULL,
                        id_player_wrf bigint(20) unsigned NOT NULL,
                        id_player_wrs bigint(20) unsigned NOT NULL,
                        PRIMARY KEY (id_participants)
                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;';
        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
register_activation_hook(__FILE__, 'wpc_create_tables');

function wpc_create_tables_players_score() {
    global $wpdb;

    $table_name = $wpdb->prefix . "participants";
    if($wpdb->get_var('SHOW TABLES LIKE ' . $table_name ) != $table_name) {
        $sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
                `id_player_score` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `id_wp_player` bigint(20) unsigned NOT NULL,
                `season_type` varchar(255) CHARACTER SET latin1 NOT NULL,
                `week` int(10) unsigned NOT NULL,
                `year` int(10) unsigned NOT NULL,
                `score` int(10) unsigned NOT NULL,
                PRIMARY KEY (`id_player_score`),
                KEY `id_wp_player` (`id_wp_player`,`id_nfl_player`,`nfl_player_name`)
              ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
        require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
register_activation_hook(__FILE__, 'wpc_create_tables_players_score');
?>