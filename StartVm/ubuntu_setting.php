
1.ubuntu 까지 설치 완료후 이유는 모르겠지만 일단 업데이트
    sudo apt update                  ----->저장소의 패키지 목록을 업데이트
    sudo apt upgrade                ----->기존에 설치되어 있던 패키지를 업그레이드
2.ssh 설정
    sudo apt-get -y install open-vm-tools-desktop
    우선 root 계정을 활성화 한다
    sudo passwd root
    입력후 비밀번호 두번 입력
    su root
    sudo apt-get install vsftpd
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
    apt-get install openssh-server
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

    #라이트 코인 쏘스 다운로드
    #git clone https://github.com/litecoin-project/litecoin.git


    https://cbw1030.tistory.com/402 (참고 링크)
    BitCoin Core 설치
    일반 유저 로 작업

    bitcoin core 설치전 기본적인 셋팅 진행
        1. sudo apt-get update
        2. sudo apt-get install build-essential libtool autotools-dev automake pkg-config bsdmainutils python3
        3. sudo apt-get install libevent-dev libboost-system-dev libboostfilesystem-dev libboost-test-dev libboost-thread-dev
        만약 E: Unable to locate package libboostfilesystem-dev 에러가 발생한다면 아래 명령어 실행
        sudo apt-get install libevent-dev libboost-dev libboost-system-dev libboost-filesystem-dev libboost-test-dev


    bitcoin core 설치 진행
        1. sudo add-apt-repository ppa:bitcoin/bitcoin (지갑을 사용하기 위해서는 ppa가 필요함)

        2. sudo apt-get update

        3. sudo apt-get install libdb4.8-dev libdb4.8++-dev

        4. apt-cache search libdb4.8 (libdb4.8이 잘 설치되어있는지 확인하는 절차)

        5. sudo apt-get install libminiupnpc-dev (Depency 중 방화벽을 뛰어넘게 도와주는 라이브러리 miniupnpc)

        6. sudo apt-get install libzmq3-dev

    bitcoin 깃허브에서 자료를 개인 컴퓨터로 받는다 (v0.20.0)


    git clone -b v0.20.0 https://github.com/bitcoin/bitcoin.git
    (다운후 나오는 경고 문구 나중에 확인 및처리)

    cd /home/유저/bitcoin 다운받은 비트코인 폴더로 이동
    ./autogen.sh
    ./configure
    make
    sudo make install

    만약 ./autogen.sh, ./configure까지는 잘 되었는데 make에서 recipe for target 'bitcoind' failed 에러가 발생한다면 아래 사이트 참조한다.
    https://stackoverflow.com/questions/52871871/bitcoin-compile-undefined-reference-to-blockassemblerblockassemblercchainp
    해결방법은 이대로 기본 세팅을 다시하면 된다

    which bitcoind ,which bitcoin-cli 명령어를 통해 경로를 찾아낼수 있으면 bitcoin core 설치는 완료된 것이다.

    https://en.bitcoin.it/wiki/Original_Bitcoin_client/API_calls_list
    여기는 비트코인 명령어 모음
    https://live.blockcypher.com/btc-testnet/
    여기는 테스트 코인거래 확인하는 부분 마지막 블록 높이를 확인하면 된다


    /home/유저/.bitcoin 폴더에서 bitcoin.conf 내용 설정 server=1 가 중요하다 나머지는 삭제해도 돌아감 상세한 내용은 잘모름 참고 링크 https://stepcoding.tistory.com/36
    nano ./bitcoin.conf
    server=1
    # server=1 은 Bitcoin-Qt 와 bitcoind JSON-RPC 사용하도록 합니다.
    rpcuser=rpc유저
    rpcpassword=rpc유저의 비밀번호
    # rpc접속에 필요한 유저와 비밀번호를 설정합니다.
    rpcallowip=rpc를 허용할 ip
    rpcallowip=rpc를 허용할 ip2
    rpcallowip=rpc를 허용할 ip3
    #추가 허용 ip가 있을경우 아래에 추가합니다. 형식은 포트번호를 제외한 ip만 입력합니다.
    rpcport=rpc포트
    # 메인넷 디폴트 포트:18332, 테스트넷 디폴트 포트:8332
    rpcthreads=4
    #rpc 호출을 처리할 스래드 개수 디폴트:4
    reindex=1
    # 블록 초기화와 함께 새롭게 블록을 다운로드합니다. 이어서 블록동기화를 진행할 경우 reindex 옵션은 삭제해주세요.
    txindex=1



#블록체인 내의 트랜잭션에 대한 데이터 조회
    bitcoind -testnet (리스트 쌓이는걸 직접 할수 있다)
    bitcoind -testnet -daemon (백그라운드에서 진행)
    실행하면 거래내역을 내려받는걸 확인할수 있다
    bitcoin-cli -testnet getblockcount (현재 내피시에 쌓인 높이를 알수 있다)
    ps -ef | grep bitcoin
    대략 한두시간이후 높이가 같아진후

    bitcoin-cli -testnet getnewaddress hnts01 지갑주소를 상성하고
    구글 bitcoin testnet coin faucet  검색후 테스트 코인을 받아온다

    코인보내기 sendtoaddress 받는사람 주소 코인 수량 ====> 리턴 txID
    bitcoin-cli -testnet sendtoaddress tb1qnlvdg2sjerwj6c46akd5x5rkkeu0eclau768pu 0.0001



    라이트 코인 0.15 빌드 하기
    mkdir workspace && cd workspace

    git clone -b 0.15 --single-branch https://github.com/litecoin-project/litecoin.git ingcoin_0.0.15
    cd ingcoin_0.0.15
    sudo apt update
    sudo apt upgrade
    sudo apt install build-essential libtool autotools-dev automake pkg-config bsdmainutils curl git
    sudo apt install nsis

    sudo apt install g++-mingw-w64-x86-64 sudo update-alternatives --config x86_64-w64-mingw32-g++
    1을 입력하고 엔터
    sudo apt-get install libboost-system-dev libboost-filesystem-dev libboost-chrono-dev libboost-program-options-dev libboost-test-dev libboost-thread-dev libboost-iostreams-dev
    sudo apt-get install libssl-dev
    모듈들을 다운로드 후
    ./autogen.sh
    ./configure --with-boost-libdir=/usr/lib/x86_64-linux-gnu
    sudo make
