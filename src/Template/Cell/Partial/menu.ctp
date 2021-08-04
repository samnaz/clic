<ul id="menu" class="menu">
    <li>
        <?=
        //El Dashboard se muestra para todos los usuarios
            $this->Html->link(
               '<i class="glyphicon glyphicon-dashboard"></i> Home',
                    ['controller' => 'Dashboard', 
                     'action' => 'index'
                    ],
                    ['data-original-title'=>'Dashboard',
                     'escape'=>false
                    ]
            );
        ?>
    </li>
		<?php
			$module = "";
			$subModule = "";
			$action = "";

			//Contadores
			$m = 1;
			$sm = 1; 
			$a = 1;
			$openAction = 1;

			//For para mostrar la lista de Modulos con sus submodulos y acciones - Estos datos vienen de particalcell.php
			foreach ($actionsRol as $item) {

				//Este if nos permite listar los modulos a los que tiene acceso el usuario
				if ($item["Module"] != $module) {
					$module = $item["Module"];

					//IF para cerrar UL de Acciones
					if ($a != 1) {
						$a = 1;
		?>
						</ul>
		<?php
					}
					
					// Para saber si está abierto
					$pos = strrpos(strtolower($this->request->getParam("here")), strtolower($item["UrlMod"]));
					if ($pos === false) { // nota: tres signos de igual
						// no encontrado...
						$open="";
					}
					else
						$open="open ";

					// Si es la primera vez
					if ($m == 1) {
		?>
						<li>
							<a href="#" name="menuLinks" id="<?= $m ?>" onClick="ShowSubMenu(this.id)">
					            <i class="<?= $item['Img']?>"></i>  <?= $module ?>
					        </a>
					        <ul class="<?= $open?>submenu" id="submenu<?= $m ?>" name="subMenu">
		<?php
					}
					else {
		?>

					        </ul>
						</li>
						<li>
							<a href="#" name="menuLinks" id="<?= $m ?>" onClick="ShowSubMenu(this.id)">
					            <i class="<?= $item['Img']?>"></i>  <?= $module ?>
					        </a>
					        <ul class="<?= $open?>submenu" id="submenu<?= $m ?>" name="subMenu">
		<?php
					}
					$m++;
				}

				//Lista para ver la lista de Submodulos
				if ($item["Submodule"] != $subModule){
					$subModule = $item["Submodule"];
					
					// Para saber si está abierto
					$pos = strrpos(strtolower($this->request->getParam("here")), strtolower($item["UrlSub"]));
					if ($pos === false) { // nota: tres signos de igual
						// no encontrado...
						$open="";
					}
					else
						$open=" open";

					//Aqui cerramos el Ul de Submodulos
					if ($a != 1) {
						$a = 1;
		?>
						</ul>
		<?php
					}

					if ($sm == 1) {
		?>
						<li>
							<a href="#" name="subMenuLinks" id="<?= $sm ?>" onClick="ShowSonSubMenu(this.id)">
								<?= $subModule ?> <span class="caret"></span>
							</a>
		<?php
					}
					else {
		?>
						</li>
						<li>
							<a href="#" name="subMenuLinks" id="<?= $sm ?>" onClick="ShowSonSubMenu(this.id)">
								<?= $subModule ?> <span class="caret"></span>
							</a>
		<?php
					}
					$sm++;
				}

				//If para crear el listado de Acciones
				if ($a == 1) {
					if ($openAction == $a) {
		?>
						<ul class="submenu-collapse<?= $open?>" id="sonsubmenu<?=  ($sm - 1) ?>" name="sonSubMenu">
							<li>
							 <?=
					            $this->Html->link(
					               $item["Action"],
					                    ['controller' => $item['UrlSub'], 
					                     'action' => $item['Url']
					                    ]
					            );
					        ?>
							</li>
		<?php			
					}
					else {
		?>
						<ul class="submenu-collapse<?= $open?>" id="sonsubmenu<?=  ($sm - 1) ?>" name="sonSubMenu">
							<li>
							 <?=
					            $this->Html->link(
					               $item["Action"],
					                    ['controller' => $item['UrlSub'], 
					                     'action' => $item['Url']
					                    ]
					            );
					        ?>
							</li>	
		<?php
					}
				}
				else {
					$openAction = $a;
		?>
						<li>
							  <?=
					            $this->Html->link(
					               $item["Action"],
					                    ['controller' => $item['UrlSub'], 
					                     'action' => $item['Url']
					                    ]
					            );
					        ?>
						</li>	
		<?php
				}
				$a++;
			}
		?>
					</li>
				</ul>
			</li>
		</ul>
	</li>
</li>


