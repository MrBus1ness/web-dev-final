-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 12, 2024 at 04:41 AM
-- Server version: 8.0.39
-- PHP Version: 8.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `card_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `card_id` int NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(45) COLLATE utf8mb4_general_ci NOT NULL,
  `supertype` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `subtype` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mana` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `power` int DEFAULT NULL,
  `toughness` int DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`card_id`, `name`, `type`, `supertype`, `subtype`, `mana`, `power`, `toughness`, `image_path`) VALUES
(1, 'Stella Lee, Wild Card', 'Creature', 'Legendary', 'Human Rogue', '{R}{U}{1}', 2, 4, '/Web Dev Final/images/otc-3-stella-lee-wild-card.jpg'),
(2, 'Arcane Signet', 'Artifact', NULL, NULL, '{2}', NULL, NULL, '/Web Dev Final/images/otc-252-arcane-signet.jpg'),
(3, 'Folio of Fancies', 'Artifact', NULL, NULL, '{U}{1}', NULL, NULL, '/Web Dev Final/images/eld-46-folio-of-fancies.jpg'),
(4, 'Izzet Signet', 'Artifact', NULL, NULL, '{2}', NULL, NULL, '/Web Dev Final/images/otc-259-izzet-signet.jpg'),
(5, 'Midnight Clock', 'Artifact', NULL, NULL, '{U}{2}', NULL, NULL, '/Web Dev Final/images/otc-100-midnight-clock.jpg'),
(6, 'Sol Ring', 'Artifact', NULL, NULL, '{1}', NULL, NULL, '/Web Dev Final/images/otc-267-sol-ring.jpg'),
(7, 'Swiftfoot Boots', 'Artifact', NULL, 'Equipment', '{2}', NULL, NULL, '/Web Dev Final/images/otc-268-swiftfoot-boots.jpg'),
(8, 'Thought Vessel', 'Artifact', NULL, NULL, '{2}', NULL, NULL, '/Web Dev Final/images/mkc-245-thought-vessel.jpg'),
(9, 'Tormod\'s Crypt', 'Artifact', NULL, NULL, '{0}', NULL, NULL, '/Web Dev Final/images/dmr-235-tormod-s-crypt.jpg'),
(10, 'Twinning Staff', 'Artifact', NULL, NULL, '{3}', NULL, NULL, '/Web Dev Final/images/ncc-383-twinning-staff.jpg'),
(11, 'Wayfarer\'s Bauble', 'Artifact', NULL, NULL, '{1}', NULL, NULL, '/Web Dev Final/images/lcc-317-wayfarer-s-bauble.jpg'),
(12, 'Arcane Bombardment', 'Enchantment', NULL, NULL, '{R}{R}{4}', NULL, NULL, '/Web Dev Final/images/otc-154-arcane-bombardment.jpg'),
(13, 'Propaganda', 'Enchantment', NULL, NULL, '{U}{2}', NULL, NULL, '/Web Dev Final/images/otc-108-propaganda.jpg'),
(14, 'Psychic Corrosion', 'Enchantment', NULL, NULL, '{U}{2}', NULL, NULL, '/Web Dev Final/images/m19-68-psychic-corrosion.jpg'),
(15, 'Shark Typhoon', 'Enchantment', NULL, NULL, '{U}{5}', NULL, NULL, '/Web Dev Final/images/otc-113-shark-typhoon.jpg'),
(16, 'Sphinx\'s Tutelage', 'Enchantment', NULL, NULL, '{U}{2}', NULL, NULL, '/Web Dev Final/images/mb1-502-sphinx-s-tutelage.jpg'),
(17, 'Thousand-Year Storm', 'Enchantment', NULL, NULL, '{R}{U}{4}', NULL, NULL, '/Web Dev Final/images/2x2-286-thousand-year-storm.jpg'),
(18, 'Underworld Breach', 'Enchantment', NULL, NULL, '{R}{1}', NULL, NULL, '/Web Dev Final/images/thb-161-underworld-breach.jpg'),
(19, 'Archmage Emeritus', 'Creature', NULL, 'Human Wizard', '{U}{U}{2}', 2, 2, '/Web Dev Final/images/otc-90-archmage-emeritus.jpg'),
(20, 'Birgi, God of Storytelling', 'Creature', 'Legendary', 'God', '{R}{2}', 3, 3, '/Web Dev Final/images/khm-123-birgi-god-of-storytelling.jpg'),
(21, 'Chakram Retriever', 'Creature', NULL, 'Elemental Hound', '{U}{4}', 2, 4, '/Web Dev Final/images/bbd-15-chakram-retriever.jpg'),
(22, 'Goblin Electromancer', 'Creature', NULL, 'Goblin Wizard', '{R}{U}', 2, 2, '/Web Dev Final/images/otc-228-goblin-electromancer.jpg'),
(23, 'Haughty Djinn', 'Creature', NULL, 'Djinn', '{U}{U}{1}', NULL, 4, '/Web Dev Final/images/otc-99-haughty-djinn.jpg'),
(24, 'Jace\'s Archivist', 'Creature', NULL, 'Vedalken Wizard', '{U}{U}{1}', 2, 2, '/Web Dev Final/images/plist-1182-jace-s-archivist.jpg'),
(25, 'Kaza, Roil Chaser', 'Creature', 'Legendary', 'Human Wizard', '{R}{U}', 1, 2, '/Web Dev Final/images/otc-232-kaza-roil-chaser.jpg'),
(26, 'Storm-Kiln Artist', 'Creature', NULL, 'Dwarf Shaman', '{R}{3}', 2, 2, '/Web Dev Final/images/otc-181-storm-kiln-artist.jpg'),
(27, 'Thunderclap Drake', 'Creature', NULL, 'Drake', '{U}{1}', 2, 1, '/Web Dev Final/images/otc-17-thunderclap-drake.jpg'),
(28, 'Veyran, Voice of Duality', 'Creature', 'Legendary', 'Efreet Wizard', '{R}{U}{1}', 2, 2, '/Web Dev Final/images/otc-248-veyran-voice-of-duality.jpg'),
(29, 'Aetherize', 'Instant', NULL, NULL, '{U}{3}', NULL, NULL, '/Web Dev Final/images/lcc-142-aetherize.jpg'),
(30, 'Big Score', 'Instant', NULL, NULL, '{R}{3}', NULL, NULL, '/Web Dev Final/images/otc-155-big-score.jpg'),
(31, 'Brain Freeze', 'Instant', NULL, NULL, '{U}{1}', NULL, NULL, '/Web Dev Final/images/plist-46-brain-freeze.jpg'),
(32, 'Chaos Warp', 'Instant', NULL, NULL, '{R}{2}', NULL, NULL, '/Web Dev Final/images/otc-160-chaos-warp.jpg'),
(33, 'Fierce Guardianship', 'Instant', NULL, NULL, '{U}{2}', NULL, NULL, '/Web Dev Final/images/cmm-94-fierce-guardianship.jpg'),
(34, 'Frantic Search', 'Instant', NULL, NULL, '{U}{2}', NULL, NULL, '/Web Dev Final/images/woc-93-frantic-search.jpg'),
(35, 'Galvanic Iteration', 'Instant', NULL, NULL, '{R}{U}', NULL, NULL, '/Web Dev Final/images/otc-227-galvanic-iteration.jpg'),
(36, 'Increasing Vengeance', 'Instant', NULL, NULL, '{R}{R}', NULL, NULL, '/Web Dev Final/images/c19-147-increasing-vengeance.jpg'),
(37, 'Opt', 'Instant', NULL, NULL, '{U}', NULL, NULL, '/Web Dev Final/images/otc-104-opt.jpg'),
(38, 'Pongify', 'Instant', NULL, NULL, '{U}', NULL, NULL, '/Web Dev Final/images/otc-106-pongify.jpg'),
(39, 'Radical Idea', 'Instant', NULL, NULL, '{U}{1}', NULL, NULL, '/Web Dev Final/images/otc-110-radical-idea.jpg'),
(40, 'Return the Favor', 'Instant', NULL, NULL, '{R}{R}', NULL, NULL, '/Web Dev Final/images/otj-142-return-the-favor.jpg'),
(41, 'Seething Song', 'Instant', NULL, NULL, '{R}{2}', NULL, NULL, '/Web Dev Final/images/c21-179-seething-song.jpg'),
(42, 'Snap', 'Instant', NULL, NULL, '{U}{1}', NULL, NULL, '/Web Dev Final/images/woc-110-snap.jpg'),
(43, 'Think Twice', 'Instant', NULL, NULL, '{U}{1}', NULL, NULL, '/Web Dev Final/images/otc-119-think-twice.jpg'),
(44, 'Cascade Bluffs', 'Land', NULL, NULL, NULL, NULL, NULL, '/Web Dev Final/images/otc-276-cascade-bluffs.jpg'),
(45, 'Command Tower', '', NULL, NULL, NULL, NULL, NULL, '/Web Dev Final/images/otc-280-command-tower.jpg'),
(46, 'Exotic Orchard', 'Land', NULL, NULL, NULL, NULL, NULL, '/Web Dev Final/images/otc-293-exotic-orchard.jpg'),
(47, 'Ferrous Lake', 'Land', NULL, NULL, NULL, NULL, NULL, '/Web Dev Final/images/otc-294-ferrous-lake.jpg'),
(48, 'Frostboil Snarl', 'Land', NULL, NULL, NULL, NULL, NULL, '/Web Dev Final/images/otc-298-frostboil-snarl.jpg'),
(49, 'Island', 'Land', 'Basic', NULL, NULL, NULL, NULL, '/Web Dev Final/images/otj-279-island.jpg'),
(50, 'Izzet Boilerworks', 'Land', NULL, NULL, NULL, NULL, NULL, '/Web Dev Final/images/otc-302-izzet-boilerworks.jpg'),
(51, 'Mountain', 'Land', 'Basic', NULL, NULL, NULL, NULL, '/Web Dev Final/images/otj-284-mountain.jpg'),
(52, 'Reliquary Tower', 'Land', NULL, NULL, NULL, NULL, NULL, '/Web Dev Final/images/otc-312-reliquary-tower.jpg'),
(53, 'Shivan Reef', 'Land', NULL, NULL, NULL, NULL, NULL, '/Web Dev Final/images/otc-320-shivan-reef.jpg'),
(54, 'Sulfur Falls', 'Land', NULL, NULL, NULL, NULL, NULL, '/Web Dev Final/images/otc-322-sulfur-falls.jpg'),
(55, 'Temple of Epiphany', 'Land', NULL, NULL, NULL, NULL, NULL, '/Web Dev Final/images/otc-329-temple-of-epiphany.jpg'),
(56, 'Temple of the False God', 'Land', NULL, NULL, NULL, NULL, NULL, '/Web Dev Final/images/otc-334-temple-of-the-false-god.jpg'),
(57, 'Blasphemous Act', 'Sorcery', NULL, NULL, '{R}{8}', NULL, NULL, '/Web Dev Final/images/dsc-160-blasphemous-act.jpg'),
(58, 'Bond of Insight', 'Sorcery', NULL, NULL, '{U}{3}', NULL, NULL, '/Web Dev Final/images/war-43-bond-of-insight.jpg'),
(59, 'Curse of the Swine', 'Sorcery', NULL, NULL, '{U}{U}{X}', NULL, NULL, '/Web Dev Final/images/otc-92-curse-of-the-swine.jpg'),
(60, 'Expressive Iteration', 'Sorcery', NULL, NULL, '{R}{U}', NULL, NULL, '/Web Dev Final/images/otc-224-expressive-iteration.jpg'),
(61, 'Faithless Looting', 'Sorcery', NULL, NULL, '{R}', NULL, NULL, '/Web Dev Final/images/otc-165-faithless-looting.jpg'),
(62, 'Fractured Sanity', 'Sorcery', NULL, NULL, '{U}{U}{U}', NULL, NULL, '/Web Dev Final/images/clb-722-fractured-sanity.jpg'),
(63, 'Jeska\'s Will', 'Sorcery', NULL, NULL, '{R}{2}', NULL, NULL, '/Web Dev Final/images/mkc-156-jeska-s-will.jpg'),
(64, 'Lock and Load', 'Sorcery', NULL, NULL, '{U}{2}', NULL, NULL, '/Web Dev Final/images/otc-15-lock-and-load.jpg'),
(65, 'Maddening Cacophony', 'Sorcery', NULL, NULL, '{U}{1}', NULL, NULL, '/Web Dev Final/images/znr-67-maddening-cacophony.jpg'),
(66, 'Mizzix\'s Mastery', 'Sorcery', NULL, NULL, '{R}{3}', NULL, NULL, '/Web Dev Final/images/otc-175-mizzix-s-mastery.jpg'),
(67, 'Ponder', 'Sorcery', NULL, NULL, '{U}', NULL, NULL, '/Web Dev Final/images/otc-105-ponder.jpg'),
(68, 'Preordain', 'Sorcery', NULL, NULL, '{U}', NULL, NULL, '/Web Dev Final/images/otc-107-preordain.jpg'),
(69, 'Rousing Refrain', 'Sorcery', NULL, NULL, '{R}{R}{3}', NULL, NULL, '/Web Dev Final/images/otc-178-rousing-refrain.jpg'),
(70, 'Serum Vision', 'Sorcery', NULL, NULL, '{U}', NULL, NULL, '/Web Dev Final/images/otc-112-serum-visions.jpg'),
(71, 'Talent of the Telepath', 'Sorcery', NULL, NULL, '{U}{U}{2}', NULL, NULL, '/Web Dev Final/images/ori-78-talent-of-the-telepath.jpg'),
(72, 'Tasha\'s Hideous Laughter', 'Sorcery', NULL, NULL, '{U}{U}{1}', NULL, NULL, '/Web Dev Final/images/afr-78-tasha-s-hideous-laughter.jpg'),
(73, 'Traumatize', 'Sorcery', NULL, NULL, '{U}{U}{3}', NULL, NULL, '/Web Dev Final/images/m14-77-traumatize.jpg'),
(74, 'Vandalblast', 'Sorcery', NULL, NULL, '{R}', NULL, NULL, '/Web Dev Final/images/otc-183-vandalblast.jpg'),
(75, 'Volcanic Torrent', 'Sorcery', NULL, NULL, '{R}{4}', NULL, NULL, '/Web Dev Final/images/otc-184-volcanic-torrent.jpg'),
(76, 'Windfall', 'Sorcery', NULL, NULL, '{U}{2}', NULL, NULL, '/Web Dev Final/images/otc-123-windfall.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `decks`
--

CREATE TABLE `decks` (
  `deck_id` int NOT NULL,
  `deck_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `owner_id` int NOT NULL,
  `card1` int DEFAULT NULL,
  `card2` int DEFAULT NULL,
  `card3` int DEFAULT NULL,
  `card4` int DEFAULT NULL,
  `card5` int DEFAULT NULL,
  `card6` int DEFAULT NULL,
  `card7` int DEFAULT NULL,
  `card8` int DEFAULT NULL,
  `card9` int DEFAULT NULL,
  `card10` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `decks`
--

INSERT INTO `decks` (`deck_id`, `deck_name`, `owner_id`, `card1`, `card2`, `card3`, `card4`, `card5`, `card6`, `card7`, `card8`, `card9`, `card10`) VALUES
(1, 'Test One', 1, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10),
(2, 'Test Two', 3, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20),
(3, 'Test Three', 1, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30),
(4, 'New Deck', 1, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40);

-- --------------------------------------------------------

--
-- Table structure for table `forum_threads`
--

CREATE TABLE `forum_threads` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forum_threads`
--

INSERT INTO `forum_threads` (`id`, `title`, `content`, `email`, `created_at`) VALUES
(1, 'I love Draftsman!!', 'This is my first thread and I\'m soooo excited to post it woweee thanks!', '', '2024-12-12 00:02:05'),
(2, 'My Email!!', 'Wow!! I was so excited last time I forgot to include my email on the forum!!!', 'myemail@email.gov', '2024-12-12 00:04:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `created_at`) VALUES
(1, 'hunter', '$2y$10$2HhJkcQoFv7sHGU6Nd5A3O/bAaLZE2sb5XMiRhYRN4kejM0RZyaVe', '2024-12-02 19:14:48'),
(3, 'test', '$2y$10$18LZWc5gPZUseGBt0.HjBO9jHK8uk4vPudwHzvwn8UHsliD60ZmcK', '2024-12-03 16:52:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`card_id`);

--
-- Indexes for table `decks`
--
ALTER TABLE `decks`
  ADD PRIMARY KEY (`deck_id`);

--
-- Indexes for table `forum_threads`
--
ALTER TABLE `forum_threads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `card_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `decks`
--
ALTER TABLE `decks`
  MODIFY `deck_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `forum_threads`
--
ALTER TABLE `forum_threads`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
