import paramiko
import keys

# Criar um cliente SSH
ssh_client = paramiko.SSHClient()
ssh_client.set_missing_host_key_policy(paramiko.AutoAddPolicy())

# Conectar ao servidor
ssh_client.connect(
    hostname = keys.hostname,
    username = keys.username,
    password = keys.password
    # Você pode usar uma chave privada ao invés de senha
    # key_filename='/path/to/private/key'
)

# Abrir um cliente SFTP
sftp_client = ssh_client.open_sftp()

# Enviar um arquivo
sftp_client.put('fotos/foto.jpg', '../../opt/lampp/htdocs/ifpark/test/fotos/foto.jpg')

# Fechar o cliente SFTP e a conexão SSH
sftp_client.close()
ssh_client.close()


