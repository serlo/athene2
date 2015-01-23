#!/bin/sh

sudo killall hhvm
sudo hhvm --mode server -vServer.Type=fastcgi -vServer.Port=9000