-- Inserting users into CGStudio
USE team3;

-- Administrator
-- Password : password
INSERT INTO users VALUES (NULL, 'admin', '54d8545f55bca7df241a32cef4850e08','Administrator','No Last Name', 0, NOW(), NOW());

-- Product Manager
-- Password : password
INSERT INTO users VALUES (NULL, 'manager', '54d8545f55bca7df241a32cef4850e08','Product Manager','No Last Name', 1, NOW(), NOW());
