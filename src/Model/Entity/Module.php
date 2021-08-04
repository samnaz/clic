<?php
	namespace App\Model\Entity;

	use Cake\ORM\Entity;

	class Module extends Entity{
		protected $_accessible = [
	        '*' => true,
	        'id' => false,
	    ];
	}
?>