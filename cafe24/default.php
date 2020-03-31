cafe24에서 가상서버 호스팅을 신청하면, 기본 centos 에 APM을 rpm 으로 설치해줍니다.

그런데 여기서 문제가 mysql 재시작, apache 재시작, vsftpd 재시작을 해줘야 정상 호스팅 상태가 됩니다.
# service vsftpd restart
# service mysqld restart
# apachectl restart

php를 돌려보던중에 gd 라이브러리와 일부 php 라이브러리가 정상 설치 안되어 있음을 확인하였습니다.
이를 해결하기 위해 yum 으로 개별 업데이트를 해주면 됩니다.
(그누보드는 gd 안되면, 관리자 설정도 바꿀수 없습니다. captcha )
# yum -y install zlib libpng freetype gd libxml lib iconv
# yum -y install php-devel php-gd php-mbstring php-pear php-pecl-mailparse mod_ssl
# apachectl restart

이제 phpinfo(); 를 보시면 gd가 정상적으로 설치되어 있고, 관리자페이지에서 캡챠 이미지도 잘 보이게 됩니다.

ps) cafe24는 왜 gd를 기본 라이브러리에서 뺐을까요?<div class='small'>[이 게시물은 관리자님에 의해 2011-10-31 17:16:08 PHP & HTML에서 이동 됨]</div>
aaa
asdfasdfasdf
