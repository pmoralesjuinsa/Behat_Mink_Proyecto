CREATE DATABASE IF NOT EXISTS retoRefac;
USE retoRefac;

create table ingresos
(
    id      int auto_increment
        primary key,
    nombre  varchar(80)                            not null,
    importe float                                  not null,
    fecha   datetime default '1999-01-01 00:00:00' not null
);

create table tipo_gastos
(
    id      int auto_increment
        primary key,
    nombre  varchar(80) not null,
    importe float       not null
);

create table gastos
(
    id             int auto_increment
        primary key,
    id_tipo_gastos int                                    not null,
    cantidad       int      default 1                     not null,
    importe        float                                  not null,
    fecha          datetime default '1999-01-01 00:00:00' not null,
    nota           varchar(60)                            null,
    constraint gastos_tipo_gastos_id_fk
        foreign key (id_tipo_gastos) references tipo_gastos (id)
            on update cascade
);
