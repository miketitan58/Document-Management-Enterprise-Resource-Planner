# Document-Management-Enterprise-Resource-Planner

## What is this ERP?
First, an Enterprise Respurce Planner or ERP is a system that is designed to manage day to day activites at an organization. This is a very small scale simulation of how a document management ERP (for securely storing, modifying, updating, archiving) would work. Since this was built for an Enterprise Software Engineering course, it had set specifications that were expected out of this system. but there are still many other features a system like this would need for it to bd used in the corporate world.

This project was built over the course of 2 months, and was designed to the format of a specific document type, and api that our professor used to demonstrate the power of ERPs, and test our ability to build them.

## How do I set it up?
This system was build using the LEMP stack. Specifically, Ubuntu Server 22, PHP 8.1, Nginx, and MySQL server, so those softwares will need to be installed first to set this up.
Next you would need to create a new database that matches the pattern detailed throughout the code, and populate it with your data. 
Lastly, if the api that was used to pull files was still up, you would want to set up CRON jobs on your system to automatically run the different aspects of this sfotware as needed.

## How can this be improved in the future?
### Security
As this project is a simple simulation of how a document management system might work, it lacks almost all forms of modern security. The first step would be to build     and authentication system for this code to use. Secondly, we would want to encrypt all data in our database so that in the event of breaches the data can still be       protected. Along with that there are many other small cybersecurity based fixes we would want to make to the system so that it will protect its user's data, but also     follow any and all compliance and privacy regulations for the country that the system is used in.
## Features
Given that this ERP was built in just 2 short months while also learning how ERP's actually work, and building projects for other classes, there are definitely many     features that are missing from this system that would be useful in the business world. For instance, logging who accesses which files, at what time, what did they       change, etc.
