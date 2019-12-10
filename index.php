https://www.lesstif.com/pages/viewpage.action?pageId=17105804 차고
데타베스 백업
    mysqldump --socket=/tmp/mysql.sock -u아이디 -p비번 vio_wallet_data > test.sql
데이터 업로그
    mysql -h dbhost2 -u root -pmypwd db2 <  mydump.sql
백업 tar [option] [압축할파일명] [압축대상파일명...]
압축
    tar -cvzf sample.tar.gz ./
    tar -cvf sample.tar ./*
압축풀기
    tar -xvzf sample.tar.gz ./

https://zetawiki.com/wiki/%EB%A6%AC%EB%88%85%EC%8A%A4_MySQL_%EC%8B%9C%EC%9E%91,_%EC%A0%95%EC%A7%80,_%EC%9E%AC%EC%8B%9C%EC%9E%91,_%EC%83%81%ED%83%9C%ED%99%95%EC%9D%B8
우분투
    시작 service mysql start
    정지 service mysql stop
    재시작 service mysql restart
    상태확인 service mysql status

CentOS6
    시작 service mysqld start
    정지 service mysqld stop
    재시작 service mysqld restart
    상태확인 service mysqld status

CentOS7
    시작 systemctl start mysqld
    정지 systemctl stop mysqld
    재시작 systemctl restart mysqld
    상태확인 systemctl status mysqld

포트번호 허용
    iptables -I INPUT -p tcp --dport 80 -j ACCEPT 하나
    iptables -I INPUT -p tcp --dport 88:80 -j ACCEPT 여러개
수정후
    /etc/rc.d/init.d/iptables save 저장

https://sarc.io/index.php/httpd/1120-apache-https-http-redirect-rewrite
아파치 mod_rewrite 참고

 CentOs 버전확인
 cat /etc/redhat-release

linux 서버 ssh 에서 root 비밀번호 변경하기
# su
# passwd
이후 비밀번호 입력

CentOS6 mysql 원격접속 허용
    모든 IP 허용
        GRANT ALL PRIVILEGES ON *.*TO'아이디'@'%'identified by '패스워드';
    아이피대역 허용(192.168.1로시작되는 대역)
        GRANT ALL PRIVILEGES ON *.*TO'아이디'@'192.168.1.%'identified by '패스워드';
    특정 IP 한개만 허용
        GRANT ALL PRIVILEGES ON *.*TO'아이디'@'192.168.1.123'identified by '패스워드';
    원격접속 허용전으로 되돌리기
        DELETE FROM mytsql.user where host='%' and user='root';
수정후
    flush privileges;

원격접속하기
    mysql -h'원격서버의ip 또는 도메인' -u'원격접속이 허둉된 사용자이름' -p


    https://codeday.me/ko/qa/20190307/14984.html
