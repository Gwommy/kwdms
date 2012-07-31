ALTER TABLE `attraction` ADD CONSTRAINT FOREIGN KEY (`kwds_id`) REFERENCES `kwds` (`id`);

ALTER TABLE `class`
    ADD CONSTRAINT FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`era_id`) REFERENCES `era` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`type_id`) REFERENCES `type` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`kwds_id`) REFERENCES `kwds` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`aerobic_id`) REFERENCES `aerobic` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`difficulty_id`) REFERENCES `difficulty` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`room_id`) REFERENCES `room` (`id`);

ALTER TABLE `coteacher` 
    ADD CONSTRAINT FOREIGN KEY (`class_id`) REFERENCES `class` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
    ENGINE = InnoDb;

ALTER TABLE `faq`
    ADD CONSTRAINT FOREIGN KEY (`kwds_id`) REFERENCES `kwds` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

ALTER TABLE `fees`
    ADD CONSTRAINT FOREIGN KEY (`kwds_id`) REFERENCES `kwds` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`fee_type_id`) REFERENCES `fee_type` (`id`);

ALTER TABLE `group` ADD CONSTRAINT FOREIGN KEY (`kingdom_id`) REFERENCES `kingdom` (`id`);

ALTER TABLE `kwds`
    ADD CONSTRAINT FOREIGN KEY (`group_id`) REFERENCES `group` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`kingdom_id`) REFERENCES `kingdom` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);

ALTER TABLE `password`
    ADD CONSTRAINT FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
    ENGINE = InnoDb;

ALTER TABLE `role`
    ADD CONSTRAINT FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`job_id`) REFERENCES `job` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`kwds_id`) REFERENCES `kwds` (`id`);

ALTER TABLE `room` ADD CONSTRAINT FOREIGN KEY (`kwds_id`) REFERENCES `kwds` (`id`);

ALTER TABLE `seminar`
    ADD CONSTRAINT FOREIGN KEY (`room_id`) REFERENCES `room` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`class_id`) REFERENCES `class` (`id`);

ALTER TABLE `update`
    ADD CONSTRAINT FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
    ENGINE = InnoDb;

ALTER TABLE `user`
    ADD CONSTRAINT FOREIGN KEY (`prefix_id`) REFERENCES `prefix` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`title_id`) REFERENCES `title` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`group_id`) REFERENCES `group` (`id`);