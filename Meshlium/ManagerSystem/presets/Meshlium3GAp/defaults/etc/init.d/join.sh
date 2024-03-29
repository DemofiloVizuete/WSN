#!/bin/bash

eth0=$(ifconfig eth0 2>/dev/null | egrep -o '([0-9]{1,3}\.){3}[0-9]{1,3}' | egrep -v '255|(127\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})')

ath0=$(ifconfig ath0 2>/dev/null | egrep -o '([0-9]{1,3}\.){3}[0-9]{1,3}' | egrep -v '255|(127\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})')

ath1=$(ifconfig ath1 2>/dev/null | egrep -o '([0-9]{1,3}\.){3}[0-9]{1,3}' | egrep -v '255|(127\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})')

ppp0=$(ifconfig ppp0 2>/dev/null | egrep -o '([0-9]{1,3}\.){3}[0-9]{1,3}' | egrep -v '255|(127\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})')

#if [ -n "$ath0" ] ; then
#	/usr/local/sbin/nat.sh ath0 ppp0 $ath0/24
#fi

if [ -n "$ath0" ] ; then
   /usr/local/sbin/nat.sh ath0 eth0 $ath0/24
fi