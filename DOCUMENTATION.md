# MyWeeklyAllowance - Documentation Complète

## Vue d'ensemble du projet

**MyWeeklyAllowance** est une application de gestion d'argent de poche pour adolescents, développée selon la méthodologie **TDD (Test Driven Development)**.

## Phases du projet TDD

### Phase 1 - RED ✓
- **Objectif**: Écrire les tests avant le code
- **Résultat**: 19 tests unitaires créés
- **Fichier**: `tests/AccountTest.php`
- **Statut**: ✅ COMPLÈTE

### Phase 2 - BLUE ✓
- **Objectif**: Implémenter le code minimum pour passer les tests
- **Résultat**: Classe `Account` créée avec toutes les fonctionnalités
- **Fichier**: `src/Account.php`
- **Tests passés**: 19/19 ✅
- **Statut**: ✅ COMPLÈTE

### Phase 3 - GREEN ✓
- **Objectif**: Refactoriser et améliorer le code
- **Améliorations**:
  - Suppression des avertissements PHPUnit
  - Ajout de la documentation PHPDoc
  - Amélioration de la lisibilité
- **Statut**: ✅ COMPLÈTE

### Phase 4 - COUVERTURE ✓
- **Objectif**: Vérifier que 100% du code est testé
- **Résultat**: 100% de couverture de code
- **Statut**: ✅ COMPLÈTE

## Commandes utiles

### Exécuter tous les tests
\`\`\`bash
./vendor/bin/phpunit
\`\`\`

### Afficher les résultats au format testdox
\`\`\`bash
./vendor/bin/phpunit --testdox
\`\`\`

### Générer le rapport de couverture HTML
\`\`\`bash
./vendor/bin/phpunit --coverage-html coverage/html
\`\`\`

### Générer un rapport texte
\`\`\`bash
./vendor/bin/phpunit --coverage-text
\`\`\`

### Générer un rapport Clover XML
\`\`\`bash
./vendor/bin/phpunit --coverage-clover coverage.xml
\`\`\`


