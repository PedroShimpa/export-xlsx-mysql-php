
Exportador de tabelas de mysql para xlsx em puro php

este projeto usa https://github.com/shuchkin/simplexlsxgen para gerar os xlxs.

para gerar os xlsx basta:

1º Clone o Repostório;
2º Instale as dependecias com composer install;
3º abra o arquivo index.php e altera as configurações do banco de dados (a partir da linha 13), lembre-se que a quantidade de campos do header precsa ser a mesma que a quantidade de campos da query.
4ºInicie o apache e acesse a url do index.php e efetue o download do arquivo.
