<?php

/**
 * Update the IP address configuration of vpn-server-api.
 *
 * IPv4:
 * Random value for the second and third octet, e.g: 10.53.129.0/24
 *
 * IPv6:
 * The IPv6 address is generated according to RFC 4193 (Global ID), it results 
 * in a /48 network.
 *
 * The addresses are written to /etc/vpn-server-api/ip.yaml
 */
require_once '/usr/share/php/fkooman/Config/autoload.php';
require_once '/usr/share/php/random_compat/autoload.php';

use fkooman\Config\YamlFile;

$v4 = sprintf('10.%s.%s.0/24', hexdec(bin2hex(random_bytes(1))), hexdec(bin2hex(random_bytes(1))));
$v6 = sprintf('fd%s:%s:%s::/48', bin2hex(random_bytes(1)), bin2hex(random_bytes(2)), bin2hex(random_bytes(2)));

echo sprintf('IPv4 CIDR  : %s', $v4).PHP_EOL;
echo sprintf('IPv6 prefix: %s', $v6).PHP_EOL;

$yamlFile = new YamlFile('/etc/vpn-server-api/ip.yaml');
$configData = $yamlFile->readConfig();
$configData['v4']['range'] = $v4;
$configData['v6']['prefix'] = $v6;
$yamlFile->writeConfig($configData);
