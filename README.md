# common
Common code for BicycleClubWebsite2023 and other private web apps

This repository can be used for any phpfui/phpfui based website and implements some basic functionality.  It should not be considered a general purpose repo but can be used as an example of using phpfui components.

To add this common repo to your project, you should add the following lines to your composer.json file:

```json
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/phpfui/common"
        }
    ],
    "require": {
        "phpfui/common": "dev-main"
    }
```

This repo is not versioned.
