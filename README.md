# Aula MVC - SENAI - 04/2021

## Checklist - Virtual HOST
- Criar o virtual host no XAMPP:
    - Acesse o arquivo: ```C:\xampp\apache\conf\extra\httpd-vhosts.conf```
    - Você encontrará as seguintes informações:
      
      **VirtualHost:** Tag definindo as configurações do virtual host.
      
      **ServerAdmin:** Endereço de contato.
      
      **DocumentRoot:** Caminho completo até a pasta que será acessada.
      
      **ServerName:** Nome do host que será acessado.
      
      **ServerAlias:** Nomes alternativos para o host.
      
      **ErrorLog:**  Nome do arquivo que o servidor registrará os erros encontrados.
      
      **CustomLog:** Nome do arquivo para as requisições.
    
    - Configure assim:
    ```
    <VirtualHost *:80>
        ServerAdmin webmaster@local.projeto.com
        DocumentRoot "C:/xampp/htdocs/projeto"
        ServerName local.projeto.com
        ErrorLog "logs/local.projeto.com-error.log"
        CustomLog "logs/local.projeto.com--access.log" common
    </VirtualHost>
    ```

- Alterar as configs do windows para redirecionar para o http://127.0.0.1:
    - Acesse o arquivo: ```C:\Windows\System32\drivers\etc\hosts``` Você pode acessar com bloco de notas mesmo. Pode ser que você tenha que executar como Administrador;
    - Insira o host e o respecitivo redirecionamento. Ex: ```127.0.0.1       local.projeto.com```
    - Salve o arquivo.
