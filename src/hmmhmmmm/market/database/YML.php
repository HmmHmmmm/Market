<?php

namespace hmmhmmmm\market\database;

use hmmhmmmm\market\Market;

use pocketmine\item\Item;
use pocketmine\utils\Config;

class YML implements Database{
   private $plugin;
   private $data;
   private $name;
   
   public function __construct(Market $plugin, string $name){
      $this->plugin = $plugin;
      $this->name = $name;
      $this->data = new Config($this->plugin->getDataFolder()."market.yml", Config::YAML, array());
      $this->plugin->getLogger()->info("You have chosen database ".$this->name);
   }
   
   public function getName(): string{
      return $this->name;
   }
   
   public function getData(): Config{
      return $this->data;
   }
   
   public function getShopId(): array{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      return array_keys($data);
   }
   
   public function getCountShop(): int{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      return count($data);
   }
   
   public function isShop(int $id): bool{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      return isset($data[$id]);
   }
   
   public function createShop(int $id, Item $item): void{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      $data[$id]["item"] = $item->jsonSerialize();
      $shopData->setAll($data);
      $shopData->save();
   }
  
   public function removeShop(int $id): void{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      unset($data[$id]);
      $shopData->setAll($data);
      $shopData->save();
   }
  
   public function setItem(int $id, Item $item): void{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      $data[$id]["item"] = $item->jsonSerialize();
      $shopData->setAll($data);
      $shopData->save();
   }
   
   public function getItem(int $id): Item{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      return Item::jsonDeserialize($data[$id]["item"]);
   }
   
   public function getOwner(int $id): string{
      return $this->getItem($id)->getCustomBlockData()->getString("owner");
   }
   
   public function setOwner(int $id, string $ownerNew): void{
      $item = $this->getItem($id);
      $item->getCustomBlockData()->setString("owner", $ownerNew);
      $this->setItem($id, $item);
   }
   
   public function getDescription(int $id): string{
      return $this->getItem($id)->getCustomBlockData()->getString("description");
   }
   
   public function setDescription(int $id, string $descriptionNew): void{
      $item = $this->getItem($id);
      $item->getCustomBlockData()->setString("description", $descriptionNew);
      $this->setItem($id, $item);
   }
   
   public function getPrice(int $id): int{
      return $this->getItem($id)->getCustomBlockData()->getInt("price");
   }
   
   public function setPrice(int $id, string $priceNew): void{
      $item = $this->getItem($id);
      $item->getCustomBlockData()->setInt("price", $priceNew);
      $this->setItem($id, $item);
   }
   
  
}