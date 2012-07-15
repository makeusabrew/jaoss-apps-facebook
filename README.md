# Facebook

A simple application demonstrating server side authentication with Facebook
for canvas apps and page tabs, and *very* basic graph API interaction.

The app comes with test handlers for both authentication and graph API interaction,
allowing for fully automated testing by mocking the various Facebook endpoints.

Several test routes are exposed which wrap the main application in an iframe -
just as on facebook.com - allowing developers to interactively submit POST requests
with various ```signed_request``` values, as well as generating their own - completely
circumventing the need to constantly check the app within a Facebook iframe.

## Required Settings

```
[facebook]
app_id=(int)
app_secret=(string)
page_url=(string)

### Optional Settings (required to run tests)

```
[facebook]
allow_test_iframe=(bool)
auth_handler=(live|test)
graph_handler=(live|test)
```

The app secret and app ID can be any values in test mode. The ```page_url``` property
must redirect back to your own test application.

## Usage

see ```controllers/facebook.php``` - specifically the init method.

## Tests

```phpunit apps/facebook``` - 90.27%
