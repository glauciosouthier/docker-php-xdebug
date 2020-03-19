# docker-php-xdebug
# ambiente de desenvolvimento em container

# instale o git (ou use uma IDE para clonar este projeto):

git clone https://github.com/glauciosouthier/docker-php-xdebug.git

cd docker-php-xdebug

sudo chmod 755 -R .


# 1.0 -- instalar o docker e o docker-compose


sudo apt install -y apt-transport-https ca-certificates curl software-properties-common

 
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -

    
export LSB_ETC_LSB_RELEASE=/etc/upstream-release/lsb-release
V=$(lsb_release -cs)


sudo add-apt-repository \
    "deb [arch=amd64] https://download.docker.com/linux/ubuntu ${V} stable"
    
    
sudo apt update -y

sudo apt-get install docker-ce

sudo apt-get  install docker-compose

sudo gpasswd -a "${USER}" docker

sudo reboot

# 2.0 fazer o build do container

# configurar os modulos desejados no arquivo .env (habilitar cliente oracle e xdebug)

# a variavel PHP_APP_FOLDER aponta para a pasta com o código PHP (default é "." mas pode apontar para o caminho absoluto da aplicação, ex: /home/seu_usuario/git/appXYZ/)


docker-compose --build

docker-compose up


# 3.0 - configurar o vscode para integrar com xdebug

# instalar vscode

sudo apt-get install code1.43


# instale os plugins PHPDebug, PHPIntelliSense, Docker


# Menu: Run > Start Debugging > PHP


# verifique se está marcado "Listen for Xdebug"


# abra o arquivo em ".vscode/launch.json"


    {
            "name": "Listen for XDebug",
            "type": "php",
            "request": "launch",
            "port": 9000,
            "log" : true,
            "stopOnEntry": false,
            "pathMappings": {
                "/var/www/html": "${workspaceFolder}/"
            }
        },
        {
            "name": "Launch currently open script",
            "type": "php",
            "request": "launch",
            "stopOnEntry": true,
            "program": "${file}",
            "cwd": "${fileDirname}",
            "port": 9000
        }
        

# menu : Run > Start Debugging
# instale a extensão "Xdebug Hepler" no seu navegador e deixe-a ativada (irá manter o cookie : XDEBUG_SESSION)

# coloque um breakpoint e teste a aplicação (localhost:8080).

--comandos uteis:

docker stop $(docker ps -aq)

docker rmi -f $(docker images -qa)

docker-compose up --build -d

docker-compose down --volumes

docker system prune

# VC pode conectar com o DBeaver (ou outro cliente de banco) diretamente nos bancos que estão em container, ex: localhost:3306 pois a porta exportada no docker-compose.yaml  (ports: - "3306:3306")
