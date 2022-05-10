CREATE TABLE IF NOT EXISTS llx_c_voyagebuilder_voyage_tag
(
    rowid int NOT NULL auto_increment PRIMARY KEY,
    code varchar(100),
    label varchar(100),
    tarift double,
    active bool
)
