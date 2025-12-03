-- -- 1 Create Database
-- CREATE DATABASE Smart_Wallet;
-- GO

-- -- 2 Select Database
-- USE Smart_Wallet;
-- GO

-- -- 3 Create table Income
-- CREATE TABLE Income (
--     id INT PRIMARY KEY AUTO_INCREMENT,
--     montent  INT NOT NULL ,
--     description  VARCHAR(255) NOT NULL,
--     date DATE DEFAULT (CURRENT_TIME)
-- );
-- GO

-- -- 4 Create table Expens
-- CREATE TABLE Expense (
--     id INT  PRIMARY KEY AUTO_INCREMENT,
--     montent INT NOT NULL ,
--     description VARCHAR(255) NOT NULL,
--     date DATE DEFAULT (CURRENT_TIME)
-- );
-- GO

-- -- 5 Insert data Income
-- INSERT INTO Income (montent, description, date) VALUES
-- (8500, N'Salaire Mensuel – Poste Développeur', '2025-02-01'),
-- (2500, N'Prime de Performance – Objectifs Atteints', '2025-02-10'),
-- (6000, N'Développement Site Web – Projet freelance', '2025-02-15'),
-- (1200, N'Remboursement de Frais Professionnels', '2025-02-18'),
-- (3000, N'Vente d’une Formation en Ligne', '2025-02-20');


-- -- 6 Insert data Expens
INSERT INTO Expense (montent, description, date) VALUES
(4500, N'Achat d’un Ordinateur Portable', '2025-02-03'),
(399, N'Facture Internet – Bureau', '2025-02-05'),
(120, N'Abonnement Outils et Logiciels', '2025-02-08'),
(950, N'Achat Chaise de Bureau Ergonomique', '2025-02-12'),
(220, N'Déplacement Professionnel – Taxi', '2025-02-17');
-- GO

SELECT * FROM Incomes;


CREATE TABLE Incomes

-- USE smart_wallet; 
-- GO

