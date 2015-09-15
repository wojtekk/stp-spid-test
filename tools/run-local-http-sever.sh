#!/usr/bin/env bash
echo "Remember about add '127.0.0.1 local.i.bt.no' to /etc/hosts"
DIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
cd "$DIR/../web/"
sudo php -S local.i.bt.no:80