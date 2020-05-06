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
 * Class <b>Settings</b> is used to control the basic settings of a 
 * component loaded from a <code>*.ini</code> file or specified by local 
 * settings.
 *
 * @author Frolov E. <frolov@amiriset.com>
 */
class Settings extends AbstractParamEntity {
    
    //--------------------------------------------------------------------------
    // CONSTRUCTOR
    //--------------------------------------------------------------------------
    
    /**
     *  Create new instance.
     * 
     * @param string $fileName
     */
    function __construct() {        
        $this->setEntityName('settings');
    }
    
    /**
     * Destroy instance.
     */
    function __destruct() {
        parent::__destruct();
        unset($this->map);
    }
        
    //--------------------------------------------------------------------------
    // PUBLIC SECTION
    //--------------------------------------------------------------------------
    
    /**
     * Get property set by name.
     * 
     * @access public
     * @param string $name Name of set.
     * @return mixed Returns:
     *  - FALSE = if component not init.
     *  - NULL = if set not found
     *  - Property instance
     */
    public function get($name) {
        if (!$this->isInit()) {
            return (FALSE);
        }
        if($this->isExists($name)) {
            return ($this->map[$name]);
        }
        return (NULL);
    }
    
    /**
     * Set to property specified by name new key/value pair.
     * If property set not exits it create a new one.
     * 
     * @access public
     * @param string $name Name of property set.
     * @param string $key (optional) Parameter key.
     * @param mixed $value (optional) Parameter value.
     */
    public function set($name, $key = NULL, $value = NULL) {
               
        if (!$this->isExists($name)) {
            $this->map[$name] = new Properties($name);
        }
        if ($key !== NULL) {
            $this->get($name)->set($key, $value);
        }
    }
    
    /**
     * Load properties from file.
     * 
     * @access public
     * @param string $iniFileName (optional) Properties file name (*.ini)
     * @return boolean Operation result.
     */
    public function load($iniFileName = NULL) {        
        if ($iniFileName) {
            $this->setFileName($iniFileName);                        
        }   
        $loadResult = $this->loadFile();
        $this->setInit($loadResult);
        return ($loadResult);
    }   
    
    /**
     * Check if has any properties.
     * 
     * @access public 
     * @return boolean  Operation result.
     */
    public function isEmpty(){
        return (count($this->map) === 0);
    }
    
    /**
     * Check if specified property set exists.
     * 
     * @access public  
     * @param string $name Properties set name.
     * @return boolean  Operation result.
     */
    public function isExists($name){
        return (key_exists($name, $this->map));
    }
    
    /**
     * Set properties file name.
     * 
     * @access public 
     * @param string $iniFileName Filename without extension.
     */
    public function setFileName($iniFileName) {
        if ($iniFileName != NULL) {
            $this->setEntityName('settings[' . $iniFileName . ']');
            $this->setParam("settings_file", $iniFileName . '.ini');
        }
    }
    
    //--------------------------------------------------------------------------
    // PRIVATE SECTION
    //--------------------------------------------------------------------------
    
    /**
     * Saves loaded properties.
     * 
     * @access private
     * @var array
     */
    private $map = array();
    
    /**
     * Load ini file.
     * 
     * @access private
     * @return boolean Operation result.
     */
    private function loadFile() {
        // Get full Path.
        $fullPath = THEME_PATH . '\\lang\\' . $this->getParam('settings_file');

        // If exists we will load it and parse.
        if (file_exists($fullPath)) {
            if ($hf = fopen($fullPath, "r")) {
                $this->setInit(TRUE);
                $name = 'default';
                $this->set($name);
                $this->parseIni($hf);
                fclose($hf);
                return (TRUE);
            }
            // If file not open, create an error message.
            $errorMessage = 'FILE (' . $fullPath . '): file opening error!';
        } else {
            // If file not found, create an error message..
            $errorMessage = 'FILE (' . $fullPath . '): Not found!';
        }
        print('<p><b>Error:' . $errorMessage . '</b></p>');
        return (FALSE);
    }
    
    /**
     * Parse properties to sets.
     * 
     * @access private
     * @param resource $hf Opened file.
     */
    private function parseIni($hf) {
        while (!feof($hf)) {
            $buffer = trim(fgets($hf, 4096));
            switch(ord($buffer[0])){
                case(91):  // '['
                    preg_match_all('~\[(.*?)\]~is', $buffer, $tpl);
                    $name = $tpl[1][0];
                    $this->set($name);
                    break;
                case(0):   // ''
                case(9):   // 'TAB'
                case(10):  // 'NL'
                case(32):  // 'SPACE'
                case(35):  // '#'
                case(59):  // ';'
                    continue;
                default:
                    $key = strstr($buffer, '=', true);
                    $val = substr(strstr($buffer, '='), 1);
                    $this->set($name, $key, $val);
                    break;
            }
        }
    }
}
