<?php
/*
  Template Name: Leaderboard
 */

$current_user = wp_get_current_user();

$contests_sql = "SELECT T1.ID, T1.post_title, T2.meta_value AS start_date, T3.meta_value AS end_date
                    FROM " . $wpdb->prefix . "posts AS T1
                        LEFT JOIN " . $wpdb->prefix . "postmeta as T2 ON T1.ID = T2.post_id
                        LEFT JOIN " . $wpdb->prefix . "postmeta as T3 ON T1.ID = T3.post_id
                    WHERE T1.post_type = 'contests'
                        AND T1.post_status = 'publish'
                        AND T2.meta_key = 'start_date'
                        AND T3.meta_key = 'end_date'
                            ORDER BY ID DESC";

$contests = $wpdb->get_results( $contests_sql );
$first_contest_id = $contests[0]->ID;
$first_contest_start_date = $contests[0]->start_date;
$first_contest_end_date = $contests[0]->end_date;

get_header();
?>

<div id="primary" class="content-area" style="font-size: 14px;">

    <main id="main" class="site-main" role="main">
        <article id="leaderboard-table" class="my-pick">

            <div class="row">
                <div class="col-auto">
                    <h5>Contest:</h5>
                </div>
                <div class="col-auto">
                    <select id="nc" onchange="new_contest();">
                        <?php
                        foreach($contests as $v) {

                            $start_date = get_field( "start_date", $v->ID );
                            $start_hour = get_field( "start_hour", $v->ID );

                            $_24 = 'am';

                            if( $start_hour > 12 ) {
                                $start_hour = $start_hour - 12;
                                $_24 = 'pm';
                            }

                            $unix_start_time = strtotime($start_date) + (60 * 60 * $start_hour);
                            $time = '(' . date("Y-m-d H", $unix_start_time) . ':00' . $_24 . ')';

                            ?>
                            <option value="<?= $v->ID; ?>"><?= $v->post_title . ' ' . $time; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row" style="display: none;">
                <div class="col-auto">Start Date: <span id="contest-start-date"><?=$first_contest_start_date;?></span></div>
            </div>
            <div class="row" style="display: none;">
                <div class="col-auto">End Date: <span id="contest-end-date"><?=$first_contest_end_date;?></span></div>
            </div>


            <div id="div-loading" style="text-align: center;">
                <p id="div-loading-text">Please wait! Loading leaderboard...</p>
                <img src="<?php echo home_url() ?>/wp-content/themes/stout/ajax_loader.gif" />
            </div>
            <span id="selected_contest" style="display: none;"><?=$first_contest_id;?></span>
            <div id="div-table" style="display: none;">
                <table id="ltable" class="pretty"></table>
            </div>

        </article>
    </main><!-- #main -->

    <script type="text/javascript">
        $ = jQuery;
        $(document).ready(function () {
            show_leaderboard();
            setInterval(function () {
                show_leaderboard(false); // this will run after every 15 seconds
            }, 15000);
        });

        function show_leaderboard(show = true) {
            $.ajax({
                type: 'POST',
                url: '<?php echo home_url(); ?>/ajax/leaderboard_table.php',
                dataType: 'json',
                data: {
                    contest: $('#selected_contest').html(),
                    user: '<?php echo strtolower( $current_user->user_login ); ?>',
                    all: true
                },
                beforeSend: function () {
                    if (show) {
                        $("#div-loading").show("slow");
                        $("#div-table").hide("slow");
                    }
                },
                complete: function () {
                    if (show) {
                        $("#div-loading").hide("slow");
                        $("#div-table").show("slow");
                    }
                },
                success: function (data) {
                    var ex = document.getElementById('ltable');
                    if ($.fn.DataTable.fnIsDataTable(ex)) {
                        $('#ltable').dataTable().fnDestroy();
                    }
//
                    $("#ltable").css("width", "100%");
                    $("#ltable").html(data.html);
                    $("#contest-start-date").html(data.start_date);
                    $("#contest-end-date").html(data.end_date);

                    $('#ltable').DataTable({
                        "autoWidth": false,
//                          "ordering": false,
                        "aaSorting": [[ 1, 'desc' ]],
                        "columns": [
                            {"width": "7%"},
                            {"width": "8%"},
                            {"width": "12%"},
                            null,
                            null,
                            null,
                            {"width": "12%"}
                        ],
                        "iDisplayLength": 25
                    });
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
//                            alert(XMLHttpRequest + 'An error occurred. Please try again later!' + errorThrown);
//                            window.location.href=window.location.href;
                }
            });
            return false;
        }

        function new_contest() {
            $('#selected_contest').html($('#nc :selected').val());
            show_leaderboard();
        }

    </script>

</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_sidebar('tertiary'); ?>

<?php get_footer(); ?>
