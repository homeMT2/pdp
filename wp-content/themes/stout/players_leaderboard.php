<?php
/*
    Template Name: Players Leaderboard
*/

$weeks_sql = "
        SELECT DISTINCT(week) FROM " . $wpdb->prefix . "players_score ORDER BY week DESC
        ";
$weeks = $wpdb->get_results( $weeks_sql );
//echo '<pre>bau'; print_r($weeks); echo '</pre>'; 
$first_week = $weeks[0]->week;
get_header(); 

?>

<div id="primary" class="content-area" style="font-size: 14px;">

	<main id="main" class="site-main" role="main">
            <article id="leaderboard-table">
                <div class="row">
                    <div class="col-auto">
                        <h5>Week:</h5>
                    </div>
                    <div class="col-auto">
                        <select id="nw" onchange="new_week();">
                            <?php 
                                foreach( $weeks AS $v) {
                            ?>
                                    <option value="<?=$v->week;?>"><?=$v->week;?></option>
                            <?php 
                                } 
                            ?>
                        </select>
                    </div>
                </div>
                    
                <div id="div-loading" style="text-align: center;">
                    <p id="div-loading-text">Please wait! Loading leaderboard...</p>
                    <img src="<?php echo  home_url()?>/wp-content/themes/stout/ajax_loader.gif" />
                </div>
                <span id="selected_week" style="display: none;"><?=$first_week;?></span>
                <div id="div-table" style="display: none;">
                    <table id="ptable" class="pretty"></table>
                </div>    
            </article>
	</main><!-- #main -->

        <script type="text/javascript">
            $=jQuery;
            $(document).ready(function() {
                show_leaderboard();
                setInterval(function(){
                    show_leaderboard(false); // this will run after every 15 seconds
                }, 60000);
            });
            
            function show_leaderboard(show = true) {
                    $.ajax({
                        type : 'POST',
                        url : '<?php echo  home_url(); ?>/ajax/players_leaderboard_table.php',
                        dataType : 'json',
                        data: {
                            week : $('#selected_week').html()
                        },
                        beforeSend: function(){
                            if(show) {
                                $("#div-loading").show("slow");
                                $("#div-table").hide("slow");
                            }
                        },
                        complete: function(){
                            if(show) {
                                $("#div-loading").hide("slow");
                                $("#div-table").show("slow");
                            }
                        },
                        success : function(data) {
                            var ex = document.getElementById('ptable');
                            if ( $.fn.DataTable.fnIsDataTable( ex ) ) {
                              $('#ptable').dataTable().fnDestroy();
                            }
//                            
                            $("#ptable").css("width","100%");
                            $("#ptable").html(data.html);
                            
                            $('#ptable').DataTable( {
            //                    "sDom": '',
                                "autoWidth": false,
            //                    "ordering": false,
                                "iDisplayLength": 25,
                                "aaSorting": [[ 12, 'desc' ]],
                                "columns": [ 
                                        { "sWidth": "12%" },
                                        null,
                                        null, null, null,
                                        null, null,
                                        null, null, null,
                                        null, null, 
                                        { "sWidth": "8%" }
                                ]
                            });
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
//                            alert(XMLHttpRequest + 'An error occurred. Please try again later!' + errorThrown);
    //                            window.location.href=window.location.href;
                        }
                    });
                    return false;
                }
                
                function new_week(){
                    $('#selected_week').html($('#nw :selected').val());
                    show_leaderboard();
                }
            
        </script>

</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_sidebar( 'tertiary' ); ?>

<?php get_footer(); ?>