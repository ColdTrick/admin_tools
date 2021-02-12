<?php

return array (
  'admin:administer_utilities:change_text' => 'Modifier le texte',
  'admin_tools:change_text:warning' => 'Cette fonction modifiera toutes les occurrences du texte donné dans toutes les colonnes de texte des tables de la base de données.
Elle utilisera des requêtes directes de sorte qu\'il n\'y aura pas d\'événements système indiquant que les données ont été modifiées.
Vous devrez peut-être effectuer des actions supplémentaires, comme vider le cache ou réindexer un moteur de recherche, pour vous assurer que les autres parties du système sont au courant des modifications.
<strong>Il n\'y a aucun moyen d\'annuler ces changements spécifiques, alors assurez-vous d\'avoir une sauvegarde.</strong>',
  'admin_tools:change_text:change' => 'Modifier',
  'admin_tools:change_text:into' => 'dans',
  'admin_tools:change_text:preview' => 'Trouvé \'%s\' dans',
  'admin_tools:change_text:execute' => 'Exécuter',
  'admin_tools:switch_to_user' => 'Mode utilisateur',
  'admin_tools:switch_to_admin' => 'Mode administrateur',
  'admin_tools:switched_admins:title' => 'Administrateurs qui sont passés temporairement comme utilisateur normal',
  'admin_tools:switched_admins:none' => 'Actuellement, il n\'y a pas d\'administrateurs qui sont passés en utilisateur normal',
  'admin_tools:cli:change_text:description' => 'Remplacer le texte dans toutes les colonnes de texte de la base de données',
  'admin_tools:cli:change_text:from' => 'Texte à remplacer',
  'admin_tools:cli:change_text:to' => 'Texte à modifier en',
  'admin_tools:cli:change_text:confirm' => 'Êtes-vous sûr de vouloir remplacer toutes les occurrences de %s par des %s ?',
  'admin_tools:cli:change_text:abort' => 'Changement abandonné',
  'admin_tools:cli:change_text:success' => 'Le texte a été modifié pour les occurrences %s',
  'admin_tools:action:toggle_admin:success:user' => 'Vous agissez maintenant comme utilisateur normal',
  'admin_tools:action:toggle_admin:success:admin' => 'Vous agissez à nouveau comme administrateur',
  'admin_tools:action:change_text:success' => 'Remplacement du texte dans les lignes %s',
);
