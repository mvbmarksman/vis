<?php
require APPPATH . '/helpers/' . 'my_cookie_helper.php';
class My_filter_helper
{
    private $_cookiePrefix;
    private $_postSuffix;


    public function __construct($cookiePrefix, $postSuffix)
    {
        $this->_cookiePrefix = $cookiePrefix;
        $this->_postSuffix = $postSuffix;
    }


    public function storeAndGet($key)
    {

    	$postKey = $key . '_' . $this->_postSuffix;
    	$cookieKey = $this->_cookiePrefix . '_' . $key;

    	if (isset($_POST[$postKey])) {
    		My_cookie_helper::setCookie($cookieKey, $_POST[$postKey]);
    		$this->_filters[$key] = $_POST[$postKey];
    		return $_POST[$postKey];
    	} else {
    		$cookieVal = My_cookie_helper::getCookie($cookieKey);
    		Debug::show('fetching from cookie ' . $cookieKey . ', fetched: ' . $cookieVal);
    		return $cookieVal;
    	}
    }
}
