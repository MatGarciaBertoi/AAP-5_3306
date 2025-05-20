-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 20, 2025 at 01:09 AM
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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aulas`
--

INSERT INTO `aulas` (`id`, `curso_id`, `titulo`, `conteudo`, `video_url`, `criado_em`) VALUES
(29, 6, 'Fundamentos de SEO', 'O que é SEO e por que ele é importante?', 'https://www.youtube.com/watch?v=pIbQfOcsEsE&t=6s', '2025-05-18 22:18:57'),
(30, 6, 'Palavras-Chave e Intenção de Busca', 'Como fazer pesquisa de palavras-chave.', 'https://www.youtube.com/watch?v=U655ixy-sdE', '2025-05-18 22:18:57'),
(31, 6, 'SEO On-page', 'Otimize seu conteúdo para os mecanismos de busca.', 'https://www.youtube.com/watch?v=k04rHijEPSw&list=PLJR61fXkAx11Oi6EpqJ9Es4rVOIZhwlSG&index=7', '2025-05-18 22:18:57'),
(46, 36, 'Finalizando Conceitos e Aplicando o Marketing Digital!', 'Vamos aplicar todas as estratégias de marketing e suas análises!', 'https://www.youtube.com/watch?v=mKr2efYjFNs&t=3s', '2025-05-19 14:23:19'),
(45, 36, 'Marketing Dígital e sua essência!', 'Demonstrando a essencia do marketing digital!', 'https://www.youtube.com/watch?v=B9bFw3pQh4M&t=1s', '2025-05-19 14:22:31'),
(44, 36, 'Introduzindo o Marketing Dígital!', 'O vídeo traz os fundamentos necessários para iniciar o marketing digital!', 'https://www.youtube.com/watch?v=5gU1V5S7eFE&t=2s', '2025-05-19 14:06:28');

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
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `avaliacoes`
--

INSERT INTO `avaliacoes` (`id`, `curso_id`, `titulo`, `descricao`, `tipo`, `data_criacao`, `criado_por_id`, `tipo_criador`) VALUES
(10, 10, 'Prova Final - Planejamento de Conteúdo', 'Avaliação sobre estratégia e planejamento de conteúdo.', 'Prova', '2025-05-18 21:28:17', 53, 'professor'),
(9, 9, 'Prova Final - Tráfego Social', 'Questões sobre tráfego pago nas redes.', 'Prova', '2025-05-18 21:28:17', 53, 'professor'),
(7, 7, 'Prova Final - SEO Avançado', 'Questões técnicas e estratégicas de SEO.', 'Prova', '2025-05-18 21:28:17', 53, 'professor'),
(8, 8, 'Prova Final - Google Ads', 'Avaliação sobre campanhas no Google Ads.', 'Prova', '2025-05-18 21:28:17', 53, 'professor'),
(6, 6, 'Prova Final - SEO Iniciante', 'Prova básica sobre fundamentos de SEO.', 'Prova', '2025-05-18 21:28:17', 53, 'professor'),
(4, 4, 'Prova Final - Social Media', 'Teste final sobre gestão de redes sociais.', 'Prova', '2025-05-18 21:28:17', 53, 'professor'),
(5, 5, 'Prova Final - Análise de Marketing', 'Questões sobre interpretação de dados e métricas.', 'Prova', '2025-05-18 21:28:17', 53, 'professor'),
(3, 3, 'Prova Final - E-mail Marketing', 'Questões sobre automação e estratégias de e-mail.', 'Prova', '2025-05-18 21:28:17', 53, 'professor'),
(1, 1, 'Prova Final - Marketing de Afiliados', 'Teste seus conhecimentos sobre marketing de afiliados.', 'Prova', '2025-05-18 21:28:17', 53, 'professor'),
(2, 2, 'Prova Final - Conteúdo para Redes', 'Avaliação sobre marketing de conteúdo para redes sociais.', 'Prova', '2025-05-18 21:28:17', 53, 'professor'),
(36, 6, 'SEO Atividade 1', 'Iniciando sua primeira atividade de SEO!', 'Atividade', '2025-05-19 10:30:37', 53, 'professor'),
(37, 36, 'Atividade 1', 'Aqui você você vai descrever conceitos essenciais do marketing digital!', 'Atividade', '2025-05-19 14:08:31', 53, 'professor'),
(39, 36, 'Prova Final', 'Demonstre todo seu conhecimento aprendido no curso!', 'Prova', '2025-05-19 14:13:47', 53, 'professor');

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
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cursos`
--

INSERT INTO `cursos` (`id`, `nome`, `categoria`, `descricao`, `imagem`, `dificuldade`, `criado_por_id`, `tipo_criador`, `data_criacao`) VALUES
(6, 'SEO Essencial: Otimização para Iniciantes', 'SEO', 'Melhore o posicionamento de sites no Google com técnicas básicas de SEO.', 'funcoes/uploads/cursos/default_image.png', 'iniciante', 53, 'professor', '2025-05-18 21:34:27'),
(8, 'Tráfego Pago com Google Ads', 'Tráfego Pago', 'Aprenda a criar campanhas no Google Ads com foco em resultados reais.', 'funcoes/uploads/cursos/default_image.png', 'intermediario', 53, 'professor', '2025-05-18 21:34:27'),
(7, 'SEO Técnico e Estratégias Avançadas', 'SEO', 'Explore aspectos técnicos e estratégias profundas para dominar o SEO.', 'funcoes/uploads/cursos/default_image.png', 'avancado', 53, 'professor', '2025-05-18 21:34:27'),
(5, 'Introdução à Análise de Marketing', 'Análise de Marketing', 'Aprenda a coletar e interpretar dados para otimizar suas campanhas de marketing.', 'funcoes/uploads/cursos/default_image.png', 'iniciante', 53, 'professor', '2025-05-18 21:34:27'),
(4, 'Gestão de Mídias Sociais na Prática', 'Social Media', 'Domine as principais ferramentas e estratégias para gerenciar redes sociais profissionalmente.', 'funcoes/uploads/cursos/default_image.png', 'intermediario', 53, 'professor', '2025-05-18 21:34:27'),
(3, 'Automação de E-mails com Estratégia', 'E-mail Marketing', 'Desenvolva campanhas de e-mail eficazes com foco em automação e conversão.', 'funcoes/uploads/cursos/default_image.png', 'avancado', 53, 'professor', '2025-05-18 21:34:27'),
(2, 'Marketing de Conteúdo para Redes Sociais', 'Marketing de Conteúdo', 'Crie conteúdos engajadores para aumentar sua presença online nas redes sociais.', 'funcoes/uploads/cursos/default_image.png', 'intermediario', 53, 'professor', '2025-05-18 21:34:27'),
(1, 'Introdução ao Marketing de Afiliados', 'Marketing de Afiliados', 'Aprenda os fundamentos do marketing de afiliados e como gerar renda promovendo produtos de terceiros.', 'funcoes/uploads/cursos/default_image.png', 'iniciante', 53, 'professor', '2025-05-18 21:34:27'),
(9, 'Tráfego Pago para Redes Sociais', 'Tráfego Pago', 'Impulsione suas campanhas nas redes sociais com estratégias de tráfego pago.', 'funcoes/uploads/cursos/default_image.png', 'iniciante', 53, 'professor', '2025-05-18 21:34:27'),
(10, 'Planejamento de Conteúdo Estratégico', 'Marketing de Conteúdo', 'Elabore um calendário de conteúdo com base em dados e objetivos de marketing.', 'funcoes/uploads/cursos/default_image.png', 'intermediario', 53, 'professor', '2025-05-18 21:34:27'),
(36, 'Introdução ao Marketing Dígital', 'Análise de Marketing', 'O aluno irá aprender os principais conceitos básicos do marketing dígital!', 'funcoes/uploads/cursos/curso_682b6451e3356.jpg', 'iniciante', 53, 'professor', '2025-05-19 14:03:13');

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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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

--
-- Dumping data for table `planos`
--

INSERT INTO `planos` (`id`, `nome`, `descricao`, `preco`, `beneficios`, `data_criacao`, `ativo`) VALUES
(1, 'Essencial', 'Ideal para quem quer acesso completo aos nossos cursos.', 20.00, 'Acesso ilimitado a todos os cursos\nMaterial de apoio\nCertificados digitais', '2025-05-18 15:06:39', 1),
(2, 'Profissional', 'Para quem busca suporte e aprendizado contínuo.', 30.00, 'Todos os benefícios do Essencial +\nWebinars exclusivos\nSuporte prioritário', '2025-05-18 15:06:39', 1),
(3, 'Empreendedor', 'Para quem quer escalar seus resultados com acompanhamento especial.', 40.00, 'Todos os benefícios do Profissional +\nMentorias ao vivo\nConsultoria personalizada\nAcesso antecipado a novos cursos', '2025-05-18 15:06:39', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questoes`
--

INSERT INTO `questoes` (`id`, `avaliacao_id`, `enunciado`, `tipo`, `alternativas`, `resposta_correta`) VALUES
(69, 6, 'Qual é o principal objetivo do SEO em marketing digital?', 'multipla_escolha', '{\"A\": \"Aumentar os gastos com anúncios pagos\", \"B\": \"Melhorar o posicionamento de um site nos resultados orgânicos de busca\", \"C\": \"Criar conteúdo apenas para redes sociais\", \"D\": \"Reduzir o número de visitas ao site\"}', 'C'),
(80, 39, 'Quem é Kotler?', 'multipla_escolha', '[\"Um genio do marketing\", \"Um genio da tecnologia\", \"Um apresentador de televisão\", \"Um motorista de avião\"]', 'A'),
(81, 39, 'O que é o Marketing Dígital?', 'multipla_escolha', '[\"É o marketing das ruas\", \"É o marketing da internet\", \"É o marketing de mercado\", \"É o marketing das danças\"]', 'B'),
(82, 39, 'Quais principais tipos de marketing dígital?', 'multipla_escolha', '[\"Lebron James, Stephen Curry\", \"Leg Press, Supino Barra\", \"Chris Bumstead, CBUM\", \"SEO, Social Media\"]', 'D'),
(83, 39, 'Qual a importancia do Marketing?', 'multipla_escolha', '[\"Para impressionar as pessoas!\", \"Para ir bem nas provas da escola!\", \"Para alavancar seu negócio!\", \"Para ser um jogador de Roblox!\"]', 'C'),
(79, 39, 'O que é o Marketing?', 'multipla_escolha', '[\"Marketing é Marketing!\", \"Marketing é Comida!\", \"Marketing é um Jogo!\", \"Marketing é Futebol!\"]', 'A'),
(78, 37, 'Descreve como os conceitos de Kotler foram propostos no vídeo.', 'dissertativa', NULL, 'Kotler e VLANs: Uma Analogia Educacional\r\n1. Segmentação de Mercado (Kotler) = Segmentação de Rede (VLANs)\r\nKotler ensina que, para atingir melhor o público-alvo, as empresas devem segmentar o mercado com base em características como idade, localização, interesses etc.\r\n➡️ Analogia: Em redes, VLANs segmentam a rede física em redes lógicas separadas, agrupando dispositivos com características ou funções similares (ex: setor financeiro, RH, TI), mesmo que estejam fisicamente em locais diferentes.\r\n\r\n2. Posicionamento (Kotler) = Isolamento e Organização (VLANs)\r\nNo marketing, posicionar uma marca significa dar a ela um lugar claro e diferenciado na mente do consumidor.\r\n➡️ Analogia: As VLANs ajudam a posicionar e organizar dispositivos na rede, isolando grupos de acordo com sua função, evitando confusão, congestionamento ou interferência (como o marketing evita a “confusão” entre marcas no mercado).\r\n\r\n3. Mix de Marketing (4 Ps) = Políticas e Estratégias de Rede\r\nKotler propõe o uso dos 4 Ps (Produto, Preço, Praça, Promoção) para alcançar o mercado de forma eficiente.\r\n➡️ Analogia: Na criação de VLANs, usamos estratégias e políticas específicas para controlar como os dados circulam, otimizando o desempenho e a segurança, da mesma forma que os 4 Ps otimizam a venda de um produto.'),
(70, 6, 'O que significa a sigla “SERP” no contexto de SEO?', 'multipla_escolha', '{\"A\": \"Search Engine Ranking Page\", \"B\": \"Social Engagement Response Page\", \"C\": \"Search Engine Results Page\", \"D\": \"Search External Ranking Protocol\"}', 'C'),
(71, 6, 'Qual dos fatores abaixo é considerado fator de ranqueamento “on-page”?', 'multipla_escolha', '{\"A\": \"Número de backlinks\", \"B\": \"Autoridade do domínio\", \"C\": \"Tempo de carregamento da página\", \"D\": \"Uso correto de palavras-chave no título\"}', 'C'),
(72, 6, 'O que é um backlink?', 'multipla_escolha', '[\"Um tipo de anúncio pago no Google\", \"Um link de um site para outro\", \"Uma tag de HTML para descrever imagens\", \"Um código para redirecionamento interno\"]', 'B'),
(73, 6, 'Qual é o impacto de um site não responsivo no SEO?', 'multipla_escolha', '[\"Nenhum impacto, desde que o conteúdo seja bom\", \"Pode melhorar o ranqueamento em dispositivos móveis\", \"Pode prejudicar o ranqueamento, especialmente em buscas mobile\", \"Aumenta automaticamente os backlinks\"]', 'C'),
(74, 6, 'O que é “palavra-chave de cauda longa” (long tail keyword)?', 'multipla_escolha', '[\"Palavra-chave curta e genérica\", \"Palavra-chave com erro de ortografia\", \"Frase mais específica e detalhada, com menor volume de busca\", \"Palavra-chave usada somente em imagens\"]', 'C'),
(75, 6, 'Qual ferramenta abaixo é mais comumente usada para acompanhar o tráfego orgânico de um site?', 'multipla_escolha', '[\"Canva\", \"Google Analytics\", \"Mailchimp\", \"Hootsuite\"]', 'B');

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
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `cpf` varchar(14) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rg` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `endereco` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `experiencia` text COLLATE utf8mb4_general_ci,
  `area_conhecimento` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `disponibilidade` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `token_ativacao` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `usuario` (`usuario`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `usuario`, `email`, `senha`, `photo`, `data_nascimento`, `tipo`, `status`, `reset_token_hash`, `reset_token_expires_at`, `aceitou_termos`, `cpf`, `rg`, `endereco`, `telefone`, `linkedin`, `experiencia`, `area_conhecimento`, `disponibilidade`, `token_ativacao`) VALUES
(52, 'CW Cursos ADM', 'CW ADM', 'suportecwcursos@gmail.com', '$2y$10$aTBYlTKcgTw0H4KrCXk1Luw..gi9Im1GNiJXD7uAwRb24H4S8NRBy', '/AAP-5_3306/funcoes/uploads/profile/default_profile.jpg	', '2007-07-17', 'administrador', 'ativo', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 'Garcia Conceição Yoshioka Zanata', 'cwcursosprof', 'cwcursos21863@cwprof.com', '$2y$10$B2GdRtTo7dX.rB17Gr3BhelTcKl45HJJvU19cj6DOPFaE6MoLtvxK', '/AAP-5_3306/funcoes/uploads/profile/default_profile.jpg	', '2007-07-17', 'professor', 'ativo', NULL, NULL, 0, '79602764201', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
