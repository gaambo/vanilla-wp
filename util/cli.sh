#!/bin/sh
# quotes around args is needed to pass args with quotes in them
docker compose run --rm cli "$@"