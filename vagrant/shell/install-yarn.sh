#!/bin/sh

export DEBIAN_FRONTEND=noninteractive

YARN_KEY_PATH="/tmp/yarn-pubkey.gpg"

curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg -o $YARN_KEY_PATH && apt-key add $YARN_KEY_PATH
echo "deb https://dl.yarnpkg.com/debian/ stable main" > /etc/apt/sources.list.d/yarn.list

apt-get update && apt-get install -y -q yarn
