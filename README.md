```
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

```

crudapp

```

Table Schema:

```

desc users;

+------------+--------------+------+-----+-------------------+-------------------+
| Field      | Type         | Null | Key | Default           | Extra             |
+------------+--------------+------+-----+-------------------+-------------------+
| id         | int          | NO   | PRI | NULL              | auto_increment    |
| Name       | varchar(100) | NO   |     | NULL              |                   |
| Gender     | varchar(10)  | YES  |     | NULL              |                   |
| Email      | varchar(100) | NO   |     | NULL              |                   |
| Mobile     | varchar(20)  | YES  |     | NULL              |                   |
| Address    | text         | YES  |     | NULL              |                   |
| created_at | timestamp    | YES  |     | CURRENT_TIMESTAMP | DEFAULT_GENERATED |
+------------+--------------+------+-----+-------------------+-------------------+

```

---

# Docker Setup

The application is containerized using Docker.

### Dockerfile

```

FROM php:8.2-apache

RUN docker-php-ext-install mysqli

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]

```

### Build Image Locally

```

docker build -t crud-php-app .

```

### Run Container

```

docker run -d -p 80:80 crud-php-app

```

---

# Environment Variables

Database credentials are passed using environment variables instead of hardcoding them.

| Variable | Description |
|--------|-------------|
DB_HOST | RDS database endpoint
DB_USER | Database username
DB_PASS | Database password
DB_NAME | Database name

---

# Jenkins Pipeline

Jenkins automates the entire CI/CD process.

Pipeline Stages:

1. Checkout source code from GitHub
2. Build Docker image
3. Push Docker image to Docker Hub
4. Connect to application server via SSH
5. Pull latest image
6. Stop old container
7. Deploy new container

---

# Jenkins Credentials

The following credentials were configured in Jenkins:

| Credential ID | Purpose |
|---------------|--------|
dockerhub-credentials | Docker Hub authentication
app-server-ssh | SSH access to application EC2
docker-image | Docker image name
app-server-ip | Application server IP
DB_HOST | Database endpoint
DB_USER | Database username
DB_PASS | Database password
DB_NAME | Database name

---

# CI/CD Workflow

```

Developer
│
▼
GitHub Repository
│
▼
Jenkins Pipeline
│
├── Build Docker Image
├── Push to Docker Hub
│
▼
Application EC2
│
▼
Docker Container
│
▼
RDS MySQL Database

```

---

# Webhook Setup

GitHub webhook triggers Jenkins pipeline automatically.

Webhook URL:

```

http://<jenkins-public-ip>:8080/github-webhook/

```

Event Trigger:
```

Push Events

```

---

# Application Access

After deployment, the application can be accessed using:

```

http://<application-ec2-public-ip>

```

---

# Features

- Dockerized PHP Application
- Automated CI/CD pipeline
- Secure database connectivity
- Environment variable based configuration
- GitHub webhook integration

---

# Future Improvements

- Add HTTPS with SSL
- Deploy using Kubernetes
- Use Terraform for infrastructure automation
- Add monitoring with Prometheus and Grafana

---

# Author

Satvik Dubey  
DevOps Engineer
```

---

These **increase recruiter attention a lot on GitHub.**
