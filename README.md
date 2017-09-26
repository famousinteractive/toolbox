# Toolbox
Install a set of library

## Basic Installation

  - `composer require famousinteractive/toolbox`
  
  - In Laravel < 5.5 : Add `Famousinteractive\Toolbox\ToolboxServiceProvider::class` in config/app.php
  
  - Launch the command `famous:toolbox` 
  
## Using custom config file

   - You can use your own set of custom library by specifying the path to a json config file.
   
        `famous:toolbox --config=config.json`
    
   - The default content for the json files should follow this structure : 
    
    {
        "aws": {
            "description": "Install a set of library to use the face and scene rekognition on Amazon web services",
            "configkeys": [
                "AWS_REGION","AWS_KEY","AWS_SECRET","AWS_BUCKET"
            ],
            "path": "https://github.com/famousinteractive/toolbox-lib-aws/archive/master.zip"
        },
        "helper": {
            "description": "A lot of function nice to have as a helper to use easily in the view and wherever you need",
            "configkeys": [],
            "path": "https://github.com/famousinteractive/toolbox-lib-helper/archive/master.zip",
            "post-install": "Open you Providers/AppServiceProvider.php and add 'include __DIR__.'/../Libraries/Helper/famous.php';' in the register() method"
        },
        "httpcommunicator": {
            "description": "It's an helper for Guzzle providing basic method for RESTfull calls.",
            "configkeys": [],
            "path": "https://github.com/famousinteractive/toolbox-lib-httpcommunicator/archive/master.zip"
        },
        "dropbox": {
            "description": "Call using the dropbox API",
            "configkeys": ["DROPBOX_ACCESS_TOKEN"],
            "path": "https://github.com/famousinteractive/toolbox-lib-dropbox/archive/master.zip"
        },
        "auth": {
                "description": "A set of file to implement a custom and managable authentification system",
                "configkeys": ["auth_remember_token_cookie_name"],
                "post-install": "Read the README in the Auth directory. A lot of files need to be moved",
                "path": "https://github.com/famousinteractive/toolbox-lib-auth/archive/master.zip"
        }
    }
    
  - The path need to lead to a github zip (or at least, an zip archive like github do, with "master" in the name)
  
  
  