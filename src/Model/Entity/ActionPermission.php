<?php
	namespace App\Model\Entity;

	use Cake\ORM\Entity;

	class ActionPermission extends Entity{
		protected $_accessible = [
	        '*' => true,
	        'id' => false,
	    ];
	}
?>