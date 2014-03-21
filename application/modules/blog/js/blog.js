_catOption = typeof _catOption !== 'undefined' ? _catOption : 'null';


/* Entry Functions
***************************************************************/

    function saveEntry() {
        var blogName = $("#blogName").val(),
            blogDate = $("#blogDate").val(),
            catOptions = $("#catOptions").val(),
            blogEntry = $("#blogEntry").val(),
            blog_img_library = $('#selectLibrary-Collections').val();

        if(catOptions === ''){
            quarxNotify('Oops', 'Your missing a name, category or entry. Not much to save here.');
            return false;
        }else{
            $.ajax({
                url: _quarxRootURL+"blog/add_entry",
                type: 'POST',
                cache: false,
                data: {
                    blog_name: blogName,
                    blog_cat: catOptions,
                    blog_date: blogDate,
                    blog_entry: blogEntry,
                    blog_img_library: blog_img_library,
                    q_csrf_token: _quarxSecurityHash
                },
                success: function(data) {
                    if(data == 'duplicate title'){
                        quarxNotify('Oops', 'You may have an entry with the same title.');
                    }else{
                        modeSwitch(data);
                        quarxNotify('Success', 'Your entry has now been saved.');
                    }
                }
            });
        }
    }

    function updateEntry(id) {
        var upblogName = $("#blogName").val(),
            upblogDate = $("#blogDate").val(),
            upcatOptions = $("#catOptions").val(),
            upblogEntry = $("#blogEntry").val(),
            upblog_img_library = $('#quarx-select-library-collections').val();

        if (catOptions === '') {
            quarxNotify('Oops', 'Your missing a name, category or entry. Not much to save here.');
            return false;
        } else {
            $.ajax({
                url: _quarxRootURL+"blog/update_entry",
                type: 'POST',
                cache: false,
                data: {
                    blog_id: id,
                    blog_name: upblogName,
                    blog_cat: upcatOptions,
                    blog_date: upblogDate,
                    blog_entry: upblogEntry,
                    blog_img_library: upblog_img_library,
                    q_csrf_token: _quarxSecurityHash
                },
                success: function(data) {
                    quarxNotify('Success', 'Your entry changes have been saved.');
                }
            });
        }
    }

    function modeSwitch(id) {
        $("#addEntryButtonBox").attr('onclick', 'updateEntry('+id+')');
        $("#addEntryButtonBox").siblings('.ui-btn-inner').children('.ui-btn-text').text("Update Entry");
        $("#SubmitBtnBox").append("<button onclick='publishEntry("+id+")'>Publish Entry</button>").trigger("create");
    }

    function getCategories() {
        $.ajax({
            url: _quarxRootURL+"blog/blog_categories/view",
            type: 'GET',
            cache: false,
            dataType: 'html',
            success: function(data) {
                $("#view_cats").html(data).trigger('create');
            }
        });
    }

    function getCatOptions(id) {
        $.ajax({
            url: _quarxRootURL+"blog/blog_categories/options/"+id,
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

        if (cat == "" || cat == "Category Name") {
            return false;
        }

        $.ajax({
            url: _quarxRootURL+"blog/blog_categories/check_title",
            type: 'POST',
            cache: false,
            data: { cat_name: cat, q_csrf_token: _quarxSecurityHash },
            success: function(data) {
                if (data == 'success') {
                    $.ajax({
                        url: _quarxRootURL+"blog/blog_categories/add",
                        type: 'POST',
                        cache: false,
                        data: { cat_name: cat, q_csrf_token: _quarxSecurityHash },
                        success: function(data) {
                            getCatOptions();
                            getCategories();
                            $('#add_category').val('');
                        }
                    });
                } else {
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
                        url: _quarxRootURL+"blog/blog_categories/delete/blog",
                        type: 'POST',
                        cache: false,
                        data: { cat_id: id, q_csrf_token: _quarxSecurityHash },
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

    function deleteConfirm(id){
        $( "#dialog-confirm" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location = _quarxRootURL+"blog/delete_entry/"+id;
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
                    window.location = _quarxRootURL+"blog/archive_entry/"+id;
                },
                Cancel: function() {
                    dialogDestroy('#dialog-archive');
                }
            }
        });
    }

    function publishEntry(id){
        $( "#dialog-display" ).dialogbox({
            buttons: {
                Ok: function() {
                    window.location = _quarxRootURL+"blog/publish_entry/"+id;
                },
                Cancel: function() {
                    dialogDestroy('#dialog-display');
                }
            }
        });
    }

    $(document).ready(function(e) {
        getCategories();
        getCatOptions(_catOption);
    });