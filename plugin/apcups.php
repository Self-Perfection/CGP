<?php

# Collectd APC UPS plugin

require_once 'conf/common.inc.php';
require_once 'type/Default.class.php';

## LAYOUT
# apcups/
# apcups/charge.rrd
# apcups/frequency-input.rrd
# apcups/percent-load.rrd
# apcups/temperature.rrd
# apcups/timeleft.rrd
# apcups/voltage-battery.rrd
# apcups/voltage-input.rrd
# apcups/voltage-output.rrd

$obj = new Type_Default($CONFIG, $_GET);

switch($obj->args['type']) {
	case 'charge':
		$obj->data_sources = array('value');
		$obj->legend = array('value' => 'Charge');
		$obj->colors = array('value' => '0000f0');
		$obj->rrd_title = sprintf('UPS Charge');
		$obj->rrd_vertical = 'Ampere hours';
	break;
	case 'frequency':
		$obj->data_sources = array('value');
		$obj->legend = array('value' => 'Input Frequency');
		$obj->colors = array('value' => '0000f0');
		$obj->rrd_title = sprintf('UPS Input Frequency');
		$obj->rrd_vertical = 'Hertz';
	break;
	case 'percent':
		$obj->data_sources = array('value');
		$obj->legend = array('value' => 'Load');
		$obj->colors = array('value' => '0000f0');
		$obj->rrd_title = sprintf('UPS Load');
		$obj->rrd_vertical = 'Percent';
	break;
	case 'temperature':
		$obj->data_sources = array('value');
		$obj->legend = array('value' => 'Temperature');
		$obj->colors = array('value' => '0000f0');
		$obj->rrd_title = sprintf('UPS Temperature');
		$obj->rrd_vertical = 'Celsius';
	break;
	case 'timeleft':
		$obj->data_sources = array('value');
		$obj->legend = array('value' => 'Time Left');
		$obj->colors = array('value' => '0000f0');
		$obj->rrd_title = sprintf('UPS Time Left');
		$obj->rrd_vertical = 'Seconds';
	break;
	case 'voltage':
		$obj->order = array('battery', 'input', 'output');
		$obj->legend = array(
			'battery' => 'Battery Voltage',
			'input' => 'Input Voltage',
			'output' => 'Output Voltage'
		);
		$obj->colors = array(
			'battery' => '0000f0',
			'input' => '00f000',
			'output' => 'f00000'
		);
		$obj->rrd_title = sprintf('UPS Voltage');
		$obj->rrd_vertical = 'Volt';
	break;
}
$obj->rrd_format = '%5.1lf%s';

# backwards compatibility
if ($CONFIG['version'] < 5 &&
	in_array($obj->args['type'], array('frequency', 'percent', 'timeleft'))) {

	$obj->data_sources = array($obj->args['type']);

	$obj->legend[$obj->args['type']] = $obj->legend['value'];
	unset($obj->legend['value']);

	$obj->colors[$obj->args['type']] = $obj->colors['value'];
	unset($obj->colors['value']);
}

$obj->rrd_graph();

