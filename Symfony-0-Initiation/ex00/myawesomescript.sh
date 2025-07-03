#!/bin/sh
# curl -sI https://bit.ly/44Egvt4 | grep -i ^Location | cut -d ' ' -f2
# curl -sI https://bit.ly/44Egvt4
# HTTP/2 301 
# server: nginx
# date: Mon, 30 Jun 2025 14:12:22 GMT
# content-type: text/html; charset=utf-8
# content-length: 110
# cache-control: private, max-age=90
# content-security-policy: referrer always;
# location: https://omnis-bibliotheca.com/index.php/Roboute_Guilliman
# referrer-policy: unsafe-url
# set-cookie: _bit=p5uecm-c7c7a76db925537282-00S; Domain=bit.ly; Expires=Sat, 27 Dec 2025 14:12:22 GMT
# via: 1.1 google
# alt-svc: h3=":443"; ma=2592000,h3-29=":443"; ma=2592000

# thomas@debian:~/Bureau/Piscine-Symfony/ex00$ curl -sI https://bit.ly/44Egvt4 | grep -i ^Location
# location: https://omnis-bibliotheca.com/index.php/Roboute_Guilliman

# thomas@debian:~/Bureau/Piscine-Symfony/ex00$ curl -sI https://bit.ly/44Egvt4 | grep -i ^Location | cut -d ' ' -f2
# https://omnis-bibliotheca.com/index.php/Roboute_Guilliman

if [ -z "$1" ]; then
	echo "Usage: $0 <shortened_url>"
	exit 1
fi

shortened_url="$1"
final_url=$(curl -sI "$shortened_url" | grep -i ^Location | cut -d ' ' -f2)
if [ -z "$final_url" ]; then
	echo "No redirection found for the provided URL."
	exit 1
fi

echo "$final_url"