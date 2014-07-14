# IS3.in URL Shortner API v1
IS3.in is a URL shortner service. The API gives full flexibility over the usage. In-depth analytics are provided.

##Documentation:
Documentation at [docs.is3.in](http://docs.is3.in)

##RESOURCES:
[API Library(zip compression)](https://github.com/is3in/IS3-API/zipball/master/), 
[API Library(tar compression)](https://github.com/is3in/IS3-API/tarball/master/), 
[License](./LICENSE)

##FEATURES:

+ Shortened urls can be logged under an account.
+ Full user history.
+ Efficient click logging.

##Allowed HTTPs requests:

+ `POST` - To create or update resource
+ `GET` - Get a resource or list of resources
+ `DELETE` - DELETE resources

##Description Of Usual Server Responses:

+ `200` OK - the request was successful.
+ `206` Partial Content - the server is delivering only part of the resource to the client(usually if a scope is undefined but the request was OK).
+ `400` Bad Request - the request could not be understood or was missing required parameters.
+ `401` Unauthorized - authentication failed or user doesn't have permissions for requested operation.
+ `404` Not Found - resource was not found.
+ `410` Gone - the resource was deleted.
+ `404` Not Found - resource was not found.
+ `503` Service Unavailable - the server failed to process.

##Supported Browser Logging:

+ Internet Explorer
+ Firefox
+ Safari
+ Chrome
+ Opera
+ Netscape
+ Maxthon
+ Konqueror
+ Handheld Browser(Unknown Browser)

##Supported Platforms Logging:

+ Windows 8.1
+ Windows 8
+ Windows 7
+ Windows Vista
+ Windows Server 2003/XP x64
+ Windows XP
+ Windows 2000
+ Windows ME
+ Windows 98
+ Windows 95
+ Windows 3.11
+ Mac OS X
+ Mac OS 9
+ Linux
+ Ubuntu
+ iPhone
+ iPod
+ iPad
+ Android
+ BlackBerry
+ Mobile+
+ Unknown 

## License

This library is distributed under the MIT license found in the [LICENSE](./LICENSE)
file.