-- DROP SCHEMA dbo;

CREATE SCHEMA dbo;
-- boletos.dbo.distributions definition

-- Drop table

-- DROP TABLE boletos.dbo.distributions;

CREATE TABLE boletos.dbo.distributions (
	id int IDENTITY(1,1) NOT NULL,
	description varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	floors int DEFAULT 1 NULL,
	created_at date DEFAULT getdate() NULL,
	CONSTRAINT distributions_pk PRIMARY KEY (id)
);


-- boletos.dbo.locations definition

-- Drop table

-- DROP TABLE boletos.dbo.locations;

CREATE TABLE boletos.dbo.locations (
	id int IDENTITY(1,1) NOT NULL,
	location varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	acronym varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS DEFAULT '' NOT NULL,
	CONSTRAINT locations_pk PRIMARY KEY (id)
);


-- boletos.dbo.users definition

-- Drop table

-- DROP TABLE boletos.dbo.users;

CREATE TABLE boletos.dbo.users (
	id int IDENTITY(1,1) NOT NULL,
	username varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	fullname varchar(150) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	password varchar(64) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	[role] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	CONSTRAINT users_pk PRIMARY KEY (id)
);


-- boletos.dbo.buses definition

-- Drop table

-- DROP TABLE boletos.dbo.buses;

CREATE TABLE boletos.dbo.buses (
	id int IDENTITY(1,1) NOT NULL,
	placa varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	description varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	distribution_id int NULL,
	created_at date DEFAULT getdate() NULL,
	CONSTRAINT buses_pk PRIMARY KEY (id),
	CONSTRAINT buses_unique UNIQUE (placa),
	CONSTRAINT buses_distributions_FK FOREIGN KEY (distribution_id) REFERENCES boletos.dbo.distributions(id)
);


-- boletos.dbo.distro_seats definition

-- Drop table

-- DROP TABLE boletos.dbo.distro_seats;

CREATE TABLE boletos.dbo.distro_seats (
	id int IDENTITY(1,1) NOT NULL,
	col1 varchar(3) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	col2 varchar(3) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	col3 varchar(3) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	col4 varchar(3) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	col5 varchar(3) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	distro_id int NOT NULL,
	floor int DEFAULT 1 NOT NULL,
	CONSTRAINT distro_seats_pk PRIMARY KEY (id),
	CONSTRAINT distro_seats_distributions_FK FOREIGN KEY (distro_id) REFERENCES boletos.dbo.distributions(id)
);


-- boletos.dbo.trips definition

-- Drop table

-- DROP TABLE boletos.dbo.trips;

CREATE TABLE boletos.dbo.trips (
	id int IDENTITY(1,1) NOT NULL,
	departure_date date NULL,
	departure_time time(0) NULL,
	bus_id int NOT NULL,
	location_id int NOT NULL,
	CONSTRAINT trips_pk PRIMARY KEY (id),
	CONSTRAINT trips_buses_FK FOREIGN KEY (bus_id) REFERENCES boletos.dbo.buses(id),
	CONSTRAINT trips_locations_FK FOREIGN KEY (location_id) REFERENCES boletos.dbo.locations(id)
);


-- boletos.dbo.tickets definition

-- Drop table

-- DROP TABLE boletos.dbo.tickets;

CREATE TABLE boletos.dbo.tickets (
	id int IDENTITY(1,1) NOT NULL,
	seat_number int NOT NULL,
	trip_id int NOT NULL,
	details varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	created_at datetime DEFAULT getdate() NULL,
	sold_by int NULL,
	CONSTRAINT tickets_pk PRIMARY KEY (id),
	CONSTRAINT tickets_trips_FK FOREIGN KEY (trip_id) REFERENCES boletos.dbo.trips(id),
	CONSTRAINT tickets_users_FK FOREIGN KEY (sold_by) REFERENCES boletos.dbo.users(id)
);