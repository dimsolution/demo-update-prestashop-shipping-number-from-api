<?php
/**
 * @title: Script permettant l'ajout du tracking number dans la commande
 * @description: php import.php '123456' 'TRACKINGNUMBER' (où '123456' est le numéro de commande et 'TRACKINGNUMBER' le numéro de suivi)
 * @required: Install PSWebServiceLibrary.php from github or composer
 * @package: Prestashop 
 * @copyright: 2016 Wistiki
 */

#require 'PSWebServiceLibrary.php';
require 'vendor/prestashop/prestashop-webservice-lib/PSWebServiceLibrary.php';

$webService = new PrestaShopWebservice('http://local.wistiki.com', 'UYAHT5DS1CEA38GY4W9VMCD8UEMVLVGA', false);   

if(!isset($argv[1]) && !isset($argv[2]))
  die("\033[31mError:\033[0m Arguments mandatory");

try {  
  $opt = array('resource' => 'orders');
  $opt['id'] = $argv[1];
  $xml = $webService->get($opt);
  $resources = $xml->children()->children();
  $resources->shipping_number = $argv[2];
  $opt = array('resource' => 'orders'); 
  $opt['putXml'] = $xml->asXML(); 
  $opt['id'] = $argv[1]; 
  $webService->edit($opt);
  echo "\033[32mSucess:\033[0m Shipping number set successfully";
} catch (PrestaShopWebserviceException $e) {  
    echo $e->getMessage();
}

?>

