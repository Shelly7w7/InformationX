<?php

namespace shelly7w7\informationx; 

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use shelly7w7\informationx\command\InformationCommand;
use shelly7w7\informationx\data\DataManager;

class Loader extends PluginBase implements Listener {

	public function onEnable(){

    @mkdir($this->getDataFolder());
    $this->saveResource('config.yml');
    $this->config = new Config($this->getDataFolder().'config.yml', Config::YAML);
    $this->getServer()->getCommandMap()->register("informationx", new InformationCommand("information", $this));
    $this->dataManager = new DataManager($this);
     }
  }