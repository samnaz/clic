<?php
	namespace App\Model\Entity;

	use Cake\ORM\Entity;

	class ActionsRols extends Entity{
		protected $_accessible = [
	        '*' => true,
	        'id' => false,
	    ];
	}
?>