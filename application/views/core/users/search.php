<?php

/**
 * Quarx
 *
 * A modular CMS application
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 - 2014 Matt Lantz
 * @license     https://ottacon.co/docs/quarx/license.html
 * @link        https://github.com/mlantz/quarx
 * @since       Version 1.0
 *
 */

?>

<div class="raw100">
    <div class="quarx-device">

        <div class="raw100">
            <form id="quarx-member-search" method="post" action="<?php echo site_url('users/search-for'); ?>">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                <input id="quarx-search" name="search" class="quarx-search-bar deefault" data-deefault="Enter a member name or email" onfocus="resetSearch()" />
            </form>
        </div>
        <div class="raw100">
            <?php if ( ! is_null($results)) echo "<p>You searched for: ".$searchTerm."</p>"; ?>
        </div>
        <div id="quarx-search-results" class="raw100">

            <?php

                if (empty($results)) echo "<p>".$empty_result."</p>";

                foreach($results as $member)
                {
                    echo '<div class="quarx-account-info-row raw100 quarx-bordered quarx-clickable" onclick="window.location=\''.site_url('users/editor/'.$this->crypto->encrypt($member->id)).'\'">';
                        echo '<div class="raw25 raw-left"><p class="raw-padding-left-8">'.$member->username.'</p></div>';
                        echo '<div class="raw25 raw-left mHide"><p>'.$this->tools->length_check($member->email).'</p></div>';
                        echo '<div class="raw25 raw-left mHide"><p>'.$this->tools->length_check($member->full_name).'</p></div>';
                        echo '<div class="raw25 raw-left mHide"><p>'.$this->tools->length_check($member->location).'</p></div>';
                    echo '</div>';
                }

            ?>

            </div>

            <?php echo $this->pagination->create_links(); ?>
    </div>
</div>

<?php $this->carabiner->display("quarx-users-js"); ?>

<?php //End of File ?>