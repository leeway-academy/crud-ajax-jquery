-- we don't know how to generate root <with-no-name> (class Root) :(
create table contacts
(
    id integer not null
        constraint contacts_pk
            primary key autoincrement,
    firstname varchar not null,
    lastname varchar not null,
    email varchar
);

create unique index contacts_email_uindex
	on contacts (email);

create unique index contacts_id_uindex
	on contacts (id);

