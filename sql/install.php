<?php

/* Init */
$sql = array();

/* Create Table in Database */
// ps_home_slider

$sql[] = 'CREATE TABLE IF NOT EXISTS  '._DB_PREFIX_.'home_slider (
                    `id_home_slider`      INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `animation`           TEXT,
                    `image`               VARCHAR(255) NOT NULL DEFAULT \'\',
                    `url`                 VARCHAR(255) NOT NULL DEFAULT \'\',
                    `position`            INT(1) UNSIGNED DEFAULT \'0\',
                    `display`             TINYINT(1) NOT NULL DEFAULT \'1\',
                    PRIMARY KEY (id_home_slider)
                )ENGINE='._MYSQL_ENGINE_.'  AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;';
// ps_home_menu
$sql[] = 'CREATE TABLE IF NOT EXISTS  '._DB_PREFIX_.'home_menu (
                    `id_home_menu`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `title`               VARCHAR(255) NOT NULL DEFAULT \'\',
                    `url`                 VARCHAR(255) NOT NULL DEFAULT \'\',
                    `position`            INT(1) UNSIGNED DEFAULT \'0\',
                    `display`             TINYINT(1) NOT NULL DEFAULT \'1\',
                    PRIMARY KEY (id_home_menu)
                )ENGINE='._MYSQL_ENGINE_.'  AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;';
// ps_home_floor
$sql[] = 'CREATE TABLE IF NOT EXISTS  '._DB_PREFIX_.'home_floor (
                    `id_home_floor`        INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `title`               VARCHAR(255) NOT NULL DEFAULT \'\',
                    `url`                 VARCHAR(255) NOT NULL DEFAULT \'\',
                    `animation`           TEXT,
                    `type`                ENUM("Special", "New", "Category", "Topic","Default") NOT NULL DEFAULT \'Default\',
                    `position`            INT(1) UNSIGNED DEFAULT \'0\',
                    `display`             TINYINT(1) NOT NULL DEFAULT \'1\',
                    PRIMARY KEY (id_home_floor)
                )ENGINE='._MYSQL_ENGINE_.'  AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;';




