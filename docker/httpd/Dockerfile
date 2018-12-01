FROM httpd:2-alpine

RUN sed -i \
        -e 's/^#\(LoadModule .*mod_rewrite.so\)/\1/' \
        conf/httpd.conf

EXPOSE 80
