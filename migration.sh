#!/bin/bash

docker-compose exec php php vendor/bin/doctrine-migrations "$@" --configuration migrations.xml --db-configuration migrations-db-config.php