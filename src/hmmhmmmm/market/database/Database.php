<?php

namespace hmmhmmmm\market\database;

use hmmhmmmm\market\Market;

interface Database{

   public function __construct(Market $plugin, string $name);
  
   public function getName(): string;
}