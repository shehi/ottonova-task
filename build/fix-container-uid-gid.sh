#!/usr/bin/env bash
set -e

# this script must be called with root permissions
if [[ $(id -g audith) != $2 || $(id -u audith) != $1 ]]; then
    groupmod -g $2 audith
    usermod -u $1 -g $2 audith
fi;

mkdir -p /home/audith
chown -R audith:audith /home/audith
