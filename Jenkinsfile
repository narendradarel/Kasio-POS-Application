pipeline {
    agent any
    
    stages {
        stage('Build') {
            steps {
                sh '''
                    git checkout main
                    php8.2 /usr/local/bin/composer install --no-dev --optimize-autoloader
                '''
            }
        }
        
        stage('Deploy Azure') {
            steps {
                sh '''
                    az webapp deploy \
                      --resource-group "kasio-rg" \
                      --name "kasio" \
                      --src-path . \
                      --type zip \
                      --async false
                '''
            }
        }
    }
}
