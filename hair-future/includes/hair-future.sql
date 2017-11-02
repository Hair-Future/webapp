-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Nov 02, 2017 alle 15:00
-- Versione del server: 10.1.26-MariaDB
-- Versione PHP: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hair-future`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `appuntamento`
--

CREATE TABLE `appuntamento` (
  `codice` int(4) NOT NULL,
  `data` date NOT NULL,
  `ora` time NOT NULL,
  `durata` int(3) NOT NULL,
  `costo` float NOT NULL DEFAULT '0',
  `utente` varchar(25) NOT NULL,
  `listaServizi` varchar(100) NOT NULL,
  `effettuato` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `appuntamento`
--

INSERT INTO `appuntamento` (`codice`, `data`, `ora`, `durata`, `costo`, `utente`, `listaServizi`, `effettuato`) VALUES
(13, '2017-11-02', '09:00:00', 210, 60, 'prova1.example@gmx.com', '1|2|4', 0),
(14, '2017-11-02', '14:00:00', 90, 20, 'prova2.example@gmx.com', '1|2', 0),
(15, '2017-10-30', '09:00:00', 90, 20, 'prova2.example@gmx.com', '1|2', 1),
(16, '2017-10-27', '10:30:00', 90, 20, 'prova1.example@gmx.com', '1|2', 0),
(17, '2017-10-31', '09:00:00', 210, 90, 'prova2.example@gmx.com', '5|3', 1),
(18, '2017-10-29', '09:00:00', 300, 100, 'prova1.example@gmx.com', '1|2|4|5', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `nome` char(40) NOT NULL,
  `descrizione` char(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`nome`, `descrizione`) VALUES
('Colore', NULL),
('Piega', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `orarioapertura`
--

CREATE TABLE `orarioapertura` (
  `giorno` char(20) NOT NULL,
  `aperturaMattina` time DEFAULT '09:00:00',
  `chiusuraMattina` time DEFAULT '13:00:00',
  `aperturaPomeriggio` time DEFAULT '16:00:00',
  `chiusuraPomeriggio` time DEFAULT '19:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `orarioapertura`
--

INSERT INTO `orarioapertura` (`giorno`, `aperturaMattina`, `chiusuraMattina`, `aperturaPomeriggio`, `chiusuraPomeriggio`) VALUES
('Domenica', '09:00:00', '13:00:00', '16:00:00', '19:00:00'),
('Giovedì', '09:00:00', '13:00:00', '16:00:00', '19:00:00'),
('Lunedì', '09:00:00', '13:00:00', '15:00:00', '19:00:00'),
('Martedì', '09:00:00', '13:00:00', '16:00:00', '19:00:00'),
('Mercoledì', '09:00:00', '13:00:00', '16:00:00', '19:00:00'),
('Sabato', '09:00:00', '13:00:00', '16:00:00', '19:00:00'),
('Venerdì', '09:00:00', '13:00:00', '16:00:00', '19:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `servizio`
--

CREATE TABLE `servizio` (
  `codice` int(11) NOT NULL,
  `nome` char(20) NOT NULL,
  `descrizione` char(100) DEFAULT NULL,
  `prezzo` float NOT NULL DEFAULT '0',
  `durata` int(20) DEFAULT NULL,
  `categoria` char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `servizio`
--

INSERT INTO `servizio` (`codice`, `nome`, `descrizione`, `prezzo`, `durata`, `categoria`) VALUES
(1, 'Taglio', NULL, 15, 30, 'Piega'),
(2, 'Piega', NULL, 5, 60, 'Piega'),
(3, 'Tinta Rossa', NULL, 50, 120, 'Colore'),
(4, 'Tinta Nera', NULL, 40, 120, 'Colore'),
(5, 'Decolorazione', NULL, 40, 90, 'Colore');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `nome` varchar(20) NOT NULL,
  `cognome` varchar(20) NOT NULL,
  `recapito` varchar(10) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(20) NOT NULL,
  `tipo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`nome`, `cognome`, `recapito`, `email`, `password`, `tipo`) VALUES
('Maria', 'Rossi', '3009002211', 'prova1.example@gmx.com', 'pappapero1', 'Cliente'),
('Concetta', 'Florenzi', '3004402233', 'prova2.example@gmx.com', 'pappapero2', 'Cliente');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `appuntamento`
--
ALTER TABLE `appuntamento`
  ADD PRIMARY KEY (`codice`),
  ADD KEY `utente_key` (`utente`);

--
-- Indici per le tabelle `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`nome`);

--
-- Indici per le tabelle `orarioapertura`
--
ALTER TABLE `orarioapertura`
  ADD PRIMARY KEY (`giorno`);

--
-- Indici per le tabelle `servizio`
--
ALTER TABLE `servizio`
  ADD PRIMARY KEY (`codice`),
  ADD UNIQUE KEY `nome_prezzo_unique` (`nome`,`prezzo`),
  ADD KEY `categoria` (`categoria`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `appuntamento`
--
ALTER TABLE `appuntamento`
  MODIFY `codice` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT per la tabella `servizio`
--
ALTER TABLE `servizio`
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `appuntamento`
--
ALTER TABLE `appuntamento`
  ADD CONSTRAINT `utente` FOREIGN KEY (`utente`) REFERENCES `utente` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `servizio`
--
ALTER TABLE `servizio`
  ADD CONSTRAINT `categoria` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`nome`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
