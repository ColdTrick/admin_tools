<?php

return [

	'admin:administer_utilities:change_text' => "Change Text",
	
	'admin_tools:change_text:warning' => "This function will change all occurences of the given text in all text columns of the database tables.
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
	
	'admin_tools:switch_to_user' => "Act as user",
	'admin_tools:switch_to_admin' => "Act as admin",
	
	'admin_tools:switched_admins:title' => "Admins who have temporarily switched to a normal user",
	'admin_tools:switched_admins:none' => "Currently there are no admins who switched to normal user",
	
	// CLI
	'admin_tools:cli:change_text:description' => "Replace text in all text columns in the database",
	'admin_tools:cli:change_text:from' => "Text to replace",
	'admin_tools:cli:change_text:to' => "Text to change into",
	'admin_tools:cli:change_text:confirm' => "Are you sure you wish to replace all occurences of %s with %s?",
	'admin_tools:cli:change_text:abort' => "Change aborted",
	'admin_tools:cli:change_text:success' => "Text has been changed for %s occurrences",
	
	// actions
	'admin_tools:action:toggle_admin:success:user' => "You're now a normal user",
	'admin_tools:action:toggle_admin:success:admin' => "You're now an admin again",
	
	'admin_tools:action:change_text:success' => "Replaced text in %s rows",
];
