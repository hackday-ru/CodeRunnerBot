FROM       ubuntu:trusty
MAINTAINER Gregory Vorozhtcov

# language
RUN locale-gen en_US.UTF-8
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:e
ENV LC_ALL en_US.UTF-8
ENV DEBIAN_FRONTEND noninteractive
RUN dpkg-reconfigure locales

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

# git
RUN apt-get install -y git vim
RUN apt-get install -y ca-certificates git-core ssh
RUN eval "$(ssh-agent -s)"
RUN mkdir /home/coderunner/
RUN useradd coderunner
RUN userdel www-data
RUN usermod -u 33 coderunner
RUN mkdir /home/coderunner/.ssh
# ADD .id_rsa /home/coderunner/.ssh/id_rsa
RUN mkdir /home/coderunner/source/
# RUN chmod 600 /home/coderunner/.ssh/id_rsa
# RUN echo "Host bitbucket.org\n\tIdentityFile /home/coderunner/.ssh/id_rsa" >> /home/coderunner/.ssh/config
RUN eval "$(ssh-agent -s)"
RUN touch /home/coderunner/.ssh/known_hosts
RUN ssh-keyscan bitbucket.org >> /home/coderunner/.ssh/known_hosts
RUN chown -R coderunner:coderunner /home/coderunner/

# open port
EXPOSE 22

VOLUME /home/coderunner/source/

# container init
ADD ./start.sh /start.sh
RUN chmod 755 /start.sh
CMD ["/bin/bash", "/start.sh"]
