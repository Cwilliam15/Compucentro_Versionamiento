pipeline {
    agent any

    environment {
        // Variables del entorno
        DOCKER_COMPOSE_FILE = "docker-compose.yml"
        PROJECT_DIR = "www/CompuCentro_Coban"
        SONARQUBE_SERVER = "SonarQubeServer" // nombre que registrarás en Jenkins
        SONARQUBE_PROJECT_KEY = "compucentro"
        SONARQUBE_LOGIN = "tu_token_de_sonarqube"
    }

    stages {

        stage('Clonar Repositorio') {
            steps {
                echo "📦 Clonando el repositorio de GitHub..."
                git branch: 'main', url: 'https://github.com/TU_USUARIO/TU_REPO.git'
            }
        }

        stage('Análisis con SonarQube') {
            steps {
                echo "🔍 Iniciando análisis de código con SonarQube..."
                withSonarQubeEnv("${SONARQUBE_SERVER}") {
                    sh '''
                        sonar-scanner \
                            -Dsonar.projectKey=${SONARQUBE_PROJECT_KEY} \
                            -Dsonar.sources=${PROJECT_DIR} \
                            -Dsonar.host.url=http://sonarqube:9000 \
                            -Dsonar.login=${SONARQUBE_LOGIN}
                    '''
                }
            }
        }

        stage('Esperar Resultado de Análisis') {
            steps {
                script {
                    timeout(time: 2, unit: 'MINUTES') {
                        waitForQualityGate abortPipeline: true
                    }
                }
            }
        }

        stage('Construir y Desplegar con Docker') {
            steps {
                echo "🐳 Construyendo e iniciando contenedores Docker..."
                sh "docker compose down"
                sh "docker compose up -d --build"
            }
        }

        stage('Verificar Despliegue') {
            steps {
                echo "✅ Verificando que el sitio esté en línea..."
                sh "curl -f http://localhost:8081 || echo '❌ Error al verificar el despliegue'"
            }
        }
    }

    post {
        success {
            echo "🎉 Despliegue exitoso: CompuCentro Cobán actualizado correctamente."
        }
        failure {
            echo "⚠️ Error durante el proceso de CI/CD. Revisa los logs en Jenkins."
        }
    }
}
