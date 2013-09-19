ALTER TABLE tb_documents modify document_type VARCHAR(100);

ALTER TABLE `celestic`.`tb_documents` CHARACTER SET = utf8 , COLLATE = utf8_general_ci ;

ALTER TABLE `celestic`.`tb_documents` CHANGE COLUMN `document_description` `document_description` TEXT NOT NULL  ;
