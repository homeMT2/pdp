( function( $ ) {

    function start_page() {
        
        $( '#add_money').hide();
        $(".fl-cta-text").find("h2:contains('Step #4 - Submit Entry')").html('Step #3 - Submit Entry');
        
        check_wallet();

        $( '.select_player' ).on( "click", function(){
            if($('#is_login').size() === 0) {
                $('#dialog-login').modal('show');
                return false;
            }else {
                $('#dialog-player').modal('show');
                return false;
            }

        });
        
        $( '.display_contests' ).html('<table id="contests_table" class="pretty" style="font-size: 14px;"></table>');
         
        $.ajax({
            type : 'POST',
            url : 'http://playdraftpick.com/ajax/contests_table.php',
            dataType : 'json',
            data: {
            },
            beforeSend: function(){
                
            },
            complete: function(){
                
            },
            success : function(data) { 
                var ex = document.getElementById('contests_table');
                if ( $.fn.DataTable.fnIsDataTable( ex ) ) {
                  $('#contests_table').DataTable().fnDestroy();
                }
                
                $("#contests_table").css("width","100%");
                $('#contests_table').html(data.html);

                var contest_table = $('#contests_table').DataTable({
                    "sDom": '',
                    "autoWidth": false,
                    "aaSorting": [[ 2, 'desc' ]],
                    "columns": [
                        { "visible": false },
                        null,
                        {"width": "16%"},
                        null,
                        null,
                        null,
                        null,
                        null
                    ],
                    "iDisplayLength": 25
                });
                 
                /*Select contest*/

                $('#contests_table tbody').on('click', 'tr', function () {

                    if( $(this).hasClass('final') ) {
                        // ---
                    }
                    else if($('#is_login').size() === 0 ) {
                        $('#dialog-login').modal('show');
                    }
                    else {

                        var data = contest_table.row( this ).data();

                        var team_1 = $(this).find('.team-1').val();
                        var team_2 = $(this).find('.team-2').val();

                        $('#players ul').css( "display", "none" );
                        $('#players ul.' + team_1 ).css( "display", "block" );
                        $('#players ul.' + team_2 ).css( "display", "block" );

                        console.log(data[0]);

                        if(data[0] > 0) {
                            $(".selected_contest").html("<p>Selected contest: " + data[2] + "</p>");
                            $("#id_selected_contest").html( data[0]);

                            if(data[4].split('$')[1] > 0) {
                                $( '#add_money' ).show();
                                $( '#contest_fee' ).html(data[4].split('$')[1]);
                                $( '.fl-cta-text' ).find( "h2:contains('Step #3 - Submit Entry')" ).html( 'Step #4 - Submit Entry' );
                            }
                            else {
                                $( '#add_money' ).hide();
                                $( '.fl-cta-text' ).find( "h2:contains('Step #4 - Submit Entry')" ).html( 'Step #3 - Submit Entry' );
                            }
                        }
                        else if(data[0] === '-1') {
                            $('#show_error_text').html("This is a started contest. Can't add new players.");
                            $('#dialog-show-error').modal('show');
                        }
                        else if(data[0] === '-2') {
                            $('#show_error_text').html("This is a finished contest. Can't add new players.");
                            $('#dialog-show-error').modal('show');
                        }
                        else {
                            $('#show_error_text').html("Unknown error!");
                            $('#dialog-show-error').modal('show');
                        }
                    }
                } );
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                //alert(XMLHttpRequest + 'An error occurred. Please try again later!' + errorThrown);
//                            window.location.href=window.location.href;
            }
        });


        
        $(".finish_player").click(function(){
            var val_arr = [];
            var nam_arr = [];

            $("input:checkbox[id=player]:checked").each(function() {
                val_arr.push($(this).val());
                nam_arr.push($('label[for=' + $(this).val() + ']').html());
            });

            if(val_arr.length !== 3 ) {
                alert("You must select 3 players!");
                return false;
            }

            $(".selected_qb").html("<p>Pick #1: <ul><li>"+ nam_arr[0] + "</li><ul></p>");
            $(".selected_rb").html("<p>Pick #2: <ul><li>"+ nam_arr[1] + "</li><ul></p>");
            $(".selected_wr").html("<p>Pick #3: <ul><li>"+ nam_arr[2] + "</li><ul></p>");

            $("#id_selected_first_qb").html(val_arr[0]);
            $("#id_selected_first_rb").html(val_arr[1]);
            $("#id_selected_first_wr").html(val_arr[2]);

            $('#dialog-player').modal('hide');
        });
        
        /*Click Login button*/
        $('.button').click(function () { 
            if ($('a.button:contains("Login")').length > 0) {
                $('#dialog-login').modal('show');
            }
            return false;
        });
        
        /*Hide login options*/
        if($('#is_login').size()) {
           $('a.button:contains("Login")').hide();
           $('a:contains("Login")').hide();
           $('a:contains("Register")').hide();
           $('a:contains("Logout")').show();
           $('a:contains("My Picks")').show();
           $('.my-wallet-top-bar').show();
        }else {
            $('a.button:contains("Login")').show();
           $('a:contains("Login")').show();
           $('a:contains("Register")').show();
           $('a:contains("Logout")').hide(); 
           $('a:contains("My Picks")').hide();
           $('a:contains("Profile")').hide();
           $('.my-wallet-top-bar').hide();
        }
        
        /*Submit Entry*/
        $( '.submit_entry' ).on( "click", function(){
            var x = false;
            var text;
            var login = false;

            if($('#is_login').size() === 0) {
                x = true;
                text = 'Please login first!';
                login = true;
            }
            else if($('#id_selected_contest').html() === '') {
                x = true;
                text = 'Please select a contest!';
            }
            else if($('#id_selected_first_qb').html() === '') {
                x = true;
                text = 'Please select two QuarterBack!';
            }
            else if($('#id_selected_first_rb').html() === '') {
                x = true;
                text = 'Please select two Running Back!';
            }
            else if($('#id_selected_first_wr').html() === '') {
                x = true;
                text = 'Please select two Wide Receiver!';
            }
            else if(parseInt($('#contest_fee').html()) > 0) {
                if($('#have_money').html() === 'no') {
                    x = true;
                    text = 'You must deposit money in your account to play.';
                }
                else if( parseInt( $('#wallet').html() ) < parseInt( $('#contest_fee').html() ) ) {
                    x = true;
                    text = 'You must deposit money in your account to play.';
                }
            }
            
            if(x) {
                if( login == false ) {
                    $('#show_error_text').html(text);
                    $('#dialog-show-error').modal('show');
                }
                else {
                    $('#dialog-login').modal('show');
                }
            }else {
                $.ajax({
                    type : 'POST',
                    url : 'http://playdraftpick.com/ajax/add_participant.php',
                    dataType : 'json',
                    data: {
                        ui : $('#is_login').html(),
                        sc : $('#id_selected_contest').html(),
                        sfq : $('#id_selected_first_qb').html(),
                        sfr : $('#id_selected_first_rb').html(),
                        sfw : $('#id_selected_first_wr').html(),
                        f: $('#contest_fee').html()
                    },
                    beforeSend: function(){
                        $('#dialog-show-spinner').modal('show');
                    },
                    complete: function(){
                        $('#dialog-show-spinner').modal('hide');
                    },
                    success : function(data) {
                        window.location.href = "http://playdraftpick.com/leaderboard/";
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        //alert(XMLHttpRequest + 'An error occurred. Please try again later!' + errorThrown);
        //                            window.location.href=window.location.href;
                    }
                });
            }
                
            return false;
        });

        //$('#primer-hero-text-2 a').on('click', function() {
        //    window.location.href = "http://playdraftpick.com/login/";
        //});
        
    }

    $( document ).ready( start_page );
    
    

} )( jQuery );