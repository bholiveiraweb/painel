-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Tempo de geração: 26/05/2020 às 22:02
-- Versão do servidor: 8.0.19
-- Versão do PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_lojapo`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_departments`
--

CREATE TABLE `tb_departments` (
  `id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `tb_departments`
--

INSERT INTO `tb_departments` (`id`, `title`, `slug`, `created_at`, `updated_at`) VALUES
(13, 'Camisetas Masculinas', 'camisetas-masculinas', '2020-05-19 18:08:37', '2020-05-26 12:05:26');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_products`
--

CREATE TABLE `tb_products` (
  `id` int NOT NULL,
  `id_department` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_general_ci,
  `price` decimal(11,2) NOT NULL,
  `image` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `link` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `tb_products`
--

INSERT INTO `tb_products` (`id`, `id_department`, `title`, `description`, `price`, `image`, `link`, `slug`, `created_at`, `updated_at`) VALUES
(12, 13, 'Produto teste', NULL, '10.99', '5eccff72b2c0e.jpeg', 'https://produto.mercadolivre.com.br/MLB-1477166211-smart-tv-led-43-polegadas-full-hd-aoc-com-wi-fi-entrada-_JM?variation=52862154522&quantity=1#reco_item_pos=1&reco_backend=promotions-sorted-by-score-mlb&reco_backend_type=low_level&reco_client=home_seller-promotions-recommendations&reco_id=51038547-118a-4919-aee2-c8072534af9c&c_id=/home/promotions-recommendations/element&c_element_order=2&c_uid=412c3c2b-5299-4a7b-ad54-879586043430', NULL, '2020-05-25 18:48:59', '2020-05-26 11:37:22');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_users`
--

CREATE TABLE `tb_users` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `tb_users`
--

INSERT INTO `tb_users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Admin', 'admin@admin.com.br', '$2y$10$xLmHosc9bS10KeeaFK8ctOKsAJH42wJTYJGEq7eN21c9NkxkUauQS');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `tb_departments`
--
ALTER TABLE `tb_departments`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_products`
--
ALTER TABLE `tb_products`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `tb_departments`
--
ALTER TABLE `tb_departments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `tb_products`
--
ALTER TABLE `tb_products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
