<?php

namespace Virtualizor;

class Admin
{

    private $key =  'key';
    private $pass = 'pass';
    private $ip = 'ip';
    private $port = 4085;
    private $protocol = 'https';

    
    /**
     * __construct
     *
     * @param  mixed $ip
     * @param  mixed $key
     * @param  mixed $pass
     * @param  mixed $port
     * @return void
     */
    public function __construct($ip, $key, $pass, $port = 4085)
    {
        $this->key = $key;
        $this->pass = $pass;
        $this->ip = $ip;
        $this->port = $port;
        if ($port != 4085) {
            $this->protocol = 'http';
        }
    }


    /**
     * generateRandStr
     *
     * @param  mixed $length
     * @return void
     */
    public function generateRandStr($length)
    {
        $randstr = "";
        for ($i = 0; $i < $length; $i++) {
            $randnum = mt_rand(0, 61);
            if ($randnum < 10) {
                $randstr .= chr($randnum + 48);
            } elseif ($randnum < 36) {
                $randstr .= chr($randnum + 55);
            } else {
                $randstr .= chr($randnum + 61);
            }
        }
        return strtolower($randstr);
    }


    /**
     * make_apikey
     *
     * @param  mixed $key
     * @param  mixed $pass
     * @return void
     */
    public function make_apikey($key, $pass)
    {
        return $key . md5($pass . $key);
    }


    /**
     * call
     *
     * @param  mixed $path
     * @param  mixed $data
     * @param  mixed $post
     * @param  mixed $cookies
     * @return void
     */
    public  function call($path, $data = array(), $post = array(), $cookies = array())
    {

        $key = $this->generateRandStr(8);
        $apikey = $this->make_apikey($key, $this->pass);
        $url = ($this->protocol) . '://' . $this->ip . ':' . $this->port . '/' . $path;
        $url .= (strstr($url, '?') ? '' : '?');
        $url .= '&api=serialize&apikey=' . rawurlencode($apikey);

        // Pass some data if there
        if (!empty($data)) {
            $url .= '&apidata=' . rawurlencode(base64_encode(serialize($data)));
        }
        // Set the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        // Time OUT
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);

        // Turn off the server and peer verification (TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        // UserAgent
        curl_setopt($ch, CURLOPT_USERAGENT, 'Softaculous');

        // Cookies
        if (!empty($cookies)) {
            curl_setopt($ch, CURLOPT_COOKIESESSION, true);
            curl_setopt($ch, CURLOPT_COOKIE, http_build_query($cookies, '', '; '));
        }

        if (!empty($post)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Get response from the server.
        $resp = curl_exec($ch);
        curl_close($ch);

        // The following line is a method to test
        //if(preg_match('/sync/is', $url)) echo $resp;

        if (empty($resp)) {
            return false;
        }

        $r = @unserialize($resp);

        if (empty($r)) {
            return false;
        }

        return $r;
    }


    /**
     * addvs_v2
     *
     * @param  mixed $post
     * @param  mixed $cookies
     * @return void
     */
    public function createVps($post, $cookies = '')
    {
        $path = 'index.php?act=addvs';
        $post['addvps'] = 1;
        $post['node_select'] = 1;
        $ret = $this->call($path, '', $post, $cookies);
        return array(
            'title' => $ret['title'],
            'error' => @empty($ret['error']) ? array() : $ret['error'],
            'vs_info' => $ret['newvs'],
            'globals' => $ret['globals'],
            'done' => $ret['done']
        );
    }
}
