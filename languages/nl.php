<?php
/**
 * This file was created by Translation Editor v13.0
 * On 2024-01-09 14:17
 */

return array (
  'admin_tools:upgrade:2024010901:title' => 'Herstel beheer functionaliteiten voor gewisselde beheerders',
  'admin_tools:upgrade:2024010901:description' => 'Beheerders welke waren gewisseld naar gewone gebruiker moeten hun beheerrechten weer terug krijgen',
  'admin_tools:settings:deadlink:include_skipped_domains' => 'Neem de overgeslagen domeinen op in het CSV-bestand',
  'admin_tools:settings:deadlink:include_success_results' => 'Neem de succesvolle resultaten op in het CSV-bestand',
  'admin:administer_utilities:deadlinks' => 'Dode Links',
  'admin_tools:settings:deadlink:title' => 'Dode link detectie instellingen',
  'admin_tools:settings:deadlink:enabled' => 'Hoe vaak moeten dode links worden gedetecteerd',
  'admin_tools:settings:deadlink:created_before' => 'Negeer content aangemaakt is de laatste x dagen',
  'admin_tools:settings:deadlink:rescan' => 'Herhaal de detectie na x dagen',
  'admin_tools:settings:deadlink:skipped_domains' => 'Sla de volgende domeinen over tijdens het detecteren van dode links',
  'admin_tools:settings:deadlink:skipped_domains:help' => 'Een komma gescheiden lijst van domeinen om over te slaan.',
  'admin_tools:settings:deadlink:report_email' => 'Stuur een additioneel rapport na het volgende e-mail adres',
  'admin_tools:settings:deadlink:report_email:help' => 'Standaard ontvangen de site beheerders een rapport.',
  'admin_tools:settings:deadlink:type_subtype' => 'Bij welke content types moet er worden gecontroleerd op dode links',
  'admin_tools:deadlinks:size' => 'Grootte',
  'admin_tools:notification:deadlinks:setting' => 'Ontvang een notificatie als er dode links worden gevonden in content',
  'admin_tools:notification:deadlinks:subject' => 'Nieuwe dode links gevonden in content',
  'admin_tools:notification:deadlinks:summary' => 'Nieuwe dode links gevonden in content',
  'admin_tools:notification:deadlinks:body' => 'De controle op nieuwe dode links in de content heeft %d nieuwe dode links opgeleverd.

Het resultaat is hier te bekijken:
%s',
  'admin_tools:action:deadlink:delete:not_exists' => 'Het bestand of de map bestaat niet',
  'admin_tools:action:deadlink:delete:fail' => 'Er is een fout opgetreden tijdens het verwijderen van het bestand of de map',
  'admin_tools:action:deadlink:delete:success:directory' => 'De map \'%s\' is succesvol verwijderd',
  'admin_tools:action:deadlink:delete:success:file' => 'Het bestand \'%s\' is succesvol verwijderd',
  'admin_tools:change_text:export:extended' => 'Exporteer uitgebreide data',
  'admin_tools:change_text:export' => 'De exports maken een CSV bestand met alle relevante data.
Voor meer informatie gebruik de uitgebreide export actie, houdt er echter rekening mee dat dit kan mislukken bij grote datasets.',
  'admin:administer_utilities:change_text' => 'Tekst wijzigen',
  'admin_tools:change_text:warning' => 'Deze functie zal de opgegeven tekst in alle tekstkolommen in de database vervangen. Het gebruikt directe database queries en daardoor worden er geen systeem events getriggerd om te vertellen dat inhoud is gewijzigd. Het is dus mogelijk noodzakelijk om aanvullende acties te doen zoals het wissen van de cache of het herindexeren van een zoekmachine. Er is geen mogelijkheid om deze wijziging ongedaan te maken, dus zorg voor een backup.',
  'admin_tools:change_text:change' => 'Verander',
  'admin_tools:change_text:into' => 'in',
  'admin_tools:change_text:preview' => '\'%s\' gevonden in',
  'admin_tools:change_text:execute' => 'Uitvoeren',
  'admin_tools:cli:change_text:description' => 'Vervang tekst in alle tekstkolommen in de database',
  'admin_tools:cli:change_text:from' => 'Text om te vervangen',
  'admin_tools:cli:change_text:to' => 'Nieuwe waarde',
  'admin_tools:cli:change_text:confirm' => 'Weet je zeker dat je alle gevallen van %s wilt vervangen met %s?',
  'admin_tools:cli:change_text:abort' => 'Wijziging geannuleerd',
  'admin_tools:cli:change_text:success' => 'Tekst is gewijzigd voor %s gevallen',
  'admin_tools:action:change_text:success' => 'Tekst vervangen in %s gevallen',
  'admin_tools:switch_to_user' => 'Word gebruiker',
  'admin_tools:switch_to_admin' => 'Word beheerder',
  'admin_tools:switched_admins:title' => 'Beheerders die tijdelijk gewone gebruiker zijn',
  'admin_tools:switched_admins:none' => 'Op dit moment zijn er geen beheerders die tijdelijk gewone gebruiker zijn',
  'admin_tools:action:toggle_admin:success:user' => 'Je bent nu een gebruiker',
  'admin_tools:action:toggle_admin:success:admin' => 'Je bent nu weer beheerder',
);
