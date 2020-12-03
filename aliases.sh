# Run artisan commands
alias artisan='docker-compose exec --user "$(id -u):$(id -g)" php php artisan'

alias fresh='docker-compose exec --user "$(id -u):$(id -g)" php php artisan migrate:fresh --seed'
alias autoload='docker-compose exec php composer dump-autoload'
