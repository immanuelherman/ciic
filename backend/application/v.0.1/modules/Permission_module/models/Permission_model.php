<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission_model extends CI_Model 
{
	public function __construct()
	{
		if (ENVIRONMENT == "development") $this->db->conn_id->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	function get_user_permission_by_id($user_id = NULL, $select = "*")
  	{
	    try
	    {
		    $query = $this->db->select($select)->get_where('tbl_permission', array('user_id' => $user_id));
	    }
	    catch (PDOException $e) {
		    log_message("error", 'Error get_user_permission_by_id: '.$user_id."<||>" . $e->getMessage());
	    	throw new PDOException($e->getMessage(), 1);
		}

		$row = $query->result();
		
		return $row;
  	}

  	function get_schema_permission_by_role_code($role_code = NULL, $select = "*")
  	{
	    try
	    {
		    $query = $this->db->select($select)->get_where('tbl_schema_permission', array('role_code' => $role_code));
	    }
	    catch (PDOException $e) {
		    log_message("error", 'Error get_schema_permission_by_role_code: '.$role_code."<||>" . $e->getMessage());
	    	throw new PDOException($e->getMessage(), 1);
		}

		$row = $query->result();
		
		return $row;
  	}

  	function create_permission_user($parameter, $auto_commit = TRUE)
  	{
  		$status = FALSE;
  		try 
		{
			if ($auto_commit) $this->db->trans_start();
			$status = $this->db->insert_batch('tbl_permission', $parameter);
		}
		catch (PDOException $e) {
			log_message("error", 'Error create_permission_user: '.json_encode($parameter)."<||>" . $e->getMessage());
  			$status = FALSE;
  			$this->db->trans_rollback();
  			throw new PDOException($e->getMessage(), 1);
		}
		
		if ($auto_commit) $this->db->trans_complete();
		return $status;
  	}

	function get_permission_by_code()
	{
		$dbh = $this->db->conn_id;
		try 
		{
			$stmt = $dbh->prepare('
									SELECT 
										role_code, permssion_code 
									FROM 
										tbl_permission
								');
			$stmt->execute();
		}
		catch (PDOException $e) {
		    log_message("error", 'Error get_permission_by_code: ' . $e->getMessage());
		}

		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result;
	}
}
