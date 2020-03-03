<?php

namespace hmmhmmmm\market\ui;

use hmmhmmmm\market\Market;
use muqsit\invmenu\InvMenu;

use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\nbt\tag\CompoundTag;

class MarketChest{
   private $plugin;
   private $prefix;
   private $lang;
   
   public function __construct(Market $plugin){
      $this->plugin = $plugin;
      $this->prefix = $this->plugin->getPrefix();
      $this->lang = $this->plugin->getLanguage();
   }
   
   public function getPlugin(): Market{
      return $this->plugin;
   }
   
   public function getPrefix(): string{
      return $this->prefix;
   }
   
   public function sendChest(Player $player, string $content = "menu", int $id = null): void{
      $menu = InvMenu::create(InvMenu::TYPE_CHEST);
      $menu->readonly();
      $menu->setListener([$this->plugin->eventListener, "MarketMenu"]);
      $menu->setName($this->getPrefix());
      $inv = $menu->getInventory();
      switch($content){
         case "menu":
            $inv->setContents($this->sendMarketMenu());
            break;
         case "search":
            $inv->setContents($this->sendMarketSearch($id));
            break;
      }
      $menu->send($player);
   }

   public function makeMarketMenuPage(): array{
      $items = [];
      foreach($this->getPlugin()->getShopId() as $id){
         $items[] = $this->getPlugin()->getShopItem($id);
      }
      return array_chunk($items, 18);
   }
   
   public function sendMarketMenu(int $page = 0): array{
      if(!isset($this->makeMarketMenuPage()[$page])){
         $arrayNull = [
            25 => Item::get(35, 4, 1)->setCustomName($this->lang->getTranslate(
               "chestmenu.back"
            )),
            26 => Item::get(35, 14, 1)->setCustomName($this->lang->getTranslate(
               "chestmenu.exit"
            ))
         ];
         for($i = 18; $i < 25; $i++){
            $arrayNull[$i] = Item::get(160, 3, 1)->setCustomName("???");
         }
         return $arrayNull;
      }
      $itemNext = Item::get(35, 5, 1);
      $tag1 = new CompoundTag();
      $tag1->setInt("page", $page);
      $itemNext->setCustomBlockData($tag1);
      $array = [
         23 => Item::get(35, 7, 1)->setCustomName($this->lang->getTranslate(
            "chestmenu.search"
         )),
         24 => Item::get(35, 4, 1)->setCustomName($this->lang->getTranslate(
            "chestmenu.back"
         )),
         25 => $itemNext->setCustomName($this->lang->getTranslate(
            "chestmenu.next",
            [($page + 1), count($this->makeMarketMenuPage())]
         )),
         26 => Item::get(35, 14, 1)->setCustomName($this->lang->getTranslate(
            "chestmenu.exit"
         ))
      ];
      for($i = 18; $i < 23; $i++){
         $array[$i] = Item::get(160, 3, 1)->setCustomName("???");
      }
      $i = 0;
      if($this->getPlugin()->getCountShop() !== 0){
         foreach($this->makeMarketMenuPage()[$page] as $item){
            $id = $item->getCustomBlockData()->getInt("id");
            $owner = $item->getCustomBlockData()->getString("owner");
            $description = $item->getCustomBlockData()->getString("description");
            $price = $item->getCustomBlockData()->getInt("price");
            $lore = [
               "text1" => $this->lang->getTranslate(
                  "chestmenu.senditem.lore",
                  [$id, $owner, $description, $price]
               )
            ];
            $array[$i] = $item->setLore($lore);
            $i++;
         }
      }
      return $array;
   }

   public function sendMarketSearch(int $id): array{
      $array = [
         25 => Item::get(35, 4, 1)->setCustomName($this->lang->getTranslate(
            "chestmenu.back"
         )),
         26 => Item::get(35, 14, 1)->setCustomName($this->lang->getTranslate(
            "chestmenu.exit"
         ))
      ];
      for($i = 18; $i < 25; $i++){
         $array[$i] = Item::get(160, 3, 1)->setCustomName("???");
      }
      $item = $this->getPlugin()->getShopItem($id);
      $id = $item->getCustomBlockData()->getInt("id");
      $owner = $item->getCustomBlockData()->getString("owner");
      $description = $item->getCustomBlockData()->getString("description");
      $price = $item->getCustomBlockData()->getInt("price");
      $lore = [
         "text1" => $this->lang->getTranslate(
            "chestmenu.senditem.lore",
            [$id, $owner, $description, $price]
         )
      ];
      $array[0] = $item->setLore($lore);
      return $array;
   }
   
}