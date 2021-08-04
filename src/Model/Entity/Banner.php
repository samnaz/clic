<?php
	namespace App\Model\Entity;

	use Cake\ORM\Entity;

	class Banner extends Entity
	{
		protected $_accessible = [
	        '*' => true,
	        'id' => false,
	    ];
	}
?>