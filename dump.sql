CREATE TABLE IF NOT EXISTS `ot_answers` (
  `id_answer` int(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `correct` tinyint(1) NOT NULL,
  `id_question` int(7) NOT NULL,
  PRIMARY KEY (`id_answer`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ot_log` (
  `id_log` int(7) NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `id_user` int(7) NOT NULL,
  `id_test` int(7) NOT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ot_questions` (
  `id_question` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `answer1` varchar(255) NOT NULL,
  `answer2` varchar(255) NOT NULL,
  `answer3` varchar(255) NOT NULL,
  `answer4` varchar(255) NOT NULL,
  `answer5` varchar(255) NOT NULL,
  `rightanswer1` tinyint(1) NOT NULL,
  `rightanswer2` tinyint(1) NOT NULL,
  `rightanswer3` tinyint(1) NOT NULL,
  `rightanswer4` tinyint(1) NOT NULL,
  `rightanswer5` tinyint(1) NOT NULL,
  `id_test` int(6) NOT NULL,
  PRIMARY KEY (`id_question`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


INSERT INTO `ot_questions` (`id_question`, `name`, `answer1`, `answer2`, `answer3`, `answer4`, `answer5`, `rightanswer1`, `rightanswer2`, `rightanswer3`, `rightanswer4`, `rightanswer5`, `id_test`) VALUES
(1, '2 + 2 = ? ', ' 2', ' 3', ' 4', ' 1', ' 5', 0, 0, 1, 0, 0, 1),
(2, '3 - 2 = ?', ' 1', ' 2', ' 3', ' 4', ' 5', 1, 0, 0, 0, 0, 1),
(3, '34 + 22 = ?', '  54', ' 55', ' 56', ' 57', ' 58', 0, 0, 0, 1, 0, 1),
(4, '60 + 10 = ?', '90', '70', '50', '25', '10', 0, 1, 0, 0, 0, 1),
(5, '11 - 11 = ?', '17', '0', '8', '2', '22', 0, 1, 0, 0, 0, 1),
(6, '45 - 10 = ?', '33', '34', '35', '35', '37', 0, 0, 1, 0, 0, 1),
(7, 'Двум братьям вместе 11 лет. Один из них на 10 лет старше другого. Сколько лет младшему? ', '9 лет ', '2 года ', '1 год ', '6 месяцев ', '11 лет ', 0, 0, 0, 0, 1, 1),
(8, '1 * 5 = ?', '1', '5', '10', '15', '20', 0, 1, 0, 0, 0, 2),
(9, '5 / 1 = ?', '1', '5', '10', '15', '20', 0, 1, 0, 0, 0, 2),
(10, '2 * 3 = ?', '2', '6', '3', '1', '10', 0, 1, 0, 0, 0, 2),
(11, '4 / 2 = ?', '2', '4', '6', '8', '10', 1, 0, 0, 0, 0, 2),
(12, '18 / 9 = ?', '2', '18', '9', '0', '1', 1, 0, 0, 0, 0, 2),
(13, '7 * 7 = ?', '7', '49', '3', '2', '1', 0, 1, 0, 0, 0, 2),
(14, '7 / 7 = ?', '7', '1', '49', '3', '2', 0, 1, 0, 0, 0, 2),
(15, 'Сколько букв в алфавите?', '30', '26', '33', '28', '19', 0, 0, 1, 0, 0, 3),
(16, 'Вставьте букву МОЛ..ОКО', 'О', 'А', 'Е', '', '', 1, 0, 0, 0, 0, 3),
(17, 'Вставьте букву С..БАКА', 'А', 'О', '', '', '', 0, 1, 0, 0, 0, 3),
(18, 'Вставьте букву САМ..ЛЕТ', 'О', 'А', '', '', '', 1, 0, 0, 0, 0, 3),
(19, 'Вставьте букву ГР..ЗА', 'А', 'О', '', '', '', 0, 1, 0, 0, 0, 3),
(20, 'Вставьте букву К..ЛЕСО', 'А', 'О', '', '', '', 0, 1, 0, 0, 0, 3),
(21, 'Вставьте букву Л..ТАТЬ', 'Е', 'И', '', '', '', 1, 0, 0, 0, 0, 3),
(22, 'Вставьте букву ЛА..ТЬ', 'Я', 'И', '', '', '', 1, 0, 0, 0, 0, 3);




CREATE TABLE IF NOT EXISTS `ot_result` (
  `id_result` int(7) NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `test_result` tinyint(1) NOT NULL,
  `id_question` int(7) NOT NULL,
  `id_log` int(7) NOT NULL,
  PRIMARY KEY (`id_result`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `ot_test` (
  `id_test` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id_test`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

INSERT INTO `ot_test` (`id_test`, `name`, `description`) VALUES
(1, 'Математический тест', 'Сложение и вычитание'),
(2, 'Математический тест', 'Умножение и деление'),
(3, 'Тест по русскому языку', 'Начальная школа');

CREATE TABLE IF NOT EXISTS `ot_users` (
  `id_user` int(6) NOT NULL AUTO_INCREMENT,
  `login` varchar(200) NOT NULL,
  `psswd` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


INSERT INTO `ot_users` (`id_user`, `login`, `psswd`, `name`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Админ'),
(2, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'User');
