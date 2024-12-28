# Chato Reborn

Chato é um chat online em tempo real que tentei implementar diversas vezes, mas nunca consegui finalizar. Dessa vez, estou tentando novamente, mas com um pouco mais de experiência e conhecimento. Este projeto usa PHP, MySQL, HTML5, CSS3, JavaScript e NodeJS. A ideia é que o chat seja um chat de salas, onde o usuário pode criar uma sala e convidar outras pessoas para conversar. Tudo e feito tentando aproveitar ao máximo o que o PHP, o MySQL e o JavaScript tem a oferecer, sem a necessidade de frameworks ou bibliotecas de terceiros, para demonstrar conhecimento sobre as tecnologias e de lógica de programação.

Não sou designer, então o visual do chat não é o melhor. A ideia é que o chat seja funcional, e não bonito.

## Mais sobre as tecnologias usadas

### Webserver

O webserver é feito em PHP (apache), sem o uso de frameworks ou bibliotecas de terceiros. Ele é responsável por servir os arquivos HTML, CSS e JavaScript, além de processar as requisições do usuário e enviar as respostas.

### Banco de dados

O banco de dados é feito em MySQL. Ele é responsável por armazenar as informações dos usuários, salas e mensagens.

### Socket server

O socket server é feito em NodeJS. Ele é responsável por manter a conexão entre os usuários e o servidor, permitindo que as mensagens sejam enviadas e recebidas em tempo real. Usa o protocolo WebSocket para manter a conexão.

## Instalação

### Configuração

Algumas variáveis de ambiente podem ser configuradas no arquivo `.env` na raiz do projeto. As variáveis disponíveis são:

- `WEBSERVER_BIND_PORT=80`: Porta em que o servidor web irá escutar.
- `SOCKET_SERVER_BIND_PORT=90`: Porta em que o servidor de socket irá escutar.
- `MYSQL_ROOT_PASSWORD=root`: Senha do usuário root do MySQL.
- `MYSQL_USER=chato_reborn`: Nome do usuário do MySQL para o Chato Reborn.
- `MYSQL_PASSWORD=chato_reborn`: Senha do usuário do MySQL para o Chato Reborn.

### Deploying do ambiente de desenvolvimento com Docker

Para inicializar o Chato Reborn em ambiente de desenvolvimento, você precisa ter o Docker e o Docker Compose instalados em sua máquina. Com eles instalados, basta executar o comando abaixo:

```bash
docker compose up -d
```

Isso irá inicializar o ambiente de desenvolvimento do Chato Reborn. Para acessar o chat, basta acessar o endereço `http://localhost/public/chat.php` em seu navegador (lembre-se de alterar a porta de acordo com a sua ```WEBSERVER_BIND_PORT```).
