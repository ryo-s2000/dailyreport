#!/bin/sh

echo '***** start befor_commit *****'

echo '--- start format ---'
composer format
echo '--- end format ---'

echo '***** end befor_commit *****'
