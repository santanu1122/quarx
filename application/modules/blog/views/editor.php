<?php /*
    Filename:   blog.php
    Location:   /application/views/blog
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

<div id="dialog-confirm" class="dialogBox" title="Delete Confirmation">
    <p>Are you sure you want to delete this entry?</p>
</div>

<div id="dialog-archive" class="dialogBox" title="Archive Confirmation">
    <p>Are you sure you want to archive this entry?</p>
</div>

<div id="dialog-display" class="dialogBox" title="Display Confirmation">
    <p>Are you sure you want to display this entry?</p>
</div>

<!-- Main Page -->

<div class="device">

    <div class="raw100">
        <a href="#" data-role="button" onclick="showMenu()">Blog Menu</a>
    </div>

    <div class="raw100">
        <a href="#imageLibrary" data-role="button" data-theme="d">Image Library</a>
    </div>

    <div class="raw66">
        <div class="raw100">
            <div id="BlogEntries" class="wide_box align-left wide90">
                
                <div class="raw100">
                    <div class="raw50">
                        <div class="pad15">
                            <input type="text" id="blogName" name="blog_title" value="<?php echo htmlspecialchars($blog->blog_title); ?>" />
                        </div>
                    </div>
                    <div class="raw50">
                        <div class="pad15">
                            <input id="blogDate" type="date" name="blog_date" data-role="datebox" data-options='{"fixDateArrays": true, "blackDates":["2012-1-2","2012-01-04"], "mode": "calbox", "useNewStyle": true}' value="<?php echo $blog->blog_date; ?>" />
                        </div>
                    </div>
                    
                    <div class="raw100">
                        <select id="catOptions" data-theme="a" name="blog_cat">
                        <!-- // options are fed via ajax -->
                        </select>
                    </div>
                </div>
                <div class="raw100 tall">
                    <textarea id="blogEntry" class="rtf" name="entry"><?php echo $blog->blog_entry; ?></textarea>
                </div>

                <?php echo imgLibrarySelect(); ?>

                <div id="SubmitBtnBox" class="raw100">
                    <button id="addEntryButtonBox" data-theme="c" onclick="updateEntry(<?php echo $blog->blog_id; ?>)">Update Entry</button>
                </div>

            </div>

            <div class="raw100">
                <?php if($blog->blog_hide === '1'){ ?>
                <button data-theme="c" onclick="displayEntry('<?php echo encrypt($blog->blog_id); ?>')">Display</button>
                <?php }else{ ?>
                <button  data-theme="b" onclick="archiveEntry('<?php echo encrypt($blog->blog_id); ?>')">Archive</button>
                <?php } ?>
                <button  data-theme="e" onclick="deleteConfirm('<?php echo encrypt($blog->blog_id); ?>')">Delete</button>
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
                <button onclick="addCategory()" data-iconpos="notext" data-icon="plus"></button>
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
        var upblogName = $("#blogName").val(),
            upblogDate = $("#blogDate").val(),
            upcatOptions = $("#catOptions").val(),
            upblogEntry = $("#blogEntry").val();

        if(catOptions === ''){
            alert('Sorry we need more information.');
        }else{
            $.ajax({
                url: "<?php echo site_url('blog/blog/update_entry'); ?>",
                type: 'POST',
                cache: false,
                data: {
                    blog_id: id,
                    blog_name: upblogName, 
                    blog_cat: upcatOptions,
                    blog_date: upblogDate,
                    blog_entry: upblogEntry,
                    <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function(data) {
                    $("#entryUpdated").fadeIn();
                    setTimeout(function(){ $("#entryUpdated").fadeOut(); }, 1500);
                }
            });
        }
    }

/* Category Functions
***************************************************************/

    function getCategories() {        
        $.ajax({
            url: "<?php echo site_url('blog/blog_categories/view'); ?>",
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
            url: "<?php echo site_url('blog/blog_categories/options'); ?>",
            type: 'GET',
            cache: false,
            dataType: 'html',
            success: function(data) {
                $("#catOptions").html('<option value="<?php echo $blog->blog_cat; ?>">Currently: <?php echo getCatName($blog->blog_cat); ?></option>'+data).selectmenu('refresh', true);
            }
        });
    }

    function addCategory() {
        var cat = $('#add_category').val();
        
        $.ajax({
            url: "<?php echo site_url('blog/blog_categories/check_title'); ?>",
            type: 'POST',
            cache: false,
            data: { cat_name: cat, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>' },
            success: function(data) {
                if(data == 'success'){
                    $.ajax({
                        url: "<?php echo site_url('blog/blog_categories/add'); ?>",
                        type: 'POST',
                        cache: false,
                        data: { cat_name: cat, <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>' },
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
                        url: "<?php echo site_url('blog/blog_categories/delete'); ?>",
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

/* Entry Actions
***************************************************************/

    function deleteConfirm(id){    
        $( "#dialog-confirm" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location="<?php echo site_url('blog/delete_entry').'/'; ?>"+id; 
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
                    window.location="<?php echo site_url('blog/archive_this_entry').'/'; ?>"+id; 
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
                    window.location="<?php echo site_url('blog/display_this_entry').'/'; ?>"+id; 
                },
                Cancel: function() {
                    dialogDestroy('#dialog-display');
                }
            }
        });
    }

/* Page Functions
***************************************************************/
    
    $(document).ready(function(e) {
        getCategories();
        getCatOptions();

        $('#blogName').one('click', function(){
            $(this).val('');
        });
    });

</script>
    
<?php //End of file ?>