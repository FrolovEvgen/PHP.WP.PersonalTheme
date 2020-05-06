<?php

/* 
 * The MIT License
 *
 * Copyright 2020 E.Frolov <frolov@amiriset.com>.
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
 * Class <b>AbstractParamEntity</b> is abstract class with parameters.
 *
 * @author Frolov E. <frolov@amiriset.com>
 */
abstract class AbstractParamEntity extends AbstractEntity { 
    
    //--------------------------------------------------------------------------
    // CONSTRUCTOR
    //--------------------------------------------------------------------------
    
    /**
	 * Destroy instance.
	 */
    function __destruct() {
        parent::__destruct();
        unset($this->_properties);
    }
    
    //--------------------------------------------------------------------------
    // PUBLIC SECTION
    //--------------------------------------------------------------------------
    
    /**
     * Get parameter.
     * 
     * @access public
     * @param string $key
     * @return mixed
     */
    function getParam($key) {
        return ($this->getProperties()->get($key));
    }
    
    /**
     * Set parameter.
     * 
     * @access public
     * @param string $key
     * @param  mixed $value
     */
    function setParam($key, $value) {
        $this->getProperties()->set($key, $value);
    }
    
    /**
     * Get property list.
     * 
     * @access public
     * @return Property
     */
    function getProperties() {
        if ($this->properties === NULL) {
            $this->properties = new Properties();
        }
        return ($this->properties);
    }
    
    /**
     * Set property list.
     * 
     * @access public
     * @param Properties $properties
     */
    function setProperties($properties) {
        $this->properties = $properties;
    }
    //--------------------------------------------------------------------------
    // PROTECTED SECTION
    //--------------------------------------------------------------------------
    
    //--------------------------------------------------------------------------
    // PRIVATE SECTION
    //--------------------------------------------------------------------------   
    /**
     * Object properties.
     * 
     * @access private
     * @var Properties
     */
    private $properties = NULL;
}


