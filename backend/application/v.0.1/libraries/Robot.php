<?php 

class Robot {
    private $_cookiefile;

    public function __construct($cookiefile) {
        if (!is_writable($cookiefile)) {
            throw new Exception('Cannot write cookiefile: ' . $cookiefile);
        }
        $this -> _cookiefile = $cookiefile;
    }

    public function get($url, $referer = 'http://www.google.com', $data = false) {
        // Setup cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this -> _cookiefile);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this -> _cookiefile);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);

        // Is there data to post
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        return curl_exec($ch);
    }

}