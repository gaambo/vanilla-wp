#!/bin/sh
docker-compose -f ./docker-compose.development.yml run --rm wpcli $@