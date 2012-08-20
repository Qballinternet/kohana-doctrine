<?php

/**
 * kohana-doctrine initialization, executed by application bootstrap.php
 *
 * LICENSE: THE WORK (AS DEFINED BELOW) IS PROVIDED UNDER THE TERMS OF THIS
 * CREATIVE COMMONS PUBLIC LICENSE ("CCPL" OR "LICENSE"). THE WORK IS PROTECTED
 * BY COPYRIGHT AND/OR OTHER APPLICABLE LAW. ANY USE OF THE WORK OTHER THAN AS
 * AUTHORIZED UNDER THIS LICENSE OR COPYRIGHT LAW IS PROHIBITED.
 *
 * BY EXERCISING ANY RIGHTS TO THE WORK PROVIDED HERE, YOU ACCEPT AND AGREE TO
 * BE BOUND BY THE TERMS OF THIS LICENSE. TO THE EXTENT THIS LICENSE MAY BE
 * CONSIDERED TO BE A CONTRACT, THE LICENSOR GRANTS YOU THE RIGHTS CONTAINED HERE
 * IN CONSIDERATION OF YOUR ACCEPTANCE OF SUCH TERMS AND CONDITIONS.
 *
 * @category  module
 * @package   kohana-doctrine
 * @author    gimpe <gimpehub@intljaywalkers.com>
 * @copyright 2011 International Jaywalkers
 * @license   http://creativecommons.org/licenses/by/3.0/ CC BY 3.0
 * @link      http://github.com/gimpe/kohana-doctrine
 */

// include kohana-doctrine config
$doctrine_config = Kohana::$config->load('doctrine');

// Setup with git loader
require $doctrine_config['doctrine_path'].'lib/Doctrine/ORM/Tools/Setup.php';
Doctrine\ORM\Tools\Setup::registerAutoloadGit($doctrine_config['doctrine_path']);

// defines your "extensions" namespace
$classLoader = new \Doctrine\Common\ClassLoader(
		'DoctrineExtensions', 
		$doctrine_config['extensions_path']);

$classLoader->register();

// Make proxies autoloader work so they work when seralizing objects. 
// Proxies are not PSR-0 compliant.
Doctrine\ORM\Proxy\Autoloader::register($doctrine_config['proxy_dir'], $doctrine_config['proxy_namespace']);

// Re-use already loaded Doctrine config
Doctrine_ORM::set_config($doctrine_config);