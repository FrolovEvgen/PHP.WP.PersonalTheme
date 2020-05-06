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
 * Class <b>AbstractEntity</b> is base class for complex objects.
 *
 * @author Frolov E. <frolov@amiriset.com>
 */
abstract class AbstractEntity {
	
    //--------------------------------------------------------------------------
    // CONSTRUCTOR
    //--------------------------------------------------------------------------
    
	/**
	 * Destroy instance.
	 */
	function __destruct() {
        $this->setInit(FALSE);

        unset($this->init);
        unset($this->entityName);
	}	
    
	//--------------------------------------------------------------------------
    // PUBLIC SECTION
    //--------------------------------------------------------------------------
    
	/**
	 * Get initialization status.
	 * 
	 * @access public
	 * @return boolean Flag's value.
	 */
	function isInit() {
        return $this->init;
	}
	
	/**
	 * Set initialization status.
	 * 
	 * @access public
	 * @param boolean $value Initialization value.
	 * - TRUE = Entity init.
	 * - FALSE = Entity uninit.
	 */
	function setInit($value) {
        if ($this->init !== $value) {
            $this->init = $value;
        }
	}
	
	/**
	 * Get entity name.
	 * 
	 * @access public
	 * @return string Name.
	 */
	function getEntityName() {
		return $this->entityName;
	}
	
	/**
	 * Set entity name. 
	 * 
	 * @access public
	 * @param string $value Name.
	 */
	function setEntityName($value) {
		$this->entityName = $value;
	}
    
    //--------------------------------------------------------------------------
    // PROTECTED SECTION
    //--------------------------------------------------------------------------
    
    //--------------------------------------------------------------------------
    // PRIVATE SECTION
    //--------------------------------------------------------------------------
    
	/**
	 * Entity name.
	 * 
	 * @access private
	 * @var string 
	 */
	private $entityName = '';
	
	/**
	 * Entity init flag.
	 * 
	 * @access private
	 * @var boolean
	 */
	private $init = FALSE;
}
