<?php
	namespace App\Model\Entity;

	use Cake\ORM\Entity;

	class Permission extends Entity{
		protected $_accessible = [
	        '*' => true,
	        'id' => false,
	    ];
	}
?>