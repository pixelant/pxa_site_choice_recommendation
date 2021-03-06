#
# Table structure for table 'tx_pxasitechoicerecommendation_domain_model_sitechoice'
#
CREATE TABLE tx_pxasitechoicerecommendation_domain_model_sitechoice (
    uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	root_pages varchar(255) DEFAULT '' NOT NULL,
	max_items int(11) DEFAULT '0' NOT NULL,
	splash_pages int(11) unsigned DEFAULT '0' NOT NULL,
	choices int(11) unsigned DEFAULT '0' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted smallint(5) unsigned DEFAULT '0' NOT NULL,
	hidden smallint(5) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,
	l10n_state text,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY language (l10n_parent,sys_language_uid)
);

#
# Table structure for table 'tx_pxasitechoicerecommendation_domain_model_choice'
#
CREATE TABLE tx_pxasitechoicerecommendation_domain_model_choice (
    uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title text,
	country_isocode varchar(2) DEFAULT '' NOT NULL,
	language_isocode varchar(2) DEFAULT '' NOT NULL,
	link varchar(255) DEFAULT '' NOT NULL,
	language_layer_uid int(11) DEFAULT '0' NOT NULL,
	flag varchar(20) DEFAULT '' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted smallint(5) unsigned DEFAULT '0' NOT NULL,
	hidden smallint(5) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,
	l10n_state text,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY language (l10n_parent,sys_language_uid)
);

#
# Table structure for table 'tx_pxasitechoicerecommendation_domain_model_splashpage'
#
CREATE TABLE tx_pxasitechoicerecommendation_domain_model_splashpage (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    root_page text,
    link_target varchar(255) DEFAULT '' NOT NULL,

    tstamp int(11) unsigned DEFAULT '0' NOT NULL,
    crdate int(11) unsigned DEFAULT '0' NOT NULL,
    cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
    deleted smallint(5) unsigned DEFAULT '0' NOT NULL,
    hidden smallint(5) unsigned DEFAULT '0' NOT NULL,
    sorting int(11) DEFAULT '0' NOT NULL,

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l10n_parent int(11) DEFAULT '0' NOT NULL,
    l10n_diffsource mediumblob,
    l10n_state text,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY language (l10n_parent,sys_language_uid)
);

#
# Table structure for table 'tx_pxasitechoicerecommendation_domain_model_splashpage'
#
CREATE TABLE tx_pxasitechoicerecommendation_domain_model_splashpage (
    sitechoice int(11) unsigned DEFAULT '0' NOT NULL
);

#
# Table structure for table 'tx_pxasitechoicerecommendation_domain_model_choice'
#
CREATE TABLE tx_pxasitechoicerecommendation_domain_model_choice (
	sitechoice int(11) unsigned DEFAULT '0' NOT NULL
);
