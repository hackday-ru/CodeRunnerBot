FROM nginx:1.9
MAINTAINER Gregory Vorozhtcov

ADD nginx.conf /etc/nginx/
ADD coderunner.conf /etc/nginx/sites-available/coderunner.conf
RUN mkdir /etc/nginx/sites-enabled
RUN ls -la /etc/nginx/sites-available
RUN ls -la /etc/nginx/sites-enabled
RUN ln -s /etc/nginx/sites-available/coderunner.conf /etc/nginx/sites-enabled/coderunner
RUN usermod -u 1000 www-data

# container init
ADD ./start.sh /start.sh
RUN chmod 755 /start.sh

RUN apt-get update && apt-get install -y wget
RUN wget -qO- https://get.docker.com/ | sh

CMD ["/bin/bash", "/start.sh"]
RUN cat /etc/nginx/sites-available/coderunner.conf
