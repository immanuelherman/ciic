<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_module extends MX_Controller {

    protected $cfg;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->database();
        $this->load->model("File_model");
    }

    public function get_file_detail($file_id)
    {
        return $this->File_model->get_file_detail($file_id);
    }

    public function render_image($file_detail)
    {
        $config_file = 'image';
        $this->config->load($config_file, TRUE);

        $base_url = FCPATH;
        $src = concat_url($base_url, $file_detail->src);

        // if (!file_exists(".".$file_detail->src))
        if (!file_exists($src))
        {
            $src = concat_url($base_url, $this->config->item('default_img', $config_file));
        }

        $md5_file = md5_file($src);
        $thumb_path = concat_url($base_url, $this->config->item('thumb_destination_path', $config_file));
        $config['source_image'] = $src;
        $config['image_library'] = $this->config->item('image_library', $config_file);
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
            else
            {
                if ($this->input->get($this->config->item('width', $config_file), TRUE)) $config['width'] = $this->input->get($this->config->item('width', $config_file), TRUE);
                if ($this->input->get($this->config->item('height', $config_file), TRUE)) $config['height'] = $this->input->get($this->config->item('height', $config_file), TRUE);
                $config['maintain_ratio'] = TRUE;
                $config['dynamic_output'] = TRUE;
            }
        }
        else
        {
            $config['maintain_ratio'] = FALSE;
            $config['width'] = $this->config->item('default_width', $config_file);
            $config['height'] = $this->config->item('default_height', $config_file);
            $expl = explode(".", $src);
            $config['new_image'] = concat_url($thumb_path,$md5_file).".".end($expl);
            $src = $config['new_image'];
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
            die;
        }
        if (!empty($config['dynamic_output'])) die;

        $this->output
        ->set_content_type('jpeg') // You could also use ".jpeg" which will have the full stop removed before looking in config/mimes.php
        ->set_output(file_get_contents($src));
        die;
    }

    public function render_image_src()
    {
        $config_file = 'image';
        $this->config->load($config_file, TRUE);

        $base_url = FCPATH;
        $src = $this->input->get("data");

        $default_img = concat_url($base_url, $this->config->item('default_img_user', $config_file));
        
        if (empty($src))
        {
            $src = $default_img;
        }
        
        $purl = parse_url($src);

        if (!empty($purl['path']) && !file_exists(concat_url($base_url, $purl['path'])))
        {
            $src = $default_img;
        }
        else
        {
            if (!empty($purl['path'])) $src = concat_url($base_url, $purl['path']);
            else $src = $default_img;

            parse_str($purl['query'], $query_image);

            $_GET = array_merge($_GET, $query_image);
        }

        $config['source_image'] = $src;
        $config['image_library'] = $this->config->item('image_library', $config_file);
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
            else
            {
                $config['width'] = $this->input->get($this->config->item('width', $config_file), TRUE);
                $config['maintain_ratio'] = TRUE;
                $config['dynamic_output'] = TRUE;
            }
        }
        else
        {
            $config['maintain_ratio'] = FALSE;
            $config['width'] = $this->config->item('default_width', $config_file);
            $config['height'] = $this->config->item('default_height', $config_file);
            $expl = explode(".", $src);
            $config['new_image'] = $thumb_path.$user_id.".".end($expl);
            $src = $config['new_image'];
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

        $this->output
        ->set_content_type('jpeg') // You could also use ".jpeg" which will have the full stop removed before looking in config/mimes.php
        ->set_output(file_get_contents($src));
        exit;
    }

    public function check_file_url($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        // don't download content
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if(curl_exec($ch)!==FALSE)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}