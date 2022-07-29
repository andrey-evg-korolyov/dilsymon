
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



