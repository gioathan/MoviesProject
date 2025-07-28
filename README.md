Run project in WSL.

Project is setted in docker.

Before you build the containers you will need a .env file in the scope where README.md is. the variable for the env are at the end of this README file.

You can build all the containers simply by running 'make up' in your terminal.

Make file contains other commands as well.

To create the db you need to run 'make db'

Everything will be ready and you will only need to open localhost:8000.

If by loading the page, this error shows up: Cache unable to write to "/var/www/html/writable/cache/".  Please run: make writable-permissions

.env:

CI_ENVIRONMENT = development

database.default.hostname = db
database.default.database = cidb
database.default.username = ciuser
database.default.password = cipassword
database.default.DBDriver = Postgre
database.default.port = 5432
database.default.DBPrefix =
database.default.pConnect = false
database.default.DBDebug = true
database.default.charset = utf8
database.default.DBCollat = utf8_general_ci

app.sessionDriver = 'CodeIgniter\Session\Handlers\FileHandler'
app.sessionSavePath = /var/www/html/writable/sessions
app.baseURL = 'http://localhost:8000/'