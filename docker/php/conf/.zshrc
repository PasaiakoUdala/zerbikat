
export ZSH="/home/www-data/.oh-my-zsh"

ZSH_THEME="kphoen"
DISABLE_LS_COLORS="false"
DISABLE_AUTO_UPDATE=false


plugins=(colorize history symfony)

source $ZSH/oh-my-zsh.sh


# ALIAS
alias cdw="cd /usr/src/app"
alias tail="grc tail"
alias cpt="vendor/bin/codecept"
alias kill="kill -9"
alias ping="ping -O "
alias portuak="netstat -la"
alias eguraldia="curl http://es.wttr.in/getaria"
alias y="clear && yarn run encore dev --watch"
alias yy="clear && yarn encore dev-server --hot"
alias vlog="sudo watch tail -n 50"
alias c='clear'
alias l="ls --color=auto -1 -lah -F -X --time-style=long-iso"
alias ls="ls --color=auto -1 -lah -F -X --time-style=long-iso"
alias sf='php bin/console'
alias dev='php bin/console --env=dev'
alias prod='php bin/console --env=prod'
alias assets="php bin/console assets:install web --symlink"
alias cc="php bin/console cache:clear"
alias ccc='rm -rf var/cache/*'
alias per1='sudo setfacl -R -m u:"www-data":rwX -m u:`whoami`:rwX var/cache var/log var/sessions'
alias per2='sudo setfacl -dR -m u:"www-data":rwX -m u:`whoami`:rwX var/cache var/log var/sessions'
alias ttop='top -ocpu -R -F -s 2 -n30'
alias glggg='git log --pretty=oneline --abbrev-commit'
alias clidebug='php -dxdebug.remote_enable=1 -dxdebug.remote_mode=req -dxdebug.remote_port=9000 -dxdebug.remote_host=172.28.64.147 -dxdebug.remote_autostart=On bin/console api:izfezt 064 1'
alias lsdebug='ln -s /etc/php5/mods-available/xdebug.ini /etc/php5/cli/conf.d/30-xdebug.ini'
