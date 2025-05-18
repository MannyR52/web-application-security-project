#!/bin/bash

# File paths
HASH_FILE="md5hashes.txt"
WORDLIST="rockyou.txt"
OUTPUT_FILE="cracked_output.txt"

# Confirm files exist
if [[ ! -f "$HASH_FILE" ]]; then
  echo "❌ Hash file '$HASH_FILE' not found!"
  exit 1
fi

if [[ ! -f "$WORDLIST" ]]; then
  echo "❌ Wordlist '$WORDLIST' not found!"
  exit 1
fi

# Run hashcat
echo "Running hashcat on '$HASH_FILE' with wordlist '$WORDLIST'..."
hashcat -m 0 -a 0 "$HASH_FILE" "$WORDLIST" --force --quiet

# Show results
echo -e "\nCracked hashes:"
hashcat -m 0 -a 0 "$HASH_FILE" "$WORDLIST" --force --show > "$OUTPUT_FILE"
cat "$OUTPUT_FILE"

# TO RUN:
# chmod +x crack_md5.sh
# ./crack_md5.sh
