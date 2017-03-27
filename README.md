fablabmanager
=============

A Symfony project created on March 9, 2017, 3:29 pm.

mysql.server start

php bin/console doctrine:schema:create --dump-sql
php bin/console doctrine:schema:drop --force; php bin/console doctrine:schema:update --force
php bin/console doctrine:generate:entity
php bin/console generate:bundle

php bin/console server:start

SELECT * FROM produit p LEFT JOIN (SELECT produit_id, sum(`price`) FROM `achat` group by produit_id) d ON d.produit_id = p.id

