버전확인
    openssl version
패키지 확인
    rpm -qa | grep openssl
ssl 모듈확인
    /etc/httpd/modules/mod_ssl.so 모듈위치
    yum install mod_ssl  모듈설치

서버 재부팅
    service httpd restart

포트443
    iptables -I INPUT -p tcp --dport 443 -j ACCEPT
    /etc/rc.d/init.d/iptables save

다운받은 인증서 업로드
    /sample/ssl/테스트

httpd.conf파일수정
    NameVirtualHost *:443 추가
    <VirtualHost *:80>
        ServerName sample.com
        ServerAlias www.sample.com
        DocumentRoot /var/www/html/sample

        RewriteEngine On
        #아래부분은 ssl 을 신청 할때 a레코드 부분빼고 신청 했을시에 대한 작업처리
        RewriteCond %{HTTP_HOST} ^www\.(.+) [NC]
        RewriteRule ^(.*) http://%1/$1 [R=301,NE,L]
        RewriteCond %{HTTPS} off
        RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI}
    </VirtualHost>
    <VirtualHost *:443>
        ServerName  cash-coin.co.kr
        ServerAlias www.cash-coin.co.kr
        DocumentRoot /var/www/html/cash_coin_market

        RewriteEngine On
        RewriteCond %{HTTPS} off
        RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI}

        SSLEngine on
        SSLCertificateKeyFile /sample/ssl/테스트/sample_ssl_file.key.pem
        SSLCertificateFile /sample/ssl/테스트/sample_ssl_file.crt.pem
        SSLCACertificateFile /sample/ssl/테스트/RootChain/AddTrustRoot.crt.pem
        <Directory /var/www/html/cash_coin_market>
                AllowOverride All
                Options All -Indexes
            <IfVersion < 2.4>
                Allow from all
            </IfVersion>
            <IfVersion >= 2.4>
                Require all granted
            </IfVersion>
        </Directory>
    </VirtualHost>

httpd 재부팅
service httpd restart
