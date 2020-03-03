<?php

namespace hmmhmmmm\market;

use hmmhmmmm\market\cmd\MarketCommand;
use hmmhmmmm\market\data\Language;
use hmmhmmmm\market\database\Database;
use hmmhmmmm\market\database\YML;
use hmmhmmmm\market\listener\EventListener;
use hmmhmmmm\market\ui\MarketChest;
use hmmhmmmm\market\ui\MarketForm;
use xenialdan\customui\API as XenialdanCustomUI; //?
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\InvMenuHandler;

use pocketmine\item\Item;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\Plugin;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\utils\Config;

class Market extends PluginBase{
   private $prefix = "?";
   private $facebook = "§cwithout";
   private $youtube = "§cwithout";
   private $discord = "§cwithout";
   private $language = null;
   private $data = null;
   public $array = [];
   private $marketform = null;
   private $moneyapi = null;
   private $marketchest = null;
   public $eventListener = null;
   
   public $database;

   private $langClass = [
      "thai",
      "english"
   ];
   
   public function onEnable(): void{
      @mkdir($this->getDataFolder());
      @mkdir($this->getDataFolder()."language/");
      $this->saveDefaultConfig();
      $this->prefix = "Market";
      $this->youtube = "https://bit.ly/2HL1j28";
      $langConfig = $this->getConfig()->getNested("language");
      if(!in_array($langConfig, $this->langClass)){
         $this->getLogger()->error("§cNot found language ".$langConfig.", Please try ".implode(", ", $this->langClass));
         $this->getServer()->getPluginManager()->disablePlugin($this);
         return;
      }else{
         $this->language = new Language($this, $langConfig);
         $this->marketform = new MarketForm($this);
         $this->eventListener = new EventListener($this);
         $this->getServer()->getCommandMap()->register("Market", new MarketCommand($this));
         $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
         switch($this->getConfig()->getNested("database")){
            case "yml":
               $this->database = new YML($this, "Yaml");
               break;
            default:
               $this->database = new YML($this, "Yaml");
               break;
         }
      }
      if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") === null){
         $this->getLogger()->error($this->language->getTranslate("notfound.plugin", ["EconomyAPI"]));
         $this->getServer()->getPluginManager()->disablePlugin($this);
         return;
      }else{
         $this->moneyapi = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
      }
      if(!class_exists(XenialdanCustomUI::class)){
         $this->getLogger()->error($this->language->getTranslate("notfound.libraries", ["CustomUI"]));
         $this->getServer()->getPluginManager()->disablePlugin($this);
         return;
      }
      if(!class_exists(InvMenu::class)){
         $this->getLogger()->error($this->language->getTranslate("notfound.libraries", ["InvMenu"]));
         $this->getServer()->getPluginManager()->disablePlugin($this);
         return;
      }else{
         if(!InvMenuHandler::isRegistered()){
            InvMenuHandler::register($this);
         }
         $this->marketchest = new MarketChest($this);
      }
   }
   
   public function getPrefix(): string{
      return "§e[§a".$this->prefix."§e]§f";
   }
   
   public function getFacebook(): string{
      return $this->facebook;
   }
   
   public function getYoutube(): string{
      return $this->youtube;
   }
   
   public function getDiscord(): string{
      return $this->discord;
   }
   
   public function getLanguage(): Language{
      return $this->language;
   }
   
   public function getMarketForm(): MarketForm{
      return $this->marketform;
   }
   
   public function getMoneyAPI(): Plugin{
      return $this->moneyapi;
   }
   
   public function getMarketChest(): MarketChest{
      return $this->marketchest;
   }
   
   public function getDatabase(): Database{
      return $this->database;
   }
   
   public function getPluginInfo(): string{
      $author = implode(", ", $this->getDescription()->getAuthors());
      $arrayText = [
         $this->getPrefix()." ".$this->getLanguage()->getTranslate("plugininfo.name", [$this->getDescription()->getName()]),
         $this->getPrefix()." ".$this->getLanguage()->getTranslate("plugininfo.version", [$this->getDescription()->getVersion()]),
         $this->getPrefix()." ".$this->getLanguage()->getTranslate("plugininfo.author", [$author]),
         $this->getPrefix()." ".$this->getLanguage()->getTranslate("plugininfo.description"),
         $this->getPrefix()." ".$this->getLanguage()->getTranslate("plugininfo.facebook", [$this->getFacebook()]),
         $this->getPrefix()." ".$this->getLanguage()->getTranslate("plugininfo.youtube", [$this->getYoutube()]),
         $this->getPrefix()." ".$this->getLanguage()->getTranslate("plugininfo.website", [$this->getDescription()->getWebsite()]),
         $this->getPrefix()." ".$this->getLanguage()->getTranslate("plugininfo.discord", [$this->getDiscord()]),
      ];
      return implode("\n", $arrayText);
   }
   
   public function getShopId(): array{
      $array = $this->getDatabase()->getShopId();
      arsort($array);
      return $array;
   }
   
   public function getCountShop(): int{
      return $this->getDatabase()->getCountShop();
   }
   
   public function isShop(int $id): bool{
      return $this->getDatabase()->isShop($id);
   }
   
   public function createShop(string $owner, string $description, int $price, Item $item): void{
      $id = $this->getCountShop() + 1;
      for($i = 0; $i < $this->getCountShop(); $i++){
         if($this->isShop($id)){
            $id++;
         }
      }
      $tag = new CompoundTag();
      $tag->setInt("id", $id);
      $tag->setString("owner", $owner);
      $tag->setString("description", $description);
      $tag->setInt("price", $price);
      $item->setCustomBlockData($tag);
      $this->getDatabase()->createShop($id, $item);
   }
   
   public function removeShop(int $id): void{
      $this->getDatabase()->removeShop($id);
   }
   
   public function getShopOwner(int $id): string{
      return $this->getDatabase()->getOwner($id);
   }
   
   public function setShopOwner(int $id, string $ownerNew): void{
      $this->getDatabase()->setOwner($id, $ownerNew);
   }
   
   public function getShopDescription(int $id): string{
      return $this->getDatabase()->getDescription($id);
   }
   
   public function setShopDescription(int $id, string $descriptionNew): void{
      $this->getDatabase()->setDescription($id, $descriptionNew);
   }
   
   public function getShopPrice(int $id): int{
      return $this->getDatabase()->getPrice($id);
   }
   
   public function setShopPrice(int $id, string $priceNew): void{
      $this->getDatabase()->setPrice($id, $priceNew);
   }
   
   public function getShopItem(int $id): Item{
      return $this->getDatabase()->getItem($id);
   }
   
}