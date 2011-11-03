<?php
class Debug {

	public static function dump($data) {
	    echo "<div style=\"color: #606; padding: 10px; border: 1px dashed #000\">";
	    echo "<pre>";
	    $val = print_r($data, true);
	    $val = htmlentities( $val );
	    $val = preg_replace( "/\[(.+)\]\s+=(.*)/", "<span style=\"color: #006\">[$1]</span> = $2", $val );
	    $val = preg_replace( "/(\w+)\s+Object\n/", "<span style=\"color: #066\">$1 Object</span>\n", $val );
	    $val = str_replace( "Array", "<span style=\"color: #066\">Array</span>", $val );
	    $val = str_replace( "Resource", "<span style=\"color: #066\">Resource</span>", $val );
	    echo $val;
	    echo "</pre>";
	    echo "</div>";
	}

	public static function log($data = array(), $level = null) {
		$level = empty($level) ? 'error' : $level;
		$trace = debug_backtrace();
		$class = $trace[1]['class'];
		$method = $trace[1]['function'];
		$line = $trace[0]['line'];
		$msg = count($data) == 0 ? '' : ' -- ' . print_r($data, true);
		log_message($level, "$class::$method() [line:$line]" . $msg);
	}
}