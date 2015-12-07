# BacklogBusters
Fitting backlogged Steam games into your schedule.

To set up this website on your own machine, the following steps are required:
1. Set up an apache server to run the site off of. For development and testing purposes, the XAMPP suite (for Windows) or the MAMP suite (for Mac) are highly recommended, for comparatively easy installation as well as built-in MySQL integration.
2. Set up an SQL database on that server, and use the SQL commands stored in either DatabaseStructure.txt or DatabaseStructureAndData.txt depending on if you want the bare-bones structure of the Database or a version with some data already included. This can be done from command line, or more easily through PHPMyAdmin's import feature (PHPMyAdmin is also included with XAMPP and MAMP).
3. Place the rest of the site files in the directory the Apache server points to by default. For example, in XAMPP, this would be in XAMPP/htdocs. This will cause localhost/index.php to redirect to the site.