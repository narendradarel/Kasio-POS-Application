pipeline {
    agent any

    environment {
        // Sesuaikan dengan nama container di docker-compose.yml
        CONTAINER_NAME = "kasio-app" 
    }

    stages {
        stage('Checkout Code') {
            steps {
                checkout scm
            }
        }

        stage('Setup Environment') {
            steps {
                script {
                    bat 'copy .env.example .env || exit 0'
                
                    powershell '''
                        (Get-Content .env) -replace "DB_HOST=127.0.0.1", "DB_HOST=db" | Set-Content .env
                        (Get-Content .env) -replace "DB_PASSWORD=", "DB_PASSWORD=password123" | Set-Content .env
                    '''
                }
            }
        }

        stage('Build & Run Docker') {
            steps {
                script {
                    // WINDOWS: Gunakan 'bat'
                    bat 'docker compose down || exit 0'
                    bat 'docker compose up -d --build'
                }
            }
        }

        stage('Waiting for Database') {
            steps {
                script {
                    echo '⏳ Menunggu Database MySQL booting...'
                    sleep 15  
                }
            }
        }

        stage('Laravel Post-Deployment') {
            steps {
                script {
                    // WINDOWS: Jalankan perintah artisan di dalam container
                    bat 'docker compose exec -T app composer install --no-interaction --prefer-dist --optimize-autoloader'
                    
                    // Generate key force
                    bat 'docker compose exec -T app php artisan key:generate --force'
                    
                    // Migrate Database
                    bat 'docker compose exec -T app php artisan migrate --force'
                    
                    // Cache config
                    bat 'docker compose exec -T app php artisan config:cache'
                    bat 'docker compose exec -T app php artisan route:cache'
                    
                    // Note: Di Windows Docker biasanya permission sudah otomatis rw, jadi tidak perlu chown
                }
            }
        }
    }

    post {
        success {
            echo '✅ Deployment Berhasil di Windows!'
        }
        failure {
            echo '❌ Deployment Gagal.'
        }
    }
}