# url shortener
designed to be used with my own hosting repository,I wont help anybody that tries to make it work for themselves more than I could try to help another person.
### how to use
just clone to /var/www/html and then add an option to get to it in your website.
then install libmicrohttpd-dev and compile redirector.c and run redirector.c as a job or something that reiterates several times
I recommend to use ```gcc -o shortener shortener.c -lmicrohttpd```
You have to also add a subdomain that is like shortener.leogamer644.com, you can change the domain in redirector.c. After doing that, to make it so that the urls are entered into the database, you have to do chmod urls.txt 777. you can probably get away with less, but I cant really check that out
## Extra
I recommend making a service out of the program redirector. if not you will have to execute it after every server restart. to do so, I recommend to use systemd and for that I recommend to write this service: 
```
sudo nano /etc/systemd/system/redirector.service

```
```
[Unit]
Description=URL Redirector Service
After=network.target

[Service]
Type=simple
ExecStart=/var/www/html/sites/shortener/redirector.out
Restart=on-failure
User=root
Group=root
WorkingDirectory=/var/www/html/sites/shortener/

[Install]
WantedBy=multi-user.target
```
then, just execute 
```
sudo systemctl daemon-reload
```
```
sudo systemctl enable redirector.service
```
```
sudo systemctl start redirector.service
```

```
if you plan to do this change getchar to a while (1) {
        sleep(1);
    } so that it works as a service
```
