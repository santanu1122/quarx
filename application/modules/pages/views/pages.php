<?php /*
    Filename:   pages.php
    Location:   /views
*/ ?>

<!-- Notices -->

<div id="entryUpdated" class="success-box">
    <p>Your update was successful!</p>
</div>

<div id="entryAdded" class="success-box">
    <p>Your entry was successfully added!</p>
</div>

<div id="entryFailed" class="error-box">
    <p>Sorry, adding this entry failed. Are you sure you don't have an entry with the same title?</p>
</div>

<div id="catFailed" class="error-box">
    <p>Sorry, adding this category failed. Are you sure you don't have a category with the same title?</p>
</div>

<!-- Dialogs -->

<div id="dialog-cat" class="dialogBox" title="Delete Confirmation">
    <p>Are you sure you want to delete this category?</p>
</div>

<div id="dialog-oops" class="dialogBox" title="Oops!">
    <p>Sorry, but you can't delete a category that has entries :(</p>
</div>

<!-- Main Page -->

<div class="quarx-device">

    <div class="raw100">
        <a href="#" data-role="button" onclick="showMenu()">Pages Menu</a>
    </div>

    <div class="raw100">
        <?php echo imageGalleryButton(); ?>
    </div>

    <div class="raw100">
        <div id="PageEntries" class="align-left">
            
            <div class="raw100">

                <div class="raw100">
                    <div class="pad15">
                        <input type="text" id="pagesName" name="pages_title" data-deefault="Page Title" />
                    </div>
                </div>
                
                <div class="raw100">
                    <select id="parentOptions" data-theme="a" name="pages_parent">
                    <!-- // options are fed via ajax -->
                    </select>
                </div>

            </div>
            <div class="raw100 tall">
                <textarea id="pagesEntry" class="rtf" name="entry"></textarea>
            </div>

            <?php echo imgLibrarySelect(null, "img_lib"); ?>

            <div id="SubmitBtnBox" class="raw100">
                <button id="addEntryButtonBox" data-theme="c" onclick="addEntry()">Add Entry</button>
            </div>

        </div>    

    </div>

</div>

<script type="text/javascript">

/* Entry Functions
***************************************************************/

    function addEntry() {
        var pagesName = $("#pagesName").val(),
            parentOptions = $("#parentOptions").val(),
            pagesEntry = $("#pagesEntry").val(),
            pages_img_library = $('#img_lib').val();

        if(parentOptions === ''){
            alert('Sorry we need more information.');
        }else{
            $.ajax({
                url: "<?php echo site_url('pages/add_entry'); ?>",
                type: 'POST',
                cache: false,
                data: { 
                    page_name: pagesName, 
                    page_parent: parentOptions,
                    page_entry: pagesEntry,
                    page_img_library: pages_img_library,
                    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function(data) {
                    if(data == 'duplicate title'){
                        $("#entryFailed").fadeIn();
                        setTimeout(function(){ $("#entryFailed").fadeOut(); }, 2500);
                    }else{
                        modeSwitch(data);
                        $("#entryAdded").fadeIn();
                        setTimeout(function(){ $("#entryAdded").fadeOut(); }, 1500);
                    }
                }
            });
        }
    }

    function updateEntry(id) {
        var uppagesName = $("#pagesName").val(),
            upparentOptions = $("#parentOptions").val(),
            uppagesEntry = $("#pagesEntry").val(),
            uppages_img_library = $('#img_lib').val();

        if(upparentOptions === ''){
            alert('Sorry we need more information.');
        }else{
            $.ajax({
                url: "<?php echo site_url('pages/update_entry'); ?>",
                type: 'POST',
                cache: false,
                data: {
                    page_id: id,
                    page_name: uppagesName, 
                    page_parent: upparentOptions,
                    page_entry: uppagesEntry,
                    page_img_library: uppages_img_library,
                    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function(data) {
                    $("#entryUpdated").fadeIn();
                    setTimeout(function(){ $("#entryUpdated").fadeOut(); }, 1500);
                }
            });
        }
    }

    function modeSwitch(id) {
        $("#addEntryButtonBox").attr('onclick', 'updateEntry('+id+')');
        $("#addEntryButtonBox").siblings('.ui-btn-inner').children('.ui-btn-text').text("Update Entry");
    }

/* Parent Functions
***************************************************************/

    function getParentOptions() {
        $.ajax({
            url: "<?php echo site_url('pages/options'); ?>",
            type: 'GET',
            cache: false,
            dataType: 'html',
            success: function(data) {
                $("#parentOptions").html(data).selectmenu('refresh', true);
            }
        });
    }

/* Page Functions
***************************************************************/
    
    $(document).ready(function(e) {
        getParentOptions();

        $('#pagesName').deefault();
    });

</script>
    
<?php //End of file ?>