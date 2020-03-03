## Market


[Language English](#english)

This plugin uses Libraries `CustomUI` and `InvMenu` No need to install that plugin
Just load this plugin as .phar

download Market.phar dev https://poggit.pmmp.io/ci/HmmHmmmm/Market/Market


# English

```diff
You must install the plugin
- EconomyAPI
this plugin will work
```

Download the plugin EconomyAPI [Click here](https://poggit.pmmp.io/p/economyapi)


**Features of plugin**<br>
- Is a plugin create shop in market
- have gui chest
- have gui form
- Have language thai and english (You can edit the language you don't like at, `/resources/language`)


**How to use**<br>
- ?


**Command**<br>
- `/market` : open gui chest
- `/market addshop <Price> <Description>` : Create shop
- `/market removeshop <ShopId>` : Delete shop
- `/market settext <ShopId> <Description>` : Set shop description
- `/market setprice <ShopId> <Price>` : Set price of shop


**Images**<br>
![1](https://github.com/HmmHmmmm/Market/blob/master/images/1.1/1.jpg)


# Config
```

#Language
#thai=ภาษาไทย
#english=English language
language: english

database: yml

```
  

# Permissions
```
/*
*
* Command /market it can be typed by everyone.
*
*/
market.command.info:
  default: op
market.command.addshop:
  default: true
market.command.removeshop:
  default: true
market.command.settext:
  default: true
market.command.setprice:
  default: true
```


