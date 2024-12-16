# url shortener
designed to be used with my own hosting repository,I wont help anybody that tries to make it work for themselves more than I could try to help another person.
### how to use
just clone to /var/www/html and then add an option to get to it in your website.
then install libmicrohttpd-dev and compile redirector.c and run redirector.c as a job or something that reiterates several times
I recommend to use ```gcc -o shortener shortener.c -lmicrohttpd```
You have to also add a subdomain that is like shortener.leogamer644.com, you can change the domain in redirector.c