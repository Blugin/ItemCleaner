<?php

/**
 * @name ItemCleaner
 * @main ItemCleaner\Main
 * @author BLEAN
 * @version 1.1
 * @api 3.0.0
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
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new class($this) extends \pocketmine\scheduler\Task{
			public $owner;
			public function __construct(Main $owner){
				$this->owner = $owner;
			}
			public function onRun(int $currentTick){
				++$this->owner->time;
				if ($this->owner->time == 1){
					$this->owner->getServer()->broadcastMessage($this->owner->prefix . 'Items will be removed after 3 minute.');
				}
				if ($this->owner->time == 2){
					$this->owner->getServer()->broadcastMessage($this->owner->prefix . 'Items will be removed after 2 minute.');
				}
				if ($this->owner->time == 3){
					$this->owner->getServer()->broadcastMessage($this->owner->prefix . 'Items will be removed after 1 minute.');
				}
				if ($this->owner->time == 4){
					foreach ($this->owner->getServer()->getLevels() as $levels){
						foreach($levels->getEntities() as $entities){
							if (!$entities instanceof Creature && !$entities instanceof Human){
								$entities->close();
								++$this->owner->count;
							}
						}
					}
					$this->owner->getServer()->broadcastMessage($this->owner->prefix . '§d' . $this->owner->count . ' §fItems have been deleted.');
					$this->owner->time = 0;
					$this->owner->count = 0;
				}
			}
		}, 20 * 60);
	}
}
