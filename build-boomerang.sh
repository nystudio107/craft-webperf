#!/usr/bin/env bash
BOOMERANG_BASE_DIR="node_modules/boomerangjs"
PLUGINS_FILE="plugins.json"

if [[ ! -f "${BOOMERANG_BASE_DIR}/${PLUGINS_FILE}.bak" ]]; then
    echo "Backing up ${BOOMERANG_BASE_DIR}/${PLUGINS_FILE}"
    cp "${BOOMERANG_BASE_DIR}/${PLUGINS_FILE}" "${BOOMERANG_BASE_DIR}/${PLUGINS_FILE}.bak"
fi

echo "Copying ${PLUGINS_FILE} to ${BOOMERANG_BASE_DIR}/${PLUGINS_FILE}"
cp "${PLUGINS_FILE}" "${BOOMERANG_BASE_DIR}/${PLUGINS_FILE}"

echo "Building Boomerang"
cd "${BOOMERANG_BASE_DIR}"
grunt build

exit 0
