# PHP CRUD Application – DevOps CI/CD Deployment

This project demonstrates a complete **DevOps CI/CD pipeline** for deploying a Dockerized PHP CRUD application using **GitHub, Jenkins, Docker, AWS EC2, and AWS RDS MySQL**.

The pipeline automatically builds, pushes, and deploys the application whenever code changes are pushed to the repository.

---

# Project Architecture

The application is deployed using a CI/CD pipeline with the following components:

- GitHub – Source code repository
- Jenkins – CI/CD automation server
- Docker – Containerization platform
- Docker Hub – Container registry
- AWS EC2 – Application and Jenkins servers
- AWS RDS MySQL – Managed database service

### Architecture Workflow

1. Developer pushes code to GitHub.
2. Jenkins detects changes via webhook.
3. Jenkins pulls the repository and builds a Docker image.
4. The Docker image is pushed to Docker Hub.
5. Jenkins connects to the Application EC2 server via SSH.
6. The application server pulls the latest Docker image.
7. Docker container starts the PHP application.
8. The application connects to the RDS MySQL database.

---

# Infrastructure Setup

## AWS EC2 Instances

### Jenkins Server
Instance Type: `t2.small`

Ports Allowed:
- 22 (SSH)
- 8080 (Jenkins)
- 443 (HTTPS)

Installed Software:
- Docker
- Jenkins
- OpenJDK 21

### Application Server
Instance Type: `t2.micro`

Ports Allowed:
- 22 (SSH)
- 80 (HTTP)
- 443 (HTTPS)

Installed Software:
- Docker
- Apache Web Server

---

# Database Setup

Database hosted on **AWS RDS MySQL**

Configuration:

| Parameter | Value |
|----------|------|
DB Identifier | crud-app-db
Engine | MySQL Community
Instance Type | db.t4g.micro
Connections | Only allowed from Application EC2
Port | 3306

Database created:
