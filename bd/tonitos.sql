create database tonitos;
use tonitos;
select * from Activo;
delete from Activo;
drop table Activo;
create table Activo(
	IDA int auto_increment,
    Mesa int not null,
    Cliente varchar(40) not null,
    Mesero varchar(40) not null,
    Hora varchar(20) not null,
    Propina int not null,
    Llevar int not null,
    primary key (IDA)
);
select * from Description;
delete from Description;
create table Description(
	IDA int not null,
    IDME int not null,
    Cantidad int not null
);

create table Mesero(
	IDM int auto_increment,
    PIN int not null,
    Nombre varchar(40) not null,
    primary key(IDM)
);
update Menu set Descuento = 0;
drop table Menu;
create table Menu(
	IDME int auto_increment,
    Producto varchar(60) not null,
    Precio double not null,
    Grupo int not null,
    Descuento double not null,
    primary key (IDME)
);
select * from Historial;
delete from Historial;
drop table Historial;
create table Historial(
	IDH int auto_increment,
    Mesa int not null,
    Cliente varchar(40) not null,
    Mesero varchar(40) not null,
    Hora varchar(40) not null,
    Fecha varchar(40) not null,
    Propina int not null,
	primary key (IDH)
);
select * from Historial_Orden;
delete from Historial_Orden;
drop table Historial_Orden;
create table Historial_Orden(
	IDH int not null,
    Producto varchar(60) not null,
    Cantidad int not null,
    Precio double not null
);

create table Regis_diario(
	Id int auto_increment,
    Fecha varchar(20) not null,
    Total double not null,
    primary key(Id)
);

select ho Porducto, COUNT(1) as total from Historial_Orden bs where IdCliente=0 group by bs.Busqueda having count(1) > 1 order by total desc;

alter table Activo
add constraint fk_a
foreign key (IDM) references Mesero (IDM);

alter table Activo
add constraint fk_d
foreign key (IDD) references Description (IDD);

alter table Description
add constraint fk_menu
foreign key (IDME) references Menu (IDME);

alter table Historial
add constraint fk_mesero
foreign key (IDM) references Mesero (IDM);

alter table Historial_Orden
add constraint fk_his
foreign key (IDH) references Historial (IDH);


INSERT INTO Activo (Mesa , Cliente , IDM , Hora) VALUES (1 , 'David' , 1 , '10:00');
SELECT IDA FROM Activo ORDER BY IDA DESC;
INSERT INTO Description (IDA ,IDME , Cantidad) VALUES (1 , 1 , 3);
INSERT INTO Description (IDA ,IDME , Cantidad) VALUES (7 , 1 , 1);