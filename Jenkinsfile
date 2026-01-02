pipeline {
    agent any
    
    stages {
        stage('Build') {
            steps {
                sh '''
                    git checkout main
                    php8.2 /usr/local/bin/composer install --no-dev --optimize-autoloader
                    npm ci && npm run build || true
                    php artisan config:cache || true
                '''
            }
        }
        
        stage('Deploy Azure') {
            steps {
                sh '''
                    zip -r kasio.zip . -x "*.git*" "node_modules/*" "tests/*"
                    az webapp deploy \
                      --resource-group "kasio-rg" \
                      --name "kasio" \
                      --src-path kasio.zip \
                      --type zip \
                      --async false
                '''
            }
        }
    }
    
    post {
        success {
            echo '✅ Kasio deployed to Azure!'
        }
        failure {
            echo '❌ Deploy failed'
        }
    }
}
