--
-- Structure for table `knuckles_people`
--

CREATE TABLE `knuckles_people` (
  `ppl_id` int NOT NULL,
  `ppl_name` varchar(100) NOT NULL,
  `ppl_age` tinyint NOT NULL,
  `ppl_states_visited` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for table `form_data`
--
ALTER TABLE `knuckles_people`
  ADD PRIMARY KEY (`ppl_id`);

ALTER TABLE `knuckles_people`
  MODIFY `ppl_id` int NOT NULL AUTO_INCREMENT;
COMMIT;
