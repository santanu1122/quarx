<?php /*
    Filename:   editor.php
    Location:   /application/modules/gallery/views/
*/ ?>

<!-- Notices -->

<div id="entryUpdated" class="success-box">
    <p>Your update was successful!</p>
</div>

<div id="entryFailed" class="error-box">
    <p>Sorry, adding this entry failed. Are you sure you don't have an entry with the same title?</p>
</div>

<!-- Dialogs -->

<div id="dialog-confirm" class="dialogBox" title="Delete Confirmation">
    <p>Are you sure you want to delete this product?</p>
</div>

<div id="dialog-manual-confirm" class="dialogBox" title="Delete Manual Confirmation">
    <p>Are you sure you want to delete this manual?</p>
</div>

<div id="dialog-archive" class="dialogBox" title="Archive Confirmation">
    <p>Are you sure you want to archive this product?</p>
</div>

<div id="dialog-display" class="dialogBox" title="Display Confirmation">
    <p>Are you sure you want to display this product?</p>
</div>

<!-- Main Page -->

<div class="quarx-device">

    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('gallery/update_entry/'.$id); ?>">
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
            <div class="raw70">
                <div id="Manual" class="raw100">
                    
                    <div class="raw100">
                        <div class="raw33">
                            <input type="text" id="galleryName" name="gallery_name" value="<?php echo htmlspecialchars($m->gallery_name); ?>" />
                        </div>
                        <div class="raw1 raw-block-10"></div>
                        <div class="raw32">
                            <input type="text" id="galleryProductCode" name="gallery_product_code" value="<?php echo htmlspecialchars($m->gallery_product_code); ?>" />
                        </div>
                        <div class="raw1 raw-block-10"></div>
                        <div class="raw33">
                            <input type="text" id="gallerySerialNumber" name="gallery_serial_number" value="<?php echo htmlspecialchars($m->gallery_serial_number); ?>" />
                        </div>
                    </div>
                    <div class="raw100 tall">
                        <textarea id="galleryEntry" class="rtf" name="gallery_entry"><?php echo $m->gallery_entry; ?></textarea>
                    </div>

                </div>
            </div>

            <div class="raw30">
                <div class="raw-padding-15">
                    <img class="raw100" alt="" src="<?php echo $m->gallery_img; ?>" />
                </div>
            </div>
        </div>

        <div class="raw100">
            <div class="raw49">
                <p class="sub-title">Gallery</p>

                <?php $i = 1; ?>
                <?php foreach ($gallery as $file) : ?>
                    <div class="raw100 border-bottom">
                        <div class="raw90">
                            <a class="manual-listing" target="_blank" href="<?php echo $file->manual_file_location; ?>"><?php echo $file->manual_file_name; ?></a>
                        </div>
                        <div class="raw10">
                            <a class="raw-right delete-button" onclick="deleteManualConfirm('<?php echo encrypt($file->manual_file_id); ?>', '<?php echo $m->gallery_id; ?>')" data-iconpos="notext" data-role="button" data-icon="delete"></a>
                        </div>
                    </div>
                    <?php $i++; ?>
                <?php endforeach; ?>
           
            </div>
            <div class="raw1 raw-block-100"></div>
            <div id="manualBox" class="raw50">
                <button id="addManual">Add Manual</button>
            </div>
        </div>

        <div class="raw100">
            <div id="SubmitBtnBox" class="raw100">
                <button id="addEntryButtonBox" type="submit" data-theme="c">Update Entry</button>
            </div>
        </div>

    </form>

    <div class="raw100">
        <?php if($m->gallery_hide === '1'){ ?>
        <button data-theme="c" onclick="displayEntry('<?php echo encrypt($m->gallery_id); ?>')">Display</button>
        <?php }else{ ?>
        <button  data-theme="b" onclick="archiveEntry('<?php echo encrypt($m->gallery_id); ?>')">Archive</button>
        <?php } ?>
        <button  data-theme="e" onclick="deleteConfirm('<?php echo encrypt($m->gallery_id); ?>')">Delete</button>
    </div> 

</div>

<script type="text/javascript">

    var fnum = 0;

    $(document).ready(function(){
        $(".delete-button").click(function(e){
            e.preventDefault();
        });

        $("#addManual").click(function(e){
            e.preventDefault();
            $("#manualBox").append('<div class="raw50"><input type="file" name="file_'+fnum+'" /></div><div class="raw1 raw-block-10"></div><div class="raw49"><input name="file_name_'+fnum+'" type="text" /></div>').trigger('create');
            fnum++;
        });
    });

/* Entry Functions
***************************************************************/

    <?php if($this->session->flashdata('success')){ ?>
        $("#entryUpdated").fadeIn().delay(2500).fadeOut();
    <?php } ?>

    <?php if($this->session->flashdata('error')){ ?>
        $("#entryError").fadeIn().delay(2500).fadeOut();
    <?php } ?>

    function oops(){
        $( "#dialog-oops" ).dialogbox({
            buttons: {
                Ok: function() {
                    dialogDestroy( "#dialog-oops" );
                },
                Cancel: false
            }
        });
    }

/* Entry Actions
***************************************************************/

    function deleteManualConfirm(id, itemId){    
        $( "#dialog-manual-confirm" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('gallery/delete_manual').'/'; ?>"+id+'/'+itemId; 
                },
                Cancel: function() {
                    dialogDestroy('#dialog-manual-confirm');
                }
            }
        });
    }

    function deleteConfirm(id){    
        $( "#dialog-confirm" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('gallery/delete_entry').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy('#dialog-confirm');
                }
            }
        });
    }

    function archiveEntry(id){
        $( "#dialog-archive" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('gallery/archive_this_entry').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy('#dialog-archive');
                }
            }
        });
    }

    function displayEntry(id){    
        $( "#dialog-display" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('used/display_this_entry').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy('#dialog-display');
                }
            }
        });
    }

</script>
    
<?php //End of file ?>