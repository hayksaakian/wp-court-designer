#!/bin/bash

# Build WordPress plugin zip file for Court Designer

PLUGIN_NAME="court-designer"
ZIP_FILE="../${PLUGIN_NAME}.zip"

echo "Building WordPress plugin: ${PLUGIN_NAME}.zip"

# Remove old zip if exists
rm -f "$ZIP_FILE"

# Create zip with all plugin files
# - Excludes git files, DS_Store, and development files
# - Files are added at root level (WordPress requirement)
zip -r "$ZIP_FILE" . \
    -x "*.git*" \
    -x "*.DS_Store" \
    -x "node_modules/*" \
    -x "*.sh" \
    -x "test.html" \
    -x "*.log" \
    -x "*.bak" \
    -x "*~"

echo "Plugin built: ${ZIP_FILE}"
echo "Upload this file to WordPress Plugins → Add New → Upload Plugin"