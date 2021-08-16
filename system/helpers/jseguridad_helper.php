<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'class.JavaScriptPacker.php';

/**
 * Metodo tradicional
 */
if (!function_exists('script_remplaze')) {

	function script_remplaze($str)
	{
		$script = stripslashes($str);
		$encoding = 62;
		$fast_decode = 1;
		$special_char = 1;

		$t1 = microtime(true);
		$packer = new JavaScriptPacker($script, $encoding, $fast_decode, $special_char);
		$packed = $packer->pack();
		$t2 = microtime(true);
		$originalLength = strlen($script);
		$packedLength = strlen($packed);
		$ratio =  number_format($packedLength / $originalLength, 3);
		$time = sprintf('%.4f', ($t2 - $t1));
		$treat = true;

		return ' <script type="text/javascript">' . $packed . '</script>';
	}
}

if (!function_exists('script_remplazed')) {

	function script_remplazed($str)
	{
		$script = stripslashes($str);
		$encoding = 62;
		$fast_decode = 1;
		$special_char = 1;

		$t1 = microtime(true);
		$packer = new JavaScriptPacker($script, $encoding, $fast_decode, $special_char);
		$packed = $packer->pack();
		$t2 = microtime(true);

		$originalLength = strlen($script);
		$packedLength = strlen($packed);
		$ratio =  number_format($packedLength / $originalLength, 3);
		$time = sprintf('%.4f', ($t2 - $t1));
		$treat = true;

		return $packed;
	}
}
