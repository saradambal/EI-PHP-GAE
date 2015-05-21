<?php
class Sample extends CI_Controller{
	public function add_employee(){
		$this->load->view('sampleform.php');
	}
	public function save(){

		$firstName= ($this->input->post('firstName'));
		$lastName= ($this->input->post('lastName'));
		$email= ($this->input->post('email'));
		$employee = array(
			'FIRST_NAME' => $firstName,
			'LAST_NAME' => $lastName,
			'EMAIL' => $email
		);
                $this->load->model('SampleModel');
		$employeeId = $this->SampleModel->addEmployee($employee);
		$data['message'] =  "";
		if($employeeId){
			$data['message'] =  "Employee Saved Successfully!..";
		}
		$query = $this->SampleModel->getEmployee();

		if($query){
			$data['EMPLOYEES'] =  $query;
		}
                $this->load->view('sampleform.php',$data);
	}


	public function employeelist(){
        $this->load->model('SampleModel');
		$query = $this->SampleModel->getEmployee();
		if($query)
                    {
			$data['EMPLOYEES'] =  $query;
		    }
		$this->load->view('employeelist.php', $data);
	}
}