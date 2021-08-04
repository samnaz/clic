<?php
	namespace App\Model\Entity;

	use Cake\ORM\Entity;

	class UserLog extends Entity
	{
		protected $_accessible = [
	        '*' => true,
	        'id' => false,
	    ];
	}
?>