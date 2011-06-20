<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* View Object
* 
* Renders a layout with partials (blocks) inside.
* Renders partials only (header,content,footer. etc).
* Allows a plugin or module to render a partial.
* 
* 
* Version 3.0.7 Wiredesignz (c) 2008-10-01
**/
class View
{
    public $layout;
    
    private $partials = array();
    
    private $vars = array();
    
    private static $ci;
    
    public function __construct($file = NULL, $data = NULL) /* you can assign a template & data */
    {
        (isset(self::$ci)) OR self::$ci = get_instance();
        
        $this->layout = $file;
        
        (is_array($data)) AND $this->vars = $data;
    }
       
    public function load($view, $file = NULL, $data = NULL) /* add a partial & data */
    {
        if ( ! isset($this->partials[$view]))
        
            $this->partials[$view] = (is_object($file)) ? $file : new View($file);
        
        (is_array($data)) AND $this->partials[$view]->set($data);
        
        return $this->partials[$view];
    }
    
    public function __set($variable, $value)
    {
        (is_array($value)) ? $this->set($value) : $this->set($variable, $value);
    }
    
    public function set($var, $value = NULL) /* store data for this view */
    {
        ($var) ? (is_array($var)) ? $this->vars = $var : $this->vars[$var] = $value : NULL;
    }

    public function __get($variable)
    {
        return $this->fetch($variable);
    }
        
    public function fetch($key = NULL) /* returns data value(s) */
    {
        return ($key) ? (isset($this->vars[$key])) ? $this->vars[$key] : NULL : $this->vars;
    }
        
    public function __toString()
    {        
        return $this->render(TRUE);
    }
    
    public function render($render = FALSE) /* render the view */
    {
        self::$ci->load->vars($this->vars);
        
        if ($this->layout)
        {
            return self::$ci->load->view($this->layout, $this->partials, $render);
        }
        else 
        {
            ob_start();
            
            foreach($this->partials as $partial) 

                $partial->render();
                
            if ($render) return ob_get_clean();
            
            echo ob_get_clean();
        }
    }
} 