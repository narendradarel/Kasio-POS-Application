pipeline {
    agent any

    environment {
        // Sesuaikan dengan nama container di docker-compose.yml
        CONTAINER_NAME = "kasio-app" 
    }

    stages {
        stage('Checkout Code') {
            steps {
                // Menarik kodingan dari Git
                checkout scm
            }
        }

        stage('Setup Environment') {
            steps {
                script {
                    // Buat file .env dari example jika belum ada
                    // Di Production asli, biasanya pakai Credentials Jenkins
                    sh 'cp .env.example .env || true'
                    
                    // Pastikan DB host mengarah ke nama service docker-compose ('db')
                    // Kita replace DB_HOST=127.0.0.1 jadi DB_HOST=db
                    sh "sed -i 's/DB_HOST=127.0.0.1/DB_HOST=db/g' .env"
                    sh "sed -i 's/DB_PASSWORD=/DB_PASSWORD=password123/g' .env"
                }
            }
        }

        stage('Build & Run Docker') {
            steps {
                script {
                    // Matikan container lama & nyalakan yang baru (rebuild)
                    sh 'docker compose down || true'
                    sh 'docker compose up -d --build'
                }
            }
        }

        stage('Waiting for Database') {
            steps {
                script {
                    echo '⏳ Menunggu Database MySQL siap...'
                    // Jeda 15 detik agar MySQL sempat booting sebelum dimigrate
                    sh 'sleep 15' 
                }
            }
        }

        stage('Laravel Post-Deployment') {
            steps {
                script {
                    // Install dependency PHP
                    sh 'docker compose exec -T app composer install --no-interaction --prefer-dist --optimize-autoloader'
                    
                    // Generate Key (HANYA jika di .env APP_KEY kosong)
                    // Tapi agar aman di tugas kuliah, kita force generate sekali di awal, 
                    // atau biarkan pakai key dari .env.example kalau ada.
                    sh 'docker compose exec -T app php artisan key:generate --force'
                    
                    // Jalankan migrasi database
                    sh 'docker compose exec -T app php artisan migrate --force'
                    
                    // Cache config & route untuk performa
                    sh 'docker compose exec -T app php artisan config:cache'
                    sh 'docker compose exec -T app php artisan route:cache'
                    sh 'docker compose exec -T app php artisan view:cache'
                    
                    // Beri hak akses storage lagi (jaga-jaga)
                    sh 'docker compose exec -T app chown -R www-data:www-data /var/www/html/storage'
                }
            }
        }
    }

    post {
        success {
            echo '✅ Deployment Berhasil! Akses di http://IP-VM-AZURE:8081'
        }
        failure {
            echo '❌ Deployment Gagal. Cek Console Output.'
            // Opsional: Matikan container jika gagal total
            // sh 'docker compose down' 
        }
    }
}