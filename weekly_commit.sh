#!/bin/bash

# Mensagem de commit com a data da semana
COMMIT_MSG="Weekly auto-commit - $(date '+%Y-%m-%d')"

git add .
git commit -m "$COMMIT_MSG"
git push origin main
