<p align="center">
  <img src="/app/res/img/logo.svg" width="350">
</p>

![-----------------------------------------------------](https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/rainbow.png)
# Kalani

This project is a joint effort, so we don't fail our WAP (Web Apps) class. 
It's a calendar, in which you can see the airtime, of the next episode of your currently releasing anime show/movie!

All the data we get about shows is thanks to the AniList GraphQL API (ily <3).

We are by no means, good developers, feel free to hit us up for any suggestions/corrections.

The project name is a wordplay -> Kalendář + Anime = KalAni. 

![-----------------------------------------------------](https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/rainbow.png)

## FAQ

#### Any reason, why use KalAni over AniList you may ask?

None, none at all. 

You really should use AniList, this is just a learning experience.

#### Why did you do X, instead of Y ?!?!

Bro idk why we did, if you have a better solution, you better tell us.

![-----------------------------------------------------](https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/rainbow.png)
## Roadmap

- Basic user management (manage users, admins) ✅

- System for users so they can manage their shows (add, remove shows) ✅

- Working calendar with required functionality ✅

- A templating system of some sort? ✅

- Decent looking and responsive front-end 🔜

- Make a one click docker image of KalAni (a webserver with a db) 🔜

- Deploy on Heroku ✅

- Deploy the Docker image on a domain 🔜

- Google calendar integration (unlikely) 🔜

- Other stuff i forgot

![-----------------------------------------------------](https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/rainbow.png)
## Deployment

#### Docker

```bash
Dont have a dockerfile yet, will update soon
```

#### Heroku

1. Fork this repo

2. Deploy this repo as an app, along with a ClearDB MySQL addon

3. Add these Environment Variables located under Config Variables in the settings via the Heroku dashboard or alternatively use HerokuCLI 

| KEY | VALUE |
| ------------- |:-------------:|
| DB_HOST   | Database hostname/server |
| DB_PW | Database password |
| DB_UN     | Database username |
| DB_SCHEMA | Database schema |
| SMTP_UN | SMTP username/email |
| SMTP_PW | SMTP password |
| SMTP_HOST | SMTP hostname/server |
| SMTP_PORT | SMTP port |
| SMTP_ENC | SMTP encryption method |

![-----------------------------------------------------](https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/rainbow.png)
## Demo

[Live docker container](https://www.docker.com/) 

[Live heroku container](http://kal4ni.herokuapp.com/)

![-----------------------------------------------------](https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/rainbow.png)
## Screenshots

![App Screenshot](https://i.imgur.com/uhYONDF.png)

![-----------------------------------------------------](https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/rainbow.png)
## Authors

[Lukáš Divíšek](https://www.github.com/Bruzdden) 

- DB/MySQL
- OOP
- JS
- Frontend
- User management, signing in/up, email verification method
- Edited PHPCalendar fork from benhall14
- Project file structure
- Color palette 

[Maxmilián Dao](https://www.github.com/MaxmilianDao) 

- GraphQL API queries
- Composer 
- Frontend
- SMTP implementation of PHPMailer for email verification
- Project idea, management
- Project deployment on heroku 
- GitHub README.md
- Storage of SMTP, DB credentials
- Color palette 



![-----------------------------------------------------](https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/rainbow.png)
## Acknowledgements
 - [AniList](https://anilist.co/)
 - [AniList API and their docs](https://github.com/AniList/ApiV2-GraphQL-Docs)
 - [Readme.so](https://readme.so/)
 - [README.md inspiration](https://github.com/matiassingers/awesome-readme)
 - [Ben Hall's PHP-Calendar](https://github.com/benhall14/php-calendar)
 - [PHPMailer](https://github.com/PHPMailer/PHPMailer)
 - Header cover image by Ivett Hildebrandtová
![-----------------------------------------------------](https://raw.githubusercontent.com/andreasbm/readme/master/assets/lines/rainbow.png)
## License

[GPL 3.0](https://choosealicense.com/licenses/gpl-3.0/)
