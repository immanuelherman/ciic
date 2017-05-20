<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File_model extends CI_Model 
{
	public function __construct()
	{
		if (ENVIRONMENT == "development") $this->db->conn_id->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

  	function get_file_detail($file_id, $select = "*")
  	{
	    try
	    {
		    $query = $this->db->select($select)
		    	->from('v_file')
		    	->where(array('file_id' => $file_id))
		    	->limit(1)->get();
	    }
	    catch (PDOException $e) {
		    log_message("error", 'Error get_file_detail: '.$file_id."<||>" . $e->getMessage());
	    	throw new PDOException($e->getMessage(), 1);
		}

		$row = $query->row();
		
		return $row;
  	}
}