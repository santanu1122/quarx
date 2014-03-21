<?php /*
    Filename:   add.php
    Location:   /views
*/ ?>

<!-- Main Page -->

<div class="select-a-user">
    <ul>
        <!-- To be populated by ajax! -->
    </ul>
</div>

<div class="quarx-device">

    <div class="raw100">

        <div class="raw48 raw-margin-bottom-15">
            <a href="#" data-role="button" onclick="showMenu()">Inbox Menu</a>
        </div>

        <div class="raw2 raw-block-10 mHide"></div>

        <div class="raw50" style="margin-top: 2px;">
            <form id="SearchBox" method="post" action="<?php echo site_url('inbox/search'); ?>">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />    
                <input id="search" name="search" class="searchBar" data-deefault="Enter a Search Term" />
            </form>
        </div>

    </div>

    <div id="formHolder" class="raw100 form">
        <form id="addAccount" method="post" enctype="multipart/form-data" action="<?php echo site_url('inbox/send_message'); ?>">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

            <!-- // Get to  the actual form! -->
            <div class="raw100">
                <div class="raw15 mHide"><p>To</p></div>
                <div class="raw85">
                    <input id="u_name" type="text" name="user_name" data-val="To" value="<?php if(isset($to)){ echo $to; } ?>" onkeyup="findUsers(this.value)" autocomplete="off" />
                </div>
            </div>
            <div class="raw100">
                <div class="raw15 mHide"><p>Subject</p></div>
                <div class="raw85"><input type="text" name="subject" data-val="Subject" /></div>
            </div>
            <div class="raw100">
                <div class="raw15 mHide"><p>Message</p></div>
                <div class="raw85"><textarea id="message" class="rtf" name="message"></textarea></div>
            </div>
            <div class="raw100">
                <div class="raw15 raw-block-15"></div>
                <div class="raw85"><input id="adduser" class="fatButton" type="submit" value="Send Message" /></div>
            </div>
        </form>
    </div>

</div>

<script type="text/javascript">

/* Page Functions
***************************************************************/

    $("#search").deefault();

    function findUsers(name) {
        if(name.length > 1){
            $(".select-a-user").slideDown();

            $.ajax({
                type: 'GET',
                url: "<?php echo site_url('inbox/find_users'); ?>/"+name,
                dataType: "html",
                success: function(data){
                    $(".select-a-user ul").html(data);
                }
            });

            var itop = $("#u_name").offset().top,
                ileft = $("#u_name").offset().left,
                iWidth = $("#u_name").width();

            $(".select-a-user").css({
                top: itop+35,
                left: ileft,
                width: iWidth-2
            });

            $("#quarx-modal").css({
                background: "transparent",
                display: "block"
            });

            $("#quarx-modal").bind("click", function(){
                $("#quarx-modal").css({
                    display: "none"
                });
                
                $(".select-a-user").slideUp();
            });
        }
    }

    $(function(){
        if($(window).width() < 680){
            $(".form .raw85 input").each(function(){
                $(this).val($(this).attr("data-val"));
            });
        }

        $("#formHolder").submit(function(e){
            if($("#u_name").val() == "" || $("#message").val() == ""){
                e.preventDefault();
            }
        });
    });

    $(window).resize(function(){
        if($(window).width() < 680){
            if($(window).width() < 680){
                $(".form .raw85 input").each(function(){
                    $(this).val($(this).attr("data-val"));
                });
            }
        }
    });

</script>
    
<?php //End of file ?>