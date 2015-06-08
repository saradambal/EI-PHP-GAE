<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctrl_Index extends CI_Controller {

	public function index()
	{
		$this->load->view('ACCESS RIGHTS/Vw_Menu');
	}
}
