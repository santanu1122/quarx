<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class events extends MX_Controller {

    function __construct(){
        parent::__construct();
        if(!$this->session->userdata('logged_in')){
            redirect('login/error'); // Denied!
        }

        if($this->session->userdata('permission') > 1){
            $access = check_master_access(); //check if master access is on
            if($access){
                redirect('login/insufficient'); // Denied!
            }
        }
    }

/* Main Blog functions
***************************************************************/

    public function index()
    {
        addImageGallery();

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Events';

        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('events/extras', $data);
        $this->load->view('events/events_menu', $events);
        $this->load->view('events/events', $data);
        $this->load->view('common/footer', $data);
    }

    public function add()
    {
        redirect('events');
    }

    public function editor($id)
    {
        addImageGallery();
        // we need this to decipher the category name from the category code
        $this->load->library('event_categorytools');

        //In order to see all our lovely events
        $this->load->model('model_event');
        $entry = $this->model_event->get_this_entry(decrypt($id));
        $data['events'] = $entry[0];

        //configured the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Events : Editor';

        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('events/extras', $data);
        $this->load->view('events/events_menu', $events);
        $this->load->view('events/editor', $data);
        $this->load->view('common/footer', $data);
    }

    public function view() {
        $this->load->model('model_event');
        $this->load->library('event_categorytools');


        //In order to see all our lovely events entries
        $data['entries'] = $this->model_event->get_all_entries();

        //configured the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Events : View';

        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('events/extras', $data);
        $this->load->view('events/events_menu', $events);
        $this->load->view('events/view', $data);
        $this->load->view('common/footer', $data);
    }

    public function calendar($year = null, $month = null){
        //Load the model
        $this->load->model('model_event');

        if($year == null){
            $year = date('Y');
        }

        if($month == null){
            $month = date('m');
        }

        $conf = array(
            'day_type' => 'long',
            'show_next_prev' => true,
            'next_prev_url' => base_url().index_page().'events/calendar'
            );

       $conf['template'] = '
            {table_open}<table class="calendar">{/table_open}
            {heading_row_start}<tr>{/heading_row_start}

            {heading_previous_cell}<th style="line-height: 40px; text-align: left;"><a class="np" href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
            {heading_title_cell}<th class="calMonth" colspan="{colspan}">{heading}</th>{/heading_title_cell}
            {heading_next_cell}<th style="text-align: right;" ><a class="np" href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

            {heading_row_end}</tr>{/heading_row_end}
            {week_day_cell}<th class="day_header">{week_day}</th>{/week_day_cell}
            {cal_cell_content}<span class="day_listing">{day}</span>{content}&nbsp;{/cal_cell_content}
            {cal_cell_content_today}<div class="today"><span class="day_listing">{day}</span>{content}</div>{/cal_cell_content_today}
            {cal_cell_no_content}<span class="day_listing">{day}</span>&nbsp;{/cal_cell_no_content}
            {cal_cell_no_content_today}<div class="today"><span class="day_listing">{day}</span></div>{/cal_cell_no_content_today}
        ';

        // load some libraries
        $this->load->library('calendar');
        $this->load->library('event_calendar', $conf);
        $dates = $this->model_event->get_calendar_data($year, $month);

        $eventDates = array();

        foreach($dates as $events):
            $dateArray = range(intval(substr($events->event_start_date, 8, 2)), intval(substr($events->event_end_date, 8, 2)));
            $i = 0;
            foreach ($dateArray as $value) {
                $eventDates[$value][] = array("details" => '<a class="event" href="'.base_url().'events/editor/'.encrypt($events->event_id).'">'.substr($events->event_title, 0, 15)."...</a>", "id" => $events->event_id);
            }
            $i++;
        endforeach;

        $data['month'] = $month;
        $data['year'] = $year;
        $data['calendar'] = $this->event_calendar->generate($year, $month, $eventDates);

        //set some data and parameters
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Events : Calendar';

        // load the view components
        $this->load->view('common/header', $data);
        $this->load->view('events/events_menu', $data);
        $this->load->view('events/calendar', $data);
        $this->load->view('common/footer', $data);

    }

    function search(){
        $name = $_POST['search'];
        $this->load->model('model_event');
        $qry = $this->model_event->search_event($name);

        $this->load->library('event_categorytools');
        $this->load->library("cryptography");

        if($qry){
            $data['results'] = $qry;
        }else{
            $data['results'] = 'error';
        }

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Events : Search';

        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('events/extras', $data);
        $this->load->view('events/events_menu', $events);
        $this->load->view('events/search', $data);
        $this->load->view('common/footer', $data);
    }

/* Redirects
***************************************************************/

    public function display_entry($id) {
        $this->load->library('cryptography');

        //In order to see all our lovely events
        $this->load->model('model_event');
        $qry = $this->model_event->display_entry(decrypt($id));
        if( $qry ){
            redirect('events/view');
        }
    }

    public function archive_entry($id) {
        $this->load->library('cryptography');

        //In order to see all our lovely events
        $this->load->model('model_event');
        $qry = $this->model_event->archive_entry(decrypt($id));
        if( $qry ){
            redirect('events/view');
        }
    }

    public function display_this_entry($id) {
        $this->load->library('cryptography');

        //In order to see all our lovely events
        $this->load->model('model_event');
        $qry = $this->model_event->display_entry(decrypt($id));
        if( $qry ){
            redirect('events/editor/'.$id);
        }
    }

    public function archive_this_entry($id) {
        $this->load->library('cryptography');

        //In order to see all our lovely events
        $this->load->model('model_event');
        $qry = $this->model_event->archive_entry(decrypt($id));
        if( $qry ){
            redirect('events/editor/'.$id);
        }
    }

    public function delete_entry($id) {
        $this->load->library('cryptography');

        //In order to see all our lovely events
        $this->load->model('model_event');
        $qry = $this->model_event->delete_entry(decrypt($id));
        if( $qry ){
            redirect('events/view');
        }
    }

/* Add Blog Entry
***************************************************************/

    public function add_entry() {
        $this->load->model('model_event');
        $qry = $this->model_event->add_entry();

        if($qry){
            echo $qry;
        }else{
            echo 'duplicate title';
        }
    }

/* Edit Blog Entry
***************************************************************/

    public function update_entry() {
        $this->load->model('model_event');
        $qry = $this->model_event->edit_entry();

        if($qry){
            echo $qry;
        }
    }

}

/* End of file events.php */
/* Location: ./application/modules/events/controllers/ */