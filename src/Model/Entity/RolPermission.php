<?php
	namespace App\Model\Entity;

	use Cake\ORM\Entity;

	class RolPermission extends Entity{
		protected $_accessible = [
	        '*' => true,
	        'id' => false,
	    ];
	}
?>