# config valid only for current version of Capistrano
lock "3.7.2"

############################################
# Setup project
############################################
set :application, "zerbikat"
set :repo_url, "https://github.com/PasaiakoUdala/zerbikat.git"
set :tmp_dir, "/tmp/zerbikat"
set :scm, :git

############################################
# Setup Capistrano
############################################
set :log_level, :info
set :use_sudo, false
set :ssh_options, {:forward_agent => true}
set :keep_releases, 3

set :log_path, "var/logs"
set :cache_path, "var/cache"
set :session_path, "var/sessions"
set :permission_method, :acl

############################################
# Linked files and directories (symlinks)
############################################
set :linked_files, ["app/config/parameters.yml"]
set :linked_dirs, [fetch(:log_path),fetch(:cache_path),fetch(:session_path), fetch(:web_path) + "/doc"]
set :file_permissions_paths, [fetch(:log_path), fetch(:cache_path), fetch(:session_path)]
set :composer_install_flags, '--no-interaction --optimize-autoloader'


namespace :deploy do

  after :restart, :clear_cache do
    on roles(:web), in: :groups, limit: 3, wait: 10 do
      # Here we can do anything such as:
      # within release_path do
      #   execute :rake, 'cache:clear'
      # end
    end
  end

end

# Run migrations after code is deployed (but not switched yet)
namespace :deploy do
  task :migrate do
    on roles(:db) do
      symfony_console('doctrine:migrations:migrate', '--no-interaction')
    end
  end
end