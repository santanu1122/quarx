<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/*
		Author:		Matt Lantz
	 */
	 
class calendar extends CI_Controller {

// Class: Default

	public function index()
	{	
		//we need to send the settings first to decide what we can do!
		$data['settings'] = $this->settings->on_off_checker();

		//grab the actual calendar settings
		$this->load->model('modelcalendarsettings');
		$data['cal_settings'] = $this->modelcalendarsettings->on_off_checker();
		
		//configured the data to be transported to the view
		$data['root'] = base_url();
		$data['pageRoot'] = base_url().'index.php';
		$data['pagetitle'] = 'Calendar Manager';
		
		//load the view elements
		$this->load->view('common/header', $data);
		$this->load->view('common/mainmenu', $data);
		$this->load->view('calendar/calendar', $data);
		$this->load->view('common/footer', $data);
	}
	
	public function activate()
	{	
		//grab the details to activate
		$settingId = $_GET['id'];
		$settingVal = $_GET['val'];
		
		//we need to send the settings first to decide what we can do!
		$data['settings'] = $this->settings->on_off_checker();
		
		$this->load->model('modelcalendarsettings');
		$query = $this->modelcalendarsettings->activate_setup($settingId, $settingVal);
		if($query){
			return true;
		}
	}

	public function statuscheck()
	{			
		//we need to send the settings first to decide what we can do!
		$data['settings'] = $this->settings->on_off_checker();
		
		$this->load->model('modelcalendarsettings');
		$query = $this->modelsettings->activate_setup($settingId, $settingVal);
		if($query){
			return true;
		}
	}


}
/* End of file setup.php */
/* Location: ./application/controllers/ */