#!/bin/sh

cd "$(dirname "$0")"
./classmap_generator.sh
./templatemap_generator.sh
