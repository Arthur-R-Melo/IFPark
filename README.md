# 🚗 IFPark

Sistema inteligente de controle de acesso para estacionamentos utilizando **Reconhecimento Automático de Placas Veiculares (ALPR)**, visão computacional, Raspberry Pi e aplicação web.

Desenvolvido como projeto final do **Curso Técnico Integrado em Informática**.

---

# 👨‍💻 Desenvolvedores

- [Arthur Melo](https://github.com/Arthur-R-Melo)
- [Valter dos Santos Simão](https://github.com/valtersimao)
- [Pedro Cruz](https://github.com/PedroHCruz)

---

# 📖 Sobre o projeto

O **IFPark** é um sistema inteligente de gerenciamento de acesso para estacionamentos que automatiza a abertura e o fechamento de portões por meio do reconhecimento automático de placas veiculares (ALPR).

A motivação para o desenvolvimento do projeto surgiu após um **acidente envolvendo o portão de acesso ao estacionamento da instituição**, que evidenciou limitações no processo manual de controle de entrada e saída de veículos. O incidente demonstrou a necessidade de uma solução capaz de aumentar a segurança, reduzir falhas humanas e proporcionar maior controle sobre os acessos.

Como resposta a esse problema, foi desenvolvido o **IFPark**, uma solução que integra **Visão Computacional**, **Inteligência Artificial**, **Raspberry Pi** e uma **Aplicação Web** para realizar a identificação automática de veículos autorizados, registrar todas as movimentações e controlar o acionamento do portão de forma segura e eficiente.

Além de automatizar o processo de acesso, o sistema fornece uma plataforma administrativa para gerenciamento de usuários, veículos, empresas e histórico de entradas e saídas, oferecendo maior confiabilidade, rastreabilidade e praticidade na administração do estacionamento.

---

# ✨ Funcionalidades

- 🚘 Detecção automática de veículos
- 🔤 Reconhecimento automático de placas (ALPR)
- 🔓 Abertura automática do portão
- 👤 Cadastro de usuários
- 🚗 Cadastro de veículos
- 🏢 Cadastro de empresas
- 👨‍💼 Gerenciamento de administradores
- 📜 Histórico completo de acessos
- 🌐 Interface Web para administração
- 📡 Comunicação entre Raspberry Pi e servidor
- 📷 Captura automática de imagens
- 🗄 Armazenamento das informações em banco de dados

---

# 🏗 Arquitetura do projeto

O sistema é dividido em três módulos principais, responsáveis pela captura das imagens, processamento inteligente e gerenciamento do sistema.

```text
IFPark
│
├── raspberry/
│   ├── Controle da protoboard
│   ├── Captura da câmera
│   ├── Upload das imagens
│   └── Comunicação com o servidor
│
├── alprService/
│   ├── Detecção de veículos (YOLO)
│   ├── Reconhecimento de placas
│   └── Serviços em Python
│
└── web/
    ├── Interface administrativa
    ├── PHP
    ├── HTML
    ├── CSS
    ├── JavaScript
    └── Banco de dados
```

---

# ⚙ Tecnologias utilizadas

## Linguagens

- PHP
- Python
- JavaScript
- HTML5
- CSS3

## Inteligência Artificial

- OpenCV
- YOLO
- OCR
- ALPR (Automatic License Plate Recognition)

## Hardware

- Raspberry Pi
- Câmera USB
- Protoboard
- Sensores eletrônicos

## Banco de Dados

- MySQL

---

# 🚀 Funcionamento

O processo de autenticação ocorre da seguinte maneira:

1. Um veículo aproxima-se do portão.
2. A câmera captura uma imagem.
3. O módulo de visão computacional detecta o veículo.
4. O sistema identifica e extrai a placa.
5. A placa é consultada no banco de dados.
6. Caso o veículo esteja autorizado:
   - o acesso é registrado;
   - o portão é aberto automaticamente.
7. Caso contrário:
   - o acesso é negado;
   - o evento é registrado no sistema.

---

# 📂 Estrutura do repositório

```text
IFPark/
│
├── alprService/
│   ├── Detecção de placas
│   ├── Detecção de veículos
│   └── Scripts Python
│
├── raspberry/
│   ├── Controle da câmera
│   ├── Comunicação
│   └── Controle do hardware
│
├── web/
│   ├── Controladores
│   ├── CSS
│   ├── JavaScript
│   ├── Imagens
│   ├── Cadastro
│   ├── Consultas
│   └── Área administrativa
│
└── README.md
```

---

# 🖥 Interface Web

A plataforma administrativa permite:

- Cadastro de usuários
- Cadastro de administradores
- Cadastro de veículos
- Cadastro de empresas
- Consulta de placas
- Histórico de acessos
- Gerenciamento completo do estacionamento

---

# 📷 Visão Computacional

O módulo de Inteligência Artificial é responsável por:

- Detectar veículos nas imagens;
- Localizar a placa do automóvel;
- Realizar o reconhecimento óptico dos caracteres (OCR);
- Validar a autorização junto ao banco de dados;
- Enviar o resultado ao sistema de controle de acesso.

---

# 🍓 Raspberry Pi

O Raspberry Pi atua como controlador do sistema físico, sendo responsável por:

- Capturar imagens da câmera;
- Controlar os dispositivos eletrônicos;
- Comunicar-se com o servidor;
- Enviar imagens para processamento;
- Acionar automaticamente o mecanismo de abertura do portão.

---

# 🧠 Conceitos aplicados

Durante o desenvolvimento foram utilizados conhecimentos de:

- Visão Computacional
- Inteligência Artificial
- Processamento Digital de Imagens
- Sistemas Embarcados
- Desenvolvimento Web
- Banco de Dados
- Redes de Computadores
- Engenharia de Software
- Arquitetura Cliente-Servidor

---

# 📚 Objetivo acadêmico

O projeto foi desenvolvido como Trabalho de Conclusão do Curso Técnico Integrado em Informática, integrando conhecimentos de:

- Desenvolvimento Web
- Banco de Dados
- Inteligência Artificial
- Visão Computacional
- Raspberry Pi
- Sistemas Embarcados
- Redes de Computadores
- Engenharia de Software

Seu principal objetivo foi aplicar conceitos multidisciplinares para solucionar um problema real da instituição por meio da automação do controle de acesso ao estacionamento.

---

# 📄 Licença

Projeto desenvolvido para fins acadêmicos.

Caso deseje reutilizar parte do código, entre em contato com os autores.
