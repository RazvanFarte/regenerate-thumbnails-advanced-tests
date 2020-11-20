#! /usr/bin/env bash

source .env

curl -s -X POST -H "Content-Type: application/json" -H "Accept: application/json" -H "Travis-API-Version: 3" -H "Authorization: token $TRAVIS_DEBUG_TOKEN" -d '{ "quiet": true }' https://api.travis-ci.com/job/$1/debug