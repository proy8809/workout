#!/bin/bash

NETWORK=workout

if ! docker network inspect "${NETWORK}" >/dev/null 2>&1; then
    docker network create --driver bridge ${NETWORK}
fi

docker compose -p workout-tracker up -d --force-recreate --build
