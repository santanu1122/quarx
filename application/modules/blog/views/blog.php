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
                            <input type="text" id="blogName" name="blog_title" value="Entry Title" />
                        </div>
                    </div>
                    <div class="raw50">
                        <div class="pad15">
                            <input id="blogDate" type="date" name="blog_date" data-role="datebox" data-options='{"fixDateArrays": true, "blackDates":["2012-1-2","2012-01-04"], "mode": "calbox", "useNewStyle": true}' />
                        </div>
                    </div>
                    
                    <div class="raw100">
                        <select id="catOptions" data-theme="a" name="blog_cat">
                        <!-- // options are fed via ajax -->
                        </select>
                    </div>
                </div>
                <div class="raw100 tall">
                    <textarea id="blogEntry" class="rtf" name="entry"></textarea>
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
            upblogEntry = $("#blogEntry").val(),
            upblog_img_library = $('#selectLibrary-Collections').val();

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
                    blog_img_library: upblog_img_library,
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
        var blogName = $("#blogName").val(),
            blogDate = $("#blogDate").val(),
            catOptions = $("#catOptions").val(),
            blogEntry = $("#blogEntry").val(),
            blog_img_library = $('#selectLibrary-Collections').val();

        if(catOptions === ''){
            alert('Sorry we need more information.');
        }else{
            $.ajax({
                url: "<?php echo site_url('blog/blog/add_entry'); ?>",
                type: 'POST',
                cache: false,
                data: { 
                    blog_name: blogName, 
                    blog_cat: catOptions,
                    blog_date: blogDate,
                    blog_entry: blogEntry,
                    blog_img_library: blog_img_library,
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
                $("#catOptions").html(data).selectmenu('refresh', true);
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