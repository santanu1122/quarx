<?php

    /*
     * Filename:   blog.php
     * Location:   /application/views/blog
     */

    $js = array("application/modules/blog/js/blog.js");
    $this->carabiner->group("blog-js", array('js'=>$js));

    ?>

<!-- Dialogs -->

<div id="dialog-cat" class="dialogBox" title="Delete Confirmation">
    <p>Are you sure you want to delete this category?</p>
</div>

<div id="dialog-confirm" class="dialogBox" title="Delete Confirmation">
    <p>Are you sure you want to delete this entry?</p>
</div>

<div id="dialog-archive" class="dialogBox" title="Archive Confirmation">
    <p>Are you sure you want to archive this entry?</p>
</div>

<div id="dialog-display" class="dialogBox" title="Publish Confirmation">
    <p>Are you sure you want to publish this entry?</p>
</div>

<!-- Main Page -->

<div class="quarx-device">

    <div class="raw100">
        <div class="raw49 raw-left">
            <a href="#" data-role="button" onclick="showMenu()">Blog Menu</a>
        </div>
        <div class="raw2 raw-left raw-block-10"></div>
        <div class="raw49 raw-left">
            <?= $this->image_tools->imageLibraryButton("Image Library"); ?>
        </div>
    </div>

    <div class="raw65 raw-left">
        <div id="BlogEntries" class="raw100 raw-left">

            <div class="raw100 raw-left raw-margin-bottom-15 raw-margin-top-5">
                <div class="raw49 raw-left">
                    <input type="text" id="blogName" name="blog_title" value="<?= htmlspecialchars($blog->blog_title); ?>" />
                </div>
                <div class="raw3 raw-left raw-block-10"></div>
                <div class="raw48 raw-left">
                    <input id="blogDate" type="date" name="blog_date" data-role="datebox" data-options='{"fixDateArrays": true, "blackDates":["2012-1-2","2012-01-04"], "mode": "calbox", "useNewStyle": true}' value="<?= $blog->blog_date; ?>" />
                </div>

                <div class="raw100 raw-left raw-margin-top-5">
                    <select id="catOptions" data-theme="a" name="blog_cat">
                    <!-- // options are fed via ajax -->
                    </select>
                </div>
            </div>
            <div class="raw100 raw-left">
                <textarea id="blogEntry" class="rtf" name="entry"><?= $blog->blog_entry; ?></textarea>
            </div>

            <div class="raw100 raw-left">
            <?= $this->image_tools->imageLibrarySelect(); ?>
            </div>

            <div id="SubmitBtnBox" class="raw100 raw-left">
                <button id="addEntryButtonBox" data-theme="d" onclick="updateEntry(<?= $blog->blog_id; ?>)">Save Changes</button>
            </div>

        </div>

        <div class="raw100 raw-left">
            <?php if($blog->blog_publish == 0){ ?>
            <div class="raw49 raw-left">
            <button data-theme="c" onclick="publishEntry('<?= $this->crypto->encrypt($blog->blog_id); ?>')">Publish</button>
            <?php }else{ ?>
            <button  data-theme="b" onclick="archiveEntry('<?= $this->crypto->encrypt($blog->blog_id); ?>')">Archive</button>
            <?php } ?>
            </div>
            <div class="raw2 raw-left raw-block-10"></div>
            <div class="raw49 raw-left">
            <button  data-theme="e" onclick="deleteConfirm('<?= $this->crypto->encrypt($blog->blog_id); ?>')">Delete</button>
            </div>
        </div>

    </div>

    <div class="raw2 raw-left raw-block-10"></div>

    <div class="raw33 raw-left blog-category-container">
        <h2>Blog Categories</h2>
        <div class="raw70 raw-left">
            <input id="add_category" type="text" name="category" class="deefault" data-deefault="Category Name" />
        </div>
        <div class="raw5 raw-left raw-block-10"></div>
        <div class="raw25 raw-left plusBtn">
            <button class="raw-right" onclick="addCategory()" data-mini="true" data-icon="plus">Add</button>
        </div>
        <div id="view_cats" class="raw100 raw-left align-left raw-margin-top-20">
        </div>
    </div>

</div>

<script type="text/javascript">

    _catOption = '<?= $blog->blog_cat; ?>';

</script>

<?php $this->carabiner->display("blog-js"); ?>

<?php //End of file ?>