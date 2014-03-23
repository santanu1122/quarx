<?php

/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 *
 */
?>

<?php

    foreach($images as $img)
    {

        $enc_id = $this->crypto->encrypt($img->img_id);
        $regular_id = $img->img_id;
        $clickAction = ($img->img_alt_tag == '' ? 'setTags(\'image-'.$regular_id.'\')' : 'updateTags(\'image-'.$regular_id.'\')');

        echo '<div id="container-'.$regular_id.'" class="quarx-image-box">';
            echo '<div class="quarx-img-thumb-holder">';
                echo '<div class="quarx-del-box" onclick="deleteImage(\''.$regular_id.'\')">';
                    echo '<span class="quarx-del-icon"></span>';
                echo '</div>';
                echo '<div class="quarx-thumb-shot">';
                    echo '<img style="visibility: hidden;" data-web-link="'.$img->img_medium_location.'" onclick="'.$clickAction.'" id="image-'.$regular_id.'" data-enc-id="'.$enc_id.'" src="'.$img->img_thumb_location.'" alt="'.$img->img_alt_tag.'" title="'.$img->img_title_tag.'" />';
                echo '</div>';
            echo '</div>';
        echo '</div>';

    }

?>