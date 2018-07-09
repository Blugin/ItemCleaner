<?php

namespace ItemCleaner;

use pocketmine\plugin\PluginBase;

use ItemCleaner\Task\CheckTask;

class Loader extends PluginBase{
	
	/** @var string */
    	public $prefix = '§d[ §fCleaner §d]§f ';

    	public function onEnable(): void {
		@mkdir($this->getDataFolder());
		$this->config = new Config($this->getDataFolder() . 'config.yml', Config::YAML, [
			'time' => 5
		]);
		$this->db['config'] = $this->config->getAll();
		$this->getScheduler()->scheduleRepeatingTask(new CheckTask($this), 20 * 60);
	}
}
