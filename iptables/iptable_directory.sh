#! /bin/sh

iptables -X
iptables -F

iptables -A INPUT -j DROP
iptables -A FORWARD -j DROP
iptables -I INPUT -i lo -j ACCEPT
iptables -I OUTPUT --out-interface lo -j ACCEPT
iptables -I OUTPUT -j ACCEPT

iptables -I INPUT -p tcp --dport 80 -j ACCEPT
iptables -I OUTPUT -p tcp --dport 80 -j ACCEPT
iptables -I OUTPUT -p tcp --sport 80 -j ACCEPT
iptables -I INPUT -p tcp --sport 80 -j ACCEPT

iptables -I INPUT -p tcp --dport 443 -j ACCEPT
iptables -I OUTPUT -p tcp --dport 443 -j ACCEPT
iptables -I OUTPUT -p tcp --sport 443 -j ACCEPT
iptables -I INPUT -p tcp --sport 443 -j ACCEPT

iptables -I INPUT -p tcp --dport 3306 -j ACCEPT
iptables -I OUTPUT -p tcp --dport 3306 -j ACCEPT
iptables -I OUTPUT -p tcp --sport 3306 -j ACCEPT
iptables -I INPUT -p tcp --sport 3306 -j ACCEPT

iptables -I INPUT -p icmp --icmp-type 8 -s 0/0 -d 10.250.14.0/24 -j ACCEPT
iptables -I OUTPUT -p icmp --icmp-type 0 -s 10.250.14.0/24 -d 0/0 -j ACCEPT
iptables -I OUTPUT -p icmp --icmp-type 8 -s 10.250.14.0/24 -d 0/0 -j ACCEPT
iptables -I INPUT -p icmp --icmp-type 0 -s 0/0 -d 10.250.14.0/24 -j ACCEPT

iptables -I INPUT -p tcp --dport 22 -m iprange --src-range 10.250.14.49-10.250.14.62 -j ACCEPT
