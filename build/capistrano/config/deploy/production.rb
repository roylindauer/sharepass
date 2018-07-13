set :stage, :production

set :deploy_to, '/var/www/vhosts/sharepass.roylindauer.com'

set :branch, 'master'
server 'web02.roylindauer.com', user: 'webuser', roles: %w{app}