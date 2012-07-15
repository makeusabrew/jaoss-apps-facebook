<?php
PathManager::loadPaths(
    array("/", "index")
);


/**
 * we conditionally load a few paths to make testing various bits of
 * Facebook logic a lot simpler. It's not ideal doing it like this;
 * of course, if you'd prefer you can split these paths out into a
 * separate app and only load the app in 'test' mode or similar.
 */
if (!Settings::getValue("facebook", "allow_test_iframe", false)) {
    return;
}

PathManager::loadPaths(
    array("/test/iframe", "iframe", "Test"),
    array("/test/auth", "auth", "Test"),
    array("/test/encode", "encode", "Test")
);
