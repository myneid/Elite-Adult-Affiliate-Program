create table Webmaster (
  id int not null primary key auto_increment,
  firstname varchar(32),
  lastname varchar(64),
  ssn_taxid varchar(15),
  street_address varchar(128),
  postal_code varchar(16),
  city varchar(64),
  state varchar(64),
  country varchar(3),
  email varchar(128),
  referred_webmaster_id int,
  aim varchar(16),
  icq varchar(16),
  skype varchar(16),
  phone varchar(16),
  referral_amount float(4,2),
  company varchar(64),
  pay_to varchar(64),
  minimum_payout float,
  payment_method varchar(16),
  notes text,
  referral_percent int,
  total_signups int,
  udf1 varchar(32),
  `per_signup` int(11) default NULL,
  key referred_webmaster_id (referred_webmaster_id)
) type=myisam comment='webmaster information';

create table Scale (
  id int not null primary key auto_increment,
  affiliate_id varchar(32),
  program_id int,
  percentage float,
  signups int,
  priceperhit float,
  pricepersignup float,
  pricereducedpercancel float,
  pricereducedperchargeback float,
  key affiliate_id (affiliate_id)
) type=myisam comment='pay out scale per afiliate';

create table Stats (
  id int not null primary key auto_increment,
  affiliate_id int,
  date date,
  hits int,
  uniques int,
  second_hits int,
  signups int,
  crosssales int,
  cancels int,
  chargebacks int,
  renewals int,
  scale_id int,
  income float,
  referral_income float,
  paid bool,
  payout_date date,
  key affiliate_id (affiliate_id),
  index idx_affilaite_id_date (affiliate_id, date)
  
) type=myisam comment='stats per day per affiliate';

create table Affiliate (
  id int not null primary key auto_increment,
  webmaster_id int,
  program_id int,
  status enum('ACTIVE', 'DISABLED', 'DISABLED-SPAM'),
  key webmaster_id (webmaster_id)
) type=myisam comment='each affiliate id for the webmasters';

create table Program (
  id int not null primary key auto_increment,
  name varchar(32),
  description varchar(128),
  scale_affiliate_id int
) type=myisam comment='each program in the system';

create table AffiliateLogin (
  id int not null primary key auto_increment,
  username varchar(32),
  password varchar(32),
  session_id varchar(128),
  affiliate_id int,
  key session_id (session_id),
  index idx_username_password (username, password)

) type=myisam comment='login information for the affiliate';

create table Site (
  id int not null primary key auto_increment,
  name varchar(32),
  description varchar(128),
  mainurl varchar(128),
  membersurl varchar(128),
  joinurl varchar(128),
  ext_siteid mediumint,
  status  enum('active','innactive','disabled','deleted') default 'active'

) type=myisam comment='each site in teh system';

create table Hit (
  id int not null primary key auto_increment,
  datetime datetime,
  affiliate_id int,
  hit_type varchar(32),
  ipaddress varchar(15),
  browser varchar(128),
  referring_url varchar(255),
  site_id int,
  uniq bool,
  program_id int default '1',
  key affiliate_id (affiliate_id),
  key datetime (datetime),
  index idx_affiliate_id_datetime (affiliate_id, datetime)

) type=myisam comment='raw data of each hit';

create table Sale (
  id int not null primary key auto_increment,
  datetime datetime,
  affiliate_id int,
  ipaddress varchar(15),
  amount float,
  type varchar(32),
  hits_id int,
  affiliate_payout float,
  scale_id int,
  processor_id tinyint,
  site_id int,
  transaction_id varchar(32),
  member_id int,
  notes int,
  key datetime (datetime),
  key affiliate_id (affiliate_id),
  index idx_affiliate_id_datetime (affiliate_id, datetime)

) type=myisam comment='all sales, new, renewals, credits, cancels';

create table APConfig (
  id int not null primary key auto_increment,
  name varchar(64),
  value varchar(255),
  description varchar(255)
) type=myisam comment='global config table';
insert into APConfig values(1, 'referral_percent', 5, 'This is the percent that you will pay for referred webmasters');
insert into APConfig values(2, 'referral_bonus', 25, 'Upon a new referral give this many dollars to the referrer as a bonus');
insert into APConfig values(3, 'base_url', 'http://www.mysite.com/', 'The base url of your site');
insert into APConfig values(4, 'admin_email', 'tanguy@0x7a69.net', 'This is the Administrators email');
insert into APConfig values(5, 'welcome_letter_location', '/tmp/welcomeletter.txt', 'location of welcome letter');
insert into APConfig values(6, 'site_name', 'AffiliateProgram', 'name of affiliate program');
insert into APConfig values(7, 'period_interval', 'BIMONTHLY', 'Frequency of payout' );

CREATE TABLE `EpochTransStats` (
  `ets_transaction_id` int(11) NOT NULL default '0',
  `ets_member_idx` int(11) NOT NULL default '0',
  `ets_transaction_date` datetime default NULL,
  `ets_transaction_type` char(1) NOT NULL default '',
  `ets_co_code` varchar(6) NOT NULL default '',
  `ets_pi_code` varchar(32) NOT NULL default '',
  `ets_reseller_code` varchar(64) default 'a',
  `ets_transaction_amount` decimal(10,2) NOT NULL default '0.00',
  `ets_payment_type` char(1) default 'A',
  `ets_username` varchar(32) default NULL,
  `ets_password` varchar(32) default NULL,
  `ets_email` varchar(64) default NULL,
  `ets_ref_trans_ids` int(11) default NULL,
  `ets_password_expire` varchar(20) default NULL,
  PRIMARY KEY  (`ets_transaction_id`),
  KEY `idx_reseller` (`ets_reseller_code`),
  KEY `idx_product` (`ets_pi_code`),
  KEY `idx_transdate` (`ets_transaction_date`),
  KEY `idx_type` (`ets_transaction_type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `EpochTransStatsProcessed` (
  `id` int(11) NOT NULL auto_increment,
  `transaction_id` int(11) NOT NULL default '0',
  `modified_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`transaction_id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `MemberCancelStats` (
  `mcs_or_idx` int(11) NOT NULL default '0',
  `mcs_canceldate` datetime default NULL,
  `mcs_signupdate` datetime default NULL,
  `mcs_cocode` varchar(16) NOT NULL default '',
  `mcs_picode` varchar(32) NOT NULL default '',
  `mcs_reseller` varchar(32) default NULL,
  `mcs_reason` varchar(64) default NULL,
  `mcs_memberstype` char(1) default NULL,
  `mcs_username` varchar(32) default NULL,
  `mcs_email` varchar(64) default NULL,
  `mcs_passwordremovaldate` datetime default NULL,
  PRIMARY KEY  (`mcs_or_idx`),
  KEY `ix_initdate` (`mcs_canceldate`),
  KEY `ix_signupdate` (`mcs_signupdate`),
  KEY `ix_pwdremdate` (`mcs_passwordremovaldate`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `ProcessedTransactions` (
  `id` int(11) NOT NULL auto_increment,
  `transaction_id` int(11) NOT NULL default '0',
  `date_time` datetime default NULL,
  `type` varchar(16) default NULL,
  `modified_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`transaction_id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `authorize` (
  `Date` datetime default NULL,
  `Username` varchar(12) default NULL,
  `IP` varchar(16) default NULL,
  `Status` int(1) default NULL,
  `hits` int(11) default '0',
  KEY `idx_isAuth` (`Username`,`Status`,`IP`,`Date`),
  KEY `idx_unsucclogin` (`Username`,`Status`,`Date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `fhg_gallery` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `fhg_gallery_pic` (
  `id` int(11) NOT NULL auto_increment,
  `gallery_id` int(11) default NULL,
  `filename` varchar(100) default NULL,
  `date_shown` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `members` (
  `ID` int(11) NOT NULL auto_increment,
  `Username` varchar(32) default NULL,
  `Password` varchar(32) default NULL,
  `Full_Name` varchar(32) default NULL,
  `Email` varchar(30) default NULL,
  `Address` varchar(50) default NULL,
  `City` varchar(30) default NULL,
  `Zip` varchar(10) default NULL,
  `State` varchar(30) default NULL,
  `Country` varchar(50) default NULL,
  `Date` date default NULL,
  `Exp_date` date default NULL,
  `Status` varchar(15) default NULL,
  `SiteID` int(11) default NULL,
  `Referred_by` varchar(12) default NULL,
  `mx_record` varchar(255) default NULL,
  `mailer_status` int(11) NOT NULL default '1',
  `mx_retrieved_at` datetime default NULL,
  `customer_id` int(11) default NULL,
  `ip_address` varchar(15) default NULL,
  `sale_id` int(11) default NULL,
  PRIMARY KEY  (`ID`),
  KEY `idx_userValid` (`Username`,`Password`,`Status`,`SiteID`),
  KEY `idx_siteidstatus` (`SiteID`,`Status`),
  KEY `idx_uservalid2` (`Username`,`Password`,`SiteID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `wire_info` (
  `id` int(11) NOT NULL auto_increment,
  `webmaster_id` int(11) NOT NULL default '0',
  `Full_Name` varchar(60) default NULL,
  `Phone_Number` varchar(20) default NULL,
  `Bank_Name` varchar(100) default NULL,
  `Bank_City` varchar(30) default NULL,
  `Bank_Country` varchar(50) default NULL,
  `Bank_SWIFT` varchar(30) default NULL,
  `Bank_ABA` varchar(40) default NULL,
  `Bank_Phone_Number` varchar(20) default NULL,
  `Account_Number` varchar(40) default NULL,
  `Intermediary_Bank_Name` varchar(100) default NULL,
  `Intermediary_Bank_City` varchar(30) default NULL,
  `Intermediary_Bank_Country` varchar(50) default NULL,
  `Intermediary_Bank_SWIFT` varchar(30) default NULL,
  `Intermediary_Bank_ABA` varchar(40) default NULL,
  `Intermediary_Account_Number` varchar(40) default NULL,
  `Other` text,
  PRIMARY KEY  (`id`),
  KEY `webmaster_id` (`webmaster_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
