FROM httpd:2-alpine

RUN sed -i \
        -e 's/^#\(LoadModule .*mod_rewrite.so\)/\1/' \
        conf/httpd.conf

COPY docker/httpd/serlo-org.conf conf/serlo-org.conf
RUN echo "Include /usr/local/apache2/conf/serlo-org.conf" >> conf/httpd.conf

EXPOSE 80
