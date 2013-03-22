<?php /*
    Filename:   content.php
    Location:   /application/views/
    Author:     Matt Lantz
*/ ?>

<style type="text/css">

.on{
    background: #006600;
    color: #fff;
    }
.off{
    background: #CC0000;
    color: #fff;
    }

</style>

<script type="text/javascript">

function setup(id, val, buttonNum){
    //No worries it will turn them on or off
    $.ajax({
        type: "GET",
        url: "<?php echo site_url('setup/activate'); ?>?id="+id+"&val="+val,
        success: function(){
            if(val == '1'){
                $('#on_'+buttonNum).css({
                    background: '#006600',
                    color: '#FFF'   
                    });
                $('#off_'+buttonNum).removeClass('off');
                $('#off_'+buttonNum).css({
                    background: '',
                    color: ''   
                    });
                }
            else{
                $('#off_'+buttonNum).css({
                    background: '#CC0000',
                    color: '#FFF'   
                    });
                $('#on_'+buttonNum).removeClass('on');  
                $('#on_'+buttonNum).css({
                    background: '',
                    color: ''   
                    });
                }
            }
        });
    }
    
</script>

<?php /*
// This is the most important file outside of the accounts based files. 
// The key here is that it enables the master user to enable and disable 
// all parts of the system. Ultimately leading to an easy to impliment 
// system. Quick to turn on and just as quick to turn off.
*/ ?>

<div class="wide_box">
    <?php if(isset($error)){ ?>
        <div style="border: #600 solid 1px; width: 500px; margin: 0 auto;">
            <p style="padding: 15px; color: #600;"><?php echo $error; ?></p>
        </div>  
    <?php } ?>

    <?php if($this->session->userdata('logged_in') && $this->session->userdata('permission') == 1){ ?>
        
        <div class="wide_box" style="text-align: center; min-height: 500px;">

            <div class="half_box centered">
                <br />
                <h1>Admin Setup</h1>
                <br />
                <p></p>

                <input class="padded10 roundcorners greyborder" value="Database Name" />
                
                <input class="padded10 roundcorners greyborder" value="Database Password" />

            </div>
        </div>
        
    <?php }else{ ?>
        
       <div class="wide_box" style="text-align: center; min-height: 500px;">
            <div style="padding: 40px;">
                <br />
                <br />
                <h3>We&rsquo;re Sorry</h3>
                <br />
                <p>It seems that your not logged in. Are you sure you have permission to be here?.</p>
                <br />
                <br />
                <br />
            </div>
        </div>
        </div>

    <?php } ?>
    
<?php /* End of File */ ?>