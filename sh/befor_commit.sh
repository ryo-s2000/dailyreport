#!/bin/sh

echo '***** start befor_commit *****'

echo '--- start format ---'
composer format
echo '--- end format ---'

echo '--- start test ---'
composer test
echo '--- end test ---'

echo '***** end befor_commit *****'
