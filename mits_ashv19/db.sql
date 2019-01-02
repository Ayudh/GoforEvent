CREATE TABLE `ashv_cse_people` (
 `people_id` int(11) NOT NULL AUTO_INCREMENT,
 `people_name` varchar(100) NOT NULL,
 `people_email` varchar(100) NOT NULL,
 `people_roll` varchar(100) NOT NULL,
 `people_campusid` varchar(100),
 `people_mobile` varchar(11) NOT NULL,
 `people_branch` varchar(100) NOT NULL,
 `people_gender` varchar(10) NOT NULL,
 `people_college` varchar(100) NOT NULL,
 `people_date` date NOT NULL,
 `people_txid` varchar(100) NOT NULL,
 `people_status` varchar(100) NOT NULL,
 PRIMARY KEY (`people_id`)
)

CREATE TABLE `ashv_cse_events` (
 `people_email` varchar(100) NOT NULL,
 `events_workshop` int(11) NOT NULL DEFAULT '0',
 `events_multi_workshop` int(11) NOT NULL DEFAULT '0',
 `events_paper` int(11) NOT NULL DEFAULT '0',
 `events_poster` int(11) NOT NULL DEFAULT '0',
 `events_project` int(11) NOT NULL DEFAULT '0',
 `events_cricket` int(11) NOT NULL DEFAULT '0',
 `events_volleym` int(11) NOT NULL DEFAULT '0',
 `events_kabaddi` int(11) NOT NULL DEFAULT '0',
 `events_football` int(11) NOT NULL DEFAULT '0',
 `events_tennikoit` int(11) NOT NULL DEFAULT '0',
 `events_volleyw` int(11) NOT NULL DEFAULT '0',
 `events_larynx` int(11) NOT NULL DEFAULT '0',
 `events_dancewance` int(11) NOT NULL DEFAULT '0',
 `events_artsalad` int(11) NOT NULL DEFAULT '0',
 `events_theatre` int(11) NOT NULL DEFAULT '0',
 `events_haute` int(11) NOT NULL DEFAULT '0',
 `events_accom` int(11) NOT NULL DEFAULT '0',
 `people_amount` double NOT NULL,
 PRIMARY KEY (`people_email`)
)

