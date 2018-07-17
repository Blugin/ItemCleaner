<?php

namespace ItemCleaner;

use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;

use ItemCleaner\Task\CheckTask;

class Loader extends PluginBase{
	/** @var string */
	public $prefix = '§d[ §fCleaner §d]§f ';

	public function onEnable(): void {
		$this->reloadConfig();
		$this->db['config'] = $this->getConfig()->getAll();
		
		$this->getScheduler()->scheduleRepeatingTask(new CheckTask($this), 20 * 60);
	}
}
