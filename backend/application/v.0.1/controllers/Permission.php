<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('http', 'permission', 'common'));
        $this->load->database();
        $this->output->enable_profiler(TRUE);
    }

    public function user_permission($user_id =NULL)
    {
        if (!empty($user_id))
        {
            modules::run("Permission_module/require_permission", "USER_LIST");
        }
        else
        {
            $user_id = $this->userdata['user_id'];
        }
        $user_id = intval($user_id);

        $list_permission_code = array('data' => modules::run("Permission_module/get_user_permission_by_id", $user_id, "module_code, sub_module_code"));
        response(200, array_merge(array("responseStatus" => "SUCCESS"), $list_permission_code));
    }
}


