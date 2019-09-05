stage("Run") {
  node {
    def scmVars = checkout scm
    def branchName = scmVars.GIT_BRANCH

    stage('Build') {
      buildImage = docker.build("sharepass", "--build-arg PRODUCTION=true --build-arg IS_DOCKER=true .")
      buildImage.inside {
        sh 'php --version'
      }
    }

    stage('Test') {
      echo 'Running unit tests yo'
      buildImage.inside {
        sh './tests.sh'
      }
    }
    
    stage('Push') {
        echo 'Doing that docker thing'
        sh "docker tag sharepass docker.roynet.network:5000/sharepass:$branchName"
        sh "docker push docker.roynet.network:5000/sharepass:$branchName"
    }

    stage('Deploy') {
      echo "Deploying to $branchName"
      sh "bundle install && cap $branchName deploy"
    }
  }
}