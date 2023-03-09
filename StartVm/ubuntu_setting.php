1.ubuntu 까지 설치 완료후 이유는 모르겠지만 일단 업데이트
    sudo apt update                  ----->저장소의 패키지 목록을 업데이트
    sudo apt upgrade                ----->기존에 설치되어 있던 패키지를 업그레이드
2.ssh 설정
    우선 root 계정을 활성화 한다
    sudo passwd root
    입력후 비밀번호 두번 입력
    su root
    비밀번호 입력후 접속 되면 활성화 된거임
    nano /etc/ftpusers
    파일 열린후 맨위에 root 를 삭제후
    nano /etc/vsftpd.conf
    파일에서 #write_enable=YES  앞 주석을 제거
    (chroot_local_user=YES 주석 풀면 자신의 홈 디렉토리만 접근가능)
        *chroot_local_user=YES 주석을 풀면 아래와 같은 에러가 발생하는 경우가 있음
        500 OOPS: vsftpd: refusing to run with writable root inside chroot()
        이러한 경우 vsftpd.conf 파일에
        allow_writeable_chroot=YES  을 추가 저장
    완료후 vsftp 재시작
    systemctl restart vsftpd
    여기까지면 ftp는 접속이 가능해진다
    ssh 설치
    apt-get install openssh_server
    root 접속제한 해제
    nano /etc/ssh/sshd_config
    #PermitRootLogin prohibit-password 를 PermitRootLogin yes 변경
    #PasswordAuthentication yes 앞에 #주석 제거
    service ssh restart


    git 설치
    apt-get install git
    버전확인
    git --version
    push했을때 올라갈 내정보 입력
    git config --global user.name LHN
    git config --global user.mail ghska519@163.com

    라이트 코인 쏘스 다운로드
    git clone https://github.com/litecoin-project/litecoin.git

    1
