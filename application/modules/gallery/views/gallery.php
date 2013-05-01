<?php /*
    Filename:   gallery.php
    Location:   /application/views/gallery
*/ ?>

<!-- Notices -->

<div id="entryUpdated" class="updateBox">
    <p>Your update was successful!</p>
</div>

<div id="entryAdded" class="updateBox">
    <p>Your entry was successfully added!</p>
</div>

<div id="entryFailed" class="errorBox">
    <p>Sorry, adding this entry failed. Are you sure you don't have an entry with the same title?</p>
</div>

<div id="catFailed" class="errorBox">
    <p>Sorry, adding this category failed. Are you sure you don't have a category with the same title?</p>
</div>

<!-- Dialogs -->

<div id="dialog-cat" class="dialogBox" title="Delete Confirmation">
    <p>Are you sure you want to delete this category?</p>
</div>

<div id="dialog-oops" class="dialogBox" title="Oops!">
    <p>Sorry, but you can't delete a category that has entries :(</p>
</div>

<div id="dialog-parent" class="dialogBox" title="Add Parent Category">
    <div class="dialogbox_body">
        <select id="catParentOptions" data-theme="a" name="parent_cat">
        <!-- // options are fed via ajax -->
        </select>
    </div>
</div>

<!-- Main Page -->

<div class="device">

    <div class="raw100">
        <a href="#" data-role="button" onclick="showMenu()">Gallery Menu</a>
    </div>

    <div class="raw100">
        <a href="#imageLibrary" data-role="button" data-theme="d">Image Library</a>
    </div>

    <div class="raw66">
        <div class="raw100">
            <div id="GalleryEntries" class="wide_box align-left wide90">
                
                <div class="raw100">
                    <div class="raw50">
                        <div class="pad15">
                            <input type="text" id="galleryName" name="gallery_title" value="Entry Title" />
                        </div>
                    </div>
                    <div class="raw50">
                        <div class="pad15">
                            <input id="galleryDate" type="date" name="gallery_date" data-role="datebox" data-options='{"fixDateArrays": true, "blackDates":["2012-1-2","2012-01-04"], "mode": "calbox", "useNewStyle": true}' />
                        </div>
                    </div>
                    
                    <div class="raw100">
                        <select id="catOptions" data-theme="a" name="gallery_cat">
                        <!-- // options are fed via ajax -->
                        </select>
                    </div>
                </div>
                <div class="raw100 tall">
                    <textarea id="galleryEntry" class="rtf" name="entry"></textarea>
                </div>

                <?php echo imgLibrarySelect(); ?>

                <div id="SubmitBtnBox" class="raw100">
                    <button id="addEntryButtonBox" data-theme="c" onclick="addEntry()">Add Entry</button>
                </div>

            </div>    

        </div>
        
    </div>

    <div class="raw33">
        <div class="pad15 form">
            <h2>Categories</h2>
            <div class="raw75">
                <input id="add_category" type="text" name="category" value="Add a Category" onfocus="this.value=''" />
            </div>
            <div class="raw25 plusBtn">
                <button onclick="addCategoryParent()" data-iconpos="notext" data-icon="plus"></button>
            </div>
            <div id="view_cats" class="raw100 align-left" style="margin-top: 20px;">
        </div>
        
        </div>
    </div>

</div>

<script type="text/javascript">

/* Entry Functions
***************************************************************/

    function updateEntry(id) {
        var upgalleryName = $("#galleryName").val(),
            upgalleryDate = $("#galleryDate").val(),
            upcatOptions = $("#catOptions").val(),
            upgalleryEntry = $("#galleryEntry").val(),
            upgalleryLibrary = $('#selectLibrary-Collections').val();

        if(catOptions === ''){
            alert('Sorry we need more information.');
        }else{
            $.ajax({
                url: "<?php echo site_url('gallery/gallery/update_entry'); ?>",
                type: 'POST',
                cache: false,
                data: {
                    gallery_id: id,
                    gallery_name: upgalleryName, 
                    gallery_cat: upcatOptions,
                    gallery_date: upgalleryDate,
                    gallery_entry: upgalleryEntry,
                    gallery_img_library: upgalleryLibrary,
                    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function(data) {
                    $("#entryUpdated").fadeIn();
                    setTimeout(function(){ $("#entryUpdated").fadeOut(); }, 1500);
                }
            });
        }
    }

    function addEntry() {
        var galleryName = $("#galleryName").val(),
            galleryDate = $("#galleryDate").val(),
            catOptions = $("#catOptions").val(),
            galleryEntry = $("#galleryEntry").val(),
            galleryLibrary = $('#selectLibrary-Collections').val();

        if(catOptions === ''){
            alert('Sorry we need more information.');
        }else{
            $.ajax({
                url: "<?php echo site_url('gallery/gallery/add_entry'); ?>",
                type: 'POST',
                cache: false,
                data: { 
                    gallery_name: galleryName, 
                    gallery_cat: catOptions,
                    gallery_date: galleryDate,
                    gallery_entry: galleryEntry,
                    gallery_img_library: galleryLibrary,
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

    function modeSwitch(id) {
        $("#addEntryButtonBox").attr('onclick', 'updateEntry('+id+')');
        $("#addEntryButtonBox").siblings('.ui-btn-inner').children('.ui-btn-text').text("Update Entry");
    }

/* Category Functions
***************************************************************/

    function getCategories() {        
        $.ajax({
            url: "<?php echo site_url('gallery/gallery_categories/view'); ?>",
            type: 'GET',
            cache: false,
            dataType: 'html',
            success: function(data) {
                $("#view_cats").html(data).trigger('create');
            }
        });
    }

    function getCatOptions() {        
        $.ajax({
            url: "<?php echo site_url('gallery/gallery_categories/options'); ?>",
            type: 'GET',
            cache: false,
            dataType: 'html',
            success: function(data) {
                $("#catOptions").html(data).selectmenu('refresh', true);
                getCatParentOptions();
            }
        });
    }

    function getCatParentOptions() {        
        $.ajax({
            url: "<?php echo site_url('gallery/gallery_categories/parent_options'); ?>",
            type: 'GET',
            cache: false,
            dataType: 'html',
            success: function(data) {
                $("#catParentOptions").html(data).selectmenu('refresh', true);
            }
        });
    }

    function addCategoryParent(){
        $( "#dialog-parent" ).dialogboxInput({
            buttons: {
                Ok: function() {
                    var parent = $('#catParentOptions').val();
                    console.log(parent);
                    addCategory(parent);
                    inputDialogDestroy( "#dialog-parent" );
                },
                Cancel: function() {
                    inputDialogDestroy( "#dialog-parent" );
                }
            }
        });
    }

    function addCategory(parent) {
        var cat = $('#add_category').val(), parentCat;
        if(parent == null){
            parentCat = 0;
        }else{
            parentCat = parent;
        }
        
        $.ajax({
            url: "<?php echo site_url('gallery/gallery_categories/check_title'); ?>",
            type: 'POST',
            cache: false,
            data: { cat_name: cat, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>' },
            success: function(data) {
                if(data == 'success'){
                    $.ajax({
                        url: "<?php echo site_url('gallery/gallery_categories/add'); ?>",
                        type: 'POST',
                        cache: false,
                        data: { cat_name: cat, cat_parent: parentCat, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>' },
                        success: function(data) {
                            getCatOptions();
                            getCategories();
                            $('#add_category').val('');
                        }
                    });
                }else{
                    $("#catFailed").fadeIn();
                    setTimeout(function(){ $("#catFailed").fadeOut(); }, 3500);
                }
            }
        });
    }

    function deleteCat(id){
        $( "#dialog-cat" ).dialogbox({
            buttons: {
                Ok: function() {
                    $.ajax({
                        url: "<?php echo site_url('gallery/gallery_categories/delete'); ?>",
                        type: 'POST',
                        cache: false,
                        data: { cat_id: id, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>' },
                        success: function(data) {
                            if(data == 'success'){
                                getCategories();
                                getCatOptions();
                                dialogDestroy( "#dialog-cat" );    
                            }else{
                                dialogDestroy( "#dialog-cat" );
                                oops();
                            }
                            
                        }
                    });
                },
                Cancel: function() {
                    dialogDestroy( "#dialog-cat" );
                }
            }
        });
    }

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

/* Page Functions
***************************************************************/
    
    $(document).ready(function(e) {
        getCategories();
        getCatOptions();

        $('#galleryName').one('click', function(){
            $(this).val('');
        });
    });

</script>
    
<?php //End of file ?>