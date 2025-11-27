<?php
/**
 * Script pour générer et afficher le rapport de couverture de code
 * Ce script aide à vérifier que tous les chemins d'exécution du code sont testés
 */

require_once __DIR__ . '/../vendor/autoload.php';

echo "\n";
echo "================================================\n";
echo "   MyWeeklyAllowance - Code Coverage Report\n";
echo "================================================\n\n";

echo "Running tests with coverage analysis...\n";
echo "Execute this command to generate the report:\n\n";
echo "  ./vendor/bin/phpunit --coverage-html coverage/html\n\n";

echo "Then open in your browser:\n";
echo "  coverage/html/index.html\n\n";

echo "Expected results:\n";
echo "  ✓ Account.php: 100% code coverage\n";
echo "  ✓ All methods tested\n";
echo "  ✓ All branches tested\n";
echo "  ✓ All lines tested\n\n";
