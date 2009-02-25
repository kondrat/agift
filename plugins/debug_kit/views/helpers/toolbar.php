<?php
/* SVN FILE: $Id$ */
/**
 * Abstract Toolbar helper.  Provides Base methods for content
 * specific debug toolbar helpers.  Acts as a facade for other toolbars helpers as well.
 *
 * helps with development.
 *
 * PHP versions 4 and 5
 *
 * CakePHP :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2006-2008, Cake Software Foundation, Inc.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2006-2008, Cake Software Foundation, Inc.
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP Project
 * @package       debug_kit
 * @subpackage    debug_kit.views.helpers
 * @since         v 1.0
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
App::import('Vendor', 'DebugKit.DebugKitDebugger');

class ToolbarHelper extends AppHelper {
/**
 * settings property to be overloaded.  Subclasses should specify a format
 *
 * @var array
 * @access public
 */
	var $settings = array();
/**
 * flag for whether or not cache is enabled.
 *
 * @var boolean
 **/
	var $_cacheEnabled = false;
/**
 * Construct the helper and make the backend helper.
 *
 * @param string $options 
 * @access public
 * @return void
 */
	function __construct($options = array()) {
		$this->_myName = strtolower(get_class($this));
		if ($this->_myName !== 'toolbarhelper') {
			return;
		}
		if (!isset($options['output'])) {
			$options['output'] = 'DebugKit.HtmlToolbar';
		}
		App::import('Helper', $options['output']);
		$className = $options['output'];
		if (strpos($options['output'], '.') !== false) {
			list($plugin, $className) = explode('.', $options['output']);
		}
		$this->_backEndClassName =  $className;
		$this->helpers = array($options['output']);
		if (isset($options['cacheKey']) && isset($options['cacheConfig'])) {
			$this->_cacheKey = $options['cacheKey'];
			$this->_cacheConfig = $options['cacheConfig'];
			$this->_cacheEnabled = true;
		}
	}

/**
 * Get the name of the backend Helper
 * used to conditionally trigger toolbar output
 *
 * @return string
 **/
	function getName() {
		return $this->_backEndClassName;
	}
/**
 * call__
 *
 * Allows method calls on backend helper
 *
 * @param string $method 
 * @param mixed $params 
 * @access public
 * @return void
 */	
	function call__($method, $params) {
		if (method_exists($this->{$this->_backEndClassName}, $method)) {
			return $this->{$this->_backEndClassName}->dispatchMethod($method, $params);
		}
	}
/**
 * Allows for writing to panel cache from view.
 * Some panels generate all variables in the view by 
 * necessity ie. Timer.  Using this method, will allow you to replace in full
 * the content for a panel.
 *
 * @param string $name Name of the panel you are replacing.
 * @param string $content Content to write to the panel.
 * @return boolean Sucess of write.
 **/
	function writeCache($name, $content) {
		if (!$this->_cacheEnabled) {
			return false;
		}
		$existing = (array)Cache::read($this->_cacheKey, $this->_cacheConfig);
		$existing[0][$name]['content'] = $content;
		return Cache::write($this->_cacheKey, $existing, $this->_cacheConfig);
	}
/**
 * Read the toolbar
 *
 * @param string $name Name of the panel you want cached data for
 * @return mixed Boolean false on failure, array of data otherwise.
 **/
	function readCache($name, $index = 0) {
		if (!$this->_cacheEnabled) {
			return false;
		}
		$existing = (array)Cache::read($this->_cacheKey, $this->_cacheConfig);
		if (!isset($existing[$index][$name]['content'])) {
			return false;
		}
		return $existing[$index][$name]['content'];
	}
/**
 * postRender method
 *
 * Custom Callback defined in DebugView to allow helpers to modify
 * View output after all rendering is complete.
 *
 * @return void
 * @access public
 */
	function postRender() {
		$this->_send();
	}
}