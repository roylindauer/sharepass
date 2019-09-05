set :stage, :production
set :deploy_to, '/var/www/vhosts/sharepass.roylindauer.com'
set :branch, 'master'

server '167.71.122.106', user: 'webuser', roles: %w{app}