pipeline {
    agent any

    environment {
        DOCKER_IMAGE = credentials('docker-image')
        APP_SERVER_IP = credentials('app-server-ip')
        DOCKER_TAG = "${BUILD_NUMBER}"
    }

    stages {

        stage('Checkout') {
            steps {
                echo 'Pulling code from GitHub'
                checkout scm
            }
        }

        stage('Build Docker Image') {
            steps {
                echo 'Building Docker image'
                sh 'docker build -t ${DOCKER_IMAGE}:${DOCKER_TAG} .'
                sh 'docker tag ${DOCKER_IMAGE}:${DOCKER_TAG} ${DOCKER_IMAGE}:latest'
            }
        }

        stage('Push to Docker Hub') {
            steps {
                echo 'Pushing image to DockerHub'
                withCredentials([usernamePassword(
                    credentialsId: 'dockerhub-credentials',
                    usernameVariable: 'DOCKER_USER',
                    passwordVariable: 'DOCKER_PASS'
                )]) {
                    sh '''
                    echo $DOCKER_PASS | docker login -u $DOCKER_USER --password-stdin
                    docker push ${DOCKER_IMAGE}:${DOCKER_TAG}
                    docker push ${DOCKER_IMAGE}:latest
                    docker logout
                    '''
                }
            }
        }

        stage('Deploy to EC2') {
            steps {
                withCredentials([
                    sshUserPrivateKey(
                        credentialsId: 'app-server-ssh',
                        keyFileVariable: 'SSH_KEY'
                    ),
                    string(credentialsId: 'DB_HOST', variable: 'DB_HOST'),
                    string(credentialsId: 'DB_USER', variable: 'DB_USER'),
                    string(credentialsId: 'DB_PASS', variable: 'DB_PASS'),
                    string(credentialsId: 'DB_NAME', variable: 'DB_NAME')
                ]) {
                    sh '''
                    ssh -i $SSH_KEY -o StrictHostKeyChecking=no ubuntu@${APP_SERVER_IP} "

                        docker pull ${DOCKER_IMAGE}:latest

                        docker stop crud-app || true
                        docker rm crud-app || true

                        docker run -d \
                        --name crud-app \
                        -p 80:80 \
                        -e DB_HOST=$DB_HOST \
                        -e DB_USER=$DB_USER \
                        -e DB_PASS=$DB_PASS \
                        -e DB_NAME=$DB_NAME \
                        ${DOCKER_IMAGE}:latest

                        docker ps
                    "
                    '''
                }
            }
        }
    }

    post {
        success {
            echo 'Deployment Successful'
        }
        failure {
            echo 'Pipeline Failed'
        }
    }
}
