#!/bin/bash

php vendor/bin/doctrine-migrations "$@"  --db-configuration migrations-db-config.php