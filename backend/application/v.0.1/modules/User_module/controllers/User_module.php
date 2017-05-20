<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_module extends MX_Controller {
	protected $error;
	protected $error_code;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_user_by_email($parameter = array(), $email, $exclude_password = TRUE)
	{
		$this->load->helper('common');
		
		if (!valid_email($email))
		{
			modules::run("Error_module/set_error", "Email not a valid format");
			modules::run("Error_module/set_error_code", 400);
			return FALSE;
		}

		$graph = $this->get_graph_result($parameter, $exclude_password);
		$this->load->model("User_model");

		$user = $this->User_model->get_user_by_email($email, $graph->select, $exclude_password);

		if (!isset($user))
		{
			modules::run("Error_module/set_error", "User not found on database");
			modules::run("Error_module/set_error_code", 404);
			return FALSE;
		}

		return $user;
	}

	public function get_user_by_id($parameter = array(), $user_id, $exclude_password = TRUE)
	{
		$graph = $this->get_graph_result($parameter, $exclude_password);
		$this->load->model("User_model");

		$user = $this->User_model->get_user_by_id($user_id, $graph->select, $exclude_password);

		if (!isset($user))
		{
			modules::run("Error_module/set_error", "User not found on database");
			modules::run("Error_module/set_error_code", 404);
			return FALSE;
		}
		return $user;
	}

	public function get_user_list($parameter = array())
	{
		$graph = $this->get_graph_result($parameter);
		$this->load->model("User_model");

		$user = $this->User_model->get_user_list($graph);
		$user_count = $this->get_user_count($parameter);
		$graph_pagination = $this->get_graph_pagination($user_count->count);

		$this->load->helper('url');
		$query_url = (!empty($this->input->get(NULL, TRUE))) ? http_build_query($this->input->get(NULL, TRUE)) : "";
		$data = array(
			'current_url' => current_url(),
			'url_query' => $query_url,
			'count' => $user_count->count,
			'data' => $user,
			'pagination' => $graph_pagination
		);
		return $data;
	}

	public function get_user_count($parameter = array())
	{
		$graph = $this->get_graph_result($parameter);
		$this->load->model("User_model");

		$user_count = $this->User_model->get_user_count($graph);

		return $user_count;
	}

	public function update_user_password_by_id($user_id)
	{
		$parameter = $this->parameter;

		if (empty($parameter))
		{
			return TRUE;
		}

		$rules = array(
			array(
				'field' => 'password',
				'rules' => 'trim|min_length[6]'
			),
			array(
				'field' => 'passconf',
				'rules' => 'trim|matches[password]'
			)
		);

		if ($this->validate_update_user_by_id($rules) === FALSE) return FALSE;
		$this->load->model("User_model");

		// add parameter created_by
		$parameter['modified_by'] = $this->userdata['user_id'];
		
		// convert password to bcrypt
		if (!empty($parameter['password']))
		{
			$parameter['password'] = password_hash($parameter['password'], PASSWORD_BCRYPT);
			unset($parameter['passconf']);
		}

		$affected_row = $this->User_model->update_user_by_id($parameter, $user_id);
		return $affected_row;
	}

	public function update_user_by_id($user_id)
	{
		$parameter = $this->parameter;

		if (empty($parameter))
		{
			return TRUE;
		}

		$rules = array(
			array(
				'field' => 'role_code',
				'rules' => 'trim|exact_length[3]'
			),
			array(
				'field' => 'first_name',
				'rules' => 'trim|min_length[3]|max_length[100]'
			),
			array(
				'field' => 'last_name',
				'rules' => 'trim|min_length[3]|max_length[100]'
			),
			array(
				'field' => 'contact',
				'rules' => 'trim|is_natural|min_length[5]'
			),
			array(
				'field' => 'gender_code',
				'rules' => 'trim|min_length[1]|in_list[N,M,F]'
			),
			array(
				'field' => 'address',
				'rules' => 'trim|min_length[10]'
			)
		);

		if ($this->validate_update_user_by_id($rules) === FALSE) return FALSE;
		$this->load->model("User_model");

		// add parameter created_by
		$parameter['modified_by'] = $this->userdata['user_id'];
		
		// convert password to bcrypt
		if (!empty($parameter['password']))
		{
			$parameter['password'] = password_hash($parameter['password'], PASSWORD_BCRYPT);
			unset($parameter['passconf']);
		}

		$affected_row = $this->User_model->update_user_by_id($parameter, $user_id);
		return $affected_row;
	}

	public function create_user($parameter = array(), $created_by = 0)
	{
		if ($this->validate_create_user($parameter) === FALSE) return FALSE;
		
		// check is user already created or not
		$check = modules::run("User_module/get_user_by_email", NULL, $parameter['email']);

		if (!empty($check->user_id))
		{
			modules::run("Error_module/set_error", "User already exist");
			modules::run("Error_module/set_error_code", 409);
			return FALSE;
		}

		$this->load->model("User_model");

		// add parameter created_by
		$parameter['created_by'] = $created_by;
		
		// convert password to bcrypt
		if (!empty($parameter['password']))
		{
			$parameter['password'] = password_hash($parameter['password'], PASSWORD_BCRYPT);
			unset($parameter['passconf']);
		}

		$user_id = $this->User_model->create_user($parameter);

		if ($user_id > 0)
		{
			// create default permission
			$status = $this->create_default_permission($user_id, $parameter['role_code']);			
			if (empty($status))
			{
				if (!empty($check->user_id))
				{
					modules::run("Error_module/set_error", "Failed to create permisison");
					modules::run("Error_module/set_error_code", 500);
					return FALSE;
				}
			}
		}

		return $user_id;
	}

	protected function create_default_permission($user_id, $role_code)
	{
		// get default permission
		$permission = modules::run("Permission_module/get_schema_permission_by_role_code", 	$role_code);

		if (empty($permission)) return FALSE;
		
		$new_permission = array();
		foreach ($permission as $key => $value) {
			$new_permission[] = array(
				'user_id' => $user_id,
				'module_code' => $value->module_code,
				'sub_module_code' => $value->sub_module_code
			);
		}
		$status = modules::run("Permission_module/create_permission_user", $new_permission);
		return $status;
	}


	public function delete_user_by_id($user_id)
	{
		if (!is_array($user_id))
		{
			$user_id = array_map("trim", explode(",", $user_id));
		}

		$user_id = array_map("intval", $user_id);

		$users = array();
		$now = date('Y-m-d H:i:s');

		foreach ($user_id as $key => $value) {
			$users[$key] = array(
				'user_id' => $value,
				'deleted_at' => $now
			);
		}

		$this->load->model("User_model");

		$affected_row = $this->User_model->delete_user_by_id($users);

		return $affected_row;
	}

	public function update_last_login($user_id)
	{
		$this->load->model("User_model");

		$status = $this->User_model->update_last_login($user_id);
		return $status;
	}

	public function get_default_select()
	{
		return array(
			'v_user.user_id' => 'user_id',
			'tbl_role.role_code' => 'role_code',
			'tbl_role.role_name' => 'role_name',
			'v_user.email' => 'email'
		);
	}

	public function get_optional_select()
	{
		return array(
			'v_user.first_name' => 'first_name',
			'v_user.last_name' => 'last_name',
			'v_user.gender_code' => 'gender_code',
			'tbl_gender.gender_name' => 'gender_name',
			'v_user.contact' => 'contact',
			'v_user.picture' => 'picture',
			'v_user.address' => 'address',
			'v_user.last_login' => 'last_login',
			'v_user.created_by' => 'created_by',
			'v_user.created_date' => 'created_date',
			'v_user.modified_date' => 'modified_date'
		);
	}

	protected function get_graph_result($parameter = array(), $exclude_password = TRUE)
	{
		$default = $this->get_default_select();
		$optional = $this->get_optional_select();

		if (!$exclude_password)
		{
			array_push($default, "password");
		}

		$this->load->library("graph");
		// check whether graph validation error or not
		if (!$this->graph->initialize($parameter, $default, $optional, "users"))
		{
			response($this->graph->get_error_code(), array(
					"responseStatus" => "ERROR",
					"error" => array(
						"code" => $this->graph->get_error_code(),
						"message" => $this->graph->get_error(),
						"errors" => array(
							"domain" => "GRAPH_VALIDATION",
							"reason" => "GraphError"
						),
					)
				)
			);   
		}

		return $this->graph->get_compile_result();
	}

	protected function get_graph_pagination($count)
	{
		$this->load->library("graph");
		// check whether graph validation error or not
		$this->graph->initialize_pagination($count);

		return $this->graph->get_compile_result_pagination();
	}

	protected function validate_update_user_by_id($rules)
	{
		$this->load->library('form_validation');	 	

		$this->form_validation->set_data($this->parameter, TRUE);
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == FALSE && $this->form_validation->error_array())
		{
			modules::run("Error_module/set_error", "error validation on input data");
			modules::run("Error_module/set_error_code", 400);
			$extra = (!is_array($this->form_validation->error_array())) ? array('invalid_field' => $this->form_validation->error_array()) : $this->form_validation->error_array(); 
			modules::run("Error_module/set_error_extra", $extra);
			return FALSE;
		}
		return TRUE;
	}

	protected function validate_create_user($parameter)
	{
		$this->load->library('form_validation');	 	
		$role_list = modules::run("Role_module/get_role_list", "role_code");
		$available_role = implode(",", array_map("trim", array_column($role_list, 'role_code')));

		$rules = array(
			array(
				'field' => 'email',
				'rules' => 'trim|required|valid_email'
			),
			array(
				'field' => 'first_name',
				'rules' => 'trim|required|min_length[2]'
			),
			array(
				'field' => 'last_name',
				'rules' => 'trim|min_length[2]'
			),
			array(
				'field' => 'password',
				'rules' => 'trim|required|min_length[6]'
			),
			array(
				'field' => 'passconf',
				'rules' => 'trim|required|matches[password]'
			),
			array(
				'field' => 'role_code',
				'rules' => 'trim|required|in_list['.$available_role.']'
			),
			array(
				'field' => 'gender_code',
				'rules' => 'trim|min_length[1]|in_list[N,M,F]'
			),
			array(
				'field' => 'contact',
				'rules' => 'trim|required|is_natural|min_length[5]'
			),
			array(
				'field' => 'address',
				'rules' => 'trim|min_length[10]'
			)
		);

		$this->form_validation->set_data($parameter, TRUE);
		$this->form_validation->set_rules($rules);

		if ($this->form_validation->run() == FALSE)
		{
			if ($this->form_validation->run() == FALSE && $this->form_validation->error_array())
			{
				modules::run("Error_module/set_error", "error validation on input data");
				modules::run("Error_module/set_error_code", 400);
				$extra = (!is_array($this->form_validation->error_array())) ? array('invalid_field' => $this->form_validation->error_array()) : $this->form_validation->error_array(); 
				modules::run("Error_module/set_error_extra", $extra);
				return FALSE;
			}
			return TRUE;
		}
	}
}