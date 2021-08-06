<?php
	namespace App\Model\Entity;

	use Cake\ORM\Entity;

	class State extends Entity
	{
		protected $_accessible = [
	        '*' => true,
	        'id' => false,
	    ];
	}
?>