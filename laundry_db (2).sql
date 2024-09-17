-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2024 at 05:38 PM
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
-- Database: `laundry_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(255) NOT NULL,
  `laundry_category_option` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `laundry_category_option`) VALUES
(1, 'Clothes/Table Napkin/Pillowcase'),
(2, 'Bedsheet/Table Cloths/Curtain'),
(3, 'Comforter/Bath towel');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `contact_number`, `address`) VALUES
(429, 'denise', '11111111111', '');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service_id` int(255) NOT NULL,
  `laundry_service_option` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`service_id`, `laundry_service_option`) VALUES
(1, 'Wash/Dry/Fold'),
(2, 'Wash/Dry/Press'),
(3, 'Dry Only');

-- --------------------------------------------------------

--
-- Table structure for table `service_category_price`
--

CREATE TABLE `service_category_price` (
  `id` int(255) NOT NULL,
  `service_id` int(255) NOT NULL,
  `category_id` int(255) NOT NULL,
  `price` decimal(65,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_category_price`
--

INSERT INTO `service_category_price` (`id`, `service_id`, `category_id`, `price`) VALUES
(1, 1, 1, 35.00),
(2, 1, 2, 55.00),
(3, 1, 3, 65.00),
(4, 2, 1, 80.00),
(5, 2, 2, 100.00),
(6, 3, 1, 35.00),
(7, 3, 2, 45.00),
(8, 3, 3, 55.00);

-- --------------------------------------------------------

--
-- Table structure for table `service_options`
--

CREATE TABLE `service_options` (
  `option_id` int(255) NOT NULL,
  `option_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_options`
--

INSERT INTO `service_options` (`option_id`, `option_name`) VALUES
(1, 'Delivery'),
(2, 'Customer Pick-Up'),
(3, 'Rush\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `service_option_price`
--

CREATE TABLE `service_option_price` (
  `option_price_id` int(255) NOT NULL,
  `option_id` int(255) NOT NULL,
  `service_option_type` varchar(100) NOT NULL,
  `price` decimal(65,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_option_price`
--

INSERT INTO `service_option_price` (`option_price_id`, `option_id`, `service_option_type`, `price`) VALUES
(1, 1, 'Delivery', 50.00),
(7, 3, 'Rush', 25.00);

-- --------------------------------------------------------

--
-- Table structure for table `service_request`
--

CREATE TABLE `service_request` (
  `request_id` int(11) NOT NULL,
  `customer_id` int(100) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `service_id` int(255) NOT NULL,
  `laundry_service_option` varchar(100) NOT NULL,
  `category_id` int(255) NOT NULL,
  `laundry_category_option` varchar(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `weight` decimal(65,0) NOT NULL,
  `price` decimal(65,2) NOT NULL,
  `request_date` date NOT NULL,
  `service_request_date` date NOT NULL DEFAULT current_timestamp(),
  `service_req_time` time NOT NULL DEFAULT current_timestamp(),
  `order_status` enum('completed','active','cancelled','') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_request`
--

INSERT INTO `service_request` (`request_id`, `customer_id`, `customer_name`, `contact_number`, `service_id`, `laundry_service_option`, `category_id`, `laundry_category_option`, `quantity`, `weight`, `price`, `request_date`, `service_request_date`, `service_req_time`, `order_status`) VALUES
(643, 429, 'denise', '11111111111', 1, 'Wash/Dry/Fold', 1, 'Clothes/Table Napkin/Pillowcase', 1, 5, 35.00, '2024-09-18', '2024-09-17', '23:31:31', 'completed'),
(644, 429, 'denise', '11111111111', 3, 'Dry Only', 3, 'Comforter/Bath towel', 1, 5, 55.00, '2024-09-18', '2024-09-17', '23:31:31', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` int(100) NOT NULL,
  `min_kilos` int(100) NOT NULL,
  `max_kilos` int(100) NOT NULL,
  `delivery_day` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `min_kilos`, `max_kilos`, `delivery_day`) VALUES
(1, 5, 20, 3);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(100) NOT NULL,
  `request_id` int(100) NOT NULL,
  `customer_id` int(100) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `service_id` int(100) NOT NULL,
  `laundry_service_option` varchar(100) NOT NULL,
  `category_id` int(100) NOT NULL,
  `laundry_category_option` varchar(100) NOT NULL,
  `price` decimal(65,2) NOT NULL,
  `service_option_id` int(255) NOT NULL,
  `service_option_name` varchar(100) NOT NULL,
  `weight` decimal(65,2) NOT NULL,
  `laundry_cycle` enum('Standard','Rush') NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `total_amount` decimal(65,2) NOT NULL,
  `delivery_fee` decimal(65,2) NOT NULL,
  `rush_fee` decimal(65,2) NOT NULL,
  `amount_tendered` decimal(65,2) NOT NULL,
  `money_change` decimal(65,2) NOT NULL,
  `request_date` date DEFAULT NULL,
  `transaction_date` date NOT NULL DEFAULT current_timestamp(),
  `transaction_time` time NOT NULL DEFAULT current_timestamp(),
  `order_status` enum('completed','active','') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `request_id`, `customer_id`, `customer_name`, `service_id`, `laundry_service_option`, `category_id`, `laundry_category_option`, `price`, `service_option_id`, `service_option_name`, `weight`, `laundry_cycle`, `customer_address`, `total_amount`, `delivery_fee`, `rush_fee`, `amount_tendered`, `money_change`, `request_date`, `transaction_date`, `transaction_time`, `order_status`) VALUES
(417, 643, 429, 'denise', 3, 'Dry Only', 3, 'Comforter/Bath towel', 55.00, 2, 'Customer Pick-Up', 5.00, 'Rush', '', 475.00, 0.00, 25.00, 500.00, 25.00, '2024-09-18', '2024-09-17', '23:31:46', 'completed'),
(418, 644, 429, 'denise', 3, 'Dry Only', 3, 'Comforter/Bath towel', 55.00, 2, 'Customer Pick-Up', 5.00, 'Rush', '', 475.00, 0.00, 25.00, 500.00, 25.00, '2024-09-18', '2024-09-17', '23:31:46', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `password` varchar(16) NOT NULL,
  `profile_picture` blob NOT NULL,
  `role` varchar(100) NOT NULL,
  `user_status` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `first_name`, `last_name`, `password`, `profile_picture`, `role`, `user_status`, `date_created`) VALUES
(1, 'admin', 'doris', 'dimaguiba', 'admin123456', 0x89504e470d0a1a0a0000000d4948445200000190000001900803000000b761c6fe000000d5504c544547704c70cef558cef259cef26199ba6ec2e858cef258cef258cef259cef259cef265cef34e5e774e5f784e5e774e5f7859cef257cef359cef24e5e774e5e7859cef257cef34e5e77aaccfa59cef24e5e7752ccf24e5e7857cef2aaccfa59cef24e5e7757cef2aaccfa55cdf3aaccfaa9ccfaaaccfaaacdfbaaccfb37c3f24b6d89aaccfaaaccfb3da9d3509ebf38c4f3aacdfa8dffbd345eff59cef234c2f24e5e77ffffffaaccfa82d8f663d0f346c8f3f3fcfe9ce2f8c8effb72d0f5e2f7fd94cdf8487f9fb8eafa4495b954bde157c6ea54b6d939799d490000003274524e53001a6cfe050e768048e4fa28ce19f52ea591f4af48ee38e5f0b8925f7dc7d7dc63d38b54bfa8365241eefe7163fef9ad139290df15f4000010264944415478daec9d0953e3b8168589edec2189b3928d24049aade94e959b6c0428a07bfeff4f1a3984c58e17d99664253e77ded44cbda286b1beb9f7dc7b2cc94747fb1d5aa5d1af97dae5fbfb72bb54ef372ae923447c713cea96caf784c647944bddd131d6252e1cfdd237165f4cfa15ac4d2cd9e184638b0459225c3b1a75171c1b24f58686351219e951e9de33da7da8bbc872d52ddffb44b98bb225130fb36c81884c3c40449c7ef4a97898550b3a22a2bf1a51f22044fae8b5047825ed7bea6837b060dc05a4ee3008d6bbfd7eb7ee3028b29391e9146bef183b05abdddd3a8a5aa5d16df32a5adacf4bacbd53544a761c15ed7b3db3232931f2b5a6e717d0234745b7adf748b3ff808d18a314b93c39fd81e5775010eb72971c44bb61fb11362a72369fdf62f91d56bbec5f8fac55ad3c62f17b8ba7f3f905647db76275699ada914547ea2c6ad6cf93f9fce40a00bc2b5657a3c1c642d6d31773126790f59d8ad5a65a694bd16251b37e9c9a404e5320608bbe2541282b5b3f7aa53c3379cc4f7e82802dbe2f74b941a9fdd145a4b84990f9fc1cb2ee619b78f5b316ad896e9fbc270852c4679d3dfec3d7ea2c55fd6a9b2024458a80e02ad65d8db23d6e470432bd987fc619deb0b802f1f244b43e3b20daedc9179013588cae404662806897df7890d617d3a18ba87b3559d692154d43be04642b23f0189de7104fd39099a86b97361e840872c4a96695bd2a16b3b637fd738707a95a97b050be26be12d536388bc5520fdd19a5ce4ee60e717a8b01f12b47baed76b95d1a69d413bd87c5e2d3ee5e9ecf5de2e20aedef4751d72a8d51e338403716d25c9c5e5e9ccc5de3e40c480240eb47b5dfb5d44f2f1c9bba757189c2452b34d15e5069d3abb3531f1c9b2c393dfb012641c7c7c0156bfae3f69c82c696c9f92d98f8f2b0eea46b076b7ab5abf379a0c058e2b3a08d88db8090214c711cf76d1be5421859d0105671dce897d86c254597153d372aa36e7d775f7c581f4b3b9a5e610e8934c03b9e918e741cc17d523fc1a41e50c919ed7d87971532462e6778226f6f80dbcb6032677a5a07ef43c2345775171e4c8e86e08d61f08255e679281aefd403d7f9aef3d51aac4e1762d749d08eb7e4741f10bbcb6734cbbe2ce8b93f10877190edf54cd8b918acc7b24b48c9720e9445606f6f202056eda88f2acccb0a76bf8706d2af70b97006e743c202e17495064e5005e87a2d3b1a467cbaa029ce18d24ee923abe7deae37b8f8b038854bd7f13a5c4c5aae3738c808cea9530c6c95be8be95ee77097326e72f0c3d1e8963c2ef7638e04779d784b47a3ee7d8d59b9c418096e03f25672ff5bfe081296378ee3be2c7725efd7e92e5d647b093c6e94735572ea3b303797c0a3d0f01c021bdd363d8e8f2c01126e4ade6ddf070f20113393db5e10d63d8485bd1f0fe970ff58c8d630393ef6fa7e451b48042af94702a4bd869376b781cd860266728b6a6b9a0f126409131ced00d35fdaebc7dbf8ee0e5f8bc4d1b2d27c90e01316bc2c12d7571f5a45acef981c8bc45bc9ddcb8fe6eacc034948e148a75d0e7c50cedf2692b6279234d4840ec534556c4d327ae7c6db5af75f4ecf5eb9fcab9a5572ad620a5cdc173055ccf5327a7530aca9aaf1f7c6b3e268b445cfed9ff2cb3054b539ee102e935c31052cdfab8b963273a2da19e76b864afe30e3ef8beb301144008eddb2e4cef88cda9070d133931649974483d1d26679ea65494ee49b357369d4af55faf7e2f201cf807a9c76d192ff0c5b149a79024657089704d6b174b195338562dc2c140aaae1146fbb8b78f37637f89ded4d72b99659fd3d5913d4e4574c14fdf7f8fa6d17eecd3fc75f6aa885426d3830eb98cf6f3820141ba12028ccc7570d671a247ed9d7f0e5edeecf36aeafc783dfbff52c898ca2f4484c2613f32f8a92c990ff53d77f130ed7d71f3fff6707c9cb3fc33b0af94d1debe58ad303158af4b4985388648f874dd5a0089baabfbcfd71896bc2e733dc7ee8eeeec5aee9fea1aaa48e8d0744f84d7d391481f9ec6387cd66ad60d0c7b715bc79b9fb1339ee5ebe10dffc17e05f8470a911301b7d29a6a6fb8b85344fa65010cd2ea86671528d40f18b290e2b12df8a6523f20986e88baef472adfdd397746fd3c7160273b0d7ac9b374638be23f965840f75ab2fbd7d62a215abefa2ad4678f237d6383e91dcfc35a247b3dada9bea3555866af427feefc65dc9a321793398c450d993f322ad6a8dc5f3febbfbc327eefeb20162d4aab97d488fcc90d1f31a9c80ac0c6631ccc89e245aab5360f6b82b3e400c8651e8e4a4569254266fa8aadc405606d3c867e53dbbaee518a607372206e3503b1349932495cdb37e58f913649324ba8c4a929e0c0acc1f75b50f3c48920c26d28d8945bdc9e35157b217ac8f3151974b49d2bd81cae749f72141363190c94be1941eec53841f0f734c6cc9320af6c62abfe75ced41c1dabac16329bc148d9153228288c1396a12188e6965c8f92957ab7d28589f5ecaf4b0d383a5b00be011b79792ca0c453ca4b13f3c8892e4b371290973a784ab8c88e1b1d94a149397c2c129e14844188fb80cc7b4b0f46052b584f288c34b29ea79b18fb8da271e8488582f858b91c8314784f3d82489382f85a353c22549e2e0618e89ba182f25dd1bc7f380618918b1c558119024424641864456f1f13054fe86e354191baab14744e2e4b1f152b81a8e5aab5a88f901832159c5cd832849879fe128ca2961e635c68fe3dd70e49424b94e4d8a075ced150e6e86a348a784059295343cb878299a60a7242a12a9709849c2d84b11ee9444d212d9686c3ae03c432f2516a7242c13196930361c63724a68a19854deff247fbf32248e1a9324e1b7e58a2596cdffa40f958197f27e380dc1ca958fe8a54c6333120f16c95099eea79178b0117ef3564a1962f9e4f152b45607e9219197621e4e43f0121223e8e62dd99c92434c92209bb76432120f36e8bd14599d92834b124a2f456aa7e4b08266f3d65e382587137e9bb734a487e824a916bdb75c213d24f252e094c401c475f356cc5baee0a5c02991276a3b5e8ab9e50ae911e798684b1205e911f798a858a741bc888a5b476ced2f5224661551ec3d56158b126754533b5d165e0fc659b07647112d0b8b373e45cf3abc1c4975b0307145c7f1fd610ebe624cd174be9059d3311ac612aaeef236b738c0e2c411035707be87a21547c1eab9bf0fa9a268892f58558f9786450c23c2790cbdb65f6b7050848f208ae7feac141c14c13c3a3e5b1873285a623d13bf6fc2c04111ab2059df0da5290c232247108a3dd77050c4e5477342b3b5170e8a38cf846e732f8a96201e63cafdef705062f74cecaf7351b4444495fad03a5ee70a1941021c59cf6018e11eb54c90336d789dcb3d3a818e7de670c89073e4837d47170e0ae72864039e54c730c2d933097c53d304c308cf11641294071c14aea187b8370b1be2f9c538d4d572515ee7360fbe4bcb4728e94d25dced65615fe7aacd6a4e3ff8a293ab36c316f56ac83bccc2392885a1de4a1f650f1d48f628ddd287a1868361d86bfeb4100e4a6d902d9a1d76028098f72c6406c1eb7a2113fae2f1c00e4ab3d3dbca552280984bd40b7c4b6827c2ddfc811c9442be9afbfc5d490142a436a7e7835492809e897d433cedaf520b63533a8e9207848c6cc52c7de52ae891be9440eba0d43a196b6b9d2420e63a291dcaca358878bb358d8342dadc89bd2e260c08119309551b4cfdda36fc86f8f736f728e9408ea8da60b51afdaef131559b0b20546df038fa57db3c37c4373b8a4b494c2410df36b8a630f8f691eb86784b9b0b20346d7095c9e7c19c1d145b9b0b209636785c63ea99f8bfcedd697301c4b26429a73638f06b5b5a07c5a9cd0510ff36b8c3ea7b869a6543bcd9e6fadbc78907b2db06377347ace2dbeb5cb7361740fcda605567f8e1bc0f07c5bdcd0510bf3678c0f4db92bd9af9293e8f3617405c91bcb7c1b51e4b1e47e96acdbbcd05109f36b8caf85bf745a518a8670310ab9828ac3f861b340044b20010000110cf233f00820c0110000110008186204300044050b2000419820c01106408802043902100820c41860008320440000440000440000440d0652143000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440000440f60f880a2000022000022000022000022000022000223614004186000880a0640108320419628de56209203265c8e27101203265c87ab6061089802c1f678f4b009107c8e261f6b000107934e475369bbd02883419f2f44c803c3f01882c40d60f04c8c31a406401f238334342594f2890c5f306c8f30240a28a7a81d110f21e6b00912243968f5b20f2d5ac6402593c6c81cc160012114881658248982289d490a7cf04916f5a4f6486bccebee2154062cf902f05913045129821df14444215492090f583058864fe49f2803c3dcfac2197c5983820b682255dd14a1c105bc192ae68250d88030fb988240cc8e279e61412b9bec902e2c24326228902e2ca4322224902b276e74188ac01442c90a5a39e7f57f625800804f2f4e8cd8310797c02105140969ee5eaab6c2d01440890856f7a7c24c90240b803592e5ee9706c90bcc67c4ae1e08104c2b1cd922580f002b2583f06c3f18e641d1f934306b25c3f3ecfc2c5f3e3fa0940980221a5eaf961163e1e9ee35193c304b20c55aa7699c450ba0e13c8e271c626c45b5cc810640834045d16ba2ccc2100e2e6f2625297d0cb7a869705b71740f03ee4fff6ce6e37611886c27482b1a9d7937a9549511a90ca051217a19ac4a2bdff430d28abd0601d550cb5dd73dea0fa6a3b4efc83174300c19b3aaa4e00e46e405097c50d082a17b901416d2f3720d7abdf3f51fd3e1890ab44d01f32201074503103821e436e40d085cb0d08fad49901c124076e4030eb841b104c036206e42c8a7c615e569a68662eb651e40313e5d29495247f34662e526951d06471984a4aa3990d91e4b331b79746b90991c6c960b23589562104229f85d9ef049aba3d101a9f55633b0281bcd90309346e06fb4308640f3c024d20c6861d8224c41d8144aa54043ba852437a71044213d66b6c694bd5ba6c78109908f618a667e927204426824d9f8906e27e785025871b0049c941aad640a892430049d1d284300622528064ee9c8762a7351776c2524f440690990dbfb5059001edc3161740b4da880420f9a57de8252200c8d285eb8a3b0019c05d5526fca95d0d200f8ee64b57840ee93312d640b245d989a3415203c863ee4a7ce5fec5d120d901c8dd69ac17a509b72a2a3293394b1ade9a22f452dc2a61c21148667bd2d09497700432f355d91b899648c23486f4745a6a1c16e353d6ed613daa3af972ce43a6deba1b8c0379c823ef152b33aab450c05d96ef3a7245dc650d70e65a19dcf6323312371e1e325e0cf332e0c5903b11ad550e42aa4e7287aa136671c48c207e4802d2f622a072914bda6e4750942509c8a1251ad5efbc9cd6188adf250169ebad351b88a81ec36a0406220ac8e9e8abda4024f6a9c70d803051d3f6b90310362fed4ebdc712360da8d29d14ca03e20baad9330042f37a582a0fe9f2662e2a0fe9e28078570308ab3bdfa7f757d57a7b96056492bd28573e812008822008ead03772139b596ccd1f210000000049454e44ae426082, 'admin', 'active', '2024-07-03 18:46:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `unique_customer` (`customer_name`,`contact_number`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `service_category_price`
--
ALTER TABLE `service_category_price`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`service_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `service_options`
--
ALTER TABLE `service_options`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `service_option_price`
--
ALTER TABLE `service_option_price`
  ADD PRIMARY KEY (`option_price_id`),
  ADD KEY `option_id` (`option_id`);

--
-- Indexes for table `service_request`
--
ALTER TABLE `service_request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `service_id` (`service_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `request_id` (`request_id`,`customer_id`),
  ADD KEY `service_option_id` (`service_option_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=430;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `service_category_price`
--
ALTER TABLE `service_category_price`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `service_options`
--
ALTER TABLE `service_options`
  MODIFY `option_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `service_option_price`
--
ALTER TABLE `service_option_price`
  MODIFY `option_price_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `service_request`
--
ALTER TABLE `service_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=645;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=419;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `service_category_price`
--
ALTER TABLE `service_category_price`
  ADD CONSTRAINT `service_category_price_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `service_category_price_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_option_price`
--
ALTER TABLE `service_option_price`
  ADD CONSTRAINT `service_option_price_ibfk_1` FOREIGN KEY (`option_id`) REFERENCES `service_options` (`option_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `service_request`
--
ALTER TABLE `service_request`
  ADD CONSTRAINT `service_request_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `service_request_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `service_request_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `service_request` (`request_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`service_option_id`) REFERENCES `service_options` (`option_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
