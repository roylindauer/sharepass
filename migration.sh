#!/bin/bash

php vendor/bin/doctrine-migrations "$@" --configuration migrations.xml --db-configuration migrations-db-config.php