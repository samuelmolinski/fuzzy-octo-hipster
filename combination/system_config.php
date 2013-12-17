<?php 

	$current = 'a:31:{i:0;a:2:{i:0;s:10:"rule_2_2_2";i:1;s:1:"c";}i:1;a:2:{i:0;s:15:"rule_b1_plus_b3";i:1;s:1:"c";}i:2;a:2:{i:0;s:8:"rule_1a1";i:1;s:1:"c";}i:3;a:2:{i:0;s:8:"rule_1a2";i:1;s:1:"c";}i:4;a:2:{i:0;s:8:"rule_1a8";i:1;s:1:"c";}i:5;a:2:{i:0;s:8:"rule_1a6";i:1;s:1:"c";}i:6;a:2:{i:0;s:9:"rule_1a5a";i:1;s:1:"c";}i:7;a:2:{i:0;s:9:"rule_1a5b";i:1;s:1:"c";}i:8;a:2:{i:0;s:8:"rule_1a7";i:1;s:1:"c";}i:9;a:2:{i:0;s:8:"rule_1a3";i:1;s:1:"c";}i:10;a:2:{i:0;s:8:"rule_1a4";i:1;s:1:"c";}i:11;a:2:{i:0;s:9:"rule_a1d1";i:1;s:1:"c";}i:12;a:2:{i:0;s:7:"rule_1d";i:1;s:1:"c";}i:13;a:3:{i:0;s:8:"rule_1b3";i:1;s:1:"c";i:2;s:4:"list";}i:14;a:3:{i:0;s:8:"rule_1b2";i:1;s:1:"c";i:2;s:4:"list";}i:15;a:3:{i:0;s:8:"rule_1b1";i:1;s:1:"c";i:2;s:4:"list";}i:16;a:2:{i:0;s:7:"rule_b1";i:1;s:1:"c";}i:17;a:2:{i:0;s:7:"rule_b2";i:1;s:1:"c";}i:18;a:2:{i:0;s:7:"rule_b3";i:1;s:1:"c";}i:19;a:2:{i:0;s:8:"rule_b4a";i:1;s:1:"c";}i:20;a:2:{i:0;s:8:"rule_b4b";i:1;s:1:"c";}i:21;a:2:{i:0;s:8:"rule_b4c";i:1;s:1:"c";}i:22;a:2:{i:0;s:9:"rule_b5a1";i:1;s:1:"c";}i:23;a:2:{i:0;s:9:"rule_b5a2";i:1;s:1:"c";}i:24;a:2:{i:0;s:9:"rule_b5a3";i:1;s:1:"c";}i:25;a:2:{i:0;s:9:"rule_b5b1";i:1;s:1:"c";}i:26;a:2:{i:0;s:9:"rule_b5b2";i:1;s:1:"c";}i:27;a:2:{i:0;s:9:"rule_b5b3";i:1;s:1:"c";}i:28;a:2:{i:0;s:9:"rule_b5c1";i:1;s:1:"c";}i:29;a:2:{i:0;s:9:"rule_b5c2";i:1;s:1:"c";}i:30;a:2:{i:0;s:9:"rule_b6a1";i:1;s:1:"c";}}';

	//  array ( ruleName, weight, list)
	$restrictions = array ( 
		array ('rule_2_2_2',		1, ), 
		array ('rule_b1_plus_b3',	1, ), 
		array ('rule_1a1',			1, ), 
		array ('rule_1a2',			1, ), 
		array ('rule_1a8',			1, ), 
		array ('rule_1a6',			1, ), 
		array ('rule_1a5a',			1, ), 
		array ('rule_1a5b',			1, ), 
		array ('rule_1a7',			1, ), 
		array ('rule_1a3',			1, ), 
		array ('rule_1a4',			1, ), 
		array ('rule_a1d1',			1, ), 
		array ('rule_1d',			1, ), 
		array ('rule_1b3',			1,	'list', ), 
		array ('rule_1b2',			1,	'list', ), 
		array ('rule_1b1',			1,	'list', ), 
		array ('rule_b1',			1, ), 
		array ('rule_b2',			1, ), 
		array ('rule_b3',			1, ), 
		array ('rule_b4a',			1, ), 
		array ('rule_b4b',			1, ), 
		array ('rule_b4c',			1, ), 
		array ('rule_b5a1',			1, ), 
		array ('rule_b5a2',			1, ), 
		array ('rule_b5a3',			1, ), 
		array ('rule_b5b1',			1, ), 
		array ('rule_b5b2',			1, ), 
		array ('rule_b5b3',			1, ), 
		array ('rule_b5c1',			1, ), 
		array ('rule_b5c2',			1, ), 
		array ('rule_b6a1',			1, )
	);

	//var_export(unserialize($current));
	echo "\n\r";

	echo serialize($restrictions);
	//print_r($var);