<?php

namespace ItemCleaner\Task;

use pocketmine\entity\object\ItemEntity;
use pocketmine\scheduler\Task;

use ItemCleaner\Loader;

class CheckTask extends Task{

    /** @var Loader */
    private $owner;

    /** @var int */
    private $time;

    public function __construct(Loader $owner){
        $this->owner = $owner;
		$this->time = (int) $this->owner->getConfig()->get('time');
    }
    public function onRun(int $currentTick){
        if ($this->time != 0){
            $this->owner->getServer()->broadcastMessage($this->owner->prefix . 'Items will be removed after §d' . --$this->time . '§f minute.');
        }else{
			$entityCount = 0;
            foreach ($this->owner->getServer()->getLevels() as $level){
                foreach($level->getEntities() as $entity){
                    if ($entity instanceof ItemEntity){
                        $entity->close();
                        ++$entityCount;
                    }
                }
            }
            $this->owner->getServer()->broadcastMessage($this->owner->prefix . '§d' . $entityCount . ' §fItems have been deleted.');
			$this->time = (int) $this->owner->getConfig()->get('time');
        }
    }
}
