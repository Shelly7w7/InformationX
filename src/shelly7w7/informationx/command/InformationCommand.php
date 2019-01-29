<?php

namespace shelly7w7\informationx\command;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\Server;
use shelly7w7\informationx\Loader;
use shelly7w7\informationx\forms\jojoe77777\FormAPI\SimpleForm;

class InformationCommand extends PluginCommand{

    public function __construct($name, Loader $plugin)
    {
        parent::__construct($name, $plugin);
        $this->plugin = $plugin;        
        $this->setAliases($this->plugin->config->get("aliases"));
        $this->setDescription("See yours and servers information!");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $this->GUI($sender);
    }

     public function GUI(Player $player){
        $form = new SimpleForm(function (Player $player, $data){
					$result = $data;
					
					if($result === null){
						return true;
					}
						switch($result){
                        case 0:
                        $player->sendMessage($this->plugin->config->get("exit-message"));
                        break;
                       }
        });
        $form->setTitle($this->plugin->config->get("gui-title"));
        $form->setContent($this->content($player));
        $form->addButton($this->plugin->config->get("exit-button"));
        $form->sendToPlayer($player);
    }
/**
     * @param Player $player
     * @param string $content
     * @return string
     */
    public function content(Player $player){
        
        $content = $this->plugin->config->get("profile-content");
        $content = str_replace("{name}", $player->getName(), $content);
        $content = str_replace("{money}", $this->plugin->dataManager->getPlayerMoney($player), $content);
        $content = str_replace("{online}", count($this->plugin->getServer()->getOnlinePlayers()), $content);
        $content = str_replace("{max_online}", $this->plugin->getServer()->getMaxPlayers(), $content);
        $content = str_replace("{rank}", $this->plugin->dataManager->getPlayerRank($player), $content);
        $content = str_replace("{prison_rank}", $this->plugin->dataManager->getPlayerPrisonRank($player), $content);
        $content = str_replace("{item_name}", $player->getInventory()->getItemInHand()->getName(), $content);
        $content = str_replace("{item_id}", $player->getInventory()->getItemInHand()->getId(), $content);
        $content = str_replace("{item_meta}", $player->getInventory()->getItemInHand()->getDamage(), $content);
        $content = str_replace("{item_count}", $player->getInventory()->getItemInHand()->getCount(), $content);
        $content = str_replace("{x}", intval($player->getX()), $content);
        $content = str_replace("{y}", intval($player->getY()), $content);
        $content = str_replace("{z}", intval($player->getZ()), $content);
        $content = str_replace("{faction}", $this->plugin->dataManager->getPlayerFaction($player), $content);
        $content = str_replace("{load}", $this->plugin->getServer()->getTickUsage(), $content);
        $content = str_replace("{tps}", $this->plugin->getServer()->getTicksPerSecond(), $content);
        $content = str_replace("{level_name}", $player->getLevel()->getName(), $content);
        $content = str_replace("{level_folder_name}", $player->getLevel()->getFolderName(), $content);
        $content = str_replace("{ip}", $player->getAddress(), $content);
        $content = str_replace("{ping}", $player->getPing(), $content);
        $content = str_replace("{kills}", $this->plugin->dataManager->getPlayerKills($player), $content);
        $content = str_replace("{deaths}", $this->plugin->dataManager->getPlayerDeaths($player), $content);
        $content = str_replace("{kdr}", $this->plugin->dataManager->getPlayerKillToDeathRatio($player), $content);
        $content = str_replace("{prefix}", $this->plugin->dataManager->getPrefix($player), $content);
        $content = str_replace("{suffix}", $this->plugin->dataManager->getSuffix($player), $content);
        $content = str_replace("{is_state}", $this->plugin->dataManager->getIsleState($player), $content);
        $content = str_replace("{is_blocks}", $this->plugin->dataManager->getIsleBlocks($player), $content);
        $content = str_replace("{is_members}", $this->plugin->dataManager->getIsleMembers($player), $content);
        $content = str_replace("{is_size}", $this->plugin->dataManager->getIsleSize($player), $content);
        $content = str_replace("{line}", "\n", $content);
        return $content;
        
    }
}
