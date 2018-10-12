<p align="center"><img width=60% src="https://www.marketingromania.ro/github/cloudincidentstatus/logo.png"></p>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
![Dependencies](https://img.shields.io/badge/dependencies-up%20to%20date-brightgreen.svg)
![Contributions welcome](https://img.shields.io/badge/contributions-welcome-orange.svg)


## CloudIncidentStatus
CloudIncidentStatus is a opensource status and incident communication tool.

If you ask how could CloudIncidentStatus help you? Below you will find some information.

With this tool you will inform your customers about the issues on your product and you will turn a bad situation into a great customer experience.

Build customer trust with this tool. Allow them to know when an incident occurs or a scheduled maintenance will take place, they will get a notification via email. 



## ScreenShots
- <a href="https://www.marketingromania.ro/github/cloudincidentstatus/status-1.png" target="_blank">**Front Page**</a>
- <a href="https://www.marketingromania.ro/github/cloudincidentstatus/status-2.png" target="_blank">**Components**</a>
- <a href="https://www.marketingromania.ro/github/cloudincidentstatus/status-3.png" target="_blank">**Incident**</a>
- <a href="https://www.marketingromania.ro/github/cloudincidentstatus/status-4.png" target="_blank">**Details about an incident**</a>
- <a href="https://www.marketingromania.ro/github/cloudincidentstatus/status-5.png" target="_blank">**Maintenance**</a>


## Overview
- Components List of your services
- Scheduled Maintenace
- Inform your clients about issues
- Subscriber notifications via email
- Clients can see in real-time the status of components
- Clients can see in real-time the status of an issue
- Set a status for what’s impacted
- Display historic uptime services
- Faster incident comms
- More customer trust
- Less time wasted
- Skip all the "It is my service down?", questions 
- A friendly Admin interface and easy to use
- A friendly User interface.
- and more, your customers will thank you.

## Requirements
- HTTP server (Apache, Nginx, etc)
- PHP 7.1 or later
- Mysql
- Composer (http://www.getcomposer.org)

If you don't have an external VPS, you can buy one from [Webland.ro](https://webland.ro) and managed with [ClusterCS.com](https://clustercs.com).


## How to install

###### Step 1
```sh
$ cd /home/statuspage/
$ git clone https://github.com/alexandrucanavoiu/CloudIncidentStatus
$ cd CloudIncidentStatus
```

###### Step 2
By default CloudIncidentStatus comes with a .env.example file. You will need to rename this file as .env
You will change the default values with your own (like database name, database user, database password, etc)

###### Step 3
```sh
$ find ./ -type f -exec chmod 644 {} +
$ find ./ -type d -exec chmod 755 {} +
```

###### Step 4
```sh
$ composer update
$ php artisan key:generate
```

###### Step 5
```sh
$ php artisan migrate
$ php artisan db:seed --class=Settings
$ php artisan db:seed --class=ComponentStatuses
$ php artisan db:seed --class=Users
$ php artisan db:seed --class=IncidentStatus
$ php artisan db:seed --class=Footer
```

###### Step 6
You need to run Queue in background. This will be used for Subscriber Emails when an Incident or Maintenance is created.
```sh
$ php artisan queue:work --queue=Incidents,Maintenance --tries=1
````

###### Step 5
````
Admin page: www.yourdomain.org/login
username: demo@example.org
password: demo

````

## Professional Installation
I offer a professional installation of this tool. Please contact me at alex.canavoiu@marketingromania.ro

## Security Vulnerabilities
It is an open-source software. If you discover a security vulnerability please contact me or you can come with a solution by contributing at the project. 