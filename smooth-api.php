<?php
/**
 * Created by PhpStorm.
 * User: entymon
 * Date: 05/08/2018
 * Time: 14:24
 *
 * @package smooth-api
 * @version 1.0
 *
 * Plugin Name: Smooth API
 * Description: Basic blog API to retrieve data from WP database. Extended for personal use.
 * Author: entymon
 * Version: 1.0
 */

require_once __DIR__ . '/constants.php';

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Smooth\\', __DIR__);

$index = new \Smooth\Api\IndexController();
$index->init();