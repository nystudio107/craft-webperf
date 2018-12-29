#!/usr/bin/env bash
BOOMERANG_BASE_DIR="../../../node_modules/boomerangjs"
BOOMERANG_PLUGINS_JSON_DIR="src/json"
BOOMERANG_PLUGINS_JS_DIR="src/js"
BOOMERANG_DIST_DIR="dist/js"
WORKING_DIR=$(pwd)
PLUGINS_FILE="plugins.json"
COPY_PLUGIN_JS_FILES=(
  "webperf-boomer-init.js"
)
COPY_BUILD_FILES=(
  "boomerang-1.0.0.min.js"
  "boomerang-1.0.0.min.js.map"
)

if [[ ! -f "${BOOMERANG_BASE_DIR}/${PLUGINS_FILE}.bak" ]]; then
    echo "Backing up ${BOOMERANG_BASE_DIR}/${PLUGINS_FILE}"
    cp "${BOOMERANG_BASE_DIR}/${PLUGINS_FILE}" "${BOOMERANG_BASE_DIR}/${PLUGINS_FILE}.bak"
fi

echo "Copying ${BOOMERANG_PLUGINS_JSON_DIR}/${PLUGINS_FILE} to ${BOOMERANG_BASE_DIR}/${PLUGINS_FILE}"
cp "${BOOMERANG_PLUGINS_JSON_DIR}/${PLUGINS_FILE}" "${BOOMERANG_BASE_DIR}/${PLUGINS_FILE}"

for file in "${COPY_PLUGIN_FILES[@]}"
do
  echo "Copying ${BOOMERANG_PLUGINS_JS_DIR}/${file} to ${BOOMERANG_BASE_DIR}/plugins/${file}"
  cp "${BOOMERANG_PLUGINS_JS_DIR}/${file}" "${BOOMERANG_BASE_DIR}/plugins/${file}"
done

echo "Building Boomerang"
cd "${BOOMERANG_BASE_DIR}"
grunt clean build --build-number="0" --build-revision="0"

cd "${WORKING_DIR}"
for file in "${COPY_BUILD_FILES[@]}"
do
  echo "Copying ${BOOMERANG_BASE_DIR}/build/${file} to ${BOOMERANG_DIST_DIR}/${file}"
  cp "${BOOMERANG_BASE_DIR}/build/${file}" "${BOOMERANG_DIST_DIR}/${file}"
done

exit 0
