ssh ubuntu@89.208.84.40 "sudo rm -r ~/the-best-vk-bot/"
ssh ubuntu@89.208.84.40 "mkdir -p ~/the-best-vk-bot/"

scp -pr composer.json ubuntu@89.208.84.40:~/the-best-vk-bot/composer.json
scp -pr index.php ubuntu@89.208.84.40:~/the-best-vk-bot/index.php
scp -pr data ubuntu@89.208.84.40:~/the-best-vk-bot/data
scp -pr src ubuntu@89.208.84.40:~/the-best-vk-bot/src

ssh ubuntu@89.208.84.40 "cd ~/the-best-vk-bot/ && composer install && composer dump-autoload"
