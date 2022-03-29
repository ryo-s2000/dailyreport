#!/bin/sh

echo '***** start befor_commit *****'

echo '\n--- start static code analysis ---'
composer analysis
echo '--- end static code analysis ---\n'

echo '\n--- start alter issues ---'
composer analysis_alter_issues
echo '--- end start auto fix ---\n'

echo '\n--- start format ---'
composer format
echo '--- end format ---\n'

echo '\n--- start test ---'
composer test
echo '--- end test ---\n'

echo '***** end befor_commit *****'
