####

    cd /var/www/home-www/yusam/github/yusam-hub/project-0001/client-demo-sdk
    composer update
    sh phpunit

#### dockers

    docker exec -it yusam-php81 bash
    docker exec -it yusam-php81 sh -c "htop"

    docker exec -it yusam-php81 sh -c "cd /var/www/data/yusam/github/yusam-hub/project-0001/client-demo-sdk && composer update"
    docker exec -it yusam-php81 sh -c "cd /var/www/data/yusam/github/yusam-hub/project-0001/client-demo-sdk && sh phpunit"

#### curl