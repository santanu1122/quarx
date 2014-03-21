<?php /*
    Filename:   events_menu.php
    Location:   /application/modules/events/views/
*/ ?>

<div id="events_menu" class="dialogBox" title="Events Menu">
    <a href="<?php echo site_url('events/add') ?>" data-role="button" data-corners="false">Add Event</a>
    <a href="<?php echo site_url('events/view') ?>" data-role="button" data-corners="false">View Events</a>
    <a href="<?php echo site_url('events/calendar') ?>" data-role="button" data-corners="false">View Event Calendar</a>
</div>

<script type="text/javascript">

    function showMenu(){
        $('#events_menu').dialogbox({
            modal: true
        });
    }

</script>

<?php //End of file ?>