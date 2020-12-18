DROP TABLE IF EXISTS `borad`;
CREATE TABLE `board` (
    `row` tinyint(1) not null,
    `col` tinyint(1) not null,
    `piece_color` enum('Y','R')
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `board_empty`;
CREATE TABLE `board_empty` (
    `row` tinyint(1) not null,
    `col` tinyint(1) not null,
    `piece_color` enum('Y','R')
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `game_status`;
CREATE TABLE `game_status` (
    `status` enum('not active','initialized','started','ended','aborded') NOT NULL DEFAULT 'not active',
    `player_turn` enum('Y','R') DEFAULT NULL,
    `result` enum('Y','R','D') DEFAULT NULL,
    `last_change` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `players` (
  `username` varchar(20) DEFAULT NULL,
  `piece_color` enum('Y','R') NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `last_action` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`piece_color`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE DEFINER=`root`@`localhost` PROCEDURE `clean_board`()
BEGIN
	replace into board select * from board_empty;
	update `players` set username=null, token=null;
    update `game_status` set `status`='not active', `player_turn`=null, `result`=null;
    END ;;
DELIMITER ;

CREATE DEFINER=`root`@`localhost` PROCEDURE `move_piece`(row tinyint,col tinyint)
BEGIN
	declare  p, p_color char;
	
	select  piece, piece_color into p, p_color FROM `board` WHERE row=row and col=col
	
	update board
	set piece=p, piece_color=p_color
	where row=row and col=col;
	
    END ;;
DELIMITER ;