<?php

return [

	// menu items
	'admin:administer_utilities:change_text' => "Change Text",
	'admin:administer_utilities:deadlinks' => "Dead Links",
	
	// plugin settings
	'admin_tools:settings:deadlink:title' => "Dead link detection settings",
	'admin_tools:settings:deadlink:enabled' => "How often should dead links be detected",
	'admin_tools:settings:deadlink:created_before' => "Ignore content created in the past x days",
	'admin_tools:settings:deadlink:rescan' => "Rescan content after x days",
	'admin_tools:settings:deadlink:skipped_domains' => "Skip the following domains while checking for dead links",
	'admin_tools:settings:deadlink:skipped_domains:help' => "A comma separated list of domains to skip.",
	'admin_tools:settings:deadlink:include_skipped_domains' => "Include the skipped domains in de CSV-file",
	'admin_tools:settings:deadlink:include_success_results' => "Include successfull results in the CSV-file",
	'admin_tools:settings:deadlink:report_email' => "Send an additional report to the following e-mail address",
	'admin_tools:settings:deadlink:report_email:help' => "By default the site admins will receive a report.",
	'admin_tools:settings:deadlink:type_subtype' => "Content types to scan for dead links",
	
	// change text
	'admin_tools:change_text:warning' => "This function will change all occurrences of the given text in all text columns of the database tables.
It will use direct queries so there will be no system events that the data has been changed.
You might need to perform additional actions like flushing the cache or reindexing a search engine to make sure other parts of the system are aware of the changes.
There is no way to revert these specific changes, so make sure you have a backup.",
	
	'admin_tools:change_text:export' => "The exports will create a CSV file with all relevant data.
For more information use the extended export feature however keep in mind this could fail on large datasets.",
	'admin_tools:change_text:export:extended' => "Export extended data",
	
	'admin_tools:change_text:change' => "Change",
	'admin_tools:change_text:into' => "into",
	'admin_tools:change_text:preview' => "Found '%s' in",
	'admin_tools:change_text:execute' => "Execute",
	
	// switch admin <-> user
	'admin_tools:switch_to_user' => "Act as user",
	'admin_tools:switch_to_admin' => "Act as admin",
	
	// deadlinks
	'admin_tools:deadlinks:size' => "Size",
	
	// CLI
	'admin_tools:cli:change_text:description' => "Replace text in all text columns in the database",
	'admin_tools:cli:change_text:from' => "Text to replace",
	'admin_tools:cli:change_text:to' => "Text to change into",
	'admin_tools:cli:change_text:confirm' => "Are you sure you wish to replace all occurrences of %s with %s?",
	'admin_tools:cli:change_text:abort' => "Change aborted",
	'admin_tools:cli:change_text:success' => "Text has been changed for %s occurrences",
	
	// notifications
	'admin_tools:notification:deadlinks:setting' => "Receive a notification when dead links are found in content",
	'admin_tools:notification:deadlinks:subject' => "New dead links found in content",
	'admin_tools:notification:deadlinks:summary' => "New dead links found in content",
	'admin_tools:notification:deadlinks:body' => "The check for new dead links in the content has resulted in %d new dead links.

Check out the results here:
%s",
	
	// actions
	'admin_tools:action:toggle_admin:success:user' => "You're now a normal user",
	'admin_tools:action:toggle_admin:success:admin' => "You're now an admin again",
	
	'admin_tools:action:change_text:success' => "Replaced text in %s rows",
	
	'admin_tools:action:deadlink:delete:not_exists' => "The file or directory doesn't exist",
	'admin_tools:action:deadlink:delete:fail' => "An error occurred while deleting the file or directory",
	'admin_tools:action:deadlink:delete:success:directory' => "Successfully deleted the directory '%s'",
	'admin_tools:action:deadlink:delete:success:file' => "Successfully deleted the file '%s'",
	
	// upgrades
	'admin_tools:upgrade:2024010901:title' => "Restore admin functionality for switched admins",
	'admin_tools:upgrade:2024010901:description' => "Admins that have switched to normal user should have their admin rights restored",
];
