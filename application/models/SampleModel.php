<?php
class SampleModel extends CI_Model {	
    
	Public function getEmployee()
        {	
		$this->db->select("EMPLOYEE_ID,FIRST_NAME,LAST_NAME,EMAIL");
		$this->db->order_by("EMPLOYEE_ID", "asc");
		$this->db->from('trn_employee');				
		$query = $this->db->get();		
		return $query->result();			
	}
	
	Public function addEmployee($employee=NULL){		
		$this->db->insert('trn_employee', $employee);
		return $this->db->insert_id();						
	}
}
?>