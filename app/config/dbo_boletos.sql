/*
 Navicat Premium Data Transfer

 Source Server         : Local Laptop
 Source Server Type    : SQL Server
 Source Server Version : 16001000
 Source Host           : localhost:1433
 Source Catalog        : boletos
 Source Schema         : dbo

 Target Server Type    : SQL Server
 Target Server Version : 16001000
 File Encoding         : 65001

 Date: 01/06/2024 13:44:22
*/


-- ----------------------------
-- Table structure for buses
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[buses]') AND type IN ('U'))
	DROP TABLE [dbo].[buses]
GO

CREATE TABLE [dbo].[buses] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [placa] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS  NOT NULL,
  [description] varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [distribution_id] int  NULL,
  [created_at] date DEFAULT getdate() NULL
)
GO

ALTER TABLE [dbo].[buses] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of buses
-- ----------------------------
SET IDENTITY_INSERT [dbo].[buses] ON
GO

INSERT INTO [dbo].[buses] ([id], [placa], [description], [distribution_id], [created_at]) VALUES (N'1', N'890-PLT', N'Bus Normal ', N'1', N'2024-05-31')
GO

SET IDENTITY_INSERT [dbo].[buses] OFF
GO


-- ----------------------------
-- Table structure for clients
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[clients]') AND type IN ('U'))
	DROP TABLE [dbo].[clients]
GO

CREATE TABLE [dbo].[clients] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [name] varchar(255) COLLATE Modern_Spanish_CI_AS  NOT NULL,
  [lastname] varchar(255) COLLATE Modern_Spanish_CI_AS  NULL,
  [mothers_lastname] varchar(255) COLLATE Modern_Spanish_CI_AS  NULL,
  [ci] varchar(50) COLLATE Modern_Spanish_CI_AS  NULL,
  [nit] varchar(50) COLLATE Modern_Spanish_CI_AS  NULL,
  [is_minor] bit  NULL,
  [user_id] int  NULL,
  [created_at] datetime  NULL
)
GO

ALTER TABLE [dbo].[clients] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of clients
-- ----------------------------
SET IDENTITY_INSERT [dbo].[clients] ON
GO

INSERT INTO [dbo].[clients] ([id], [name], [lastname], [mothers_lastname], [ci], [nit], [is_minor], [user_id], [created_at]) VALUES (N'1', N'jiuseppe', N'flores', N'quisbert', N'123456', N'789456', N'0', NULL, NULL)
GO

INSERT INTO [dbo].[clients] ([id], [name], [lastname], [mothers_lastname], [ci], [nit], [is_minor], [user_id], [created_at]) VALUES (N'2', N'sheyla', N'quispe', N'tancani', N'5789456', N'6981225', N'1', NULL, NULL)
GO

INSERT INTO [dbo].[clients] ([id], [name], [lastname], [mothers_lastname], [ci], [nit], [is_minor], [user_id], [created_at]) VALUES (N'3', N'asdasd', N'asdasd', N'asdasd', N'456456', N'456456', N'1', N'4', N'2024-01-06 12:16:21.000')
GO

INSERT INTO [dbo].[clients] ([id], [name], [lastname], [mothers_lastname], [ci], [nit], [is_minor], [user_id], [created_at]) VALUES (N'4', N'asdasd', N'asdasd', N'asdasd', N'456456', N'456456', N'1', N'4', N'2024-01-06 12:18:33.000')
GO

INSERT INTO [dbo].[clients] ([id], [name], [lastname], [mothers_lastname], [ci], [nit], [is_minor], [user_id], [created_at]) VALUES (N'5', N'test 1', N'test 2', N'test 4', N'876543', N'', N'0', N'4', N'2024-01-06 12:30:22.000')
GO

INSERT INTO [dbo].[clients] ([id], [name], [lastname], [mothers_lastname], [ci], [nit], [is_minor], [user_id], [created_at]) VALUES (N'6', N'test 4', N'test 4', N'test 4', N'', N'4444', N'1', N'4', N'2024-01-06 12:46:54.000')
GO

INSERT INTO [dbo].[clients] ([id], [name], [lastname], [mothers_lastname], [ci], [nit], [is_minor], [user_id], [created_at]) VALUES (N'7', N'ghkjklj', N'jkljkl', N'jkljkl', N'678678', N'678678', N'1', N'4', N'2024-01-06 13:00:58.000')
GO

SET IDENTITY_INSERT [dbo].[clients] OFF
GO


-- ----------------------------
-- Table structure for distributions
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[distributions]') AND type IN ('U'))
	DROP TABLE [dbo].[distributions]
GO

CREATE TABLE [dbo].[distributions] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [description] varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [floors] int DEFAULT 1 NULL,
  [created_at] date DEFAULT getdate() NULL
)
GO

ALTER TABLE [dbo].[distributions] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of distributions
-- ----------------------------
SET IDENTITY_INSERT [dbo].[distributions] ON
GO

INSERT INTO [dbo].[distributions] ([id], [description], [floors], [created_at]) VALUES (N'1', N'Simple', N'1', N'2024-05-31')
GO

SET IDENTITY_INSERT [dbo].[distributions] OFF
GO


-- ----------------------------
-- Table structure for distro_seats
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[distro_seats]') AND type IN ('U'))
	DROP TABLE [dbo].[distro_seats]
GO

CREATE TABLE [dbo].[distro_seats] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [col1] varchar(3) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [col2] varchar(3) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [col3] varchar(3) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [col4] varchar(3) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [col5] varchar(3) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [distro_id] int  NOT NULL,
  [floor] int DEFAULT 1 NOT NULL
)
GO

ALTER TABLE [dbo].[distro_seats] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of distro_seats
-- ----------------------------
SET IDENTITY_INSERT [dbo].[distro_seats] ON
GO

INSERT INTO [dbo].[distro_seats] ([id], [col1], [col2], [col3], [col4], [col5], [distro_id], [floor]) VALUES (N'3', N'1', N'2', NULL, N'3', N'4', N'1', N'1')
GO

INSERT INTO [dbo].[distro_seats] ([id], [col1], [col2], [col3], [col4], [col5], [distro_id], [floor]) VALUES (N'4', N'5', N'6', NULL, N'7', N'8', N'1', N'1')
GO

INSERT INTO [dbo].[distro_seats] ([id], [col1], [col2], [col3], [col4], [col5], [distro_id], [floor]) VALUES (N'5', N'9', N'10', NULL, N'11', N'12', N'1', N'1')
GO

INSERT INTO [dbo].[distro_seats] ([id], [col1], [col2], [col3], [col4], [col5], [distro_id], [floor]) VALUES (N'6', N'13', N'14', NULL, NULL, N'P', N'1', N'1')
GO

INSERT INTO [dbo].[distro_seats] ([id], [col1], [col2], [col3], [col4], [col5], [distro_id], [floor]) VALUES (N'7', N'15', N'16', NULL, N'17', N'18', N'1', N'1')
GO

INSERT INTO [dbo].[distro_seats] ([id], [col1], [col2], [col3], [col4], [col5], [distro_id], [floor]) VALUES (N'8', N'19', N'20', NULL, N'21', N'22', N'1', N'1')
GO

INSERT INTO [dbo].[distro_seats] ([id], [col1], [col2], [col3], [col4], [col5], [distro_id], [floor]) VALUES (N'9', N'23', N'24', NULL, N'25', N'26', N'1', N'1')
GO

INSERT INTO [dbo].[distro_seats] ([id], [col1], [col2], [col3], [col4], [col5], [distro_id], [floor]) VALUES (N'10', N'27', N'28', N'T', N'29', N'30', N'1', N'1')
GO

INSERT INTO [dbo].[distro_seats] ([id], [col1], [col2], [col3], [col4], [col5], [distro_id], [floor]) VALUES (N'11', N'31', N'32', NULL, N'33', N'34', N'1', N'1')
GO

INSERT INTO [dbo].[distro_seats] ([id], [col1], [col2], [col3], [col4], [col5], [distro_id], [floor]) VALUES (N'12', N'35', N'36', NULL, N'37', N'38', N'1', N'1')
GO

INSERT INTO [dbo].[distro_seats] ([id], [col1], [col2], [col3], [col4], [col5], [distro_id], [floor]) VALUES (N'13', N'39', N'40', NULL, N'41', N'42', N'1', N'1')
GO

INSERT INTO [dbo].[distro_seats] ([id], [col1], [col2], [col3], [col4], [col5], [distro_id], [floor]) VALUES (N'14', N'43', N'44', NULL, N'45', N'46', N'1', N'1')
GO

INSERT INTO [dbo].[distro_seats] ([id], [col1], [col2], [col3], [col4], [col5], [distro_id], [floor]) VALUES (N'15', N'47', N'48', NULL, N'49', N'50', N'1', N'1')
GO

SET IDENTITY_INSERT [dbo].[distro_seats] OFF
GO


-- ----------------------------
-- Table structure for locations
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[locations]') AND type IN ('U'))
	DROP TABLE [dbo].[locations]
GO

CREATE TABLE [dbo].[locations] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [location] varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS  NOT NULL,
  [acronym] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS DEFAULT '' NOT NULL
)
GO

ALTER TABLE [dbo].[locations] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of locations
-- ----------------------------
SET IDENTITY_INSERT [dbo].[locations] ON
GO

INSERT INTO [dbo].[locations] ([id], [location], [acronym]) VALUES (N'1', N'la paz', N'lp')
GO

INSERT INTO [dbo].[locations] ([id], [location], [acronym]) VALUES (N'2', N'uyuni', N'uni')
GO

INSERT INTO [dbo].[locations] ([id], [location], [acronym]) VALUES (N'3', N'potosi', N'pt')
GO

INSERT INTO [dbo].[locations] ([id], [location], [acronym]) VALUES (N'4', N'santa cruz', N'SC')
GO

SET IDENTITY_INSERT [dbo].[locations] OFF
GO


-- ----------------------------
-- Table structure for tickets
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[tickets]') AND type IN ('U'))
	DROP TABLE [dbo].[tickets]
GO

CREATE TABLE [dbo].[tickets] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [seat_number] int  NOT NULL,
  [trip_id] int  NOT NULL,
  [client_id] int  NOT NULL,
  [created_at] datetime DEFAULT getdate() NULL,
  [sold_by] int  NULL
)
GO

ALTER TABLE [dbo].[tickets] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of tickets
-- ----------------------------
SET IDENTITY_INSERT [dbo].[tickets] ON
GO

SET IDENTITY_INSERT [dbo].[tickets] OFF
GO


-- ----------------------------
-- Table structure for trips
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[trips]') AND type IN ('U'))
	DROP TABLE [dbo].[trips]
GO

CREATE TABLE [dbo].[trips] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [departure_date] date  NULL,
  [departure_time] time  NULL,
  [bus_id] int  NOT NULL,
  [location_id_origin] int  NOT NULL,
  [min_price] float(53)  NULL,
  [price] float(53)  NULL,
  [location_id_dest] int  NULL
)
GO

ALTER TABLE [dbo].[trips] SET (LOCK_ESCALATION = TABLE)
GO

EXEC sp_addextendedproperty
'MS_Description', N'Precio minimo',
'SCHEMA', N'dbo',
'TABLE', N'trips',
'COLUMN', N'min_price'
GO

EXEC sp_addextendedproperty
'MS_Description', N'Precio normal',
'SCHEMA', N'dbo',
'TABLE', N'trips',
'COLUMN', N'price'
GO


-- ----------------------------
-- Records of trips
-- ----------------------------
SET IDENTITY_INSERT [dbo].[trips] ON
GO

INSERT INTO [dbo].[trips] ([id], [departure_date], [departure_time], [bus_id], [location_id_origin], [min_price], [price], [location_id_dest]) VALUES (N'1', N'2024-06-02', N'13:30:00', N'1', N'2', N'50', N'55', N'1')
GO

INSERT INTO [dbo].[trips] ([id], [departure_date], [departure_time], [bus_id], [location_id_origin], [min_price], [price], [location_id_dest]) VALUES (N'2', N'2024-06-03', N'22:30:00', N'1', N'3', N'30', N'40', N'2')
GO

INSERT INTO [dbo].[trips] ([id], [departure_date], [departure_time], [bus_id], [location_id_origin], [min_price], [price], [location_id_dest]) VALUES (N'3', N'2024-06-02', N'13:30:00', N'1', N'1', N'30', N'45', N'3')
GO

SET IDENTITY_INSERT [dbo].[trips] OFF
GO


-- ----------------------------
-- Table structure for users
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[dbo].[users]') AND type IN ('U'))
	DROP TABLE [dbo].[users]
GO

CREATE TABLE [dbo].[users] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [username] varchar(100) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [fullname] varchar(150) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [password] varchar(64) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL,
  [role] varchar(10) COLLATE SQL_Latin1_General_CP1_CI_AS  NULL
)
GO

ALTER TABLE [dbo].[users] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of users
-- ----------------------------
SET IDENTITY_INSERT [dbo].[users] ON
GO

INSERT INTO [dbo].[users] ([id], [username], [fullname], [password], [role]) VALUES (N'1', N'admin', N'Usuario Administrador', N'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', N'ADMIN')
GO

INSERT INTO [dbo].[users] ([id], [username], [fullname], [password], [role]) VALUES (N'3', N'vendedor2', N'German Llantos', N'4ec043af19e8ffd26bea8e241d4f1f8824060216823fa4fbc80216ee7384a747', N'VENDEDOR')
GO

INSERT INTO [dbo].[users] ([id], [username], [fullname], [password], [role]) VALUES (N'4', N'jiuseppe', N'Jiuseppe Flores', N'8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', N'ADMIN')
GO

SET IDENTITY_INSERT [dbo].[users] OFF
GO


-- ----------------------------
-- Auto increment value for buses
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[buses]', RESEED, 1)
GO


-- ----------------------------
-- Uniques structure for table buses
-- ----------------------------
ALTER TABLE [dbo].[buses] ADD CONSTRAINT [buses_unique] UNIQUE NONCLUSTERED ([placa] ASC)
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Primary Key structure for table buses
-- ----------------------------
ALTER TABLE [dbo].[buses] ADD CONSTRAINT [buses_pk] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for clients
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[clients]', RESEED, 7)
GO


-- ----------------------------
-- Primary Key structure for table clients
-- ----------------------------
ALTER TABLE [dbo].[clients] ADD CONSTRAINT [PK__clients__3213E83FBA640139] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for distributions
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[distributions]', RESEED, 1)
GO


-- ----------------------------
-- Primary Key structure for table distributions
-- ----------------------------
ALTER TABLE [dbo].[distributions] ADD CONSTRAINT [distributions_pk] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for distro_seats
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[distro_seats]', RESEED, 15)
GO


-- ----------------------------
-- Primary Key structure for table distro_seats
-- ----------------------------
ALTER TABLE [dbo].[distro_seats] ADD CONSTRAINT [distro_seats_pk] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for locations
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[locations]', RESEED, 4)
GO


-- ----------------------------
-- Primary Key structure for table locations
-- ----------------------------
ALTER TABLE [dbo].[locations] ADD CONSTRAINT [locations_pk] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for tickets
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[tickets]', RESEED, 1)
GO


-- ----------------------------
-- Primary Key structure for table tickets
-- ----------------------------
ALTER TABLE [dbo].[tickets] ADD CONSTRAINT [tickets_pk] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for trips
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[trips]', RESEED, 3)
GO


-- ----------------------------
-- Primary Key structure for table trips
-- ----------------------------
ALTER TABLE [dbo].[trips] ADD CONSTRAINT [trips_pk] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for users
-- ----------------------------
DBCC CHECKIDENT ('[dbo].[users]', RESEED, 4)
GO


-- ----------------------------
-- Primary Key structure for table users
-- ----------------------------
ALTER TABLE [dbo].[users] ADD CONSTRAINT [users_pk] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Foreign Keys structure for table buses
-- ----------------------------
ALTER TABLE [dbo].[buses] ADD CONSTRAINT [buses_distributions_FK] FOREIGN KEY ([distribution_id]) REFERENCES [dbo].[distributions] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table distro_seats
-- ----------------------------
ALTER TABLE [dbo].[distro_seats] ADD CONSTRAINT [distro_seats_distributions_FK] FOREIGN KEY ([distro_id]) REFERENCES [dbo].[distributions] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table tickets
-- ----------------------------
ALTER TABLE [dbo].[tickets] ADD CONSTRAINT [tickets_clients_FK] FOREIGN KEY ([client_id]) REFERENCES [dbo].[clients] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [dbo].[tickets] ADD CONSTRAINT [tickets_trips_FK] FOREIGN KEY ([trip_id]) REFERENCES [dbo].[trips] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [dbo].[tickets] ADD CONSTRAINT [tickets_users_FK] FOREIGN KEY ([sold_by]) REFERENCES [dbo].[users] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table trips
-- ----------------------------
ALTER TABLE [dbo].[trips] ADD CONSTRAINT [trips_buses_FK] FOREIGN KEY ([bus_id]) REFERENCES [dbo].[buses] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [dbo].[trips] ADD CONSTRAINT [trips_locations_FK] FOREIGN KEY ([location_id_origin]) REFERENCES [dbo].[locations] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [dbo].[trips] ADD CONSTRAINT [trips_location_destination_FK] FOREIGN KEY ([location_id_dest]) REFERENCES [dbo].[locations] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

