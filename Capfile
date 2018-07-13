set :deploy_config_path, 'build/capistrano/config/deploy.rb'
set :stage_config_path, 'build/capistrano/config/deploy'

# Load DSL and Setup Up Stages
require 'capistrano/setup'

# Includes default deployment tasks
require 'capistrano/deploy'

require "capistrano/scm/git"
install_plugin Capistrano::SCM::Git

# New Relic
#require 'new_relic/recipes' # gem install newrelic_rpm

# Includes tasks from other gems included in your Gemfile
#
# For documentation on these, see for example:
#
#   https://github.com/capistrano/rvm
#   https://github.com/capistrano/rbenv
#   https://github.com/capistrano/chruby
#   https://github.com/capistrano/bundler
#   https://github.com/capistrano/rails
#
# require 'capistrano/rvm'
# require 'capistrano/rbenv'
# require 'capistrano/chruby'
# require 'capistrano/bundler'
# require 'capistrano/rails/assets'
# require 'capistrano/rails/migrations'
require 'capistrano/composer'

# Loads custom tasks from `lib/capistrano/tasks' if you have any defined.
Dir.glob('build/capistrano/tasks/*.rake').each { |r| import r }
