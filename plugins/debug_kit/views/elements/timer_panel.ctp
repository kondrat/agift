<?php
/* SVN FILE: $Id$ */
/**
 * Timer Panel Element
 *
 * 
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
 * @subpackage    cake.debug_kit.views.elements
 * @since         
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
if (!isset($debugKitInHistoryMode)):
	$timers = DebugKitDebugger::getTimers();
	$currentMemory = DebugKitDebugger::getMemoryUse();
	$peakMemory = DebugKitDebugger::getPeakMemoryUse();
	$requestTime = DebugKitDebugger::requestTime();	
else:
	$content = $toolbar->readCache('timer', $this->params['pass'][0]);
	if (is_array($content)):
		extract($content);
	endif;
endif;
?>
<h2><?php __('Memory'); ?></h2>
<div class="current-mem-use">
	<?php echo $toolbar->message(__('Current Memory Use',true), $number->toReadableSize($currentMemory)); ?>
</div>
<div class="peak-mem-use">
<?php
	echo $toolbar->message(__('Peak Memory Use', true), $number->toReadableSize($peakMemory)); ?>
</div>

<h2><?php __('Timers'); ?></h2>
<div class="request-time">
	<?php $totalTime = sprintf(__('%s (seconds)', true), $number->precision($requestTime, 6)); ?>
	<?php echo $toolbar->message(__('Total Request Time:', true), $totalTime)?>
</div>

<?php
$maxTime = 0;
foreach ($timers as $timerName => $timeInfo):
	$maxTime += $timeInfo['time'];
endforeach;

foreach ($timers as $timerName => $timeInfo):
	$rows[] = array(
		$timeInfo['message'],
		$number->precision($timeInfo['time'], 6),
		$simpleGraph->bar($number->precision($timeInfo['time'], 6), array('max' => $maxTime))
	);
	$headers = array(__('Message', true), __('Time in seconds', true), __('Graph', true));
endforeach;

echo $toolbar->table($rows, $headers, array('title' => 'Timers')); 

if (!isset($debugKitInHistoryMode)):
	$toolbar->writeCache('timer', compact('timers', 'currentMemory', 'peakMemory', 'requestTime'));
endif;
?>
