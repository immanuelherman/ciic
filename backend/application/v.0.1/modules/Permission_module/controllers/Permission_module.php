<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission_module extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_user_permission_by_id($user_id, $select = "*")
	{
        $this->load->model('Permission_model');

        // set user permission table
        $list_permission = $this->Permission_model->get_user_permission_by_id($user_id, $select = "*");
        return $list_permission;
	}

	public function get_schema_permission_by_role_code($role_code, $select = "*")
	{
        $this->load->model('Permission_model');

        // set user permission table
        $list_permission = $this->Permission_model->get_schema_permission_by_role_code($role_code, $select = "*");
        return $list_permission;
	}

	public function create_permission_user($permission)
	{
        $this->load->model('Permission_model');

        // set user permission table
        $list_permission = $this->Permission_model->create_permission_user($permission);
        return $list_permission;
	}

	public function require_permission($permission_code, $strict = TRUE)
	{
        modules::run("Authentication_module/is_user_login");

		$require_permission = array();

		if (is_array($permission_code))
		{
			foreach ($permission_code as $key => $value) 
			{
				$require_permission[] = $value;
			}
		}
		else
		{
			$require_permission = array_map("trim", explode(",", $permission_code));
		}

		$missing = array_diff($require_permission, array_column($this->userdata['permission'], "sub_module_code"));

		$granted = (boolean) (empty($missing)) ? TRUE : FALSE;
		
		if (!$strict) return $granted;

		if (!$granted)
		{
			get_instance()->load->helper('http');
			response(401, array(
                    "responseStatus" => "ERROR",
                    "code" => 401,
                    "error" => array(
                        "message" => "User need permission ".implode("`,`", $missing),
                        "errors" => array(
                            "domain" => "AUTHENTICATION",
                            "reason" => "UserNeedPermission"
                        ),
                    )
                )
            );
		}
	}
}