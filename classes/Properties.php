<?php

/*
 * The MIT License
 *
 * Copyright 2020 Frolov E. <frolov@amiriset.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

if (!defined('THEME_PATH')) {
    header('Refresh: 0; url=' . ($_SERVER['HTTP_HOST']));
}
/**
 * Class <b>Properties</b> is key/value list.
 *
 * @author Frolov E. <frolov@amiriset.com>
 */
class Properties extends AbstractEntity {
	    
    //--------------------------------------------------------------------------
    // CONSTRUCTOR
    //--------------------------------------------------------------------------

    /**
	 * Create new instance.
	 * 
	 * @param string $strName (optional)  Specify group name.
	 */
	function __construct($name = 'root') {
        if ($name === NULL) {
           $name = 'root';           
        }
		$this->groupName = $name;
        $this->setInit(TRUE);
        $this->setEntityName('Properties.' . $name);
    }
    
	/**
	 * Destroy instance.
	 */
	function __destruct() {
        parent::__destruct();
        unset($this->groupName);
        unset($this->map);
    }
	
    //--------------------------------------------------------------------------
    // PUBLIC SECTION
    //--------------------------------------------------------------------------

    /**
     * Remove all properties.
	 * 
     * @access public
     */
    public function clear() {
        $this->map = NULL;
        $this->map = [];
    }
	
	/**
	 * Parse property from string.
	 * 
	 * @access public
	 * @param string $property String as 'key=value'
	 */
	public function parse($property) {
        $key = strstr($property, '=', TRUE);
        $val = substr(strstr($property, '='), 1);
        $this->set($key, $val);
    }
	
	/**
	 * Get property value by key.
	 * 
	 * @access public
	 * @param string $key Property key.
	 * @return mixed Property value.
	 */
	public function get($key) {
        if ($this->isExists($key)) {
            return ($this->map[$key]);
        }
        return NULL;
    }
	
	/**
	 * Get properties as array.
	 * 
	 * @access public
	 * @return array Array of properties.
	 */
	public function getMap() {
		if ($this->map === NULL) {
			$this->map = [];
		}
        return ($this->map);
	}
	
	/**
	 * Check if properties empty.
	 * 
	 * @access public.	
	 * @return boolean Return TRUE if has any property value.
	 */
	public function isEmpty() {		
        return (count($this->map) === 0);
    }
	
	/**
	 * Check if Key exists.
	 * 
	 * @access public.
	 * @param string $key Key.
	 * @return boolean Return TRUE if key exists..
	 */
	public function isExists($key) {
        return (key_exists($key, $this->map));
    }
	
	/**
	 * Set properties array.
	 * 
	 * @access public.
	 * @param array $array
	 */
	public function setMap($array) {
		$this->map = $array;
	}
	
	/**
	 * Set property key/value.
	 * If key exists its replace old value.
	 * 
	 * @param string $key Key.
	 * @param mixed $value Value.
	 */
	public function set($key, $value) {
        $this->map[$key] = $value;
    }    
        
    //--------------------------------------------------------------------------
    // PROTECTED SECTION
    //--------------------------------------------------------------------------
    
    //--------------------------------------------------------------------------
    // PRIVATE SECTION
    //--------------------------------------------------------------------------
	
	/**
	 * Properties group name.
	 * @var string
	 */
	private $groupName;
	
	/**
	 * Properties array.
	 * @var array 
	 */
	private $map = array();
}
