FROM bagelcorner/app

# NodeJS
RUN apt-get update \
    && apt-get install -y \
       nodejs \
       npm \
    && ln -s /usr/bin/nodejs /usr/bin/node

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin \
    && composer global require "hirak/prestissimo:^0.3"

COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY id_rsa.pub /root/.ssh/id_rsa.pub
COPY id_rsa /root/.ssh/id_rsa
RUN chmod 400 ~/.ssh/id_rsa

CMD ["bash"]
