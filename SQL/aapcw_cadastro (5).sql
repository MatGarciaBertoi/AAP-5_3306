-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2024 at 07:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aapcw_cadastro`
--

-- --------------------------------------------------------

--
-- Table structure for table `administradores`
--

CREATE TABLE `administradores` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `confsenha` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administradores`
--

INSERT INTO `administradores` (`id`, `nome`, `usuario`, `email`, `senha`, `confsenha`, `data_nascimento`) VALUES
(1, 'Jonathas Yoshioka', 'Jonathas01', 'jonathasolsen@gmail.com', '$2y$10$HyeDs8DfvDdV3pWesgccoO4d2p6exrxAOogZxWl8gtfF/DV/gWH/2', '', '2005-12-09');

-- --------------------------------------------------------

--
-- Table structure for table `certificados`
--

CREATE TABLE `certificados` (
  `id` int(11) NOT NULL,
  `curso_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `data_assinatura` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `nome_curso` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `duracao` int(11) DEFAULT NULL,
  `status` enum('pendente','aprovado','reprovado') DEFAULT 'pendente',
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `imagem` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cursos`
--

INSERT INTO `cursos` (`id`, `nome_curso`, `descricao`, `duracao`, `status`, `data_criacao`, `imagem`, `video_url`) VALUES
(1, 'Curso de SEO', 'Aprenda as melhores práticas de SEO para otimizar sites.', 1, 'aprovado', '2024-09-27 16:21:50', 'seoavançado.png', 'TtuloSEO.mp4'),
(2, 'Curso de Marketing de Conteúdo', 'Curso sobre como criar e distribuir conteúdo que engaja.', 1, 'aprovado', '2024-09-27 16:21:50', 'Marketingdeconteudo_curso.png', 'https://www.youtube.com/watch?v=Marketing1'),
(3, 'Curso de Mídias Sociais', 'Domine as estratégias para gerenciar redes sociais.', 1, 'aprovado', '2024-09-27 16:21:50', 'cursodeMidiasDigitais_curso.png', 'https://www.youtube.com/watch?v=Midias1'),
(4, 'Curso de Introdução ao MKT', 'Conceitos básicos de marketing para iniciantes.', 1, 'aprovado', '2024-09-27 16:21:50', 'intmktdigital.png', 'https://www.youtube.com/watch?v=MKT1'),
(5, 'Curso de Redes Sociais', 'Curso avançado para uso prático das redes.', 1, 'aprovado', '2024-09-27 16:21:50', 'mktemredessociasi.png', 'https://www.youtube.com/watch?v=Redes1');

-- --------------------------------------------------------

--
-- Table structure for table `fotos_perfil`
--

CREATE TABLE `fotos_perfil` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `caminho_foto` varchar(255) NOT NULL,
  `data_upload` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `professores`
--

CREATE TABLE `professores` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `confsenha` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `professores_voluntarios`
--

CREATE TABLE `professores_voluntarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `rg` varchar(12) DEFAULT NULL,
  `data_nascimento` date NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `experiencia` text NOT NULL,
  `area_conhecimento` varchar(255) NOT NULL,
  `disponibilidade` varchar(50) DEFAULT NULL,
  `curriculo` varchar(255) DEFAULT NULL,
  `data_inscricao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professores_voluntarios`
--

INSERT INTO `professores_voluntarios` (`id`, `nome`, `cpf`, `rg`, `data_nascimento`, `endereco`, `email`, `telefone`, `linkedin`, `experiencia`, `area_conhecimento`, `disponibilidade`, `curriculo`, `data_inscricao`) VALUES
(1, 'Matheus Garcia Bertoi', '46193010866', '501183620', '2005-05-16', 'Rua Werner Goldberg 157', 'matheusbertoi09@gmail.com', '11 988533778', 'https://www.linkedin.com/in/matheus-garcia-bertoi-70052128a/', '0', '0', '0', 'uploads/curriculos/MatheusGBertoi_RelatorioIndividua.pdf', '2024-10-31 19:02:28'),
(2, 'Fernando Gonsales Garcia', '41274892734', '340270431', '2005-05-16', 'Rua Werner Goldberg 157', 'fafa@gmail.com', '11 988533778', 'https://www.linkedin.com/in/matheus-garcia-bertoi-70052128a/', '0', '0', '0', 'uploads/curriculos/RelatorioIndividual_MatheusGBertoi01.pdf', '2024-10-31 19:09:20'),
(3, 'Almeida Junior', '32332323233', '252345454', '2005-05-16', 'Rua Werner Goldberg 157', 'almeidinha@gmail.com', '11 988533778', 'https://www.linkedin.com/in/matheus-garcia-bertoi-70052128a/', '3 anos na área.', 'SEO avançado', '40', 'uploads/curriculos/Calendario-Academico-2o-semestre-de-2024.pdf', '2024-11-02 00:28:22');

-- --------------------------------------------------------

--
-- Table structure for table `suporte`
--

CREATE TABLE `suporte` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `mensagem` text DEFAULT NULL,
  `status` enum('pendente','respondida','resolvida') DEFAULT 'pendente',
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(110) DEFAULT NULL,
  `confsenha` varchar(110) DEFAULT NULL,
  `photo` varchar(255) DEFAULT 'images/default_profile.jpg',
  `data_nascimento` date DEFAULT NULL,
  `tipo` enum('aluno','professor','administrador') NOT NULL DEFAULT 'aluno',
  `status` enum('ativo','pendente','bloqueado') NOT NULL DEFAULT 'ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `usuario`, `email`, `senha`, `confsenha`, `photo`, `data_nascimento`, `tipo`, `status`) VALUES
(1, 'Matheus Garcia Bertoi adm', 'MatheusADM', 'matheusbertoi@cwadm.com', '123456', '123456', 'images/default_profile.jpg', '2005-05-16', 'administrador', 'ativo'),
(7, 'Cristiane Garcia Bertoi', 'Cristiane01', 'cris09@cwprof.com', '123456', '123456', 'images/default_profile.jpg', '1978-08-21', 'professor', 'ativo'),
(18, 'Matheus Garcia Bertoi', 'MatGa', 'matheusbertoi09@gmail.com', '$2y$10$v134Ad5R8d24L9WLiwD7S.c5ODjz9loa3sezWZD5ImxBV4/anGldC', '123456', 'uploads/imgcapaexemplo.jpg', NULL, 'aluno', 'ativo'),
(19, 'Jonathas Yoshioka', 'Jonathas01', 'jonathasolsen@gmail.com', '$2y$10$pG/2knsNJEA8XxUIRwzQC.M0FzI0M3RF6yWAdX59P9q3PvHC8gZ/.', '123456', 'uploads/membrojonathans.jpeg', NULL, 'aluno', 'ativo'),
(33, 'Jonathas Yoshioka Olsen', 'Jonathas Adm', 'jonathasyoshioka@cwadm.com', '$2y$10$s9O3nCZBIyAipGonWsRzeOiO8eGAmfLCIjCuH1QpVyD.NwtRX8KQK', NULL, 'images/default_profile.jpg', '2005-06-01', 'administrador', 'ativo'),
(34, 'João Almeida Junior', 'Junior01', 'joaojunior01@gmail.com', '$2y$10$XbI3yIX2GhSPNbxBJz2qAOgU.obHScrPAl2dU3YQum132cBR.s4n6', '123456', 'uploads/1707685002137.jpeg', '2005-05-16', 'aluno', 'ativo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificados`
--
ALTER TABLE `certificados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curso_id` (`curso_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fotos_perfil`
--
ALTER TABLE `fotos_perfil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `professores`
--
ALTER TABLE `professores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `professores_voluntarios`
--
ALTER TABLE `professores_voluntarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suporte`
--
ALTER TABLE `suporte`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`nome`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `certificados`
--
ALTER TABLE `certificados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `fotos_perfil`
--
ALTER TABLE `fotos_perfil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `professores`
--
ALTER TABLE `professores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `professores_voluntarios`
--
ALTER TABLE `professores_voluntarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `suporte`
--
ALTER TABLE `suporte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `certificados`
--
ALTER TABLE `certificados`
  ADD CONSTRAINT `certificados_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificados_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fotos_perfil`
--
ALTER TABLE `fotos_perfil`
  ADD CONSTRAINT `fotos_perfil_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `suporte`
--
ALTER TABLE `suporte`
  ADD CONSTRAINT `suporte_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
