<?php
/**
 * 
 */
class AdminModel extends CI_Model
{
	function getUser($filter = NULL,$start = NULL,$limit = NULL,$order_by = NULL)
	{
		if($filter)
		{
			$this->db->where($filter);
		}
		if($start || $limit){
			$this->db->limit($start,$limit);
		}
		if($order_by)
		{
			$this->db->order_by($order_by);
		}
		$result = $this->db->get('user');
	//	print_r($this->db->last_query());exit;
		if($result)
		{
			return $result->result_array();
		}else
		{
			return false;
		}
	}



	function insertmName($data3,$filter = NULL)
	{
		
		if($this->input->post('id') == 'new'){
			$this->db->insert('manufacturer',$data3);
		}else{
			$this->db->where($filter);
			$this->db->update('manufacturer',$data3);
		}
	
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}

	}

	function getManufacturerList($filter = NULL,$start = NULL,$limit = NULL,$order_by = NULL)
	{
		if($filter)
		{
			$this->db->where($filter);
		}
		if($start || $limit){
			$this->db->limit($start,$limit);
		}
		if($order_by)
		{
			$this->db->order_by($order_by);
		}
		$result = $this->db->get('manufacturer');
	//	print_r($this->db->last_query());exit;
		if($result)
		{
			return $result->result_array();
		}else
		{
			return false;
		}
	}



	function getModelList($filter = NULL,$start = NULL,$limit = NULL,$order_by = NULL)
	{
		$this->db->select('mo.*,mf.*,count(mo.model) as Number_of_cars,mo.id as modelid');
		if($filter)
		{
			$this->db->where($filter);
		}
		if($start || $limit){
			$this->db->limit($start,$limit);
		}
		if($order_by)
		{
			$this->db->order_by($order_by);
		}
		$this->db->join('manufacturer mf','mf.id = mo.mName','inner');
		$this->db->group_by('mo.model');
		$result = $this->db->get('model mo');
	//	print_r($this->db->last_query());exit;
		if($result)
		{
			return $result->result_array();
		}else
		{
			return false;
		}
	}

	function insertModel($data3,$filter = NULL)
	{
		
		if($this->input->post('id') == 'new'){
			$this->db->insert('model',$data3);
		}else{
			$this->db->where($filter);
			$this->db->update('model',$data3);
		}
	
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}

	}

	public function deleteModal($filter = NULL){
		if($filter){
			$this->db->where($filter);
		}
		$this->db->delete('model');
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	

}
?>
