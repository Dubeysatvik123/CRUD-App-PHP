
pipeline {
    agent any
 
    environment {
        // Docker Hub image name 
        DOCKER_IMAGE = 'satvikdubey268/crud-php-app'
        DOCKER_TAG = "${BUILD_NUMBER}"
        // App Server IP 
        APP_SERVER_IP = '3.237.37.60'
    }
 
    stages {
 
        stage('Checkout') {
            steps {
                echo 'Stage 1: Pulling code from GitHub...'
                checkout scm
                sh 'ls -la'
            }
        }
 
        stage('Build Docker Image') {
            steps {
                echo 'Stage 2: Building Docker image...'
                sh 'docker build -t ${DOCKER_IMAGE}:${DOCKER_TAG} .'
                sh 'docker tag ${DOCKER_IMAGE}:${DOCKER_TAG} ${DOCKER_IMAGE}:latest'
                sh 'docker images | grep crud-php-app'
            }
        }
 
        stage('Push to Docker Hub') {
            steps {
                echo 'Stage 3: Pushing image to Docker Hub...'
                withCredentials([usernamePassword(
                    credentialsId: 'dockerhub-credentials',
                    usernameVariable: 'DOCKER_USER',
                    passwordVariable: 'DOCKER_PASS'
                )]) {
                    sh 'echo $DOCKER_PASS | docker login -u $DOCKER_USER --password-stdin'
                    sh 'docker push ${DOCKER_IMAGE}:${DOCKER_TAG}'
                    sh 'docker push ${DOCKER_IMAGE}:latest'
                    sh 'docker logout'
                }
            }
        }
 
        stage('Deploy to App Server') {
            steps {
                echo 'Stage 4: Deploying to App Server...'
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
                        ssh -i $SSH_KEY -o StrictHostKeyChecking=no ubuntu@${APP_SERVER_IP} '
                            # Pull latest image
                            docker pull ''' + env.DOCKER_IMAGE + ''':latest
 
                            # Stop and remove old container (ignore errors if not running)
                            docker stop crud-app || true
                            docker rm crud-app || true
 
                            # Run new container with RDS env vars
                            docker run -d \\
                                --name crud-app \\
                                --restart unless-stopped \\
                                -p 80:80 \\
                                -e DB_HOST=''' + env.DB_HOST + ''' \\
                                -e DB_USER=''' + env.DB_USER + ''' \\
                                -e DB_PASS=''' + env.DB_PASS + ''' \\
                                -e DB_NAME=''' + env.DB_NAME + ''' \\
                                ''' + env.DOCKER_IMAGE + ''':latest
 
                            # Verify container is running
                            docker ps | grep crud-app
                        '
                    '''
                }
            }
        }
 
        stage('Verify Deployment') {
            steps {
                echo 'Stage 5: Verifying deployment...'
                sh "curl -s -o /dev/null -w '%{http_code}' http://${APP_SERVER_IP} | grep -E '200|301|302'"
                echo 'Deployment successful!'
            }
        }
    }
 
    post {
        success {
            echo 'Pipeline completed successfully! App deployed.'
        }
        failure {
            echo 'Pipeline FAILED. Check logs above.'
        }
        always {
            // Clean up local Docker images to save space
            sh 'docker image prune -f || true'
        }
    }
}
