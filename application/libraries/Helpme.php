<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Helpme {

    function startsWithChar($needle, $haystack)
	{
		return ($needle[0] === $haystack);
	}	

	function endsWithChar($needle, $haystack)
	{
		return ($needle[strlen($needle) - 1] === $haystack);
	}
}
?>