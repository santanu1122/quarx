<?php $CI =& get_instance(); ?>
<?php if($CI->session->userdata('permission') > 51 || $CI->session->userdata('permission') == 1){ ?>
<li><a href="<?php echo site_url('dealers'); ?>">Dealer Manager</a></li>
<?php } ?>