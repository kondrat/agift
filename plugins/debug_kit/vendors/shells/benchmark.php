<?php
/* SVN FILE: $Id$ */
/**
 * Benchmark Shell.
 *
 * Provides basic benchmarking of application requests 
 * functionally similar to Apache AB
 *
 * PHP versions 4 and 5
 *
 * CakePHP :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2006-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2006-2008, Cake Software Foundation, Inc.
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP Project
 * @package       cake
 * @subpackage    cake.debug_kit.vendors.shells
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Benchmark Shell Class
 *
 * @package cake
 * @subpackage cake.debug_kit.vendors.shells
 * @todo Print/export time detail information
 * @todo Export/graphing of data to .dot format for graphviz visualization
 * @todo Make calculated results round to leading significant digit position of std dev.
 */
class BenchmarkShell extends Shell {
	
	/**
	 * Main execution of shell
	 *
	 * @return void
	 * @access public
	 */
	function main() {
		if (empty($this->args) || count($this->args) > 1) {
			return $this->help();
		}

		$url = $this->args[0];
		$defaults = array('t' => 100, 'n' => 10);
		$options  = array_merge($defaults, $this->params);
		$times = array();
		
		$this->out(String::insert(__('-> Testing :url', true), compact('url')));
		$this->out("");
		for ($i = 0; $i < $options['n']; $i++) {
			if (floor($options['t'] - array_sum($times)) <= 0 || $options['n'] <= 1) {
				break;
			}
			
			$start = microtime(true);
			file_get_contents($url);
			$stop = microtime(true);
			
			$times[] = $stop - $start;
		}
		
		$this->_results($times);
	}
	
	
	/**
	 * Prints calculated results
	 *
	 * @param array $times Array of time values
	 * @return void
	 * @access protected
	 */
	function _results($times) {
		$duration = array_sum($times);
		$requests = count($times);
		
		$this->out(String::insert(__('Total Requests made: :requests', true), compact('requests')));
		$this->out(String::insert(__('Total Time elapsed: :duration (seconds)', true), compact('duration')));
		
		$this->out("");
		
		$this->out(String::insert(__('Requests/Second: :rps req/sec', true), array(
				'rps' => round($requests / $duration, 3)
		)));
		
		$this->out(String::insert(__('Average request time: :average-time seconds', true), array(
				'average-time' => round($duration / $requests, 3)
		)));
		
		$this->out(String::insert(__('Standard deviation of average request time: :std-dev', true), array(
				'std-dev' => round($this->_deviation($times, true), 3)
		)));
		
		$this->out(String::insert(__('Longest/shortest request: :longest sec/:shortest sec', true), array(
				'longest' => round(max($times), 3),
				'shortest' => round(min($times), 3)
		)));
		
		$this->out("");
		
	}
	

	/**
	 * One-pass, numerically stable calculation of population variance.
	 *
	 * Donald E. Knuth (1998). 
	 * The Art of Computer Programming, volume 2: Seminumerical Algorithms, 3rd edn., 
	 * p. 232. Boston: Addison-Wesley.
	 *
	 * @param array $times Array of values
	 * @param boolean $sample If true, calculates an unbiased estimate of the population 
	 * 						  variance from a finite sample.
	 * @return float Variance
	 * @access protected
	 */
	function _variance($times, $sample = true) {
		$n = $mean = $M2 = 0;

		foreach($times as $time){
			$n += 1;
			$delta = $time - $mean;
			$mean = $mean + $delta/$n;
			$M2 = $M2 + $delta*($time - $mean);
		}
		
		if ($sample) $n -= 1;
		
		return $M2/$n;
	}
	
	/**
	 * Calculate the standard deviation.
	 *
	 * @param array $times Array of values
	 * @return float Standard deviation
	 * @access protected
	 */
	function _deviation($times, $sample = true) {
		return sqrt($this->_variance($times, $sample));
	}
		
	/**
	 * Help for Benchmark shell
	 *
	 * @return void
	 * @access public
	 */
	function help() {
		$this->out(__("DebugKit Benchmark Shell", true));
		$this->out("");
		$this->out(__("\tAllows you to obtain some rough benchmarking statistics \n\tabout a fully qualified URL.", true));
		$this->out("");
		$this->out(__("\tUse:", true));
		$this->out(__("\t\tcake benchmark [-n iterations] [-t timeout] url", true));
		$this->out("");
		$this->out(__("\tParams:", true));
		$this->out(__("\t\t-n Number of iterations to perform. Defaults to 10. \n\t\t   Must be an integer.", true));
		$this->out(__("\t\t-t Maximum total time for all iterations, in seconds. \n\t\t   Defaults to 100. Must be an integer.", true));
		$this->out("");
		$this->out(__("\tIf a single iteration takes more than the \n\ttimeout specified, only one request will be made.", true));
		$this->out("");
		$this->out(__("\tExample Use:", true));
		$this->out(__("\t\tcake benchmark -n 10 -t 100 http://localhost/testsite", true));
		$this->out("");
		$this->out(__("\tNote that this benchmark does not include browser render time", true));
		$this->out("");
		$this->hr();
		$this->out("");
	}
}

?>
