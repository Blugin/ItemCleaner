<?php

/**
 * @name ItemCleaner
 * @main ItemCleaner\Main
 * @author BLEAN
 * @version 1.0
 * @api 3.0.0-ALPHA12
 */

namespace ItemCleaner;

use pocketmine\entity\{
	Creature,
	Human
};

class Main extends \pocketmine\plugin\PluginBase{
	public $prefix = '§d[ §fCleaner §d]§f ';
	public $time = 0;
	public $count = 0;
	public function onEnable(){
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new class($this) extends \pocketmine\scheduler\PluginTask{
			public function onRun(int $currentTick){
				++$this->getOwner()->time;
				if ($this->getOwner()->time == 1){
					$this->getOwner()->getServer()->broadcastMessage($this->getOwner()->prefix . 'Items will be removed after 3 minute.');
				}
				if ($this->getOwner()->time == 2){
					$this->getOwner()->getServer()->broadcastMessage($this->getOwner()->prefix . 'Items will be removed after 2 minute.');
				}
				if ($this->getOwner()->time == 3){
					$this->getOwner()->getServer()->broadcastMessage($this->getOwner()->prefix . 'Items will be removed after 1 minute.');
				}
				if ($this->getOwner()->time == 4){
					foreach ($this->getOwner()->getServer()->getLevels() as $levels){
						foreach($levels->getEntities() as $entities){
							if (!$entities instanceof Creature && !$entities instanceof Human){
								$entities->close();
								++$this->getOwner()->count;
							}
						}
					}
					$this->getOwner()->getServer()->broadcastMessage($this->getOwner()->prefix . '§d' . $this->getOwner()->count . ' §fItems have been deleted.');
					$this->getOwner()->time = 0;
					$this->getOwner()->count = 0;
				}
			}
		}, 20 * 60);
	}
}
