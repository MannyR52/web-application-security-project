#!/bin/bash

# File paths
HASH_FILE="bcryptHashes.txt"
WORDLIST="rockyou.txt"
OUTPUT_FILE="bcrypt_cracked.txt"

# Check if hash file exists
if [[ ! -f "$HASH_FILE" ]]; then
    echo "Hash file $HASH_FILE not found!"
    exit 1
fi

# Check if wordlist exists
if [[ ! -f "$WORDLIST" ]]; then
    echo "Wordlist $WORDLIST not found!"
    exit 1
fi

# Run hashcat using bcrypt mode (-m 3200)
hashcat -m 3200 -a 0 "$HASH_FILE" "$WORDLIST" --outfile="$OUTPUT_FILE" --force

# Wait until cracking is done
hashcat --show -m 3200 "$HASH_FILE" --outfile="$OUTPUT_FILE"

# Show cracked results
echo "Cracked bcrypt hashes:"
cat "$OUTPUT_FILE"

# TO RUN:
# chmod +x crack_bcrypt.sh
# ./crack_bcrypt.sh


