<?php
	namespace App\Model\Entity;

	use Cake\ORM\Entity;

	class Countrie extends Entity{
		protected $_accessible = [
	        '*' => true,
	        'id' => false,
	    ];
	}
?>