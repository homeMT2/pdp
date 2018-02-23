<?php

/**
 * Child theme version.
 *
 * @since 1.0.0
 *
 * @var string
 */
define( 'PRIMER_CHILD_VERSION', '1.1.0' );

/**
 * Move some elements around.
 *
 * @action template_redirect
 * @since  1.0.0
 */
function stout_move_elements() {

	remove_action( 'primer_header',                'primer_add_hero',               7 );
	remove_action( 'primer_after_header',          'primer_add_primary_navigation', 11 );
	remove_action( 'primer_after_header',          'primer_add_page_title',         12 );
	remove_action( 'primer_before_header_wrapper', 'primer_video_header',           5 );

	add_action( 'primer_after_header', 'primer_add_hero',               7 );
	add_action( 'primer_header',       'primer_add_primary_navigation', 11 );
	add_action( 'primer_hero',         'primer_video_header',           3 );

	if ( ! is_front_page() || ! is_active_sidebar( 'hero' ) ) {

		add_action( 'primer_hero', 'primer_add_page_title', 12 );

	}

}
add_action( 'template_redirect', 'stout_move_elements' );

/**
 * Set hero image target element.
 *
 * @filter primer_hero_image_selector
 * @since  1.0.0
 *
 * @return string
 */
function stout_hero_image_selector() {

	return '.hero';

}
add_filter( 'primer_hero_image_selector', 'stout_hero_image_selector' );

/**
 * Set custom logo args.
 *
 * @filter primer_custom_logo_args
 * @since  1.0.0
 *
 * @param  array $args
 *
 * @return array
 */
function stout_custom_logo_args( $args ) {

	$args['width']  = 248;
	$args['height'] = 100;

	return $args;

}
add_filter( 'primer_custom_logo_args', 'stout_custom_logo_args' );

/**
 * Set fonts.
 *
 * @filter primer_fonts
 * @since  1.0.0
 *
 * @param  array $fonts
 *
 * @return array
 */
function stout_fonts( $fonts ) {

	$fonts[] = 'Lato';
	$fonts[] = 'Oswald';

	return $fonts;

}
add_filter( 'primer_fonts', 'stout_fonts' );

/**
 * Set font types.
 *
 * @filter primer_font_types
 * @since  1.0.0
 *
 * @param  array $font_types
 *
 * @return array
 */
function stout_font_types( $font_types ) {

	$overrides = array(
		'site_title_font' => array(
			'default' => 'Oswald',
		),
		'navigation_font' => array(
			'default' => 'Oswald',
		),
		'heading_font' => array(
			'default' => 'Oswald',
		),
		'primary_font' => array(
			'default' => 'Lato',
		),
		'secondary_font' => array(
			'default' => 'Lato',
		),
	);

	return primer_array_replace_recursive( $font_types, $overrides );

}
add_filter( 'primer_font_types', 'stout_font_types' );

/**
 * Set colors.
 *
 * @filter primer_colors
 * @since  1.0.0
 *
 * @param  array $colors
 *
 * @return array
 */
function stout_colors( $colors ) {

	unset(
		$colors['content_background_color'],
		$colors['footer_widget_content_background_color']
	);

	$overrides = array(
		/**
		 * Text colors
		 */
		'header_textcolor' => array(
			'default' => '#e3ad31',
		),
		'tagline_text_color' => array(
			'default' => '#686868',
		),
		'hero_text_color' => array(
			'default' => '#ffffff',
		),
		'menu_text_color' => array(
			'default' => '#686868',
		),
		'heading_text_color' => array(
			'default' => '#353535',
		),
		'primary_text_color' => array(
			'default' => '#252525',
		),
		'secondary_text_color' => array(
			'default' => '#686868',
		),
		'footer_widget_heading_text_color' => array(
			'default' => '#ffffff',
		),
		'footer_widget_text_color' => array(
			'default' => '#ffffff',
		),
		'footer_menu_text_color' => array(
			'default' => '#252525',
			'css'      => array(
				'.footer-menu ul li a,
				.footer-menu ul li a:visited' => array(
					'color' => '%1$s',
				),
				'.site-info-wrapper .social-menu a,
				.site-info-wrapper .social-menu a:visited' => array(
					'background-color' => '%1$s',
				),
			),
			'rgba_css' => array(
				'.footer-menu ul li a:hover,
				.footer-menu ul li a:visited:hover' => array(
					'color' => 'rgba(%1$s, 0.8)',
				),
			),
		),
		'footer_text_color' => array(
			'default' => '#686868',
		),
		/**
		 * Link / Button colors
		 */
		'link_color' => array(
			'default' => '#e3ad31',
		),
		'button_color' => array(
			'default' => '#e3ad31',
		),
		'button_text_color' => array(
			'default' => '#ffffff',
		),
		/**
		 * Background colors
		 */
		'background_color' => array(
			'default' => '#ffffff',
		),
		'hero_background_color' => array(
			'default' => '#252525',
		),
		'menu_background_color' => array(
			'default' => '#ffffff',
			'css'     => array(
				'.site-header-wrapper' => array(
					'background-color' => '%1$s',
				),
			),
		),
		'footer_widget_background_color' => array(
			'default' => '#4e4e4e',
		),
		'footer_background_color' => array(
			'default' => '#ffffff',
		),
	);

	return primer_array_replace_recursive( $colors, $overrides );

}
add_filter( 'primer_colors', 'stout_colors' );

/**
 * Set color schemes.
 *
 * @filter primer_color_schemes
 * @since  1.0.0
 *
 * @param  array $color_schemes
 *
 * @return array
 */
function stout_color_schemes( $color_schemes ) {

	unset( $color_schemes['canary'] );

	$overrides = array(
		'blush' => array(
			'colors' => array(
				'header_textcolor' => $color_schemes['blush']['base'],
				'link_color'       => $color_schemes['blush']['base'],
				'button_color'     => $color_schemes['blush']['base'],
			),
		),
		'bronze' => array(
			'colors' => array(
				'header_textcolor' => $color_schemes['bronze']['base'],
				'link_color'       => $color_schemes['bronze']['base'],
				'button_color'     => $color_schemes['bronze']['base'],
			),
		),
		'cool' => array(
			'colors' => array(
				'header_textcolor' => $color_schemes['cool']['base'],
				'link_color'       => $color_schemes['cool']['base'],
				'button_color'     => $color_schemes['cool']['base'],
			),
		),
		'dark' => array(
			'colors' => array(
				// Text
				'tagline_text_color'               => '#999999',
				'menu_text_color'                  => '#ffffff',
				'heading_text_color'               => '#ffffff',
				'primary_text_color'               => '#e5e5e5',
				'secondary_text_color'             => '#c1c1c1',
				'footer_widget_heading_text_color' => '#ffffff',
				'footer_widget_text_color'         => '#ffffff',
				'footer_menu_text_color'           => '#ffffff',
				// Backgrounds
				'background_color'               => '#222222',
				'hero_background_color'          => '#282828',
				'menu_background_color'          => '#333333',
				'footer_widget_background_color' => '#282828',
				'footer_background_color'        => '#222222',
			),
		),
		'iguana' => array(
			'colors' => array(
				'header_textcolor' => $color_schemes['iguana']['base'],
				'link_color'       => $color_schemes['iguana']['base'],
				'button_color'     => $color_schemes['iguana']['base'],
			),
		),
		'muted' => array(
			'colors' => array(
				// Text
				'header_textcolor'       => '#5a6175',
				'menu_text_color'        => '#5a6175',
				'heading_text_color'     => '#4f5875',
				'primary_text_color'     => '#4f5875',
				'secondary_text_color'   => '#888c99',
				'footer_menu_text_color' => $color_schemes['muted']['base'],
				'footer_text_color'      => '#4f5875',
				// Links & Buttons
				'link_color'   => $color_schemes['muted']['base'],
				'button_color' => $color_schemes['muted']['base'],
				// Backgrounds
				'background_color'               => '#ffffff',
				'hero_background_color'          => '#5a6175',
				'menu_background_color'          => '#ffffff',
				'footer_widget_background_color' => '#b6b9c5',
				'footer_background_color'        => '#ffffff',
			),
		),
		'plum' => array(
			'colors' => array(
				'header_textcolor'               => $color_schemes['plum']['base'],
				'link_color'                     => $color_schemes['plum']['base'],
				'button_color'                   => $color_schemes['plum']['base'],
				'footer_widget_background_color' => '#191919',
			),
		),
		'rose' => array(
			'colors' => array(
				'header_textcolor' => $color_schemes['rose']['base'],
				'link_color'       => $color_schemes['rose']['base'],
				'button_color'     => $color_schemes['rose']['base'],
			),
		),
		'tangerine' => array(
			'colors' => array(
				'header_textcolor' => $color_schemes['tangerine']['base'],
				'link_color'       => $color_schemes['tangerine']['base'],
				'button_color'     => $color_schemes['tangerine']['base'],
			),
		),
		'turquoise' => array(
			'colors' => array(
				'header_textcolor' => $color_schemes['turquoise']['base'],
				'link_color'       => $color_schemes['turquoise']['base'],
				'button_color'     => $color_schemes['turquoise']['base'],
			),
		),
	);

	return primer_array_replace_recursive( $color_schemes, $overrides );

	$overrides = array(
		'blush' => array(
			'colors' => array(
				'header_textcolor'      => '#cc494f',
				'menu_background_color' => '#ffffff',
			),
		),
		'bronze' => array(
			'colors' => array(
				'header_textcolor'      => '#b1a18b',
				'menu_background_color' => '#ffffff',
			),
		),
		'cool' => array(
			'colors' => array(
				'header_textcolor'      => '#78c3fb',
				'menu_background_color' => '#ffffff',
			),
		),
		'dark' => array(
			'colors' => array(
				'link_color'   => '#e3ad31',
				'button_color' => '#e3ad31',
			),
		),
		'iguana' => array(
			'colors' => array(
				'header_textcolor'      => '#62bf7c',
				'menu_background_color' => '#ffffff',
			),
		),
		'muted' => array(
			'colors' => array(
				'header_textcolor'               => '#5a6175',
				'menu_text_color'                => '#5a6175',
				'background_color'               => '#ffffff',
				'menu_background_color'          => '#ffffff',
				'footer_widget_background_color' => '#d5d6e0',
				'footer_background_color'        => '#ffffff',
			),
		),
		'plum' => array(
			'colors' => array(
				'header_textcolor'      => '#5d5179',
				'menu_background_color' => '#ffffff',
			),
		),
		'rose' => array(
			'colors' => array(
				'header_textcolor'      => '#f49390',
				'menu_background_color' => '#ffffff',
			),
		),
		'tangerine' => array(
			'colors' => array(
				'header_textcolor'      => '#fc9e4f',
				'menu_background_color' => '#ffffff',
			),
		),
		'turquoise' => array(
			'colors' => array(
				'header_textcolor'      => '#48e5c2',
				'menu_background_color' => '#ffffff',
			),
		),
	);

	return primer_array_replace_recursive( $color_schemes, $overrides );

}
add_filter( 'primer_color_schemes', 'stout_color_schemes' );

/**
 * Enqueue stout hero scripts.
 *
 * @link  https://codex.wordpress.org/Function_Reference/wp_enqueue_script
 * @since 1.1.0
 */
function stout_hero_scripts() {

	$suffix = SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_script( 'stout-hero', get_stylesheet_directory_uri() . "/assets/js/stout-hero{$suffix}.js", array( 'jquery' ), PRIMER_VERSION, true );

}
add_action( 'wp_enqueue_scripts', 'stout_hero_scripts' );

/**
 * Enqueue adibr70 scripts.
 *
 * @link  https://codex.wordpress.org/Function_Reference/wp_enqueue_script
 * @since 1.1.0
 */
function adibr70_fp_scripts() {

    wp_enqueue_script( 'adibr70_fp', get_stylesheet_directory_uri() . "/assets/js/adibr70_fp.js", array( 'jquery' ), PRIMER_VERSION, true );

}
//if(filter_input(INPUT_SERVER, "REQUEST_URI") === '/') {
add_action( 'wp_enqueue_scripts', 'adibr70_fp_scripts' );
//}

function adibr70_pay_scripts() {

    wp_enqueue_script( 'adibr70_checkout', "https://www.paypalobjects.com/api/checkout.js" );

}
//if(filter_input(INPUT_SERVER, "REQUEST_URI") === '/') {
add_action( 'wp_enqueue_scripts', 'adibr70_pay_scripts' );
//}


function custom_content_before_body_close_tag_fp() {
    global $wpdb;
    ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    
    
    <!--<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.3.0/build/cssreset/reset-min.css">-->
    <link rel="stylesheet" type="text/css" href="<?php echo  home_url()?>/wp-content/themes/stout/style_pretty_table.css">

    
    <!-- Modal -->
    <div class="modal fade" id="dialog-player" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLongTitle">Select 3 Players</h3>
<!--            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>-->
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary finish_player">Finish</button>
          </div>
          <div class="modal-body" style="padding: 15px 0;">
              <form>
                  <div id="players" style="list-style-type: none;">
                <?php

                    $sql = "SELECT TT1.ID AS player_id, TT1.post_title AS player_name, TT3.ID AS team_id, TT3.post_title AS team_name   
                                    FROM (SELECT T1.ID, T1.post_title FROM " . $wpdb->prefix . "posts AS T1 
                                            JOIN " . $wpdb->prefix . "postmeta AS T2 ON T1.ID = T2.post_id 
                                            JOIN " . $wpdb->prefix . "posts AS T3 
                                                WHERE T1.post_type = 'players' 
                                                    AND
                                                        T2.meta_key = 'position'
                                                    AND  
                                                        T2.meta_value = T3.ID
                                                    ORDER BY T1.post_date  ASC) AS TT1
				JOIN " . $wpdb->prefix . "postmeta AS TT2 ON TT1.ID = TT2.post_id 
				JOIN " . $wpdb->prefix . "posts AS TT3
				WHERE TT2.meta_key = 'team'
					AND TT2.meta_value = TT3.ID
					AND TT3.post_type = 'teams'";
                            
                    $query = $wpdb->get_results( $sql );

                    function sort_by_player_name($a, $b)
                    {
                        return strcmp( $a->player_name, $b->player_name );
                    }

                    function sort_by_team_name($a, $b)
                    {
                        return strcmp( $a->team_name, $b->team_name );
                    }

                    //usort($query, 'sort_by_player_name' );
                    usort($query, 'sort_by_team_name' );

                    $team_name = '';
                    $show_team_name = FALSE;
                    $show_team_name_first = TRUE;

                    foreach ($query as $q) {

                        if( $team_name != $q->team_name ) {
                            $team_name = $q->team_name;
                            $show_team_name = TRUE;
                        }

                        if( $show_team_name == TRUE ) {

                            if( $show_team_name_first == FALSE ) {
                                echo '</ul>';
                            }

                            if( $show_team_name_first == TRUE ) {
                                echo '<div class="play-line"></div>';
                            }

                            echo '<ul class="players_team ' . $q->team_id . '" style="display: block;">';
                            echo '<li class="' . $q->team_id . '" style="display: block;"><h3>' . $team_name . '</h3></li>';
                            $show_team_name = FALSE;
                            $show_team_name_first = FALSE;
                        }

                        echo '<li><input id="player" type="checkbox" value="' . $q->player_id .'" /><label for="' . $q->player_id . '">' . $q->player_name . '</label></li>';
                    }

                    echo '</ul>';
                ?>
                  </div>
              </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary finish_player">Finish</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Login Form -->
    <div class="modal fade" id="dialog-login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLongTitle">Login/Sign Up</h3>
                    <button type="button" class="btn btn-primary" onclick="window.location = 'http://playdraftpick.com/register/';">Register</button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo do_shortcode( '[wpmem_form login]' ); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal First Contest Form -->
    <div class="modal fade" id="first-contest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLongTitle">Login/Sign Up</h3>
                    <button type="button" class="btn btn-primary" onclick="window.location = 'http://playdraftpick.com/register/';">Register</button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo do_shortcode( '[wpmem_form login]' ); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Error Window -->
    <div class="modal fade" id="dialog-show-error" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLongTitle">Error !!!</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <p id="show_error_text"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Spinner Window -->
    <div class="modal fade" id="dialog-show-spinner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <p>Thank you, you will be redirected soon...</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <?php
    $curent_user_id = 0;
    $wallet = 0;
    if(is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $curent_user_id = $current_user->ID;
        $wallet = your_wallet($curent_user_id);
        echo '<div id="is_login" style="display: none;">'.$curent_user_id.'</div>';
    }
    ?>

    <div id="id_selected_contest" style="display: none;"></div>

    <div id="id_selected_first_qb" style="display: none;"></div>
    <div id="id_selected_first_rb" style="display: none;"></div>
    <div id="id_selected_first_wr" style="display: none;"></div>

    <div id="contest_fee" style="display: none">0</div>
    <div id="wallet" style="display: none;"><?=$wallet;?></div>
    <div id="have_money" style="display: none;"></div>
    <div id="selected_amount" style="display: none"></div>

    <style>

        /* Media query for mobile viewport */
        @media screen and (max-width: 400px) {
            #paypal-button {
                width: 100%;
            }
        }

        /* Media query for desktop viewport */
        @media screen and (min-width: 400px) {
            #paypal-button {
                width: 250px;
                display: inline-block;
            }
        }

    </style>

    <script>
        $ = jQuery;

        $("#selected_amount").html($(".sel_amount").val());

        paypal.Button.render({

            env: 'sandbox', // Or 'production',

             // Specify the style of the button

            style: {
                label: 'checkout',  // checkout | credit | pay | buynow | generic
                size:  'responsive', // small | medium | large | responsive
                shape: 'pill',   // pill | rect
                color: 'gold'   // gold | blue | silver | black
            },

            client: {
                sandbox:    'Afp16L5acmdVIMXCAZctlbkANEHbxuoydXc9LxQMyDDzKFRlRl2t8_SRRwQXirpqxnniO-zvg_mtcBak',
                production: 'AcAU1Wu0JWGA149zqhRjOVhQcIG_uyWkWF0UoalS5HRIwy8hBKfzwS-xeeLYbcR0NYqKuq64Npd-9eZh'
            },

            commit: true, // Show a 'Pay Now' button

            payment: function(data, actions) {

                return actions.payment.create({
                    payment: {
                        transactions: [
                            {
                                amount: { total: $('#selected_amount').html(), currency: 'USD' },
                                custom: $('#is_login').html()
                            }
                        ]
                    },
                    experience: {
                        input_fields: {
                            no_shipping: 1
                        }
                    }
                });
            },

            onAuthorize: function(data, actions) {
                return actions.payment.execute().then(function(payment) {
//                        alert(payment.transactions[0].custom);
//                        alert(payment.transactions[0].amount.total);
//                            window.alert('Payment Complete!');
//                        for(var propertyName in payment) {
//                            window.alert(propertyName);
//                        }
                    $.ajax({
                        type : 'POST',
                        url : 'http://playdraftpick.com/ajax/update_pp.php',
                        dataType : 'json',
                        data: {
                            c: payment.transactions[0].custom,
                            a: payment.transactions[0].amount.total
                        },
                        beforeSend: function(){

                        },
                        complete: function(){

                        },
                        success : function(data) {
                            /*facem update la valoarea din portofel si la have money calculam*/
//                                alert(data.w);
                            $('#wallet').html(data.w);
                            check_wallet();
//                                alert('w ' + $('#wallet').html());
//                                alert('cf ' + $('#contest_fee').html());
//                                alert('cf ' + $('#have_money').html());
//
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
//                                alert(XMLHttpRequest + 'An error occurred. Please try again later!' + errorThrown);
            //                            window.location.href=window.location.href;
                        }
                    });
                });
            }

        }, '#paypal-button');

        $( ".sel_amount" ).change(function() {
            $("#selected_amount").html($(this).val());
        });


        function check_wallet() {
            $(".fl-rich-text").find("p:contains('You must deposit money in your account to play.  Any additional money not used will stay in your account to be used in a later contest.  A portion of all entry fees goes back to charity.')").addClass('mny_txt');

            if($('#wallet').html() === 0) {
//                    $(".fl-rich-text").find("p:contains('You must deposit money in your account to play.  Any additional money not used will stay in your account to be used in a later contest.  A portion of all entry fees goes back to charity.')").html('Your wallet is empty. You must deposit money in your account to play.  Any additional money not used will stay in your account to be used in a later contest.  A portion of all entry fees goes back to charity.');
                $(".mny_txt").html('Your wallet is empty. You must deposit money in your account to play.  Any additional money not used will stay in your account to be used in a later contest.  A portion of all entry fees goes back to charity.');
                $('#have_money').html('no');
            }else {
                var fee = parseInt($('#contest_fee').html());
                var wallet = parseInt($('#wallet').html());
//                    alert(fee);
//                    alert(wallet);
                var rest = wallet - fee;
//                    alert(rest);
                if(rest >= 0) {
//                        $(".fl-rich-text").find("p:contains('You must deposit money in your account to play.  Any additional money not used will stay in your account to be used in a later contest.  A portion of all entry fees goes back to charity.')").html('You have $' + $('#wallet').html() + ' in your wallet. You can deposit new money in your account if you want.  Any additional money not used will stay in your account to be used in a later contest.  A portion of all entry fees goes back to charity.');
                    $(".mny_txt").html('You have $' + $('#wallet').html() + ' in your wallet. You can deposit new money in your account if you want.  Any additional money not used will stay in your account to be used in a later contest.  A portion of all entry fees goes back to charity.');
                    $('#have_money').html('yes');
                }else {
//                        $(".fl-rich-text").find("p:contains('You must deposit money in your account to play.  Any additional money not used will stay in your account to be used in a later contest.  A portion of all entry fees goes back to charity.')").html('You have only $' + $('#wallet').html() + ' in your wallet. You must deposit money in your account to play.  Any additional money not used will stay in your account to be used in a later contest.  A portion of all entry fees goes back to charity.');
                    $(".mny_txt").html('You have only $' + $('#wallet').html() + ' in your wallet. You must deposit money in your account to play.  Any additional money not used will stay in your account to be used in a later contest.  A portion of all entry fees goes back to charity.');
                    $('#have_money').html('no');
                }
            }
        }

        $('#menu-item-344 ul').append('<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-0"><a href="javascript:;">My Wallet: $<?=$wallet;?></a></li>');
        $('#wp-admin-bar-top-secondary').append('<li class="my-wallet-top-bar">My Wallet: $<?=$wallet;?></li>');

    </script>
<?php

}

//if(filter_input(INPUT_SERVER, "REQUEST_URI") === '/') {
    add_action('before_body_close_tag', 'custom_content_before_body_close_tag_fp');
//}

function my_login_redirect() {

    return home_url();
}

add_action( 'wpmem_login_redirect', 'my_login_redirect');

function my_reg_redirect($fields)
{
    global $wpdb;
    // NOTE: this is an action hook that uses wp_redirect
    // wp_redirect must end with exit();
    $id_user = $fields['ID'];
    $amount = 10;
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
            'Free Registration Deposit - '. $amount,
            'publish',
            'paypal-incoming',
            'paypal-transaction'
        ) );
    $post_id = $wpdb->insert_id;
    
    update_post_meta($post_id, 'incoming', $amount);

    wp_redirect( home_url() );

    exit();
}

add_action( 'wpmem_register_redirect', 'my_reg_redirect' );

function my_logout_redirect() {
    // return the url that the logout should redirect to
    return home_url();
}

add_filter( 'wpmem_logout_redirect', 'my_logout_redirect' );

function fant_redirect_to($location = NULL) {
    if($location != NULL){
        header("Location:{$location}");
        exit;
    }	
}

function your_wallet($user_id) {
    global $wpdb;
    $sql = "SELECT T2.meta_key AS type, T2.meta_value AS value FROM " . $wpdb->prefix . "posts AS T1
                LEFT JOIN " . $wpdb->prefix . "postmeta AS T2 ON T1.ID = T2.post_id
                WHERE T1.post_author = {$user_id} 
                    AND T1.post_type = 'paypal-transaction'
                AND (T2.meta_key = 'incoming' OR T2.meta_key = 'outgoing')
        ";
    $wallet_data = $wpdb->get_results( $sql );
    $wallet = 0;
    foreach($wallet_data as $v) {
        if($v->type == 'incoming') {
            $wallet += $v->value;
        }else if($v->type == 'outgoing') {
            $wallet -= $v->value;
        }
    }
    return $wallet;
}