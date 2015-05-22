#!/bin/sh
cd ../src/assets/
pm2 start node_modules/athene2-editor/server/server.js --node-args="----expose_gc --gc_global"