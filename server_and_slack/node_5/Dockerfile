FROM     node:5
MAINTAINER Gregory Vorozhtcov

# update soft
RUN apt-get update -y
RUN apt-get -y dist-upgrade
RUN apt-get upgrade -y
RUN apt-get install software-properties-common -y

# ssh
RUN apt-get install -y openssh-server
RUN mkdir /var/run/sshd
RUN sed -ri 's/^PermitRootLogin\s+.*/PermitRootLogin yes/' /etc/ssh/sshd_config
RUN sed -ri 's/UsePAM yes/#UsePAM yes/g' /etc/ssh/sshd_config
RUN mkdir /root/.ssh/
RUN apt-get update && apt-get install -y vim

# open port
EXPOSE 22

# container init
ADD ./start.sh /start.sh
RUN chmod 755 /start.sh
CMD ["/bin/bash", "/start.sh"]

