create table help_article
(
    id           int auto_increment
        primary key,
    name         varchar(255) not null,
    content      text null,
    author       int          not null,
    created_at   datetime default current_timestamp() null,
    date_deleted datetime null,
    deleted_by   int null,
    chapter      int null,
    tech_name    varchar(255) null,
    is_deleted   tinyint(1) default 0 null,
    constraint help_article_id_uindex
        unique (id)
);

create table help_chapter
(
    id           int auto_increment,
    name         varchar(255) not null,
    created_at   datetime default current_timestamp() null,
    date_deleted datetime null,
    deleted_by   int null,
    tech_name    varchar(255) null,
    is_deleted   tinyint(1) default 0 null,
    constraint help_chapter_id_uindex
        unique (id)
);

create table station
(
    id           int auto_increment
        primary key,
    address      varchar(255) null,
    size         int not null comment '' Max number of vehicles
        '',
    phone        varchar(255) null,
    name         varchar(255) null,
    created_at   datetime default current_timestamp() null,
    is_active    tinyint(1) default 1 null,
    date_deleted datetime null,
    deleted_by   int null,
    is_deleted   tinyint(1) default 0 null,
    constraint station_id_uindex
        unique (id)
);

create table ticket
(
    id               int auto_increment
        primary key,
    urgency          int          not null,
    state            int          not null,
    vehicle          int null comment '' Možná rework na grupu '',
    location_address varchar(255) null,
    location_gps     varchar(255) null,
    summary          varchar(255) not null,
    description      text         not null,
    created_at       datetime default current_timestamp() null,
    date_deleted     datetime null,
    deleted_by       int null,
    is_deleted       int      default 0 null,
    constraint ticket_id_uindex
        unique (id)
);

create table user
(
    id           int auto_increment comment '' Primary Key ''
        primary key,
    email        varchar(255) not null comment '' User Email '',
    password     varchar(255) not null comment '' User Password '',
    role         varchar(255) not null comment '' User Role '',
    created_at   datetime default current_timestamp() null comment '' Create Time '',
    name         varchar(255) null,
    is_active    tinyint  default 1 null,
    date_deleted datetime null,
    deleted_by   int null,
    is_deleted   tinyint(1) default 0 null,
    constraint user_email_uindex
        unique (email),
    constraint user_id_uindex
        unique (id)
);

create table vehicle
(
    id           int auto_increment
        primary key,
    callsign     varchar(255) not null,
    model        varchar(255) null,
    station      int null,
    on_station   tinyint(1) default 1 null,
    created_at   datetime default current_timestamp() null,
    date_deleted datetime null,
    deleted_by   int null,
    is_deleted   tinyint(1) default 0 null,
    constraint vehicle_callsign_uindex
        unique (callsign),
    constraint vehicle_id_uindex
        unique (id)
);
-- Insert password php has admin
INSERT INTO user(email, password, role, name) VALUES ('admin@admin.cz', '$2y$10$dBNtemQOdjHgIHL8JPZLk.rvbHF5vM.JVOHRnBb8UbjxcBq5yF0ja', 'Admin', 'Administrator');