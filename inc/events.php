<?php

/*
 *  Copyright (c) 2010-2012 Tinyboard Development Group
 */

if (realpath($_SERVER['SCRIPT_FILENAME']) == str_replace('\\', '/', __FILE__)) {
	// You cannot request this file directly.
	exit;
}

function event() {
	global $events;
	
	$args = func_get_args();
	
	$event = $args[0];
	
	$args = array_splice($args, 1);
	
	if (!isset($events[$event]))
		return false;
	
	foreach ($events[$event] as $callback) {
		if (!is_callable($callback))
			error('Event handler for ' . $event . ' is not callable!');
		if ($error = call_user_func_array($callback, $args))
			return $error;
	}
	
	return false;
}

function event_handler($event, $callback) {
	global $events;
	
	if (!isset($events[$event]))
		$events[$event] = Array();
	
	$events[$event][] = $callback;
}

function reset_events() {
	global $events;
	
	$events = Array();
}

