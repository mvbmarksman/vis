<?php
require APPPATH . '/helpers/' . 'my_cookie_helper.php';
class My_filter_helper
{
    private $_filters = array();


    public function fetchAndStoreFilters($input, $prefix)
    {
        if (!is_array($input) || empty($prefix)) {
            throw new InvalidArgumentException('Must supply a valid input array and prefix.');
        }
        $filters = array();
        foreach ($input as $key => $val) {
            $actualVal = $this->_getActualVal($key, $val);
            My_cookie_helper::setCookie($prefix . '_' . $key, $actualVal);
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
