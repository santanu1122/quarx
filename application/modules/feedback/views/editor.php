<?php /*
	Filename: 	editor.php
	Location: 	/application/views/feedback
*/ ?>

<script type="text/javascript">

    function archiveEntry(id){    
        $( "#dialog-archive" ).dialogbox({
            modal: true,
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('feedback/archive_entry').'/'; ?>"+id; 
                },
                Cancel: function() {
                    archiveDialog('#dialog-display');
                }
            }
        });
    }

    function displayEntry(id){    
        $( "#dialog-display" ).dialogbox({
            modal: true,
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('feedback/display_entry').'/'; ?>"+id; 
                },
                Cancel: function() {
                    destroyDialog('#dialog-display');
                }
            }
        });
    }

</script>

<!-- dialogs -->

<div id="dialog-archive" title="Archive Confirmation" class="dialogBox">
    <p>Are you sure you want to archive this entry?</p>
</div>

<div id="dialog-display" title="Display Confirmation" class="dialogBox">
    <p>Are you sure you want to display this entry?</p>
</div>

<!-- main content -->

<div class="device">
    <div class="raw100">
        <a href="#" data-role="button" onclick="showMenu()">Feedback Menu</a>
    </div>

    <div class="raw100 tall">
        <div id="feedbackFormPage" class="raw100 align-left">
            <form id="feedback_form" method="post" action="<?php echo site_url('feedback/update_rating'); ?>">
                
                <input type="hidden" id="id" name="id" value="<?php echo $rating->fbr_id; ?>" />
                <input type="hidden" id="fb_id" name="fb_id" value="<?php echo $rating->fbr_feedback_id; ?>" />
                <input type="hidden" id="servicesList" name="services" value="" />

                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

                <div class="raw49">
                    <input class="padded5" type="text" id="clientName" name="client_name" value="<?php echo $feedback[0]->fb_client_name; ?>" />
                </div>
                <div class="spacer raw2"></div>
                <div class="raw49">
                    <input class="padded5" type="text" id="clientEmail" name="client_email" value="<?php echo $feedback[0]->fb_client_email; ?>" />
                </div>
                <div class="raw100">
                    <input class="padded5" type="text" id="location" name="location" value="<?php echo $rating->fbr_location; ?>" />
                </div>


                <div class="raw100">
                    <h3>Services</h3>
                </div> 
                <div class="raw100">
                    <div class="raw32">
                        <input class="service" type="checkbox" id="doors" value="doors" />
                        <label for="doors">Doors</label>
                    </div>
                    <div class="spacer raw2"></div>
                    <div class="raw32">
                        <input class="service" type="checkbox" id="windows" value="windows" />
                        <label for="windows">Windows</label>
                    </div>
                    <div class="spacer raw2"></div>
                    <div class="raw32">
                        <input class="service" type="checkbox" id="roofing" value="roofing" />
                        <label for="roofing">Roofing</label>
                    </div>

                    <div class="raw32">
                        <input class="service" type="checkbox" id="siding" value="siding" />
                        <label for="siding">Siding</label>
                    </div>
                    <div class="spacer raw2"></div>
                    <div class="raw32">
                        <input class="service" type="checkbox" id="insulation" value="insulation" />
                        <label for="insulation">Insulation</label>
                    </div>
                    <div class="spacer raw2"></div>
                    <div class="raw32">
                        <input class="service" type="checkbox" id="renovations" value="renovations" />
                        <label for="renovations">Renovations</label>
                    </div>
                </div>

                <div class="raw100" style="margin: 10px 0px;">
                    <h3>Staff Ratings</h3>
                </div> 

                <div class="raw100">
                    <div class="raw25"><p>Sales Representative</p></div>
                    <div class="raw25">
                        <select id="salesRep" name="sales_rep">
                            <option value="<?php echo $feedback[0]->fb_sales_rep; ?>"><?php echo $feedback[0]->fb_sales_rep; ?></option>
                            <option value="sue">Sue</option>
                            <option value="john">John</option>
                            <option value="jerry">Jerry</option>
                            <option value="mike">Mike</option>
                            <option value="heather">Heather</option>
                        </select>
                    </div>
                    <div class="raw25">
                        <ul id="feedback_sales" class="star-rating">
                            <li class="stars"></li>
                            <li class="stars"></li>
                            <li class="stars"></li>
                            <li class="stars"></li>
                            <li class="stars"></li>
                        </ul>
                    </div>
                    <div class="raw25">
                        <textarea class="comments" name="sales_rep_comments"><?php echo $rating->fbr_sales_rep_comments; ?></textarea>
                    </div>
                </div>


            <div class="raw100">
                <div class="raw25"><p>Jobsite Forman</p></div>
                <div class="raw25">
                    <select id="foreman" name="foreman">
                        <option value="<?php echo $feedback[0]->fb_foreman; ?>"><?php echo $feedback[0]->fb_foreman; ?></option>
                        <option value="joe">Joe</option>
                        <option value="bobby">Bobby</option>
                        <option value="steve">Steve</option>
                        <option value="kim">Kim</option>
                        <option value="jack">Jack</option>
                    </select>
                </div>
                <div class="raw25">
                    <ul id="feedback_foreman" class="star-rating">
                        <li class="stars"></li>
                        <li class="stars"></li>
                        <li class="stars"></li>
                        <li class="stars"></li>
                        <li class="stars"></li>
                    </ul>
                </div>
                <div class="raw25">
                    <textarea class="comments" name="foreman_comments"><?php echo $rating->fbr_foreman_comments; ?></textarea>
                </div>
            </div>

            <div class="raw100 ratingBox">
                <div class="raw50"><p>Professionalism</p></div>
                <ul id="feedback_professionalism" class="star-rating">
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                </ul>
            </div>

            <div class="raw100 ratingBox">
                <div class="raw50"><p>Efficiency</p></div>
                <ul id="feedback_efficiency" class="star-rating">
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                </ul>
            </div>

            <div class="raw100 ratingBox">
                <div class="raw50"><p>Cleanliness</p></div>
                <ul id="feedback_cleanliness" class="star-rating">
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                </ul>
            </div>

            <div class="raw100 ratingBox">
                <div class="raw50"><p>Workmanship</p></div>
                <ul id="feedback_workmanship" class="star-rating">
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                </ul>
            </div>

            <div class="raw100 ratingBox">
                <div class="raw50"><p>Overall Experience</p></div>
                <ul id="feedback_experience" class="star-rating">
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                </ul>
            </div>

            <div class="raw100 ratingBox">
                <div class="raw50"><p>Cost Value</p></div>
                <ul id="feedback_value" class="star-rating">
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                </ul>
            </div>

            <div class="raw100 ratingBox">
                <div class="raw50"><p><b>Overall</b></p></div>
                <ul id="feedback_overall" class="star-rating">
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                    <li class="stars"></li>
                </ul>
            </div>
            
            <div class="raw100">

                <!-- <div class="raw50">
                    <p>Would you recommend us to a friend? </p>
                </div>
                <div class="raw50">
                    <input type="checkbox" id="recommend" <?php if($rating->fbr_recommend == 'yes'){ echo 'checked="checked"'; } ?> name="recommend" value="yes" />
                    <label for="recommend">Recommend</label>
                </div> -->

                <div class="raw25">
                    <p>Title</p>
                </div>
                <div class="raw75">
                    <input class="padded5" type="text" id="title" name="title" value="<?php echo $rating->fbr_title; ?>" />
                </div>

                <div class="raw25">
                    <p>Comments</p>
                </div>
                <div class="raw75">
                    <textarea class="comments_box" name="comments"><?php echo $rating->fbr_comments; ?></textarea>
                </div>
                
            </div>

            <div class="raw100">
                <button id="submitBtn" data-theme="a" style="margin-top: 15px;">Update Entry</button>
                <?php if($rating->fbr_display === 'no'){ ?>
                <button id="displayBtn" data-theme="c">Display</button>
                <?php }else if($rating->fbr_display == "yes"){ ?>
                <button id="archiveBtn" data-theme="b">Hide</button>
                <?php }else{ ?>
                <button id="displayBtn" data-theme="c">Enable Display</button>
                <?php } ?>
            </div>
        </div>    
        </form>
    </div>
    
</div>

<script type="text/javascript">

    $(document).ready(function(){

        $('#displayBtn').bind('click', function(e){
            e.preventDefault();
            displayEntry('<?php echo encrypt($rating->fbr_id); ?>')
        });

        $('#archiveBtn').bind('click', function(e){
            e.preventDefault();
            archiveEntry('<?php echo encrypt($rating->fbr_id); ?>')
        });

        $('.service').bind('click', function(){
            if($(this).attr('data-checked') > ''){
                $(this).removeAttr('data-checked');
            }else{
                $(this).attr('data-checked', 'checked');
            }
        });

        $('#submitBtn').click (function (e) {
            e.preventDefault ();

            var ServicesList = new Array(),
                i = 0,
                allServices = '[ ';

            $('.service').each(function(){
                if($(this).attr('data-checked') == 'checked'){
                    ServicesList[i] = $(this).val();
                    i++;
                }
            });

            for(s = 0; s < ServicesList.length; s++){
                if(s == ServicesList.length){
                    allServices += '"'+ServicesList[s]+'"';
                }else if(s == 0){
                    allServices += '"'+ServicesList[s]+'"';
                }else{
                    allServices += ',"'+ServicesList[s]+'"';
                }
            }

            allServices += ' ]';

            $('#servicesList').val(allServices);

            // console.log(allServices);

            $('#feedback_form').submit();

        });

        $('#feedback_overall').tothestars({
            startAt: <?php echo overall_score($rating->fbr_id); ?>,
            deadStarBackground: 'url(<?php echo $root; ?>/application/modules/feedback/img/small-stars.png) no-repeat 0px -23px',
            liveStarBackground: 'url(<?php echo $root; ?>/application/modules/feedback/img/small-stars.png) no-repeat 0px 0px'
        });

        $('#feedback_sales').tothestars({
            startAt: <?php echo $rating->fbr_sales_rep_rating; ?>,
            deadStarBackground: 'url(<?php echo $root; ?>/application/modules/feedback/img/small-stars.png) no-repeat 0px -23px',
            liveStarBackground: 'url(<?php echo $root; ?>/application/modules/feedback/img/small-stars.png) no-repeat 0px 0px'
        });

        $('#feedback_foreman').tothestars({
            startAt: <?php echo $rating->fbr_foreman_rating; ?>,
            deadStarBackground: 'url(<?php echo $root; ?>/application/modules/feedback/img/small-stars.png) no-repeat 0px -23px',
            liveStarBackground: 'url(<?php echo $root; ?>/application/modules/feedback/img/small-stars.png) no-repeat 0px 0px'
        });

        $('#feedback_professionalism').tothestars({
            startAt: <?php echo $rating->fbr_professionalism; ?>,
            deadStarBackground: 'url(<?php echo $root; ?>/application/modules/feedback/img/small-stars.png) no-repeat 0px -23px',
            liveStarBackground: 'url(<?php echo $root; ?>/application/modules/feedback/img/small-stars.png) no-repeat 0px 0px'
        });

        $('#feedback_cleanliness').tothestars({
            startAt: <?php echo $rating->fbr_cleanliness; ?>,
            deadStarBackground: 'url(<?php echo $root; ?>/application/modules/feedback/img/small-stars.png) no-repeat 0px -23px',
            liveStarBackground: 'url(<?php echo $root; ?>/application/modules/feedback/img/small-stars.png) no-repeat 0px 0px'
        });

        $('#feedback_efficiency').tothestars({
            startAt: <?php echo $rating->fbr_speed; ?>,
            deadStarBackground: 'url(<?php echo $root; ?>/application/modules/feedback/img/small-stars.png) no-repeat 0px -23px',
            liveStarBackground: 'url(<?php echo $root; ?>/application/modules/feedback/img/small-stars.png) no-repeat 0px 0px'
        });

        $('#feedback_workmanship').tothestars({
            startAt: <?php echo $rating->fbr_workmanship; ?>,
            deadStarBackground: 'url(<?php echo $root; ?>/application/modules/feedback/img/small-stars.png) no-repeat 0px -23px',
            liveStarBackground: 'url(<?php echo $root; ?>/application/modules/feedback/img/small-stars.png) no-repeat 0px 0px'
        });

        $('#feedback_experience').tothestars({
            startAt: <?php echo $rating->fbr_experience; ?>,
            deadStarBackground: 'url(<?php echo $root; ?>/application/modules/feedback/img/small-stars.png) no-repeat 0px -23px',
            liveStarBackground: 'url(<?php echo $root; ?>/application/modules/feedback/img/small-stars.png) no-repeat 0px 0px'
        });

        $('#feedback_value').tothestars({
            startAt: <?php echo $rating->fbr_cost_value; ?>,
            deadStarBackground: 'url(<?php echo $root; ?>/application/modules/feedback/img/small-stars.png) no-repeat 0px -23px',
            liveStarBackground: 'url(<?php echo $root; ?>/application/modules/feedback/img/small-stars.png) no-repeat 0px 0px'
        });

        var services = <?php echo $feedback[0]->fb_services; ?>;
        
        $('.service').each(function(){
            if(services.indexOf($(this).attr('id')) >= 0){
                $(this).attr('checked', 'checked').checkboxradio('refresh');;
                $(this).attr('data-checked', 'checked');
            }
        });
        
    });

</script>
	
<!-- End of File -->