-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20/06/2024 às 22:23
-- Versão do servidor: 10.4.27-MariaDB
-- Versão do PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `filafacil`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `called_pass`
--

CREATE TABLE `called_pass` (
  `id` int(11) NOT NULL,
  `idpass` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `pc` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `called_pass`
--

INSERT INTO `called_pass` (`id`, `idpass`, `iduser`, `pc`, `createdAt`, `updatedAt`) VALUES
(55, 43, 1, 'servidorescola', '2024-05-22 14:45:09', '2024-05-22 14:45:09'),
(56, 44, 1, 'servidorescola', '2024-05-22 14:47:28', '2024-05-22 14:47:28'),
(57, 45, 3, 'servidorescola', '2024-05-22 14:48:58', '2024-05-22 14:48:58'),
(58, 46, 3, 'servidorescola', '2024-05-22 16:45:13', '2024-05-22 16:45:13'),
(59, 47, 3, 'servidorescola', '2024-05-22 16:45:33', '2024-05-22 16:45:33'),
(60, 48, 3, 'servidorescola', '2024-05-22 18:24:45', '2024-05-22 18:24:45'),
(61, 50, 1, 'servidorescola', '2024-05-23 10:11:35', '2024-05-23 10:11:35'),
(62, 51, 1, 'servidorouro', '2024-05-23 14:40:51', '2024-05-23 14:40:51');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cargos`
--

CREATE TABLE `cargos` (
  `id` int(11) NOT NULL,
  `cargo` varchar(100) NOT NULL,
  `salario` double NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cargos`
--

INSERT INTO `cargos` (`id`, `cargo`, `salario`, `createdAt`, `updatedAt`) VALUES
(1, 'Administrador', 7525, '2024-05-18 17:14:13', '2024-05-22 09:56:19'),
(3, 'Atendente', 1520, '2024-05-18 18:04:36', '2024-05-21 21:49:51'),
(4, 'Recepcionista', 1412, '2024-05-18 20:36:25', '2024-05-18 20:36:25'),
(5, 'Técnico bancário', 5200, '2024-05-18 21:29:39', '2024-05-21 21:53:34'),
(6, 'Estagiário', 900, '2024-05-18 21:33:35', '2024-05-18 21:44:46'),
(7, 'Cozinheiro', 2432, '2024-05-18 21:33:48', '2024-05-18 21:47:09'),
(8, 'Serviços gerais', 1810, '2024-05-18 21:47:35', '2024-05-18 21:47:43'),
(9, 'Contador', 1035, '2024-05-21 22:12:01', '2024-05-21 22:12:11');

-- --------------------------------------------------------

--
-- Estrutura para tabela `guiches`
--

CREATE TABLE `guiches` (
  `id` int(11) NOT NULL,
  `guiche` int(11) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `guiches`
--

INSERT INTO `guiches` (`id`, `guiche`, `createdAt`, `updatedAt`) VALUES
(1, 1, '2024-05-17 13:41:31', '2024-05-22 13:55:18'),
(2, 2, '2024-05-17 14:11:49', '2024-05-17 14:11:49'),
(3, 3, '2024-05-17 14:13:19', '2024-05-17 14:13:19'),
(4, 4, '2024-05-17 14:42:48', '2024-05-17 14:42:48'),
(5, 5, '2024-05-17 14:43:47', '2024-05-17 14:43:47'),
(6, 6, '2024-05-17 21:27:06', '2024-05-17 21:27:06'),
(7, 7, '2024-05-17 21:27:08', '2024-05-17 21:27:08'),
(8, 8, '2024-05-17 21:27:09', '2024-05-17 21:27:09'),
(9, 9, '2024-05-17 21:27:10', '2024-05-17 21:27:10'),
(10, 10, '2024-05-17 21:27:12', '2024-05-17 21:27:12'),
(11, 11, '2024-05-17 21:27:22', '2024-05-17 21:27:22'),
(12, 12, '2024-05-17 21:27:25', '2024-05-17 21:27:25'),
(13, 13, '2024-05-17 21:27:27', '2024-05-17 21:27:27'),
(14, 14, '2024-05-17 21:27:28', '2024-05-17 21:27:28'),
(15, 15, '2024-05-17 21:27:30', '2024-05-17 21:27:30'),
(16, 16, '2024-05-21 21:58:44', '2024-05-21 21:58:44'),
(17, 17, '2024-05-21 22:04:43', '2024-05-21 22:04:43');

-- --------------------------------------------------------

--
-- Estrutura para tabela `permissao_bloqueada`
--

CREATE TABLE `permissao_bloqueada` (
  `id` int(11) NOT NULL,
  `idcargo` int(11) NOT NULL,
  `idpermission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `permissao_bloqueada`
--

INSERT INTO `permissao_bloqueada` (`id`, `idcargo`, `idpermission`) VALUES
(104, 3, 3),
(105, 3, 4),
(106, 3, 5),
(107, 3, 6),
(108, 3, 7),
(109, 3, 8),
(110, 3, 9),
(111, 3, 10),
(112, 3, 11),
(113, 4, 3),
(114, 4, 4),
(115, 4, 5),
(116, 4, 7),
(117, 4, 8),
(118, 4, 9),
(119, 4, 10),
(120, 4, 11),
(121, 4, 12),
(132, 5, 3),
(133, 5, 4),
(134, 5, 5),
(135, 5, 6),
(136, 5, 7),
(137, 5, 8),
(138, 5, 9),
(139, 5, 10),
(140, 5, 11),
(141, 5, 12),
(142, 7, 3),
(143, 7, 4),
(144, 7, 5),
(145, 7, 6),
(146, 7, 7),
(147, 7, 8),
(148, 7, 9),
(149, 7, 10),
(150, 7, 11),
(151, 7, 12),
(152, 8, 3),
(153, 8, 4),
(154, 8, 5),
(155, 8, 6),
(156, 8, 7),
(157, 8, 8),
(158, 8, 9),
(159, 8, 10),
(160, 8, 11),
(161, 8, 12),
(162, 9, 4),
(163, 9, 5),
(164, 9, 6),
(165, 9, 8),
(166, 9, 9),
(167, 9, 10),
(168, 9, 11),
(169, 9, 12),
(170, 6, 3),
(171, 6, 4),
(172, 6, 5),
(173, 6, 6),
(174, 6, 7),
(175, 6, 8),
(176, 6, 9),
(177, 6, 10),
(178, 6, 11),
(179, 6, 12);

-- --------------------------------------------------------

--
-- Estrutura para tabela `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `permission_name` varchar(255) NOT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `permissions`
--

INSERT INTO `permissions` (`id`, `permission_name`, `surname`, `type`, `description`) VALUES
(3, 'admin/users/index', 'Lista de usuários', 'route', 'Dá acesso a página de visualização de usuários'),
(4, 'admin/users/create', 'Cadastro de usuários', 'route', 'Dá acesso a página de criação de usuários'),
(5, 'admin/users/store', 'Cadastrar usuário', 'route', 'Permite cadastrar um usuário'),
(6, 'admin/home/getNewPass', 'Gerar senha', 'route', 'Permite que o usuário gere uma senha para o cliente'),
(7, 'admin/cargos/index', 'Lista e cadastro de cargos', 'route', 'Permite acessar a página de visualização e cadastro de cargos'),
(8, 'admin/cargos/store', 'Cadastrar cargos', 'route', 'Permite cadastrar um novo cargo'),
(9, 'admin/guiches/index', 'Lista e cadastro de guichês', 'route', 'Permite acessar a página de visualização e cadastro de guichês'),
(10, 'admin/guiches/store', 'Cadastrar guichês', 'route', 'Permite cadastrar um novo guichê'),
(11, 'admin/configuracoes/index', 'Configurações do sistema', 'route', 'Permite visualizar a página de configurações do sistema'),
(12, 'admin/home/callNewPass', 'Chamar nova senha', 'route', 'Permite que o usuário chame uma nova senha caso alguma a ser chamada.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `previous_generated_pass`
--

CREATE TABLE `previous_generated_pass` (
  `id` int(11) NOT NULL,
  `pass_generated` varchar(7) NOT NULL,
  `user` int(11) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `previous_generated_pass`
--

INSERT INTO `previous_generated_pass` (`id`, `pass_generated`, `user`, `createdAt`, `updatedAt`) VALUES
(43, 'KVY3E31', 1, '2024-05-22 14:45:04', '2024-05-22 14:45:04'),
(44, 'GE1P90', 1, '2024-05-22 14:47:00', '2024-05-22 14:47:00'),
(45, 'LBZ6M29', 1, '2024-05-22 14:47:19', '2024-05-22 14:47:19'),
(46, 'MBV7V70', 1, '2024-05-22 16:44:40', '2024-05-22 16:44:40'),
(47, 'RVE6I05', 5, '2024-05-22 16:45:00', '2024-05-22 16:45:00'),
(48, 'ZAE2B91', 5, '2024-05-22 18:17:40', '2024-05-22 18:17:40'),
(49, 'YEY2N76', 5, '2024-05-22 18:26:54', '2024-05-22 18:26:54'),
(50, 'UXQ3X95', 1, '2024-05-23 09:07:25', '2024-05-23 09:07:25'),
(51, 'EYP7Y02', 1, '2024-05-23 14:40:45', '2024-05-23 14:40:45');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `user` varchar(10) NOT NULL,
  `password` text NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `user`, `password`, `createdAt`, `updatedAt`) VALUES
(1, 'admin', 'admin', 'admin', '$2y$10$0dM2t/oY2FmvZxOXLyp/QOixLtC6uLd8zFZa89T4D3EL6cor5UoZC', '2024-05-18 17:19:00', '2024-05-18 17:19:00'),
(3, 'Marcos', 'Paulo', 'marcos', '$2y$10$qy79WFygcxdpSeopX6huMu0qCBW9xCdop/nk0vKBM6kIyuxUkjv3e', '2024-05-18 18:04:52', '2024-05-18 18:04:52'),
(5, 'Alice', 'Carvalho', 'alice', '$2y$10$I7CRgSj6e3JOzMRGWNukhOHLv6bLvlguENm3MA/8FDUkOhDpxa39G', '2024-05-21 22:42:44', '2024-05-21 22:42:44'),
(6, 'Fabricio', 'Marques', 'fabricio', '$2y$10$88D0Byk/vV9eX8k3nIdv0uPAKnU/6Xn3CqByymvyo/wPit2O24XGG', '2024-05-22 09:55:05', '2024-05-22 09:55:05');

-- --------------------------------------------------------

--
-- Estrutura para tabela `user_cargo`
--

CREATE TABLE `user_cargo` (
  `iduser` int(11) NOT NULL,
  `idcargo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `user_cargo`
--

INSERT INTO `user_cargo` (`iduser`, `idcargo`) VALUES
(1, 1),
(3, 3),
(5, 4),
(6, 9);

-- --------------------------------------------------------

--
-- Estrutura para tabela `user_guiche`
--

CREATE TABLE `user_guiche` (
  `id` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idguiche` int(11) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `called_pass`
--
ALTER TABLE `called_pass`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idpass` (`idpass`),
  ADD KEY `iduser` (`iduser`);

--
-- Índices de tabela `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `guiches`
--
ALTER TABLE `guiches`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `permissao_bloqueada`
--
ALTER TABLE `permissao_bloqueada`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idcargo` (`idcargo`),
  ADD KEY `idpermission` (`idpermission`);

--
-- Índices de tabela `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `previous_generated_pass`
--
ALTER TABLE `previous_generated_pass`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user` (`user`);

--
-- Índices de tabela `user_cargo`
--
ALTER TABLE `user_cargo`
  ADD UNIQUE KEY `user_cargo_foreign` (`iduser`),
  ADD KEY `idcargo` (`idcargo`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `called_pass`
--
ALTER TABLE `called_pass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de tabela `cargos`
--
ALTER TABLE `cargos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `guiches`
--
ALTER TABLE `guiches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `permissao_bloqueada`
--
ALTER TABLE `permissao_bloqueada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT de tabela `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `previous_generated_pass`
--
ALTER TABLE `previous_generated_pass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `called_pass`
--
ALTER TABLE `called_pass`
  ADD CONSTRAINT `previous_generated_pass_called_pass_foreign` FOREIGN KEY (`idpass`) REFERENCES `previous_generated_pass` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_called_pass_foreign` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `permissao_bloqueada`
--
ALTER TABLE `permissao_bloqueada`
  ADD CONSTRAINT `cargos_permissao_bloqueada_foreign` FOREIGN KEY (`idcargo`) REFERENCES `cargos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permissions_permissao_bloqueada_foreign` FOREIGN KEY (`idpermission`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `previous_generated_pass`
--
ALTER TABLE `previous_generated_pass`
  ADD CONSTRAINT `users_previous_generated_pass_foreign` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `user_cargo`
--
ALTER TABLE `user_cargo`
  ADD CONSTRAINT `user_cargo_cargo_foreign` FOREIGN KEY (`idcargo`) REFERENCES `cargos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_cargo_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
