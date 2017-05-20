<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debugger extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('http'));
        header("Content-Type: text/html");
	}

	public function index()
    {
        $this->load->driver("scannerdriver", array("asd","asda"));
        $img = "/img/file1";
        $pdf = "/pdf/file1";
        print_r($this->scannerdriver->scan($img, $pdf));
        // print_r($this->scannerdriver->ocr($img));
        die;
        $output = shell_exec("/usr/sbin/service vsftpd stop >> /tmp/ftp_switch.output 2>&1");
        print_r($output);
        die;
        $upn = "KoranMadura";
        $input = "RAW";
        $method = "GET";
        // http://192.168.88.7/api/regency?page=1&perPage=10&offset=0&search=jam
        $path = "/articles/55213";
        // $path = "/raspberry/setup";
        $upn_key = 'email';
        $token_key = 'secret_key';
        $exist_secret_key = "";

        $params = array(
            "email" => "alex@koranmadura.com",
            "first_name" => "Alex",
            "last_name" => "marten",
            "password" => "@lbergat1",
            "passconf" => "@lbergat1",
            "role_code" => "SUP",
            "contact" => "081318502342",
        );
        $urlParams = "";

        $base_url = "http://koranmadura.djemana.com/api";
        $url = $base_url.$path;

        $agent = 'bMozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36';
        if (empty($exist_secret_key))
        {

            if (empty($this->parameter[$upn_key]) OR empty($this->parameter['password'])) 
            {
                die('email or password required');
            }
            else
            {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $base_url.'/users/login');
                curl_setopt($ch, CURLOPT_USERAGENT, $agent);
                
                $fields = array($upn_key => $this->parameter[$upn_key], 'password' => $this->parameter['password']);

                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                // Disabling SSL Certificate support temporarly
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLINFO_HEADER_OUT, 1);


                $server_output_bef = curl_exec ($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $server_output = json_decode($server_output_bef, TRUE);

                if (empty($server_output[$token_key]))
                {
                    echo "HTTP_CODE: <b>".$httpCode."</b>";
                    echo "<pre>";
                    print_r($server_output_bef);
                    echo "</pre>";
                    echo "<pre>";
                    print_r($server_output);
                    echo "</pre>";
                }

                $secretKey = $server_output[$token_key];

                if ($httpCode != '200')
                {
                    die("Invalid username/password supplied.. response httpStatusCode : ".$httpCode);
                }

                if (empty($secretKey))
                {
                    die("server doen't return secretKey");
                }
            }
        }
        else
        {
            $secretKey = $exist_secret_key;
        }
        echo "<pre>";
        print_r(array('secretKey' => $secretKey));
        echo "</pre>";

        $ch = curl_init();
        
        $timezone = date('Z');
        $operator = ($timezone[0] === '-') ? '-' : '+';
        $timezone = abs($timezone);
        $timezone = floor($timezone/3600) * 100 + ($timezone % 3600) / 60;

        $date = sprintf('%s %s%04d', date('D, j M Y H:i:s'), $operator, $timezone);
        $headers = array();

        curl_setopt($ch, CURLOPT_URL, $url.$urlParams);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($input == "FORM") curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        if ($input == "RAW") 
        {
            $params = json_encode($params);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            $headers[] = 'Content-Type: text/html';
        }
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        // curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 0); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 0); //timeout in seconds
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        // {"method":"GET","path":"\/profile","Authorization":"Sinarmas sinarmas02:meMBN9vzzNTdme6ajcmFakw6jCQ=","Date":"Fri, 03 Jul 2015 15:29:24 +0700","digest":"meMBN9vzzNTdme6ajcmFakw6jCQ=","hash":"dcOlWo5t6lQ3zSNIjiNFaOODV3U="}

        $data = $method.'+'.$path.'+'.$date;
        // $data = 'GET+/profile+Fri, 03 Jul 2015 15:29:24 +0700';
        // GET+/profile+2015-04-23 11:36:20
        // $secretKey = "";
        // 5hMJoGHKo6gG2R7
        $hash_hmac = hash_hmac('SHA512', $data, $secretKey, FALSE);
        $digest = base64_encode($hash_hmac);
        // var_dump(hash_hmac('SHA1', "abc", "secret", TRUE));
        $headers[] = "Authorization: ".$upn." ".$this->parameter[$upn_key].":".$digest;

        $headers[] = "X-".$upn."-Date: ".$date;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        echo "URL: ".$url;
        echo "<pre>";
        print_r($headers);
        echo "</pre>";
        $server_output = curl_exec ($ch);
        // $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        // $header = substr($server_output, 0, $header_size);
        echo "Response:<br>";
        echo "<iframe width='1100px' height='600px' srcdoc='".print_r($server_output, true)."'></iframe>";
        curl_close ($ch);
	}

    protected function secondsToTime($seconds) {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
    }

    protected function get_file_info($file_name)
    {
        $data = array();
        $structure = array(
            "device_name",
            "channel",
            "stream",
            "start_date",
            "end_date"
        );
        // explode name
        $expl_filename = explode("_", $file_name);
        for ($i=0; $i < count($structure); $i++) 
        { 
            $data[$structure[$i]] = $expl_filename[$i];
        }
        $data['end_date'] = explode(".", $data['end_date']);
        $data['end_date'] = $data['end_date'][0];
        return $data;
    }

    protected function human_filesize($bytes, $decimals = 2) {
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }
}


