Usage:
---------------

1. Create a web-accessible directory for the presentation
2. Download the latest from the impress.js repo (https://github.com/bartaz/impress.js/)
3. Make the /js and /css directory off the web root and copy the impress js & css files in
4. Execute "php impress-gen.php" and the impress presentation file will be outputted

in docroot:
/index.html <-- generated presentation

/css/impress-demo.css

/js/impress.js

Pathing is hard-coded for now, but there's plans to change that in the future.
Full Markdown support HAS NOT been implemented (yet)

Chris Cornutt <ccornutt@phpdeveloper.org>
MIT license
