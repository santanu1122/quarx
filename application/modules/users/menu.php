<?php $CI =& get_instance(); ?>
<?php if($CI->session->userdata('permission') > 0){ ?><li><a href="<?php echo site_url('users'); ?>">Users</a></li><?php } ?>
