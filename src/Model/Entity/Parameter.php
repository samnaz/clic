<?php
	namespace App\Model\Entity;

	use Cake\ORM\Entity;

	class Parameter extends Entity
	{
		protected $_accessible = [
	        '*' => true,
	        'id' => false,
	    ];
	}
?>