CREATE TABLE `system` (
  `name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `content` text CHARACTER SET utf8 COLLATE utf8_bin
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `template` (
  `name` text CHARACTER SET utf8 COLLATE utf8_bin,
  `menu` text CHARACTER SET utf8 COLLATE utf8_bin,
  `file` text CHARACTER SET utf8 COLLATE utf8_bin,
  `permissions` text CHARACTER SET utf8 COLLATE utf8_bin,
  `icon` text CHARACTER SET utf8 COLLATE utf8_bin
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `user` (
  `user` text CHARACTER SET utf8 COLLATE utf8_bin,
  `pass` text CHARACTER SET utf8 COLLATE utf8_bin,
  `email` text CHARACTER SET utf8 COLLATE utf8_bin,
  `phone` text CHARACTER SET utf8 COLLATE utf8_bin,
  `plugin` text CHARACTER SET utf8 COLLATE utf8_bin,
  `activation` text CHARACTER SET utf8 COLLATE utf8_bin,
  `permissions` text CHARACTER SET utf8 COLLATE utf8_bin,
  `keys` text CHARACTER SET utf8 COLLATE utf8_bin,
  `ip` text CHARACTER SET utf8 COLLATE utf8_bin,
  `time` text CHARACTER SET utf8 COLLATE utf8_bin,
  `memory` text CHARACTER SET utf8 COLLATE utf8_bin,
  `vip` text CHARACTER SET utf8 COLLATE utf8_bin,
  `log` text CHARACTER SET utf8 COLLATE utf8_bin
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


