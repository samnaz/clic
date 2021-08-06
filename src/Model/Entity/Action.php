<?php
	namespace App\Model\Entity;

	use Cake\ORM\Entity;

	class Action extends Entity{
		protected $_accessible = [
	        '*' => true,
	        'id' => false,
	    ];
	}
?>