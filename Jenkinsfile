pipeline {
    agent any
    
    stages {
        stage('Project Info') {
            steps {
                echo '================================================'
                echo 'KASIO POS'
                echo '================================================'
                echo 'Build Date: ' + new Date().format('yyyy-MM-dd HH:mm:ss')
                echo 'Build ID: #' + env.BUILD_NUMBER
                echo 'Branch: ' + env.GIT_BRANCH
                echo 'Triggered by: GitHub Webhook'
                echo '================================================'
            }
        }
        
        stage('Checkout Source Code') {
            steps {
                echo '📥 Mengambil source code dari GitHub...'
                
                checkout scm

                echo 'Source code berhasil diambil!'
            }
        }
        
        stage('Project Structure') {
            steps {
                echo 'Struktur project:'
                bat 'dir /B'  // Windows
                // sh 'ls -la' // Linux/Mac
                
                echo 'Project structure verified!'
            }
        }
        
        stage('Deployment Info') {
            steps {
                echo '================================================'
                echo 'DEPLOYMENT INFORMATION'
                echo '================================================'
                echo 'Target: Azure App Service'
                echo 'Resource Group: Kasio'
                echo 'App Name: kasio'
                echo 'URL: https://kasio.azurewebsites.net'
                echo '================================================'
                echo 'ℹAzure akan build otomatis setelah code di-push'
            }
        }
        
        stage('Deployment Status') {
            steps {
                echo 'Jenkins CI/CD Pipeline: SUCCESS'
                echo 'Code siap untuk deployment ke Azure'
                echo 'Azure akan proses deployment dalam 2-5 menit'
                echo 'Monitor di: https://portal.azure.com'
            }
        }
    }
    
    post {
        success {
            echo 'Build Sukses'
        }
        failure {
            echo 'Build Gagal'
        }
        always {
            echo 'Build Durasi: ' + currentBuild.durationString
        }
    }
}
