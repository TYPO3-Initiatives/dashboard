#
# Table structure for table 'sys_dashboards'
#
CREATE TABLE sys_dashboards (
    identifier varchar(120) DEFAULT '' NOT NULL,
    label varchar(120) DEFAULT '' NOT NULL,
    configuration text
);

