CREATE TABLE `pessoapet` (
  `PessoaPetID` int(11) NOT NULL,
  `PessoaID` int(11) NOT NULL,
  `PetID` int(11) NOT NULL,
  `Excluido` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `pessoas` (
  `PessoaID` int(11) NOT NULL,
  `Nome` varchar(200) DEFAULT NULL,
  `Cidade` varchar(180) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `DataNascimento` date DEFAULT NULL,
  `Whatsapp` varchar(100) DEFAULT NULL,
  `Senha` varchar(100) NOT NULL,
  `Excluido` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `pets` (
  `PetID` int(11) NOT NULL,
  `Identificacao` varchar(150) DEFAULT NULL,
  `Nome` varchar(200) DEFAULT NULL,
  `Peso` int(3) DEFAULT NULL,
  `DataNascimento` date DEFAULT NULL,
  `Especie` VARCHAR(50) NOT NULL,
  `Alergias` longtext DEFAULT NULL,
  `Vacinas` longtext DEFAULT NULL,
  `Foto` varchar(255) DEFAULT NULL,
  `Excluido` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices de tabela `pessoapet`
--
ALTER TABLE `pessoapet`
  ADD PRIMARY KEY (`PessoaPetID`),
  ADD KEY `pessoa` (`PessoaID`),
  ADD KEY `pet` (`PetID`);

--
-- Índices de tabela `pessoas`
--
ALTER TABLE `pessoas`
  ADD PRIMARY KEY (`PessoaID`);

--
-- Índices de tabela `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`PetID`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `pessoapet`
--
ALTER TABLE `pessoapet`
  MODIFY `PessoaPetID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pessoas`
--
ALTER TABLE `pessoas`
  MODIFY `PessoaID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pets`
--
ALTER TABLE `pets`
  MODIFY `PetID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas `pessoapet`
--
ALTER TABLE `pessoapet`
  ADD CONSTRAINT `pessoa` FOREIGN KEY (`PessoaID`) REFERENCES `pessoas` (`PessoaID`),
  ADD CONSTRAINT `pet` FOREIGN KEY (`PetID`) REFERENCES `pets` (`PetID`);
COMMIT;
