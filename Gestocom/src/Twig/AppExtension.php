<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension 
{
	public function getFilters()
	{
		return array(
			new TwigFilter("isInstanceof", array($this, "isInstanceof"))
		);
	}
	
	public function isInstanceof($var, $instance){
		return $var instanceof $instance;
	}
}