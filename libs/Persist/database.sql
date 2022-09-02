
-- --------------------------------------------------------

--
--`disk` table structure
--

CREATE TABLE `disk` (
  `id` int NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `filesystem` text NOT NULL,
  `used` int NOT NULL,
  `total` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Stored Table Indexes
--

--
-- `disk` table indexes
--
ALTER TABLE `disk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for saved tables
--

--
-- AUTO_INCREMENT for table `disk`
--
ALTER TABLE `disk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;


-- --------------------------------------------------------

--
-- `load_average` table structure
--

CREATE TABLE `load_average` (
  `id` int NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `min_1` int NOT NULL,
  `min_5` int NOT NULL,
  `min_15` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Stored Table Indexes
--

--
-- Table indexes `load_average`
--
ALTER TABLE `load_average`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for saved tables
--

--
-- AUTO_INCREMENT for `load_average` table
--
ALTER TABLE `load_average`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;



