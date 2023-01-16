# Document-Management-Enterprise-Resource-Planner

## What is this ERP?
First, an Enterprise Resource Planner or ERP is a system that is designed to manage day to day activites at an organization. This is a very small-scale simulation of how a document management ERP (for securely storing, modifying, updating, archiving) would work. Since this was built for an Enterprise Software Engineering course, it had set specifications that were expected out of this system. However, there are still many other features a system like this would need for it to be used in the corporate world.

### Disclaimer
This project was built over the course of 2 months, and was designed to the format of a specific document type, and api that our professor used to demonstrate the power of ERPs, and test our ability to build them. This was built in a learning environemnt so it lacks any form of security and authentication to protect any data stored on it. 

## How does it work?
This system is a fairly simple web-based interface that allows a user to upload documents, search for them, and view them. It uses an api built by our professor to pull new documents at any given time, and then will automatically send the data to the database, as well as handle and errors that may be thrown its way. If the documents all follow the conventional system that this was built for (or how an organation may standardize their documents), it also has the ability to analyze said documents. It can tell how many unique loans numbers have been created, what associated documents they contain, what documents they may be missing, how many of them there are, etc. Overall, this is a simple yet powerful way to show the roots of how powerful a document management system can really be.

## How do I set it up?
This system was build using the LEMP stack. Specifically, Ubuntu Server 22, PHP 8.1, Nginx, and MySQL server, so those softwares will need to be installed first to set this up.
After this, you would need to copy the contents of the main folder on this repository into the server's /var/www/html folder.
Next, you would need to create a new database that matches the pattern detailed throughout the code, and populate it with your data. 
Lastly, if the api that was used to pull files was still up, you would want to set up CRON jobs on your system to automatically run the different aspects of this sfotware as needed.

## How can this be improved in the future?
### Security
As this project is a simple simulation of how a document management system might work, it lacks almost all forms of modern security. The first step would be to build     and authentication system for this code to use. Secondly, we would want to encrypt all data in our database so that in the event of breaches the data can still be       protected. Along with that there are many other small cybersecurity fixes we would want to implement into to the system so that it will protect its user's data, but also follow any and all compliance and privacy regulations for the country that the system is used in.
## New Features
Given that this ERP was built in just 2 short months while also learning how ERP's actually work, and building projects for other classes, there are definitely many     features that are missing from this system that would be useful in the business world. For instance, logging who accesses which files, at what time, what did they       change, etc.
