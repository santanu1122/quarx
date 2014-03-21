<?php /*
    Filename:   usedEq.php
    Location:   /application/views/usedEq
*/ ?>

<!-- Notices -->

<div id="entryFailed" class="error-box">
    <p>Sorry, adding this entry failed. Are you sure you don't have an entry with the same title?</p>
</div>

<!-- Main Page -->

<div class="quarx-device">

    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('gallery/add_entry'); ?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

        <div class="raw100">
            <div class="raw50">
                <div class="raw-padding-5">
                    <a href="#" data-role="button" onclick="showMenu()">Gallery Menu</a>
                </div>
            </div>
            <div class="raw50">
                <div class="raw-padding-5">
                    <input type="file" name="userfile" />
                </div>
            </div>
        </div>

        <div class="raw100">
            <div class="raw100">
                <div id="Manual" class="raw100">
                    
                    <div class="raw100">
                        <div class="raw33">
                            <input type="text" class="deefault" id="galleryName" name="gallery_name" data-deefault="Product Name" />
                        </div>
                        <div class="raw1 raw-block-10"></div>
                        <div class="raw32">
                            <input type="text" class="deefault" id="galleryProductCode" name="gallery_product_code" data-deefault="Product Code" />
                        </div>
                        <div class="raw1 raw-block-10"></div>
                        <div class="raw33">
                            <input type="text" class="deefault" id="gallerySerialNumber" name="gallery_serial_number" data-deefault="Serial Number" />
                        </div>
                    </div>
                    <div class="raw100 tall">
                        <div class="raw56">
                            <textarea id="galleryEntry" class="rtf" name="gallery_entry"></textarea>
                        </div>
                        <div class="raw1 raw-block-10"></div>
                        <div id="manualBox" class="raw43">
                            <button id="addManual">Add Manual</button>
                        </div>
                    </div>

                    <div id="SubmitBtnBox" class="raw100">
                        <button type="submit" data-theme="c">Add Product Gallery</button>
                    </div>

                </div>    

            </div>
            
        </div>

    </form>

</div>

<script type="text/javascript">

/* Page Functions
***************************************************************/
    
    var fnum = 0;

    $(document).ready(function(e) {
        $("#addManual").click(function(e){
            e.preventDefault();
            $("#manualBox").append('<div class="raw50"><input type="file" name="file_'+fnum+'" /></div><div class="raw1 raw-block-10"></div><div class="raw49"><input name="file_name_'+fnum+'" type="text" /></div>').trigger('create');
            fnum++;
        });

        <?php if($this->session->flashdata('error') > ''){ ?>
            $("#entryFailed").fadeIn().delay(2500).fadeOut();
        <?php } ?>
        $('.deefault').deefault();
    });

</script>
    
<?php //End of file ?>