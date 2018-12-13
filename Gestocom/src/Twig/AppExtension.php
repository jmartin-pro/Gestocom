<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigTest;

class AppExtension extends AbstractExtension 
{
	public function getTests()
	{
		return array(
			new TwigTest("instanceof", array($this, "isInstanceof"))
		);
	}
	
	public function isInstanceof($var, $className){
		$instance = new $className();
		return $var instanceof $instance;
	}
}
