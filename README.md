# twitter_app
The project utilizes PHP, JavaScript, HTML, and CSS to complete the requirements. Almost no frameworks were used outside of jQuery and BootStrap, so most of the code is written by myself. The only outside files/frameworks I utilized were TwitterOAuth to make OAuth requests and API calls https://twitteroauth.com/, and I ripped an Autoload.php file from a wordpress theme. 

This app does not use MySQL because I did not see a need for it. Given that Twitter handles the user authentication, I only need to store the access token from Twitter. This means the SESSION is sufficient for storage. If the authentication was handled at my application's level, then a MySQL database would be needed to compare username/password combinations.

## How to Setup on Your Local
You can set this up on your local by running MAMP, or WAMP. I use MAMP. Once that is setup, you'll want to make sure it is hosting the server through port 80. You can probably just run the services manually if you have that setup already, MAMP just makes it easier. The versions of the services that I used are PHP 5.6.10 and Apache 2.2.29. It is necessary to change the base directory Apache points to to http://localhost/

Once the services are setup, you can download/clone the project. The project NEEDS to be cloned to a folder km/ inside of the base directory. So to visit the site, you will go to http://localhost/km/index.php. This is VERY important because the Twitter callback url points to this address, so you will not be able to authenticate with Twitter if this is incorrect. Once that is setup, you should be good to go running the application.

## How the Code is Setup 
The basic file structure has files that are more or less resources (.js, .css, .jpg, etc.), which are stored in the /inc folder in the base directory. All external libraries and files mentioned in the introduction are located in /inc/vendor/. The /inc folder has include files that setup constants I use throughout the application, and it includes a Debugger I made. The debugger is very simple but can be expanded in the future. The debugger outputs the contents of a variable when in debug mode (GET[dbg] is set, you can see this in include.php).

For ease of understanding the code, I separated the JS files by type (reqeusts, response, parser, etc.). In a real application these classes would be in one minified JS file, so the client can just try to retrieve one file.

The /fw directory is a directory I'm using as an interface bewteen the JavaScript front end and the PHP backend. All JS asynchronous requests will go through this page. This directory uses a .htaccess file to redirect all requests to the /fw/index.php file which breaks down the request, and calls the appropriate controller from the parameters.

The /twitter folder is the meat of the application. This is where the controllers, authentication, and different views lie. I basically setup an MVC from scratch, but it is not fully an MVC yet. Some other things need to be done before it can be considered that. 

Each page should be made with a class that subclasses Page.php. This class will indicate the css and js to include in the HTML header. It has a base function which outputs all the HTML to the screen. It does this by calling an action on the controller for that page.

The controllers have a base class BaseController. This class has basic authentication functions that initialize an authorization object and return it. The authorization object is going to be a sublclass of Auth.php. For this simple application, the auth object we will use everywhere is the TwitterAuth object. 

The page class uses the controller's auth object to authenticate the page. You can see this in Page.php in the drawContents function. This function calls an authorize function internal to page.php that calls a few hooks on the Auth object. Based on this, you can see it would be easy to switch out the auth object per page if necessary. This wouldn't necessarily be desired (switching from Twitter to Facebook auth object in the middle of the application), but it makes more sense if you were to create a more strict auth object that is a subclass of the TwitterAuth object.

The controllers can implement an interface called PageInterface located in the BaseController.php file. This interface has a simple function that tells the client the controller is meant to draw a view to the screen. Since there is only one page in this application (the home page), the home page controller is the only one that implements this interface (HomeController.php). The other controllers do not cast views to the screen, but interact with the Twitter API and are located in the Twitter folder.