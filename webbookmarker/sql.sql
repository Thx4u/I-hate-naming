CREATE DATABASE IF NOT EXISTS `webbookmarker` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE `webbookmarker`;

CREATE TABLE IF NOT EXISTS `web_marker`(
`id` int(10) unsigned NOT NULL,
`title` mediumtext NOT NULL,
`href` mediumtext NOT NULL,
`icon` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

ALTER TABLE `web_marker` ADD PRIMARY KEY (`id`);

ALTER TABLE `web_marker` MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;

INSERT INTO  `web_marker` (`id`, `title`, `href`, `icon`) VALUES (null, 'GOOGLE', 'https://www.baidu.com/', 'view-source:https://www.baidu.com/favicon.ico');