find . -type f -name '*.html' -print0 | while IFS= read -r -d '' f; do
  mv -- "$f" "${f%.html}.php"
done