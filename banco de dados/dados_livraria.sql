-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26-Fev-2025 às 03:45
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dados_livraria`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `archived_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `description`, `price`, `stock`, `category_id`, `sub_category_id`, `image`, `created_at`, `updated_at`, `archived_at`) VALUES
(1, 'O Senhor dos Anéis', 'J.R.R. Tolkien', 'Uma obra clássica da fantasia.', 59.90, 20, 1, 1, 'imagens/senhor-dos-aneis.jpg', '2025-02-19 13:47:23', '2025-02-19 19:33:01', NULL),
(2, '1984', 'George Orwell', 'Uma visão distópica do futuro.', 39.90, 15, 1, 2, 'imagens/1984.jpg', '2025-02-19 13:47:23', '2025-02-19 19:33:14', NULL),
(3, 'Sapiens', 'Yuval Noah Harari', 'Uma breve história da humanidade.', 45.00, 10, 2, 3, 'imagens/sapiens.jpg', '2025-02-19 13:47:23', '2025-02-19 19:33:22', NULL),
(4, 'Orgulho e Preconceito', 'Jane Austen', 'Um romance clássico.', 29.90, 25, 3, 4, 'imagens/orgulho-e-preconceito.jpg', '2025-02-19 13:47:23', '2025-02-19 19:33:33', NULL),
(5, 'A Ilha do Tesouro', 'Robert Louis Stevenson', 'Uma aventura pirata inesquecível.', 34.50, 18, 4, 5, 'imagens/ilha-do-tesouro.jpg', '2025-02-19 13:47:23', '2025-02-19 19:33:42', NULL),
(6, 'It: A Coisa', 'Stephen King', 'Um grupo de amigos enfrenta um ser aterrorizante que assume a forma de seus piores medos.', 54.90, 12, 5, 6, 'imagens/it.jpg', '2025-02-19 14:03:00', '2025-02-19 19:33:51', NULL),
(12, 'O Chamado de Cthulhu', 'H.P. Lovecraft', 'Uma história sobre loucura e seres cósmicos além da compreensão humana.', 35.90, 8, 5, 5, 'imagens/cthulhu.jpg', '2025-02-19 14:03:00', '2025-02-19 14:03:00', NULL),
(13, 'O Silêncio dos Inocentes', 'Thomas Harris', 'A agente do FBI Clarice Starling precisa lidar com o genial e assustador Hannibal Lecter.', 45.00, 10, 6, 7, 'imagens/silencio-inocentes.jpg', '2025-02-19 14:03:00', '2025-02-19 14:03:00', NULL),
(14, 'Mindset: A Nova Psicologia do Sucesso', 'Carol S. Dweck', 'Um livro sobre a importância do crescimento pessoal através da mentalidade certa.', 49.90, 20, 7, 9, 'imagens/mindset.jpg', '2025-02-19 14:03:00', '2025-02-19 14:03:00', NULL),
(15, 'O Pequeno Príncipe', 'Antoine de Saint-Exupéry', 'Uma história encantadora sobre amizade, amor e descobertas.', 29.90, 30, 8, 11, 'imagens/pequeno-principe.jpg', '2025-02-19 14:03:00', '2025-02-19 14:03:00', NULL),
(16, 'Steve Jobs', 'Walter Isaacson', 'A biografia definitiva de um dos maiores visionários da tecnologia.', 59.90, 15, 9, 13, 'imagens/steve-jobs.jpg', '2025-02-19 14:03:00', '2025-02-19 14:03:00', NULL),
(17, 'Batman: O Cavaleiro das Trevas', 'Frank Miller', 'Uma releitura sombria e icônica do herói Batman.', 64.90, 18, 10, 16, 'imagens/batman.jpg', '2025-02-19 14:03:00', '2025-02-26 00:10:50', NULL),
(18, 'One Piece - Volume 1', 'Eiichiro Oda', 'O início da grande aventura de Luffy e sua tripulação.', 22.90, 50, 10, 17, 'imagens/one-piece.jpg', '2025-02-19 14:03:00', '2025-02-26 00:10:30', NULL),
(19, 'O Príncipe', 'Nicolau Maquiavel', 'Um polémico e universal tratado filosófico que encerra o segredo para a arte de bem governar.', 19.90, 5, 9, 3, 'imagens/o-principe.jpg', '2025-02-19 19:38:35', '2025-02-19 19:48:48', NULL),
(20, 'De Pobre a Milionário', 'Celso Lascasas', 'Celso Lascasas, fundador das lojas de mobiliário Laskasas e empreendedor, traz-nos nestas páginas muito mais do que a história de uma vida conquistada a pulso. De Pobre a Milionário é também um manancial de importantes lições de empreendedorismo. E isso só é possível para alguém que passou do duro trabalho braçal para o duro trabalho de ser um empreendedor.', 17.99, 5, 9, 14, 'imagens/pobre-a-milionario.jpg', '2025-02-25 23:51:24', '2025-02-26 02:03:53', NULL),
(21, 'Caçador Sem Coração', ' Kristen Ciccarelli', 'Na noite em que uma devastadora revolução derruba as bruxas, a vida de Rune muda para sempre. Agora, as bruxas são caçadas e executadas, e para sobreviver ela precisa de esconder quem realmente é. Durante o dia, a jovem fi nge ser apenas uma socialite fútil, mas à noite torna-se na Mariposa Escarlate, uma vingadora que salva bruxas da purga que se abateu sobre o reino. Porém, quando um dos resgates corre mal, ela tem de despistar os perseguidores e conseguir a informação de que precisa. E a solução é cortejar o belo e impiedoso Gideon Sharpe, um dos mais famosos caçadores de bruxas.', 17.99, 8, 1, 1, 'imagens/cacador-sem-coracao.jpg', '2025-02-25 23:55:06', '2025-02-26 00:01:38', NULL),
(22, 'Espiritualidade E Autoajuda', 'Pe. Roque Schneider', 'Este ebook se configura como uma espécie de roteiro orante, alicerçada em pequenas reflexões diárias, com o objetivo de oferecer ao leitor uma forma de conectar-se com Deus, o que, como bem se sabe, é terapêutico e salutar. O autor, bastante conhecido por seus inúmeros livros e por seus programas no rádio e na TV, buscou inspiração em sua bagagem intelectual, formada por textos acadêmicos e literários, para mostrar que todos têm, dentro de si mesmos, a solução para triunfar sobre os obstáculos e fazer da sua existência a mais rica das trajetórias humanas. Assim, com fé em Deus e iluminados por suas luzes interiores, este livro, repleto de palavras de sabedoria, fraternidade e esperança mostrará aos leitores novos caminhos e horizontes para o dia a dia.', 2.99, 16, 7, 11, 'imagens/espiritualidade-e-autoajuda.jpg', '2025-02-26 00:05:41', '2025-02-26 00:05:41', NULL),
(23, 'Não Há Impossíveis', 'Paulo Azevedo e Paulo M. Morais', '«Podia ser pior», disse a sua mãe, aos 16 anos, quando percebeu que tinha acabado de dar à luz uma criança sem mãos e sem pernas. Começou a escrever-se assim a história daquele que é hoje o protagonista das mais poderosas palestras motivacionais do país. Condenado a nunca conseguir caminhar, a uma vida de total dependência e a não cumprir sonho algum, Paulo Azevedo rejeitou desde cedo, com um extraordinário (...)\r\n', 13.29, 6, 7, 10, 'imagens/nao-ha-impossiveis.jpg', '2025-02-26 00:08:43', '2025-02-26 00:08:43', NULL),
(24, 'Pessoa. Uma Biografia', 'Richard Zenith', '\r\nFernando Pessoa é, a par de Luís de Camões, o maior poeta português. E é uma das figuras proeminentes do modernismo europeu, juntamente com escritores como Kafka, Joyce e Proust. O seu vastíssimo legado - da poesia, drama e ficção ao artigo de opinião e escrita mediúnica, cruzando e aprofundando inúmeros domínios do conhecimento (da literatura à religião, passando pela história, a filosofia, a astrologia e tantos outros) - tem vindo a ser progressivamente conhecido pelos leitores portugueses e de todo o mundo.', 23.99, 3, 9, 14, 'imagens/pessoa.jpg', '2025-02-26 00:13:08', '2025-02-26 02:00:10', NULL),
(25, 'O Pai e Eu', 'Maria Teresa Maia Gonzalez', 'Quando dissemos a nossa primeira palavra, o Pai foi logo contar a novidade a toda a gente que conhecia (e era a palavra «Mamã»)!', 5.99, 8, 8, 12, 'imagens/o-pai-e-eu.jpg', '2025-02-26 00:38:34', '2025-02-26 00:38:34', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `idcategoria` int(11) NOT NULL,
  `NomeCategoria` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`idcategoria`, `NomeCategoria`, `created_at`, `updated_at`) VALUES
(1, 'Ficção', '2025-02-19 13:37:43', '2025-02-19 13:39:23'),
(2, 'Não-ficção', '2025-02-19 13:37:43', '2025-02-19 13:39:31'),
(3, 'Best-sellers', '2025-02-19 13:37:43', '2025-02-19 13:39:38'),
(4, 'Clássicos', '2025-02-19 13:37:43', '2025-02-19 13:39:44'),
(5, 'Terror', '2025-02-19 13:59:51', '2025-02-19 13:59:51'),
(6, 'Suspense', '2025-02-19 13:59:51', '2025-02-19 13:59:51'),
(7, 'Autoajuda', '2025-02-19 13:59:51', '2025-02-19 13:59:51'),
(8, 'Infantil', '2025-02-19 13:59:51', '2025-02-19 13:59:51'),
(9, 'Biografia', '2025-02-19 13:59:51', '2025-02-19 13:59:51'),
(10, 'HQs e Mangás', '2025-02-19 13:59:51', '2025-02-19 13:59:51');

-- --------------------------------------------------------

--
-- Estrutura da tabela `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','canceled') DEFAULT 'pending',
  `delivery_address` text NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_time_of_order` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `subcategoria`
--

CREATE TABLE `subcategoria` (
  `sub_category_id` int(11) NOT NULL,
  `Nome` varchar(255) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `subcategoria`
--

INSERT INTO `subcategoria` (`sub_category_id`, `Nome`, `idcategoria`, `created_at`, `updated_at`, `slug`) VALUES
(1, 'Fantasia', 1, '2025-02-19 13:45:53', '2025-02-19 13:45:53', 'fantasia'),
(2, 'Ficção Científica', 1, '2025-02-19 13:45:53', '2025-02-19 13:45:53', 'ficcao-cientifica'),
(3, 'História', 2, '2025-02-19 13:45:53', '2025-02-19 13:45:53', 'historia'),
(4, 'Romance', 3, '2025-02-19 13:45:53', '2025-02-19 13:45:53', 'romance'),
(5, 'Aventura', 4, '2025-02-19 13:45:53', '2025-02-19 13:45:53', 'aventura'),
(6, 'Horror Psicológico', 5, '2025-02-19 14:01:05', '2025-02-19 14:01:05', 'horror-psicologico'),
(7, 'Sobrenatural', 5, '2025-02-19 14:01:05', '2025-02-19 14:01:05', 'sobrenatural'),
(8, 'Policial', 6, '2025-02-19 14:01:05', '2025-02-19 14:01:05', 'policial'),
(9, 'Thriller', 6, '2025-02-19 14:01:05', '2025-02-19 14:01:05', 'thriller'),
(10, 'Motivacional', 7, '2025-02-19 14:01:05', '2025-02-19 14:01:05', 'motivacional'),
(11, 'Desenvolvimento Pessoal', 7, '2025-02-19 14:01:05', '2025-02-19 14:01:05', 'desenvolvimento-pessoal'),
(12, 'Contos Infantis', 8, '2025-02-19 14:01:05', '2025-02-19 14:01:05', 'contos-infantis'),
(13, 'Fábulas', 8, '2025-02-19 14:01:05', '2025-02-19 14:01:05', 'fabulas'),
(14, 'Histórias Reais', 9, '2025-02-19 14:01:05', '2025-02-19 14:01:05', 'historias-reais'),
(15, 'Celebridades', 9, '2025-02-19 14:01:05', '2025-02-19 14:01:05', 'celebridades'),
(16, 'Super-Heróis', 10, '2025-02-19 14:01:05', '2025-02-19 14:01:05', 'super-herois'),
(17, 'Mangá', 10, '2025-02-19 14:01:05', '2025-02-19 14:01:05', 'manga');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `apelido` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `chave_validacao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `senha`, `nome`, `apelido`, `phone_number`, `role`, `created_at`, `updated_at`, `chave_validacao`) VALUES
(1, '', 'kauanbenitez04@gmail.com', '$2y$10$iDlW1w0mIaHYIrhP6BpGB.jG6xU4wkySpXMObqBseQWIZTQRf6qmq', 'Kauan', 'Benitez', NULL, 'user', '2025-02-18 21:19:49', '2025-02-18 21:19:49', 'YL4M73s'),
(3, '', 'kauanbenitez4@gmail.com', '$2y$10$Xxv/sdf3bSjGr2znzW1ho.ho7N.boDSt3/Kh2yklZTjX9Y5XAatGe', 'KaKa', 'brs', NULL, 'user', '2025-02-26 00:45:12', '2025-02-26 00:45:12', 'yIdDPjn'),
(4, '', 'maravidal888@gmail.com', '$2y$10$qgS/rIRD95Xtj5o1VknlROruAB70ZUdd3OsutphqnQ6mAOun83SHe', 'KK', 'Benitez', NULL, 'user', '2025-02-26 02:33:28', '2025-02-26 02:33:28', '78f819a'),
(5, '', 'kauanbenitez46@gmail.com', '$2y$10$z/Ok4X.mWwH9DxI3LbtqFOLaqJxkycEC5O407Vvlnu40wc.ydO0ce', 'KK', 'Benitez', NULL, 'user', '2025-02-26 02:35:08', '2025-02-26 02:35:08', '09ba0ae');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `sub_category_id` (`sub_category_id`);

--
-- Índices para tabela `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Índices para tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Índices para tabela `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices para tabela `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Índices para tabela `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD PRIMARY KEY (`sub_category_id`),
  ADD KEY `category_id` (`idcategoria`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `subcategoria`
--
ALTER TABLE `subcategoria`
  MODIFY `sub_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categorias` (`idcategoria`),
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`sub_category_id`) REFERENCES `subcategoria` (`sub_category_id`);

--
-- Limitadores para a tabela `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);

--
-- Limitadores para a tabela `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Limitadores para a tabela `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);

--
-- Limitadores para a tabela `subcategoria`
--
ALTER TABLE `subcategoria`
  ADD CONSTRAINT `subcategoria_ibfk_1` FOREIGN KEY (`idcategoria`) REFERENCES `categorias` (`idcategoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
