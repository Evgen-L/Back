CREATE DATABASE Lw2DB;
USE Lw2DB
CREATE TABLE lw2T
(
	id_task     INT PRIMARY KEY IDENTITY(1,1),
	[description] VARCHAR(100),
	date_start  DATE,
	date_end    DATE,
	[priority]    VARCHAR(10)
)

INSERT INTO lw2T VALUES ('description 1', '2021-04-07', '2021-04-08', 'first'),
                             ('description 2', '2021-04-09', '2021-04-10', 'second'),
							 ('description 3', '2021-04-13', '2021-04-14', 'third'),
							 ('description 4', '2021-04-17', '2021-04-18', 'fourth'),
							 ('description 5', '2021-04-18', '2021-04-19', 'fifth')

SELECT * FROM lw2T
