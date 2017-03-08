
######################################################################
# Setup Server
######################################################################
server "172.28.64.200", user: "root", roles: %w{web}
set :deploy_to, "/var/www/zerbikat"
set :env, "dev"

set :use_sudo, true



set :controllers_to_clear, [""]
set :linked_dirs, ["var/logs", "var/cache", "var/sessions"]

set :writable_dirs, ["var/cache", "var/logs", "var/sessions"]

set :file_permissions_paths, ["var"]
set :permission_method, false

######################################################################
# Capistrano Symfony - https://github.com/capistrano/symfony/#settings
######################################################################
set :file_permissions_users, ['www-data']
set :webserver_user, "www-data"

######################################################################
# Setup Git
######################################################################
set :branch, "master"