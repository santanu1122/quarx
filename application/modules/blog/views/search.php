<?php

    /*
     * Filename:   search.php
     * Location:   /application/modules/blog/views
     */

?>

<div class="raw100 align-left">

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

        <div id="searchResults" class="raw100 raw-left">

            <?php

                if ($results == 'error') echo '<p class="raw-margin-top-50">Sorry, we don\'t have any matches.</p>';

                foreach ($results as $blog)
                {
                    echo '<div class="raw100">';
                    echo '<div class="raw25 raw-left"><p><a href="'.site_url('blog/editor/'.$this->crypto->encrypt($blog->blog_id)).'">'.substr($blog->blog_title, 0, 30).'</a></p></div>';
                    echo '<div class="raw25 raw-left mHide"><p>'.strip_tags($blog->blog_date).'</p></div>';
                    echo '<div class="raw25 raw-left mHide"><p>'.strip_tags($blog->blog_entry).'</p></div>';
                    echo '<div class="raw25 raw-left mHide"><p>'.$this->blog_cat_tools->getCatName($blog->blog_cat).'</p></div>';
                    echo '</div>';

                }

            ?>

        </div>

    </div>

</div>

<script>

    $("#search").deefault();

</script>

<?php //End of file ?>