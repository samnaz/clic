<?php
	namespace App\Model\Entity;

	use Cake\ORM\Entity;

	class UserRol extends Entity
	{
		protected $_accessible = [
	        '*' => true,
	        'id' => false,
	    ];
	}
?>