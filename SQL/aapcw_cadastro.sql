-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 19, 2025 at 02:16 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

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
-- Table structure for table `assinaturas`
--

DROP TABLE IF EXISTS `assinaturas`;
CREATE TABLE IF NOT EXISTS `assinaturas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `aluno_id` int NOT NULL,
  `plano_id` int NOT NULL,
  `data_assinatura` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_expiracao` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aluno_id` (`aluno_id`),
  KEY `fk_plano_id` (`plano_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `aulas`
--

DROP TABLE IF EXISTS `aulas`;
CREATE TABLE IF NOT EXISTS `aulas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `curso_id` int DEFAULT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `conteudo` text COLLATE utf8mb4_general_ci,
  `video_url` text COLLATE utf8mb4_general_ci,
  `criado_em` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `curso_id` (`curso_id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `avaliacoes`
--

DROP TABLE IF EXISTS `avaliacoes`;
CREATE TABLE IF NOT EXISTS `avaliacoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `curso_id` int NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_general_ci,
  `tipo` enum('Prova','Atividade') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `criado_por_id` int NOT NULL,
  `tipo_criador` enum('administrador','professor') COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `curso_id` (`curso_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `cursos`
--

DROP TABLE IF EXISTS `cursos`;
CREATE TABLE IF NOT EXISTS `cursos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `categoria` enum('Marketing de Afiliados','Marketing de Conteúdo','E-mail Marketing','Social Media','Análise de Marketing','SEO','Tráfego Pago') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_general_ci NOT NULL,
  `imagem` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dificuldade` enum('iniciante','intermediario','avancado') COLLATE utf8mb4_general_ci NOT NULL,
  `criado_por_id` int NOT NULL,
  `tipo_criador` enum('administrador','professor') COLLATE utf8mb4_general_ci NOT NULL,
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `cursos_concluidos`
--

DROP TABLE IF EXISTS `cursos_concluidos`;
CREATE TABLE IF NOT EXISTS `cursos_concluidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `aluno_id` int NOT NULL,
  `curso_id` int NOT NULL,
  `data_conclusao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aluno_curso_unico` (`aluno_id`,`curso_id`),
  KEY `curso_id` (`curso_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

DROP TABLE IF EXISTS `feedbacks`;
CREATE TABLE IF NOT EXISTS `feedbacks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `aluno_id` int NOT NULL,
  `curso_id` int NOT NULL,
  `comentario` text COLLATE utf8mb4_general_ci NOT NULL,
  `data_envio` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `aluno_id` (`aluno_id`),
  KEY `curso_id` (`curso_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `formularios`
--

DROP TABLE IF EXISTS `formularios`;
CREATE TABLE IF NOT EXISTS `formularios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `nome` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `experiencia` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `avaliacao_experiencia` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `navegacao` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `qualidade` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `atendimento` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipo_curso` text COLLATE utf8mb4_general_ci,
  `outro_tipo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tema_especifico` text COLLATE utf8mb4_general_ci,
  `motivacoes` text COLLATE utf8mb4_general_ci,
  `outra_motivacao` text COLLATE utf8mb4_general_ci,
  `recursos` text COLLATE utf8mb4_general_ci,
  `outro_recurso` text COLLATE utf8mb4_general_ci,
  `sugestoes` text COLLATE utf8mb4_general_ci,
  `comentarios` text COLLATE utf8mb4_general_ci,
  `atualizacoes` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contato` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_envio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inscricoes`
--

DROP TABLE IF EXISTS `inscricoes`;
CREATE TABLE IF NOT EXISTS `inscricoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `aluno_id` int NOT NULL,
  `curso_id` int NOT NULL,
  `data_inscricao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aluno_id` (`aluno_id`,`curso_id`),
  KEY `curso_id` (`curso_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pagamentos`
--

DROP TABLE IF EXISTS `pagamentos`;
CREATE TABLE IF NOT EXISTS `pagamentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `aluno_id` int DEFAULT NULL,
  `plano_id` int DEFAULT NULL,
  `nome` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `celular` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cpf` varchar(14) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `forma_pagamento` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_pagamento` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `plano_id` (`plano_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `planos`
--

DROP TABLE IF EXISTS `planos`;
CREATE TABLE IF NOT EXISTS `planos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_general_ci,
  `preco` decimal(10,2) NOT NULL,
  `beneficios` text COLLATE utf8mb4_general_ci,
  `data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `ativo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `professores_voluntarios`
--

DROP TABLE IF EXISTS `professores_voluntarios`;
CREATE TABLE IF NOT EXISTS `professores_voluntarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `cpf` varchar(14) COLLATE utf8mb4_general_ci NOT NULL,
  `rg` varchar(12) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_nascimento` date NOT NULL,
  `endereco` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `telefone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `experiencia` text COLLATE utf8mb4_general_ci NOT NULL,
  `area_conhecimento` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `disponibilidade` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `curriculo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_inscricao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `progresso_aula`
--

DROP TABLE IF EXISTS `progresso_aula`;
CREATE TABLE IF NOT EXISTS `progresso_aula` (
  `id` int NOT NULL AUTO_INCREMENT,
  `aluno_id` int NOT NULL,
  `aula_id` int NOT NULL,
  `concluida` tinyint(1) DEFAULT '0',
  `data_conclusao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `aluno_id` (`aluno_id`,`aula_id`),
  KEY `aula_id` (`aula_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `questoes`
--

DROP TABLE IF EXISTS `questoes`;
CREATE TABLE IF NOT EXISTS `questoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `avaliacao_id` int NOT NULL,
  `enunciado` text COLLATE utf8mb4_general_ci NOT NULL,
  `tipo` enum('multipla_escolha','dissertativa') COLLATE utf8mb4_general_ci NOT NULL,
  `alternativas` json DEFAULT NULL,
  `resposta_correta` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`),
  KEY `avaliacao_id` (`avaliacao_id`)
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `respostas_alunos`
--

DROP TABLE IF EXISTS `respostas_alunos`;
CREATE TABLE IF NOT EXISTS `respostas_alunos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `avaliacao_id` int NOT NULL,
  `aluno_id` int NOT NULL,
  `resposta` text COLLATE utf8mb4_general_ci,
  `nota` decimal(5,2) DEFAULT NULL,
  `data_envio` datetime DEFAULT CURRENT_TIMESTAMP,
  `tentativa` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `avaliacao_id` (`avaliacao_id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `respostas_tickets`
--

DROP TABLE IF EXISTS `respostas_tickets`;
CREATE TABLE IF NOT EXISTS `respostas_tickets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ticket_id` int NOT NULL,
  `resposta` text COLLATE utf8mb4_general_ci NOT NULL,
  `data_resposta` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ticket_id` (`ticket_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `assunto` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `mensagem` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Aberto','Em andamento','Fechado') COLLATE utf8mb4_general_ci DEFAULT 'Aberto',
  `data_criacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `senha` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '/AAP-5_3306/funcoes/uploads/profile/default_profile.jpg',
  `data_nascimento` date DEFAULT NULL,
  `tipo` enum('aluno','professor','administrador') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'aluno',
  `status` enum('ativo','pendente','bloqueado') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'ativo',
  `reset_token_hash` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `aceitou_termos` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `usuario` (`usuario`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--


INSERT INTO `usuarios` (`id`, `nome`, `usuario`, `email`, `senha`, `photo`, `data_nascimento`, `tipo`, `status`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(52, 'CW Cursos ADM', 'CW ADM', 'cwcursos21@gmail.com', '$2y$10$aTBYlTKcgTw0H4KrCXk1Luw..gi9Im1GNiJXD7uAwRb24H4S8NRBy', '/AAP-5_3306/funcoes/uploads/profile/default_profile.jpg	', '2007-07-17', 'administrador', 'ativo', NULL, NULL),
(53, 'CW Cursos Professor', 'cwcursos21863', 'cwcursos21863@cwprof.com', '$2y$10$B2GdRtTo7dX.rB17Gr3BhelTcKl45HJJvU19cj6DOPFaE6MoLtvxK', '/AAP-5_3306/funcoes/uploads/profile/default_profile.jpg	', '2007-07-17', 'professor', 'ativo', NULL, NULL);

--
-- Constraints for dumped tables
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
