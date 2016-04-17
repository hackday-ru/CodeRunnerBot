#!/bin/bash

echo "root:root" | chpasswd

/usr/sbin/sshd -D
