<?php
require APPPATH . '/helpers/' . 'my_cookie_helper.php';
class My_filter_helper
{
    private $_filters = array();
    private $_input = array();
    private $_prefix;


    public function __construct($input, $prefix)
    {
        $this->_input = $input;
        $this->_prefix = $prefix;
    }


    public function processAndStoreFilters()
    {
        $filters = array();
        foreach ($this->_input as $key => $val) {
            $actualVal = $this->_getActualVal($key, $val);
            My_cookie_helper::setCookie($this->_prefix . '_' . $key, $actualVal);
            $filters[$key] = $actualVal;
        }
        Debug::log($filters);
        $this->_filters = $filters;
    }


    private function _getActualVal($key, $val)
    {
        if (empty($val)) {
            return My_cookie_helper::getCookie($key);
        }
        return $val;
    }


    public function get($key)
    {
        if (empty($this->_filters[$key])) {
            return;
        }
        return $this->_filters[$key];
    }
}
