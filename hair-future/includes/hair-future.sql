-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Nov 11, 2017 alle 17:31
-- Versione del server: 10.1.25-MariaDB
-- Versione PHP: 5.6.31

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
-- Struttura della tabella `Appuntamento`
--

CREATE TABLE `Appuntamento` (
  `codice` int(4) NOT NULL,
  `data` date NOT NULL,
  `ora` time NOT NULL,
  `durata` int(3) NOT NULL,
  `costo` float NOT NULL DEFAULT '0',
  `utente` varchar(100) NOT NULL,
  `listaServizi` varchar(100) NOT NULL,
  `effettuato` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Struttura della tabella `Categoria`
--

CREATE TABLE `Categoria` (
  `nome` char(100) NOT NULL,
  `descrizione` char(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `OrarioApertura`
--

CREATE TABLE `OrarioApertura` (
  `giorno` char(100) NOT NULL,
  `aperturaMattina` time DEFAULT '09:00:00',
  `chiusuraMattina` time DEFAULT '13:00:00',
  `aperturaPomeriggio` time DEFAULT '16:00:00',
  `chiusuraPomeriggio` time DEFAULT '19:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `OrarioApertura`
--

INSERT INTO `OrarioApertura` (`giorno`, `aperturaMattina`, `chiusuraMattina`, `aperturaPomeriggio`, `chiusuraPomeriggio`) VALUES
  ('dom', '09:00:00', '13:00:00', '16:00:00', '19:00:00'),
  ('gio', '09:00:00', '13:00:00', '16:00:00', '19:00:00'),
  ('lun', '09:00:00', '13:00:00', '16:00:00', '19:00:00'),
  ('mar', '09:00:00', '13:00:00', '16:00:00', '19:00:00'),
  ('mer', '09:00:00', '13:00:00', '16:00:00', '19:00:00'),
  ('sab', '09:00:00', '13:00:00', '16:00:00', '19:00:00'),
  ('ven', '09:00:00', '13:00:00', '16:00:00', '19:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `Servizio`
--

CREATE TABLE `Servizio` (
  `codice` int(11) NOT NULL,
  `nome` char(100) NOT NULL,
  `descrizione` char(200) DEFAULT NULL,
  `prezzo` float NOT NULL DEFAULT '0',
  `durata` int(20) DEFAULT NULL,
  `categoria` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Struttura della tabella `Utente`
--

CREATE TABLE `Utente` (
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `recapito` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `tipo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `Appuntamento`
--
ALTER TABLE `Appuntamento`
  ADD PRIMARY KEY (`codice`),
  ADD KEY `utente_key` (`utente`);

--
-- Indici per le tabelle `Categoria`
--
ALTER TABLE `Categoria`
  ADD PRIMARY KEY (`nome`);

--
-- Indici per le tabelle `OrarioApertura`
--
ALTER TABLE `OrarioApertura`
  ADD PRIMARY KEY (`giorno`);

--
-- Indici per le tabelle `Servizio`
--
ALTER TABLE `Servizio`
  ADD PRIMARY KEY (`codice`),
  ADD UNIQUE KEY `nome_prezzo_unique` (`nome`,`prezzo`),
  ADD KEY `categoria` (`categoria`);

--
-- Indici per le tabelle `Utente`
--
ALTER TABLE `Utente`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `Appuntamento`
--
ALTER TABLE `Appuntamento`
  MODIFY `codice` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `Servizio`
--
ALTER TABLE `Servizio`
  MODIFY `codice` int(11) NOT NULL AUTO_INCREMENT;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `Appuntamento`
--
ALTER TABLE `Appuntamento`
  ADD CONSTRAINT `utente` FOREIGN KEY (`utente`) REFERENCES `Utente` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Servizio`
--
ALTER TABLE `Servizio`
  ADD CONSTRAINT `categoria` FOREIGN KEY (`categoria`) REFERENCES `Categoria` (`nome`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
