stage("Run") {
  node {
    def scmVars = checkout scm
    def branchName = scmVars.GIT_BRANCH

    stage('Build') {
      testImage = docker.build("sharepass", "--build-arg PRODUCTION=true .")
      testImage.inside {
        sh 'php --version'
      }
    }

    stage('Test') {
      echo 'Running unit tests yo'
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