<html>
    <head>
        <link type="text/css" rel="stylesheet" href="//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
        <script type="text/javascript" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="http://playdraftpick.com/ajax/jquery.responsive_countdown.min.js"></script>
        <script type="text/javascript" src="http://playdraftpick.com/ajax/caffeine.js"></script>
        <script type="text/javascript" src="http://playdraftpick.com/ajax/videojs-ie8.js"></script>
        <script type="text/javascript" src="http://playdraftpick.com/ajax/video.js"></script>
        <style>
            #myVideo {
                opacity: 0;
                filter: alpha(opacity=40); /* For IE8 and earlier */
            }
        </style>
    </head>
    <body>
        <h1 style="text-align: center;">AMR</h1>
        <h1 style="text-align: center;">01 Octombrie 2019</h1>
        <div id="five_min_show_min" style="position: relative; width: 100%; height: 50px;"></div>
        <script>
            jQuery(document).ready(function () {
                create_counter();

                var caffeine = new Caffeine();
                caffeine.init();
                if ($( "#myVideo" ).hasClass( "video-js" )) { 
                    var myPlayer = videojs('myVideo');
                    myPlayer.play();
                }

            });
            function create_counter() {

                five_min_show_min = $("#five_min_show_min").ResponsiveCountdown({
                    use_custom_update:false,
                    new_custom_state: "",
                    target_date:"2019/10/1 00:00:00",
                    server_now_date: "",
                    time_zone:new Date().getTimezoneOffset()/(-60),
                    target_future:false,
                    set_id:0,pan_id:0,day_digits:3,
                    fillStyleSymbol1:"rgba(250, 240, 241, 1)",

                    fillStyleSymbol2:"rgba(255, 255, 255, 1)",

                    fillStylesPanel_g1_1:"rgba(33, 198, 83, 1)",

                    fillStylesPanel_g1_2:"rgba(20, 20, 60, 1)",

                    fillStylesPanel_g2_1:"rgba(33, 198, 83, 1)",

                    fillStylesPanel_g2_2:"rgba(20, 20, 60, 1)",

                    text_color:"rgba(0, 0, 0, 1)",
                    text_glow:"rgba(136, 136, 136, 1)",
                    show_ss:1,show_mm:1,
                    show_hh:1,show_dd:1,
                    f_family:"Verdana",show_labels:1,
                    type3d:"single",max_height:300,
                    days_long:"DAYS",days_short:"DD",
                    hours_long:"HOURS",hours_short:"HH",
                    mins_long:"MINUTES",mins_short:"MM",
                    secs_long:"SECONDS",secs_short:"SS",
                    min_f_size:9,max_f_size:30,
                    spacer:"circles",groups_spacing:3,text_blur:2,
                    font_to_digit_ratio:0.15,labels_space:1.2
                });

            }
        </script>
    </body>
</html>
