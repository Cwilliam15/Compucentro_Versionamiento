pipeline {
    agent any

    environment {
        // ⚙️ Variables globales
        DOCKER_COMPOSE_FILE = "docker-compose.yml"
        PROJECT_DIR = "www/CompuCentro_Coban"
        SONARQUBE_SERVER = "SonarQubeServer"       // Nombre registrado en Jenkins (Manage Jenkins > Configure System)
        SONARQUBE_PROJECT_KEY = "compucentro"      // Debe coincidir con el ID del proyecto en SonarQube
        SONARQUBE_LOGIN = "tu_token_de_sonarqube"  // Token generado desde SonarQube
    }

    stages {

        stage('Clonar Repositorio') {
            steps {
                echo "📦 Clonando el repositorio de GitHub..."
                git branch: 'main',
                    credentialsId: 'github-token', // ID del token agregado en Jenkins Credentials
                    url: 'https://github.com/SelenaAM505/Compucentro_Versionamiento.git'
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
                    echo "⏳ Esperando resultados de calidad de SonarQube..."
                    timeout(time: 6
                    , unit: 'MINUTES') {
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
                sh '''
                    if curl -f http://localhost:8081 > /dev/null 2>&1; then
                        echo "🌐 Sitio operativo correctamente."
                    else
                        echo "❌ Error al verificar el despliegue"
                        exit 1
                    fi
                '''
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
