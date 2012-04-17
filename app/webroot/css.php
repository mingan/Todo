<?php
/* SVN FILE: $Id$ */
/**
 * Short description for file.
 *
 * Long description for file
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.webroot
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
if (!defined('CAKE_CORE_INCLUDE_PATH')) {
	header('HTTP/1.1 404 Not Found');
	exit('File Not Found');
}
if (!class_exists('File')) {
	App::uses('File', 'Utility');
}

define('CACHE_TIMESTAMP_SUFFIX', '_timestamp');


	function make_clean_css($path, $name) {
		App::import('Vendor', 'csspp' . DS . 'csspp');
		$regs = null;
		preg_match('#(.*[/\\\\])(.+\.css)$#i', $path, $regs);
		$csspp = new csspp($regs[2], $regs[1], array('expanders' => false));
		$output = $csspp->process();
		return $output;
	}

	function parse_less ($path, $dest) {
		if (preg_match('#(.+)\.less$#i', $path, $regs)) {
			App::import('Vendor', 'lessphp', array('file' => 'lessphp' . DS . 'lessc.inc.php'));
			try {
				lessc::ccompile($regs[1] . '.less', $dest);
			} catch (exception $ex) {
				exit('lessc fatal error:<br />'.$ex->getMessage());
			}
		}
	}

	if (preg_match('|\.\.|', $url) || !preg_match('|^ccss/(.+)$|i', $url, $regs)) {
		die('Wrong file name.');
	}

	$filename = 'css/' . $regs[1];
	$filepathWithTimestamp = $filepath = CSS . $regs[1];
	$cachepath = 'css' . DS . str_replace(array('/','\\'), '-', $regs[1]);

	if (!file_exists($filepathWithTimestamp)) {
		die('Wrong file name.');
	}

	if (preg_match('#css/(.+)\.(less|css|php)$#i', $filename, $regs)) {
		$phpToExecute = $lessToParse = null;
		switch (strtolower($regs[2])) {
			case 'less':
				$lessToParse = $filename;
				$filepathWithTimestamp = $filename;
				$filename = $regs[1] . '_computed.css';
				$cachepath = 'css' . DS . str_replace(array('/','\\'), '-', $regs[1]);
				$filepath = $cachepath . '_computed.css';
				$cachepath .= '.css';
				break;
			case 'php':
				$phpToExecute = $regs[0];
				$filepathWithTimestamp = CSS . $regs[1] . '.json';
				$filename = $regs[1] . '_computed.css';
				$cachepath = 'css' . DS . str_replace(array('/','\\'), '-', $regs[1]);
				$filepath = $cachepath . '_computed.css';
				$cachepath .= '.css';
				break;
			case 'css':
			default:
				break;
		}

		$cached = Cache::read($cachepath, 'less');
		$cachedTimestamp = Cache::read($cachepath . CACHE_TIMESTAMP_SUFFIX, 'less');
		$templateModified = filemtime($filepathWithTimestamp);
		if ($cached !== false && $cachedTimestamp !== false
				&& $templateModified <= $cachedTimestamp
			) {
			$output = $cached;
		} else {
			if ($phpToExecute) {
				ob_start();
				include $phpToExecute;
				ob_end_flush();
			} else if ($lessToParse) {
				parse_less($lessToParse, $filepath);
			}
			$output = make_clean_css($filepath, $filename);

			$templateModified = time();

			Cache::write($cachepath, $output, 'less');
			Cache::write($cachepath . CACHE_TIMESTAMP_SUFFIX, $templateModified, 'less');


		}

		header("Date: " . date("D, j M Y G:i:s ", $templateModified) . 'GMT');
		header("Content-Type: text/css");
		header("Expires: " . gmdate("D, d M Y H:i:s", time() + DAY) . " GMT");
		header("Cache-Control: max-age=86400, must-revalidate"); // HTTP/1.1
		header("Pragma: cache");        // HTTP/1.0
		print $output;
	} else {
		preg_match('#\.([a-z0-9]+)$#i', $filename, $regs);
		$Dispatcher = new Dispatcher();
		$Dispatcher->_deliverAsset($filename, $regs[1]);
	}
?>