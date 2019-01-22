<?php

declare(strict_types = 1);

namespace shelly7w7\informationx\data;
use _64FF00\PurePerms\PurePerms;
use FactionsPro\FactionMain;
use JackMD\CPS\CPS;
use JackMD\KDR\KDR;
use shelly7w7\informationx\Loader;
use onebone\economyapi\EconomyAPI;
use pocketmine\Player;
use rankup\RankUp;
use room17\SkyBlock\SkyBlock;

class DataManager{
	
	/** @var Main */
	private $plugin;
	
	public function __construct(Loader $plugin){
		$this->plugin = $plugin;
	}
	
	/**
	 * @param Player $player
	 * @return float|string
	 */
	public function getPlayerMoney(Player $player){
		/** @var EconomyAPI $economyAPI */
		$economyAPI = $this->plugin->getServer()->getPluginManager()->getPlugin("EconomyAPI");
		if($economyAPI instanceof EconomyAPI){
			return $economyAPI->myMoney($player);
		}else{
			return "Plugin not found";
		}
	}
	
	/**
	 * @param Player $player
	 * @return string
	 */
	public function getPlayerRank(Player $player): string{
		/** @var PurePerms $purePerms */
		$purePerms = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
		if($purePerms instanceof PurePerms){
			$group = $purePerms->getUserDataMgr()->getData($player)['group'];
			if($group !== null){
				return $group;
			}else{
				return "No Rank";
			}
		}else{
			return "Plugin not found";
		}
	}
	
	/**
	 * @param Player $player
	 * @return bool|int|string
	 */
	public function getPlayerPrisonRank(Player $player){
		/** @var RankUp $rankUp */
		$rankUp = $this->plugin->getServer()->getPluginManager()->getPlugin("RankUp");
		if($rankUp instanceof RankUp){
			$group = $rankUp->getRankUpDoesGroups()->getPlayerGroup($player);
			if($group !== false){
				return $group;
			}else{
				return "No Rank";
			}
		}
		return "Plugin not found";
	}
	
	/**
	 * @param Player $player
	 * @return string
	 */
	public function getPlayerFaction(Player $player): string{
		/** @var FactionMain $factionsPro */
		$factionsPro = $this->plugin->getServer()->getPluginManager()->getPlugin("FactionsPro");
		if($factionsPro instanceof FactionMain){
			$factionName = $factionsPro->getPlayerFaction($player->getName());
			if($factionName == null){
				return "No Faction";
			}
			return $factionName;
		}
		return "Plugin not found";
	}
	
	/**
	 * @param Player $player
	 * @return int|string
	 */
	public function getPlayerKills(Player $player){
		/** @var KDR $kdr */
		$kdr = $this->plugin->getServer()->getPluginManager()->getPlugin("KDR");
		if($kdr instanceof KDR){
			return $kdr->getProvider()->getPlayerKillPoints($player);
		}else{
			return "Plugin Not Found";
		}
	}
	
	/**
	 * @param Player $player
	 * @return int|string
	 */
	public function getPlayerDeaths(Player $player){
		/** @var KDR $kdr */
		$kdr = $this->plugin->getServer()->getPluginManager()->getPlugin("KDR");
		if($kdr instanceof KDR){
			return $kdr->getProvider()->getPlayerDeathPoints($player);
		}else{
			return "Plugin Not Found";
		}
	}
	
	/**
	 * @param Player $player
	 * @return string
	 */
	public function getPlayerKillToDeathRatio(Player $player): string{
		/** @var KDR $kdr */
		$kdr = $this->plugin->getServer()->getPluginManager()->getPlugin("KDR");
		if($kdr instanceof KDR){
			return $kdr->getProvider()->getKillToDeathRatio($player);
		}else{
			return "Plugin Not Found";
		}
	}
	
	/**
	 * @param Player $player
	 * @param null   $levelName
	 * @return string
	 */
	public function getPrefix(Player $player, $levelName = null): string{
		/** @var PurePerms $purePerms */
		$purePerms = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
		if($purePerms instanceof PurePerms){
			$prefix = $purePerms->getUserDataMgr()->getNode($player, "prefix");
			if($levelName === null){
				if(($prefix === null) || ($prefix === "")){
					return "No Prefix";
				}
				return (string) $prefix;
			}else{
				$worldData = $purePerms->getUserDataMgr()->getWorldData($player, $levelName);
				if(empty($worldData["prefix"]) || $worldData["prefix"] == null){
					return "No Prefix";
				}
				return $worldData["prefix"];
			}
		}else{
			return "Plugin not found";
		}
	}
	
	/**
	 * @param Player $player
	 * @param null   $levelName
	 * @return string
	 */
	public function getSuffix(Player $player, $levelName = null): string{
		/** @var PurePerms $purePerms */
		$purePerms = $this->plugin->getServer()->getPluginManager()->getPlugin("PurePerms");
		if($purePerms instanceof PurePerms){
			$suffix = $purePerms->getUserDataMgr()->getNode($player, "suffix");
			if($levelName === null){
				if(($suffix === null) || ($suffix === "")){
					return "No Suffix";
				}
				return (string) $suffix;
			}else{
				$worldData = $purePerms->getUserDataMgr()->getWorldData($player, $levelName);
				if(empty($worldData["suffix"]) || $worldData["suffix"] == null){
					return "No Suffix";
				}
				return $worldData["suffix"];
			}
		}else{
			return "Plugin not found";
		}
	}
		
	/**
	 * @param Player $player
	 * @return int|string
	 */
	public function getIsleBlocks(Player $player){
		/** @var SkyBlock $sb */
		$sb = $this->plugin->getServer()->getPluginManager()->getPlugin("SkyBlock");
		if($sb instanceof SkyBlock){
			$session = $sb->getSessionManager()->getSession($player);
			if(!$session->hasIsle()){
				return "No Island";
			}
			$isle = $session->getIsle();
			return $isle->getBlocksBuilt();
		}else{
			return "Plugin Not Found";
		}
	}
	
	/**
	 * @param Player $player
	 * @return string
	 */
	public function getIsleSize(Player $player){
		/** @var SkyBlock $sb */
		$sb = $this->plugin->getServer()->getPluginManager()->getPlugin("SkyBlock");
		if($sb instanceof SkyBlock){
			$session = $sb->getSessionManager()->getSession($player);
			if(!$session->hasIsle()){
				return "No Island";
			}
			$isle = $session->getIsle();
			return $isle->getCategory();
		}else{
			return "Plugin Not Found";
		}
	}
	
	/**
	 * @param Player $player
	 * @return int|string
	 */
	public function getIsleMembers(Player $player){
		/** @var SkyBlock $sb */
		$sb = $this->plugin->getServer()->getPluginManager()->getPlugin("SkyBlock");
		if($sb instanceof SkyBlock){
			$session = $sb->getSessionManager()->getSession($player);
			if(!$session->hasIsle()){
				return "No Island";
			}
			$isle = $session->getIsle();
			return count($isle->getMembers());
		}else{
			return "Plugin Not Found";
		}
	}
	
	/**
	 * @param Player $player
	 * @return string
	 */
	public function getIsleState(Player $player){
		/** @var SkyBlock $sb */
		$sb = $this->plugin->getServer()->getPluginManager()->getPlugin("SkyBlock");
		if($sb instanceof SkyBlock){
			$session = $sb->getSessionManager()->getSession($player);
			if(!$session->hasIsle()){
				return "No Island";
			}
			$isle = $session->getIsle();
			return $isle->isLocked() ? "Locked" : "Unlocked";
		}else{
			return "Plugin Not Found";
		}
	}
}