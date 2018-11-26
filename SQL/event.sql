
CREATE TABLE `evenements` (
  `idEvent` int(11) NOT NULL AUTO_INCREMENT,
  `jour` date NOT NULL,
  `target` varchar(40) NOT NULL,
  `author` varchar(40) NOT NULL,
  `description` varchar(255) NOT NULL,
  `isDone` enum('true','false') NOT NULL,
  PRIMARY KEY (idEvent),
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `evenements`
--

INSERT INTO `evenements` ( `jour`, `target`, `author`, `description`, `isDone`) VALUES
('2018-11-01', 'Pat', 'Trycias', 'C\'est le jour UN', 'false'),
('2018-11-02', 'Pat', 'dev', 'AHAHAHAH', 'false'),
( '2018-11-02', 'Pat', 'dev2', 'AHAHAHAH', 'false');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `evenements`
--
ALTER TABLE `evenements`
  ADD PRIMARY KEY (`jour`,`target`,`author`);