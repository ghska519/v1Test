sudo apt-get install -y curl

sudo apt update



먼저 PPA 패키지에 엑세스하기 위해 PPA를 설치한다. 홈 디렉토리 ~ 로 진입해14.x 버전을 설치한다
cd ~
curl -sL https://deb.nodesource.com/setup_14.x | sudo -E bash -

sudo 권한으로 PPA 를 추가하고 업데이트한다

sudo bash nodesource_setup.sh
sudo apt-get install -y nodejs

PPA 를 통해 Node.js 를 설치하면 npm 까지 같이 설치된다. npm이 제대로 동작하기 위해 build-essential 패키지를 설치해야 한다.
sudo apt-get install build-essential

node -v
npm -v





npm install -g express-generator

express {생성할 프로젝트명}

express node-api
cd node-api
npm install
만약 모듈을 설치하는 과정에서 ‘npm WARN deprecated’와 같은 경고 메세지가 나온다면 다음의 명령어를 입력해주면 됩니다.
npm audit fix

npm install pm2 -g

node-api폴더에서
pm2 start --name "앱이름" npm -- start
