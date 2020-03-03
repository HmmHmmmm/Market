<?php

namespace hmmhmmmm\market\data;

use hmmhmmmm\market\Market;

use pocketmine\utils\Config;

class Language{
   private $plugin = null;
   private $data = null;
   private $lang = "?";
   private $version = null;
   
   private $langEnglish = [
      "reset" => false,
      "version" => 1,
      "notfound.plugin" => "§cThis plugin will not work, Please install the plugin %1",
      "notfound.libraries" => "§cLibraries %1 not found, Please download this plugin to as .phar",
      "plugininfo.name" => "§fName plugin %1",
      "plugininfo.version" => "§fVersion %1",
      "plugininfo.author" => "§fList of creators %1",
      "plugininfo.description" => "§fDescription of the plugin. §eis a plugin free. Please do not sell. If you redistribute it, please credit the creator. :)",
      "plugininfo.facebook" => "§fFacebook %1",
      "plugininfo.youtube" => "§fYoutube %1",
      "plugininfo.website" => "§fWebsite %1",
      "plugininfo.discord" => "§fDiscord %1",
      "market.command.consoleError" => "§cSorry: commands can be typed only in the game.",
      "market.command.permissionError" => "§cSorry: You cannot type this command.",
      "market.command.sendHelp.empty" => "§eYou can see more commands by typing /market help",
      "market.command.info.usage" => "/market info",
      "market.command.info.description" => "§fCredit of the plugin creator",
      "market.command.additem.usage" => "/market addshop <Price> <Description>",
      "market.command.additem.description" => "§fCreate shop",
      "market.command.additem.error1" => "§cTry: %1",
      "market.command.additem.error2" => "§c<Price> Please write as numbers.",
      "market.command.additem.error3" => "§cCannot create a shop using this item.",
      "market.command.additem.complete" => "§aYou have successfully created a shop.",
      "market.command.removeitem.usage" => "/market removeshop <ShopId>",
      "market.command.removeitem.description" => "§fDelete shop",
      "market.command.removeitem.error1" => "§cTry: %1",
      "market.command.removeitem.error2" => "§c<ShopId> Please write as numbers.",
      "market.command.removeitem.error3" => "§cId shop not found %1",
      "market.command.removeitem.error4" => "§cYou are not owner of this shop.",
      "market.command.removeitem.complete" => "§aYou have deleted id shop %1 successfully",
      "market.command.settext.usage" => "/market settext <ShopId> <Description>",
      "market.command.settext.description" => "§fSet shop description",
      "market.command.settext.error1" => "§cTry: %1",
      "market.command.settext.error2" => "§c<ShopId> Please write as numbers.",
      "market.command.settext.error3" => "§cId shop not found %1",
      "market.command.settext.error4" => "§cYou are not the owner of this shop.",
      "market.command.settext.complete" => "§aYou have set description. %1 in id shop %2 successfully",
      "market.command.setprice.usage" => "/market setprice <ShopId> <Price>",
      "market.command.setprice.description" => "§fSet price of shop",
      "market.command.setprice.error1" => "§cTry: %1",
      "market.command.setprice.error2" => "§c<ShopId> Please write as numbers.",
      "market.command.setprice.error3" => "§cId shop not found %1",
      "market.command.setprice.error4" => "§cYou are not the owner of this shop.",
      "market.command.setprice.error5" => "§c<Price> Please write as numbers.",
      "market.command.setprice.complete" => "§aYou have set price. %1 in id shop %2 successfully",
      "chestmenu.search" => "§bSearch for Shop ID",
      "chestmenu.exit" => "§cExit",
      "chestmenu.back" => "§eBack",
      "chestmenu.next" => "§aNext %1/%2",
      "chestmenu.senditem.lore" => "ShopId #%1\nOwner %2\nDescription %3\nPrice %4",
      "form.buyconfirm.error1" => "§cYour money is not enough",
      "form.buyconfirm.complete" => "You have bought %1 amount %2 in price %3 successfully",
      "form.buyconfirm.owner.complete" => "§aPlayer %1 have purchased items in id shop #%2 of you with price %3",
      "form.buyconfirm.content" => "§fShopId #%1\n§fShop owner %2\n§fYou want to buy §b%3\n§famount §e%4 \n§fDescription %5\n§fin price §6%6 §fOr not?",
      "form.buyconfirm.button1" => "§aBuy",
      "form.buyconfirm.button2" => "§cNo",
      "form.searchid.input1.title" => "§eShopId",
      "form.searchid.input1.error1" => "§cAn error has occurred\n§e%1 Need to put",
      "form.searchid.input1.error2" => "§cAn error has occurred\n§e%1 Please write as numbers.",
      "form.searchid.input1.error3" => "§cAn error has occurred\n§eShop ID is not found."
      
   ];
   
   
   private $langThai = [
      "reset" => false,
      "version" => 1,
      "notfound.plugin" => "§cปลั๊กนี้จะไม่ทำงาน กรุณาลงปลั๊กอิน %1",
      "notfound.libraries" => "§cไม่พบไลบรารี %1 กรุณาดาวน์โหลดปลั๊กอินนี้ให้เป็น .phar",
      "plugininfo.name" => "§fปลั๊กอินชื่อ %1",
      "plugininfo.version" => "§fเวอร์ชั่น %1",
      "plugininfo.author" => "§fรายชื่อผู้สร้าง %1",
      "plugininfo.description" => "§fคำอธิบายของปลั๊กอิน §eเป็นปลั๊กอินทำแจกกรุณาอย่าเอาไปขาย ถ้าจะแจกต่อโปรดให้เครดิตผู้สร้างด้วย :)",
      "plugininfo.facebook" => "§fเฟสบุ๊ค %1",
      "plugininfo.youtube" => "§fยูทูป %1",
      "plugininfo.website" => "§fเว็บไซต์ %1",
      "plugininfo.discord" => "§fดิสคอร์ด %1",
      "market.command.consoleError" => "§cขออภัย: คำสั่งสามารถพิมพ์ได้เฉพาะในเกมส์",
      "market.command.permissionError" => "§cขออภัย: คุณไม่สามารถพิมพ์คำสั่งนี้ได้",
      "market.command.sendHelp.empty" => "§eคุณสามารถดูคำสั่งเพิ่มเติมได้โดยพิมพ์ /market help",
      "market.command.info.usage" => "/market info",
      "market.command.info.description" => "§fเครดิตผู้สร้างปลั๊กอิน",
      "market.command.additem.usage" => "/market addshop <ราคา> <คำอธิบาย>",
      "market.command.additem.description" => "§fสร้างร้านค้า",
      "market.command.additem.error1" => "§cลอง: %1",
      "market.command.additem.error2" => "§c<ราคา> กรุณาเขียนให้เป็นตัวเลข",
      "market.command.additem.error3" => "§cไม่สามารถสร้างร้านค้าโดยใช้ไอเทมนี้ได้",
      "market.command.additem.complete" => "§aคุณได้สร้างร้านค้าเรียบร้อย",
      "market.command.removeitem.usage" => "/market removeshop <ร้านค้าไอดี>",
      "market.command.removeitem.description" => "§fลบร้านค้า",
      "market.command.removeitem.error1" => "§cลอง: %1",
      "market.command.removeitem.error2" => "§c<ร้านค้าไอดี> กรุณาเขียนให้เป็นตัวเลข",
      "market.command.removeitem.error3" => "§cไม่พบร้านค้าไอดี %1",
      "market.command.removeitem.error4" => "§cคุณไม่ใช่เจ้าของร้านค้าไอดีนี้",
      "market.command.removeitem.complete" => "§aคุณได้ลบร้านค้าไอดี %1 เรียบร้อย",
      "market.command.settext.usage" => "/market settext <ร้านค้าไอดี> <คำอธิบาย>",
      "market.command.settext.description" => "§fเซ็ตคำอธิบายของร้านค้า",
      "market.command.settext.error1" => "§cลอง: %1",
      "market.command.settext.error2" => "§c<ร้านค้าไอดี> กรุณาเขียนให้เป็นตัวเลข",
      "market.command.settext.error3" => "§cไม่พบร้านค้าไอดี %1",
      "market.command.settext.error4" => "§cคุณไม่ใช่เจ้าของร้านค้าไอดีนี้",
      "market.command.settext.complete" => "§aคุณได้เซ็ตคำอธิบาย %1 ในร้านค้าไอดี %2 เรียบร้อย",
      "market.command.setprice.usage" => "/market setprice <ร้านค้าไอดี> <ราคา>",
      "market.command.setprice.description" => "§fเซ็ตราคาขายของร้านค้า",
      "market.command.setprice.error1" => "§cลอง: %1",
      "market.command.setprice.error2" => "§c<ร้านค้าไอดี> กรุณาเขียนให้เป็นตัวเลข",
      "market.command.setprice.error3" => "§cไม่พบร้านค้าไอดี %1",
      "market.command.setprice.error4" => "§cคุณไม่ใช่เจ้าของร้านค้าไอดีนี้",
      "market.command.setprice.error5" => "§c<ราคา> กรุณาเขียนให้เป็นตัวเลข",
      "market.command.setprice.complete" => "§aคุณได้เซ็ตราคา %1 ในร้านค้าไอดี %2 เรียบร้อย",
      "chestmenu.search" => "§bค้นหาไอดีร้านค้า",
      "chestmenu.exit" => "§cออก",
      "chestmenu.back" => "§eกลับ",
      "chestmenu.next" => "§aถัดไป %1/%2",
      "chestmenu.senditem.lore" => "ร้านค้าไอดี #%1\nเจ้าของ %2\nคำอธิบาย %3\nราคา %4",
      "form.buyconfirm.error1" => "§cเงินของคุณไม่เพียงพอ",
      "form.buyconfirm.complete" => "คุณได้ชื้อ %1 จำนวน %2 ในราคา %3 เรียบร้อย!",
      "form.buyconfirm.owner.complete" => "§aผู้เล่น %1 ได้ชื้อไอเทมในร้านค้า #%2 ของคุณ ด้วยราคา %3",
      "form.buyconfirm.content" => "§fร้านค้าไอดี #%1\n§fเจ้าของร้านค้า %2\n§fคุณต้องการชื้อ §b%3\n§fจำนวน §e%4 \n§fคำอธิบาย %5\n§fในราคา §6%6 §fหรือไม่?",
      "form.buyconfirm.button1" => "§aชื้อ",
      "form.buyconfirm.button2" => "§cไม่",
      "form.searchid.input1.title" => "§eไอดีร้านค้า",
      "form.searchid.input1.error1" => "§cเกิดข้อผิดพลาด\n§e%1 จำเป็นต้องใส่",
      "form.searchid.input1.error2" => "§cเกิดข้อผิดพลาด\n§e%1 กรุณาเขียนให้เป็นตัวเลข",
      "form.searchid.input1.error3" => "§cเกิดข้อผิดพลาด\n§eไม่พบไอดีร้านค้า"
      
   ];
   

   public function __construct(Market $plugin, string $lang){
      $this->plugin = $plugin;
      $this->lang = $lang;
      $this->plugin->getLogger()->info("You have chosen language ".$this->getLang());
      $this->data = new Config($this->plugin->getDataFolder()."language/$this->lang.yml", Config::YAML, array());
      $d = $this->data->getAll();
      if(!isset($d["reset"])){
         $this->reset();
      }else{
         if($d["reset"]){
            $this->reset();
            $this->plugin->getLogger()->info("You have reset language ".$this->getLang());
         }
         if(isset($d["version"])){
            $this->version = $d["version"];
            if($this->getVersion() !== 1){
               $this->plugin->getLogger()->info("Language ".$this->getLang()." has been update as version ".$this->getVersion()." please reset language");
            }
         }else{
            $this->reset();
            $this->plugin->getLogger()->info("Language ".$this->getLang()." has been update as version ".$this->getVersion()." therefore language has been reset");
         }
      }
   }
   
   public function getPlugin(): Market{
      return $this->plugin;
   }
   
   public function getData(): Config{
      return $this->data;
   }
   
   public function getLang(): string{
      return $this->lang;
   }
   
   public function getVersion(): int{
      return $this->version;
   }
   
   public function reset(): void{
      $data = $this->getData();
      if($this->getLang() == "thai"){
         foreach($this->langThai as $key => $value){
            $data->setNested($key, $value);
         }
      }
      if($this->getLang() == "english"){
         foreach($this->langEnglish as $key => $value){
            $data->setNested($key, $value);
         }
      }
      $data->save();
   }
   
   public function getTranslate(string $key, array $params = []): string{
      $data = $this->getData();
      if(!$data->exists($key)){
         $message = $data->getNested($key);
         for($i = 0; $i < count($params); $i++){
            $message = str_replace("%".($i + 1), $params[$i], $message);
         }
         return $message;
      }else{
         return "§cNot found message ".$key;
      }
   }
}