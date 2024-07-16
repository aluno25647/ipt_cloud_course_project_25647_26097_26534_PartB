# Projeto B

Mestrado em Engenharia Informática – IoT

Computação em Nuvem e Virtualização - 2023/2024

Luís Costa – n.º 25647 /
Paulo Peixoto – n.º 26097 /
Ricardo Elisiário – n.º 26534

## Projeto A

https://github.com/aluno25647/ipt_cloud_course_project_25647_26097_26534_PartA

## Descrição

Este projeto é uma aplicação web escalável e resiliente, implementada utilizando várias tecnologias para garantir alta disponibilidade, desempenho e monitorização eficaz. 
A arquitetura inclui servidores web e websockets redundantes e monitorização em tempo real.

## Arquitetura

### Componentes Principais do Projeto

- **Web Server (Apache + PHP)**: Serviço web base do projeto.
- **WebSockets**: Serviço de WebSockets para comunicação através de um chat em tempo real.
- **Database (Postgres)**: Banco de dados para armazenamento de informações persistentes.
- **GlusterFS**: Sistema de arquivos distribuído para armazenamento compartilhado, proporcionando redundância e alta disponibilidade dos dados.
- **Docker**: Motor Docker para execução de containers, simplificando a implementação e a gestão dos serviços do projeto.
- **Redis**: Cache de dados, acelerando o acesso aos dados e melhorando a performance da aplicação.
- **Prometheus**: Sistema de monitorização e alerta, recolhendo métricas dos serviços para garantir uptime e performance da infraestrutura.
- **Grafana**: Plataforma de análise e visualização de métricas, permitindo a criação de dashboards personalizados para monitorização detalhada.
- **Portainer**: Interface de gestão de contêineres Docker, facilitando a administração e monitorização da infraestrutura de containers.
- **Traefik**: Proxy reverso e load balancer dinâmico, que permite a manutenção em tempo real das rotas dos diferentes serviços presentes no swarm, sem necessidade de intervenção manual, evitando a sobrecarga dos serviços.


## Instalação e Configuração

### Pré-requisitos

- Vagrant
- VirtualBox

### Passos para Configuração

1. Clone o repositório:
   ```bash
   git clone https://github.com/aluno25647/ipt_cloud_course_project_25647_26097_26534_PartB.git
   cd ipt_cloud_course_project_25647_26097_26534_PartB

2. Iniciar as VMs com Vagrant:
   ```bash
   vagrant up

3.  Aceda ao Node1 (manager)
  ```bash
  vagrant ssh node1
  ```

4.  Aceder à pasta shared
  ```bash
  cd /home/vagrant/shared
  ```

5. Compose up
  ```bash
  docker stack deploy -c compose.yml stackb
  ```

6. Aceda à aplicação web através do IP configurado (http://192.168.46.11).
  
7. Para aceder a outras funcionalidades:

   ```bash
    [Portainer]
    http://192.168.46.11:9000
