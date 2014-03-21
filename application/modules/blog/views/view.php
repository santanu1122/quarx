<?php

    /*
     * Filename:   view.php
     * Location:   /application/modules/blog/view
     */

    $js = array("application/modules/blog/js/blog.js");
    $this->carabiner->group("blog-js", array('js'=>$js));

    ?>

<!-- Dialogs -->

<div id="dialog-confirm" class="dialogBox" title="Delete Confirmation">
    <p>Are you sure you want to delete this entry?</p>
</div>

<div id="dialog-archive" class="dialogBox" title="Archive Confirmation">
    <p>Are you sure you want to archive this entry?</p>
</div>

<div id="dialog-display" class="dialogBox" title="Publish Confirmation">
    <p>Are you sure you want to publish this entry?</p>
</div>

<!-- Content -->

<div class="quarx-device">

    <div class="raw100 raw-left">
        <div class="raw49 raw-left">
            <a href="#" data-role="button" onclick="showMenu()">Blog Menu</a>
        </div>
        <div class="raw2 raw-left raw-block-10"></div>
        <div class="raw49 raw-left blog-search-box">
            <form id="SearchBox" method="post" action="<?= site_url('blog/search'); ?>">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                <input id="search" name="search" class="searchBar" data-deefault="Enter a Search Term" />
            </form>
        </div>
    </div>

    <div class="raw100 mHide">
        <div class="raw25 raw-left">
            <p><b>Title</b></p>
        </div>
        <div class="raw12 raw-left tHide">
            <p><b>Date</b></p>
        </div>
        <div class="raw13 raw-left">
            <p><b>Category</b></p>
        </div>
        <div class="raw50 raw-left">
            <p><b>Actions</b></p>
        </div>
    </div>


    <div class="raw100 raw-left entry-list">
    <?php

        foreach ($entries as $entry)
        {
            echo '<div class="raw100 raw-left entry-list-row">';
                echo '<div class="raw35 raw-left"><a href="'.site_url('blog/editor/'.$this->crypto->encrypt($entry->blog_id)).'">'.$this->tools->val_trim($entry->blog_title, 40).'</a></div>';
                echo '<div class="raw15 raw-left mHide tHide"><p>'.$this->tools->length_check($entry->blog_date).'</p></div>';
                echo '<div class="raw15 raw-left mHide"><p>'.$this->tools->length_check($this->blog_cat_tools->getCatName($entry->blog_cat)).'</p></div>';

                echo '<div class="raw10 raw-left mHide"><button data-theme="d" data-mini="true" onclick="window.location=\''.site_url('blog/editor/'.$this->crypto->encrypt($entry->blog_id)).'\'">Edit</button></div>';
                echo '<div class="raw1 raw-left raw-block-10"></div>';

                if ($entry->blog_publish == 0) echo '<div class="raw8 raw-left mHide"><button data-theme="c" data-mini="true" onclick="publishEntry(\''.$this->crypto->encrypt($entry->blog_id).'\')">Publish</button></div>';
                else echo '<div class="raw9 raw-left mHide"><button data-theme="b" data-mini="true" onclick="archiveEntry(\''.$this->crypto->encrypt($entry->blog_id).'\')">Archive</button></div>';
                echo '<div class="raw1 raw-left raw-block-10"></div>';

                echo '<div class="raw9 raw-left mHide"><button data-theme="e" data-mini="true" onclick="deleteConfirm(\''.$this->crypto->encrypt($entry->blog_id).'\')">Delete</button></div>';
            echo '</div>';
        }

    ?>
    </div>

</div>

<script type="text/javascript">

    $('#search').deefault();

</script>

<?php $this->carabiner->display("blog-js"); ?>

<?php //End of file ?>