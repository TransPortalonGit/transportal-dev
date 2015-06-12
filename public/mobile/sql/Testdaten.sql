
INSERT INTO users (username, email, first_name, last_name, company) 
VALUES('lucy', 'zelada@tzi.de', 'Luselia', 'Zelada Lopez', 'Uni Bremen') 
ON DUPLICATE KEY UPDATE username=VALUES(username);

INSERT INTO projects (user_id, title,content,files)
VALUES (
(SELECT id FROM users WHERE username = 'lucy' LIMIT 1), 
'Mein erstes Projekt',
'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.',
'/uploads/projects/3/images/137070166751b33f637a79f.png')
ON DUPLICATE KEY UPDATE title=VALUES(title);

INSERT INTO projects (user_id, title,content,files)
VALUES (
(SELECT id FROM users WHERE username = 'lucy' LIMIT 1), 
'Mein zweites Projekt',
'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.',
'/uploads/projects/12/images/139098811652e8cb54cec4f.png')
ON DUPLICATE KEY UPDATE title=VALUES(title);

INSERT INTO projects (user_id, title,content,files)
VALUES (
(SELECT id FROM users WHERE username = 'lucy' LIMIT 1), 
'Mein drites Projekt',
'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.',
'/uploads/projects/52/images/139463560153207351f012a.png')
ON DUPLICATE KEY UPDATE title=VALUES(title);

