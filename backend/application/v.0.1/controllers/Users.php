<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('http', 'permission', 'common'));
        $this->load->database();
        $this->output->enable_profiler(FALSE);
    }

    public function user_login()
    {
        $this->load->library('form_validation');        

        $rules = array(
                    array(
                            'field' => 'email',
                            'rules' => 'trim|required|valid_email'
                    ),
                    array(
                            'field' => 'password',
                            'rules' => 'trim|required'
                    ),
                    array(
                            'field' => 'device',
                            'rules' => 'trim'
                    )
        );

        $this->form_validation->set_data($this->parameter, TRUE);
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE)
        {
            $code = 400;
            response($code, array(
                    "responseStatus" => "ERROR",
                    "error" => array(
                        "code" => $code,
                        "message" => "Invalid parameter",
                        "errors" => array(
                            "domain" => "FORM_VALIDATION",
                            "reason" => "InvalidParameter",
                            "extra" => $this->form_validation->error_array()
                        ),
                    )
                )
            );
        }
       
        // get user_login by email and password
        $user_data = modules::run("Authentication_module/check", $this->parameter['email'], $this->parameter['password']);

        if ($user_data === FALSE)
        {
            $code = modules::run("Error_module/get_error_code");
            response($code, array(
                    "responseStatus" => "ERROR",
                    "error" => array(
                        "code" => $code,
                        "message" => modules::run("Error_module/get_error"),
                        "errors" => array(
                            "domain" => "AUTHENTICATION",
                            "reason" => "UnprocessableEntity",
                            "extra" => modules::run("Error_module/get_error_extra")
                        ),
                    )
                )
            );
        }

        // generate user session
        $secret_key = modules::run("Session_module/generate", $this->parameter['email']);

        if (empty($secret_key))
        {
            $code = modules::run("Error_module/get_error_code");
            response($code, array(
                    "responseStatus" => "ERROR",
                    "code" => $code,
                    "error" => array(
                        "message" => modules::run("Error_module/get_error"),
                        "errors" => array(
                            "domain" => "AUTHENTICATION",
                            "reason" => "UnprocessableEntity",
                            "extra" => modules::run("Error_module/get_error_extra")
                        ),
                    )
                )
            );
        }
        // get user permission
        $list_permission_code = modules::run("Permission_module/get_user_permission_by_id", $user_data->user_id, "module_code, sub_module_code");

        // set login flag
        $user_data->logged_in = TRUE;

        // set user permission table
        $user_data->permission = $list_permission_code;
        // set userdata
        $this->load->config('user_authentication');
        $index_secret_key = $this->config->item('user_authentication')['secret_key']['key'];

        // override user profile url
        $this->load->helper('url');

        $user_data->picture = "/users/".$user_data->user_id."/picture";
        
        $data = array(
            $index_secret_key => $secret_key,
            'data' => $user_data
        );
        $sess_data = (array) $user_data;
        $sess_data[$index_secret_key] = $secret_key;
        $this->session->set_userdata($sess_data);

        modules::run("User_module/update_last_login", $user_data->user_id);

		response(200, array_merge(array("responseStatus" => "SUCCESS"), $data));
	}

    public function user_profile()
    {
        response(200, array_merge(array("responseStatus" => "SUCCESS"), array('data' => $this->userdata)));
    }

	public function user_logout()
	{
        $this->load->helper('common');
        // lock user finger print
        // create session id unique by upn+ip_address+user_agent
        session_id(create_finger_print($this->userdata['email']));
        session_destroy();
	}

	public function user_list($user_id = NULL)
    {
        modules::run("Permission_module/require_permission", "USER_LIST");
        $users = array();
        $count = NULL;

        if (!empty($user_id))
        {
            $user_id = intval($user_id);
            $users = modules::run("User_module/get_user_by_id", $this->input->get(NULL, TRUE), $user_id);

            $this->load->helper("url");

            if ($users === FALSE)
            {
                $code = modules::run("Error_module/get_error_code");
                response($code, array(
                        "responseStatus" => "ERROR",
                        "error" => array(
                            "code" => $code,
                            "message" => modules::run("Error_module/get_error"),
                            "errors" => array(
                                "domain" => "USER",
                                "reason" => "UserNotFound"
                            ),
                        )
                    )
                );
            }
            $data['data'] = $users;
            // override user profile url
            $data['data']->picture = "/users/".$data['data']->user_id."/picture";
        }
        else
        {
            $data = modules::run("User_module/get_user_list", $this->input->get(NULL, TRUE));
            // override user profile url
            foreach ($data['data'] as $index => $row) 
            {
                $data['data'][$index]->picture = "/users/".$data['data'][$index]->user_id."/picture";
            }
        }

        response(200, array_merge(array("responseStatus" => "SUCCESS"), $data));
    }

    public function user_count()
    {
        modules::run("Permission_module/require_permission", "USER_LIST");

        $count = modules::run("User_module/get_user_count", $this->input->get(NULL, TRUE));
        response(200, array_merge(array("responseStatus" => "SUCCESS"), (array) $count));
    }

	public function create_user()
	{
        modules::run("Permission_module/require_permission", "USER_CREATE");

        $user_id = modules::run("User_module/create_user", $this->parameter, $this->userdata['user_id']);
            
        if ($user_id === FALSE)
        {
            $code = modules::run("Error_module/get_error_code");
            response($code, array(
                    "responseStatus" => "ERROR",
                    "error" => array(
                        "code" => $code,
                        "message" => modules::run("Error_module/get_error"),
                        "errors" => array(
                            "domain" => "USER",
                            "reason" => "UpdateErrorException",
                            "extra" => modules::run("Error_module/get_error_extra")
                        ),
                    )
                )
            );
        }

        $data = array("data" => array("user_id" => $user_id));

        response(201, array_merge(array("responseStatus" => "SUCCESS"), $data));
	}

    public function update_profile()
    {
        $this->update_user_by_id(['user_id']);
    }

	public function update_user_by_id($user_id)
	{
        if ($this->userdata['user_id'] != $user_id)
        {
            modules::run("Permission_module/require_permission", "USER_UPDATE");
        }

        $affected_row = modules::run("User_module/update_user_by_id", $user_id);
            
        if ($affected_row === FALSE)
        {
            $code = modules::run("Error_module/get_error_code");
            response($code, array(
                    "responseStatus" => "ERROR",
                    "error" => array(
                        "code" => $code,
                        "message" => modules::run("Error_module/get_error"),
                        "errors" => array(
                            "domain" => "USER",
                            "reason" => "UpdateErrorException",
                            "extra" => modules::run("Error_module/get_error_extra")
                        ),
                    )
                )
            );
        }

        response(200, array_merge(array("responseStatus" => "SUCCESS")));
	}

	public function delete_user_by_id()
    {
        $segs = array_values(array_filter(array_map("intval", $this->uri->segment_array())));
        $users = array_map("trim", $segs);

        if (in_array($this->userdata['user_id'], $users))
        {
            response(400, array(
                    "responseStatus" => "ERROR",
                    "error" => array(
                        "code" => 400,
                        "message" => "user can't self delete",
                        "errors" => array(
                            "domain" => "USER",
                            "reason" => "DeleteErrorException"
                        ),
                    )
                )
            );
        }

        // require access delete user
        modules::run("Permission_module/require_permission", "USER_DELETE");

        $affected_row = modules::run("User_module/delete_user_by_id", $users);
        if ($affected_row != count($users))
        {
            $code = modules::run("Error_module/get_error_code");
            response(500, array(
                    "responseStatus" => "ERROR",
                    "error" => array(
                        "code" => 500,
                        "message" => "some row not deleted",
                        "errors" => array(
                            "domain" => "USER",
                            "reason" => "UpdateErrorException",
                            "extra" => array("counter_deleted" => $affected_row)
                        ),
                    )
                )
            );
        }

        response(200, array_merge(array("responseStatus" => "SUCCESS")));
    }

    public function user_picture($user_id)
    {
        $user_id = intval($user_id);
        
        $user = modules::run("User_module/get_user_by_id", array(), $user_id);
        if ($user === FALSE)
        {
            $code = modules::run("Error_module/get_error_code");
            response($code, array(
                    "responseStatus" => "ERROR",
                    "error" => array(
                        "code" => $code,
                        "message" => modules::run("Error_module/get_error"),
                        "errors" => array(
                            "domain" => "USER",
                            "reason" => "UserNotFound"
                        ),
                    )
                )
            );
        }

        $user_id = md5($user_id);

        $this->load->helper('url');
        $config_file = 'image';
        $this->config->load($config_file, TRUE);

        $base_path = $this->config->item('base_path', $config_file);
        $thumb_path = $base_path.rtrim($this->config->item('thumb_destination_path_profile', $config_file), "/")."/";

        $image_src = $base_path.$user->picture;

        if (!file_exists($image_src))
        {
            $image_src = $base_path.$this->config->item('default_img_user', $config_file);
        }

        $config['image_library'] = $this->config->item('image_library', $config_file);
        $config['source_image'] = $image_src;
        $config['maintain_ratio'] = $this->config->item('maintain_ratio', $config_file);

        if (!$this->input->get($this->config->item('thumb', $config_file), TRUE))
        {
            if ($this->input->get($this->config->item('width', $config_file), TRUE) && $this->input->get($this->config->item('height', $config_file), TRUE))
            {
                $config['width'] = $this->input->get($this->config->item('width', $config_file), TRUE);
                $config['height'] = $this->input->get($this->config->item('height', $config_file), TRUE);
                $config['maintain_ratio'] = FALSE;
                $config['dynamic_output'] = TRUE;
            }
        }
        else
        {
            $config['maintain_ratio'] = FALSE;
            $config['width'] = $this->config->item('default_width', $config_file);
            $config['height'] = $this->config->item('default_height', $config_file);
            $expl = explode(".", $image_src);
            $config['new_image'] = $thumb_path.$user_id.".".end($expl);
            $image_src = $config['new_image'];
        }

        $this->load->library('image_lib');

        $this->image_lib->initialize($config);

        if ( ! $this->image_lib->resize())
        {
            $code = 400;
            response($code, array(
                    "responseStatus" => "ERROR",
                    "error" => array(
                        "code" => $code,
                        "message" => $this->image_lib->display_errors(),
                        "errors" => array(
                            "domain" => "USER",
                            "reason" => "ImageError"
                        ),
                    )
                )
            );
        }
        $this->output // You could also use ".jpeg" which will have the full stop removed before looking in config/mimes.php
        ->set_output(file_get_contents($image_src))->_display();
        return;
    }
}


