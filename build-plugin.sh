#!/bin/bash

# Build WordPress plugin zip file for Sports Court Designer

PLUGIN_NAME="sports-court-designer"
ZIP_FILE="../${PLUGIN_NAME}.zip"

echo "Building WordPress plugin: ${PLUGIN_NAME}.zip"

# Remove old zip if exists
rm -f "$ZIP_FILE"

# Create zip with all plugin files
# - Excludes git files, DS_Store, and development files
# - Excludes screenshots (they go in SVN repo only)
# - Excludes shop drawings (internal documentation)
# - Files are added at root level (WordPress requirement)
zip -r "$ZIP_FILE" . \
    -x "*.git*" \
    -x "*.DS_Store" \
    -x "node_modules/*" \
    -x "*.sh" \
    -x "test.html" \
    -x "*.log" \
    -x "*.bak" \
    -x "*~" \
    -x "screenshot-*.png" \
    -x "shop-drawings/*"

echo "Plugin built: ${ZIP_FILE}"
echo "Upload this file to WordPress Plugins → Add New → Upload Plugin"