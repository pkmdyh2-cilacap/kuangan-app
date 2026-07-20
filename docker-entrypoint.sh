#!/bin/bash
set -e

# Generate .env from Render environment variables
cat > /var/www/html/.env <<EOF
CI_ENVIRONMENT = ${CI_ENVIRONMENT:-production}
app.baseURL = '${app.baseURL:-https://kuangan-app.onrender.com}'
database.default.hostname = ${database.default.hostname:-}
database.default.database = ${database.default.database:-postgres}
database.default.username = ${database.default.username:-}
database.default.password = ${database.default.password:-}
database.default.DBDriver = ${database.default.DBDriver:-Postgre}
database.default.DBPrefix = ${database.default.DBPrefix:-}
database.default.port = ${database.default.port:-5432}
database.default.charset = ${database.default.charset:-utf8}
database.default.DBCollat = ${database.default.DBCollat:-}
database.default.DSN = ${database.default.DSN:-}
database.default.schema = ${database.default.schema:-public}
encryption.key = ${encryption.key:-}
EOF

chown www-data:www-data /var/www/html/.env

exec apache2-foreground
