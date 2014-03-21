<?php /*
    Filename:   generate_link.php
    Location:   /views
*/ ?>

<?php if(isMobile()) { ?>

<style type="text/css">

.raw32{
    width: 100%;
}

</style>

<?php } ?>

<!-- notifications -->

<div id="entryUpdated" class="updateBox">
    <p>Your update was successful!</p>
</div>

<div id="entryAdded" class="updateBox">
    <p>Your entry was successfully added!</p>
</div>

<div id="entryFailed" class="errorBox">
    <p>Sorry, adding this entry failed. Are you sure you don't have an entry with the same title?</p>
</div>

<!-- main content -->

<div class="device">

        <div id="FeedbackResult" class="notification">
            <div class="spacer raw15"></div>
            <div class="raw66">
                <h1>Success</h1>
                <div class="feedbackMsg">
                    <p id="keybox"></p>
                </div>
            </div>
        </div>

        <div class="raw100">
            <a href="#" data-role="button" onclick="showMenu()">Feedback Menu</a>
        </div>

        <div class="raw100">
            <h2>Generate a Feedback Link</h2>
        </div>

        <div id="Feedback" class="raw100">

        <form id="dummyForm">
            <div class="raw100">   
                <div class="raw49 input_box">
                    <input class="padded5" type="text" id="clientName" name="client_name" value="Client Name" />
                </div>
                <div class="spacer raw2"></div>
                <div class="raw49  input_box">
                    <input class="padded5" type="text" id="clientEmail" name="client_email" value="Client Email" />
                </div>
            </div> 
               
            <div class="raw100">
                <h3>Services</h3>
            </div> 

            <div class="raw100">
                <div class="raw32">
                    <input data-theme="a" class="service" id="doors" type="checkbox" value="doors" />
                    <label for="doors">Doors</label>
                </div>
                <div class="spacer raw2"></div>
                <div class="raw32">
                    <input data-theme="a" class="service" type="checkbox" id="windows" value="windows" />
                    <label for="windows">Windows</label>
                </div>
                <div class="spacer raw2"></div>
                <div class="raw32">
                    <input data-theme="a" class="service" type="checkbox" id="roofing" value="roofing" />
                    <label for="roofing">Roofing</label>
                </div>
            </div>
            <div class="raw100">
                <div class="raw32">
                    <input data-theme="a" class="service" type="checkbox" id="siding" value="siding" />
                    <label for="siding">Siding</label>
                </div>
                <div class="spacer raw2"></div>
                <div class="raw32">
                    <input data-theme="a" class="service" type="checkbox" id="insulation" value="insulation" />
                    <label for="insulation">Insulation</label>
                </div>
                <div class="spacer raw2"></div>
                <div class="raw32">
                    <input data-theme="a" class="service" type="checkbox" id="renovations" value="renovations" />
                    <label for="renovations">Renovations</label>
                </div>
            </div>

            <div class="raw100">
                <h3>Project Information</h3>
            </div> 

            <div class="raw100">
                <div class="raw50">
                    <p class="selectLabel">Choose Sales Rep</p>
                </div>
                <div class="raw50">
                    <select id="salesRep" name="salesRep">
                        <option value="Darrell Martin">Darrell Martin</option>
                        <option value="Rob Martin">Rob Martin</option>
                        <option value="Trevor Martin">Trevor Martin</option>
                        <option value="Karl Steckley">Karl Steckley</option>
                        <option value="Paul Fretz">Paul Fretz</option>
                        <option value="Tom Taylor">Tom Taylor</option>
                        <option value="Steve Gascho">Steve Gascho</option>
                        <option value="Doug Eby">Doug Eby</option>
                    </select>
                </div>
            </div>

            <div class="raw100">
                <div class="raw50">
                    <p class="selectLabel">Choose Jobsite Foreman</p>
                </div>
                <div class="raw50">
                    <select id="foreman" name="foreman">
                        <option value="Ken Martin">Ken Martin</option>
                        <option value="Toby Grigat">Toby Grigat</option>
                        <option value="Dennis Weber">Dennis Weber</option>
                        <option value="John Nighswander">John Nighswander</option>
                        <option value="Harold Lichty">Harold Lichty</option>
                        <option value="Terry Lachance">Terry Lachance</option>
                        <option value="Kevin Futher">Kevin Futher</option>
                        <option value="Nate Yutzy">Nate Yutzy</option>
                    </select>
                </div>
            </div>

            <div class="raw100">
                <button data-theme="c" id="genBtn" style="margin-top: 15px;" onclick="makeFBlink()">Generate Link</button>
            </div>

        </form>
    </div> 
    
</div>

<script type="text/javascript">

    $(document).ready(function(){
        $('#dummyForm').bind("submit", function(e){
            e.preventDefault();
        });

        $('.service').bind('click', function(){
            if($(this).attr('data-checked') > ''){
                $(this).removeAttr('data-checked');
            }else{
                $(this).attr('data-checked', 'checked');
            }
        });

        $('#FeedbackResult').hide();
    
        $('#clientName').one('click', function(){
            $(this).val('');
        });

        $('#clientEmail').one('click', function(){
            $(this).val('');
        });
    });

    function makeFBlink(){

        var ServicesList = new Array(),
            i = 0, s,
            clientName = $('#clientName').val(),
            clientEmail = $('#clientEmail').val(),
            salesRep = $('#salesRep').val(),
            foreman = $('#foreman').val(),
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

        $.ajax({
            url: "<?php echo site_url('feedback/generate_link'); ?>",
            type: 'POST',
            cache: false,
            data: { 
                client_name: clientName, 
                client_email: clientEmail,
                services: allServices,
                sales_rep: salesRep,
                foreman: foreman,
                <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            success: function(data) {
                var result = jQuery.parseJSON(data);

                if(result.success == 'true'){
                    $("#genBtn").fadeOut();
                    $("#keybox").html('You\'ve successfully generated and emailed the feedback link.');
                    $("#FeedbackResult").fadeIn();
                    setTimeout(function(){ window.location='<?php echo site_url("feedback"); ?>' }, 2000);
                }else{
                    $("#genBtn").fadeOut();
                    $("#keybox").html('Oops, there seems to have been an error, please try again.');
                    $("#FeedbackResult").fadeIn();
                    setTimeout(function(){ window.location='<?php echo site_url("feedback"); ?>' }, 2000);
                }
            }
        });

    }

// });

</script>
    
<?php //End of file ?>