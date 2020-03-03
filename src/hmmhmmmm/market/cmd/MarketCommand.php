<?php

namespace hmmhmmmm\market\cmd;

use hmmhmmmm\market\Market;

use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;

class MarketCommand extends Command{
   private $plugin;
   private $prefix;
   private $lang;
   
   public function __construct(Market $plugin){
      parent::__construct("market");
      $this->plugin = $plugin;
      $this->prefix = $this->plugin->getPrefix();
      $this->lang = $this->plugin->getLanguage();
   }
   
   public function getPlugin(): Market{
      return $this->plugin;
   }
   
   public function sendConsoleError(CommandSender $sender): void{
      $sender->sendMessage($this->lang->getTranslate(
         "market.command.consoleError"
      ));
   }
      
   public function sendPermissionError(CommandSender $sender): void{
      $sender->sendMessage($this->lang->getTranslate(
         "market.command.permissionError"
      ));
   }
   
   public function getPrefix(): string{
      return $this->prefix;
   }
   
   public function sendHelp(CommandSender $sender): void{
      $sender->sendMessage($this->getPrefix()." : §fCommand");
      if($sender->hasPermission("market.command.info")){
         $sender->sendMessage("§a".$this->lang->getTranslate("market.command.info.usage")." : ".$this->lang->getTranslate("market.command.info.description"));
      }
      if($sender->hasPermission("market.command.addshop")){
         $sender->sendMessage("§a".$this->lang->getTranslate("market.command.additem.usage")." : ".$this->lang->getTranslate("market.command.additem.description"));
      }
      if($sender->hasPermission("market.command.removeshop")){
         $sender->sendMessage("§a".$this->lang->getTranslate("market.command.removeitem.usage")." : ".$this->lang->getTranslate("market.command.removeitem.description"));
      }
      if($sender->hasPermission("market.command.settext")){
         $sender->sendMessage("§a".$this->lang->getTranslate("market.command.settext.usage")." : ".$this->lang->getTranslate("market.command.settext.description"));
      }
      if($sender->hasPermission("market.command.setprice")){
         $sender->sendMessage("§a".$this->lang->getTranslate("market.command.setprice.usage")." : ".$this->lang->getTranslate("market.command.setprice.description"));
      }
      
   }
   
   public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
      if(empty($args)){
         if($sender instanceof Player){
            $this->getPlugin()->getMarketChest()->sendChest($sender);
            $sender->sendMessage($this->lang->getTranslate(
               "market.command.sendHelp.empty"
            ));
         }else{
            $this->sendHelp($sender);
         }
         return true;
      }
      $sub = array_shift($args);
      if(isset($sub)){
         switch($sub){
            case "help":
               $this->sendHelp($sender);
               break;
            case "info":
               if(!$sender->hasPermission("market.command.info")){
                  $this->sendPermissionError($sender);
                  return true;
               }
               $sender->sendMessage($this->getPlugin()->getPluginInfo());
               break;
            case "addshop":
               if(!$sender instanceof Player){
                  $this->sendConsoleError($sender);
                  return true;
               }
               if(!$sender->hasPermission("market.command.addshop")){
                  $this->sendPermissionError($sender);
                  return true;
               }
               if(count($args) < 2){
                  $sender->sendMessage($this->lang->getTranslate(
                     "market.command.additem.error1",
                     [$this->lang->getTranslate("market.command.additem.usage")]
                  ));
                  return true;
               }
               $price = (int) array_shift($args);
               if(!is_numeric($price)){
                  $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                     "market.command.additem.error2"
                  ));
                  return true;
               }
               $description = implode(" ", $args);
               $item = $sender->getInventory()->getItemInHand();
               if($item->getId() == 0){
                  $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                     "market.command.additem.error3"
                  ));
                  return true;
               }
               $this->getPlugin()->createShop($sender->getName(), $description, $price, $item);
               $item->setCount(0);
               $sender->getInventory()->setItemInHand($item);
               $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                  "market.command.additem.complete"
               ));
               break;
            case "removeshop":
               if(!$sender->hasPermission("market.command.removeshop")){
                  $this->sendPermissionError($sender);
                  return true;
               }
               if(count($args) < 1){
                  $sender->sendMessage($this->lang->getTranslate(
                     "market.command.removeitem.error1",
                     [$this->lang->getTranslate("market.command.removeitem.usage")]
                  ));
                  return true;
               }
               $id = (int) array_shift($args);
               if(!is_numeric($id)){
                  $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                     "market.command.removeitem.error2"
                  ));
                  return true;
               }
               if(!$this->getPlugin()->isShop($id)){
                  $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                     "market.command.removeitem.error3",
                     [$id]
                  ));
                  return true;
               }
               if(!($this->getPlugin()->getShopOwner($id) == $sender->getName())){
                  $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                     "market.command.removeitem.error4"
                  ));
                  return true;
               }
               $this->getPlugin()->removeShop($id);
               $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                  "market.command.removeitem.complete",
                  [$id]
               ));
               break;
            case "settext":
               if(!$sender->hasPermission("market.command.settext")){
                  $this->sendPermissionError($sender);
                  return true;
               }
               if(count($args) < 2){
                  $sender->sendMessage($this->lang->getTranslate(
                     "market.command.settext.error1",
                     [$this->lang->getTranslate("market.command.settext.usage")]
                  ));
                  return true;
               }
               $id = (int) array_shift($args);
               if(!is_numeric($id)){
                  $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                     "market.command.settext.error2"
                  ));
                  return true;
               }
               if(!$this->getPlugin()->isShop($id)){
                  $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                     "market.command.settext.error3",
                     [$id]
                  ));
                  return true;
               }
               if(!($this->getPlugin()->getShopOwner($id) == $sender->getName())){
                  $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                     "market.command.settext.error4"
                  ));
                  return true;
               }
               $description = implode(" ", $args);
               $this->getPlugin()->setShopDescription($id, $description);
               $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                  "market.command.settext.complete",
                  [$description, $id]
               ));
               break;
            case "setprice":
               if(!$sender->hasPermission("market.command.setprice")){
                  $this->sendPermissionError($sender);
                  return true;
               }
               if(count($args) < 2){
                  $sender->sendMessage($this->lang->getTranslate(
                     "market.command.setprice.error1",
                     [$this->lang->getTranslate("market.command.setprice.usage")]
                  ));
                  return true;
               }
               $id = (int) array_shift($args);
               if(!is_numeric($id)){
                  $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                     "market.command.setprice.error2"
                  ));
                  return true;
               }
               if(!$this->getPlugin()->isShop($id)){
                  $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                     "market.command.setprice.error3",
                     [$id]
                  ));
                  return true;
               }
               if(!($this->getPlugin()->getShopOwner($id) == $sender->getName())){
                  $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                     "market.command.setprice.error4"
                  ));
                  return true;
               }
               $price = (int) array_shift($args);
               if(!is_numeric($price)){
                  $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                     "market.command.setprice.error5"
                  ));
                  return true;
               }
               $this->getPlugin()->setShopPrice($id, $price);
               $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                  "market.command.setprice.complete",
                  [$price, $id]
               ));
               break;
            default:
               $this->sendHelp($sender);
               break;
         }
      }
      return true;
   }
}