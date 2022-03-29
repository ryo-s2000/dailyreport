#!/bin/sh

echo '***** start befor_commit *****'

echo '--- start format ---'
composer format
echo '--- end format ---'

echo '--- start test ---'
composer test
echo '--- end test ---'

echo '--- start static code analysis ---'
composer analysis
echo '--- end static code analysis ---'

echo '***** end befor_commit *****'
