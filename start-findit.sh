#!/usr/bin/env bash
set -euo pipefail

PROJECT_DIR="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" && pwd)"
cd "$PROJECT_DIR"

export FINDIT_DB_HOST="${FINDIT_DB_HOST:-127.0.0.1}"
export FINDIT_DB_PORT="${FINDIT_DB_PORT:-3306}"
export FINDIT_DB_NAME="${FINDIT_DB_NAME:-findit}"
export FINDIT_DB_USER="${FINDIT_DB_USER:-findit_app}"

if [[ -z "${FINDIT_DB_PASSWORD:-}" ]]; then
    read -r -s -p "FindIt database password: " FINDIT_DB_PASSWORD
    echo
    export FINDIT_DB_PASSWORD
fi

echo "FindIt is running at http://localhost:8000"
echo "Stop the server with Ctrl+C."
php -S localhost:8000
