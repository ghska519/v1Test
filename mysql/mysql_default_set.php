<h1 style="font-weight:bold;color:red">MySQL</h1>
    root 비밀번호 변경

        1.mysql 접근
            mysql -uroot -p

        2.mydql 데타베이스 접근
            use mysql

        3.비밀번호변경
            password필드가 존재할때
                update user set password=password('asdf123') where user='root';
            authentication_string필드가 존재할때
                update user set authentication_string=password('asdf123') where user='root';
                플러그인 타입을 확인하고 plugin 을 업데이트
                update user set plugin='mysql_native_password' where user='root';
            flush privileges;     // 변경된 내용을 메모리에 반영(권한 적용)

    유저생성 및 권한부여

        1.유저생성/삭저
            오든 아이피에서 접속 가능한 유저생성(외부접근)
            create user '아이디'@'%' identified by '비밀번호';
            delete from user where user = '사용자ID';      // 사용자 삭제

        2.유저에게 데타베이스 사용권한부여
            비밀번호 변경시에  IDENTIFIED BY '비밀번호'; 사용
            GRANT ALL PRIVILEGES ON 데타베스명.* TO 유저아이디@'%' IDENTIFIED BY '비밀번호';

        3.모든 데타베이스 대한 권한부여
            GRANT ALL PRIVILEGES ON *.*TO'유저아이디'@'%' IDENTIFIED by '비밀번호';
            ALL 대신에 select , update , insert , delete  등으로 수정 가능

        4.권한확인
            SHOW GRANTS FOR 유저아이디@'%';

        5.권한제거
            revoke all on DB명.테이블명 from 사용자ID;

        6.유저삭제
            drop user 유저아이디@'%';

        flush privileges;     // 변경된 내용을 메모리에 반영(권한 적용)
